<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="uk-modal-dialog uk-modal-body">
	<?php echo form_open(base_url(), 'class="uk-form-stacked CreateRoleForm" method="POST" data-action="saveroles" data-controller="teams"');?>
		<div class="uk-margin">
			<label class="uk-form-label" for="rolename">Organisation role name</label>
			<div class="uk-form-controls">
			<input class="uk-input" type="text" value="<?php echo $info->rolename;?>" name="rolename" required>
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="description">Description (optional)</label>
			<div class="uk-form-controls">
			<input class="uk-input" type="text" value="<?php echo $info->description;?>" name="description">
			<input type="hidden" value="<?php echo encryptKey($info->roleid);?>" name="editroleid">
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="role">Status</label>
			<div class="uk-form-controls">
				<div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
					<?php if($this->userinfo->roleid == $info->roleid ) {?>
						<input type="hidden" value="1" name="isactive">
						<label><input class="uk-radio" type="radio" name="isactive_not" value="1" <?php echo ($info->isactive == 1 ? 'checked="checked"' : '');?> <?php echo ( $this->userinfo->roleid == $info->roleid ? 'disabled' : '');?>>
						 Active</label>
						<label><input class="uk-radio" type="radio" name="isactive_not" value="0" <?php echo ($info->isactive == 0 ? 'checked="checked"' : '');?> <?php echo ( $this->userinfo->roleid == $info->roleid ? 'disabled' : '');?>> Inactive</label>
					<?php } else { ?>
						<label><input class="uk-radio" type="radio" name="isactive" value="1" <?php echo ($info->isactive == 1 ? 'checked="checked"' : '');?>>
						 Active</label>
						<label><input class="uk-radio" type="radio" name="isactive" value="0" <?php echo ($info->isactive == 0 ? 'checked="checked"' : '');?>> Inactive</label>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="uk-text-right">
			<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
			<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('CreateRoleForm','Update');">Update</button>
		</div>
	<?php echo form_close(); ?>
</div>