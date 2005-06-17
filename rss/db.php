<?
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


rss_connect(DBSERVER,DBUNAME,DBPASS);
rss_select_db(DBNAME);

//// The following are just wrappers of their mysql counterpart for now
//// maybe one day I shall support other rdbms and add some differentiation
//// in here.

function rss_connect($dbserver, $dbuname, $dbpass) {
	 if (!mysql_connect($dbserver, $dbuname, $dbpass)) {
		  die( "<h1>Error connecting to the database!</h1>\n"
				 ."<p>Have you edited dbinit.php and correctly defined "
				 ."the database username and password?</p>\n" );		  
    }
}

function rss_select_db($dbname) {
    if (!mysql_select_db($dbname)) {
		  die( "<h1>Error connecting to the database!</h1>\n"
				 ."<p>Have you edited dbinit.php and correctly defined "
				 ."the database username and password?</p>\n"
				 ."<p>Refer to the <a href=\"INSTALL\">INSTALL</a> document "
				 ."if in doubt</p>\n" );
    }
}

function rss_query ($query, $dieOnError=true, $preventRecursion=false) {
	 $ret =  mysql_query($query);

	 if ($error = rss_sql_error()) {
		  $errorString = rss_sql_error_message();
	 }

	 // if we got a missing table error, look for missing tables in the schema
	 // and try to create them
	 if ($error == 1146 && !$preventRecursion && $dieOnError) {
		  rss_require('schema.php');
		  checkSchema();
		  return rss_query ($query, $dieOnError, true);
	 } elseif ($error == 1054 && !$preventRecursion && $dieOnError) {
		  if (preg_match("/^[^']+'([^']+)'.*$/",$errorString,$matches)) {
				rss_require('schema.php');
				checkSchemaColumns($matches[1]);
				return rss_query ($query, $dieOnError, true);
		  }
	 }

    if ($error && $dieOnError) {
		  die ("<p>Failed to execute the SQL query <pre>$query</pre> </p>"
				 ."<p>Error $error: $errorString</p>");
	 }
	 return $ret;
}

function rss_fetch_row($rs) {
    return  mysql_fetch_row($rs);
}

function rss_fetch_assoc($rs) {
    return mysql_fetch_assoc($rs);
}
function rss_num_rows($rs) {
    return mysql_num_rows($rs);
}

function rss_sql_error() {
	 return mysql_errno();
}

function rss_sql_error_message () {
	 return mysql_error();
}

function rss_insert_id() {
    return mysql_insert_id();
}

function rss_real_escape_string($string) {
	 if (function_exists('mysql_real_escape_string')) {
		  return mysql_real_escape_string($string);
	 } elseif (function_exists('mysql_escape_string')) {
		  return mysql_escape_string($string);
	 } else {
		  die( rss_error("Your PHP version doesn't meet Gregarius' minimal requirements, please consider upgrading!", true));
	 }
}

function getTable($tableName) {
    if (defined('DB_TABLE_PREFIX') && "" != DB_TABLE_PREFIX) {
		  return (" " . DB_TABLE_PREFIX . "_" . $tableName . " ");
    } else {
		  return (" $tableName ");
    }
}

?>
