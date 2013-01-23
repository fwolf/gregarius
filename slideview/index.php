<?php
if (!defined('P2R')) define('P2R', './');
@include 'fwolflib/fwolflib.php';
if (!defined('FWOLFLIB'))
	die('Fwolflib needed, download from http://github.com/fwolf/fwolflib
   		and put in your PHP include path.');
@include 'smarty/Smarty.class.php';
if (!class_exists('Smarty'))
	die('Smarty v3 needed, put it\'s libs/ dir under include path
		and rename to \'smarty\'.');
require_once FWOLFLIB . 'class/mvc-controler.php';


/**
 * Site index
 *
 * @package		gregarius
 * @subpackage	slideview
 * @copyright	Copyright 2012-2013, Fwolf
 * @author		Fwolf <fwolf.aide+gregarius@gmail.com>
 * @license		http://www.gnu.org/licenses/lgpl.html LGPL V3
 * @since		2012-12-25
 */
class IdxRoot extends Controler {


	/**
	 * User call starter function
	 */
	public function Go() {
		require P2R . 'v-slide.php';
	} // end of func Go


	/**
	 * Disp error msg
	 *
	 * @param	string	$msg
	 */
	public function ViewErrorDisp ($msg) {
	} // end of func ViewErrorDisp


} // end of class IdxRoot

$idx_root = new IdxRoot();
$idx_root->Go();
?>
