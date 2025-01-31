<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div uk-grid class="uk-grid-collapse" uk-height-viewport="expand: true">
	<div class="uk-container" style="padding: 3%;">
		<ul class="uk-breadcrumb">
			<li><a href="<?php echo website_url('apps'); ?>">Home</a></li>
			<li class="uk-active"><span>Settings</span></li>
		  </ul>
		<hr>
		<div class="uk-child-width-1-3@s uk-grid-match" uk-grid>
			<div class="<?php echo HasAppMenuAccess('myteams','canview');?>">
				<div class="uk-card uk-card-default uk-card-hover uk-card-body" onclick="window.location='<?php echo website_url($this->controller.'/myteam');?>'" style="cursor: pointer">
					<h3 class="uk-card-title">My team</h3>
					<p>Create new users and edit details of existing users.</p>
				</div>
			</div>
			<div class="<?php echo HasAppMenuAccess('organisation_role','canview');?>">
				<div class="uk-card uk-card-default uk-card-hover uk-card-body" onclick="window.location='<?php echo website_url($this->controller.'/roles'); ?>'" style="cursor: pointer">
					<h3 class="uk-card-title">Organisation role master</h3>
					<p>Create, edit and view organisation roles.</p>
				</div>
			</div>
			<div class="<?php echo HasAppMenuAccess('account_settings','canview');?>" hidden>
				<div class="uk-card uk-card-default uk-card-hover uk-card-body" onclick="window.location='<?php echo website_url($this->controller.'/accounts');?>'" style="cursor: pointer">
					<h3 class="uk-card-title">Account settings</h3>
					<p>Edit or upgrade your subscription plan and download invoices.</p>
				</div>
			</div>
			<div class="<?php echo HasAppMenuAccess('branding','canview');?>">
				<div class="uk-card uk-card-default uk-card-hover uk-card-body" onclick="window.location='<?php echo website_url('apps/styling');?>'" style="cursor: pointer">
					<h3 class="uk-card-title">Branding</h3>
					<p>Upload your company logo.</p>
				</div>
			</div>
		   <div class="<?php echo HasAppMenuAccess('integrations','canview');?>" hidden>
				<div class="uk-card uk-card-default uk-card-hover uk-card-body" onclick="window.location='<?php echo website_url('integration');?>'" style="cursor: pointer">
					<h3 class="uk-card-title">Integrations</h3>
					<p>Connect other third party providers.</p>
				</div>
			</div>
		</div>
    </div>
</div>