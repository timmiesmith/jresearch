<?php
/**
 * @package JResearch
 * @subpackage Publications
 * View for showing a list of publications
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<div class="componentheading"><div style="float: right;"><?php JHTML::_('Jresearch.icon','add','publications'); ?></div><?php echo JText::_('JRESEARCH_PUBLICATIONS'); ?></div>
<table align="left" width="100%" cellspacing="2" cellpadding="2">
<tbody>
	<?php 
		$layout = JRequest::getVar('filter_order', 'year');
		require_once(JPATH_COMPONENT.DS.'views'.DS.'publicationslist'.DS.'tmpl'.DS.$layout.'.php');
	?>
	<tr><td align="center"><?php echo $this->page->getResultsCounter(); ?><br /><?php echo $this->page->getPagesLinks(); ?></td></tr>
</tbody>
</table>


