<?php
/**
 * @package joomla.ecfirm.net
 * @copyright Copyright (C) joomla.ecfirm.net. All rights reserved.
 * @license GNU General Public License version 2 or later.
 */

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die('Restricted access');

abstract class EcViewLegacy extends HtmlView //JViewLegacy
{

	protected $context;

	protected $item;

	protected $optionCom;

	protected $nameKey;

	protected $params;

	protected $plural;
	
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->optionCom = Factory::getApplication()->input->get('option');
	}

	public function display($tpl = null)
	{
		$classNameArray = explode('View', get_called_class());
		$this->context = 'com_' . strtolower($classNameArray[0]) . '.' . $this->nameKey;
		$this->params = Factory::getApplication()->getParams(); //$this->get('State')->get('params);

		parent::display($tpl);
	}

	/**
	 * @desc: $this->nameKey to $this->getName()
	 */
	protected function eventPlugin($dispatcher, &$item)
	{
		$dispatcher->trigger('on' . ucfirst($this->getName()) . 'PrepareDisplay', array(
			$this->context,
			&$item
		));
		
		$item->event = new stdClass();
		
		$results = $dispatcher->trigger('on' . ucfirst($this->getName()) . 'BeforeDisplay', array(
			$this->context,
			&$item
		));
		
		$item->event->beforeDisplay = trim(implode($results));
		
		$results = $dispatcher->trigger('on' . ucfirst($this->getName()) . 'AfterDisplay', array(
			$this->context,
			&$item
		));
		
		$item->event->afterDisplay = trim(implode($results));
		
		return $item;
	}
}