<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="uk-container">
    <!--for mobile only -->
    <div class="uk-grid-small uk-hidden@m uk-margin-bottom" uk-grid>
        <div class="uk-text-center uk-width-1-2">
            <h4 class=" uk-text-light uk-margin-remove-vertical">Current age</h4>
            <h2 class=" uk-text-light uk-margin-remove-vertical" id="Age"><?php echo $this->DefaultCurrentAge;?></h2>
        </div>
        <div class="uk-text-center uk-width-1-2">
            <h4 class="uk-text-light uk-margin-remove-vertical">Current plan value</h4>
            <h2 class="uk-text-light uk-text-center uk-margin-remove-vertical" id="PotValue">
                <?php echo (isset($_COOKIE['selectedcurrencyvalue']) ? $_COOKIE['selectedcurrencyvalue'] : '$');?><?php echo number_format($this->DefaultPortValue);?>
            </h2>
        </div>
    </div>
    <!--end mobile.-->
    <div class="uk-text-center profile-information">
        <h1>I am...</h1>
    </div>
    <div class="uk-grid-match uk-child-width-1-3@m" uk-grid>
        <div class="uk-text-center">
            <h1 class="uk-margin-remove-bottom"><a href="javascript:void(0);"
                    onClick="window.location.href='<?php echo website_url($this->controller.'/contributing');?>'"
                    class="atr-investing">Contributing</a></h1>
            <p class="information uk-margin-remove-top">I am adding to my pot of money to increase my savings. This can
                include amounts my employer is contributing on my behalf.</p>
        </div>
        <div class="uk-text-center">
            <h1 class="uk-margin-remove-bottom"><a href="javascript:void(0);"
                    onClick="window.location.href='<?php echo website_url($this->controller.'/investing');?>'"
                    class="atr-growing">Investing</a></h1>
            <p class="information uk-margin-remove-top">I am not adding to my pot of money, I’m investing to grow my
                savings.</p>
        </div>
        <div class="uk-text-center">
            <h1 class="uk-margin-remove-bottom"><a href="javascript:void(0);"
                    onClick="window.location.href='<?php echo website_url($this->controller.'/withdrawing');?>'"
                    class="atr-harvesting">Withdrawing</a></h1>
            <p class="information uk-margin-remove-top">I am receiving benefits/withdrawing from my savings pot.</p>
        </div>
    </div>
</div>

<?php echo $this->txtSessionIDtxtUserInput; ?>