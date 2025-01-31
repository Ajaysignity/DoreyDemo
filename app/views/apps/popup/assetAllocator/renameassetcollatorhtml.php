<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="uk-modal-dialog uk-modal-body">
	<?php echo form_open(base_url(), 'class="uk-form-stacked SavesubNewFolderForm" method="POST" data-action="updateuserallocator" data-controller="assetallocator"');?>
		<div class="uk-margin">
			<label class="uk-form-label" for="add-solution"><?php echo ucwords(decryptKey($type));?> solution</label>
			<div class="uk-form-controls">
				<input class="uk-input" name="ClientName" type="text" placeholder="solution name..." value="<?php echo $ClientName;?>">
				<input name="iduserallocator" type="hidden" value="<?php echo ($iduserallocator);?>">
				<input name="type" type="hidden" value="<?php echo ($type);?>">
			</div>
		</div>
		<div class="uk-text-right">
			<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
			<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('SavesubNewFolderForm','Continue');">Save</button>
		</div>
	<?php echo form_close(); ?>
</div>