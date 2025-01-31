
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
		<script src="<?php echo assets_url('js/uikit.min.js'); ?>"></script> 
		<script src="<?php echo assets_url('js/uikit-icons.min.js'); ?>"></script>
		<script>
		var base_url = '<?php echo website_url('');?>';
		var controller = 'welcome';
		//if (location.protocol !== 'https:') {
			//location.replace(`https:${location.href.substring(location.protocol.length)}`);
		//}
		</script>
	</head>
	<body>
        <div class="uk-modal-body">
            <h2 class="uk-modal-title">Reset Password</h2>
            <?php echo form_open(base_url(), 'class="uk-form-stacked resetPasswordFrom" method="POST" data-action="resetpasswordForm"');?>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="password">Password</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="password" type="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="c_password">Confirm Password</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="confirmpassword" type="password" placeholder="Confirm Password" required>
						<input type="hidden" name="userid" value="<?php echo $this->input->get("key"); ?>">
                    </div>
                </div>
                
                <div class="uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
                    <button class="uk-button uk-button-primary uk-border-pill" type="submit" onclick="ValidateForgotPasswordFormSubmit('resetPasswordFrom','Sign up');">Send</button>
                </div>
            </form>
        </div>
        <script src="<?php echo assets_url('js/jquery.min.js'); ?>"></script>
		<script src="<?php echo assets_url('js/helper.min.js'); ?>"></script>
		<script src="<?php echo assets_url('js/sweetalert2.min.js'); ?>"></script>
		<script src="<?php echo assets_url('js/lity.js'); ?>"></script>
		<script src="//cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    </body>
</html>
    