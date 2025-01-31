<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div>
    <div class="uk-container">
        <h1 class="atr-planting"><?php echo $this->headerLabel; ?></h1>
        <div class="atr-primary-nav">
            <?php echo doreyjtcSteps('risk'); ?>
            <ul class="uk-child-width-expand uk-margin-small-top" uk-tab>
                <li class="uk-active"
                    onClick="window.location='<?php echo website_url($this->controller.'/contributing-risk');?>'"><span
                        class="uk-position-center-left uk-hidden@s atr-progress" style="padding-left: 20px;"><span
                            class="complete"></span> <span class="complete"></span> <span class="complete"></span> <span
                            class="complete"></span> <span class="complete"></span> <span
                            class="complete"></span></span><a>Risk <i uk-icon="icon: question; ratio: .6" uk-tooltip="title: A lower number indicates less need/ability/willingness to take risk. A higher number indicates more need/ability/willingness to take risk. Different survey questions help us understand your individual risk characteristics. ; delay: 500"></i></a></li>
                <li class="uk-visible@m"
                    onClick="window.location='<?php echo website_url($this->controller.'/contributing-results');?>'">
                    <span class="uk-position-center-left uk-hidden@s atr-progress" style="padding-left: 20px;"><span
                            class="complete"></span> <span class="complete"></span> <span class="complete"></span> <span
                            class="complete"></span> <span class="complete"></span> <span
                            class="complete"></span></span><a>Projection</a>
                </li>
            </ul>
        </div>
        <p class="information uk-visible@s">Your personal risk profile is based on your age, plan value and survey
            responses. There is no 'good' or 'bad' profile. The best approach is to match your risk profile to your
            investments. Your financial advisor can help you with this. <span
                style="font-style: normal; color: #059ACB; font-size: 85%">PLEASE CLICK ‘NEXT’ TO PROCEED</span></p>
        <p class="information uk-hidden@s">Your personal risk profile.</p>
        <?php echo form_open(base_url(), 'class="SaveFormInfo" method="POST" data-action="savecontributingtransparency" data-controller="'.$this->controller.'"');?>
        <div class="RiskMatrixRiskTableDataDivisionBox">
            <table id="risk-matrix"
                class="uk-text-center RiskMatrixRiskTableData uk-table uk-table-small atr-table  atr-table column-highlight-<?php echo (!empty($info->risklabel) ? $info->risklabel :'four'); ?>">
            </table>
        </div>
        <?php form_close(); ?>
    </div>
</div>

<?php $this->load->view($this->template.'/concerto/modal-popup/risk-popuphtml.php');?>