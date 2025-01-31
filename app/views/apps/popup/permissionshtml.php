<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="uk-modal-dialog uk-modal-body">
	<button class="uk-modal-close-default" type="button" uk-close></button>
	<div class="uk-modal-header">
		<h2 class="uk-modal-title">Set permissions for <b><?php echo $info->rolename;?></b> role</h2>
	</div>
	<div class="uk-modal-body">
		<?php echo form_open(base_url(), ['class' => 'uk-form-stacked CreatePermissionsForm', 'method' => 'POST', 'data-action' => 'savepermissions', 'data-controller' => 'teams']); ?>
			<table class="uk-table uk-table-hover uk-table-divider uk-table-small">
				<thead>
					<tr>
						<th>Menu name</th>
						<th>Can view</th>
						<th>Can add</th>
						<th>Can edit</th>
						<th>Can delete</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach( $lists as $list ): ?>
						<tr>
							<td><?php echo $list->menulabel;?></td>
							<td><input type="checkbox" class="uk-checkbox" name="actionid[<?php echo $list->menuid;?>][]" value="canview" <?php echo ( getActionAppLabel($list->actionlabel,'canview')? 'checked="checked"' : '');?> <?php echo ( $this->userinfo->roleid == $info->roleid ? 'disabled' : '');?>></td>
							<td><input type="checkbox" class="uk-checkbox" name="actionid[<?php echo $list->menuid;?>][]" value="canadd" <?php echo ( getActionAppLabel($list->actionlabel,'canadd')? 'checked="checked"' : '');?> <?php echo ( $this->userinfo->roleid == $info->roleid ? 'disabled' : '');?>  <?php echo ( in_array($list->menuname, $AppArrayLists) ? 'hidden' : '');?>></td>
							<td><input type="checkbox" class="uk-checkbox" name="actionid[<?php echo $list->menuid;?>][]" value="canedit" <?php echo ( getActionAppLabel($list->actionlabel,'canedit')? 'checked="checked"' : '');?> <?php echo ( $this->userinfo->roleid == $info->roleid ? 'disabled' : '');?> <?php echo ( in_array($list->menuname, $AppArrayLists) ? 'hidden' : '');?>></td>
							<td><input type="checkbox" class="uk-checkbox" name="actionid[<?php echo $list->menuid;?>][]" value="candelete" <?php echo ( getActionAppLabel($list->actionlabel,'candelete')? 'checked="checked"' : '');?> <?php echo ( $this->userinfo->roleid == $info->roleid ? 'disabled' : '');?> <?php echo ( in_array($list->menuname, $AppArrayLists) ? 'hidden' : '');?>></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div class="uk-text-right uk-mrgin">
				<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
				<?php if( $this->userinfo->roleid != $info->roleid) : ?> 
				<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('CreatePermissionsForm','Update');">Update</button>
				<?php endif; ?>
			</div>
		<input type="hidden" name="roleid" value="<?php echo $roleid;?>">
		<?php echo form_close(); ?>
	</div>
</div>