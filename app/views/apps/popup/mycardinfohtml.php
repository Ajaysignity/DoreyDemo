<?php defined('BASEPATH') OR exit('No direct script access allowed'); $billinginfo = json_decode($Orderinfo->billinginfo);?>
<div class="uk-modal-dialog uk-modal-body">
	<?php echo form_open(base_url(), 'class="uk-form-stacked SavesubNewForm" method="POST" data-action="upgradeCardDetails" data-controller="accounts"');?>
		<div uk-grid>
			<h4 class="uk-width-1-1 uk-margin-small-top uk-text-bold">Payment Information</h4>
			<div class="uk-margin-small-top uk-width-1-1@s">
				<label class="uk-text-normal uk-display-block">Name on card<span class="assist">*</span></label>
				<input class="uk-input required  uk-form-width-large" type="text" name="cardholdername" required>
			</div>
			<div class="uk-margin-small-top uk-width-1-1@s resist">
				<label class="uk-text-normal uk-display-block ">Card number<span class="assist">*</span></label>
				<div class="uk-inline">
					<span class="uk-form-icon uk-form-icon-flip" uk-icon="credit-card"></span>
					<input class="uk-input required  uk-form-width-large" type="text" name="cardnumber" required> 
				</div>
			</div>
			<div class="uk-margin uk-width-1-2@s">
				<label class="uk-text-normal uk-display-block" style="display: flex;">Start date (MM/YY)<span class="assist">*</span></label>
				<?php echo form_dropdown('cardstartmonthdate',array(''=>'Month')+$this->months,'','class="uk-input uk-form-width-small  required" required'); ?>
				<?php echo form_dropdown('cardstartyeardate',array(''=>'YY')+YearDropdown(),'','class="uk-input uk-form-width-small  required" required'); ?>
			</div>
			<div class="uk-margin uk-width-1-2@s">
				<label class="uk-text-normal uk-display-block" style="display: flex;">Expiry date (MM/YY)<span class="assist">*</span></label>
				<?php echo form_dropdown('cardexpirymonthdate',array(''=>'Month')+$this->months,'','class="uk-input uk-form-width-small required" required'); ?>
				<?php echo form_dropdown('cardexpiryyeardate',array(''=>'YY')+YearDropdown(true),'','class="uk-input uk-form-width-small  required" required'); ?>
			</div>
			<div class="uk-margin-small-top uk-width-1-2@s resist">
				<label class="uk-text-normal uk-display-block ">CVV<span class="assist">*</span></label>
				<div class="uk-inline">
					<span class="uk-form-icon uk-form-icon-flip" uk-icon="info"></span>
					<input required class="uk-input required uk-input uk-form-width-normal" type="text" name="cardcvvnumber" autocomplete="off" onkeypress="return ValidateNumberOnly(event)" data-uk-tooltip title="<p>The CVV code (Card Verification Value) is a three-digit number <br/>usually located on the back of the card, although in some cases it may be found on the front.</p>">
				</div>
			</div>
			<div class="uk-width-1-1 uk-margin-small-top uk-margin-small-bottom excceedamountdiv">
				<label><input name="termcheck" value="true" class="uk-checkbox" type="checkbox" required> I agree to the Financial Projector <a target="_blank" href="<?php echo website_url('term-and-conditions');?>">Terms & Conditions</a> </label>
			</div>
			<div class="uk-width-1-1 uk-margin-small-top uk-margin-small-bottom excceedamountdiv">
				<label><input name="authcheck" value="true" class="uk-checkbox" type="checkbox" required> I authorise Financial Projector to send instructions to my card issuer to take payments from my card account in accordance with the terms of my agreement with you</label>
			</div>
		</div>
		<div class="uk-text-right">
			<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('SavesubNewForm','Save Card');">Save Card</button>
			<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
			<input type="hidden" name="addressline1" value="<?php echo (isset($billinginfo->line1) ? $billinginfo->line1 : ''); ?>">
			<input type="hidden" name="usercity" value="<?php echo (isset($billinginfo->city) ? $billinginfo->city : ''); ?>">
			<input type="hidden" name="userpostcode" value="<?php echo (isset($billinginfo->postcode) ? $billinginfo->postcode : ''); ?>">
			<input type="hidden" name="countryCode" value="<?php echo (isset($billinginfo->countryCode) ? $billinginfo->countryCode : ''); ?>">
		</div>
	<?php echo form_close(); ?>
</div>