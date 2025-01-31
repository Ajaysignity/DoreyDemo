<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Financial Projector by Dorey Financial Modelling</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo assets_url('css/dorey-fm.css'); ?>" />
    <link rel="stylesheet" href="<?php echo assets_url('css/fp-public.css'); ?>" />
    <link rel="stylesheet" href="<?php echo assets_url('css/sweetalert2.css'); ?>" />
    <link rel="stylesheet" href="<?php echo assets_url('css/lity.css'); ?>" />
    <link
        href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500&display=swap"
        rel="stylesheet" />
    <script src="<?php echo assets_url('js/uikit.min.js'); ?>"></script>
    <script src="<?php echo assets_url('js/uikit-icons.min.js'); ?>"></script>
    <script>
    var base_url = '<?php echo website_url('');?>';
    var controller = 'welcome';
    <?php if(ENVIRONMENT === 'production'): ?>
    if (location.protocol !== 'https:') {
        location.replace(`https:${location.href.substring(location.protocol.length)}`);
    }
    <?php endif;?>
    </script>
</head>

<body>
    <header uk-navbar class="uk-navbar uk-container uk-container-expand"
        <?php echo ($this->router->fetch_class() == 'JtcB2CAuth' ? 'style="display:none;"':'');?>>
        <div class="uk-navbar-left finantial">
            <figure class="uk-navbar-item"><img src="<?php echo assets_url('pix/DoreyFM.svg'); ?>"
                    alt="Dorey Financial Modelling" width="200px"></figure>
        </div>
        <div class="uk-navbar-left finance">
            <figure class="uk-navbar-item"><img src="<?php echo assets_url('pix/DFM-Financial-Projector_b.svg'); ?>"
                    alt="Financial Projector" width="400px"></figure>
        </div>
        <div class="uk-navbar-right">
            <div class="uk-navbar-item">
                <ul class="uk-navbar-nav">
                    <?php if( $this->session->userdata('UserLoggedin') != TRUE || $this->session->userdata('userid') == '' ) { ?>
                    <li
                        <?php echo ($this->controller=='welcome' && $this->router->fetch_method()=='forgotpassword' ? 'hidden':'');?>>
                        <a href="#common-loginpopup" uk-toggle>Log in</a>
                    </li>
                    <?php } else { ?>
                    <li><a href="javascript:void();"
                            onClick="window.location.href='<?php echo website_url('apps');?>'">My
                            Dashboard</a></li>
                    <li><a href="javascript:void(0);"
                            onClick="window.location.href='<?php echo website_url('welcome/logout');?>'">Log out</a>
                    </li>
                    <?php } ?>
                    <li><a href="#OpenContactPoupWebsite" uk-toggle hidden>Contact Us</a></li>
                </ul>
            </div>
        </div>
    </header>

    <?php $this->load->view($views, $data); ?>

    <footer uk-navbar class="uk-navbar uk-container uk-container-expand"
        <?php echo ($this->router->fetch_class() == 'JtcB2CAuth' ? 'style="display:none;"':'');?>>
        <div class="uk-navbar-left">
            <figure class="uk-navbar-item"><img src="<?php echo assets_url('pix/DoreyFM.svg');?>"
                    alt="Dorey Financial Modelling" width="200px"></figure>
        </div>
        <div class="uk-navbar-right">
            <div class="uk-navbar-item">
                <ul class="uk-navbar-nav">
                    <li><a>&copy; Dorey Limited</a></li>
                </ul>
            </div>
        </div>
    </footer>
    <a id="toTopFromBottom"></a>
    <div id="organisationfree-trial" uk-modal="bg-close: false">
        <div class="uk-modal-dialog uk-modal-body">
            <figure><img src="<?php echo assets_url('pix/FinancialProjector_alt.svg'); ?>" alt="Financial Projector"
                    width="300px"></figure>
            <p>Try financial projector with a free 28 day trial</p>
            <?php echo form_open(base_url(), ['class' => 'uk-form-stacked OrgantionRegForm', 'method' => 'POST', 'data-action' => 'authorganisation']); ?>
            <div class="uk-margin">
                <label class="uk-form-label" for="firstname">First name*</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="firstname" type="text" placeholder="First name" required>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="surname">Surname*</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="surname" type="text" placeholder="Surname" required>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="email">Email address*</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="email" type="email" placeholder="Email address" required>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="mobile">Mobile phone number to receive verification codes*</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="mobile" type="text" placeholder="Mobile Number" required>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="company">Organisation name*</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="company" type="text" placeholder="Organisation name" required>
                </div>
            </div>
            <div class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
                <button class="uk-button uk-button-primary uk-border-pill" type="submit"
                    onclick="ValidateFormSubmit('OrgantionRegForm','Sign up');">Sign up</button>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
    <div id="common-loginpopup" uk-modal="bg-close: false">
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title">Log in</h2>
            <?php echo form_open(base_url(), ['class' => 'uk-form-stacked authloginFrom', 'method' => 'POST', 'data-action' => 'authlogin']); ?>

            <div class="uk-margin">
                <label class="uk-form-label" for="username">User name</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="username" type="text" placeholder="User name" required>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="password">Password</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="password" type="password" placeholder="Password" required>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="password">
                    <span class="refreshCaptchacodeImage"><?php echo $data['captchaImg']; ?></span>
                    <span>Can't read the image? click <a href="javascript:void(0);" class="refreshCaptchaImage">here</a> to refresh.</span>
                </label>
                
            </div>
            <div class="uk-margin">
                <div class="uk-form-controls">
                <input class="uk-input" name="captchaimage" type="text" placeholder="Enter captcha code.. "
                required>
                </div>
            </div>
            
            <div class="uk-margin">
                <a href="javascript:void();"
                    onClick="window.location.href='<?php echo website_url('forgot-your-password');?>'">Forgot
                    Password</a>
            </div>
            <div class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
                <button class="uk-button uk-button-primary uk-border-pill" type="submit"
                    onclick="ValidateFormSubmit('authloginFrom','Sign up');">Log in</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

    <div id="otp_regmodel" uk-modal="bg-close: false">
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title">Two factor authentication </h2>
            <?php echo form_open(base_url(), ['class' => 'uk-form-stacked verifyloginotpForm', 'method' => 'POST', 'data-action' => 'verifyloginotp']); ?>
            <div class="uk-margin">
                <label class="uk-form-label" for="otp">Please insert the verification code</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="otpnumber" type="text" placeholder="verification code">
                </div>
            </div>
            <div class="uk-text-right">
                <div class="resendOTP_Error"></div>
                <div hidden class="uk-margin uk-form-label resendOTP_timermessage" style="display:none;">Resend otp in
                    <span id="OTPTimer"></span>
                </div>
                <span class="uk-form-label resendOTP_buttonlabel" for="otp" class="">Didn’t receive an SMS? <a
                        href="javascript:void(0);" class="resendOTPButton">Resend</a></span>
                <button class="uk-button uk-button-primary uk-border-pill" type="submit"
                    onclick="ValidateFormSubmit('verifyloginotpForm','Log in');">Log in</button>
            </div>
            </form>
        </div>
    </div>
    <div id="OpenContactPoupWebsite" uk-modal="bg-close: false">
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title">Contact us</h2>
            <p>How can we help?</p>
            <?php echo form_open(base_url(), ['class' => 'uk-form-stacked OpenContactPoupForm', 'method' => 'POST', 'data-action' => 'saveopencontactformdata']); ?>
            <div class="uk-margin">
                <label class="uk-form-label" for="contact-name">Name*</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="contactname" type="text" placeholder="Your name" required>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="contact-email">Email address*</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="contactemail" type="email" placeholder="Your email address" required>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="contact-subject">Subject*</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="contactsubject" type="text" placeholder="Subject" required>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="contact-message">Message*</label>
                <div class="uk-form-controls">
                    <textarea class="uk-textarea" name="contactmessage" rows="5" placeholder="What's your message..."
                        required></textarea>
                </div>
            </div>
            <div class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
                <button class="uk-button uk-button-primary uk-border-pill" type="submit"
                    onclick="ValidateFormSubmit('OpenContactPoupForm','Send');">Send</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

    <script src="<?php echo assets_url('js/jquery.min.js'); ?>"></script>
    <script src="<?php echo assets_url('js/helper.min.js'); ?>"></script>
    <script src="<?php echo assets_url('js/sweetalert2.min.js'); ?>"></script>
    <script src="<?php echo assets_url('js/lity.js'); ?>"></script>
    <script src="//cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</body>

</html>