<?php

/**
* @version		$Id$
* @package		J!Research
* @subpackage	Citation
* @copyright		Copyright (C) 2008 Luis Galarraga.
* @license		GNU/GPL
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'citationStyles'.DS.'ieee'.DS.'ieee.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_jresearch'.DS.'helpers'.DS.'publications.php');


/**
* Implementation of IEEE citation style for incollection records.
*
*/
class JResearchIEEEIncollectionCitationStyle extends JResearchIEEECitationStyle{
	

	/**
	* Takes a publication and returns the complete reference text. This is the text used in the Publications 
	* page and in the Works Cited section at the end of a document.
	* @return 	string
	*/
	function getReferenceText(JResearchPublication $publication){
		return $this->getReference($publication);
	}
	
	/**
	* Takes a publication and returns the complete reference text in HTML format.
	* @return 	string
	*/
	function getReferenceHTMLText(JResearchPublication $publication, $authorLinks=false){
		return $this->getReference($publication, true);
	}
	
		
	/**
	* Takes a publication and returns the complete reference text. This is the text used in the Publications 
	* page and in the Works Cited section at the end of a document.
	* 
	* @param JResearchPublication $publication
	* @param boolean $html Add html tags for formats like italics or bold
	* 
	* @return 	string
	*/
	protected function getReference(JResearchPublication $publication, $html=false, $authorLinks=false){		
		$nAuthors = $publication->countAuthors();
		$nEditors = count($publication->getEditors());
		$eds = $nEditors > 1? JText::_('Eds.'):JText::_('Ed.');
		
		if($nAuthors > 0){
			$authorsText = $this->getAuthorsReferenceTextFromSinglePublication($publication, $authorLinks);
		}
		
		$title = '"'.trim($publication->title).'",';	
		
		if(!empty($authorsText))
			$header = "$authorsText. $title";
		else
			$header = $title;	
		
		$booktitle = trim($publication->booktitle);
		if(!empty($booktitle))
			$booktitle = " in ".($html?"<i>$booktitle</i>":$booktitle);	


		$editors = $this->getEditorsReferenceTextFromSinglePublication($publication);	
		if(!empty($editors))
			$header .= ', '.$editors.' '.$eds;	
			
		$address = $this->_getAddressText($publication);
		if(!empty($address))
			$header .= " .$address";
	
		$month = trim($publication->month);
		if(!empty($month))
			$header .= ', '.$month;	
				
		if($publication->year != null && $publication->year != '0000')		
			if(!empty($month))
				$header =  "$header $publication->year";
			else
				$header =  "$header, $publication->year";	
			
		$pages = str_replace('--', '-', trim($publication->pages));
		if(!empty($pages))
			$header .= ', pp. '.$pages;	
			
		return $header;

	}
	


}
?>