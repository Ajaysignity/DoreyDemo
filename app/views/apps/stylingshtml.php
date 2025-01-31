<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<section class="uk-section" uk-height-viewport="expand: true">
    <div class="uk-container">
        <ul class="uk-breadcrumb">
            <li><a href="<?php echo website_url('apps'); ?>">Home</a></li>
            <li><a href="<?php echo website_url('teams/settings');  ?>">Settings</a></li>
            <li class="uk-active"><span>Branding</span></li>
        </ul>
        <hr>
        <div class="uk-width companyprofile">
            <h5>Company Profile</h5>
            <p>Reinforce your brand and upload your company logo to appear at the top of every page and on report
                downloads.</p>
        </div>
        <div class="uk-width Current_organisationlogo">
            <p>Current logo</p>
            <div class="uk-inline uk-margin">
                <img src="<?php echo getorganisation_logo();?>" alt="Financial Projector" width="400px"
                    class="uk-float-left">
                <div class="uk-text-right uk-padding-small <?php echo HasAppMenuAccess('branding','canedit');?>">
                    <span class="loadingimageshow"></span>
                    <div uk-form-custom class="loadingimagediv">
                        <input type="file" id="organisationlogo" name="organisationlogo">
                        <span class="uk-link">Change</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>