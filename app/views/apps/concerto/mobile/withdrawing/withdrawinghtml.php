<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div>
    <div class="uk-container">
        <div class="uk-alert-primary uk-margin-small-top uk-margin-medium-bottom" uk-alert> <a href
                class="uk-alert-close" uk-close></a>
            <p>Please review your Plan Documentation to understand which options are available to you.</p>
        </div>
        <h1 class="atr-planting">I am making withdrawing for&mldr;</h1>
        <div class="atr-rational uk-text-center uk-child-width-1-3@l" uk-grid>
            <div>
                <h3 class="uk-margin-remove-bottom"><a href="javascript::void(0);"
                        class="atr-flexible-income" onClick="RedirectPageView('FlexibleIncome','<?php echo website_url($this->controller.'/withdrawing-background');?>')">Flexible Income</a></h3>
                <p class="information uk-margin-remove-top">I am withdrawing my money for flexible income.</p>
            </div>
            <div>
                <h3 class="uk-margin-remove-bottom"><a href="javascript::void(0);" class="atr-annuity" onClick="RedirectPageView('Annuity','<?php echo website_url($this->controller.'/withdrawing-background');?>')">Annuity</a>
                </h3>
                <p class="information uk-margin-remove-top">I am withdrawing my money for regular income – the same amount each month/year.</p>
            </div>
            <div>
                <h3 class="uk-margin-remove-bottom"><a href="javascript::void(0);" class="atr-cash-lump-sum" onClick="RedirectPageView('CashLumpSum','<?php echo website_url($this->controller.'/withdrawing-background');?>')">Cash
                        Lump Sum</a></h3>
                <p class="information uk-margin-remove-top">I am withdrawing my money as a lump sum.</p>
            </div>
        </div>
    </div>
</div>