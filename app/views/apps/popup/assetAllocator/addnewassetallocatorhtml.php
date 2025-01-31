<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="uk-modal-dialog uk-modal-body">
	<h2 class="uk-modal-title">New allocation</h2>
    <p>Set up basic client information.</p>
	<?php echo form_open(base_url(), 'class="uk-form-stacked SaveDataForm" method="POST" data-action="saveallocatorbasicinfo" data-controller="assetallocator"');?>
		<div class="uk-margin">
			<label class="uk-form-label" for="aa-name">Name*</label>
			<div class="uk-form-controls">
				<input class="uk-input required" name="clientname" type="text" value="<?php echo (isset($UserInfo->OrganisationName) ? $UserInfo->OrganisationName : ''); ?>" placeholder="Clients name" required>
			</div>
		</div>
		<div class="uk-margin" hidden>
			<label class="uk-form-label" for="aa-report-date">Report date*</label>
			<div class="uk-form-controls">
				<input class="uk-input required ReportDate"  value="<?php echo date('d/m/Y');?>" name="reportdate___" type="text" readonly>
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="aa-introducer">Introducer</label>
			<div class="uk-form-controls">
				<input class="uk-input" name="introducer" type="text" value="" placeholder="Introducers name">
			</div>
		</div> 
		<div class="uk-margin">
			<label class="uk-form-label" for="aa-currency">Select Assumptions*</label>
			<div class="uk-form-controls AssumptionSelectContainer">
				<?php echo form_dropdown('reportdate',array(''=>'choose')+$DisplayNames,$info->displayname,'class="uk-select required" required'); ?>
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="aa-currency">Reference currency*</label>
			<div class="uk-form-controls">
				<?php echo form_dropdown('referencecurrency',$Currencies,'','class="uk-select required" required'); ?>
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="aa-portfolio">Proposed portfolio strategy*<span class="RegeneratePortfolioStrategy"></span></label>
			<div class="uk-form-controls PortfoliosSelectContainerByAssumption">
				<?php echo form_dropdown('portfoliostrategy',$PortfolioNames,'','class="uk-select required" required'); ?>
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="aa-min-time-horizon">Minimum time horizon, years</label>
			<div class="uk-form-controls">
				<input class="uk-input" id="minimumhorizon" type="text" value="1" disabled>
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="aa-tartet-return">Target annualised return CPI +x%</label>
			<div class="uk-form-controls">
				<input class="uk-input" id="annualreturn" type="text" value="0%" disabled>
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="aa-avoid-drawdown">Avoid 12 month drawdown of x%</label>
			<div class="uk-form-controls">
				<input class="uk-input" id="avoiddrawdown" type="text" value="0%" disabled>
				<input class="uk-input" name="displayname" type="hidden" value="18/07/2023">
			</div>
		</div>
		<div class="uk-text-right">
			<input class="uk-input InitialiseApidata" type="hidden" value="" name="InitialiseApidata">
			<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
			<button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateFormSubmit('SaveDataForm','Confirm');">Confirm</button>
		</div>
	<?php echo form_close(); ?>
</div>
<script>
jQuery(".ReportDate").datepicker({
	format: 'dd/mm/yyyy'
});
</script>