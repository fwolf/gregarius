<?php
###############################################################################
# Gregarius - A PHP based RSS aggregator.
# Copyright (C) 2003 - 2006 Marco Bonetti
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
# E-mail:      mbonetti at gmail dot com
# Web page:    http://gregarius.net/
#
###############################################################################

///// HEADER WRAPPERS /////
function rss_header_charset() {
    return (getConfig('rss.output.encoding') ? getConfig('rss.output.encoding') : DEFAULT_OUTPUT_ENCODING);
}

function rss_header_title($escaped=true) {
    return ($escaped?$GLOBALS['rss']->header->docTitle:$GLOBALS['rss']->header->rawTitle);
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
    rss_plugin_hook("rss.plugins.before.mainobject",null);
    foreach($GLOBALS['rss'] -> mainObject as $o) {
        $o->render();
    }
}

function rss_main_feeds() {
    switch ($GLOBALS['rss']->sideMenu->activeElement) {

    case 'CatList':
        rss_require('cls/categories.php');
        $v = new CatList();
        $v -> render();
        break;

    case 'TagList':
        rss_require('cls/taglist.php');
        $GLOBALS['rss']-> tagList = new TagList('item');
        $GLOBALS['rss']-> tagList -> render();
        break;


    case 'FeedList':
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
    return ($ts ? rss_locale_date ("%c", $ts) : LBL_FOOTER_LAST_MODIF_NEVER);
}

function rss_header_logininfo() {

    $ret = "<span id=\"loginfo\">\n";
    
    if (rss_user_level() > RSS_USER_LEVEL_NOLEVEL) {
        $ret .= sprintf(LBL_LOGGED_IN_AS, rss_user_name())
                ."&nbsp;|&nbsp;<a href=\"".getPath()."?logout\">".LBL_LOG_OUT."</a>\n";
    } else {
        $ret .= LBL_NOT_LOGGED_IN
                ."&nbsp;|&nbsp;<a href=\"#\" onclick=\"miniloginform(); return false;\">".LBL_LOG_IN."</a>";
        $ret .= "<span style=\"display:none\" id=\"loginformcontainer\">"
						 . '<form ' . 'onsubmit="return loginHandler();" ' . 'method="post" action="'.getPath().'">'
						 . '<input style=" width:50px;" name="username" id="username" type="text" />'
						 . '<input style=" width:50px;" name="password" id="password"  type="password" />'
						 . '<input type="submit" value="'.LBL_LOG_IN.'" />'
						 . '</form>'
        		 ."</span>\n";
    }
    $ret .= "</span>\n";
    return $ret;
}

?>