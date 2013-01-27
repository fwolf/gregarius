{*
	Slideview for Gregarius
*}

<nav>
	<h1>Gregarius SlideViw Mode</h1>
	<div>
		Hotkey: f/j/Right=Next, a/k/Left=Prev, d/Del=Mark Readed and Next, s=Star item
	<div id='item_counter'>
		<span id='item_counter_prev'>0</span>
		|
		<span id='item_cur_id'></span>
		|
		<span id='item_counter_next'>0</span>
	</div>
	</div>
</nav>

<div id='item_container'>
</div>

<script type='text/javascript'>
//<![CDATA[
<!-- -->
var o_items = {
	/* Loaded item info */
	i_min: 0,	/* Usually largest id */
	i_max: 0,	/* Usually smallest id */
	i_cur: 0,
	i_cnt: 0,
	i_cnt_prev: 0,
	i_cnt_next: 0,

	/* Add item to page */
	ItemAdd: function(item) {
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
		/* Change item index */
		if (0 == this.i_min) {
			this.i_min = item.id;
			this.i_cur = item.id;
		}
		else {
			this.i_cnt_next ++;
		}
		this.i_max = item.id;
		this.i_cnt ++;
		this.RefreshCounter();
	},


	/* Load item from db */
	Load: function (i_start, i_num) {
		/* Param default value */
		if ('undefined' == typeof(i_start))
			i_start = this.i_max;
		if ('undefined' == typeof(i_num))
			i_num = {$gr.pagesize};
		$.ajax({
			type: 'GET',
			url: '?a=ajax-item-list',
			data: {
				start: i_start,
				pagesize: i_num
			}
		}).done(function (msg) {
			/* JSON.parse() will reverse item order (by key/item.id asc, */
			/* So data is not index by item.id anymore. */
			$.each(JSON.parse(msg), function (i, item) {
				o_items.ItemAdd(item);
			});
			/* Show cur item */
			$('#article_' + o_items.i_cur).show();
		});
	},


	/* Scroll to Next item */
	Next: function () {
		console.log('next');
	},


	/* Scroll to Prev item */
	Prev: function () {
		console.log('prev');
	},


	/* Set cur item Readed and Next */
	ReadAndNext: function () {
		console.log('read and next');
	},


	/* Refresh prev/next item counter */
	RefreshCounter: function () {
		$('#item_counter_prev').text(this.i_cnt_prev);
		$('#item_counter_next').text(this.i_cnt_next);
		$('#item_cur_id').text(this.i_cur);
	},


	/* Toggle item Readed */
	ToggleReaded: function () {
		console.log('toggle readed');
	},


	/* Toggle item Stared */
	ToggleStared: function () {
		console.log('toggle stared');
	}
}


/* Bind keys */
$(window).keydown(function (evt) {
	// Next: f/j/Right
	if (-1 != [70, 74, 39].indexOf(evt.keyCode)) {
		o_items.Next();
	}
	// Prev: a/k/Left
	else if (-1 != [65, 75, 37].indexOf(evt.keyCode)) {
		o_items.Prev();
	}
	// Mark Readed and Next: d/Del
	else if (-1 != [68, 46].indexOf(evt.keyCode)) {
		o_items.ReadAndNext();
	}
	// Toggle item Stared: s
	else if (-1 != [83].indexOf(evt.keyCode)) {
		o_items.ToggleStared();
	}
	// Toggle item Readed: u
	else if (-1 != [85].indexOf(evt.keyCode)) {
		o_items.ToggleReaded();
	}
});


/* Load items */
o_items.Load();
//]]>
</script>
