<?
###############################################################################
# Gregarius - A PHP based RSS aggregator.
# Copyright (C) 2003, 2004 Marco Bonetti
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



if (
    defined('USE_MODREWRITE') 
    && USE_MODREWRITE 
    && array_key_exists('channel',$_REQUEST)    
    // this is nasty because a numeric feed title could break it
    && !is_numeric($_REQUEST['channel'])     
    ) 
{
    $sqlid =  preg_replace("/[^A-Za-z0-9\.]/","%",$_REQUEST['channel']);
    $res =  rss_query( "select id from channels where title like '$sqlid'" );
    
    if ( rss_num_rows ( $res ) == 1) {
	list($cid) = rss_fetch_row($res);
    } else {
	$cid = "";
    }       
    
    // lets see if theres an item id as well
    $iif = "";
    if ($cid != "" && array_key_exists('iid',$_REQUEST) && $_REQUEST['iid'] != "") {
	$sqlid =  preg_replace("/[^A-Za-z0-9\.]/","%",$_REQUEST['iid']);
	$res =  rss_query( "select id from item where title like '$sqlid' and cid=$cid" );
		
	if ( rss_num_rows ( $res ) >0) {
	    list($iid) = rss_fetch_row($res);  
	}
    }
    

    
    // date ?
    if ($cid != "" 
	&& array_key_exists('y',$_REQUEST) && $_REQUEST['y'] != "" && is_numeric($_REQUEST['y'])
	&& array_key_exists('m',$_REQUEST) && $_REQUEST['m'] != "" && is_numeric($_REQUEST['m']))
	
    {	
	
	$y = (int) $_REQUEST['y'];
	if ($y < 1000) $y+=2000;
	
	$m =  $_REQUEST['m'];	
	if ($m > 12) {
	    $m = date("m");
	}
	
	$d =  $_REQUEST['d'];
	if ($d > 31) {
	    $d = date("d");
	} 

    } else {
	$y = 0;
	$m = 0;
	$d = 0;
    }

// no mod rewrite: ugly but effective
} elseif (array_key_exists('channel',$_REQUEST)) {
    $cid= (array_key_exists('channel',$_REQUEST))?$_REQUEST['channel']:"";
    $iid= (array_key_exists('iid',$_REQUEST))?$_REQUEST['iid']:"";
    $pageNum =  (array_key_exists('page',$_REQUEST))?(int)$_REQUEST['page']:1;
}

// If we have no channel-id somethign went terribly wrong.
// Redirect to index.php
if (!$cid) {
    $red = "http://" . $_SERVER['HTTP_HOST'] . getPath();
    header("Location: $red");
}

if (array_key_exists ('action', $_POST) && $_POST['action'] == MARK_CHANNEL_READ) {
    
    $sql = "update item set unread=0 where cid=$cid";
    rss_query($sql);
    
    // redirect to the next unread, if any.
    $sql = "select cid,title from item where unread=1 order by added desc limit 1";
    $res = rss_query($sql);
    list ($next_unread_id, $next_unread_title) = rss_fetch_row($res);
    
    if ($next_unread_id == '') {	
	$redirect = "http://"
	  . $_SERVER['HTTP_HOST']     
	  . dirname($_SERVER['PHP_SELF']);   
	
	if (substr($redirect,-1) != "/") {
	    $redirect .= "/";
	} 
	
	header("Location: $redirect");
	exit();
    } else {
	$cid = $next_unread_id;
    }
}

assert(is_numeric($cid));

$itemFound = true;
if ($iid != "" && !is_numeric($iid)) {
    //item was deleted
    $itemFound = false;
    $iid = "";
}


if ($iid == "") {
    $res = rss_query("select title,icon from channels where id = $cid");
    list($title,$icon) = rss_fetch_row($res);
    if ($y > 0 && $m > 0 && $d == 0) {
	$dtitle =  (" " . TITLE_SEP ." " . date('F Y',mktime(0,0,0,$m,1,$y)));
    } elseif ($y > 0 && $m > 0 && $d > 0) {
	$dtitle =  (" " . TITLE_SEP ." " . date('F jS, Y',mktime(0,0,0,$m,$d,$y)));
    } else {
	$dtitle ="";
    }
    
    rss_header( rss_htmlspecialchars( $title ) . $dtitle);
} else {
   $res = rss_query ("select c.title, c.icon, i.title from channels c,item i where c.id = $cid and i.cid=c.id and i.id=$iid");
    list($title,$icon,$ititle) = rss_fetch_row($res);
    rss_header(  
		 rss_htmlspecialchars($title) 
		 . " " . TITLE_SEP ." " 
		 .  rss_htmlspecialchars($ititle)  
	      );
}



sideChannels($cid); 
if (defined('_DEBUG_') && array_key_exists('dbg',$_REQUEST)) {
    debugFeed($cid);
} else {
    items($cid,$title,$iid,$y,$m,$d);
}
rss_footer();


function items($cid,$title,$iid,$y,$m,$d) {
    echo "\n\n<div id=\"items\" class=\"frame\">";    
    markReadForm($cid);

    $sql = " select i.title, i.url, i.description, i.unread, "
      ." if (i.pubdate is null, unix_timestamp(i.added), unix_timestamp(i.pubdate)) as ts, "
      ." pubdate is not null as ispubdate, "
      ." c.icon, c.title, i.id "
      ." from item i, channels c "
      ." where i.cid = $cid and c.id = $cid ";

    
    if ($iid != "") {
	$sql .= " and i.id=$iid";
    }
    

    
    if  (isset($_REQUEST['unread']) && $iid == "") {
      $sql .= " and unread=1 ";
    }
    
    if ($m > 0 && $y > 0) {
	$sql .= " and if (i.pubdate is null, month(i.added)= $m , month(i.pubdate) = $m) "
	  ." and if (i.pubdate is null, year(i.added)= $y , year(i.pubdate) = $y) ";
	
	if ($d > 0) {
	    $sql .= " and if (i.pubdate is null, dayofmonth(i.added)= $d , dayofmonth(i.pubdate) = $d) ";
	}
    }
    
    $sql .=" order by i.added desc, i.id asc";

      

    if ( $m==0 && $y==0 ) {
	$sql .= " limit " .ITEMS_ON_CHANNELVIEW;
    }

    

    $res = rss_query($sql);    
    $items = array();
        
    $iconAdded = false;
      
    
    while (list($ititle, $iurl, $idescription, $iunread, $its, $iispubdate, $cicon, $ctitle, $iid) =  rss_fetch_row($res)) {
      	$items[]=array($cid, $ctitle, $cicon, $ititle,$iunread,$iurl,$idescription, $its, $iispubdate, $iid);
      	if (! $iconAdded && defined('USE_FAVICON') && USE_FAVICONS && $cicon != "") {
      	    $iconAdded = true;
      	     $title = ("<img src=\"$cicon\" class=\"favicon\" alt=\"\"/>" . $title);
      	}
    }
    
    
    
    $shown = itemsList($title, $items, IL_CHANNEL_VIEW);
    
    
    $sql = "select count(*) from item where cid=$cid and unread=1";
    $res2 = rss_query($sql);
    list($unread_left) = rss_fetch_row($res2);

    $sql = "select count(*) from item where cid=$cid";
    $res2 = rss_query($sql);
    list($allread) = rss_fetch_row($res2);
    
    /** read more navigation **/
    $readMoreNav = "";
    /*
    if ($unread_left > 0 && !isset($_REQUEST['unread']) && $shown < $unread_left) {
        if (ITEMS_ON_CHANNELVIEW < $unread_left) {
            $readMoreNav .= "<a href=\"". getPath() . "feed.php?channel=$cid&amp;all&amp;unread\">" . sprintf(SEE_ALL_UNREAD,$unread_left) . "</a>";
        } else { 
            $readMoreNav .=  "<a href=\"". getPath() . "feed.php?channel=$cid&amp;all&amp;unread\">". sprintf(SEE_ONLY_UNREAD,$unread_left) ."</a>";
        }
    }
    
    if ((!isset($_REQUEST['unread'])) 
	//&& $shown < $allread
	) {

	// month view.
	$sql = "select "
	  ." if (i.pubdate is null, dayofmonth(i.added), dayofmonth(i.pubdate)) as d, count(*) "
	  ." from item i where i.cid=$cid and "
	  ." if (i.pubdate is null, month(i.added)=$m, month(i.pubdate)=$m) and "
	  ." if (i.pubdate is null, year(i.added)=$y, year(i.pubdate)=$y) "
	  ." group by d "
	  ." order by d desc";

	//die($sql);
	$cal = rss_query($sql);

	if (($nr = rss_num_rows($cal)) > 0) {
	    $readMoreNav .=  "<table class=\"wide\"><tr><td colspan=\"$nr\">$m/$y</td></tr>\n<tr>";
	    
	    while (list($dd,$cc)=rss_fetch_row($cal)) {
		if ($dd == $d) {
		    $readMoreNav .= "<td class=\"active\">$dd ($cc)</td>\n";
		}else {		    		
		    $url = getPath(). $_REQUEST['channel'] . "/$y/$m/$dd/";
		    $readMoreNav .= "<td><a href=\"$url\">$dd ($cc)</a></td>\n";
		}
	    }
	    $readMoreNav .=  "\n</tr></table>\n";
	}
    }
     */
    
    $monthView = $dayView = false;
    if ($y > 0 && $m > 0 && $d > 0) {
	$dayView = true;
    } elseif ($y > 0 && $m > 0 && $d == 0) {
	$monthView = true;
    }
    	    
    if ($monthView || $dayView) {
	$ts = mktime(0,0,0,$m,$d,$y);
	$sql_succ = " select "
	  ." UNIX_TIMESTAMP( if (i.pubdate is null, i.added, i.pubdate)) as ts_, "
	  ." year( if (i.pubdate is null, i.added, i.pubdate)) as y_, "
	  ." month( if (i.pubdate is null, i.added, i.pubdate)) as m_, "
	  .(($dayView)?" dayofmonth( if (i.pubdate is null, i.added, i.pubdate)) as d_, ":"")
	  ." count(*) as cnt_ "
	  ." from item i  "
	  ." where cid=$cid "
	  ." and UNIX_TIMESTAMP(if (i.pubdate is null, i.added, i.pubdate)) > $ts "
	  ." group by y_,m_"
	  .(($dayView)?",d_ ":"")
	  ." order by ts_ asc limit 4";
	
	//	var_dump($sql_succ);
	
	$sql_prev = " select "
	  ." UNIX_TIMESTAMP( if (i.pubdate is null, i.added, i.pubdate)) as ts_, "
	  ." year( if (i.pubdate is null, i.added, i.pubdate)) as y_, "
	  ." month( if (i.pubdate is null, i.added, i.pubdate)) as m_, "
	  .(($dayView)?" dayofmonth( if (i.pubdate is null, i.added, i.pubdate)) as d_, ":"")
	  ." count(*) as cnt_ "
	  ." from item i  "
	  ." where cid=$cid "
	  ." and UNIX_TIMESTAMP(if (i.pubdate is null, i.added, i.pubdate)) < $ts "
	  ." group by y_,m_"
	  .(($dayView)?",d_ ":"")
	  ." order by ts_ desc limit 4";
	
	$res_prev = rss_query($sql_prev);
	$res_succ = rss_query($sql_succ);
	
	$mCount = (12 * $y + $m);
	$prev = $succ = null;
	while ($succ == null && $row=rss_fetch_assoc($res_succ)) {
	    if ($dayView) {
		if (mktime(0,0,0,$row['m_'],$row['d_'],$row['y_']) > $ts) {
		    $succ = array(
				  'y' => $row['y_'], 
				  'm' => $row['m_'], 
				  'd' => $row['d_'], 
				  'cnt' => $row['cnt_'], 
				  'ts' => $row['ts_']);
		}
	    } elseif($monthView) {		
		if (($row['m_'] + 12 * $row['y_']) > $mCount) {		    
		    $succ = array(
				  'y' => $row['y_'],
				  'm' => $row['m_'],
				  'cnt' => $row['cnt_'],
				  'ts' => $row['ts_']);		    
		}
		
	    }
	}
	
	
	while ($prev == null && $row=rss_fetch_assoc($res_prev)) {
	    if ($dayView) {
		if (mktime(0,0,0,$row['m_'],$row['d_'],$row['y_']) < $ts) {
		    $prev = array(
				  'y' => $row['y_'],
				  'm' => $row['m_'],
				  'd' => $row['d_'],
				  'cnt' => $row['cnt_'],
				  'ts' => $row['ts_']);
		}
	    } elseif($monthView) {
		if (($row['m_'] + 12 * $row['y_']) < $mCount) {
		    $prev = array(
				  'y' => $row['y_'],
				  'm' => $row['m_'],
				  'cnt' => $row['cnt_'],
				  'ts' => $row['ts_']);
		}
		
	    }
	}
	
		
	$escaped_title = preg_replace("/[^A-Za-z0-9\.]/","_",$_REQUEST['channel']);
	if($prev != null) {	    
	    $dlbl = date(($dayView?'F jS':'F Y'),$prev['ts']) . " (".$prev['cnt'].")";
	    $url = getPath() 
	      . "$escaped_title/"
	      .date(($dayView?'Y/m/d/':'Y/m/'),$prev['ts']);
	      
	    $readMoreNav .= "<a href=\"$url\" class=\"fl\">&larr;&nbsp;$dlbl</a>\n";
	}
	if($succ != null) {
	    $dlbl = date(($dayView?'F jS':'F Y'),$succ['ts']) . " (".$succ['cnt'].")";
	    $url = getPath()
	      . "$escaped_title/"
	      .date(($dayView?'Y/m/d/':'Y/m/'),$succ['ts']);
	    
	    /*
	    if ($readMoreNav) {
		$readMoreNav .= " | ";
	    }
	     * */
	    $readMoreNav .= "<a href=\"$url\" class=\"fr\">$dlbl&nbsp;&rarr;</a>\n";
	}	
    }
    
    
    
    if ($readMoreNav != "") {
	echo "<div class=\"readmore\">$readMoreNav";
	echo "<hr class=\"clearer\"/>\n</div>\n";
    }
    
    
    echo "</div>\n";
}

function markReadForm($cid) {
    $sql = "select count(*)  from item where cid=$cid and unread=1";
    $res=rss_query($sql);
    list($cnt) = rss_fetch_row($res);
    if($cnt > 0) {
    	echo "<form action=\"". getPath() ."feed.php\" method=\"post\" class=\"markread\">\n"
    	  ."\t<p><input type=\"submit\" name=\"action\" value=\"". MARK_CHANNEL_READ ."\"/>\n"
    //	  ."\t<input type=\"hidden\" name=\"all\"/>\n"
    //	  ."\t<input type=\"hidden\" name=\"unread\">\n"
    	  ."\t<input type=\"hidden\" name=\"channel\" value=\"$cid\"/></p>\n"
    	  ."</form>";
     }
}


function debugFeed($cid) {
    echo "<div id=\"items\" class=\"frame\">\n";
    $res = rss_query("select url from channels where id = $cid");
    list($url) = rss_fetch_row($res);
    $rss = fetch_rss ($url);
    echo "<pre>\n";
    echo htmlentities(print_r($rss,1));
    echo "</pre>\n";    
    echo "</div>\n";
}




?>
