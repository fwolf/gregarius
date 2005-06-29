<?php
###############################################################################
# Gregarius - A PHP based RSS aggregator.
# Copyright (C) 2003 - 2005 Marco Bonetti
#
###############################################################################
# File: $Id$ $Name$
#
###############################################################################
# This program is free software and open source software; you can redistribute
# it and/or modify it under the terms of the GNU General Public License as
# published by the Free Software Foundation; either version 2 of the License,
# or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful, but WITHOUT
# ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
# FITNESS FOR A PARTICULAR PURPOSE.	 See the GNU General Public License for
# more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA  or visit
# http://www.gnu.org/licenses/gpl.html
#
###############################################################################
# E-mail:	   mbonetti at users dot sourceforge dot net
# Web page:	   http://sourceforge.net/projects/gregarius
#
###############################################################################

/*************** Channel management ************/

/**
 * renders the subscribe feed form, and the currently subscribed
 * feeds table
 */
function channels() {
	echo "<h2>". LBL_ADMIN_CHANNELS ."</h2>\n";
	echo "<div id=\"admin_channels\">\n";
	echo "<form method=\"post\" action=\"" .$_SERVER['PHP_SELF'] ."\">\n";
	echo "<p><input type=\"hidden\" name=\"". CST_ADMIN_DOMAIN."\" value=\"".CST_ADMIN_DOMAIN_CHANNEL."\"/>\n";
	echo "<label for=\"new_channel\">". LBL_ADMIN_CHANNELS_ADD ."</label>\n";
	echo "<input type=\"text\" name=\"new_channel\" id=\"new_channel\" value=\"http://\" onfocus=\"this.select()\"/>\n";

	echo "<label for=\"add_channel_to_folder\">". LBL_ADMIN_IN_FOLDER . "</label>\n";
	folder_combo('add_channel_to_folder');

	echo "<input type=\"submit\" name=\"action\" value=\"". LBL_ADMIN_ADD ."\"/></p>\n";
	echo "<p style=\"font-size:small\">".LBL_ADMIN_ADD_CHANNEL_EXPL."</p>";
	echo "</form>\n\n";

	// bookmarklet
	$b_url = "http://" . $_SERVER["HTTP_HOST"] . getPath() . "admin/index.php";
	$b_url .= "?domain=feeds&amp;add_channel_to_folder=0&amp;action=".LBL_ADMIN_ADD."&amp;new_channel=";

	$bookmarklet = "javascript:void(document.location = "
	  ."('$b_url'.concat(document.location)))";

	echo "<p class=\"bookmarklet\">" . LBL_ADMIN_BOOKMARKET_LABEL . " <a class=\"bookmarklet\" href=\"$bookmarklet\">".LBL_ADMIN_BOOKMARKLET_TITLE."</a></p>\n";

	// feeds
	echo "<table id=\"channeltable\">\n"
	  ."<tr>\n"
	  ."\t<th>". LBL_ADMIN_CHANNELS_HEADING_TITLE ."</th>\n"
	  ."\t<th class=\"cntr\">". LBL_ADMIN_CHANNELS_HEADING_FOLDER ."</th>\n"
	  ."\t<th>". LBL_ADMIN_CHANNELS_HEADING_DESCR ."</th>\n"	  
	  ."\t<th>". LBL_ADMIN_CHANNELS_HEADING_FLAGS."</th>\n";
	  
	if (getConfig('rss.config.absoluteordering')) {
	echo "\t<th>".LBL_ADMIN_CHANNELS_HEADING_MOVE."</th>\n";
	}

	echo "\t<th class=\"cntr\">". LBL_ADMIN_CHANNELS_HEADING_ACTION ."</th>\n"
	  ."</tr>\n";

	$sql = "select "
	  ." c.id, c.title, c.url, c.siteurl, d.name, c.descr, c.parent, c.icon, c.mode "
	  ." from " .getTable("channels") ." c, " . getTable("folders") ." d "
	  ." where d.id = c.parent ";

	if (getConfig('rss.config.absoluteordering')) {
	$sql .=" order by d.position asc, c.position asc";
	} else {
	$sql .=" order by c.parent asc, c.title asc";
	}

	$res = rss_query($sql);
	$cntr = 0;
	while (list($id, $title, $url, $siteurl, $parent, $descr, $pid, $icon,$mode) = rss_fetch_row($res)) {

	if (getConfig('rss.output.usemodrewrite')) {
		$outUrl = getPath() . preg_replace("/[^A-Za-z0-9\.]/","_","$title") ."/";
	} else {
		$outUrl = getPath() . "feed.php?channel=$id";
	}

	$parentLabel = $parent == ''? LBL_HOME_FOLDER:$parent;

	$class_ = (($cntr++ % 2 == 0)?"even":"odd");
	
	$fmode = array();
	if ($mode & FEED_MODE_PRIVATE_STATE) {
		$fmode[] = "P";
	}
	if ($mode & FEED_MODE_DELETED_STATE) {
		$fmode[] = "D";
	}
	$slabel = count($fmode)?implode(", ",$fmode):"&nbsp;";
	
	echo "<tr class=\"$class_\">\n"
	  ."\t<td>"
	  .((getConfig('rss.output.showfavicons') && $icon != "")?
		"<img src=\"$icon\" class=\"favicon\" alt=\"$title\" width=\"16\" height=\"16\" />":"")
		."<a href=\"$outUrl\">$title</a></td>\n"
	  ."\t<td class=\"cntr\">".preg_replace('/ /','&nbsp;',$parentLabel)."</td>\n"
	  ."\t<td>$descr</td>\n"
	  ."\t<td class=\"cntr\">$slabel</td>\n";

	if (getConfig('rss.config.absoluteordering')) {
		echo "\t<td class=\"cntr\"><a href=\"".$_SERVER['PHP_SELF']. "?".CST_ADMIN_DOMAIN."=". CST_ADMIN_DOMAIN_CHANNEL
		  ."&amp;action=". CST_ADMIN_MOVE_UP_ACTION. "&amp;cid=$id\">". LBL_ADMIN_MOVE_UP
		  ."</a>&nbsp;-&nbsp;<a href=\"".$_SERVER['PHP_SELF']. "?".CST_ADMIN_DOMAIN."=". CST_ADMIN_DOMAIN_CHANNEL
		  ."&amp;action=". CST_ADMIN_MOVE_DOWN_ACTION ."&amp;cid=$id\">".LBL_ADMIN_MOVE_DOWN ."</a></td>\n";
	}
	echo "\t<td class=\"cntr\"><a href=\"".$_SERVER['PHP_SELF']. "?".CST_ADMIN_DOMAIN."=". CST_ADMIN_DOMAIN_CHANNEL
	  ."&amp;action=". CST_ADMIN_EDIT_ACTION. "&amp;cid=$id\">" . LBL_ADMIN_EDIT
	  ."</a>|<a href=\"".$_SERVER['PHP_SELF']. "?".CST_ADMIN_DOMAIN."=". CST_ADMIN_DOMAIN_CHANNEL
	  ."&amp;action=". CST_ADMIN_DELETE_ACTION ."&amp;cid=$id\">" . LBL_ADMIN_DELETE ."</a></td>\n"
	  ."</tr>\n";
	}

	echo "</table>\n</div>\n\n\n";

}

/**
 * Performs all the feed-related admin actions
 */

function channel_admin() {

	$ret__ = CST_ADMIN_DOMAIN_NONE;
	switch ($_REQUEST['action']) {
	 case LBL_ADMIN_ADD:
	 case 'Add':

    $label = trim($_REQUEST['new_channel']);
	$fid = trim($_REQUEST['add_channel_to_folder']);
	if ($label != 'http://' &&	substr($label, 0,4) == "http") {
		$ret = add_channel($label,$fid);
		//var_dump($ret);
		if (is_array($ret) && $ret[0] > -1) {
			update($ret[0]);
			$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
		} elseif  (is_array($ret) && $ret[0] > -2) {
			//rss_error("Error: " .$ret[1]);
			// okay, something went wrong, maybe thats a html url after all?
			// let's try and see if we can extract some feeds
			$feeds = extractFeeds($label);
			if (!is_array($feeds) || sizeof($feeds) == 0) {
				rss_error($ret[1]);
				$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
			} else {
				//one single feed in the html doc, add that
				if (is_array($feeds) && sizeof($feeds) == 1 && array_key_exists('href',$feeds[0])) {
					$ret = add_channel($feeds[0]['href'],$fid);
					if (is_array($ret) && $ret[0] > -1) {
						update($ret[0]);
						$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
					} else {
						// failure
						rss_error($ret[1]);
						$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
					}
				} else {
					// multiple feeds in the channel
					echo "<form method=\"post\" action=\"" .$_SERVER['PHP_SELF'] ."\">\n"
					  ."<p>".sprintf(LBL_ADMIN_FEEDS,$label,$label)."</p>\n";
					$cnt = 0;
					while(list($id,$feedarr) = each($feeds)) {
						// we need an URL
						if (!array_key_exists('href',$feedarr)) {
							continue;
						} else {
							$href = $feedarr['href'];
						}
	
						if (array_key_exists('type',$feedarr)) {
							$typeLbl = " [<a href=\"$href\">" . $feedarr['type'] 
							. "</a>]";
						}
	
					$cnt++;
	
					if (array_key_exists('title',$feedarr)) {
						$lbl = $feedarr['title'];
					} elseif (array_key_exists('type',$feedarr)) {
						$lbl = $feedarr['type'];
						$typeLbl = "";
					} elseif (array_key_exists('href',$feedarr)) {
						$lbl = $feedarr['href'];
					} else {
						$lbl = "Resource $cnt";
					}
	
					echo "<p>\n\t<input class=\"indent\" type=\"radio\" id=\"fd_$cnt\" name=\"new_channel\" "
					  ." value=\"$href\"/>\n"
					  ."\t<label for=\"fd_$cnt\">$lbl $typeLbl</label>\n"
					  ."</p>\n";
				}
	
				echo "<p><input type=\"hidden\" name=\"add_channel_to_folder\" value=\"$fid\"/>\n"
				  ."<input type=\"hidden\" name=\"".CST_ADMIN_DOMAIN."\" value=\"".CST_ADMIN_DOMAIN_CHANNEL."\"/>\n"
				  ."<input type=\"submit\" class=\"indent\" name=\"action\" value=\"". LBL_ADMIN_ADD ."\"/>\n"
				  ."</p>\n</form>\n\n";
				}
			}
		} elseif (is_array($ret))  {
			rss_error($ret[1]);
			$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
		} else {
			rss_error(sprintf(LBL_ADMIN_BAD_RSS_URL,$label));
			$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
		}
	} else {
		rss_error(sprintf(LBL_ADMIN_BAD_RSS_URL,$label));
		$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
	}
	break;

	 case CST_ADMIN_EDIT_ACTION:
		$id = $_REQUEST['cid'];
		channel_edit_form($id);
	break;

	 case LBL_ADMIN_CREATE:
		$label=$_REQUEST['new_folder'];
		assert(strlen($label) > 0);

		$sql = "insert into " . getTable("folders") ." (name) values ('" . rss_real_escape_string($label) ."')";
		rss_query($sql);
		$ret__ = CST_ADMIN_DOMAIN_FOLDER;
		break;

	 case CST_ADMIN_DELETE_ACTION:
		$id = $_REQUEST['cid'];
		if (array_key_exists(CST_ADMIN_CONFIRMED,$_REQUEST) && $_REQUEST[CST_ADMIN_CONFIRMED] == LBL_ADMIN_YES) {
			$rs = rss_query("select distinct id from " .getTable("item") . " where cid=$id");
			$ids = array();
			while (list($did) = rss_fetch_row($rs)) {
					$ids[] = $did;
			}
			if (count($ids)) {
				$sqldel = "delete from " .getTable('metatag') . " where fid in ("
				. implode(",",$ids)	.")";
				rss_query($sqldel);
			}
				
			$sql = "delete from " . getTable("item") ." where cid=$id";
			rss_query($sql);
			$sql = "delete from " . getTable("channels") ." where id=$id";
			rss_query($sql);
			$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
		} elseif (array_key_exists(CST_ADMIN_CONFIRMED,$_REQUEST) && $_REQUEST[CST_ADMIN_CONFIRMED] == LBL_ADMIN_NO) {
			$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
		} else {
			list($cname) = rss_fetch_row(rss_query("select title from " . getTable("channels") ." where id = $id"));

			echo "<form class=\"box\" method=\"post\" action=\"" .$_SERVER['PHP_SELF'] ."\">\n"
			."<p class=\"error\">"; printf(LBL_ADMIN_ARE_YOU_SURE,$cname); echo "</p>\n"
			."<p><input type=\"submit\" name=\"".CST_ADMIN_CONFIRMED."\" value=\"". LBL_ADMIN_NO ."\"/>\n"
			."<input type=\"submit\" name=\"".CST_ADMIN_CONFIRMED."\" value=\"". LBL_ADMIN_YES ."\"/>\n"
			."<input type=\"hidden\" name=\"cid\" value=\"$id\"/>\n"
			."<input type=\"hidden\" name=\"".CST_ADMIN_DOMAIN."\" value=\"".CST_ADMIN_DOMAIN_CHANNEL."\"/>\n"
			."<input type=\"hidden\" name=\"action\" value=\"". CST_ADMIN_DELETE_ACTION ."\"/>\n"
			."</p>\n</form>\n";
		}
		break;

	 case LBL_ADMIN_FILE_IMPORT:
		if (is_uploaded_file($_FILES['opmlfile']['tmp_name'])) {
			$url = $_FILES['opmlfile']['tmp_name'];
		} else {
			$url = '';
		}

	 case LBL_ADMIN_IMPORT:
		if ($url == '') {
			$url = $_REQUEST['opml'];
		}
		$opml=getOpml($url);

		if (sizeof($opml) > 0) {
		
			rss_query("delete from " . getTable("metatag"));
			rss_query("delete from " . getTable("channels"));
			rss_query("delete from " . getTable("item"));
			rss_query("delete from " . getTable("folders") ." where id > 0");

			$prev_folder = LBL_HOME_FOLDER;
			$fid = 0;
			while (list($folder,$items) = each ($opml)) {
				if ($folder != $prev_folder) {
					$fid = create_folder($folder);
					$prev_folder = $folder;
				}
		
				for ($i=0;$i<sizeof($opml[$folder]);$i++){
					$url_ = trim($opml[$folder][$i]['XMLURL']);
					add_channel($url_, $fid);
				}
		
			}
	
			//update all the feeds
			update("");
	
			// mark all items as read
			rss_query( "update " . getTable("item") ." set unread=0" );

		}
		$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
		break;

	 case CST_ADMIN_SUBMIT_EDIT:
		$cid = $_REQUEST['cid'];
		$title= rss_real_escape_string(real_strip_slashes($_REQUEST['c_name']));
		$url= rss_real_escape_string($_REQUEST['c_url']);
		$siteurl= rss_real_escape_string($_REQUEST['c_siteurl']);
		$parent= rss_real_escape_string($_REQUEST['c_parent']);
		$descr= rss_real_escape_string(real_strip_slashes($_REQUEST['c_descr']));
		$icon = rss_real_escape_string($_REQUEST['c_icon']);
		$priv = (array_key_exists('c_private',$_REQUEST) && $_REQUEST['c_private'] == '1');
		$old_priv = ($_REQUEST['old_priv'] == '1');
		if ($priv != $old_priv) {
			$mode = ", mode = mode ";
			if ($priv) {
				$mode .=  " | " . FEED_MODE_PRIVATE_STATE;
				rss_query ('update ' . getTable('item') 
				." set unread = unread | " . FEED_MODE_PRIVATE_STATE 
				." where cid=$cid");
			} else {
				$mode .= " & " .SET_MODE_PUBLIC_STATE;
				
				rss_query ('update ' . getTable('item') 
				." set unread = unread & " . SET_MODE_PUBLIC_STATE 
				." where cid=$cid");
			}
		} else { 
			$mode = "";
		}
		
		$del = (array_key_exists('c_deleted',$_REQUEST) && $_REQUEST['c_deleted'] == '1');
		$old_del = ($_REQUEST['old_del'] == '1');
		if ($del != $old_del) {
			if ($mode == "") {
				$mode = ", mode = mode ";
			} 
			if ($del) {
				$mode .=  " | " . FEED_MODE_DELETED_STATE;
			} else {
				$mode .= " & " . SET_MODE_AVAILABLE_STATE;
			}
		} 
		
	
		if ($url == '' || substr($url,0,4) != "http") {
			rss_error(sprintf(LBL_ADMIN_BAD_RSS_URL,$url));
			$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
			break;
		}
	
		$sql = "update " .getTable("channels") 
			." set title='$title', url='$url', siteurl='$siteurl', "
		  ." parent=$parent, descr='$descr', icon='$icon' "
		  ." $mode where id=$cid";
	
		rss_query($sql);
		$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
		break;

	 case CST_ADMIN_MOVE_UP_ACTION:
	 case CST_ADMIN_MOVE_DOWN_ACTION:
		$id = $_REQUEST['cid'];
		$res = rss_query("select parent,position from " . getTable("channels") ." where id=$id");
		list($parent,$position) = rss_fetch_row($res);
		$res = rss_query(
				 "select id, position from " .getTable("channels")
				 ." where parent=$parent and id != $id order by abs($position-position) limit 2"
				 );
	
		// Let's look for a lower/higher position than the one we got.
		$switch_with_position=$position;
	
		while (list($oid,$oposition) = rss_fetch_row($res)) {
			if (
			// found none yet?
			($switch_with_position == $position) &&
			(
			 // move up: we look for a lower position
			 ($_REQUEST['action'] == CST_ADMIN_MOVE_UP_ACTION && $oposition < $switch_with_position)
			 ||
			 // move up: we look for a higher position
			 ($_REQUEST['action'] == CST_ADMIN_MOVE_DOWN_ACTION && $oposition > $switch_with_position)
			 )
			){
			$switch_with_position = $oposition;
			$switch_with_id = $oid;
			}
		}
		// right, lets!
		if ($switch_with_position != $position) {
			rss_query( "update " .getTable("channels") ." set position = $switch_with_position where id=$id" );
			rss_query( "update " .getTable("channels") ." set position = $position where id=$switch_with_id" );
		}
		$ret__ = CST_ADMIN_DOMAIN_CHANNEL;
		break;

	 default: break;
	}
	return $ret__;
}

function channel_edit_form($cid) {
	$sql = "select id, title, url, siteurl, parent, descr, icon, mode from " .getTable("channels") ." where id=$cid";
	$res = rss_query($sql);
	list ($id, $title, $url, $siteurl, $parent, $descr, $icon,$mode) = rss_fetch_row($res);

	echo "<div>\n";
	echo "\n\n<h2>".LBL_ADMIN_CHANNEL_EDIT_CHANNEL." '$title'</h2>\n";
	echo "<form method=\"post\" action=\"" .$_SERVER['PHP_SELF'] ."\" id=\"channeledit\">\n"
	  ."<p><input type=\"hidden\" name=\"".CST_ADMIN_DOMAIN."\" value=\"". CST_ADMIN_DOMAIN_CHANNEL."\"/>\n"
	  ."<input type=\"hidden\" name=\"action\" value=\"". CST_ADMIN_SUBMIT_EDIT ."\"/>\n"
	  ."<input type=\"hidden\" name=\"cid\" value=\"$cid\"/>\n"

	  // Item name
	  ."<label for=\"c_name\">". LBL_ADMIN_CHANNEL_NAME ."</label>\n"
	  ."<input type=\"text\" id=\"c_name\" name=\"c_name\" value=\"$title\"/></p>"

	  // RSS URL
	  ."<p><label for=\"c_url\">". LBL_ADMIN_CHANNEL_RSS_URL ."</label>\n"
	  ."<a href=\"$url\">" . LBL_VISIT . "</a>\n"
	  ."<input type=\"text\" id=\"c_url\" name=\"c_url\" value=\"$url\"/></p>"

	  // Site URL
	  ."<p><label for=\"c_siteurl\">". LBL_ADMIN_CHANNEL_SITE_URL ."</label>\n"
	  ."<a href=\"$siteurl\">" . LBL_VISIT . "</a>\n"
	  ."<input type=\"text\" id=\"c_siteurl\" name=\"c_siteurl\" value=\"$siteurl\"/></p>"

	  // Folder
	  ."<p><label for=\"c_parent\">". LBL_ADMIN_CHANNEL_FOLDER ."</label>\n";

	folder_combo('c_parent',$parent);
	echo "</p>\n";
	
	
	// Items state
	if ($mode & FEED_MODE_PRIVATE_STATE) {
		$pchk = " checked=\"checked\" ";
		$old_priv = "1";
	} else {
		$pchk = "";
		$old_priv = "0";
	}
	
	if ($mode & FEED_MODE_DELETED_STATE) {
		$dchk = " checked=\"checked\" ";
		$old_del = "1";
	} else {
		$dchk = "";
		$old_del = "0";
	}
	
	
	echo "<p>\n"
		."<input style=\"display:inline\" type=\"checkbox\" id=\"c_private\" "
		." name=\"c_private\" value=\"1\"$pchk />\n"
		."<label for=\"c_private\">". LBL_ADMIN_CHANNEL_PRIVATE ."</label>\n"
		."<input type=\"hidden\" name=\"old_priv\" value=\"$old_priv\" />\n"
		."</p>\n";

	
	echo "<p>\n"
		."<input style=\"display:inline\" type=\"checkbox\" id=\"c_deleted\" "
		." name=\"c_deleted\" value=\"1\"$dchk />\n"
		."<label for=\"c_deleted\">". LBL_ADMIN_CHANNEL_DELETED ."</label>\n"
		."<input type=\"hidden\" name=\"old_del\" value=\"$old_del\" />\n"
		."</p>\n";

	
	// Description
    $descr = strip_tags($descr);
	echo "<p><label for=\"c_descr\">". LBL_ADMIN_CHANNEL_DESCR ."</label>\n"
	  ."<input type=\"text\" id=\"c_descr\" name=\"c_descr\" value=\"$descr\"/></p>\n";

	// Icon
	if (getConfig('rss.output.showfavicons')) {
		echo "<p><label for=\"c_icon\">" . LBL_ADMIN_CHANNEL_ICON ."</label>\n";
	
		if (trim($icon) != "") {
			echo "<img src=\"$icon\" alt=\"$title\" class=\"favicon\" width=\"16\" height=\"16\" />\n";
			echo "<span>" . LBL_CLEAR_FOR_NONE ."</span>";
		}

		echo "<input type=\"text\" id=\"c_icon\" name=\"c_icon\" value=\"$icon\"/></p>\n";
	} else {
		echo "<p><input type=\"hidden\" name=\"c_icon\" id=\"c_icon\" value=\"$icon\"/></p>\n";
	}

	echo "<p><input type=\"submit\" name=\"action_\" value=\"". LBL_ADMIN_SUBMIT_CHANGES ."\"/></p>"
	  ."</form></div>\n";
}

?>