<?php
/**
* @version		$Id$
* @package		JResearch
* @subpackage	Teams
* @copyright	Copyright (C) 2008 Florian Prinz.
* @license		GNU/GPL
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'modelSingleRecord.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables'.DS.'team.php');

/**
* Model class for holding a single team record.
*
*/
class JResearchModelTeam extends JResearchModelSingleRecord
{
	/**
	* Returns the record with the id sent as parameter.
	* @return 	object
	*/
	public function getItem($itemId)
	{
		$db =& JFactory::getDBO();
		
		$team = new JResearchTeam($db);
		$result = $team->load($itemId);
		
		return ($result) ? $team : null;
	}
	
	public function getMembersFromTeam($itemId)
	{
		$item = $this->getItem($itemId);
		
		return $item->getMembers();
	}
}
?>