<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div uk-height-viewport="expand: true">
    <div class="uk-container jtc-tools-formsection">
        <h1 class="atr-planting"><?php echo $this->headerLabel; ?></h1>
        <div class="atr-primary-nav">
            <?php echo doreyjtcStepsmobilemenus('potentialfalls'); ?>
        </div>
        <?php echo form_open(base_url(), 'class="SaveFormInfo" method="POST" data-action="saveinvestingtransparency" data-controller="'.$this->controller.'" onkeydown="if(event.keyCode === 13) { return false; }"');?>
        <input id="planting_potentialfalls_label" type="hidden" name="planting_potentialfalls_label"
            value="<?php echo ( !empty($info->planting_potentialfalls_label) ? $info->planting_potentialfalls_label : '' ); ?>">
        <div>
            <div class="jtcatrbind_<?php echo $this->method;?>"></div>
        </div>
        <div class="uk-text-center">
            <div class="uk-button-group uk-button-group-pill uk-width-1-3 uk-margin-medium-top">
                <button type="button" class="uk-button formbackbuttontext uk-button-default uk-text-capitalize uk-width-1-2"
                    onClick="window.location='<?php echo website_url($this->controller.'/investing-growth');?>'" hidden>Back</button>
                <input type="hidden" name="httpredirect" value="<?php echo $httpredirect; ?>">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <input type="hidden" name="atrtype" id="atrtype"
                    value="<?php echo ( !empty($atrtype) ? $atrtype : '' ); ?>">
                <button class="uk-button uk-button-default uk-text-capitalize button-focus uk-width-1-2"
                    onclick="ValidateFormSubmit_JTC('SaveFormInfo','Confirm');" type="submit" hidden>Confirm</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>