<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="uk-modal-dialog uk-modal-body">
	<?php echo form_open(base_url(), 'class="uk-form-stacked SavesubNewFolderForm" method="POST" data-action="savenewsolutionfolder" data-controller="solutions"');?>
		<div class="uk-margin">
			<label class="uk-form-label" for="add-solution">Add sub folder in <b> <?php echo $info->Solution;?></b> folder</label>
			<div class="uk-form-controls">
				<input class="uk-input" name="solutiontype" type="text" placeholder="Sub folder name...">
				<input name="ModelType" type="hidden" value="Folder">
				<input name="foldertype" type="hidden" value="subfolder">
				<input name="nextboxnumer" type="hidden" value="<?php echo (isset($nextboxnumer) ? $nextboxnumer : 1);?>">
				<input name="FolderUniQIDS" type="hidden" value="<?php echo (isset($FolderUniQIDS) ? $FolderUniQIDS : '');?>">
			</div>
		</div>
		<div class="uk-text-right">
			<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
			<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateSolutionFormSubmit('SavesubNewFolderForm','Continue');">Save</button>
		</div>
	<?php echo form_close(); ?>
</div>