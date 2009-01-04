<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

$n = count($this->items);
$previousType = null;
global $mainframe;
$style = $mainframe->getParams('com_jresearch')->get('citationStyle', 'APA');
for($i = 0; $i < $n; $i++ ): 
	$styleObj = JResearchCitationStyleFactory::getInstance($style, $this->items[$i]->pubtype);
	$publicationText = $styleObj->getReferenceHTMLText($this->items[$i], true, true);
	if($previousType != $this->items[$i]->pubtype):
		$header = JText::_('JRESEARCH_PUBLICATION_TYPE').': '.$this->items[$i]->pubtype;			
?>
		<tr><td class="sectiontableheader"><?php echo $header; ?></td></tr>
	<?php endif; ?>
	<tr><td><?php echo $publicationText;  ?>&nbsp;<a href="index.php?option=com_jresearch&view=publication&task=show&id=<?php echo $this->items[$i]->id; ?>"><?php echo JText::_('JRESEARCH_MORE'); ?></a></td></tr>
	<?php $previousType = $this->items[$i]->pubtype; ?>
<?php endfor; ?>

