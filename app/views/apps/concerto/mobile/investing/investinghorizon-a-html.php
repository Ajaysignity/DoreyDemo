<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div>
    <?php echo form_open(base_url(), 'class="SaveFormInfo" method="POST" data-action="saveinvestingtransparency" data-controller="'.$this->controller.'" onkeydown="if(event.keyCode === 13) { return false; }"');?>
    <div class="uk-container">
        <h1 class="atr-planting"><?php echo $this->headerLabel; ?></h1>
        <div class="atr-primary-nav">
            <?php echo doreyjtcStepsmobilemenus('horizon'); ?>
        </div>
        <div uk-grid>
            <div class="uk-width-expand@m">
                <div class="uk-margin-small ">
                    <div class="uk-margin">
                        <div uk-grid class="uk-flex uk-flex-middle">
                            <div><h1 class="uk-text-center uk-visible@s uk-margin-remove-top"><span id="rangeValue" style="font-size: 77px; color: #059ACB;"><?php echo ( !empty($info->current_age) ? $info->current_age : $this->DefaultCurrentAge ); ?></span></h1>
                            </div>
                            <div class="uk-width-expand">
								<input type="hidden"name="current_age" value="<?php echo ( !empty($info->current_age) ? $info->current_age : $this->DefaultCurrentAge ); ?>" >
								<select class="uk-select uk-hidden@s margin-remove-top-mobile atr-form-inputs"
                                    aria-label="Select" onChange="retirementAge(this.value)" name="retirerment_age">
									<option>Retiring at &hellip;</option>
									<?php for( $retage=$this->DefaultCurrentAge; $retage <= 100; $retage++ ) {
										echo '<option value="'.$retage.'" '. (isset($info->retirerment_age) && $info->retirerment_age==$retage ? 'selected="selected"' : '' ).'>'.$retage.'</option>';
									} ?>
								</select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="uk-text-center uk-hidden@s margin-remove-top-mobile"><span class="uk-text-large uk-text-middle">I
                plan on retiring/leaving service when I'm</span> <span id="retirementAge"
                style="font-size: 2em; position: relative; bottom: -4px;">&hellip;<?php echo ( !empty($info->retirerment_age) ? $info->retirerment_age : '' ); ?></span></h1>
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
    function retirementAge(value) {
        document.getElementById('retirementAge').innerHTML = value;
    }
</script>