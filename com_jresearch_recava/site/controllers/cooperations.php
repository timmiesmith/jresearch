<?php
/**
* @version		$Id$
* @package		JResearch
* @subpackage	Cooperations
* @copyright	Copyright (C) 2008 Florian Prinz.
* @license		GNU/GPL
* This file implements the controller for all operations related to the management
* of staff members.
*/
define('_COOPERATION_IMAGE_MAX_WIDTH_', 400);
define('_COOPERATION_IMAGE_MAX_HEIGHT_', 400);

jimport('joomla.application.component.controller');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables'.DS.'cooperation.php');

/**
 * JResearch Cooperations Component Controller
 *
 */
class JResearchCooperationsController extends JController
{
	/**
	 * Initialize the controller by registering the tasks to methods.
 	 */
	function __construct()
	{
		parent::__construct();
		
		//Load additionally language files
		$lang = JFactory::getLanguage();
		$lang->load('com_jresearch.cooperations');
		
		// Task for edition of profile
		$this->registerTask('show', 'show');
		$this->registerTask('edit', 'edit');
		$this->registerTask('save','save');
		$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'cooperations');
		$this->addViewPath(JPATH_COMPONENT.DS.'views'.DS.'staff');
		$this->addViewPath(JPATH_COMPONENT.DS.'views'.DS.'member');

	}

	/**
	 * Default method, it shows the list of published staff members.
	 *
	 * @access public
	 */
	function display()
	{
		global $mainframe;
		
		//Get and use configuration
    	$params = $mainframe->getPageParameters('com_jresearch');
    	$limit = $params->get('cooperation_entries_per_page');
    	
		JRequest::setVar('limit', $limit);
		$limitstart = JRequest::getVar('limitstart', null);	
			
		if($limitstart === null)
			JRequest::setVar('limitstart', 0);
			
		
		$model =& $this->getModel('Cooperations', 'JResearchModel');
		$view =& $this->getView('Cooperations', 'html', 'JResearchView');
		$view->setModel($model, true);
		$view->display();
	}

	/**
	* Invoked when the visitant has decided to see a cooperation
	*/
	function show()
	{
		$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'teams');
		$model =& $this->getModel('Cooperation', 'JResearchModel');
		$teamModel =& $this->getModel('Team', 'JResearchModel');
		$view =& $this->getView('Cooperation', 'html', 'JResearchView');
		$view->setModel($model, true);
		$view->setModel($teamModel);
		$view->display();				
	}
	
	function edit()
	{
		global $mainframe;
		
		$cid = JRequest::getVar("id");

		$user =& JFactory::getUser();
		$view = &$this->getView('Cooperation', 'html', 'JResearchView');
		$model = &$this->getModel('Cooperation', 'JResearchModel');
		
		if($cid)
		{
			$coop = $model->getItem($cid);
			$user = &JFactory::getUser();

			//Check if it is checked out
			if($coop->isCheckedOut($user->get("id")))
			{
				$this->setRedirect('index.php?option=com_jresearch&controller=cooperations', JText::_('You cannot edit this item. Another user has locked it.'));
			}
			else
			{
				$coop->checkout($user->get("id"));
			}
		}
		
		$view->setModel($model, true);
		$view->setLayout('edit');
		$view->display();
	}
	
	function save()
	{
		global $mainframe;
	    if(!JRequest::checkToken())
		{
		    $this->setRedirect('index.php?option=com_jresearch');
		    return;
		}
		
		$db =& JFactory::getDBO();
		$coop = new JResearchCooperation($db);

		// Bind request variables
		$post = JRequest::get('post');

		$coop->bind($post);
		$coop->name = JRequest::getVar('name', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$coop->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);

		//Upload photo
		$fileArr = JRequest::getVar('inputfile', null, 'FILES');
		$del = JRequest::getVar('delete');
		
		JResearch::uploadImage(	$coop->image_url, 	//Image string to save
								$fileArr, 			//Uploaded File array
								'assets'.DS.'cooperations'.DS, //Relative path from administrator folder of the component
								($del == 'on')?true:false,	//Delete?
								 _COOPERATION_IMAGE_MAX_WIDTH_, //Max Width
								 _COOPERATION_IMAGE_MAX_HEIGHT_ //Max Height
		);
		
		// Validate and save
		if($coop->check())
		{
			if($coop->store())
			{
				$task = JRequest::getVar('task');

				//Specific redirect for specific task
				if($task == 'save')
					$this->setRedirect('index.php?option=com_jresearch&controller=cooperations', JText::_('The cooperation was successfully saved.'));
				elseif($task == 'apply')
					$this->setRedirect('index.php?option=com_jresearch&controller=cooperations&task=edit&cid[]='.$coop->id, JText::_('The cooperation was successfully saved.'));

				// Trigger event
				$arguments = array('cooperation', $coop->id);
				$mainframe->triggerEvent('onAfterSaveCooperationEntity', $arguments);

			}
			else
			{
				JError::raiseWarning(1, $coop->getError());
				$this->setRedirect('index.php?option=com_jresearch&controller=cooperations&task=edit&cid[]='.$coop->id, JText::_('JRESEARCH_SAVE_FAILED'));
			}
		}
		else
		{
			JError::raiseWarning(1, $coop->getError());
			$this->setRedirect('index.php?option=com_jresearch&controller=cooperations&task=edit&cid[]='.$coop->id);
		}

		//Reordering ordering of other cooperations
		$coop->reorder();
		
		//Unlock record
		$user =& JFactory::getUser();
		if(!$coop->isCheckedOut($user->get('id')))
		{
			if(!$coop->checkin())
				JError::raiseWarning(1, JText::_('JRESEARCH_UNLOCK_FAILED'));
		}
	}
}
?>