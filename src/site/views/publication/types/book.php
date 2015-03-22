<?php
/**
 * @package JResearch
 * @subpackage Publications
 * @license	GNU/GPL
 * Specific type view for book
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php $publisher = trim($this->publication->publisher);  ?>
<?php if(!empty($publisher)): ?>
	<dt><?php echo JText::_('Publisher').': ' ?></dt>		
	<dd property="dc:publisher"><?php echo $publisher; ?></dd>
<?php endif; ?>
<?php $editor = trim($this->publication->editor); ?>
<?php if(!empty($editor)): ?>
	<dt><?php echo JText::_('JRESEARCH_EDITOR').': ' ?></dt>
	<dd property="bibo:editor"><?php echo $editor ?></dd>
<?php endif; ?>
<?php $volume = trim($this->publication->volume);  ?>
<?php if(!empty($volume)): ?>
	<dt><?php echo JText::_('JRESEARCH_VOLUME').': ' ?></dt>		
	<dd property="bibo:volume"><?php echo $volume; ?></dd>
<?php endif; ?>
<?php $number = trim($this->publication->number); ?>
<?php if(!empty($number)): ?>
	<dt><?php echo JText::_('JRESEARCH_NUMBER').': ' ?></dt>
	<dd property="bibo:number"><?php echo $number ?></dd>
<?php endif; ?>
<?php $series = trim($this->publication->series);  ?>
	<?php if(!empty($series)): ?>
	<dt><?php echo JText::_('JRESEARCH_SERIES').': ' ?></dt>		
	<dd><?php echo $series; ?></dd>
	<?php endif; ?>
	<?php $address = trim($this->publication->address); ?>
	<?php if(!empty($address)): ?>
	<dt><?php echo JText::_('JRESEARCH_ADDRESS').': ' ?></dt>
	<dd><?php echo $address ?></dd>
<?php endif; ?>
<?php $edition = trim($this->publication->edition);  ?>
<?php if(!empty($edition)): ?>
	<dt><?php echo JText::_('JRESEARCH_EDITION').': ' ?></dt>		
	<dd property="bibo:edition"><?php echo $edition; ?></dd>
<?php endif; ?>
<?php $month = trim($this->publication->month); ?>
<?php if(!empty($month)): ?>
	<dt><?php echo JText::_('JRESEARCH_MONTH').': ' ?></dt>
	<dd><?php echo JResearchPublicationsHelper::formatMonth($month); ?></dd>
<?php endif; ?>
<?php $isbn = trim($this->publication->isbn);  ?>
<?php if(!empty($isbn)): ?>
	<dt><?php echo JText::_('JRESEARCH_ISBN').': ' ?></dt>		
	<dd property="bibo:isbn"><?php echo $isbn; ?></dd>
<?php endif; ?>