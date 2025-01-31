<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<section class="uk-section" uk-height-viewport="expand: true">
	<div class="uk-container">
		<div style="margin: 0 auto;width: 40%;">
			<div class="uk-card uk-card-default uk-card-body">
				<h2 class="uk-modal-title">Sign up</h2>
				<?php echo form_open(base_url(), 'class="uk-form-stacked generatepasswordForm" method="POST" data-action="'. (!empty($access) ? 'saveDFMgeneratepassword' : 'savegeneratepassword').'"');?>
					<!--<div class="uk-margin">
						<label class="uk-form-label" for="username">User name</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" disabled value="<?php //echo $info->username;?>">
						</div>
					</div>-->
					<div class="uk-margin">
						<label class="uk-form-label" for="username">Email</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" disabled value="<?php echo $info->email;?>">
						</div>
					</div>
					<div class="uk-margin">
						<label class="uk-form-label" for="password">Set password</label>
						<div class="uk-form-controls">
							<input class="uk-input" name="new_password" type="password" placeholder="Set password" autocomplete="off" data-uk-tooltip title="<div class='custom-passwordtoolip'>Passwords must include:<ul><li>At least 8 characters - the more characters, the better.</li><li>A mixture of both uppercase and lowercase letters.</li><li>Both letters and numbers.</li><li>At least one special character, e.g., ! @ # ? ]</li></ul></div>">
						</div>
					</div>
					<div class="uk-margin">
						<label class="uk-form-label" for="password">Re-enter password</label>
						<div class="uk-form-controls">
							<input class="uk-input" name="confirm_password" type="password" placeholder="Re-enter password" autocomplete="off" data-uk-tooltip title="<div class='custom-passwordtoolip'>Passwords must include:<ul><li>At least 8 characters - the more characters, the better.</li><li>A mixture of both uppercase and lowercase letters.</li><li>Both letters and numbers.</li><li>At least one special character, e.g., ! @ # ? ]</li></ul></div>">
						</div>
					</div>
					<div class="uk-text-right">
						<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('generatepasswordForm','Next');">Next</button>
					</div>
					<input type="hidden" name="secretkey" value="<?php echo $secretkey; ?>">
					<input type="hidden" name="secrettoken" value="<?php echo $token; ?>">
					<input type="hidden" name="accesscode" value="<?php echo $access; ?>">
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>