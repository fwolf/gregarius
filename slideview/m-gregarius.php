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
		$this->iPageSize = GetCfg('system.pagesize');

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
		// DB_TABLE_PREFIX

		return $this;
	 } // end of func SetCfgDefault


} // end of class Gregarius
?>
