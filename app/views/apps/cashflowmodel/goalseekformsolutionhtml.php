<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<fieldset class="uk-fieldset info_form solutiongoalseekinfoform" style="display:none;">
	<legend class="uk-legend">Client A</legend>
	<h6>Goal Seek</h6>
	<p>Adjust a chosen pot’s amount, keeping all other pots unchanged, by setting the pot value to a selected amount at a chosen time and specified level of security (confidence level).</p>
	<ul class="solution_form goal_seek">
		<li class="uk-margin uk-flex solutiongoalseekinfo_potlist">
			<label>Select pot</label>
			<select class="uk-select" type="text">
				<option>choose pot</option>
				<option value="1">Investment pot 1</option>
			</select>
		</li>
		<div class="uk-grid-small uk-grid">
			<li class="uk-margin uk-flex uk-width-1-2 uk-margin-small-top">
				<label>Set pot value</label>
				<input class="uk-input idGoalSeekPotValue" type="number" placeholder="£">
			</li>
			<li class="uk-margin uk-flex uk-width-1-2 uk-margin-small-top">
				<select class="uk-select idGoalSeekRealNominal">
					<option value="Real">Real</option>
					<option value="Nominal">Nominal</option>
				</select>
			</li>
		</div>
			<li class="uk-margin uk-flex uk-width-1-1">
				<label>With security</label>
				<select class="uk-select idGoalSeekPercentile">
					<?php foreach($withsecuritylists as $key=>$withsecuritylist ):?>
						<option value="<?php echo str_replace('th','',$withsecuritylist); ?>"><?php echo $withsecuritylist; ?></option>
					<?php endforeach;?>
				</select>
			</li>
		
		<li class="uk-margin uk-flex">
			<label>At time</label>
			<select class="uk-select LoadgoalseekprojectionAtTimelisttab">
			<?php foreach($Defaultgoalseekprojection as $key=>$Defaultgoalseekprojection ):?>
				<option value="<?php echo $key; ?>"><?php echo $Defaultgoalseekprojection; ?></option>
			<?php endforeach;?>
			</select>
		</li>
		<li class="uk-margin uk-flex solutiongoalseekinfo_cashFlowlist">
			<label>By changing</label>
			<select class="uk-select">
				<option>Choose cashflow</option>
			</select>
		</li>
		<li class="uk-margin uk-flex cashflowoutputsection uk-hidden">
		
			<div class="invest_li" style="width: 80%; border: none;">
                <div class="uk-form-controls&quot;">
                    <p>OUTFLOW</p>
					<p>£20,000</p>
					<p>Annual real</p>
					<p>Start: Retirement</p>
					<p>End: to projection age</p>
					<p>Indicator</p>
					<p>Probability of shortfall: 98.1%</p>
					<p>Expected shortfall: -£812,000</p>
                </div>
            </div>
			<div class="invest_li" style="width: 80%; border: none;">
                <div class="uk-form-controls&quot;">
				<p>OUTFLOW</p>
					<p>£20,000</p>
					<p>Annual real</p>
					<p>Start: Retirement</p>
					<p>End: to projection age</p>
					<p>Indicator</p>
					<p>Probability of shortfall: 98.1%</p>
					<p>Expected shortfall: -£812,000</p>
                </div>
            </div>
		</li>
		<li class="uk-flex uk-flex-wrap uk-flex-center cc_btns uk-margin-small-top">
			<button type="button" data-formtype="goalseekinfo" class="uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-uppercase white_btn discmisssolutionformpopup" aria-expanded="false" onclick="ClickcollectionAllTypeOfData();">Cancel</button>
			<button onclick="collectGoalSeekInputs(this);" type="button" class="uk-button uk-button-default uk-border-pill uk-text-uppercase yellow_btn" aria-expanded="false">Solve</button>
		</li>
	</ul>
</fieldset>