<?php
require_once FWOLFLIB . 'class/mvc-module.php';
require_once FWOLFLIB . 'class/adodb.php';
require P2R . '../constants.php';


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
	 * Get Gregarius item list
	 *
	 * @param	array	$ar_cfg
	 * @return	array
	 */
	public function GetItemList ($ar_cfg = array()) {
		// Treat config param
		if (empty($ar_cfg['pagesize']))
			$ar_cfg['pagesize'] =
				$this->GetCfg('rss.output.frontpage.numitems');

		$ar_sql = array(
			'SELECT'	=> array(
				'i.id',
//				'i.added',
				'i.title',
				'i.url',
				'i.description',
				'i.unread',
				'i.pubdate',
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
			'ORDERBY'	=> 'i.pubdate DESC',
			'LIMIT'		=> $ar_cfg['pagesize'],
		);
		$ar_sql = array_merge($ar_sql, $ar_cfg);

		$rs = $this->oDb->ExecuteGenSql($ar_sql);
		if (empty($rs) || $rs->EOF)
			return null;
		else {
			// Adodb::GetAssoc() will got useless numberic index
			$ar = array();
			while (!$rs->EOF) {
				$ar[$rs->fields['id']] = $rs->GetRowAssoc(false);
				$rs->MoveNext();
			}
			return $ar;
		}
	} // end of func GetItemList


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
