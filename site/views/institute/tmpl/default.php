<?php
/**
* @package JResearch
* @subpackage Institutes
* Default view for showing a single institute
*/
JHTML::_('behavior.modal');

if(!empty($this->institute->institute_logo)):
	$url = JResearch::getUrlByRelative($this->institute->institute_logo);
	$thumb = ($this->params->get('thumbnail_enable', 1) == 1)?JResearch::getThumbUrlByRelative($this->institute->institute_logo):$url;
?>
<div style="text-align: center;">
	<a href="<?php echo $url?>" class="modal" rel="{handler: 'image'}">
		<img src="<?php echo $thumb;?>" title="<?php echo JText::sprintf('JRESEARCH_INSTITUTE_IMAGE_OF', $this->institute->name)?>" alt="<?php echo JText::sprintf('JRESEARCH_INSTITUTE_IMAGE_OF', $this->institute->name)?>" />
	</a>
</div>
<?php
endif;
?>
<h1 class="componentheading">
	<?php echo JText::_('JRESEARCH_INSTITUTE');?>
	-
	<?php echo $this->institute->name;?>
</h1>
<div class="content">
	<h3><?php echo JText::_('JRESEARCH_INSTITUTE_ADDRESS'); ?></h3>
	<p>
		<?php if(!empty($this->institute->street)): ?>
			<em><?php echo $this->institute->street; ?></em><br />
		<?php endif; ?>
		<?php if(!empty($this->institute->street2)): ?>		
			<em><?php echo $this->institute->street2; ?></em><br />
		<?php endif; ?>
		<?php if(!empty($this->institute->zip)): ?>
			<em><?php echo $this->institute->zip; ?></em>
		<?php endif; ?>
		<?php if(!empty($this->institute->place)): ?>
		 	<em><?php echo $this->institute->place; ?></em>
		 <?php endif;?>	
		 <br />
		<?php if(!empty($this->institute->state_province)): ?>
			<em><?php echo $this->institute->state_province; ?></em>
		<?php endif; ?>
		<?php $country = $this->institute->getCountry(); ?>
		<?php if(!empty($country)): ?>
			<em><?php echo !empty($this->institute->state_province)?', ':''; ?><?php echo $country; ?></em>
		<?php endif; ?>		
	</p>
	<h3><?php echo JText::_('JRESEARCH_INSTITUTE_CONTACT'); ?></h3>
	<?php if(!empty($this->institute->url)):
			$ampReplacedUrl = JFilterOutput::ampReplace($this->institute->url);
	?>
	<p>
		<strong><?php echo JText::_('JRESEARCH_INSTITUTE_URL');?>:</strong> <a href="<?php echo $ampReplacedUrl;?>"><?php echo $ampReplacedUrl;?></a>
	</p>
	<?php endif; ?>
	<?php if(!empty($this->institute->phone)): ?>
	<p>
		<strong><?php echo JText::_('JRESEARCH_INSTITUTE_PHONE');?>:</strong> <?php echo $this->institute->phone; ?>
	</p>
	<?php endif; ?>
	<?php if(!empty($this->institute->fax)): ?>
	<p>
		<strong><?php echo JText::_('JRESEARCH_INSTITUTE_FAX');?>:</strong> <?php echo $this->institute->fax; ?>
	</p>
	<?php endif; ?>
	<?php if(!empty($this->institute->email)): ?>
	<p>
		<strong><?php echo JText::_('JRESEARCH_INSTITUTE_EMAIL');?>:</strong> <?php JHTML?><a href="mailto:<?php echo $this->institute->email; ?>"><?php echo $this->institute->email; ?></a>
	</p>
	<?php endif; ?>
	<?php
	if($this->comment):
		foreach($this->comment as $content):
	?>
	<p>
		<?php echo $content;?>
	</p>
	<?php
		endforeach;
	endif;
	?>
</div>
<div><a href="javascript:history.go(-1)"><?php echo JText::_('Back'); ?></a></div>