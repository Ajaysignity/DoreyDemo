<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div>
    <div class="uk-container jtc-tools-formsection">
        <h1 class="atr-planting">I am making contributions to my savings</h1>
        <div class="atr-primary-nav">
            <?php echo doreyjtcStepsmobilemenus('missing_out'); ?>
        </div>
        <?php echo form_open(base_url(), 'class="SaveFormInfo" method="POST" data-action="savecontributingtransparency" data-controller="'.$this->controller.'" onkeydown="if(event.keyCode === 13) { return false; }"');?>
        <input id="planting_regret_label" type="hidden" name="planting_regret_label"
            value="<?php echo ( !empty($info->planting_regret_label) ? $info->planting_regret_label : '' ); ?>">
        <input id="planting_regret_info" type="hidden" name="planting_regret_info"
            value="<?php echo ( !empty($info->planting_regret_info) ? $info->planting_regret_info : '' ); ?>">
        <div class="uk-hidden@s narrow-block-mobile">
            <ul id="missing-out-diagram" class="uk-switcher missing-out-diagram"
                style="background-image: url('<?php echo assets_url('jtc-kit/jtc/icons/diagram-missing-out-mobile_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; ">
                <li style="background-image: url('<?php echo assets_url('jtc-kit/jtc/icons/diagram-missing-out-mobile_01_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
                    class="uk-animation-slide-bottom-small">
                    <svg id="_01" data-name="01" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                        <text id="outcomeValue1" class="diagram-text-large" transform="translate(4.22314 433.53794)">
                            <tspan x="0" y="0">
                                <?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>10,000
                            </tspan>
                        </text>
                    </svg>
                </li>
                <li style="background-image: url('<?php echo assets_url('jtc-kit/jtc/icons/diagram-missing-out-mobile_02_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
                    class="uk-animation-slide-bottom-small">
                    <svg id="_02" data-name="02" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                        <text id="outcomeValue3" class="diagram-text-large" transform="translate(3.48828 415.53794)">
                            <tspan x="0" y="0">
                                <?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>10,000
                            </tspan>
                        </text>
                        <text id="outcomeValue4" class="diagram-text-large" transform="translate(600.88751 124.14005)">
                            <tspan x="0" y="0">
                                <?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>18,000
                            </tspan>
                        </text>
                    </svg>
                </li>
                <li style="background-image: url('<?php echo assets_url('jtc-kit/jtc/icons/diagram-missing-out-mobile_03_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
                    class="uk-animation-slide-bottom-small">
                    <svg id="_03" data-name="03" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                        <text id="outcomeValue5" class="diagram-text-large" transform="translate(3.48828 415.53794)">
                            <tspan x="0" y="0">
                                <?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>10,000
                            </tspan>
                        </text>
                        <text id="outcomeValue6" class="diagram-text-large" transform="translate(600.88751 220.84901)">
                            <tspan x="0" y="0">
                                <?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>15,000
                            </tspan>
                        </text>
                    </svg>
                </li>
                <li style="background-image: url('<?php echo assets_url('jtc-kit/jtc/icons/diagram-missing-out-mobile_04_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
                    class="uk-animation-slide-bottom-small">
                    <svg id="_04" data-name="04" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                        <text id="outcomeValue7" class="diagram-text-large" transform="translate(3.48828 415.53794)">
                            <tspan x="0" y="0">
                                <?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>10,000
                            </tspan>
                        </text>
                        <text class="diagram-text-large" transform="translate(600.88751 305.55798)">
                            <tspan x="0" y="0">Above</tspan>
                        </text>
                        <text class="diagram-text-large" transform="translate(600.88751 330.55798)">
                            <tspan x="0" y="0">inflation</tspan>
                        </text>
                    </svg>
                </li>
                <li style="background-image: url('<?php echo assets_url('jtc-kit/jtc/icons/diagram-missing-out-mobile_05_base.svg');?>'); background-position: center; background-repeat: no-repeat; background-size: 100% 100%; "
                    class="uk-animation-slide-top-small">
                    <svg id="_05" data-name="05" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 460">
                        <text id="outcomeValue8" class="diagram-text-large" transform="translate(3.48828 415.53794)">
                            <tspan x="0" y="0">
                                <?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>10,000
                            </tspan>
                        </text>
                        <text class="diagram-text-large" transform="translate(600.88751 400.27659)">
                            <tspan x="0" y="0">Not lose</tspan>
                        </text>
                        <text class="diagram-text-large" transform="translate(600.88751 425.27659)">
                            <tspan x="0" y="0">money</tspan>
                        </text>
                    </svg>
                </li>
            </ul>
        </div>
        <div class="growth-matrix uk-hidden@s">
            <h5 class="uk-text-light">If I invested $10,000 and the global stock market doubled in five years, I would
                be satisfied with a portfolio value o&mldr;</h5>
            <ul class="uk-tab-left half-pill-button-left <?php echo ( empty($info->planting_regret_label) ? 'remove-default-rquired-li' : '' ); ?>" uk-tab="connect: .missing-out-diagram;">
                <li class="<?php echo ( $info->planting_regret_label =='5' ? 'uk-active' : '' ); ?>"
                        onclick="getbuttonvalue(this);" data-btnVal="5" data-btnId="planting_regret_label"
                        data-btnIdInfo="planting_regret_info" data-btnValInfo="<?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>20,000, the same growth"><a><?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>20,000, the same growth</a></li>
                <li class="<?php echo ( $info->planting_regret_label =='4' ? 'uk-active' : '' ); ?>"
                        onclick="getbuttonvalue(this);" data-btnVal="4" data-btnId="planting_regret_label"
                        data-btnIdInfo="planting_regret_info" data-btnValInfo="<?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>18,000"><a><?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>18,000</a></li>
                <li class="<?php echo ( $info->planting_regret_label =='3' ? 'uk-active' : '' ); ?>"
                        onclick="getbuttonvalue(this);" data-btnVal="3" data-btnId="planting_regret_label"
                        data-btnIdInfo="planting_regret_info" data-btnValInfo="<?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>15,000"><a><?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>15,000</a></li>
                <li class="<?php echo ( $info->planting_regret_label =='2' ? 'uk-active' : '' ); ?>"
                        onclick="getbuttonvalue(this);" data-btnVal="2" data-btnId="planting_regret_label"
                        data-btnIdInfo="planting_regret_info" data-btnValInfo="Anything above inflation"><a>Anything above inflation</a></li>
                <li class="<?php echo ( $info->planting_regret_label =='1' ? 'uk-active' : '' ); ?>"
                        onclick="getbuttonvalue(this);" data-btnVal="1" data-btnId="planting_regret_label"
                        data-btnIdInfo="planting_regret_info" data-btnValInfo="<?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>10,000 - no losses"><a><?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$'); ?>10,000 &ndash; no losses</a></li>
            </ul>
        </div>
        <div class="uk-text-center">
            <div class="uk-button-group uk-button-group-pill uk-width-1-3 uk-margin-medium-top">
                <button type="button" class="uk-button uk-button-default uk-text-capitalize uk-width-1-2"
                    onClick="window.location='<?php echo website_url($this->controller.'/contributing-potential-falls');?>'">Back</button>
                <input type="hidden" name="httpredirect" value="<?php echo $httpredirect; ?>">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <button class="uk-button uk-button-default uk-text-capitalize button-focus uk-width-1-2"
                    onclick="ValidateFormSubmit_JTC('SaveFormInfo','Confirm');" type="submit">Confirm</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>