<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<section class="uk-section" uk-height-viewport="expand: true">
	<div class="uk-container">
		<div style="margin: 0 auto;width: 40%;">
			<div class="uk-card uk-card-default uk-card-body">
				<h2 class="uk-modal-title">Forgot Password</h2>
                <p>Enter your email address to reset your password.</p>
				<?php echo form_open(base_url(), 'class="uk-form-stacked forgotPasswordFrom" method="POST" data-action="forgotpasswordForm"');?>
					<div class="uk-margin">
						<div class="uk-form-controls">
                        <input class="uk-input uk-form-width-large" name="email" type="email" placeholder="Enter you email" required>
						</div>
					</div>
					<div class="uk-text-right">
                    <button class="uk-button uk-button-default uk-border-pill" type="button" onClick="window.location.href='<?php echo website_url('/');?>'" style="color: #757575 !important;">Cancel</button>
                    <button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateForgotPasswordFormSubmit('forgotPasswordFrom','Sign up');">Send</button>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>