<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="uk-modal-dialog uk-modal-body">
	<?php echo form_open(base_url(), 'class="uk-form-stacked RenameNewFolderForm" method="POST" data-action="savenewsolutionfolder" data-controller="dashboard"');?>
		<div class="uk-margin">
			<label class="uk-form-label" for="add-solution">Rename <?php echo $info->Type; ?></label>
			<div class="uk-form-controls">
				<input class="uk-input" name="solutiontype" type="text" value="<?php echo $info->Solution; ?>">
				<input type="hidden" name="actiontakenid" value="<?php echo (isset($_GET['autoid']) ? $_GET['autoid'] : ''); ?>">
				<input type="hidden" name="ModelType" value="<?php echo $info->Type; ?>">
			</div>
		</div>
		<div class="uk-text-right">
			<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
			<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('RenameNewFolderForm','Save');">Save</button>
		</div>
	<?php echo form_close(); ?>
</div>