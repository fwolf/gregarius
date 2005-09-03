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
###############################################################################


require_once('init.php');

function __exp__setState($id,$state) {
	if (!hidePrivate()) {
		rss_query('update '.getTable('item') . " set unread=$state where id=$id");	
	}
    $rs = rss_query('select unread from '.getTable('item') . " where id=$id");
    list($unread) = rss_fetch_row($rs);
    return "$id|$unread";
}

function __exp__getSideContent($what) {
	ob_start();
	switch ($what) {
		case '0':
			$f = new FeedList(false);
			$f -> render();
			break;

		case '1':
			//rss_require('cls/taglist.php');
			//$v = new TagList('channel');
			rss_require('cls/categories.php');
			$v = new CatList();
			$v -> render();
			break;

		case '2':
			rss_require('cls/taglist.php');
			$t = new TagList('item');
			$t -> render();
			break;
	}
	$c = ob_get_contents();
	ob_end_clean();
	return ($what . "#@#" .$c);
}

function __exp__getFeedContent($cid) {

	
	ob_start();
	rss_require('cls/items.php');
	
	$readItems = new ItemList();

	$readItems -> populate(" not(i.unread & ". FEED_MODE_UNREAD_STATE  .") and i.cid= $cid", "", 0, 2);
	$readItems -> setTitle(LBL_H2_RECENT_ITEMS);
	$readItems -> setRenderOptions(IL_TITLE_NO_ESCAPE);
	foreach ($readItems -> feeds[0] -> items as $item) {
		$item -> render();
	}
	$c = ob_get_contents();
	
	ob_end_clean();
	return "$cid|@|$c";
}

function __exp__rateItem($iid, $rt) {
	list($rrt) = rss_fetch_row(rss_query("select rating from "
	    .getTable('rating') . " where iid = $iid"));

	rss_query('delete from ' .getTable('rating') . ' where iid = ' . $iid);
	if ($rt == $rrt) {
		return ("$iid|0");
	}
	rss_query('insert into ' .getTable('rating') . "(iid,rating) values ($iid,$rt)");
	if (rss_is_sql_error(RSS_SQL_ERROR_NO_ERROR)) {
		return ("$iid|$rt");
	}
}

/** 
 * this exported AJAX method is only here so that the plugin callback
 * hook is asynchronous 
 */
function __exp_itemRatedCB($iid,$rt) {
	rss_plugin_hook("rss.plugins.rating.rated",array($iid,$rt));
	return null;
}

$sajax_request_type = "POST";
$sajax_debug_mode = 0;
$sajax_remote_uri = getPath() . basename(__FILE__);

// Non standard! One usually calls sajax_export() ...
$sajax_export_list = array("__exp__submitTag","__exp__getSideContent","__exp__getFeedContent");

// Plugins shall export ajax functions as well
$sajax_export_list = rss_plugin_hook("rss.plugins.ajax.exports",$sajax_export_list);


if (!hidePrivate()) {
    $sajax_export_list[] = "__exp__setState";
    $sajax_export_list[] = "__exp__rateItem";
    $sajax_export_list[] = "__exp_itemRatedCB";
}

sajax_init();

//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////

/* spit out the javascript for this bugger */
if (array_key_exists('js',$_GET)) {

    $js = sajax_get_javascript();
    
    // The javascript output shall be cached
    $etag = md5($js.'$Revision$');
    ETagHandler($etag);
    echo $js;

    // and here is s'more javascript for field editing...
    ?>

/// End Sajax javscript
/// From here on: Copyright (C) 2003 - 2005 Marco Bonetti, gregarius.net
/// Released under GPL

function setTags(id,tagss) {
  tags = tagss.split(' ');

  var fld=document.getElementById("t" + id);
  var html = "";
  for (i=0;i<tags.length;i++) {
     html = html + "<a href=\"<?= getPath()
     . (getConfig('rss.output.usemodrewrite')?'tag/':'tags.php?tag=')
     ?>" + tags[i] + "\">" + tags[i] + "</a> ";
  }
  fld.innerHTML = html;

  var aspan=document.getElementById("ta" + id);
  aspan.innerHTML = "<a href=\"#\" onclick=\"_et(" +id +"); return false;\"><?= LBL_TAG_EDIT ?></a>";
}

function submit_tag_cb(ret) {
    data= ret.replace(/[^a-zA-Z0-9\ _\.,]/gi,"").split(',');
    id=data[0];
    tags=data[1];
    setTags(id,tags);
}

function submit_tag(id,tags) {
    x___exp__submitTag(id, tags, submit_tag_cb);
}

function _et(id) {
   var actionSpan = document.getElementById("ta" + id);
    var toggle = actionSpan.firstChild;
    if (toggle.innerHTML == "<?= LBL_TAG_SUBMIT ?>") {
        var fld = document.getElementById("tfield" + id);
      toggle.innerHTML="<?= LBL_TAG_SUBMITTING ?>";
        submit_tag(id,fld.value);
    } else if (toggle.innerHTML == "<?= LBL_TAG_EDIT ?>") {
       var isIE=document.all?true:false;
       // the tag container
       var tc=document.getElementById("t"+id);
        var tags = tc.innerHTML.replace(/<\/?a[^>]*>(\ $)?/gi,"").replace(<?=ALLOWED_TAGS_REGEXP ?>gi,"");
        // submit link
        toggle.innerHTML="<?= LBL_TAG_SUBMIT ?>";
        // cancel link
        cancel = document.createElement("a");
        cancel.style.margin="0 0 0 0.5em";
        cancel.innerHTML = "<?= LBL_TAG_CANCEL ?>";
        cancel.setAttribute("href","#");
        if (isIE) {
            // the IE sucky way
            cancel.onclick = function() { setTags(id,tags); return false;}
       } else {
          // the proper DOM way
            cancel.setAttribute("onclick","setTags("+id+",'"+tags+"'); return false;");
       }
        actionSpan.appendChild(cancel);

		  <?php rss_plugin_hook("rss.plugins.ajax.extrajs.edittag",null); ?>
		  
        tc.innerHTML = "<input class=\"tagedit\" id=\"tfield"
         +id+"\" type=\"text\" value=\"" + tags + "\" />";

        // set the caret to the end of the field for bloody IE
        var control = tc.firstChild;
        control.focus();
        if (control.createTextRange) {
            var range = control.createTextRange();
        range.collapse(false);
            range.select();
        } else if (control.setSelectionRange) {
            control.focus();
            var length = control.value.length;
            control.setSelectionRange(length, length);
        }
    }
    return false;
}


cs = getCookie('side');
if (!cs) {
	cs = '1';
}
document.currentSide = cs;
document.currentSideCache = new Array();
for (i=0;i<3;i++) {
	document.currentSideCache[i] = null;
}


function _side(what) {
	if (document.currentSide == what) {
		return 0;
	} 
	
	document.currentSideCache[document.currentSide] = document.getElementById('channels').innerHTML;
	if ((content = document.currentSideCache[what]) != null) {	
		_setSideContent_cb( what + "#@#" + content );
	} else {
		x___exp__getSideContent(what, _setSideContent_cb);
	}
}

function _setSideContent_cb(ret) {
 	data=ret.split('#@#');
 	kind=data[0];
 	content=data[1];
	c = document.getElementById('channels').innerHTML;
	
	for (i=0;i<3;i++) {
		if (i == kind) {
			document.getElementById('sidemenu'+i).className = "active";
		} else {
			document.getElementById('sidemenu'+i).className = "";
		}
	}
	document.currentSide = kind;
	document.currentSideCache[kind] = content;
	document.getElementById('channels').innerHTML = content;
	setCookie("side",kind, "<?= getPath() ?>");
}



// feed collapsing
function _ftgl(cid) {
	cids = getCookie('collapsedfeeds');
	if (cids) {
		cidsArr = cids.split(":");
	} else {
		cidsArr = new Array();
	}
	
	var ul = document.getElementById('f'+cid);
	var img = document.getElementById('cli'+cid);
	var collapsed  = (img.parentNode.className == 'expand');
	
	if (collapsed) {
		img.src = img.src.replace(/plus/g,'minus');
		img.parentNode.className = "collapse";
		img.parentNode.parentNode.className="";
		for(i=0;i<cidsArr.length;i++) {
			if (cidsArr[i] == cid) {
				cidsArr[i] = -1;
			}
		}
		if (ul.style.display == "none") {
			ul.style.display = "block";
		} else {
			ul.innerHTML = "...";
			x___exp__getFeedContent(cid, get_feed_content_cb);
		}
	} else {
		img.src = img.src.replace(/minus/g,'plus');
		img.parentNode.className = "expand";
		img.parentNode.parentNode.className="collapsed";
		ul.style.display = "none";
		cidsArr[cidsArr.length]=cid;
	}
	
	cidsArr.sort();
	cidsCookie = "";
	for (i=0;i<cidsArr.length;i++) {
		if (cidsArr[i] > 0) {
			cidsCookie = cidsCookie + cidsArr[i];
			if (i<cidsArr.length -1) {
				cidsCookie += ":";
			}
		}
	}
	setCookie('collapsedfeeds',cidsCookie, "/");
}


function get_feed_content_cb(data) {
	d=data.split('|@|');
	cid=d[0];
	html=d[1];
	if (cid) {
		ul = document.getElementById('f'+cid);
		if (ul) {
			ul.innerHTML = html;
			ul.style.display = "block";
		}
	}
}

<?php rss_plugin_hook("rss.plugins.ajax.extrajs.public",null); ?>

<?php if (! hidePrivate()) { ?>

<?php rss_plugin_hook("rss.plugins.ajax.extrajs.private",null); ?>

document.states = new Array();
document.prevState = new Array();


function setState(id,state) {
    x___exp__setState(id,state,setState_cb);
}

function setItemClass(id,cls) {
    if ((a=document.getElementById('sa'+id)) && (li=a.parentNode)) {
        li.className=cls;
    }
}

function fade(id,amount) {
    if ((a=document.getElementById('sa'+id)) && (li=a.parentNode)) {
        li.style.opacity=amount;
        li.style.height = amount*li.style.height;
        if (amount <= 0) {
            li.parentNode.removeChild(li);
        }
    }
}

function setItemHide(id, redirect){
    if ((a=document.getElementById('sa'+id)) && (li=a.parentNode)) {
       ul = li.parentNode;
       
       if (false) {
        // do funky tuff
        for (i=5;i>=0;i--) {
            window.setTimeout('fade('+id+','+(2*i)/10+')', 100*(5-i));
        }
       } else {
         trash = ul.removeChild(li);
       }
       
       // remove parent elements (heading, ul) if all the children are gone
       if (ul.getElementsByTagName('li').length == 0) {
       	pn = ul.parentNode;
       	
       	var ps = ul.previousSibling;
       	while ( ps = ps.previousSibling ) {
            if ("H3" == ps.nodeName.toUpperCase()) {
                trash=ps.parentNode.removeChild(ps);
                break;
            }
        }
       	trash = pn.removeChild(ul);
       }
       
       if (redirect) {
        document.location = '<?= getPath() ?>';
       }
    }
}

function setState_cb(ret) {
    data=ret.replace(/[^0-9\|]/gi,"").split('|');
    id=data[0];
    s=data[1];
    document.states[id]=s;
    _ces(id);
}

function _es(id, state) {
	if (document.prevState[id] != null) {
	   // if we click the edit icon while editing cancel the edit
	   _ces(id);
	   document.prevState[id] = null;
	   return;
	}
	 
    if (document.states[id]) {
        tmpState =document.states[id];
    } else {
        tmpState =state;
    }
    document.prevState[id] = tmpState;
	if (div = document.getElementById('sad'+id)) {


	onOk = '<?= rss_plugin_hook("rss.plugins.ajax.admindlg.onok",null); ?>'.replace(/_ID_/g,id);
	onCancel = '<?= rss_plugin_hook("rss.plugins.ajax.admindlg.oncancel",null); ?>'.replace(/_ID_/g,id);
	extraCode = '<?= rss_plugin_hook("rss.plugins.ajax.admindlg",null); ?>'.replace(/_ID_/g,id);
	
	if (!onOk) {
        onOk = '_ses('+id+'); return false;';
    }
    if (!onCancel) {
        onCancel = '_ces('+id+'); return false;';
    }
	if (!extraCode) {
	   extraCode = '';
	}
   	div.innerHTML = ''
   		+ '<form class="sf" id="sf"'+id+'" action="#" method="post">'
   		+ '<p><input type="checkbox" id="sf' + id + 'u" value="1"'
   		+ (tmpState & <?= FEED_MODE_UNREAD_STATE ?> ?' checked="checked"':'')
   		+ ' />'
		+ '<label for="sf' + id + 'u"><?= LBL_STATE_UNREAD ?></label></p>'
   		+ '<p><input type="checkbox" id="sf' + id + 's" value="1"'
   		+ (tmpState & <?= FEED_MODE_STICKY_STATE ?> ?' checked="checked"':'')
   		+ ' />'
		+ '<label for="sf' + id + 's"><?= LBL_STATE_STICKY ?></label></p>'
   		+ '<p><input type="checkbox" id="sf' + id + 'p" value="1"'
   		+ (tmpState & <?= FEED_MODE_PRIVATE_STATE ?> ?' checked="checked"':'')
   		+ ' />'
		+ '<label for="sf' + id + 'p"><?= LBL_STATE_PRIVATE ?></label></p>'
		+ extraCode
		+ '<p class="sbm">'
		+ '<a id="ess'+id+'ok" href="#" onclick="'+onOk+'"><?= LBL_ADMIN_OK ?></a>'
		+ '<a href="#" onclick="'+onCancel+'"><?= LBL_ADMIN_CANCEL ?></a></p>'
   		+ '</form>';

    div.className = 'ief';
    div.style.display = "block";
   }
}

function _ces(id) {
	if (div = document.getElementById('sad'+id)) {
		div.className = '';
		div.innerHTML = '';
		div.style.display='none';
	}
	
	if (sa = document.getElementById('sa' + id)) {
        sa.focus();
    }

}

function _ses(id) {
    s = 0;
    if ((sfu = document.getElementById('sf'+id+'u')) && sfu.checked) {
      s += <?= FEED_MODE_UNREAD_STATE ?>;
    }
    if ((sfs = document.getElementById('sf'+id+'s')) && sfs.checked) {
      s += <?= FEED_MODE_STICKY_STATE ?>;
    }
    if ((sfp = document.getElementById('sf'+id+'p')) && sfp.checked) {
      s += <?= FEED_MODE_PRIVATE_STATE ?>;
    }
    
    

    if ((p=document.prevState[id]) != s) {
        if ((s & <?= FEED_MODE_UNREAD_STATE ?>) != (p & <?= FEED_MODE_UNREAD_STATE ?>)) {
            if (s & <?= FEED_MODE_UNREAD_STATE ?>) {
                setItemClass(id,'item unread');
                c=unreadCnt(1);
            } else {
                c = unreadCnt(-1);
				if ((sel = document.getElementById('<?= SHOW_WHAT ?>')) &&
				    sel.options[sel.selectedIndex].value == <?= SHOW_UNREAD_ONLY ?>) {
                        setItemHide(id, (c==0));
				} else{ 
				        setItemClass(id, 'item even');				     
				}
            }
        }
        if (btn=document.getElementById('ess'+id+'ok')) {
            btn.innerHTML = '...';
            btn.disabled = true;
        }
        document.prevState[id] = null;
        setState(id,s);
    } else {
      // state didn't change!
      _ces(id);
    }
}

function unreadCnt(d) {
    if (span = document.getElementById('ucnt')) {
        if (c = span.innerHTML.replace(/[^0-9]+/g,"")) {
            c = d+eval(c);
            span.innerHTML = span.innerHTML.replace(/[0-9]+/g,c);
        }
        return c;
    }
    return null;
}

function _rt(id,rt) {
	 x___exp__rateItem(id,rt,rateItem_cb);
}

function rateItem_cb(ret) {
	data=ret.replace(/[^0-9\|]/gi,"").split('|');
	id = data[0];
	rt = data[1];
	if (id && rt) {
		
		ul = document.getElementById("rr" + id);
		lis = ul.getElementsByTagName('li');
		for (i=0;i<lis.length;i++) {
			var li = lis[i];
			if ((i+1) == rt) {
				li.className = "current";
			} else {
             li.className = "";
			}
		}
		x___exp_itemRatedCB(id,rt,itemRatedCB_cb);
	}
}
function itemRatedCB_cb(data) {}

<?php }

flush();
exit();
    
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////

} elseif(array_key_exists('rs',$_REQUEST)) {
    // this one handles the xmlhttprequest call from the above javascript
    sajax_handle_client_request();
    exit();
}

//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
?>
