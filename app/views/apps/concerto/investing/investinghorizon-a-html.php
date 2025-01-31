<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div>
    <?php echo form_open(base_url(), 'class="SaveFormInfo" method="POST" data-action="saveinvestingtransparency" data-controller="'.$this->controller.'" onkeydown="if(event.keyCode === 13) { return false; }"');?>
    <div class="uk-container">
        <h1 class="atr-growing"><?php echo $this->headerLabel; ?></h1>
        <div class="atr-primary-nav">
            <?php echo doreyjtcSteps('horizon'); ?>
        </div>
        <div uk-grid>
            <div class="uk-width-auto@m uk-flex">
                <h4 class="uk-margin-medium-top uk-text-light uk-visible@s">I am currently
                    <strong><?php echo ( !empty($info->current_age) ? $info->current_age : $this->DefaultCurrentAge ); ?></strong>
                    years old and plan to retire/leave service when I am&hellip;
                </h4>
            </div>
            <div class="uk-width-expand@m">
                <div class="uk-margin-small ">
                    <div class="uk-margin">
                        <div uk-grid class="uk-flex uk-flex-middle">
                            <div>
                                <h1 class="uk-text-center uk-visible@s uk-margin-remove-top"><span id="rangeValue"
                                        style="font-size: 77px; color: #059ACB;"><?php echo ( !empty($info->retirerment_age) ? $info->retirerment_age : $this->DefaultRetirementAge ); ?></span>
                                </h1>
                            </div>
                            <div class="uk-width-expand">
                                <input type="hidden" name="current_age"
                                    value="<?php echo ( !empty($info->current_age) ? $info->current_age : $this->DefaultCurrentAge ); ?>">
                                <input class="uk-width-1-1 uk-range  uk-visible@s" type="range" name="retirerment_age"
                                    value="<?php echo ( !empty($info->retirerment_age) ? $info->retirerment_age : $this->DefaultRetirementAge ); ?>"
                                    min="<?php echo $this->DefaultCurrentAge ; ?>" max="99" step="1" aria-label="Range" onChange="rangeSlide(this.value)"
                                    onmousemove="rangeSlide(this.value)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-text-center">
            <div class="uk-button-group uk-button-group-pill uk-width-1-3 uk-margin-medium-top">
                <button type="button" class="uk-button uk-button-default uk-text-capitalize uk-width-1-2"
                    onClick="window.location='<?php echo website_url($this->controller.'/investing-background');?>'">Back</button>
                <input type="hidden" name="httpredirect" value="<?php echo $httpredirect; ?>">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <button class="uk-button uk-button-default uk-text-capitalize button-focus uk-width-1-2"
                    onclick="ValidateFormSubmit_JTC('SaveFormInfo','Confirm');" type="submit">Confirm</button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
</div>

<script type="text/javascript">
function rangeSlide(value) {
    document.getElementById('rangeValue').innerHTML = value;
}
</script>