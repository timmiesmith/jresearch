<?php
/**
 * @package JResearch
 * @subpackage Projects
 * @license	GNU/GPL
 * Default view for showing a list of projects
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 
jresearchimport('helpers.html.jresearchfrontend', 'jresearch.site');
$jinput = JFactory::getApplication()->input;
?>
<?php if($this->showHeader): ?>
    <h1 class="componentheading"><?php echo $this->escape($this->header); ?></h1>
<?php endif; ?>
<form name="adminForm" method="post" id="adminForm" action="<?php echo JURI::current(); ?>/<?php echo '?Itemid='.$jinput->getInt('Itemid'); ?>">
<div style="text-align: left;">
	<?php echo $this->filter; ?>
</div>
<div style="clear: both;" ></div>
<?php $introText = $this->params->get('projects_introtext', ''); ?>
<?php if(!empty($introText)): ?>
<p>
    <?php echo $introText; ?>
</p>
<?php endif; ?>
<?php
if(count($this->items) > 0):
?>
<ul class="frontenditems">
 
<?php foreach($this->items as $project): ?>
    <?php 
        $researchAreas = $project->getResearchAreas();
        $researchAreasNames = array();
        foreach($researchAreas as $area){
            if($area->id > 1){
                if($area->published)
                    $researchAreasNames[] = $area->name;
                else
                    $researchAreasNames[] = JHTML::_('jresearchfrontend.link', $area->name, 'researcharea', 'display', $area->id, $itemId);
            }
        } 
    ?>
    <li>
        <div>
            <?php $contentArray = explode('<hr id="system-readmore" />', $project->description); ?>
            <?php $itemId = $jinput->getInt('Itemid'); ?>
            <h3 class="contentheading"><?php echo $project->title; ?></h3>
            <?php 
            //Show research area?
            if($this->params->get('show_researcharea') == 1):
            ?>		
                <?php if(count($researchAreasNames) > 0): ?>
                <div>
                        <h4><?php echo JText::_('JRESEARCH_RESEARCH_AREAS')?></h4>
                        <span><?php echo implode(', ', $researchAreasNames); ?></span>
                </div>
                <?php endif; ?>
            <?php endif; ?> 
            <?php
            //Show members?
            if($this->params->get('show_members') == 1):
                $members = implode('; ',$project->getLeaders());
            ?>			
                <div>
                    <h4><?php echo JText::_('JRESEARCH_PROJECT_LEADERS')?></h4>
                    <span><?php echo $members; ?></span>
                </div>
            <?php endif; ?>
            <?php if(!empty($contentArray[0])): ?>
            <div class="itemdescription">
                <?php echo $contentArray[0]; ?>
            </div>
            <?php endif; ?>
            <div style="text-align:left">
                <?php echo JHTML::_('jresearchfrontend.link', JText::_('JRESEARCH_READ_MORE'), 'project', 'show', $project->id); ?>
            </div>
        </div>
    </li>	
<?php endforeach; ?>
</ul>
<input type="hidden" name="option" value="com_jresearch" />
<input type="hidden" name="task" value="list" />
<input type="hidden" name="view" value="projects"  />	
<input type="hidden" name="controller" value="projects"  />
<input type="hidden" name="limitstart" value="0" />
<input type="hidden" name="modelkey" value="default" />
<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $jinput->getInt('Itemid'); ?>" />	
</form>

<?php endif; ?>
<div style="text-align:center;"><?php echo $this->page->getResultsCounter(); ?><br /><?php echo $this->page->getPagesLinks(); ?></div>