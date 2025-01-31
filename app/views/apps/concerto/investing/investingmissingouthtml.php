<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div>
    <div class="uk-container  jtc-tools-formsection">
        <h1 class="atr-planting"><?php echo $this->headerLabel; ?></h1>
        <div class="atr-primary-nav">
            <?php echo doreyjtcSteps('missing_out'); ?>
        </div>
        <?php echo form_open(base_url(), 'class="SaveFormInfo" method="POST" data-action="saveinvestingtransparency" data-controller="'.$this->controller.'" onkeydown="if(event.keyCode === 13) { return false; }"');?>
        <input id="planting_regret_label" type="hidden" name="planting_regret_label"
            value="<?php echo ( !empty($info->planting_regret_label) ? $info->planting_regret_label : '' ); ?>">
        <input id="planting_regret_info" type="hidden" name="planting_regret_info"
            value="<?php echo ( !empty($info->planting_regret_info) ? $info->planting_regret_info : '' ); ?>">
        <h4 class="uk-margin-medium-top uk-text-light  uk-visible@s">If I invested
            <?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>10,000
            and the global stock market
            doubled in five years, I would be satisfied with a portfolio value of&hellip;</h4>
        <div uk-grid class="uk-flex  uk-visible@s">
            <div class="uk-width-1-2@m missing-out-options uk-flex-last@s">
                <ul class="uk-tab-right half-pill-button-right <?php echo ( empty($info->planting_regret_label) ? 'remove-default-rquired-li' : '' ); ?>"
                    uk-tab="connect: #potential-missing-out; animation: uk-animation-slide-left-small">
                    <li class="<?php echo ( $info->planting_regret_label =='5' ? 'uk-active' : '' ); ?>"
                        onclick="getbuttonvalue(this);" data-btnVal="5" data-btnId="planting_regret_label"
                        data-btnIdInfo="planting_regret_info" data-btnValInfo="$20,000, the same growth">
                        <a><?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>20,000,
                            the same growth</a></li>
                    <li class="<?php echo ( $info->planting_regret_label =='4' ? 'uk-active' : '' ); ?>"
                        onclick="getbuttonvalue(this);" data-btnVal="4" data-btnId="planting_regret_label"
                        data-btnIdInfo="planting_regret_info" data-btnValInfo="$18,000">
                        <a><?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>18,000</a>
                    </li>
                    <li class="<?php echo ( $info->planting_regret_label =='3' ? 'uk-active' : '' ); ?>"
                        onclick="getbuttonvalue(this);" data-btnVal="3" data-btnId="planting_regret_label"
                        data-btnIdInfo="planting_regret_info" data-btnValInfo="$15,000">
                        <a><?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>15,000</a>
                    </li>
                    <li class="<?php echo ( $info->planting_regret_label =='2' ? 'uk-active' : '' ); ?>"
                        onclick="getbuttonvalue(this);" data-btnVal="2" data-btnId="planting_regret_label"
                        data-btnIdInfo="planting_regret_info" data-btnValInfo="Anything above inflation"><a>Anything
                            above inflation</a></li>
                    <li class="<?php echo ( $info->planting_regret_label =='1' ? 'uk-active' : '' ); ?>"
                        onclick="getbuttonvalue(this);" data-btnVal="1" data-btnId="planting_regret_label"
                        data-btnIdInfo="planting_regret_info" data-btnValInfo="$10,000 - no losses">
                        <a><?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>10,000
                            - no losses</a></li>
                </ul>
            </div>
            <div class="uk-width-expand@m">
                <ul id="potential-missing-out" class="uk-switcher"
                    style="background-image: url('<?php echo assets_url('concerto/icons/diagram-missing-out_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; ">

                    <li style="background-image: url('<?php echo assets_url('concerto/icons/diagram-missing-out_01_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
                        class="uk-animation-slide-bottom-small missingoutstatsdatainformations <?php echo ( $info->planting_regret_label =='5' ? 'uk-active' : '' ); ?>">
                        <svg id="_01" data-name="01" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                            <text text-anchor="end" id="outcomeValue1" class="diagram-text-large"
                                transform="translate(133 433)">
                                <tspan x="0" y="0"><?php echo $_COOKIE['selectedcurrencyvalue'];?>10,000</tspan>
                            </text>
                        </svg>
                    </li>
                    <li style="background-image: url('<?php echo assets_url('concerto/icons/diagram-missing-out_02_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
                        class="uk-animation-slide-bottom-small" <?php echo ( $info->planting_regret_label =='4' ? 'uk-active' : '' ); ?>>
                        <svg id="_02" data-name="02" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                            <text text-anchor="end" id="outcomeValue3" class="diagram-text-large"
                                transform="translate(133 433)">
                                <tspan x="0" y="0"><?php echo $_COOKIE['selectedcurrencyvalue'];?>10,000</tspan>
                            </text>
                        </svg>
                    </li>
                    <li style="background-image: url('<?php echo assets_url('concerto/icons/diagram-missing-out_03_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
                        class="uk-animation-slide-bottom-small" <?php echo ( $info->planting_regret_label =='3' ? 'uk-active' : '' ); ?>>
                        <svg id="_03" data-name="03" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                            <text text-anchor="end" id="outcomeValue5" class="diagram-text-large"
                                transform="translate(133 433)">
                                <tspan x="0" y="0"><?php echo $_COOKIE['selectedcurrencyvalue'];?>10,000</tspan>
                            </text>
                        </svg>
                    </li>
                    <li style="background-image: url('<?php echo assets_url('concerto/icons/diagram-missing-out_04_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
                        class="uk-animation-slide-bottom-small" <?php echo ( $info->planting_regret_label =='2' ? 'uk-active' : '' ); ?>>
                        <svg id="_04" data-name="04" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                            <text text-anchor="end" id="outcomeValue7" class="diagram-text-large"
                                transform="translate(133 433)">
                                <tspan x="0" y="0"><?php echo $_COOKIE['selectedcurrencyvalue'];?>10,000</tspan>
                            </text>
                        </svg>
                    </li>
                    <li style="background-image: url('<?php echo assets_url('concerto/icons/diagram-missing-out_05_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
                        class="uk-animation-slide-top-small" <?php echo ( $info->planting_regret_label =='1' ? 'uk-active' : '' ); ?>>
                        <svg id="_05" data-name="05" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                            <text text-anchor="end" id="outcomeValue8" class="diagram-text-large"
                                transform="translate(133 433)">
                                <tspan x="0" y="0"><?php echo $_COOKIE['selectedcurrencyvalue'];?>10,000</tspan>
                            </text>
                        </svg>
                    </li>
                </ul>
            </div>
        </div>

        <div class="uk-text-center">
            <div class="uk-button-group uk-button-group-pill uk-width-1-3 uk-margin-medium-top">
                <button type="button" class="uk-button uk-button-default uk-text-capitalize uk-width-1-2"
                    onClick="window.location='<?php echo website_url($this->controller.'/investing-potential-falls');?>'">Back</button>
                <input type="hidden" name="httpredirect" value="<?php echo $httpredirect; ?>">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <button class="uk-button uk-button-default uk-text-capitalize button-focus uk-width-1-2"
                    onclick="ValidateFormSubmit_JTC('SaveFormInfo','Confirm');" type="submit">Confirm</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>