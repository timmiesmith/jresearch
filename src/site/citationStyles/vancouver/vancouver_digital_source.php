<?php
/**
* @version		$Id$
* @package		JResearch
* @subpackage	Citation
* @copyright	Copyright (C) 2008 Luis Galarraga.
* @license		GNU/GPL
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'citationStyles'.DS.'vancouver'.DS.'vancouver.php');


/**
* Implementation of Vancouver citation style for digital sources.
*
*/
class JResearchVancouverDigital_sourceCitationStyle extends JResearchVancouverCitationStyle{
		
	/**
	* Takes a publication and returns the complete reference text. This is the text used in the Publications 
	* page and in the Works Cited section at the end of a document.
	* 
	* @param JResearchPublication $publication
	* @param boolean $html Add html tags for formats like italics or bold
	* @param boolean $authorPreviouslyCited If true
	* 
	* @return 	string
	*/
	protected function getReference(JResearchPublication $publication, $html=false, $authorLinks=false){		
		$nAuthors = $publication->countAuthors();
		$text = '';
		
		if($nAuthors <= 0){
			$authorsText = '';
		}else{
			$authorsText = $this->getAuthorsReferenceTextFromSinglePublication($publication, $authorLinks);
		}
		$text .= rtrim($authorsText, '.');		
		
		$title = $html?'<i>'.trim($publication->title).'</i>':trim($publication->title);	
		if(!empty($text))
			$text .= '. '.$title;
		else
			$text .= $title;

		switch($publication->source_type){
			case 'cdrom':
				$type = JText::_('JRESEARCH_CDROM');
				break;
			case 'film':
				$type = JText::_('JRESEARCH_FILM');	
				break;
		}
		$text .= ' ['.$type.']';	
		
		$address = $this->_getAddressText($publication);
		if(!empty($address))
			$text .= ' '.$address;
		
		$year = trim($publication->year);	
		if($year != null && $year != '0000'){		
			$text .= '; '.$year;
		}			
		
		return $text.'.';			
	}
}

?>
