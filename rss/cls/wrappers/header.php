<?php
###############################################################################
# Gregarius - A PHP based RSS aggregator.
# Copyright (C) 2003 - 2005 Marco Bonetti
#
###############################################################################
# This program is free software and open source software; you can redistribute
# it and/or modify it under the terms of the GNU General Public License as
# published by the Free Software Foundation; either version 2 of the License,
# or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful, but WITHOUT
# ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
# FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
# more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA  or visit
# http://www.gnu.org/licenses/gpl.html
#
###############################################################################
# E-mail:      mbonetti at users dot sourceforge dot net
# Web page:    http://sourceforge.net/projects/gregarius
#
###############################################################################

///// HEADER WRAPPERS /////
function rss_header_charset() {
 return (getConfig('rss.output.encoding') ? getConfig('rss.output.encoding') : DEFAULT_OUTPUT_ENCODING);
}

function rss_header_title() {
	return $GLOBALS['rss']->header->docTitle;
}

function rss_header_robotmeta() {
	return ((array_key_exists('expand', $_REQUEST) || 
			array_key_exists('collapse', $_REQUEST) || 
			array_key_exists('fcollapse', $_REQUEST) || 
			array_key_exists('fexpand', $_REQUEST) || 
			array_key_exists('dbg', $_REQUEST)) ? 'noindex,follow' : getConfig('rss.config.robotsmeta'));
}

function rss_header_autorefreshtime() {
	return $GLOBALS['rss']->header->redirectTimeout;
}

function rss_header_autorefreshurl() {
	return $GLOBALS['rss']->header->redirectUrl;
}

function rss_header_links() {
	return $GLOBALS['rss']->header->links;
}

function rss_header_javascripts() {
	return $GLOBALS['rss']->header->javascriptFiles;
}

function rss_header_onLoadAction() {
    if (($action = $GLOBALS['rss']->header->onLoadAction) != "") {
	   return " onload=\"$action\" ";
	}
	return "";
}

function rss_main_header() {
	if(isset($GLOBALS['rss']->header)) {
		
		$GLOBALS['rss']->header->render();
	}
}

function rss_main_div_id() {
	if ($GLOBALS['rss']->mainDivId) {
		return " id=\"".$GLOBALS['rss']->mainDivId ."\" ";
	}
	return null;
}

function rss_main_object() {
	foreach($GLOBALS['rss'] -> mainObject as $o) {
		$o->render();
	}
}

function rss_main_feeds() {
	switch ($GLOBALS['rss']->sideMenu->activeElement) {
		
		case 'tags':
			rss_require('cls/taglist.php');
			$GLOBALS['rss']-> tagList = new TagList(false);
			$GLOBALS['rss']-> tagList -> render();
		break;
		
		case 'feeds':
		default:
		if ($GLOBALS['rss']-> feedList) {
			$GLOBALS['rss']-> feedList-> render();
		}
		break;
		
	}
	
}

function rss_main_sidemenu($cntr) {
	if ($GLOBALS['rss']-> sideMenu) {
		$GLOBALS['rss'] -> sideMenu -> setContainer($cntr);
		$GLOBALS['rss']-> sideMenu -> render();
	}
}

function rss_main_title() {
    return makeTitle($GLOBALS['rss']->header->rawTitle);
}

function rss_main_footer() {
	$f=$GLOBALS['rss']->getTemplateFile('footer.php');
	rss_require($f);
}

function rss_footer_last_modif() {
	$ts = getLastModif();
	return ($ts ? rss_date(getConfig('rss.config.dateformat'), $ts) : "never");
}
?>