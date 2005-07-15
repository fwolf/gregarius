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

if (!defined('DBTYPE')) {
	define ('DBTYPE','mysql');
}

rss_require('cls/db/db.'.DBTYPE.'.php');
$dbcls = ucfirst(DBTYPE)."DB";
$GLOBALS['rss']->db = new $dbcls;


function rss_query ($query, $dieOnError=true, $preventRecursion=false) {
	return $GLOBALS['rss']->db->rss_query ($query, $dieOnError, $preventRecursion);
}

function rss_fetch_row($rs) {
    return  $GLOBALS['rss']->db->rss_fetch_row($rs);
}

function rss_fetch_assoc($rs) {
    return $GLOBALS['rss']->db->rss_fetch_assoc($rs);
}
function rss_num_rows($rs) {
    return $GLOBALS['rss']->db->rss_num_rows($rs);
}

function rss_sql_error() {
	 return $GLOBALS['rss']->db->rss_sql_errno();
}

function rss_sql_error_message () {
	 return $GLOBALS['rss']->db->rss_sql_error_message();
}

function rss_insert_id() {
    return $GLOBALS['rss']->db->rss_insert_id();
}

function rss_real_escape_string($string) {
	return $GLOBALS['rss']->db->rss_real_escape_string($string);
}

function getTable($tableName) {
	return $GLOBALS['rss']->db->getTable($tableName);
}

?>
