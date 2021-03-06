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


require_once(dirname(__FILE__) . '/db.php');

class MysqliDB extends DB {

    // we could as well set this to private and use PHP5-syntax __construct for
    // the constructor, as Mysqli is only supported by PHP5, afaik.

    var $_db;

    function  MysqliDB() {
        parent::DB();
    }


    function DBConnect($dbserver, $dbuname, $dbpass) {
		
		if (class_exists('mysqli')) {
			$this -> _db = new mysqli($dbserver, $dbuname, $dbpass);
			$this -> _db -> query('set names utf8');
		} else {
			$this -> _db = false;
		}
        

        if(!$this -> _db) {
            die( "<h1>Error connecting to the database!</h1>\n"
                 ."<p>Have you edited dbinit.php and correctly defined "
                 ."the database username and password?</p>\n" );
        }
    }

    function DBSelectDB($dbname) {
        if (!$this -> _db -> select_db($dbname)) {
            die( "<h1>Error selecting the database!</h1>\n"
                 ."<p>Does your database exist?"
                 . "Have you edited dbinit.php and correctly defined "
                 ."the database username and password?</p>\n"
                 ."<p>Refer to the <a href=\"INSTALL\">INSTALL</a> document "
                 ."if in doubt</p>\n" );
        }
    }

    function rss_query ($query, $dieOnError=true, $preventRecursion=false) {
        $ret =  $this -> _db -> query($query);

        if ($error = $this -> rss_sql_error()) {
            $errorString = $this -> rss_sql_error_message();
        }

        // if we got a missing table error, look for missing tables in the schema
        // and try to create them
        if ($error == 1146 && !$preventRecursion && $dieOnError) {
            require_once(dirname(__FILE__) . '/../../init.php');
            rss_require('schema.php');
            checkSchema();
            return $this -> rss_query ($query, $dieOnError, true);
        }
        elseif ($error == 1054 && !$preventRecursion && $dieOnError) {
            if (preg_match("/^[^']+'([^']+)'.*$/",$errorString,$matches)) {
                require_once(dirname(__FILE__) . '/../../init.php');
                rss_require('schema.php');
                checkSchemaColumns($matches[1]);
                return $this -> rss_query ($query, $dieOnError, true);
            }
        }

        if ($error && $dieOnError) {
            die ("<p>Failed to execute the SQL query <pre>$query</pre> </p>"
                 ."<p>Error $error: $errorString</p>");
        }
        return $ret;
    }

    function rss_fetch_row($rs) {
        return  $rs -> fetch_row();
    }

    function rss_fetch_assoc($rs) {
        return $rs -> fetch_assoc();
    }
    function rss_num_rows($rs) {
        return $rs -> num_rows;
    }

    function rss_sql_error() {
        return $this -> _db -> errno;
    }

    function rss_sql_error_message () {
        return $this -> _db -> error;
    }

    function rss_insert_id() {
        return $this -> _db -> insert_id;
    }

    function rss_real_escape_string($string) {
        if (method_exists($this -> _db, 'real_escape_string')) {
            return $this -> _db -> real_escape_string($string);
        }
        elseif (method_exists($this -> _db, 'escape_string')) {
            return $this -> _db -> escape_string($string);
        }
        else {
            die("<p class=\"error\">Your PHP version doesn't meet Gregarius' minimal requirements, please consider upgrading!</p>");
        }
    }

    function rss_is_sql_error($kind) {
        switch ($kind) {
        case RSS_SQL_ERROR_NO_ERROR:
                return ($this -> rss_sql_error() == 0);
            break;
        case RSS_SQL_ERROR_DUPLICATE_ROW:
            return ($this -> rss_sql_error() == 1062);
            break;
        default:
            return false;
        }
    }
}
?>
