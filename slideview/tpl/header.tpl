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
	li, p, td {
		line-height: 1.5;
	}
	section {
		text-indent: 2em;
	}
	/* Force display vertical scrollbar */
	html {
		overflow: -moz-scrollbars-vertical;
		overflow-y: scroll;
	}

	/* Nav bar */
	nav {
		left: 0;
		position: fixed;
		top: 0;
		width: 100%;
		z-index: 999;
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
		line-height: 1.4;
		margin: 0.2em;
		padding-top: 0.2em;
	}
	article {
		display: none;
		margin: auto;
		position: relative;
		width: 70%;
	}
	article section {
		margin-top: 0.8em;
		text-align: left;
	}
	/* Stared and Readed */
	article.readed h2 {
		background-color: lightgray;
		text-decoration: line-through;
	}
	article.stared h2 {
		background-color: #70DBFF;
	}
	article.stared h2:before {
		content: url('../plugins/stickyflag/sticky.png') " ";
	}
	article.stared h2:after {
		content: " " url('../plugins/stickyflag/sticky.png');
	}


  /* For mobile view */
  @media screen and (max-width: 1024px) {
    #nav {
      width: 100%;
    }
    article {
      width: 99%;
    }
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
