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
	/* Global */
	p, li {
		line-height: 1.5;
	}

	/* Nav bar */
	nav {
		left: 0;
		position: fixed;
		top: 0;
		width: 100%;
	}
	#nav {
		background-color: #70DBFF;
		margin: auto;
		width: 50%;
		/* Round corner for bottom */
		-moz-border-radius: 0 0 0.7em 0.7em;
		border-radius: 0 0 0.7em 0.7em;
	}
	nav h1 {
		font-size: 1.2em;
		line-height: 1;
		margin: auto;
		padding-top: 0.2em;
	}
	#item_counter {
		float: right;
		line-height: 1.4;	/* Smaller than other(1.5) */
		padding-right: 1.0em;
		text-align: right;
	}

	/* Simulate nav height, make item_container position below nav */
	#hotkey_shadow {
		line-height: 1.5em;
		margin: auto;
		visibility: hidden;
		width: 50%;		/* Same with #nav */
	}
	#item_container {
	}

	/* Items */
	#item_container h2 {
		font-size: 1.2em;
		line-height: 1.2;
		margin: 0.2em;
	}
	article {
		/*visibility: hidden;*/
		display: none;
		margin: auto;
		width: 70%;
	}
	article section {
		margin-top: 0.8em;
		text-align: left;
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
