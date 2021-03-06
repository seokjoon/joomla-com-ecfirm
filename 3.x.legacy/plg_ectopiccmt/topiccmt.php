<?php /** @package ecfirm.net
* @copyright	Copyright (C) ecfirm.net. All rights reserved.
* @license GNU General Public License version 2 or later. */
defined('_JEXEC') or die('Restricted access');



class PlgEcTopiccmt extends JPlugin {
	
	/**
	 * Load the language file on instantiation. Note this is only available in Joomla 3.1 and higher.
	 * If you want to support 3.0 series you must override the constructor
	 * @var    boolean
	 * @since  3.1 */
	protected $autoloadLanguage = true;
	
	//public function onTopicPrepareDisplay($context, &$item) { }
	
	//public function onTopicBeforeDisplay($context, &$item) { } 
	
	public function onTopicAfterDisplay($context, &$item) {
		$optionCom = 'com_ectopic';
		$nameKey = 'topiccmt';
		$nameCol = 'topic';
		$valueCol = $item->$nameCol;
		$params['optionCom'] = $optionCom;
		$params['nameKey'] = $nameKey.'s';
		$params['nameCol'] = $nameCol;
		$params['valueCol'] = $valueCol;
		$params['nameCols'] = array($nameCol);
		$params['task'] = 'show';
		$params['countKey'] = $item->$nameKey;
		return EcWidget::cmtSpan($params);
	}
}