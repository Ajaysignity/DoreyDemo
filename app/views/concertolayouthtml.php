<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo (isset($data['title']) ? $data['title'] : '');?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo assets_url('dash/css/dataTables.uikit.min.css');?>" defer />
    <link rel="stylesheet" href="<?php echo assets_url('concerto/css/uikit.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo assets_url('concerto/css/dfm-kit.css?ver='.rand(10,99)); ?>" />
    <link rel="stylesheet" href="<?php echo assets_url('concerto/css/dfm-kit-extra.css?ver='.rand(10,99)); ?>" />
    <link rel="stylesheet" href="<?php echo assets_url('css/sweetalert2.css'); ?>" defer />
    <link rel="stylesheet" href="<?php echo assets_url('css/lity.css');?>" defer />
    <script src="<?php echo assets_url('js/jquery.min.js'); ?>"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;500&display=swap" rel="stylesheet">
    <script>
    var base_url = '<?php echo website_url('');?>';
    var controller = '<?php echo $this->controller;?>';
    var ActiveMethod = '<?php echo $this->method;?>';
    var browserdetect = '<?php echo IsMobileBrowser();?>';
    </script>

</head>

<body id="finacial-projector-main">
    <header uk-navbar class="uk-navbar uk-container uk-container-expand">
        <div class="uk-navbar-left"><a href="javascript:void(0);"
                onClick="window.location.href='<?php echo website_url('concerto/choice');?>'">
                <figure class="uk-navbar-item"><img src="<?php echo assets_url('concerto/pix/Concerto.svg'); ?>" alt="Concerto tool"
                        width="150" alt="Financial Projector"></figure>
            </a></div>
        <div class="uk-navbar-right" ><a onClick="window.location.href='<?php echo website_url('apps');?>'"
                class="uk-icon-button" uk-icon="home"></a>
        </div>
    </header>
    <div class="content-section">
        <?php $this->load->view($views, $data); ?>
    </div>
    <footer>
        <span>
            &copy; Dorey Financial Modelling |
            <a onClick="window.location.href='<?php echo website_url('concerto/termandconditions');?>'">Terms and
                Conditions</a> |
            <a onClick="window.location.href='<?php echo website_url('concerto/faqs');?>'">FAQs</a> |
            <a href="#support_form" uk-toggle hidden>Support</a>
        </span>
    </footer>
    <a id="toTopFromBottom"></a>
    <script src="<?php echo assets_url('concerto/js/uikit.min.js'); ?>"></script>
    <script src="<?php echo assets_url('concerto/js/uikit-icons.min.js'); ?>"></script>

    <script src="<?php echo assets_url('concerto/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo assets_url('concerto/js/helper.min.js?ver='.rand(1,99)); ?>" defer></script>
    <script src="<?php echo assets_url('concerto/js/sweetalert2.min.js'); ?>" defer></script>
    <script src="<?php echo assets_url('concerto/js/lity.js');?>" defer></script>
    <script src="<?php echo assets_url('concerto/js/concerto.tools.min.js?ver='.rand(1,99));?>"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <div id="modal-sectionswithErrorPopup" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" style="border-radius: 18px;">
            <button id="side-close" class="uk-modal-close-default" type="button" uk-close></button>
            <h2 class="uk-modal-title defaultmodaltypetitlemsgError" id="defaultmodaltypetitlemsgError">Error</h2>
            <p id="error-messageError"></p>
            <div class="uk-text-center">
                <div class="uk-button-group uk-button-group-pill uk-width-1-2">
                    <button type="button"
                        class="uk-button formbackbuttontext uk-button-default uk-text-capitalize uk-width-1-1 uk-modal-close"
                        style="border-radius: 500px;">Back</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-confirmationsuccesspopup" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" style="border-radius: 18px;">
            <h2 class="uk-modal-title defaultmodaltypetitlemsgConfirm" id="defaultmodaltypetitlemsgConfirm">Error</h2>
            <p id="error-messageConfirm"></p>
            <div class="uk-text-center">
                <div class="uk-button-group uk-button-group-pill uk-width-1-2">
                    <button type="button" id="close-button"
                        class="uk-button formbackbuttontext uk-button-default uk-text-capitalize uk-width-1-2 uk-modal-close">Back</button>
                    <button id="ok-button"
                        class="uk-button uk-button-default uk-text-capitalize button-focus uk-width-1-2"
                        onclick="ValidateFormSubmit_JTC('SaveFormInfo','Confirm');" type="submit">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div id="support_form" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title">Support</h2>
            <p>For support on how to use Concerto, please see the <a
                    href="<?php echo website_url('jtctools/faqs');?>">FAQs</a> section in the footer below<br />
                Alternatively, please outline your query below<br /></p>
            <?php echo form_open(base_url(), 'class="SaveSupportForm" method="POST" data-action="savesupportdata" data-controller="dashboard"');?>
            Alternatively, please contact ************@jtcgroup.com
            <div class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Close</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <a id="toTopFromBottom"></a>
</body>

</html>