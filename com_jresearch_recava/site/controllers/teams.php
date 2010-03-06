<?php
/**
* @version		$Id$
* @package		JResearch
* @subpackage	Teams
* @copyright	Copyright (C) 2008 Florian Prinz.
* @license		GNU/GPL
* This file implements the controller for all operations related to the management
* of teams.
*/

jimport('joomla.application.component.controller');

class JResearchTeamsController extends JController
{
	public function __construct($config = array())
	{
		parent::__construct ($config);
		
		//Load additionally language files
		$lang = JFactory::getLanguage();
		$lang->load('com_jresearch.teams');
		
		// Task for edition of profile
		$this->registerTask('show', 'show');

		$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'teams');
		
		$this->addViewPath(JPATH_COMPONENT.DS.'views'.DS.'teams');
		$this->addViewPath(JPATH_COMPONENT.DS.'views'.DS.'team');
	}
	
	/**
	 * Default method, it shows the list of published staff members.
	 *
	 * @access public
	 */
	public function display()
	{
		global $mainframe;
		
		//Get and use configuration
    	$params = $mainframe->getPageParameters('com_jresearch');
    	$limit = $params->get('team_entries_per_page');
    	
		JRequest::setVar('limit', $limit);
		$limitstart = JRequest::getVar('limitstart', null);	
			
		if($limitstart === null)
			JRequest::setVar('limitstart', 0);
			
		$model =& $this->getModel('Teams', 'JResearchModel');
		$view =& $this->getView('Teams', 'html', 'JResearchView');
		$view->setModel($model, true);
		$view->display();
	}

	/**
	* Invoked when the visitant has decided to see a team
	*/
	public function show()
	{
		$model =& $this->getModel('Team', 'JResearchModel');
		$view =& $this->getView('Team', 'html', 'JResearchView');
		$view->setModel($model, true);
		$view->display();				
	}
}

?>