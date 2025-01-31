<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div>
    <div class="uk-container">
        <div class="uk-flex uk-flex-center uk-flex-middle uk-grid-small ">
            <div class=" uk-flex-middle uk-flex-right">
                <h4 class="uk-text-light">Current age</h4>
            </div>
            <div>
                <h2 class="uk-text-light uk-text-center"><?php echo $this->DefaultCurrentAge;?></h2>
            </div>
            <div class=" uk-flex-middle uk-flex-right uk-margin-left">
                <h4 class="uk-text-light">Current plan value</h4>
            </div>
            <div>
                <h2 class="uk-text-light uk-text-center"><?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$');?><?php echo number_format($this->DefaultPortValue);?></h2>
            </div>
            <div class=" uk-flex-middle uk-flex-right uk-margin-left" hidden>
                <h4 class="uk-text-light">Currency</h4>
            </div>
            <div uk-form-custom="target: true" class="uk-flex-middle atr-form-inputs uk-text-light uk-text-center" hidden>
                <select aria-label="Custom controls" onChange="setCurrencyonchange(this);">
                    <option value="$" <?php echo ($_COOKIE['selectedcurrencytext'] == '$ (USD)' ? 'selected="selected"' : '');?>> $ (USD) </option>
                    <option value="£" <?php echo ($_COOKIE['selectedcurrencytext'] == '£ (GBP)' ? 'selected="selected"' : '');?>> £ (GBP) </option>
                    <option value="€" <?php echo ($_COOKIE['selectedcurrencytext'] == '€ (EUR)' ? 'selected="selected"' : '');?>> € (EUR) </option>
                    <option value="$" <?php echo ($_COOKIE['selectedcurrencytext'] == '$ (CAD)' ? 'selected="selected"' : '');?>> $ (CAD) </option>
                </select>
                <h2 class="uk-text-light uk-text-center uk-margin-remove-top"><span></span></h2>
            </div>
        </div>
        <div class="uk-text-center profile-information">
            <h1>I am...</h1>
        </div>
        <div class="uk-grid-match uk-child-width-1-3@m uk-flex-top" uk-grid>
            <div class="uk-text-center">
                <h1 class="uk-margin-remove-bottom"><a href="javascript:void(0);"
                onClick="window.location.href='<?php echo website_url($this->controller.'/contributing');?>'" class="atr-investing">Contributing</a></h1>
                <p class="information uk-margin-remove-top">I am adding to my pot of money to increase my savings. This can include amounts my employer is contributing on my behalf.</p>
            </div>
            <div class="uk-text-center uk-margin-remove-top@s">
                <h1 class="uk-margin-remove-bottom"><a href="javascript:void(0);"
                onClick="window.location.href='<?php echo website_url($this->controller.'/investing');?>'" class="atr-growing">Investing</a></h1>
                <p class="information uk-margin-remove-top">I am not adding to my pot of money, I’m investing to grow my
                    savings.</p>
            </div>
            <div class="uk-text-center">
                <h1 class="uk-margin-remove-bottom"><a href="javascript:void(0);"
                onClick="window.location.href='<?php echo website_url($this->controller.'/withdrawing');?>'" class="atr-harvesting">Withdrawing</a></h1>
                <p class="information uk-margin-remove-top">I am receiving benefits/withdrawing from my savings pot.</p>
            </div>
        </div>
    </div>
</div>
<style> .jtchomeicon { 	display:none; }</style>
<?php echo $this->txtSessionIDtxtUserInput; ?>