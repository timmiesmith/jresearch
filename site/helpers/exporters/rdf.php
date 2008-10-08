<?php
/**
* @version		$Id$
* @package		JResearch
* @copyright	Copyright (C) 2008 Luis Galarraga.
* @license		GNU/GPL
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'helpers'.DS.'exporters'.DS.'exporter.php');

/**
 * This class allows to export sets of JResearchPublication objects into RDF/XML
 * output.
 *
 */
class JResearchPublicationRDFExporter extends JResearchPublicationExporter{
	
	/**
	 * Parse the array of JResearchPublication objects into RDF/XML text.
	 *
	 * @param mixed $publications JResearchPublication object or array of them. 
	 * @return string Representation of the objects in a RDF format, null if it is
	 * not possible to parse the objects.
	 */
	function parse($publications){
	}
	
	/**
	* Parse a single JResearchPublication object into a RDF text.
	*
	* @param JResearchPublication Object to parse.
	*/
	private function parseSingle($publication){
	}
	
	/**
	* Returns the MIME encoding of the output generated by the parser. The default
	* is text/plain as these classes return string variables, but derived classes
	* can override the method to specify other text formats.
	*/	
	function getMimeEncoding(){
		return "text/xml";
	}
	
}
?>