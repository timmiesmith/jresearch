<?php
/**
* @package JResearch
* @subpackage Cooperations
* Default view for showing a list of cooperations
*/

defined("_JEXEC") or die("Restricted access");

?>
<h1 class="componentheading">
	<?php echo JText::_('JRESEARCH_TEAMS');?>
</h1>
<ul style="padding-left:0px;">
	<?php
	foreach($this->items as $team)
	{
	?>
		<li class="liteam">
				<?php
				$contentArray = explode('<hr id="system-readmore" />', $team->description);
				$itemId = JRequest::getVar('Itemid');
				?>
				<h2 class="contentheading">
					<?php echo JFilterOutput::ampReplace($team->name); ?>
				</h2>
				<div>
					<?php $leader = $team->getLeader(); ?>
					<strong><?php echo JText::_('JRESEARCH_TEAM_LEADER');?>:</strong> <?php echo $leader->__toString(); ?>
				</div>
				<div style="text-align:left">
					<a href="index.php?option=com_jresearch&task=show&view=team&id=<?php echo $team->id.(isset($itemId)?'&Itemid='.$itemId:'');?>" >
						<?php echo JText::_('JRESEARCH_READ_MORE'); ?>
					</a>
				</div>
			<div style="clear: both;"></div>
		</li>
	<?php
	}
	?>
</ul>
<div style="width:100%;text-align:center;">
	<?php echo $this->page->getResultsCounter()?><br />
	<?php echo $this->page->getPagesLinks()?>
</div>
<input type="hidden" name="option" value="com_jresearch" />
<input type="hidden" name="controller" value="teams"  />
<input type="hidden" name="limitstart" value="" />
<input type="hidden" name="hidemainmenu" value="" />