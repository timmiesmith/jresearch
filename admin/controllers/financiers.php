<?php
/**
* @version		$Id$
* @package		JResearch
* @subpackage	Financiers
* @copyright	Copyright (C) 2008 Florian Prinz.
* @license		GNU/GPL
* This file implements the controller for all operations related to the management
* of financiers in the backend interface.
*/

jimport('joomla.application.component.controller');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables'.DS.'financier.php');

class JResearchAdminFinanciersController extends JController
{
	function __construct($config = array())
	{
		parent::__construct ($config);
		
		$lang = JFactory::getLanguage();
		$lang->load('com_jresearch.financiers');
		
		$this->registerDefaultTask('display');
		$this->registerTask('add', 'edit');
		$this->registerTask('edit', 'edit');
		$this->registerTask('publish', 'publish');
		$this->registerTask('unpublish', 'unpublish');
		$this->registerTask('remove', 'remove');
		$this->registerTask('save', 'save');
		$this->registerTask('apply', 'save');
		$this->registerTask('cancel', 'cancel');

		$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'financiers');
		$this->addViewPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'financiers');
	}
	
	/**
	 * Default method, it shows the control panel for JResearch component.
	 *
	 * @access public
	 */
	function display()
	{
		$view = &$this->getView('Financiers', 'html', 'JResearchAdminView');
		$model = &$this->getModel('Financiers', 'JResearchModel');
		
		$view->setModel($model,true);
		$view->display();
	}

	function edit()
	{
		$cid = JRequest::getVar("cid");

		$view = &$this->getView('Financier', 'html', 'JResearchAdminView');
		$model = &$this->getModel('Financier', 'JResearchModel');

		if($cid)
		{
			$fin = $model->getItem($cid[0]);
			if(!empty($fin)){
				$user = &JFactory::getUser();
	
				//Check if it is checked out
				if($fin->isCheckedOut($user->get("id")))
				{
					$this->setRedirect('index.php?option=com_jresearch&controller=financier', JText::_('You cannot edit this item. Another user has locked it.'));
				}
				else
				{
					$fin->checkout($user->get("id"));
					$view->setModel($model,true);
					$view->display();
				}
			}else{
				JError::raiseWarning(1, JText::_('JRESEARCH_ITEM_NOT_FOUND'));
				$this->setRedirect('index.php?option=com_jresearch&controller=financiers');				
			}
			
		}
		else
		{
			$view->setModel($model,true);
			$view->display();
		}
	}

	function publish()
	{
		// Array of ids
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar('cid');

		$fin = new JResearchFinancier($db);
		$fin->publish($cid, 1);

		$this->setRedirect('index.php?option=com_jresearch&controller=financiers', JText::_('The items were successfully published'));
	}

	function unpublish()
	{
		// Array of ids
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar('cid');

		$fin = new JResearchFinancier($db);
		$fin->publish($cid, 0);

		$this->setRedirect('index.php?option=com_jresearch&controller=financiers', JText::_('The items were successfully unpublished'));
	}

	function remove()
	{
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar('cid');
		$n = 0;

		$fin = new JResearchFinancier($db);

		foreach($cid as $id)
		{
			if(!$fin->delete($id))
			{
				JError::raiseWarning(1, JText::sprintf('Financier with id %d could not be deleted', $id));
			}
			else
			{
				$n++;
			}
		}

		$this->setRedirect('index.php?option=com_jresearch&controller=financiers', JText::sprintf('%d successfully deleted.', $n));
	}

	function save()
	{
		global $mainframe;

		$db =& JFactory::getDBO();

		$fin = new JResearchFinancier($db);

		// Bind request variables
		$post = JRequest::get('post');

		$fin->bind($post);
		$fin->name = JRequest::getVar('name', '', 'post', 'string', JREQUEST_ALLOWRAW);

		// Validate and save
		if($fin->check())
		{
			if($fin->store())
			{
				$task = JRequest::getVar('task');

				//Specific redirect for specific task
				if($task == 'save')
					$this->setRedirect('index.php?option=com_jresearch&controller=financiers', JText::_('The financier was successfully saved.'));
				elseif($task == 'apply')
					$this->setRedirect('index.php?option=com_jresearch&controller=financiers&task=edit&cid[]='.$fin->id, JText::_('The financier was successfully saved.'));

				// Trigger event
				$arguments = array('financier', $fin->id);
				$mainframe->triggerEvent('onAfterSaveFinancierEntity', $arguments);

			}
			else
			{
				JError::raiseWarning(1, $fin->getError());
				$this->setRedirect('index.php?option=com_jresearch&controller=financiers&task=edit&cid[]='.$fin->id, JText::_('The information could not be saved.'));
			}
		}
		else
		{
			JError::raiseWarning(1, $fin->getError());
			$this->setRedirect('index.php?option=com_jresearch&controller=financiers&task=edit&cid[]='.$fin->id);
		}
		
		//Unlock record
		$user =& JFactory::getUser();
		if(!$fin->isCheckedOut($user->get('id')))
		{
			if(!$fin->checkin())
				JError::raiseWarning(1, JText::_(JRESEARCH_UNLOCK_FAILED));
		}
	}

	function cancel()
	{
		$id = JRequest::getInt('id');
		$model = &$this->getModel('Financier', 'JResearchModel');

		if($id != null)
		{
			$fin = $model->getItem($id);

			if(!$fin->checkin())
			{
				JError::raiseWarning(1, JText::_('The record could not be unlocked.'));
			}
		}

		$this->setRedirect('index.php?option=com_jresearch&controller=financiers');
	}
}

?>