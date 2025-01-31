<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<fieldset class="uk-fieldset info_form solutionbasicinfoform" style="display:none;">
	<legend class="uk-legend"><?php echo $info->Solution;?></legend>
	<h6>Basic information</h6>
	<p>Set up and edit client information</p>
	<ul class="solution_form">
		<li class="uk-margin">
			<input class="uk-input" type="text" name="ClientName" id="ClientName" value="<?php echo $info->Solution;?>" type="text" placeholder="Solution / Client name">
		</li>
		<li class="uk-margin">
			<label>Age</label>
			<div class="slider_range">
			<input class="uk-input"  value="50" type="text" name="Age_value" id="Age_value" type="number" maxlength="2" min="16" max="101" onchange="UpdateAgeInputsBoxes('TypeAge','Age_value', 'Age_slider','Age')">
			<input class="uk-range collectInputData" min="16" max="101" value="50" type="range" id="Age_slider" oninput="SliderAgeOnInput();" style="height: 0;" onchange="SliderAgeOnDrop('TypeAge','Age_value', 'Age_slider','Age')">
			</div>
		</li>
		<li class="uk-margin">
			<label>Retirement age</label>
			<div class="slider_range">
			<input class="uk-input" type="text" placeholder="65" name = "Retirement_value" id="Retirement_value" type="number" maxlength="2" min="50" max="103" value="65" onchange="UpdateAgeInputsBoxes('TypeRetirementAge','Retirement_value', 'Retirement_slider')">
			<input class="uk-range collectInputData" max="103" value="65" type="range" id="Retirement_slider" oninput="SliderAgeOnInput();" style="height: 0;" onchange="SliderAgeOnDrop('TypeRetirementAge','Retirement_value', 'Retirement_slider')">
			</div>
		</li>
		<li class="uk-margin">
			<label>Projection age</label>
			<div class="slider_range">
			<input class="uk-input" type="text" placeholder="100" name="Horizon_value" id="Horizon_value" type="number" maxlength="2" min="16" max="105" value="100" onchange="UpdateAgeInputsBoxes('TypeHorizonAge','Horizon_value', 'Horizon_slider')">
			<input class="uk-range collectInputData"  min="16" max="105" value="100" type="range" id="Horizon_slider" oninput="SliderAgeOnInput();" style="height: 0;" onchange="SliderAgeOnDrop('TypeHorizonAge','Horizon_value', 'Horizon_slider')">
			</div>
		</li>
		<li class="uk-flex uk-flex-wrap uk-flex-center cc_btns uk-margin-small-top">
		<button type="button" data-formtype="basicinfo" class="uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-uppercase white_btn discmisssolutionformpopup" aria-expanded="false" onclick="ClickcollectionAllTypeOfData();">Cancel</button>
		<button type="button" data-formtype="basicinfo" class="uk-button uk-button-default uk-border-pill uk-text-uppercase blue_btn discmisssolutionformpopup" aria-expanded="false" onclick="ClickcollectionAllTypeOfData('confirm_btn');">Confirm</button>
		</li>
	</ul>
</fieldset>