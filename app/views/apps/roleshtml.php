<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div uk-grid class="uk-grid-collapse" uk-height-viewport="expand: true">
	<div class="uk-width-expand@m">
		<div class=" uk-padding">
			    <ul class="uk-breadcrumb">
					<li><a href="<?php echo website_url('apps'); ?>">Home</a></li>
					<li><a href="<?php echo website_url($this->controller.'/settings');  ?>">Settings</a></li>
					<li class="uk-active"><span>Organisation role master</span></li>
				</ul>
			<hr>
			<div class="uk-grid-divider uk-child-width-expand@s"  uk-grid>
				<div>
					<p>Create, edit and view Organisation roles. </p>
		
					<button class="uk-button uk-button-default uk-margin-small-bottom uk-border-pill uk-text-capitalize <?php echo HasAppMenuAccess('organisation_role','canadd');?>" type="button" uk-toggle="target: #createnewrole_popup">Create new role</button>
				</div>
				<div>
				<form class="uk-form-stacked">
					<div class="uk-margin">
						<label class="uk-form-label" for="search">Search</label>
							<div class="uk-form-controls">
								<input class="uk-input uk-form-width-large" id="ajax-search-input" type="text" placeholder="Search..." >
							</div>
						</div>
					</form>
				</div>
			</div>
			<hr>
			<table class="uk-table uk-table-hover uk-table-divider uk-table-small" id="datatableCommon" data-action="roles_json" data-mode="rolelists">
				<thead>
					<tr>
						<th>Role name</th>
						<th>Description</th>
						<th>Status</th>
						<th>Created on</th>
						<th class="uk-text-center">Permissions</th>
						<th class="uk-text-right">Action</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>