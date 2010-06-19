<?php
// Tag on content, a plugin for Gregarius
// Copyright (C) 2006  Ludovic Perrine <jazz@fr.fm>
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

/// Name: Go to item top
/// Author: Ludovic Perrine
/// Description: Add a link on bottom of each item to go to the top of the item.
/// Version: 0.1

// History:
//
// 0.1: Initial release

function __gotoitemtop_addTopAnchor($id)
{
  echo "<a name=\"item_$id\" />";
  return $id;
}

function __gotoitemtop_addBottomLink($item)
{
  $id = $item->id;
  $item->description .= "<br><a href=\"#item_$id\">".__("Top")."</a>";
  return $item;
}

rss_set_hook('rss.plugins.items.beforetitle', '__gotoitemtop_addTopAnchor');
rss_set_hook('rss.plugins.items.beforerender','__gotoitemtop_addBottomLink');

?>