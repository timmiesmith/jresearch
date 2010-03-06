<?php
/**
* @version		$Id$
* @package		JResearch
* @subpackage	Publications
* @copyright	Copyright (C) 2008 Luis Galarraga.
* @license		GNU/GPL
* This file implements the view which is responsible for the presentation of a
* single publication in frontend.
*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );



/**
 * HTML View class for presentation of a publication information.
 *
 */

class JResearchViewPublication extends JResearchView
{
    function display($tpl = null)
    {
    	global $mainframe;
    	
        $layout = $this->getLayout();
        $result = true;
        $arguments = array();

        switch($layout){
        	case 'new':
        		$result = $this->_displayNewPublicationForm();
        		break;
        	case 'edit':
        		$result = $this->_editPublication($arguments);        		
        		break;
        	case 'default': default:
        		$result = $this->_displayPublication($arguments);        		
        		break;
        		
        }
        
		if($result)
		{
       		parent::display($tpl);
       		
       		if($layout == 'default')
       			$mainframe->triggerEvent('onAfterRenderJResearchEntity', $arguments);
       		elseif($layout == 'edit')
       			$mainframe->triggerEvent('onAfterRenderJResearchEntityForm', $arguments);	
		}
    }
    
    /**
    * Display the information of a publication.
    */
    private function _displayPublication(&$arguments){
      	global $mainframe;
      	require_once(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'helpers'.DS.'publications.php');      	      	
      	
      	$id = JRequest::getInt('id');
    	$user = JFactory::getUser();    	    	
    	$commentsAllowed = false;
   		$showComments = JRequest::getInt('showcomm', 0);
   		$doc =& JFactory::getDocument();
   		   		
      	JHTML::addIncludePath(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'helpers'.DS.'html');   		
   		JHTML::_('Validator._');   
   		$config = array('filePath'=>JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'views'.DS.'publication'.DS.'captcha');   			
   		$doc->addScript(JURI::base().'components/com_jresearch/views/publication/comments.js');
   		
    	if(empty($id)){
    		JError::raiseWarning(1, JText::_('JRESEARCH_INFORMATION_NOT_RETRIEVED'));
    		return false;
    	}
    	//Get the model
    	$model =& $this->getModel();
    	$publication = $model->getItem($id);

		if(!$publication->internal || !$publication->published){
			JError::raiseWarning(1, JText::_('JRESEARCH_ITEM_NOT_FOUND'));
			return false;
		}
				    	
    	JResearchPluginsHelper::onPrepareJResearchContent('publication', $publication);		
		$arguments[] = 'publication';
		$arguments[] =  $publication->id;    	
		$areaModel = &$this->getModel('researcharea');
    	$area = $areaModel->getItem($publication->id_research_area);
    	
    	//Get and use configuration
    	$params = $mainframe->getPageParameters('com_jresearch');
		if($params->get('publications_allow_comentaries') == 'yes'){
			$user =& JFactory::getUser();
		 	$from = $params->get('publications_allow_comentaries_from');	
			if($from == 'everyone' || (!$user->guest && $from == 'users')){
				$commentsAllowed = true;
			}
			
			jximport('jxtended.captcha.captcha');
 		 	$captcha = &JXCaptcha::getInstance('image', $config);
 		 	if(!$captcha->initialize())
 		 		JError::raiseWarning(1, JText::_('JRESEARCH_CAPTCHA_NOT_INITIALIZED'));
 	
    		if (!is_array($captchaInformation = $captcha->create())) {
	 			JError::raiseWarning(1, JText::_('JRESEARCH_CAPTCHA_NOT_INITIALIZED'));
	    	}
	    	
	    	// Get the comments
	    	$limit = JRequest::getVar('limit', 5);
	    	$limitStart = JRequest::getVar('limitstart', 0);
	    	$comments = $model->getComments($publication->id, $limit, $limitStart);			
	    	$total = $model->countComments($publication->id);
	    	$this->assignRef('comments', $comments);
	    	$this->assignRef('limit', $limit);
			$this->assignRef('limitstart', $limitStart);	    	
			$this->assignRef('total', $total);
		}
    	    	
    	
    	// Cross referencing
		$missingFields = $publication->getReferencedFields();
		if(!empty($missingFields)){
			$count = 0;
			$crossrefData = "<tr>";
			foreach($missingFields as $key=>$value){
				if($count % 2 == 0 && $count > 0){
					$crossrefData .= "<tr>";
				}		
				$crossrefData .= "<td class=\"publicationlabel\">".JResearchText::_($key).": </td><td>".trim($value)."</td>";
				$count++;	
				if($count % 2 == 0 && $count > 0){
					$crossrefData .= "</tr>";
				}
		
			} 
			if($count % 2 != 0)
				$crossrefData .= "<td></td><td></td></tr>";
			
			$this->assignRef('reference', $crossrefData);	
		}
		
		$doc->setTitle(JText::_('JRESEARCH_PUBLICATION').' - '.$publication->title);
				
    	// Bind variables for layout
    	$this->assignRef('staff_list_arrangement', $params->get('staff_list_arrangement'));
    	$this->assignRef('publication', $publication, JResearchFilter::OBJECT_XHTML_SAFE);
    	$this->assignRef('area', $area, JResearchFilter::OBJECT_XHTML_SAFE);
    	$this->assignRef('commentsAllowed', $commentsAllowed);
    	$this->assignRef('showComments', $showComments);
    	$this->assignRef('captcha', $captchaInformation);
		$this->assignRef('user', $user, JResearchFilter::OBJECT_XHTML_SAFE);
		
		$mainframe->triggerEvent('onBeforeDisplayJResearchEntity', $arguments);
		
		return true;

    }
    
    private function _editPublication(&$arguments)
    {
    	global $mainframe;
    	
    	$arguments[] = 'publication';    	    	    	
    	JHTML::addIncludePath(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'helpers'.DS.'html');
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables'.DS.'member.php');
		JHTML::_('Validator._');		
		$user = JFactory::getUser();
		$cid = JRequest::getVar('id', 0);
		$journalValue = null;
		$selectFromList = true;
				
		$pubtype = JRequest::getVar('pubtype');
		$model = $this->getModel('researchareaslist');
		
		$this->assignRef('id', $cid);
		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration('
		function msubmitform(pressbutton){
			if (pressbutton) {
				document.adminForm.task.value=pressbutton;
			}
			if (typeof document.adminForm.onsubmit == "function") {
				if(!document.adminForm.onsubmit())
				{
					return;
				}
				else
				{
					document.adminForm.submit();
				}
    		}
    		else
    		{
    			document.adminForm.submit();
    		}
    	}');
		
    	// Retrieve the list of research areas   	
    	$researchAreas = $model->getData(null, true, false);

    	$researchAreasOptions = array();
    	foreach($researchAreas as $r){
    		$researchAreasOptions[] = JHTML::_('select.option', $r->id, $r->name);
    	}
    	
    	//Published options
    	$publishedOptions = array();
    	$publishedOptions[] = JHTML::_('select.option', '1', JText::_('JRESEARCH_YES'));    	
    	$publishedOptions[] = JHTML::_('select.option', '0', JText::_('JRESEARCH_NO'));
		
		if($cid > 0)
		{    		
			$publication = JResearchPublication::getById($cid);
			$pubtype = $publication->pubtype;
					
		    $researchAreasHTML = JHTML::_('select.genericlist',  $researchAreasOptions, 'id_research_area', 'class="inputbox" size="5"', 'value', 'text', $publication->id_research_area);
			
		    //Published radio
			$publishedRadio = JHTML::_('select.genericlist', $publishedOptions ,'published', 'class="inputbox"' ,'value', 'text' , $publication->published);
			$authors = $publication->getAuthors();			
			$authorsControl = JHTML::_('AuthorsSelector.autoSuggest2', 'authors' ,$authors);			
			$this->assignRef('publication', $publication);	
			$arguments[] = $publication->id;
			
			if(!empty($publication->id_journal)){
				$journalValue = $publication->id_journal;
				$selectFromList = true;
			}else{
				$journalValue = $publication->journal;
				$selectFromList = false;				
			}	
		}else{
			$researchAreasHTML = JHTML::_('select.genericlist',  $researchAreasOptions, 'id_research_area', 'class="inputbox" size="5"', 'value', 'text', null);
			
		    //Published radio
			$publishedRadio = JHTML::_('select.genericlist', $publishedOptions ,'published', 'class="inputbox"' ,'value', 'text' , 1);
			$member = new JResearchMember(JFactory::getDBO());
			$member->bindFromUsername($user->username);
			$authorsControl = JHTML::_('AuthorsSelector.autoSuggest2', 'authors' , array($member));
			$arguments[] = null;
		}
		$journalsControl = JHTML::_('JournalsControl.journalscontrol', 'journal', $journalValue, $selectFromList);
		
		
		$this->assignRef('user', $user, JResearchFilter::OBJECT_XHTML_SAFE);
		$this->assignRef('pubtype', $pubtype);
		$this->assignRef('areasList', $researchAreasHTML);
		$this->assignRef('publishedRadio', $publishedRadio);
		$this->assignRef('internalRadio', $internalRadio );
		$this->assignRef('authors', $authorsControl);
		$this->assignRef('journals', $journalsControl);

		$mainframe->triggerEvent('onBeforeEditJResearchEntity', $arguments);
		
		return true;
    }
    
	/**
	* Binds the variables for the form used to select the type 
	* for a new publication.
	*/
	private function _displayNewPublicationForm(){
		JHTML::addIncludePath(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'helpers'.DS.'html');
		$subtypes = JResearchPublication::getPublicationsSubtypes();
		$typesOptions = array();
		
		foreach($subtypes as $type){
			// Inproceedings is the same as conference 
			if($type != 'inproceedings')
				$typesOptions[] = JHTML::_('select.option', $type, $type.': '.JText::_('JRESEARCH_'.strtoupper($type)));			
		}
		
		$typesList = JHTML::_('select.genericlist', $typesOptions, 'pubtype', 'size="1"');		
		
		$this->assignRef('types', $typesList);
		return true;
	}
}

?>