<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="uk-container jtc-tools-formsection">
    <h1 class="atr-planting am"><?php echo $this->headerLabel; ?></h1>

    <div class="atr-primary-nav">
        <?php echo doreyjtcStepsmobilemenus('background'); ?>
    </div>
    <?php echo form_open(base_url(), 'class="SaveFormInfo" method="POST" data-action="saveWithdrawingtransparency" data-controller="'.$this->controller.'" onkeydown="if(event.keyCode === 13) { return false; }"');?>
    <div class="uk-hidden@m">
        <ul uk-accordion>
            <li class="uk-open"> <a class="uk-accordion-title" href>Experience investing <span id="expInvest"
                        class="uk-text-small uk-text-truncate"></span></a>
                <div class="uk-accordion-content radio-button-group">
                    <input type="radio" name="Experience_investing" id="lt1yr" value="Less than 1 year"
                        <?php echo ($info->Experience_investing == 'Less than 1 year' ? 'checked' : ''); ?>>
                    <label for="lt1yr" uk-tooltip="title: I have less than a year's experience at investing; delay: 500"
                        onclick="document.getElementById('expInvest').innerHTML = 'Less than 1 year'">Less than 1
                        year</label>
                    <input type="radio" name="Experience_investing" id="lt7rs" value="1 to 7 years"
                        <?php echo ($info->Experience_investing == '1 to 7 years' ? 'checked' : ''); ?>>
                    <label for="lt7rs"
                        uk-tooltip="title: I have more than 1, but less than 7 years' of experience at investing; delay: 500"
                        onclick="document.getElementById('expInvest').innerHTML = '1 to 7 years'">1 to 7 years</label>
                    <input type="radio" name="Experience_investing" id="mt7yrs" value="More than 7 years"
                        <?php echo ($info->Experience_investing == 'More than 7 years' ? 'checked' : ''); ?>>
                    <label for="mt7yrs"
                        uk-tooltip="title: I have more than seven years' experience at investing; delay: 500"
                        onclick="document.getElementById('expInvest').innerHTML = 'More than 7 years'">More than 7
                        years</label>
                </div>
            </li>
            <li> <a class="uk-accordion-title" href>Knowledge <span id="myKnowledge"
                        class="uk-text-small uk-text-truncate"></span></a>
                <div class="uk-accordion-content radio-button-group">
                    <input type="radio" name="Knowledge" id="basic" value="Basic"
                        <?php echo ( $info->Knowledge =='Basic' ? 'checked' : '' ); ?> >
                    <label for="basic" uk-tooltip="title: I have a limited understanding of investments; delay: 500"
                        onclick="document.getElementById('myKnowledge').innerHTML = 'Basic'">Basic</label>
                    <input type="radio" name="Knowledge" id="intermediate" value="Intermediate" <?php echo ( $info->Knowledge =='Intermediate' ? 'checked' : '' ); ?>>
                    <label for="intermediate"
                        uk-tooltip="title: I am familiar with equity and bond investments; delay: 500"
                        onclick="document.getElementById('myKnowledge').innerHTML = 'Intermediate'">Intermediate</label>
                    <input type="radio" name="Knowledge" id="advanced" value="Advanced" <?php echo ( $info->Knowledge =='Advanced' ? 'checked' : '' ); ?>>
                    <label for="advanced"
                        uk-tooltip="title: I am well read on investments and comfortably understand investment risk; delay: 500"
                        onclick="document.getElementById('myKnowledge').innerHTML = 'Advanced'">Advanced</label>
                </div>
            </li>
            <li> <a class="uk-accordion-title" href>Investment decision maker <span id="investDecMaker"
                        class="uk-text-small uk-text-truncate"></span></a>
                <div class="uk-accordion-content radio-button-group">
                    <input type="radio" name="Investment_decision_maker" id="professional" value="Professional/Fund manager"
                        <?php echo ( $info->Investment_decision_maker =='Professional/Fund manager' ? 'checked' : '' ); ?>>
                    <label for="professional"
                        uk-tooltip="title: A fund manager or advisor has made most of my buying and selling decisions for me; delay: 500"
                        onclick="document.getElementById('investDecMaker').innerHTML = 'Profession / Fund Manager'">Professional
                        / Fund Manager</label>
                    <input type="radio" name="Investment_decision_maker" id="me" name="Investment_decision_maker"
                        value="Me" <?php echo ( $info->Investment_decision_maker =='Me' ? 'checked' : '' ); ?>>
                    <label for="me" uk-tooltip="title: I have made most or all of my investment decisions; delay: 500"
                        onclick="document.getElementById('investDecMaker').innerHTML = 'Me'">Me</label>
                </div>
            </li>
            <li> <a class="uk-accordion-title" href>Income per annum <span id="incPerAnnum"
                        class="uk-text-small uk-text-truncate"></span></a>
                <div class="uk-accordion-content">
                    <div class="uk-width-1-1 atr-form-inputs"
                        uk-tooltip="title: This is my average annual income (usually salary); delay: 500">
                        <div class="uk-inline uk-width-1-1"><span class="uk-form-icon currency-input"><?php echo $_COOKIE['selectedcurrencyvalue'];?></span>
							<input onInput="numberWithCommas('Income_per_annum');" class="uk-input uk-width-1-1" name="Income_per_annum" id="Income_per_annum" type="text" autocomplete="off" min="10" max="150000" value="<?php echo ( !empty($info->Income_per_annum) ? number_format($info->Income_per_annum) : '' ); ?>">
                        </div>
                    </div>
                </div>
            </li>
            <li hidden> <a class="uk-accordion-title" href>Contributions per month <span id="contPerMonth"
                        class="uk-text-small uk-text-truncate"></span></a>
                <div class="uk-accordion-content">
                    <div class="uk-width-2-3@m">
                        <div uk-grid class="uk-margin-small uk-flex-middle">
                            <div class="uk-width-1-3">
                                <div class="atr-form-inputs"
                                    uk-tooltip="title: On average this is how much I contribute to my pension plan as a percentage of my monthly income; delay: 500">
                                    <div class="uk-inline"><span class="uk-form-icon currency-input">%</span>
                                        <input class="uk-input uk-width-1-1" name="Contributions_percentage" id="Contributions_percentage" type="number" placeholder="0.00" value="0" oninput="validateInputPercentage(event)" min="0" step="0.01">
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-expand">
                                <div class="atr-form-inputs uk-width-expand"
                                    uk-tooltip="title: On average this is how much I contribute to my pension plan on a monthly basis; delay: 500">
                                    <div class="uk-inline uk-width-expand"><span class="uk-form-icon currency-input"><?php echo $_COOKIE['selectedcurrencyvalue'];?></span>
									 <input class="uk-input uk-width-1-1" name="Contributions_per_annum" id="Contributions_per_annum" type="text" min="10" max="10000" autocomplete="off" onInput="numberWithCommas('Contributions_per_annum');" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li> <a class="uk-accordion-title" href>Main source of retirement income <span id="mainIncome"
                        class="uk-text-small uk-text-truncate"></span></a>
                <div class="uk-accordion-content radio-button-group">
                    <input type="radio" name="Other_sources_of_income" id="yes" value="Yes" <?php echo ( $info->Other_sources_of_income =='Yes' ? 'checked' : '' ); ?>>
                    <label for="yes"
                        uk-tooltip="title: The money I have with JTC will be my main source of income when I retire. I do not currently have – or know  of - other significant sources of income.; delay: 500"
                        onclick="document.getElementById('mainIncome').innerHTML = 'Yes'">Yes</label>
                    <input type="radio" name="Other_sources_of_income" id="no" value="No" <?php echo ( $info->Other_sources_of_income =='No' ? 'checked' : '' ); ?>>
                    <label for="no"
                        uk-tooltip="title: I have additional substantial sources of income for retirement. I will not be wholly dependent on my investment with JTC.; delay: 500"
                        onclick="document.getElementById('mainIncome').innerHTML = 'No'">No</label>
                </div>
            </li>
        </ul>
    </div>
    <div class="uk-text-center">
        <div class="uk-button-group uk-button-group-pill uk-width-1-3 uk-margin-medium-top">
            <button type="button" class="uk-button uk-button-default uk-text-capitalize uk-width-1-2"
                onClick="window.location='<?php echo website_url($this->controller.'/withdrawing');?>'">Back</button>
            <input type="hidden" name="httpredirect" value="<?php echo $httpredirect; ?>">
            <input type="hidden" name="type" value="<?php echo $type; ?>">
			
            <button class="uk-button uk-button-default uk-border-pill uk-text-capitalize button-focus uk-width-1-2"
                onclick="ValidateFormSubmit_JTC('SaveFormInfo','Confirm');" type="submit">Confirm</button>

        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<style>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}
</style>
