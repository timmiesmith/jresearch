<?php
/**
* @version		$Id$
* @package		JResearch
* @subpackage	Frontend
* @copyright	Copyright (C) 2008 Luis Galarraga.
* @license		GNU/GPL
* This file is the main entry for component JResearch. Its purpose is to load
* the right controller based in request. Controllers reside in folder site/controllers
* and are implemented in files with the same name. The frontend interface of JResearch
* is administered by the following controllers:
*  - JResearchPublicationsController
*  - JResearchProjectsController
*  - JResearchThesesController
*  - JResearchResearchAreasController
*/

// No direct access
defined('_JEXEC') or die('Restricted access');

global $mainframe;

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'init.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jresearch.php');

//Set ACL
setACL();

$controller = JRequest::getVar('controller', null);
// Verify if view parameter is set (usually for frontend requests and map to a controller
if($controller === null)
	$controller = __mapViewToController();


require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');

//Require media and styles
$document = &JFactory::getDocument();
$url = JURI::base();
$document->addStyleSheet($url.'components/com_jresearch/css/jresearch_styles.css');

$session =& JFactory::getSession();

if($session->get('citedRecords', null, 'jresearch') == null){
	$session->set('citedRecords', array(), 'jresearch');
}

// Make an instance of the controller
$classname  = 'JResearch'.ucfirst($controller).'Controller';
$controller = new $classname( );

$pluginhandledRequest = JResearchPluginsHelper::onBeforeExecuteJResearchTask();
// Perform the request task if none of the plugins decided to do it
if(!$pluginhandledRequest)
	$controller->execute(JRequest::getVar('task'));

$mainframe->triggerEvent('onAfterExecuteJResearchTask' , array());

// Redirect if set by the controller
if(!$pluginhandledRequest)
	$controller->redirect();


/**
 * Maps the view requested to the controller that should process the request.
 * Useful when accessing JResearch from a menu item which include view parameter instead of
 * controller.
 *
 * @return string
 */
function __mapViewToController(){
	$view = JRequest::getVar('view');
	
	switch($view){
		case 'staff': case 'member':
			$value = 'staff';
			break;
		case 'publicationslist': case 'publication':
			$value = 'publications';
			break;
		case 'projectslist': case 'project':
			$value = 'projects';
			break;
		case 'theseslist': case 'thesis':
			$value = 'theses';
			break;
		case 'cooperations': case 'cooperation':
			$value = 'cooperations';
			break;
		case 'facilities': case 'facility':
			$value = 'facilities';
			break;
		case 'teams': case 'team';
			$value = 'teams';
			break;
		default:
			$value = 'researchAreas';			
			break;
	}
	
	JRequest::setVar('controller', $value);
	return $value;
	
}


?>