<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<fieldset class="uk-fieldset info_form solutionsettingsinfoform" style="display:none;">
	<legend class="uk-legend"><?php echo $info->Solution;?></legend>
	<h6>Solution setting</h6>
	<ul class="solution_form">

		<li class="uk-margin">
            <label>How would you like to measure time?</label>
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid radio_inline">
                <label><input class="uk-radio" type="radio" name="RadioTime" checked value="Age" id="setting_age"> Age</label>
                <label><input class="uk-radio" type="radio" name="RadioTime" value="CalendarYears" id="setting_age"> Calendar years</label>
                <label><input class="uk-radio" type="radio" name="RadioTime" value="Time" id="setting_age"> Year from today</label>
            </div>
		</li>
		<li class="uk-margin">
            <label>Would you like to see output in real or nominal terms?</label>
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid radio_inline">
                <label><input class="uk-radio" type="radio" name="RadioReal" checked value="Real" id="SelectReal1"> Real</label>
                <label><input class="uk-radio" type="radio" name="RadioReal" value="Nominal" id="SelectReal1"> Nominal</label>
            </div>
		</li>
        <li class="uk-margin">
            <label>Would you like the chart to show negative values of wealth?</label>
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid radio_inline">
                <label><input class="uk-radio" type="radio" name="RadioPosOrNegChart" checked value="PositiveOnly_Y"  id="setting_NegPos" > Show positive values only</label>
                <label><input class="uk-radio" type="radio" name="RadioPosOrNegChart" value="AllowNegative_Y"  id="setting_NegPos" > Allow negative values</label>
            </div>
		</li>
        <li class="uk-margin">
            <label>Screen Hints:</label>
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid radio_inline">
                <label><input class="uk-radio" type="radio" name="screenhits" checked id="setting_ScreenHit" value="1" checked> On</label>
                <label><input class="uk-radio" type="radio" name="screenhits" id="setting_ScreenHit" value="0"> Off</label>
            </div>
		</li>
        <li class="uk-margin">
        <label>Projection events</label>
        <div class="invest_li" >
                <div class="uk-form-controls">
                    <p>Choose between normal and mean reverting markets, and add a market downturn to test different economic scenarios.</p>
                    <div class="uk-flex uk-flex-right cc_btns">
                        <button type="button" class="uk-button uk-button-default uk-margin-small-bottom uk-border-pill uk-text-capitalize yellow_btn addprojectioneventrow" aria-expanded="false" data-CashFlowitem="1" aria-expanded="false">Add market downturn</button>
                    </div>
                    <table class="table projectioneventgridcashflow_table investmentcashflowrowTableCommon solutionform_projectioneventgrid_table_1">
                        <tbody></tbody>
                    </table>
                </div>
            </div>
		</li>
        <li class="uk-margin">
            <label class="uk-form-label">Currency</label>
            <div class="uk-form-controls">
                <select class="uk-select curentcurrencysetting"  name="currency" id="setting_Currency">
              <!--       <option value="&#163" selected>£</option>
                    <option value="&#36">$</option> -->
                      <option value="0" selected>£</option>
                    <option value="1">$</option>
                </select>
            </div>
        </li>
		<li class="uk-margin">
		<button type="button" data-formtype="settingsinfo" class="uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-uppercase white_btn discmisssolutionformpopup" aria-expanded="false" onclick="ClickcollectionAllTypeOfData();">Cancel</button>
		<button type="button" data-formtype="settingsinfo" class="uk-button uk-button-default uk-border-pill uk-text-uppercase blue_btn discmisssolutionformpopup" aria-expanded="false" onclick="ClickcollectionAllTypeOfData('setting_btn');">Confirm</button>
		</li>
	</ul>
</fieldset>