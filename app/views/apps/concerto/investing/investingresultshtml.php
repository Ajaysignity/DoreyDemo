<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div>
    <div class="uk-container">
        <h1 class="atr-growing"><?php echo $this->headerLabel; ?></h1>
        <div class="atr-primary-nav">
            <?php echo doreyjtcSteps('risk'); ?>
            <ul class="uk-child-width-expand uk-margin-small-top" uk-tab>
                <li class="uk-visible@m"
                    onClick="window.location='<?php echo website_url($this->controller.'/investing-risk');?>'"><span
                        class="uk-position-center-left uk-hidden@s atr-progress" style="padding-left: 20px;"><span
                            class="complete"></span> <span class="complete"></span> <span class="complete"></span> <span
                            class="complete"></span> <span class="complete"></span> <span
                            class="complete"></span></span><a>Risk</a></li>
                <li class="uk-active"
                    onClick="window.location='<?php echo website_url($this->controller.'/investing-results');?>'"><span
                        class="uk-position-center-left uk-hidden@s atr-progress" style="padding-left: 20px;"><span
                            class="complete"></span> <span class="complete"></span> <span class="complete"></span> <span
                            class="complete"></span> <span class="complete"></span> <span
                            class="complete"></span></span><a>Projection <i uk-icon="icon: question; ratio: .6" uk-tooltip="title: Your personalised projections are based on your plan information and survey responses to illustrate possible financial outcomes. Please note that financial forecasting involves uncertainty, and there’s no guarantee for these projections.; delay: 500"></i></a></li>
            </ul>
        </div>
        <div class="atr-form-inputs uk-grid-divider" uk-grid>
            <div class="uk-width-2-5@m uk-visible@s">
                <h4>Where am I today&mldr;</h4>
                <div uk-grid class="uk-flex uk-flex-middle uk-grid-small margin-remove-top-child-mobile">
                    <div class="uk-width-1-2@m uk-flex uk-flex-middle uk-flex-right">
                        <h4 class="uk-text-light">Current age</h4>
                    </div>
                    <div class="uk-width-1-2">
                        <h2 class="uk-text-light uk-text-center">
                            <?php echo (isset($horizoninfo->current_age) && !empty($horizoninfo->current_age) ? $horizoninfo->current_age : $this->DefaultCurrentAge); ?>
                        </h2>
                    </div>
                    <div class="uk-width-1-2@m uk-flex uk-flex-middle uk-flex-right">
                        <h4 class="uk-text-light">Current plan value</h4>
                    </div>
                    <div class="uk-width-1-2">
                        <h2 class="uk-text-light uk-text-center"><?php echo $_COOKIE['selectedcurrencyvalue'].number_format($this->DefaultPortValue);?>
                        </h2>
                    </div>
                    <div class="uk-width-1-2@m uk-flex uk-flex-middle uk-flex-right">
                        <h4 class="uk-text-light">Current risk profile</h4>
                    </div>
                    <div class="uk-width-1-2">
                        <h2 class="uk-text-light uk-text-center">
                            <div class="atr-risk-value">
                                <?php echo (isset($riskinfo->risknumber) && !empty($riskinfo->risknumber) ? $riskinfo->risknumber : 4); ?>
                            </div>
                        </h2>
                    </div>
                    <div class="uk-width-1-2@m uk-flex uk-flex-middle uk-flex-right">
                        <h4 class="uk-text-light">Retirement income goal</h4>
                    </div>
                    <div class="uk-width-1-2 retirementincomegoalSection">
                        <div class="uk-inline uk-width-1-1"><span class="uk-form-icon currency-input"><?php echo $_COOKIE['selectedcurrencyvalue'];?></span>
                            <input class="uk-input uk-width-1-1" style="text-align-last:center" type="text"
                                placeholder="" value="<?php echo number_format($this->DefaultRetirementIncomeGoal);?>" id="retirementincomegoalText">
                            <input type="hidden" value="<?php echo number_format($this->DefaultRetirementIncomeGoal);?>" id="retirementincomegoalValue">
                        </div>
                    </div>
                    <div class="uk-width-1-2@m uk-flex uk-flex-middle uk-flex-right">
                        <h4 class="uk-text-light">Will I make my goal?</h4>
                    </div>
                    <div class="uk-width-1-2 uk-text-center displaygoalimagelikeStatus"
                        uk-toggle="target: #displaygoalimagelikeStatus-goals" style="cursor: pointer">
                        <img src="<?php echo assets_url('concerto/icons/rating-icon-1-off.svg');?>" width="32px"
                            height="32px" data-value="bad" />
                        <img src="<?php echo assets_url('concerto/icons/rating-icon-3-off.svg');?>" width="32px"
                            height="32px" data-value="average" />
                        <img src="<?php echo assets_url('concerto/icons/rating-icon-5-on.svg');?>" width="32px"
                            height="32px" data-value="good" />
                    </div>
                </div>
            </div>
            <div class="uk-width-3-5@m uk-visible@m">
                <h4>What if I were to change my&mldr;</h4>
                <div class="uk-accordion-content margin-remove-top-child-mobile margin-remove-top-mobile">
                    <div uk-grid class="uk-flex uk-flex-middle uk-grid-small">
                        <div class="uk-width-1-3 uk-flex uk-flex-middle uk-flex-right">
                            <h4 class="uk-text-light uk-text-right">Retirement age</h4>
                        </div>
                        <div class="uk-width-1-3 onchangegetretirenment_mobile">
                            <select id="selectRetirementAge" class="uk-text-center uk-select" aria-label="Select">
                                <option>Select…</option>
                                <?php for( $RetirementAge = 40; $RetirementAge <=99;  $RetirementAge++ ) {
                                    echo '<option value="'.$RetirementAge.'" '.( $horizoninfo->retirerment_age == $RetirementAge ? 'selected="selected"' : '' ).'>'.$RetirementAge.'</option>';
                                } ?>
                            </select>
                            <span hidden id="rangeRetirement"
                                data-original-value="<?php echo (isset($horizoninfo->retirerment_age) && !empty($horizoninfo->retirerment_age) ? $horizoninfo->retirerment_age : 65); ?>"><?php echo (isset($horizoninfo->retirerment_age) && !empty($horizoninfo->retirerment_age) ? $horizoninfo->retirerment_age : $this->DefaultRetirementAge ); ?></span>
                        </div>
                        <div class="uk-width-expand">
                            <input class="uk-range" type="range"
                                value="<?php echo (isset($horizoninfo->retirerment_age) && !empty($horizoninfo->retirerment_age) ? $horizoninfo->retirerment_age : $this->DefaultRetirementAge ); ?>"
                                min="40" max="99" step="1" aria-label="Range" onChange="rangeRetirement(this.value)"
                                onChange="rangeRetirement(this.value)" id="retirerment_age">
                        </div>
                    </div>
                    <div uk-grid class="uk-flex uk-flex-middle uk-grid-small">
                        <div class="uk-width-1-3 uk-flex uk-flex-middle uk-flex-right">
                            <h4 class="uk-text-light uk-text-right">Risk profile</h4>
                        </div>
                        <div class="uk-width-1-3 onchangegetrisknumber_mobile">
                            <span hidden id="rangeRisk"
                                data-original-value="<?php echo (isset($riskinfo->risknumber) && !empty($riskinfo->risknumber) ? $riskinfo->risknumber : 4); ?>"><?php echo (isset($riskinfo->risknumber) && !empty($riskinfo->risknumber) ? $riskinfo->risknumber : 4); ?></span>
                            <select id="selectRiskNumberSelection" class="uk-text-center uk-select">
                                <option>Select&hellip;</option>
                                <?php for( $RisgNbr = 1; $RisgNbr <=6;  $RisgNbr++ ) {
                                    echo '<option value="'.$RisgNbr.'">'.$RisgNbr.'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="uk-width-expand">
                            <input class="uk-range" type="range"
                                value="<?php echo (isset($riskinfo->risknumber) && !empty($riskinfo->risknumber) ? $riskinfo->risknumber : 4); ?>"
                                min="1" max="6" step="1" aria-label="Range" onChange="rangeRiskOnchange(this.value)"
                                id="risknumber">
                        </div>
                    </div>
                    <div uk-grid class="uk-flex uk-flex-middle uk-grid-small">
                        <div class="uk-width-1-3 uk-flex uk-flex-middle uk-flex-right">
                            <h4 class="uk-text-light uk-text-right">Monthly contributions</h4>
                        </div>
                        <div class="uk-width-1-3 MonthlyContributionsSection">
                            <h2 hidden class="uk-text-light uk-text-center uk-border"><?php echo $_COOKIE['selectedcurrencyvalue'];?><span id="rangeContributions"
                                    data-original-value="<?php echo (isset($transparencyinfo->Contributions_per_annum) && !empty($transparencyinfo->Contributions_per_annum) ? $transparencyinfo->Contributions_per_annum : 200); ?>"><?php echo (isset($transparencyinfo->Contributions_per_annum) && !empty($transparencyinfo->Contributions_per_annum) ? number_format($transparencyinfo->Contributions_per_annum) : 200); ?></span>
                            </h2>
                            <div class="uk-inline uk-width-1-1"><span class="uk-form-icon currency-input"><?php echo $_COOKIE['selectedcurrencyvalue'];?></span>
                                <input class="uk-input uk-width-1-1" type="text" min="0" max="10000"
                                    onInput="numberWithCommas ('rangeContributionsText');"
                                    value="0"
                                    id="rangeContributionsText">
                            </div>
                        </div>
                        <div class="uk-width-expand MonthlyContributionsSectionHidden">
                            <input class="uk-range" type="range"
                                value="0"
                                min="0" max="10000" step="101" aria-label="Range"
                                onChange="rangeContributionsOnchange(this.value)" id="Contributions_per_annum">
                        </div>
                    </div>
                    <div uk-grid class="uk-flex uk-flex-middle uk-grid-small">
                        <div class="uk-width-1-3 uk-flex uk-flex-middle uk-flex-right">
                            <h4 class="uk-text-light uk-text-right">Projected annual income</h4>
                        </div>
                        <div class="uk-width-1-3 rangeMonthlyTargetIncomeSection">
                            <h2 hidden class="uk-text-light uk-text-center uk-border"><?php echo $_COOKIE['selectedcurrencyvalue'];?><span id="rangeMonthlyTarget"
                                    data-original-value="5000">5000</span></h2>
                            <div class="uk-inline uk-width-1-1"><span class="uk-form-icon currency-input"><?php echo $_COOKIE['selectedcurrencyvalue'];?></span>
                                <input class="uk-input uk-width-1-1" type="text" value="5000" min="0" max="500000"
                                    id="rangeMonthlyTargetText">
                            </div>
                        </div>
                        <div class="uk-width-expand rangeMonthlyTargetIncomeSectionHidden">
                            <input class="uk-range" type="range" value="5000" min="0" max="500000" step="101"
                                id="target_annual_income" aria-label="Range"
                                onChange="rangeMonthlyTargetOnchange(this.value)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="margin-remove-top-mobile uk-padding-remove-left">Retirement projections</h1>
        <div class="uk-text-center potsizeMonthlyincome_resultTable"></div>
        <div class="uk-text-center">
            <div class="uk-button-group uk-button-group-pill uk-text-center uk-margin-medium-top">
                <button class="uk-button uk-button-default uk-text-capitalize"
                    onClick="window.location='<?php echo website_url($this->controller.'/investing-risk');?>'"
                    type="button">Back</button>
                <button hidden class="uk-button uk-button-default uk-text-capitalize"><span uk-icon="icon: mail"></span> &nbsp;
                    Email Results</button>
                <button class="uk-button uk-button-default uk-text-capitalize commonbtnreportclass DownloadResultbtn" onclick="generate_report('Download')"><span uk-icon="icon: file-pdf"></span>
                    &nbsp; Download Results</button>
                <button class="uk-button uk-button-default uk-text-capitalize button-focus" id="resetCalculationsBtnId"
                    onClick="resetCalculations()">Reset Calculations</button>
            </div>
        </div>
    </div>
</div>
<div id="displaygoalimagelikeStatus-goals" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" style="border-radius: 18px;">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">Goals</h2>
        <p><img src="<?php echo assets_url('concerto/icons/rating-icon-good-on.svg');?>" width="35px" height="35px"
                class="uk-align-left uk-margin-small-right" />
            Likely to meet or exceed your income goal in a typical investment scenario.</p>
        <p><img src="<?php echo assets_url('concerto/icons/rating-icon-average-on.svg');?>" width="35px" height="35px"
                class="uk-align-left uk-margin-small-right" />
            Fair chance that you will meet your income goal. Making some changes may improve how likely this is.</p>
        <p><img src="<?php echo assets_url('concerto/icons/rating-icon-bad-on.svg');?>" width="35px" height="35px"
                class="uk-align-left uk-margin-small-right" />
            Unlikely to meet your income goal without making changes to your current plans.</p>
        <div class="uk-text-center">
            <button class="uk-button uk-button-default uk-border-pill uk-modal-close uk-text-capitalize"
                type="button">Close</button>
        </div>
    </div>
</div>
<div hidden>
    <input type="hidden" id="current_age"
        value="<?php echo ( !empty($horizoninfo->current_age) ? $horizoninfo->current_age : $this->DefaultCurrentAge ); ?>" />
    <input type="hidden" id="current_plan_value" value="<?php echo $this->DefaultPortValue;?>" min="100"
        max="<?php echo $this->DefaultPortValue;?>" />
    <input type="text"
        value="<?php echo ( !empty($horizoninfo->retirerment_age) ? $horizoninfo->retirerment_age : 65 ); ?>" min="50"
        max="100" step="1" id="retirerment_ageold">
    <input type="text"
        value="<?php echo (isset($riskinfo->risknumber) && !empty($riskinfo->risknumber) ? $riskinfo->risknumber : 4); ?>"
        min="1" max="6" step="1" id="risknumberold">
</div>
<style>
table.atr-table tr td:nth-child(1), table.atr-table tr td:nth-child(3) {
    border-right: 2px solid #e5e5e5;/*    border-right: 1px solid #d4d4d4;*/
}
table.atr-table tr td:nth-child(4) {
    border-right: none;
}
    .uk-select:not([multiple]):not([size]) {
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 10px;
    background-image: none;
}
</style>