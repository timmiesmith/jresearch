<?php
/**
* @version		$Id$
* @package		JResearch
* @subpackage	Staff
* @copyright		Copyright (C) 2008 Luis Galarraga.
* @license		GNU/GPL
* This file implements the view which is responsible for management of a single member's profile
* in the backend.
*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for single member management in JResearch Component backend
 *
 */

class JResearchAdminViewMember extends JView
{
    function display($tpl = null){
    	global $mainframe;
      	JResearchToolbar::editMemberAdminToolbar();
        JHTML::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'html');      	
      	
		JHTML::_('jresearchhtml.validation');
    	JRequest::setVar( 'hidemainmenu', 1 );

    	// Information about the member
    	$cid = JRequest::getVar('cid');
    	$model =& $this->getModel();
    	
    	$member = $model->getItem($cid[0]);
    	$arguments = array('member', $member?$member->id:null);
    	
    	//Lists
    	$publishedRadio = JHTML::_('jresearchhtml.publishedlist', array('name' => 'published', 'attributes' => 'class="inputbox"', 'selected' => $member->published));
   	 	$researchAreasHTML = JHTML::_('jresearchhtml.researchareas', array('name' => 'id_research_area', 'attributes' => 'class="inputbox" size="5"', 'selected' => $member->id_research_area)); 

    	$orderOptions = array();
    	$orderOptions = JHTML::_('list.genericordering','SELECT ordering AS value, CONCAT_WS(\' \', firstname, lastname) AS text FROM #__jresearch_member ORDER by former_member,ordering ASC');
    	$orderList = JHTML::_('select.genericlist', $orderOptions ,'ordering', 'class="inputbox"' ,'value', 'text' , ($member)?$member->ordering:0);
    	
    	$positionList = JHTML::_('jresearchhtml.memberpositions', array('name' => 'position', 'attributes' => 'class="inputbox" size="5"', 'selected' => $member->position));
    	
		$editor =& JFactory::getEditor();    	
    	
    	$this->assignRef('member', $member);
    	$this->assignRef('areasList', $researchAreasHTML);
    	$this->assignRef('publishedRadio', $publishedRadio);
    	$this->assignRef('orderList', $orderList);
    	$this->assignRef('positionList', $positionList);
		$this->assignRef('editor', $editor);    	
    	
		// Load cited records
		$mainframe->triggerEvent('onBeforeEditJResearchEntity', $arguments);
		
       	parent::display($tpl);
       	
       	$mainframe->triggerEvent('onAfterEditJResearchEntity', $arguments);
    }
}

?>
