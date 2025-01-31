<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>

<div class="uk-container jtc-tools-formsection">
    <h1 class="atr-planting am"><?php echo $this->headerLabel; ?></h1>

    <div class="atr-primary-nav">
        <?php echo doreyjtcSteps('background'); ?>
    </div>
    <?php echo form_open(base_url(), 'class="SaveFormInfo" method="POST" data-action="savecontributingtransparency" data-controller="'.$this->controller.'" onkeydown="if(event.keyCode === 13) { return false; }"');?>

    <div uk-grid="">
        <div class="uk-width-1-3@m uk-flex uk-flex-middle uk-flex-right uk-first-column">
            <h4 class="uk-text-light title_font">Experience investing</h4>
        </div>
        <div class="uk-width-2-3@m">
            <div class="radio-button-group uk-flex">
                <div class="custom-radio uk-width-1-3">
                    <input type="radio" class=" stv-radio-tab uk-width-1-1 " id="Experience_investing1"
                        name="Experience_investing" value="Less than 1 year"
                        <?php echo ($info->Experience_investing == 'Less than 1 year' ? 'checked' : ''); ?>>
                    <label class="uk-width-1-1" for="Experience_investing1"
                        uk-tooltip="title: I have less than a year's experience at investing">Less than 1 year</label>
                </div>
                <div class="custom-radio uk-width-1-3">
                    <input type="radio" class=" stv-radio-tab uk-width-1-1" id="Experience_investing2"
                        name="Experience_investing" value="1 to 7 years"
                        <?php echo ($info->Experience_investing == '1 to 7 years' ? 'checked' : ''); ?>>
                    <label class="uk-width-1-1" for="Experience_investing2"
                        uk-tooltip="title: I have more than 1, but less than 7 years of experience at investing">1 to 7
                        years</label>
                </div>
                <div class="custom-radio uk-width-1-3">
                    <input type="radio" class=" stv-radio-tab uk-width-1-1" id="Experience_investing3"
                        name="Experience_investing" value="More than 7 years"
                        <?php echo ($info->Experience_investing == 'More than 7 years' ? 'checked' : ''); ?>>
                    <label class="uk-width-1-1" for="Experience_investing3"
                        uk-tooltip="title: I have more than seven years’ experience at investing">More than 7
                        years</label>
                </div>
            </div>

        </div>
    </div>

    <div uk-grid>
        <div class="uk-width-1-3@m uk-flex uk-flex-middle uk-flex-right">
            <h4 class="uk-text-light title_font">Knowledge</h4>
        </div>
        <div class="uk-width-2-3@m">


            <div class="radio-button-group uk-flex">
                <div class="custom-radio uk-width-1-3">
                    <input type="radio" class="stv-radio-tab uk-width-1-1" id="Basic" name="Knowledge" value="Basic"
                        <?php echo ( $info->Knowledge =='Basic' ? 'checked' : '' ); ?> />
                    <label class="uk-width-1-1" for="Basic"
                        uk-tooltip="title: I have a limited understanding of investments.">Basic</label>
                </div>
                <div class="custom-radio uk-width-1-3">
                    <input type="radio" class="stv-radio-tab uk-width-1-1" id="Intermediate" name="Knowledge"
                        value="Intermediate" <?php echo ( $info->Knowledge =='Intermediate' ? 'checked' : '' ); ?> />
                    <label class="uk-width-1-1" for="Intermediate"
                        uk-tooltip="title: I am familiar with equity and bond investments.">Intermediate</label>
                </div>
                <div class="custom-radio uk-width-1-3">
                    <input type="radio" class="stv-radio-tab uk-width-1-1" id="Advanced" name="Knowledge"
                        value="Advanced" <?php echo ( $info->Knowledge =='Advanced' ? 'checked' : '' ); ?> />
                    <label class="uk-width-1-1" for="Advanced"
                        uk-tooltip="title:  I am well-read on investments and understand investment risk.">Advanced</label>
                </div>
            </div>


        </div>
    </div>

    <div uk-grid>
        <div class="uk-width-1-3@m uk-flex uk-flex-middle uk-flex-right">
            <h4 class="uk-text-light title_font">Investment decision maker</h4>
        </div>
        <div class="uk-width-2-3@m">


            <div class="radio-button-group uk-flex">
                <div class="custom-radio uk-width-1-2">
                    <input type="radio" class="stv-radio-tab uk-width-1-1" id="Professional/Fund manager"
                        name="Investment_decision_maker" value="Professional/Fund manager"
                        <?php echo ( $info->Investment_decision_maker =='Professional/Fund manager' ? 'checked' : '' ); ?> />
                    <label class="uk-width-1-1" for="Professional/Fund manager"
                        uk-tooltip="title: A fund manager or advisor has made most of my buying and selling decisions for me.">Professional/Fund
                        manager</label>
                </div>
                <div class="custom-radio uk-width-1-2">
                    <input type="radio" class="stv-radio-tab uk-width-1-1" id="Me" name="Investment_decision_maker"
                        value="Me" <?php echo ( $info->Investment_decision_maker =='Me' ? 'checked' : '' ); ?> />
                    <label class="uk-width-1-1" for="Me"
                        uk-tooltip="title: I have made most or all of my investment decisions.">Me</label>
                </div>
            </div>


        </div>


    </div>

    <div uk-grid>
        <div class="uk-width-1-3@m uk-flex uk-flex-middle uk-flex-right">
            <h4 class="uk-text-light title_font">Income per annum</h4>
        </div>
        <div class="uk-width-2-3@m">
            <div class="uk-margin-small ">
                <div class="uk-width-1-1 atr-form-inputs uk-position-relative"
                    uk-tooltip="title: This is my average annual income (usually salary); delay: 500">
                    <span class="uk-form-icon currency-input"><?php echo $_COOKIE['selectedcurrencyvalue'];?></span>
                    <input onInput="numberWithCommas('Income_per_annum');" class="uk-input" name="Income_per_annum"
                        id="Income_per_annum" type="text" autocomplete="off" min="10" max="150000"
                        value="<?php echo ( !empty($info->Income_per_annum) ? number_format($info->Income_per_annum) : '' ); ?>">
                </div>
            </div>
        </div>
    </div>


    <div uk-grid>
        <div class="uk-width-1-3@m uk-flex uk-flex-middle uk-flex-right">
            <h4 class="uk-text-light">Contributions per month</h4>
        </div>
        <div class="uk-width-2-3@m">
            <div uk-grid class="uk-margin-small uk-flex-middle">
                <div class="uk-width-1-3">
                    <div class="atr-form-inputs"
                        uk-tooltip="title: On average this is how much I contribute to my pension plan as a percentage of my monthly income; delay: 500">
                        <div class="uk-inline uk-width-1-1"><span class="uk-form-icon currency-input">%</span>
                            <input class="uk-input uk-width-1-1" id="Contributions_percentage"
                                name="Contributions_percentage" type="number" placeholder=""  value="<?php echo ( !empty($info->Contributions_percentage) ? ($info->Contributions_percentage) : '' ); ?>"
                                oninput="validateInputPercentage(event)" min="0" step="0.01">
                        </div>
                    </div>
                </div>
                <div class="uk-width-expand">
                    <div class="atr-form-inputs uk-width-expand"
                        uk-tooltip="title: On average this is how much I contribute to my pension plan on a monthly basis; delay: 500">
                        <div class="uk-inline uk-width-expand"><span class="uk-form-icon currency-input"><?php echo $_COOKIE['selectedcurrencyvalue'];?></span>
                            <input class="uk-input" name="Contributions_per_annum" id="Contributions_per_annum"
                                type="text" min="10" max="10000" autocomplete="off"
                                onInput="numberWithCommas('Contributions_per_annum');"
                                value="<?php echo ( !empty($info->Contributions_per_annum) ? number_format($info->Contributions_per_annum) : '' ); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div uk-grid hidden>
        <div class="uk-width-1-3@m uk-flex uk-flex-middle uk-flex-right">
            <h4 class="uk-text-light title_font">Desired Income per annum ( $ )</h4>
        </div>
        <div class="uk-width-2-3@m">
            <div class="uk-margin-small ">
                <div class="uk-width-1-1 atr-form-inputs"
                    uk-tooltip="title:This is the income I am hoping to have in retirement.; delay: 500">
                    <input class="uk-input" name="Desiredincome_per_annum" id="Desiredincome_per_annum" type="text"
                        min="0" max="100000000" autocomplete="off"
                        onInput="numberWithCommas('Desiredincome_per_annum');" value="0">
                </div>
            </div>
        </div>
    </div>


    <div uk-grid>
        <div class="uk-width-1-3@m uk-flex uk-flex-middle uk-flex-right">
            <h4 class="uk-text-light title_font">Main source of retirement income</h4>
        </div>
        <div class="uk-width-2-3@m">

            <div class="radio-button-group uk-flex">
                <div class="custom-radio uk-width-1-2">
                    <input type="radio" class="stv-radio-tab uk-width-1-1" id="Yes" name="Other_sources_of_income"
                        value="Yes" <?php echo ( $info->Other_sources_of_income =='Yes' ? 'checked' : '' ); ?> />
                    <label class="uk-width-1-1" for="Yes"
                        uk-tooltip="The money I have with JTC will be my main source of income when I retire. I do not currently have – or know of - other significant sources">Yes</label>
                </div>
                <div class="custom-radio uk-width-1-2">
                    <input type="radio" class="stv-radio-tab uk-width-1-1" id="No" name="Other_sources_of_income"
                        value="No" <?php echo ( $info->Other_sources_of_income =='No' ? 'checked' : '' ); ?> />
                    <label class="uk-width-1-1" for="No"
                        uk-tooltip="title: I have additional substantial sources of income for retirement. I will not be wholly dependent on my investment with JTC.">No</label>
                </div>
            </div>

        </div>
    </div>

    <div class="uk-text-center">
        <div class="uk-button-group uk-button-group-pill uk-width-1-3 uk-margin-medium-top">
            <button type="button" class="uk-button uk-button-default uk-text-capitalize uk-width-1-2"
                onClick="window.location='<?php echo website_url($this->controller.'/contributing');?>'">Back</button>
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