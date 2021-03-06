{*
	Slideview for Gregarius
*}

<nav>
	<div id='nav'>
		<div id='item_counter'>
			<span id='item_counter_prev'>0</span>
			|
			<span id='item_cur_id'></span>
			|
			<span id='item_counter_next'>0</span>
		</div>
		<h1>
			<a href='../'title='Return to original Gregarius'>Gregarius</a>
			SlideViw Mode</h1>
		<div id='hotkey'>
			Key:
				<a href='javascript: Items.Prev();'>a/k/Left=Prev</a>,
				<a href='javascript: Items.Next();'>f/j/Right=Next</a>,
				<a href='javascript: Items.ReadAndNext();'>
					d/Del=Mark Readed and Next</a>,
				<a href='javascript: Items.ToggleReaded();'>u=Readed(T)</a>
				<a href='javascript: Items.ToggleStared();'>s=Stared(T)</a>,
		</div>
	</div>
</nav>

<div id='hotkey_shadow'>
	<br /> {* Simulate h1 *}
			Key:
				a/k/Left=Prev,
				f/j/Right=Next,
				d/Del=Mark Readed and Next,
				u=Readed(T)
				s=Stared(T),
</div>


<div id='item_container'>
</div>

<script type='text/javascript'>
//<![CDATA[
<!-- -->
/* Item operation object */
var Items = {
	/* Config vars */
	i_pagesize : {$gr.pagesize},
	i_slide_speed : 200,	/* Duration in animate() */
	/* Loaded item info */
	i_min : 0,	/* Usually smallest id, appear later */
	i_max : 0,	/* Usually largest id, appear earlier */
	i_cur : 0,
	i_cnt : 0,
	i_cnt_prev : 0,
	i_cnt_next : 0,
	/* Prevent duplicate load to same content */
	ar_loading : [],
	/* Array of items on page queue */
	ar_items : [],


	/* Hide an article to dir */
	ArticleHide : function (id, dir) {
		if ('undefined' == typeof(dir))
			dir = 'left';

		var obj = $('#article_' + id);
		if ('left' == dir)
			obj.animate({
				left : - obj.outerWidth()
			}, this.i_slide_speed);
		else if ('right' == dir)
			obj.animate({
				left : + obj.outerWidth()
			}, this.i_slide_speed);
		obj.hide();
	},


	/* Show an article from dir */
	ArticleShow : function (id, dir) {
		if ('undefined' == typeof(dir))
			dir = 'right';

		var obj = $('#article_' + id);
		if ('right' == dir)
			obj.css('left', obj.outerWidth())
				.show()
				.animate({
					left : 0
				}, this.i_slide_speed);
		else if ('left' == dir)
			obj.css('left', - obj.outerWidth())
				.show()
				.animate({
					left : 0
				}, this.i_slide_speed);
	},


	/* Check to load new or destory old items */
	CheckLoadDestory : function () {
		/* Load */
		if (this.i_pagesize >= this.i_cnt_next) {
			var s = 'load_from_' + this.i_min;
			/* Check first avoid dup loading */
			if (this.LoadingCheck(s)) {
				this.LoadingAdd(s);
				this.Load(this.i_min, this.i_pagesize);
			}
		}
		/* Remove old item */
		if (this.i_pagesize <= this.i_cnt_prev) {
			/* :THINK: Remove readed item only ? */
			/* If so, i will not allways have value 0. */
			var i = this.i_cnt_prev - this.i_pagesize;
			if (0 == i)
				/* Only need re-set i_max when removing first item */
				this.i_max = this.ar_items[1];
			/* Remove from page */
			$('#article_' + this.ar_items[i]).remove();
			/* Remove from id array */
			this.ar_items.splice(i, 1);
			this.i_cnt --;
			this.i_cnt_prev --;
		}
	},


	/* Add item to page */
	ItemAdd : function (item) {
		$('#item_container').append('\
			<article id="article_' + item.id + '">\
				<h2>\
					<a href="' + item.url + '">'
					+ item.title + '</a>\
				</h2>\
				<div>\
					<a href="{$P2R}../feed.php?channel=' + item.c_id + '">'
						+ item.c_title + '</a>\
					' + ((null == item.pubdate) ? '\
						Fetched: ' + item.added : '\
						Posted: ' + item.pubdate) + '\
				</div>\
				<section>' + item.description + '</section>\
			</article>\
		');

		/* Attach class to new added item */
		if (0 != item.stared)
			$('#article_' + item.id).addClass('stared');
		if (0 == item.readed)
			$('#article_' + item.id).addClass('readed');

		/* Change item index */
		this.ar_items.push(item.id);
		if (0 == this.i_max) {
			this.i_max = item.id;
			this.i_cur = item.id;
		}
		else {
			this.i_cnt_next ++;
		}
		/* Remove i_min from loading and assign new id to it */
		this.LoadingDel('load_from_' + this.i_min);
		this.i_min = item.id;
		this.i_cnt ++;
		this.RefreshCounter();
	},


	/* Load item from db */
	Load : function (i_start, i_num) {
		/* Param default value */
		if ('undefined' == typeof(i_start))
			i_start = this.i_min;
		if ('undefined' == typeof(i_num))
			i_num = this.i_pagesize;
		$.ajax({
			type : 'GET',
			url : '?a=ajax-item-list',
			data : {
				start : i_start,
				pagesize : i_num
			}
		}).done(function (msg) {
			/* JSON.parse() will reverse item order (by key/item.id asc, */
			/* So data is not index by item.id anymore. */
			$.each(JSON.parse(msg), function (i, item) {
				Items.ItemAdd(item);
			});
			/* Show cur item */
			$('#article_' + Items.i_cur).show();
		});
	},


	/* Add entry to loading array */
	LoadingAdd : function (key) {
		this.ar_loading.push(key);
	},


	/* Check if key in loading array, return true if NOT in */
	LoadingCheck : function (key) {
		return (-1 == this.ar_loading.indexOf(key));
	},


	/* Del entry in loading array */
	LoadingDel : function (key) {
		var i = this.ar_loading.indexOf(key);
		if (-1 != i)
			this.ar_loading.splice(i, 1);
	},


	/* Scroll to Next item */
	Next : function () {
		if (this.i_cur == this.i_min)
			return;

		/* Hide cur item, show next */
		var i_next = this.NextItemId();
		this.ArticleHide(this.i_cur, 'left');
		this.ArticleShow(i_next, 'right');

		/* Change counter */
		this.i_cur = i_next;
		this.i_cnt_prev ++;
		this.i_cnt_next --;
		this.RefreshCounter();

		this.CheckLoadDestory();
	},


	/* Get next item id */
	NextItemId : function (i_cur) {
		if ('undefined' == typeof(i_cur))
			i_cur = this.i_cur;
		if (i_cur == this.i_min)
			return this.i_min;
		/* Get next item id by inner array */
		return this.ar_items[this.ar_items.indexOf(i_cur) + 1];
	},


	/* Scroll to Prev item */
	Prev : function () {
		if (this.i_cur == this.i_max)
			return;

		/* Hide cur item, show prev */
		var i_prev = this.PrevItemId();
		this.ArticleHide(this.i_cur, 'right');
		this.ArticleShow(i_prev, 'left');

		/* Change counter */
		this.i_cur = i_prev;
		this.i_cnt_prev --;
		this.i_cnt_next ++;
		this.RefreshCounter();
	},


	/* Get prev item id */
	PrevItemId : function (i_cur) {
		if ('undefined' == typeof(i_cur))
			i_cur = this.i_cur;
		if (i_cur == this.i_max)
			return this.i_max;
		/* Get prev item id by inner array */
		return this.ar_items[this.ar_items.indexOf(i_cur) - 1];
	},


	/* Set cur item Readed and Next */
	ReadAndNext : function () {
		var id = this.i_cur;
		this.Next();
		this.ToggleReaded(id, 0);
	},


	/* Refresh prev/next item counter */
	RefreshCounter : function () {
		$('#item_counter_prev').text(this.i_cnt_prev);
		$('#item_counter_next').text(this.i_cnt_next);
		$('#item_cur_id').text(this.i_cur);
	},


	/* Scroll: PageUp */
	ScrollPageUp : function () {
		$(window).scrollTop($(window).scrollTop()
			- (window.innerHeight || document.documentElement.offsetHeight)
				* 0.875);
	},


	/* Toggle item Readed */
	ToggleReaded : function (id, unread) {
		if ('undefined' == typeof(id))
			id = this.i_cur;
		if ('undefined' == typeof(unread))
			// Toggle
			var data = { id : id };
		else
			// Set
			var data = { id : id, unread : unread };

		/* Avoid duplicate run */
		var s = 'toggle_readed_' + id;
		if (!this.LoadingCheck(s))
			return;
		this.LoadingAdd(s);

		$.ajax({
			type : 'GET',
			url : '?a=ajax-item-toggle-readed',
			data : data
		}).done(function (msg) {
			msg = JSON.parse(msg);
			/* Remove from loading ar */
			Items.LoadingDel('toggle_readed_' + msg.id);

			/* Modify article attribute */
			if (0 == msg.readed)
				$('#article_' + msg.id).addClass('readed');
			else
				$('#article_' + msg.id).removeClass('readed');
		});
	},


	/* Toggle item Stared */
	ToggleStared : function (id) {
		if ('undefined' == typeof(id))
			id = this.i_cur;
		/* Avoid duplicate run */
		var s = 'toggle_stared_' + id;
		if (!this.LoadingCheck(s))
			return;
		this.LoadingAdd(s);

		$.ajax({
			type : 'GET',
			url : '?a=ajax-item-toggle-stared',
			data : {
				id : id
			}
		}).done(function (msg) {
			msg = JSON.parse(msg);
			/* Remove from loading ar */
			Items.LoadingDel('toggle_stared_' + msg.id);

			/* Modify article attribute */
			if (0 != msg.stared)
				$('#article_' + msg.id).addClass('stared');
			else
				$('#article_' + msg.id).removeClass('stared');
		});
	}
}


/* Bind keys */
$(window).keydown(function (evt) {
	// Next: f/j/Right
	if (-1 != [70, 74, 39].indexOf(evt.keyCode)) {
		Items.Next();
	}
	// Prev: a/k/Left
	else if (-1 != [65, 75, 37].indexOf(evt.keyCode)) {
		Items.Prev();
	}
	// Mark Readed and Next: d/Del
	else if (-1 != [68, 46].indexOf(evt.keyCode)) {
		Items.ReadAndNext();
	}
	// Toggle item Stared: s
	else if (-1 != [83].indexOf(evt.keyCode)) {
		Items.ToggleStared();
	}
	// Toggle item Readed: u
	else if (-1 != [85].indexOf(evt.keyCode)) {
		Items.ToggleReaded();
	}
	// Scroll: PageUp
	else if (-1 != [66].indexOf(evt.keyCode)) {
		Items.ScrollPageUp();
	}
});


/* Load items */
Items.Load();
//]]>
</script>
