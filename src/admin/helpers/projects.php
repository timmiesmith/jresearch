<?php
/**
* @package		JResearch
* @subpackage	
* @copyright	Copyright (C) 2008 Luis Galarraga.
* @license		GNU/GPL v2
* Description
*/

defined('JPATH_BASE') or die;

class JResearchProjectsHelper{
	
	/**
	 * Gets a list of all years used for projects
	 */
   	public static function getYears(){
       $db = JFactory::getDBO();
       $db->setQuery('SELECT DISTINCT YEAR(start_date) as year FROM '.$db->nameQuote('#__jresearch_project').' ORDER BY '.$db->nameQuote('start_date').' DESC ');
       return $db->loadResultArray();
   	}
   	
   	/**
   	 * Get the list of all authors who are involved in projects
   	 */
   	public static function getAllAuthors(){
   		$db = JFactory::getDBO();
   		$db->setQuery('SELECT DISTINCT mid, member_name FROM '.$db->nameQuote('#__jresearch_all_project_authors'));
   		return $db->loadAssocList();
   	}
   	
	/**
	 * Returns a project given its id.
	 * @param int $id
	 */
	public static function getProject($id){
		jresearchimport('tables.project', 'jresearch.admin');
		
		$project = JTable::getInstance('Project', 'JResearch');
		if($project->load($id)){
			return $project;
		}else{
			return null;
		}
	}   	
}
?>