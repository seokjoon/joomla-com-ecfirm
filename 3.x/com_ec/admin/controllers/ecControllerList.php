<?php /** @package ecfirm.net
* @copyright Copyright (C) kilmeny.net. All rights reserved.
* @license GNU General Public License version 2 or later. */
defined('_JEXEC') or die('Restricted access');



class EcControllerList extends JControllerAdmin	{
	protected $entity;
	protected $nameKey;
	//protected $option;

	/** Constructor.
	 * @param   array  $config	An optional associative array of configuration settings.
	 * @return  EcControllerList
	 * @see     JController
	 * @since   1.6 */
	public function __construct($config = array()) {
		parent::__construct($config);
		$classNameArray = explode('Controller', get_called_class());
		$this->entity = strtolower($classNameArray[1]);
		$this->nameKey = (substr($this->entity, -1) == 's') ?
			substr($this->entity, 0, -1) : $this->entity;
		//$this->option = 'com_' . strtolower($this->getName());
		$this->registerTask('offenable', 'enable');
		$this->registerTask('onenable', 'enable');
	}
	
	/** method to checked a list of items
	 * @return void */
	public function bool($attr = 'enable')	{
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		$user = JFactory::getUser();
		$ids = $this->input->get('cid', array(), 'array');
		$values = array('off'.$attr => 0, 'on'.$attr => 1);
		$task = $this->getTask();
		$value = JArrayHelper::getValue($values, $task, 0, 'int');
		foreach ($ids as $i => $id)	{
			if(!$user->authorise('core.edit.state', 
				'com_'.EcConst::getPrefix.$this->nameKey.'.'.$this->nameKey.'.'.(int)$id)) {
				unset($ids[$i]);
				JError::raiseNotice(403, 
					JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED')); 
			} 
		}
		if(empty($ids)) { 
			JError::raiseWarning(500, JText::_('JERROR_NO_ITEMS_SELECTED')); 
		} else {
			$model = $this->getModel($this->nameKey); 
			if(!$model->bool($ids, $value, $attr)) {
				JError::raiseWarning(500, $model->getError()); 
			} else {
				if($value == 1) $this->setMessage
					(JText::plural(JString::strtoupper($this->option)
						.'_ON_'.$attr.'_N', count($ids)));
				elseif($value == 0) $this->setMessage
					(JText::plural(JString::strtoupper($this->option)
						.'_OFF_'.$attr.'_N', count($ids))); 
			} 
		}		
		$this->setRedirect
			('index.php?option='.$this->option.'&view='.$this->view_list);
	}
	
	public function enable() { $this->bool('enable'); }
	
	public function getModel($name = '', $prefix = '', $config = array()) {
		if(empty($name)) $name = $this->nameKey;
		return parent::getModel($name, $prefix, $config);
	}
}