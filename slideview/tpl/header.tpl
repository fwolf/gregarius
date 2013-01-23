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
