<?php 
$GLOBALS['rss']->nav->appendNavItem(getPath()."?feeds",__('Feeds'));
$GLOBALS['rss']->nav->appendNavItem(getPath()."?cats",__('Categories'));
$GLOBALS['rss']->nav->appendNavItem(getPath()."update.php?mobile", __('Refresh'));

foreach ($GLOBALS['rss']->nav->items as $item) {
    if( !eregi( 'update.php$', $item -> href ) && !eregi( 'admin', $item -> href ) ) {
			$item -> render();
    }
}

?>
