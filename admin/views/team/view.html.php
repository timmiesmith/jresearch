<?php
/**
* @version		$Id$
* @package		JResearch
* @subpackage	Cooperations
* @copyright	Copyright (C) 2008 Florian Prinz.
* @license		GNU/GPL
* This file implements the view which is responsible for adding/editing a cooperation.
*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for management of members lists in JResearch Component backend
 *
 */

class JResearchAdminViewTeam extends JView
{
	function display($tpl = null)
	{
    	global $mainframe;
      	
      	JHTML::addIncludePath(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'helpers'.DS.'html');
		JHTML::_('Validator._');
    	JRequest::setVar( 'hidemainmenu', 1 );
    	$arguments = array('team');

    	// Information about the member
    	$cid = JRequest::getVar('cid');
    	$model =& $this->getModel();
    	$membersModel =& $this->getModel('Staff');
		
    	//Published options
    	$publishedOptions = array();
    	$publishedOptions[] = JHTML::_('select.option', '1', JText::_('Yes'));    	
    	$publishedOptions[] = JHTML::_('select.option', '0', JText::_('No'));    	
    	
    	//Staff options
    	$members = $membersModel->getData();
    	$memberOptions = array();
    	
    	foreach($members as $member)
    	{
    		$memberOptions[] = JHTML::_('select.option', $member->id, $member->firstname.' '.$member->lastname);
    	}
    	
    	$selectedMemberOptions = array();
    	
    	if($cid){
    		$team = $model->getItem($cid[0]);
    		$arguments[] = $team->id;
    		$publishedRadio = JHTML::_('select.genericlist', $publishedOptions ,'published', 'class="inputbox"' ,'value', 'text' , $team->published);    		
			//Leader and members list
    		$leaderList = JHTML::_('select.genericlist', $memberOptions ,'id_leader', 'class="inputbox" size="1"' ,'value', 'text' , $team->id_leader);    		
			$selectedMembers = $team->getMembers(JFactory::getDBO());
			foreach($selectedMembers as $member)
			{
				$selectedMemberOptions[] = $member->id;
			}			
	    	$memberList = JHTML::_('select.genericlist', $memberOptions ,'members[]', 'class="inputbox" multiple="multiple" size="5"' ,'value', 'text' ,$selectedMemberOptions);

    	}else{
    		$arguments[] = null;
    		$publishedRadio = JHTML::_('select.genericlist', $publishedOptions ,'published', 'class="inputbox"');    		
			//Leader and members list
    		$leaderList = JHTML::_('select.genericlist', $memberOptions ,'id_leader', 'class="inputbox" size="1"');    		
	    	$memberList = JHTML::_('select.genericlist', $memberOptions ,'members[]', 'class="inputbox" multiple="multiple" size="5"');    		
    	}	
    	
    	
    	
		$editor =& JFactory::getEditor();    	
		
    	$this->assignRef('team', $team);
    	$this->assignRef('publishedRadio', $publishedRadio);
    	$this->assignRef('leaderList', $leaderList);
    	$this->assignRef('memberList', $memberList);
		$this->assignRef('editor', $editor);    	
    	
		// Load cited records
		$mainframe->triggerEvent('onBeforeEditJResearchEntity', $arguments);
		
       	parent::display($tpl);
    }
}
?>