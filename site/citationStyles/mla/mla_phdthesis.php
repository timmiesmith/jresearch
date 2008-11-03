<?php
/**
* @version		$Id$
* @package		J!Research
* @subpackage	Citation
* @copyright		Copyright (C) 2008 Luis Galarraga.
* @license		GNU/GPL
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'citationStyles'.DS.'mla'.DS.'mla.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'helpers'.DS.'publications.php');


/**
* Implementation of MLA citation style for master thesis records.
*
*/
class JResearchMLAPhdthesisCitationStyle extends JResearchMLACitationStyle{
	
	/**
	* Takes a publication and returns the complete reference text in HTML format.
	* @return 	string
	*/
	function getReferenceHTMLText(JResearchPublication $publication, $authorLinks=false){
		$this->lastAuthorSeparator = JText::_('JRESEARCH_BIBTEXT_AUTHOR_SEP');
		$nAuthors = $publication->countAuthors();
		
		if(!$publication->__authorPreviouslyCited){
			if($nAuthors <= 0){
				$authorsText = '';
			}else{
				$authorsText = trim($this->getAuthorsReferenceTextFromSinglePublication($publication, $authorLinks));
			}
		}else{
			$authorsText = '---';
		}

		$address = $this->_getAddressText($publication);
		
		$title = '"'.trim($publication->title).'"';

		if(!empty($authorsText)){
			$header = "$authorsText. $title.";
		}else{
			$header = "$title";	
		}
		
		$school = trim($publication->school);

		if($publication->year != null && $publication->year != '0000')		
			return "$header. $school, $publication->year";
		else
			return "$header. $school";			
	}
	
}
?>