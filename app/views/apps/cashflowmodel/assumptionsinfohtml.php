<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<fieldset class="uk-fieldset info_form solutionassumptionsinfoform" style="display:none;">
	<legend class="uk-legend"><?php echo $info->Solution;?></legend>
	<h6>Assumptions</h6>
	<ul class="solution_form">
        <li class="uk-margin">
            <label class="uk-form-label">Assumption</label>
            <div class="uk-form-controls apiassumptionlists">
			<?php echo form_dropdown('assumption_name',$assumptionlists,'','class="uk-select uk-margin-small-bottom assumption_name_select" required');?>
            </div>
        </li>
		<li class="uk-flex uk-flex-wrap uk-flex-center cc_btns uk-margin-small-top">
		<button type="button" data-formtype="assumptionsinfo" class="uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-uppercase white_btn discmisssolutionformpopup" aria-expanded="false" onclick="ClickcollectionAllTypeOfData();">Cancel</button>
		<a type="button" class="uk-button uk-button-default uk-border-pill uk-text-uppercase blue_btn" aria-expanded="false" href="<?php echo website_url('assumptions'); ?>" target="_blank">View more</a>
		</li>
	</ul>
</fieldset>