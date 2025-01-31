<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<fieldset class="uk-fieldset info_form solutionincomeinfoform" style="display:none;">
	<legend class="uk-legend uk-text-capitalize">Client A</legend>
	<h6 class="uk-text-capitalize">Income Sources</h6>
	<p>Use these templates to add income sources, or create your own</p>
	<ul class="solution_form commonincomegridform">
		<li class="uk-margin">
			<input class="uk-input solutionform_incomegridinput_1" type="text" placeholder="Salary" >
			<span>
				<a href="javascript:void(0);" uk-icon="trash" class="trashsolutionform_income" data-item="1"></a>
				<a href="javascript:void(0);" uk-icon="plus" uk-toggle="target: #solutionform_incomegrid_1" class="expandsolutionform incomegrid_1formtoggle"></a>
			</span>
			<div id="solutionform_incomegrid_1" class="uk-grid-small salary_grid" uk-grid hidden>
				<div class="uk-margin uk-width-1-3 uk-flex uk-flex-middle">
					<label>Start</label>
					<select class="uk-select" type="text">
						<option>Now</option>
						<option>Now</option>
						<option>Now</option>
					</select>
				</div>
				<div class="uk-margin uk-width-2-3 uk-flex uk-flex-middle margint0">
					<label class="differ_width">End</label>
					<select class="uk-select " type="text" placeholder="">
						<option>at retirement</option>
						<option>at retirement</option>
						<option>at retirement</option>
					</select>
				</div>
				<div class="uk-margin uk-width-1-3 uk-flex uk-flex-middle">
					<label>Amount</label>
					<input class="uk-input solutionform_incomegridinputAmount_1" type="text" placeholder="£ enter amount">
				</div>
				<div class="uk-margin uk-width-2-3 uk-flex uk-flex-middle">
					<label class="differ_width">Type</label>
					<select class="uk-select " type="text">
						<option>Annual nominal increasing 4%</option>
						<option>Annual nominal increasing 4%</option>
					</select>
				</div>
				<div class="uk-flex uk-flex-right cc_btns">
					<button type="button" class="uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-uppercase white_btn collapsesolutionformtoggle" data-formtype="incomegrid_1" aria-expanded="false">Cancel</button>
					<button type="button" class="uk-button uk-button-default uk-border-pill uk-text-uppercase blue_btn collapsesolutionformtoggle" data-formtype="incomegrid_1" data-popup="confirmed" aria-expanded="false">Confirm</button>
				</div>
			</div>
		</li>
		<li class="uk-margin">
			<input class="uk-input solutionform_incomegridinput_2" type="text" placeholder="State pension" >
			<span>
				<a href="javascript:void(0);" uk-icon="trash" class="trashsolutionform_income" data-item="2"></a>
				<a href="javascript:void(0);" uk-icon="plus" uk-toggle="target: #solutionform_incomegrid_2" class="expandsolutionform incomegrid_2formtoggle"></a>
			</span>
			<div id="solutionform_incomegrid_2" class="uk-grid-small salary_grid" uk-grid hidden>
				<div class="uk-margin uk-width-1-3 uk-flex uk-flex-middle">
					<label>Start</label>
					<select class="uk-select " type="text">
						<option>Retirement</option>
						<option>Retirement</option>
						<option>Retirement</option>
					</select>
				</div>
				<div class="uk-margin uk-width-2-3 uk-flex uk-flex-middle margint0">
					<label class="differ_width">End</label>
					<select class="uk-select " type="text" placeholder="at projection age">
						<option>at projection age</option>
						<option>at projection age</option>
						<option>at projection age</option>
					</select>
				</div>
				<div class="uk-margin uk-width-1-3 uk-flex uk-flex-middle">
					<label>Amount</label>
					<input class="uk-input solutionform_incomegridinputAmount_2" type="text" placeholder="£ enter amount">
				</div>
				<div class="uk-margin uk-width-2-3 uk-flex uk-flex-middle">
					<label class="differ_width">Type</label>
					<select class="uk-select " type="text">
						<option>Monthly real</option>
						<option>Monthly real</option>
						<option>Monthly real</option>
					</select>
				</div>
				<div class="uk-flex uk-flex-right cc_btns">
					<button type="button" class="uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-uppercase white_btn collapsesolutionformtoggle" data-formtype="incomegrid_2" aria-expanded="false">Cancel</button>
					<button type="button" class="uk-button uk-button-default uk-border-pill uk-text-uppercase blue_btn collapsesolutionformtoggle" data-formtype="incomegrid_2" data-popup="confirmed" aria-expanded="false">Confirm</button>
				</div>
			</div>
		</li>
		<li class="uk-margin">
			<input class="uk-input solutionform_incomegridinput_3" type="text" placeholder="Lump sum" >
			<span>
				<a href="javascript:void(0);" uk-icon="trash" class="trashsolutionform_income" data-item="3"></a>
				<a href="javascript:void(0);" uk-icon="plus" uk-toggle="target: #solutionform_incomegrid_3" class="expandsolutionform incomegrid_3formtoggle"></a>
			</span>
			<div id="solutionform_incomegrid_3" class="uk-grid-small salary_grid" uk-grid hidden>
				<div class="uk-margin uk-width-1-3 uk-flex uk-flex-middle">
					<label>Start</label>
					<select class="uk-select " type="text">
						<option>Now</option>
						<option>Now</option>
					</select>
				</div>
				<div class="uk-margin uk-width-2-3 uk-flex uk-flex-middle margint0">
					<label class="differ_width">End</label>
					<select class="uk-select " type="text">
						<option></option>
					</select>
				</div>
				<div class="uk-margin uk-width-1-3 uk-flex uk-flex-middle">
					<label>Amount</label>
					<input class="uk-input solutionform_incomegridinputAmount_3" type="text" placeholder="£ enter amount">
				</div>
				<div class="uk-margin uk-width-2-3 uk-flex uk-flex-middle">
					<label class="differ_width">Type</label>
					<select class="uk-select " type="text" placeholder="">
						<option>One off nominal today</option>
						<option>One off nominal today</option>
						<option>One off nominal today</option>
					</select>
				</div>
				<div class="uk-flex uk-flex-right cc_btns">
					<button type="button" class="uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-uppercase white_btn collapsesolutionformtoggle" data-formtype="incomegrid_3" aria-expanded="false">Cancel</button>
					<button href="javascript:void(0);" class="uk-button uk-button-default uk-border-pill uk-text-uppercase blue_btn collapsesolutionformtoggle" data-formtype="incomegrid_3" data-popup="confirmed" aria-expanded="false">Confirm</button>
				</div>
			</div>
		</li>
	</ul>
	<div class="uk-flex uk-flex-wrap uk-flex-between uk-margin-small-top">
		<button type="button" class="uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-capitalize" uk-toggle="target: #addnewincomegridmodalpopup">Add income Source</button>
		<button type="button" data-formtype="incomeinfo" class="uk-button uk-button-default uk-border-pill uk-text-uppercase white_btn discmisssolutionformpopup" aria-expanded="false">Close</button>
	</div>
</fieldset>
<div id="addnewincomegridmodalpopup" uk-modal bg-close="false">
	<div class="uk-modal-dialog uk-modal-body">
		<div class="uk-margin">
			<label class="uk-form-label" for="add-solution">Add Income Source</label>
			<div class="uk-form-controls">
				<input class="uk-input" class="newincomesourcehtmlval" id="newincomesourcehtmlval" type="text" placeholder="Add Income Source...">
				<label class="newincomesourcehtmlval_error error"></label>
			</div>
		</div>
		<div class="uk-text-right">
			<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
			<button class="uk-button uk-button-primary uk-border-pill addnewincomegrid" type="button">Save</button>
		</div>
	</div>
</div>