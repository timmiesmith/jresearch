<?php
/**
 * @package JResearch
 * @subpackage Facilities
 * Default view for showing a single facility
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');

?>
<div class="componentheading"><?=$this->fac->name; ?></div>
<?php 
if($this->fac->image_url)
{
?>
	<div style="text-align: center;">
		<a href="<?=$this->fac->image_url?>" class="modal" rel="{handler: 'image'}">
			<img src="<?=$this->fac->image_url?>" alt="Image from <?=$this->fac->name?>" title="Image from <?=$this->fac->name?>" style="width: 500px;" />
		</a>
	</div>
<?php 
}

if($this->fac->description)
{
?>
	<p>
		<?=$this->fac->description;?>
	</p>
<?php 
}
?>
<div style="text-align: center;">
	<a href="javascript:history.go(-1)"><?=JText::_('Back'); ?></a>
</div>