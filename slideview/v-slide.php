<?php
require_once FWOLFLIB . 'class/mvc-view.php';
require_once FWOLFLIB . 'class/smarty-fl/smarty-fl.php';
require_once P2R . 'm-gregarius.php';


/**
 * View of slideview mode
 *
 * @package		gregarius
 * @subpackage	slideview
 * @copyright	Copyright 2012-2013, Fwolf
 * @author		Fwolf <fwolf.aide+gregarius@gmail.com>
 * @license		http://www.gnu.org/licenses/lgpl.html LGPL V3
 * @since		2012-12-25
 */
class ViewSlide extends View {

	/**
	 * Gregarius object
	 * @var	object
	 */
	public $oGr = NULL;


	/**
	 * construct
	 * @param object	&$ctl	Caller controler object
	 */
	public function __construct (&$ctl) {
		unset($this->oGr);
		parent::__construct($ctl);

		// Assign js
		$this->aJs['JSON-js'] = '/js/json2.js';
		$this->aJs['jquery'] = '/js/jquery.js';

	} // end of func __construct


	/**
	 * New object: Gregarius
	 *
	 * @return	object
	 */
	protected function NewObjGr () {
		return new Gregarius();
	} // end of func NewObjGr


	/**
	 * New template object
	 *
	 * @return	object
	 * @see	$oTpl
	 */
	protected function NewObjTpl() {
		$o_smarty = new SmartyFl();
		$o_smarty->assign('P2R', P2R);
		return $o_smarty;
	} // end of func NewObjTpl


} // end of class ViewSlide
?>
