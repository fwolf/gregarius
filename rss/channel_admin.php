<?
###############################################################################
# Gregarius - A PHP based RSS aggregator.
# Copyright (C) 2003, 2004 Marco Bonetti
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

require_once('init.php');
require_once('opml.php');

define ('ADMIN_DOMAIN','domain');
define ('ADMIN_DOMAIN_FOLDER','folder');
define ('ADMIN_DOMAIN_CHANNEL','channel');
define ('ADMIN_DELETE_ACTION','delete');
define ('ADMIN_EDIT_ACTION','edit');

/*
if (defined('_ADMIN_USERNAME_') && defined ('_ADMIN_PASSWORD_')) {
    if ($_SERVER['PHP_AUTH_USER'] != _ADMIN_USERNAME_ || $_SERVER['PHP_AUTH_PW'] != _ADMIN_PASSWORD_ ) {
	header('WWW-Authenticate: Basic realm="Gregarius Admin Authentication"');
	header('HTTP/1.0 401 Unauthorized');

	exit();
    }
}
*/

rss_header("Channel Admin",4);


main();
rss_footer();

$folder_array=array();

function main() {
    echo "\n<div id=\"channel_managmenet\" class=\"frame\">";

    if (array_key_exists(ADMIN_DOMAIN,$_REQUEST)) {
	switch($_REQUEST[ADMIN_DOMAIN]) {
	 case ADMIN_DOMAIN_FOLDER:
	    folder_admin();
	    break;
	 case ADMIN_DOMAIN_CHANNEL:
	    channel_admin();
	    break;
	 default:
	    break;
	}
    }
    folders();
    channels();
    echo "</div>\n";
}

/*************** Channel management ************/

function channels() {
    echo "\n\n<h2>". ADMIN_CHANNELS ."</h2>\n";
    echo "<form method=\"post\" action=\"" .$_SERVER['PHP_SELF'] ."\">\n";
    echo "<p><input type=\"hidden\" name=\"". ADMIN_DOMAIN."\" value=\"".ADMIN_DOMAIN_CHANNEL."\"/>\n";
    echo "<label for=\"new_channel\">". ADMIN_CHANNELS_ADD ."</label>\n";
    echo "<input type=\"text\" name=\"new_channel\" id=\"new_channel\" value=\"http://\" />\n";
    echo "<input type=\"submit\" name=\"action\" value=\"". ADMIN_ADD ."\"/></p>\n";
    echo "</form>\n\n";


    echo "<table id=\"channeltable\">\n"
      ."<tr>\n"
      ."\t<th>". ADMIN_CHANNELS_HEADING_TITLE ."</th>\n"
      ."\t<th>". ADMIN_CHANNELS_HEADING_FOLDER ."</th>\n"
      ."\t<th>". ADMIN_CHANNELS_HEADING_DESCR ."</th>\n"
      ."\t<th>". ADMIN_CHANNELS_HEADING_ACTION ."</th>\n"
      ."</tr>\n";

    $sql = "select "
      ." c.id, c.title, c.url, c.siteurl, d.name, c.descr, c.parent "
      ." from channels c, folders d "
      ." where d.id = c.parent"
      ." order by 7 asc, 2 asc";

    $res = rss_query($sql);
    $cntr = 0;
    while (list($id, $title, $url, $siteurl, $parent, $descr, $pid) = mysql_fetch_row($res)) {
	if ($siteurl != "") {
	    $outUrl = $siteurl;
	} else {
	    $outUrl = $url;
	}
	
	
	$parentLabel = $parent == ''? HOME_FOLDER:$parent;
	
	$class_ = (($cntr++ % 2 == 0)?"even":"odd");
	echo "<tr class=\"$class_\">\n"
	  ."\t<td><a href=\"$outUrl\">$title</a></td>\n"
	  ."\t<td>$parentLabel</td>\n"
	  ."\t<td>$descr</td>\n"
	  ."\t<td><a href=\"".$_SERVER['PHP_SELF']. "?".ADMIN_DOMAIN."=". ADMIN_DOMAIN_CHANNEL."&amp;action=". ADMIN_EDIT_ACTION. "&amp;cid=$id\">" . ADMIN_EDIT ."</a>|<a href=\"".$_SERVER['PHP_SELF']. "?".ADMIN_DOMAIN."=". ADMIN_DOMAIN_CHANNEL."&amp;action=". ADMIN_DELETE_ACTION ."&amp;cid=$id\">" . ADMIN_DELETE ."</a></td>\n"
	  ."</tr>\n";
    }

    echo "</table>\n";


    //opml import
    echo "\n\n<h2>". ADMIN_OPML ."</h2>\n";
    echo "<form method=\"post\" action=\"" .$_SERVER['PHP_SELF'] ."\">\n";
    echo "<p><input type=\"hidden\" name=\"". ADMIN_DOMAIN ."\" value=\"".ADMIN_DOMAIN_CHANNEL."\"/>\n";
    echo "<label for=\"opml\">" . ADMIN_OPML_IMPORT ."</label>\n";
    echo "<input type=\"text\"  name=\"opml\" id=\"opml\" value=\"http://\" />\n";
    echo "<input type=\"submit\" name=\"action\" value=\"". ADMIN_IMPORT ."\"/></p>\n";

    echo "</form>\n";

    opml_export_form();
}

function channel_admin() {
    
    if (defined('DEMO_MODE') && DEMO_MODE == true) {
	rss_error ("I'm sorry, " . _TITLE_ . " is currently in demo mode. Actual actions are not performed.");	
	return;
    }
    
    switch ($_REQUEST['action']) {	
     case ADMIN_ADD:
	$label = $_REQUEST['new_channel'];
	add_channel($label);	
	break;
	
     case ADMIN_EDIT_ACTION:
	$id = $_REQUEST['cid'];
	channel_edit_form($id);
	break;
	
     case ADMIN_CREATE:
	$label=$_REQUEST['new_folder'];
	assert(strlen($label) > 0);

	$sql = "insert into folders (name) values ('" . mysql_real_escape_string($label) ."')";
	rss_query($sql);
	break;

     case ADMIN_DELETE_ACTION:
	$id = $_REQUEST['cid'];
	if (array_key_exists('confirmed',$_REQUEST) && $_REQUEST['confirmed'] == ADMIN_YES) {
	    $sql = "delete from item where cid=$id";
	    rss_query($sql);
	    $sql = "delete from channels where id=$id";
	    rss_query($sql);	    
	} elseif (array_key_exists('confirmed',$_REQUEST) && $_REQUEST['confirmed'] == ADMIN_NO) {
	    // nop;
	} else {
	    list($cname) = mysql_fetch_row(rss_query("select title from channels where id = $id"));
	    
	    echo "<form class=\"box\" method=\"post\" action=\"" .$_SERVER['PHP_SELF'] ."\">\n"
	      ."<p class=\"error\">"; printf(ADMIN_ARE_YOU_SURE,$cname); echo "</p>\n"
	      ."<p><input type=\"submit\" name=\"confirmed\" value=\"". ADMIN_NO ."\"/>\n"
	      ."<input type=\"submit\" name=\"confirmed\" value=\"". ADMIN_YES ."\"/>\n"
	      ."<input type=\"hidden\" name=\"cid\" value=\"$id\"/>\n"
	      ."<input type=\"hidden\" name=\"".ADMIN_DOMAIN."\" value=\"".ADMIN_DOMAIN_CHANNEL."\"/>\n"
	      ."<input type=\"hidden\" name=\"action\" value=\"". ADMIN_DELETE ."\"/>\n"
	      ."</p>\n</form>\n";
	}
	break;

     case ADMIN_IMPORT:
	$url = $_REQUEST['opml'];
	$opml=getOpml($url);

	if (sizeof($opml) > 0) {
	    $sql = "delete from channels";
	    rss_query($sql);

	    $sql = "delete from item";
	    rss_query($sql);

	    //$sql = "delete from folders where id > 0";
	    //rss_query($sql);

	    //echo "adding: " .$opml[$i]['XMLURL'];
	    for ($i=0;$i<sizeof($opml);$i++){
		add_channel($opml[$i]['XMLURL']);
	    }
	    //update all the feeds
	    update("");
	}
	break;

     case 'submit_channel_edit':
	$cid = $_REQUEST['cid'];
	$title= mysql_real_escape_string(real_strip_slashes($_REQUEST['c_name']));
	$url= mysql_real_escape_string($_REQUEST['c_url']);
	$siteurl= mysql_real_escape_string($_REQUEST['c_siteurl']);
	$parent= mysql_real_escape_string($_REQUEST['c_parent']);
	$descr= mysql_real_escape_string(real_strip_slashes($_REQUEST['c_descr']));

	$sql = "update channels set title='$title', url='$url', siteurl='$siteurl', "
	  ." parent=$parent, descr='$descr' where id=$cid";

	rss_query($sql);
	break;

     default: break;
    }    
}

function channel_edit_form($cid) {
    $sql = "select id, title, url, siteurl, parent, descr from channels where id=$cid";
    $res = rss_query($sql);
    list ($id, $title, $url, $siteurl, $parent, $descr) = mysql_fetch_row($res);

    echo "<div>\n";
    echo "\n\n<h2>Edit '$title'</h2>\n";
    echo "<form method=\"post\" action=\"" .$_SERVER['PHP_SELF'] ."\" id=\"channeledit\">\n"
      ."<p><input type=\"hidden\" name=\"".ADMIN_DOMAIN."\" value=\"". ADMIN_DOMAIN_CHANNEL."\"/>\n"
      ."<input type=\"hidden\" name=\"action\" value=\"submit_channel_edit\"/>\n"
      ."<input type=\"hidden\" name=\"cid\" value=\"$cid\"/>\n"
      ."<label for=\"c_name\">". ADMIN_CHANNEL_NAME ."</label>\n"
      ."<input type=\"text\" id=\"c_name\" name=\"c_name\" value=\"$title\"/></p>"
      ."<p><label for=\"c_url\">". ADMIN_CHANNEL_RSS_URL ."</label>\n"
      ."<input type=\"text\" id=\"c_url\" name=\"c_url\" value=\"$url\"/></p>"
      ."<p><label for=\"c_siteurl\">". ADMIN_CHANNEL_SITE_URL ."</label>\n"
      ."<input type=\"text\" id=\"c_siteurl\" name=\"c_siteurl\" value=\"$siteurl\"/></p>"
      ."<p><label for=\"c_parent\">". ADMIN_CHANNEL_FOLDER ."</label>\n"
      ."<select name=\"c_parent\" id=\"c_parent\">\n";

    $sql = " select id, name from folders order by id asc";
    $res = rss_query($sql);
    while (list($pid, $pname) = mysql_fetch_row($res)) {
	if ($pid == $parent) {
	    $selected = " selected=\"selected\"";
	} else {
	    $selected = "";
	}
	
	$parentLabel = ($pid == 0)?HOME_FOLDER:$pname;
	//if ($pid > 0) {
	echo "\t<option value=\"$pid\" $selected>$parentLabel</option>\n";
	//}
    }

    echo "</select></p>\n";

    echo "<p><label for=\"c_descr\">". ADMIN_CHANNEL_DESCR ."</label>\n"
      ."<input type=\"text\" id=\"c_descr\" name=\"c_descr\" value=\"$descr\"/></p>"

      ."<p><input type=\"submit\" name=\"action_\" value=\"". ADMIN_SUBMIT_CHANGES ."\"></p>"
      ."</form></div>\n";
}

/*************** Folder management ************/

function folders() {
    echo "<h2>".ADMIN_FOLDERS."</h2>\n";
    echo "<form method=\"post\" action=\"" .$_SERVER['PHP_SELF'] ."\">\n";
    echo "<p><input type=\"hidden\" name=\"".ADMIN_DOMAIN."\" value=\"".ADMIN_DOMAIN_FOLDER."\"/>\n";

    folder_combo('folder_rename');
    echo "<input type=\"submit\" name=\"action\" value=\"".ADMIN_RENAME."\"/>\n";
    echo "<input type=\"text\"  name=\"folder_rename_to\" value=\"\" /></p>";   
    
    echo "<p>";
    folder_combo('folder_delete');                  
    echo "<input type=\"submit\" name=\"action\" value=\"".ADMIN_DELETE2."\"/>\n";
    echo "</p>\n";

    
    echo "<p><input type=\"text\"  name=\"new_folder\" value=\"\" />";
    echo "<input type=\"submit\" name=\"action\" value=\"". ADMIN_CREATE ."\"/>\n";
    echo "</p></form>";
}

function folder_combo($name) {
    echo "\n<select name=\"$name\">\n";
    $res = rss_query("select id, name from folders");
    while (list($id, $name) = mysql_fetch_row($res)) {	
	echo "\t<option value=\"$id\">" .  (($id == 0)?HOME_FOLDER:$name)  ."</option>\n";
    } 
    echo "</select>\n";   
}

function folder_admin() {

    if (defined('DEMO_MODE') && DEMO_MODE == true) {
	rss_error ("I'm sorry, " . _TITLE_ . " is currently in demo mode. Actual actions are not performed.");
	return;
    }

    switch ($_REQUEST['action']) {

     case ADMIN_DELETE2:
	$id = $_REQUEST['folder_delete'];
	assert(is_numeric($id) && $id>=0);

	if ($id == 0) {
	    rss_error ("You can't delete the '". HOME_FOLDER ."' folder!");
	} else {
	    $sql = "delete from folders where id=$id";
	    rss_query($sql);
	    $sql = "update channels set parent=0 where parent=$id";
	    rss_query($sql);
	}

	break;
     case ADMIN_RENAME:
	$id = $_REQUEST['folder_rename'];
	$new_label = mysql_real_escape_string($_REQUEST['folder_rename_to']);
	if (is_numeric($id) && strlen($new_label) > 0) {
	    rss_query("update folders set name='$new_label' where id=$id");
	}
	break;
	
     case ADMIN_CREATE:
	$label=$_REQUEST['new_folder'];
	assert(strlen($label) > 0);
	$sql = "insert into folders (name) values ('" . mysql_real_escape_string($label) ."')";
	rss_query($sql);
	break;
	
     default: break;
    }
}

/*************** OPML Export ************/

function opml_export_form() {
    echo "<form method=\"get\" action=\"". getPath() ."opml.php\">\n"
      ."<p><label for=\"action\">". ADMIN_OPML_EXPORT. "</label>\n"
      ."<input type=\"submit\" name=\"action\" id=\"action\" value=\"". ADMIN_EXPORT ."\"/></p>\n</form>\n";
}

function real_strip_slashes($string) {
    if (stripslashes($string) == $string) {
	return $string;
    }
    return real_strip_slashes(stripslashes($string));
}
?>
