<?php
/**
 * @package JResearch
 * @subpackage Facilities
 * Default view for adding/editing a single facility
 */
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<form name="adminForm" id="adminForm" method="post" enctype="multipart/form-data" class="form-validate" onSubmit="return validate(this);">
<table class="editpublication" cellpadding="5" cellspacing="5">
<tbody>
	<tr>
		<th colspan="4"><?php echo JText::_('JRESEARCH_REQUIRED')?></th>
	</tr>
	<tr>
		<td><?php echo JText::_('Name').': '?></td>
		<td colspan="3">
			<input name="name" id="name" size="80" maxlength="255" value="<?php echo $this->fac?$this->fac->name:'' ?>" class="required" />
			<br />
			<label for="name" class="labelform"><?php echo JText::_('JRESEARCH_FACILITY_PROVIDE_VALID_NAME'); ?></label>
		</td>
	</tr>
	<tr>
		<td><?php echo JText::_('JRESEARCH_RESEARCH_AREA').': ' ?></td>		
		<td colspan="3"><?php echo $this->areasList; ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('Published').': '; ?></td>
		<td colspan="3"><?php echo $this->publishedRadio; ?></td>
	</tr>
	<tr>
		<th class="editpublication" colspan="4"><?php echo JText::_('JRESEARCH_OPTIONAL'); ?></th>
	</tr>
	<tr>
		<td>
			<?php echo JText::_('JRESEARCH_FACILITY_IMAGE').': '; ?>
		</td>
		<td>
			<input type="file" name="inputfile" id="inputfile" />&nbsp;&nbsp;<?php echo JHTML::_('tooltip', JText::sprintf('JRESEARCH_IMAGE_SUPPORTED_FORMATS', 1024, 768)); ?><br />
		</td>
		<td colspan="2" rowspan="2">
			<?php
			if($this->fac && $this->fac->image_url):
			?>
				<a href="<?php echo $this->fac->image_url;?>" class="modal">
					<img src="<?php echo $this->fac->image_url; ?>" alt="Image of <?php echo $this->fac->name?>" width="100" />
				</a>
				<label for="delete" /><?php echo JText::_('Delete current photo'); ?></label><input type="checkbox" name="delete" id="delete" />
				<input type="hidden" name="image_url" id="image_url" value="<?php echo $this->fac->image_url;?>" />
			<?php
			endif;
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left"><?php echo JText::_('JRESEARCH_DESCRIPTION').': '; ?></td>
	</tr>
	<tr>
		<td colspan="4"><?php echo $this->editor->display( 'description',  $this->fac?$this->fac->description:'' , '100%', '350', '75', '20' ) ; ?></td>
	</tr>
</tbody>
</table>
<input type="hidden" name="option" value="com_jresearch" />
<input type="hidden" name="task" value="" />		
<input type="hidden" name="controller" value="facilities" />
<input type="hidden" name="id" value="<?php echo $this->fac?$this->fac->id:'' ?>" />		
<?php echo JHTML::_('behavior.keepalive'); ?>
<?php echo JHTML::_('form.token'); ?>	
</form>