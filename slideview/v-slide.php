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

		// Assign css, js
		$this->aCss[] = array(P2R . 'tpl/loader/default.css.php', 'all');
		$this->aJs['JSON-js'] = '/js/json2.js';
		$this->aJs['jquery'] = '/js/jquery.js';

		if (empty($this->sAction))
			$this->sAction = 'default';

	} // end of func __construct


	/**
	 * Ajax: get item list
	 */
	public function AjaxItemList () {
		$ar = $this->oGr->GetItemList(array(
			'start'		=> GetGet('start', 0),
			'pagesize'	=> GetGet('pagesize', 0),
		));
		echo JsonEncodeUnicode($ar);
		exit(0);
	} // end of func AjaxItemList


	/**
	 * Ajax: toggle item stared
	 */
	public function AjaxItemToggleStared () {
		$ar = $this->oGr->ItemToggleStared(GetGet('id'));
		if (!empty($ar))
			echo JsonEncodeUnicode($ar);
		exit(0);
	} // end of func AjaxItemToggleStared


	/**
	 * Gen page default
	 *
	 * @return	string
	 */
	public function GenDefault () {
		return $this->oTpl->fetch('slideview.tpl');
	} // end of func GenDefault


	/**
	 * Gen menu: empty
	 *
	 * @return	string
	 */
	public function GenMenu () {
		return null;
	} // end of func GenMenu


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

		$o_smarty->setTemplateDir(array(
			'default'	=> 'tpl',
		));
		$o_smarty->setCompileDir(sys_get_temp_dir());
		$o_smarty->setCacheDir(sys_get_temp_dir());


		$o_smarty->assign('P2R', P2R);
		$o_smarty->assign('global', array(
			'css'	=> &$this->aCss,
			'js'	=> &$this->aJs,
		));
		$o_smarty->assign('gr', array(
			'pagesize'	=> $this->oGr->GetCfg('rss.output.frontpage.numitems'),
		));

		return $o_smarty;
	} // end of func NewObjTpl


} // end of class ViewSlide
?>
