<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div uk-height-viewport="expand: true">
    <div class="uk-container jtc-tools-formsection">
        <h1 class="atr-harvesting am"><?php echo $this->headerLabel; ?></h1>
        <div class="atr-primary-nav">
            <?php echo doreyjtcSteps('horizon'); ?>
        </div>
        <?php echo form_open(base_url(), 'class="SaveFormInfo" method="POST" data-action="saveWithdrawingtransparency" data-controller="'.$this->controller.'" onkeydown="if(event.keyCode === 13) { return false; }"');?>
        <input type="hidden" id="retirerment_age" name="retirerment_age"
            value="<?php echo $this->DefaultCurrentAge ; ?>" />
        <input type="hidden" name="current_age"
            value="<?php echo ( !empty($info->current_age) ? $info->current_age : $this->DefaultCurrentAge ); ?>">
        <div uk-grid>
            <div class="uk-width-1-1@m">
                <div class="uk-margin-small ">
                    <div class="uk-margin">
                        <h1 class="uk-text-center"><span class="uk-text-large uk-text-middle">My current age is</span>
                            <span
                                id="rangeValue"><?php echo ( !empty($info->current_age) ? $info->current_age : $this->DefaultCurrentAge ); ?></span>
                        </h1>
                        <div uk-grid>
                            <div class="uk-text-light">
                                <p>You said you are receiving benefits/withdrawing from your savings pot. If you are still contributing or
                                investing without withdrawing, please re-start the survey and select:</p>
                                <ul>
                                    <li><a onClick="window.location.href='<?php echo website_url('jtctools/contributing');?>'">Contributing</a> if you are still making contributions</li>
                                    <li><a onClick="window.location.href='<?php echo website_url('jtctools/investing');?>'">Investing</a> if you have stopped making contributions but are not retiring or leaving service yet</li>
                                </ul>
                            </div>
                            <script type="text/javascript">
                            function rangeSlide(value) {
                                document.getElementById('rangeValue').innerHTML = value;
                            }
                            </script>
                        </div>
                    </div>
                </div>


                <div class="uk-text-center">
                    <div class="uk-button-group uk-button-group-pill uk-width-1-3 uk-margin-medium-top">
                        <button type="button" class="uk-button uk-button-default uk-text-capitalize uk-width-1-2"
                            onClick="window.location='<?php echo website_url($this->controller.'/withdrawing-background');?>'">Back</button>
                            <input type="hidden" name="httpredirect" value="<?php echo $httpredirect; ?>">
                        <input type="hidden" name="type" value="<?php echo $type; ?>">
                        <button
                            class="uk-button uk-button-default uk-border-pill uk-text-capitalize button-focus uk-width-1-2"
                            onclick="ValidateFormSubmit_JTC('SaveFormInfo','Confirm');" type="submit">Confirm</button>
                        
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>