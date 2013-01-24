<!DOCTYPE HTML>
<html lang='en'>
<head>
	<meta charset='utf-8' />
	<title>Gregarius SlideView</title>

{foreach from=$global.css item='css'}
	<link rel='stylesheet' href='{$css[0]}' type='text/css'
		media='{$css[1]|default: 'all'}' />
{/foreach}

	<style type='text/css' media='all'>
	/*<![CDATA[*/
	/* Write CSS below */
	nav {
		position: fixed;
		top: 0;
		width: 100%;
	}
	h1 {
		font-size: 1.2em;
		line-height: 1em;
		margin-top: 0em;
		padding-top: 0.2em;
	}
	nav h1, nav > div {
		background-color: #70DBFF;
		width: 50%;
		margin: auto;
	}
	nav > div {
		/* Round corner for bottom */
		-moz-border-radius: 0 0 0.7em 0.7em;
		border-radius: 0 0 0.7em 0.7em;
	}
	#item_container {
		margin-top: 3em;
	}
	/*]]>*/
	</style>

{foreach from=$global.js item='url'}
	<script type='text/javascript' src='{$url}'></script>
{/foreach}

	<script type='text/javascript'>
	//<![CDATA[
	<!-- -->
	/* Write js below */
	//]]>
	</script>
</head>
<body>
	<header>
	</header>
