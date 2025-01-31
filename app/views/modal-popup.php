<div id="common_view_modalpopup" uk-modal></div>
<div id="createnewrole_popup" class="ukmodalpopup_role" uk-modal="bg-close: false">
	<div class="uk-modal-dialog uk-modal-body">
		<?php echo form_open(base_url(), 'class="uk-form-stacked CreateRoleForm" method="POST" data-action="saveroles" data-controller="teams"');?>
			<div class="uk-margin">
				<label class="uk-form-label" for="rolename">Organisation role name</label>
				<div class="uk-form-controls">
				<input class="uk-input" type="text" value="" name="rolename" required>
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label" for="description">Description (optional)</label>
				<div class="uk-form-controls">
				<input class="uk-input" type="text" value="" name="description">
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label" for="role">Status</label>
				<div class="uk-form-controls">
					<div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
						<label><input class="uk-radio" type="radio" name="isactive" value="1">
						 Active</label>
						<label><input class="uk-radio" type="radio" name="isactive" value="0" checked="checked"> Inactive</label>
					</div>
				</div>
			</div>
			<div class="uk-text-right">
				<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
				<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('CreateRoleForm','Create');">Create</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>





<div id="support_form" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<h2 class="uk-modal-title">Support</h2>
		<p>How can we help? Start by checking our <a href="<?php echo website_url('faqs');?>">User Guide </a>page. <br/>
		Alternatively, please outline your query below<br/></p>
			<?php echo form_open(base_url(), 'class="uk-form-stacked SaveSupportForm" method="POST" data-action="savesupportdata" data-controller="dashboard"');?>
			<div class="uk-margin">
				<label class="uk-form-label" for="username">Name</label>
				<div class="uk-form-controls">
				<input class="uk-input" type="text" value="<?php echo (isset($this->userinfo) ? $this->userinfo->firstname.' '.$this->userinfo->surname : '');?>" disabled>
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label" for="account">Account</label>
				<div class="uk-form-controls">
				<input class="uk-input" type="text" value="<?php echo (isset($this->userinfo) ? $this->userinfo->OrganisationName : '');?>" disabled>
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label" for="email">Email address</label>
				<div class="uk-form-controls">
				<input class="uk-input" type="email" value="<?php echo (isset($this->userinfo) ? $this->userinfo->email : '');?>" disabled>
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label" for="support-subject">Subject</label>
				<div class="uk-form-controls">
				<input class="uk-input" name="supportsubject" type="text" placeholder="Subject" required>
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label" for="support-message">Message</label>
				<div class="uk-form-controls">
				<textarea class="uk-textarea" name="supportmessage" rows="5" placeholder="What's your message..." required></textarea>
				</div>
			</div>
			<div class="uk-text-right">
				<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
				<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('SaveSupportForm','Send');">Send</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div id="addnewsolution" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
			<?php echo form_open(base_url(), 'class="uk-form-stacked SaveNewSolutionForm" method="POST" data-action="savenewsolutionfolder" data-controller="solutions"');?>
			<div class="uk-margin">
				<label class="uk-form-label" for="add-solution">Create new solution</label>
				<div class="uk-form-controls">
					<input class="uk-input" name="solutiontype" type="text" placeholder="Solution name..." required>
					<input name="ModelType" type="hidden" value="CashflowModel">
					<input name="ScreenType" type="hidden" value="mysolutions">
				</div>
			</div>
			<div class="uk-text-right">
				<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
				<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateSolutionFormSubmit('SaveNewSolutionForm','Continue');">Continue</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div id="addnewfolder" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
			<?php echo form_open(base_url(), 'class="uk-form-stacked SaveNewFolderForm" method="POST" data-action="savenewsolutionfolder" data-controller="solutions"');?>
			<div class="uk-margin">
				<label class="uk-form-label" for="add-solution">Add folder</label>
				<div class="uk-form-controls">
					<input class="uk-input" name="solutiontype" type="text" placeholder="folder name..." required>
					<input name="ModelType" type="hidden" value="Folder">
					<input name="foldertype" type="hidden" value="parent">
					<input name="ScreenType" type="hidden" value="mysolutions">
				</div>
			</div>
			<div class="uk-text-right">
				<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
				<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateSolutionFormSubmit('SaveNewFolderForm','Continue');">Save</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div id="otp_regmodel" uk-modal="bg-close: false">
	<div class="uk-modal-dialog uk-modal-body">
		<h2 class="uk-modal-title">Two factor authentication </h2>
			<?php echo form_open(base_url(), 'class="uk-form-stacked verifymobileotpForm" method="POST" data-action="updatecurrentprofile" data-controller="dashboard"');?>
			<div class="uk-margin">
				<label class="uk-form-label" for="otp">Please insert the verification code we sent to email/mobile number ending <span id="endingmobilenumber"></span></label>
				<div class="uk-form-controls">
					<input class="uk-input" name="mobileotpnumber" type="text" placeholder="verification code" required>
				</div>
			</div>
			<div class="uk-text-right">
				<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('verifymobileotpForm','Continue');">Continue</button>
			</div>
			<input name="action" type="hidden" value="verifiedOTPmobile">
		<?php echo form_close(); ?>
	</div>
</div>

<div id="edit-account-name" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<?php echo form_open(base_url(), 'class="uk-form-stacked OrganisationForm" method="POST" data-action="updateorganisation" data-controller="teams"');?>
			<div class="uk-margin">
				<label class="uk-form-label" for="account-name">Edit account name</label>
				<div class="uk-form-controls">
					<input class="uk-input" name="OrganisationName" type="text" value="<?php echo (isset($this->userinfo) ? $this->userinfo->OrganisationName : '');?>" autocomplete="off" required>
				</div>
			</div>
			<div class="uk-text-right">
				<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
				<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('OrganisationForm','Save');">Save</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div id="modal-create-new-assumption" uk-modal>
	<div class="uk-modal-dialog">
		<?php echo form_open(base_url(), 'class="uk-form-stacked AssumptionsForm" method="POST" data-action="saveassumptionemodelsdata" data-controller="assumptions"');?>
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<div class="uk-modal-header">
				<h2 class="uk-modal-title">Create new assumption</h2>
			</div>
			<div class="uk-modal-body">
				<div class="uk-margin">
					<label class="uk-form-label" for="new-assumption-name">Select model name</label>
					<div class="uk-form-controls">
						<?php //echo assumptionSelects();?>
						<input class="uk-input" id="expensenewassumptionname" type="text" placeholder="Name for new assumption" name="suggestedmodelname">
					</div>
					<div class="uk-margin">
						<label class="uk-form-label" for="new-assuption-date-referred">Input date referred to</label>
						<div class="uk-form-controls">
							<input class="uk-input referred_date" id="" name="referred_date" type="text" placeholder="Date referred to... 31/12/2021a">
						</div>
					</div>
					<div class="uk-margin">
						<label class="uk-form-label"><span class="uk-text-meta">Alternatively Upload Assumption Entry<a class="uk-link-text uk-align-right" href="javascript:void(0);" onClick="window.location.href='<?php echo assets_url('sample-assumptionentrycsv.csv');?>'">Download Sample</a></span></label>
					</div>
					<div class="uk-margin">
						<label class="uk-form-label">Upload Excel Asset File ( Only CSV file )</label>
						<div class="uk-form-controls">
							<input type="file" name="importexcelsheet_asset" > 
						</div>
					</div>
					<div class="uk-margin">
						<label class="uk-form-label">Upload Excel Portfoliio File ( Only CSV file )</label>
						<div class="uk-form-controls">
							<input type="file" name="importexcelsheet_port" > 
						</div>
					</div>
				</div>
			</div>
			<div class="uk-modal-footer uk-text-right">
				<div class="uk-margin-small-bottom">
					<button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
					<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('AssumptionsForm','Update Manaully');">Update Manaully</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>






<div id="UpgdareSubscriptionPopupForm" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<?php echo form_open(base_url(), 'class="uk-form-stacked " ');?>
			<div class="uk-margin">
				<h3>Access denied.</h3>
			</div>
			<?php //if($this->userinfo->PowerUser == 1 && CheckTrialSubscription() == 'plan expired' ) { ?>
				<!-- <div class="uk-margin">
					<p>To add more users, you have to reactivate or upgrade your Plan, your plan has been expired, Please go to Account Settings.</p>
					<div class="uk-text-right">
					<a href ="<?php echo site_url('/accounts/subscription');?>" class="uk-button uk-button-default uk-border-pill">Account Setting</a>
					<button class="uk-button uk-button-default uk-modal-close uk-border-pill" id="closebtn" type="button">Cancel</button>
					</div>
				</div> -->
			<?php //}else if($this->userinfo->PowerUser == 1) {?>
			<?php  if($this->userinfo->PowerUser == 1) {?>
				<div class="uk-margin">
					<p>To add more users, you have to upgrade your Account, go to Account Settings and update your payment settings.</p>
					<div class="uk-text-right">
					<a href ="<?php echo site_url('/accounts/subscription');?>" class="uk-button uk-button-default uk-border-pill">Account Setting</a>
					<button class="uk-button uk-button-default uk-modal-close uk-border-pill" id="closebtn" type="button">Cancel</button>
					</div>
				</div>
			<?php } else { ?>
				<div class="uk-margin">
					<p>You can continue to view your solutions but you will not be able to create anything new. Please speak to the Super User to reactive the account.</p>
				</div>
				<div class="uk-text-right">
					<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
				</div>
			<?php } ?>
		<?php echo form_close(); ?>
	</div>
</div>

<div id="accountsupport_form" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<h2 class="uk-modal-title">Account Support</h2>
		<p>How can we help? Start by checking our <a href="<?php echo website_url('dashboard/faqs');?>">Frequently Asked Questions (FAQs) </a>page. <br/>
		Alternatively, please outline your query below <br/></p>
			<?php echo form_open(base_url(), 'class="uk-form-stacked SaveSupportForm" method="POST" data-action="savesupportdata" data-controller="dashboard"');?>
			<div class="uk-margin">
				<label class="uk-form-label" for="username">Name</label>
				<div class="uk-form-controls">
				<input class="uk-input" type="text" value="<?php echo (isset($this->userinfo) ? $this->userinfo->firstname.' '.$this->userinfo->surname : '');?>" disabled>
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label" for="account">Account</label>
				<div class="uk-form-controls">
				<input class="uk-input" type="text" value="<?php echo (isset($this->userinfo) ? $this->userinfo->OrganisationName : '');?>" disabled>
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label" for="email">Email address</label>
				<div class="uk-form-controls">
				<input class="uk-input" type="email" value="<?php echo (isset($this->userinfo) ? $this->userinfo->email : '');?>" disabled>
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label" for="support-subject">Subject</label>
				<div class="uk-form-controls">
				<input class="uk-input" name="supportsubject" type="text" placeholder="Subject" required>
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label" for="support-message">Message</label>
				<div class="uk-form-controls">
				<textarea class="uk-textarea" name="supportmessage" rows="5" placeholder="What's your message..." required></textarea>
				</div>
			</div>
			<div class="uk-text-right">
				<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
				<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('SaveSupportForm','Send');">Send</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div id="export-orgnisation-data" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<?php echo form_open(base_url(), 'class="uk-form-stacked OrganisationForm" method="POST" data-action="updateorganisation" data-controller="teams"');?>
			<div class="uk-margin">
				<p>Export your user settings and solutions for safe keeping</p>
			</div>
			<div class="uk-margin">
				<label><input name="exporttype" value="users" class="uk-radio" type="radio" required> Export user settings</label>
			</div>
			<div class="uk-margin">
				<label><input name="exporttype" value="solutions" class="uk-radio" type="radio" required> Export solutions</label>
			</div>
			<div class="uk-margin">
				<p>This export generates a ZIP file containing files in CSV format. This provides a handy copy of your data for backup or transfer. When the ZIP file is ready it will be emailed to you using the email address <?php echo $this->userinfo->email;?>.</p>
			</div>
			<div class="uk-text-right">
				<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
				<button class="uk-button uk-button-primary uk-border-pill" type="button" >Export to ZIP file</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div id="exceeds-orgnisation-amount" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<?php echo form_open(base_url(), 'class="uk-form-stacked exceedsamountForm" method="POST" data-action="exceedsamountsave" data-controller="accounts"');?>
			<div class="uk-margin">
				<p>One of the team at Financial Projector will be in touch with you to discuss payment options for over 50 users. Select CONFIRM and you’ll receive a confirmation email shortly. </p>
			</div>
			<div class="uk-text-right">
				<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
				<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('exceedsamountForm','Contact us');">Contact us</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div id="searchsolutionpopup" uk-modal class="searchpopup">
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Search results</h2>
        </div>
        <div class="uk-modal-body">
           <div class="folder_search">
			<div class="uk-grid-small" uk-grid>
				<div class="uk-width-1-1">
					<div class="uk-overflow-auto">
						<table class="uk-table uk-table-hover uk-table-divider uk-table-small" id="SearchSolutionDataTableColmn" data-action="mysolutions_json" data-mode="mysolutions" style="width:100%;">
							<thead>
								<tr>
									<th>Solutions</th>
									<th class="uk-text-right">Location</th>
								</tr>
							</thead>
							<tbody class="uk-modal-body" uk-overflow-auto="">
								<tr>
									<td style="text-align:center;">
										<img src="<?php echo assets_url('dash/pix/ajax-loader.gif'); ?>">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
    	</div>
        </div>
    </div>
</div>