<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div>
    <div class="uk-container">
        <h1>Welcome to Concerto Financial Modeller</h1>
        <blockquote>An online questionnaire designed to help you understand your investment risk profile, how to apply that to your asset allocation, and give you information on the achievability of your investment goals.</blockquote>
        <div class="uk-column-1-3">	
            <p>You can save a PDF version of your results, but please note that this tool is not intended to give individual investment advice. We recommend reviewing your responses at least annually, or when your circumstances change.</p>
			
			<p>Past performance cannot be relied upon as a guide to future performance. The price of and income derived from the financial products described in this tool can go down as well as up and investors may not recoup the amount originally invested.</p>

            </p>Specific professional advice should be obtained before taking or refraining from any action in connection with the results of the survey.</p>
			
        </div>
        <div class="uk-text-center">
            <p class="uk-text-center uk-margin-medium-top">
                <button type="button"
                    class="uk-button uk-button-default uk-border-pill uk-text-capitalize button-focus uk-width-1-3"
                    onClick="window.location='<?php echo website_url($this->controller.'/choice');?>'">Continue</button>
            </p>
        </div>

    </div>
</div>
</div>
<style> .jtchomeicon { 	display:none; }</style>
<?php echo $this->txtSessionIDtxtUserInput; ?>