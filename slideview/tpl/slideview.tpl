{*
	Slideview for Gregarius
*}

<nav>
	<h1>Gregarius SlideViw Mode</h1>
	<div>
		Hotkey: f/j/Right=Next, a/k/Left=Prev, d/Del=Mark Readed and Next, s=Star item
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

	/* Add item to page */
	ItemAdd: function(item) {
		$('#item_container').append('\
			<article id="article_' + item.id + '">\
				<h2>' + item.title + '</h2>\
			</article>\
		');
		/* Change item index */
		if (0 == this.i_min) {
			this.i_min = item.id;
			this.i_cur = item.id;
		}
		o_items.i_max = item.id;
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
			/* So reverse them back before each loop. */
			var ar_item = [];
			$.each(JSON.parse(msg), function (i, item) {
				ar_item.unshift(item);
			});
			/* Loop add item to page */
			$.each(ar_item, function (i, item) {
				o_items.ItemAdd(item);
			});
		});
	}
}


/* Load items */
o_items.Load();
setTimeout(function () {
	console.log(JSON.stringify(o_items, null, 2));
}, 2000);
//]]>
</script>
