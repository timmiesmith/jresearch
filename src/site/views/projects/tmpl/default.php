<?php
/**
 * @package JResearch
 * @subpackage Projects
 * Default view for showing a list of projects
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 
jresearchimport('helpers.html.jresearchfrontend', 'jresearch.site');
?>
<?php if($this->showHeader): ?>
<h1 class="componentheading"><?php echo $this->escape($this->header); ?></h1>
<?php endif; ?>
<div style="text-align: left;">
	<?php echo $this->filter; ?>
</div>
<?php
if(count($this->items) > 0):
?>
<ul style="padding-left:0px;">
 
<?php foreach($this->items as $project): ?>
	<?php $researchAreas = $project->getResearchAreas();
		$researchAreasNames = array();
		foreach($researchAreas as $area){
			if($area->published)
				$researchAreasNames[] = $area->name;
			else
				$researchAreasNames[] = JHTML::_('jresearchfrontend.link', $area->name, 'researcharea', 'display', $area->id, $itemId);
		} 
	?>
	<li class="liresearcharea">
		<div>
			<?php $contentArray = explode('<hr id="system-readmore" />', $project->description); ?>
			<?php $itemId = JRequest::getVar('Itemid'); ?>
			<h3 class="contentheading"><?php echo $project->title; ?></h3>
			<?php 
			//Show research area?
			if($this->params->get('show_researcharea') == 1):
			?>		
			<div>
				<h4><?php echo JText::_('JRESEARCH_RESEARCH_AREA')?></h4>
				<span><?php echo implode(', ', $researchAreas); ?></span>
			</div>
			<?php 
			endif;
			
			//Show members?
			if($this->params->get('show_members') == 1):
				$members = implode(', ',$project->getPrincipalInvestigators());
			?>			
			<div>
        		<h4><?php echo JText::_('JRESEARCH_PROJECT_LEADERS')?></h4>
        		<span><?php echo $members; ?></span>
			</div>
			<?php 
			endif;			
			
			if(!empty($contentArray[0])):
			?>
				<div>&nbsp;</div>
				<?php echo $contentArray[0]; ?>
			<?php
			endif;
			?>
			<div style="text-align:left">
				<?php echo JHTML::_('jresearchfrontend.link', JText::_('JRESEARCH_READ_MORE'), 'project', 'show', $project->id); ?>
			</div>
		</div>

	</li>	
<?php endforeach; ?>
</ul>

<?php
endif;
?>
<div style="text-align:center;"><?php echo $this->page->getResultsCounter(); ?><br /><?php echo $this->page->getPagesLinks(); ?></div>