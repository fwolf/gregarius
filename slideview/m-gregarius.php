<?php
require_once FWOLFLIB . 'class/mvc-module.php';
require_once FWOLFLIB . 'class/adodb.php';


/**
 * Gregarius module class
 *
 * @package		gregarius
 * @subpackage	slideview
 * @copyright	Copyright 2013, Fwolf
 * @author		Fwolf <fwolf.aide+gregarius.slideview@gmail.com>
 * @license		http://www.gnu.org/licenses/lgpl.html LGPL V3
 * @since		2013-01-22
 */
class Gregarius extends Module {


	/**
	 * construct
	 * @param object	$view	Caller view object
	 */
	public function __construct ($view = NULL) {
		parent::__construct($view);

		// Read some data from config.php
		$this->iPageSize = $this->GetCfg('rss.output.frontpage.numitems');

	} // end of func __construct


	/**
	 * Check auth data in cookie
	 *
	 * @param	string	$s_cookie
	 * @return	boolean
	 */
	public function AuthCheck ($s_cookie) {
		if (empty($s_cookie))
			return false;

		$ar = explode('|', $s_cookie);
		if (2 != count($ar))
			return false;

		$ar_db = $this->oDb->GetDataByPk(
			$this->aCfg['tbl_prefix'] . 'users'
			, $ar[0], array('password', 'ulevel'), 'uname');

		if (empty($ar_db)
			|| 99 != $ar_db['ulevel']
			|| md5($ar[1]) != $ar_db['password'])
			return false;

		return true;
	} // end of func AuthCheck


	/**
	 * Connect to db, using func defined in include file, check error here.
	 *
	 * <code>
	 * $s = array(type, host, user, pass, name, lang);
	 * type is mysql/sybase_ase etc,
	 * name is dbname to select,
	 * lang is db server charset.
	 * </code>
	 *
	 * Useing my extended ADODB class now, little difference when new object.
	 * @var array	$dbprofile	Server config array
	 * @return object			Db connection object
	 */
	protected function DbConn ($dbprofile) {
		//$conn = DbConn($s);
		$conn = new Adodb($dbprofile);
		$conn->Connect();

		if (0 !=$conn->ErrorNo())
		{
			// Display error
			$s = 'ErrorNo: ' . $conn->ErrorNo()
				. "<br />\nErrorMsg: " . $conn->ErrorMsg();
			//$this->oView->oCtl->ViewErrorDisp($s);
		}
		else
			return $conn;
	} // end of func DbConn


	/**
	 * Get Gregarius config
	 *
	 * @param	string	$key
	 * @return	mixed
	 */
	public function GetCfg ($key) {
		if (empty($key))
			return null;
		$rs = $this->oDb->ExecuteGenSql(array(
			'SELECT'	=> array(
				'v'	=> 'value_',
				'type_',
			),
			'FROM'		=> $this->aCfg['tbl_prefix'] . 'config',
			'WHERE'		=> array(
				'"' . $key . '" = key_',
			),
		));
		if (!empty($rs) && !$rs->EOF) {
			if ('array' == $rs->fields['type_'])
				return unserialize($rs->fields['v']);
			else
				return $rs->fields['v'];
		}
		else
			return null;
	} // end of func GetCfg


	/**
	 * Fix invalid html
	 *
	 * @param	string	$s_html
	 * @return	string
	 */
	public function HtmlFix ($s_html) {
		if (empty($s_html))
			return '';

		// Use htmLawed
		if (function_exists('htmLawed')) {
			$s_rs = htmLawed($s_html, array(
				// Allow dynamic CSS expression
				'css_expression'	=> 1,
				'style_pass'		=> 1,
				// Not strict to lower attribute value
				'lc_std_val'		=> 0,
				// Not remove tag non-strict in XHTML
				'make_tag_strict'	=> 0,
				// Allow all schemes
				'schemes'			=> '*',
				// 1tab for indent, \n for line break
				'tidy'				=> '1t1n',
				// Not Check id for unique
				'unique_ids'		=> 0,
			));
		}

		// Use inner class DOMDocument
		elseif (class_exists('DOMDocument')) {
			static $o_dom = null;
			if (is_null($o_dom))
				$o_dom = new DOMDocument;
			$s_header = '<html><head>
				<meta http-equiv="Content-Type"
					content="text/html; charset=UTF-8" />
			';
			$o_dom->loadHTML($s_header . $s_html);
			$s_rs = $o_dom->saveXML();
			// Remove uselsss part
			$s_rs = substr($s_rs, 256);
			$s_rs = substr($s_rs, 0, -15);
		}

		return $s_rs;
	} // end of func HtmlFix


	/**
	 * Get Gregarius item list
	 *
	 * @param	array	$ar_cfg
	 * @return	array
	 */
	public function ItemList ($ar_cfg = array()) {
		// Treat config param
		if (empty($ar_cfg['pagesize']))
			$ar_cfg['pagesize'] =
				$this->GetCfg('rss.output.frontpage.numitems');

		$ar_sql = array(
			'SELECT'	=> array(
				'i.id',
				'i.added',
				'i.title',
				'i.url',
				'i.description',
				'i.unread',
				'pubdate'	=> 'i.pubdate',
				'c_id'		=> 'c.id',
				'c_title'	=> 'c.title',
				'c_siteurl'	=> 'c.siteurl',
			),
			'FROM'		=> array(
				'i'	=> $this->aCfg['tbl_prefix'] . 'item',
				'c'	=> $this->aCfg['tbl_prefix'] . 'channels',
			),
			'WHERE'		=> array(
				'i.cid = c.id',
				// Unread only
				RSS_MODE_UNREAD_STATE . ' & i.unread',
				// Not deleted
				'NOT (' . RSS_MODE_DELETED_STATE . ' & i.unread)',
				// Channel not deprecated
				'NOT (' . RSS_MODE_DELETED_STATE . ' & c.mode)',
			),
			// Same with original Gr, but not good for find start point below
//			'ORDERBY'	=> 'IFNULL(i.pubdate, i.added) DESC',
			// Order by id is more simple
			'ORDERBY'	=> 'i.id DESC',
			'LIMIT'		=> $ar_cfg['pagesize'],
		);
		if (!empty($ar_cfg['start']))
			$ar_sql['WHERE'][] = 'i.id < ' . $ar_cfg['start'];
		$ar_sql = array_merge($ar_sql, $ar_cfg);

		$rs = $this->oDb->ExecuteGenSql($ar_sql);
		if (empty($rs) || $rs->EOF)
			return null;
		else {
			// Adodb::GetAssoc() will got useless numberic index
			$ar = array();
			while (!$rs->EOF) {
				// Use item.id as array index will cause sort problem
				// when JSON.parse(), so not assign index,
				// the result keep native order same with db query.
				$ar_t = $rs->GetRowAssoc(false);

				// Convert flag column
				$ar_t['stared'] = intval($ar_t['unread'])
					& RSS_MODE_STICKY_STATE;

				// Purify html in description
				$ar_t['description'] = $this->HtmlFix($ar_t['description']);

				$ar[] = $ar_t;
				$rs->MoveNext();
			}
			return $ar;
		}
	} // end of func ItemList


	/**
	 * Toggle item readed
	 *
	 * @param	int		$id
	 * @param	int		$unread			Direct set to this value
	 * @return	array
	 */
	public function ItemToggleReaded ($id, $unread = null) {
		if (empty($id))
			return null;

		$ar = array(
			'id'	=> $id,
		);
		// Retrieve data
		$i_unread = $this->oDb->GetDataByPk(
			$this->aCfg['tbl_prefix'] . 'item', $id, 'unread', 'id');
		if (is_null($i_unread))
			return null;

		if (is_null($unread)) {
			// Toggle
			$ar['unread'] = $i_unread ^ RSS_MODE_UNREAD_STATE;
		}
		else {
			// Set
			$ar['unread'] = $i_unread & (SET_MODE_READ_STATE | $unread);
		}

		// Save
		$this->oDb->Write($this->aCfg['tbl_prefix'] . 'item'
			, $ar, 'U');

		$ar['readed'] = $ar['unread'] & RSS_MODE_UNREAD_STATE;
		return $ar;
	} // end of func ItemToggleReaded


	/**
	 * Toggle item stared
	 *
	 * @param	int		$id
	 * @return	array
	 */
	public function ItemToggleStared ($id) {
		if (empty($id))
			return null;

		// Retrieve data
		$i_unread = $this->oDb->GetDataByPk($this->aCfg['tbl_prefix'] . 'item'
			, $id, 'unread', 'id');
		if (is_null($i_unread))
			return null;

		// Toggle
		$i_unread = $i_unread ^ RSS_MODE_STICKY_STATE;

		// Save
		$ar = array(
			'id'		=> $id,
			'unread'	=> $i_unread,
		);
		$this->oDb->Write($this->aCfg['tbl_prefix'] . 'item'
			, $ar, 'U');

		$ar['stared'] = $ar['unread'] & RSS_MODE_STICKY_STATE;
		return $ar;
	} // end of func ItemToggleStared


	/**
	 * Set default config.
	 *
	 * @return	object
	 */
	 protected function SetCfgDefault () {
		parent::SetCfgDefault();

		// Read original Gregarius config file
		require P2R . '../dbinit.php';

		// Db profile
		$this->aCfg['dbprofile'] = array(
			'type'	=> DBTYPE,
			'host'	=> DBSERVER,
			'user'	=> DBUNAME,
			'pass'	=> DBPASS,
			'name'	=> DBNAME,
			'lang'	=> 'utf-8',
		);

		// Other const may use later:
		if (defined('DB_TABLE_PREFIX'))
			$this->aCfg['tbl_prefix'] = DB_TABLE_PREFIX;
		else
			$this->aCfg['tbl_prefix'] = '';

		return $this;
	 } // end of func SetCfgDefault


} // end of class Gregarius
?>
