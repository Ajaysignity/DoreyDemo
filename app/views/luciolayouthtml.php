<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!doctype html>
<html>

<head data-machine="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
    <meta charset="UTF-8">
    <title><?php echo (isset($data['title']) ? $data['title'] : '');?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo assets_url('dash/css/cashflow.css?ver='.rand(2,99)); ?>" />
    <link rel="stylesheet" href="<?php echo assets_url('dash/css/dorey-fm.css'); ?>" />

    <link rel="stylesheet" href="<?php echo assets_url('dash/css/fp-private.css?ver='.rand(5,99)); ?>" />
    <link rel="stylesheet" href="<?php echo assets_url('dash/css/sweetalert2.css'); ?>" defer />
    <link rel="stylesheet" href="<?php echo assets_url('dash/css/jquery-ui.css'); ?>" defer />
    <link rel="stylesheet" href="<?php echo assets_url('dash/css/lity.css');?>" defer />
    <link rel="stylesheet" href="<?php echo assets_url('dash/css/dataTables.uikit.min.css');?>" defer />
    <script src="<?php echo assets_url('dash/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo assets_url('dash/js/uikit.min.js'); ?>"></script>
    <script src="<?php echo assets_url('dash/js/uikit-icons.min.js'); ?>"></script>
    <script>
    var base_url = '<?php echo website_url('');?>';
    var controller = '<?php echo $this->controller;?>';
    var ActiveMethod = '<?php echo $this->method;?>';
    </script>

</head>

<body id="finacial-projector-main">
    <div id="dfm-preloader"></div>
    <header uk-navbar class="uk-navbar uk-container uk-container-expand">
        <div class="uk-navbar-left">
            <a href="javascript:void(0);" onClick="window.location.href='<?php echo website_url('homepage');?>'">
                <figure class="uk-navbar-item"><img src="<?php echo getorganisation_logo();?>" alt="Financial Projector"
                        width="<?php echo (1008 == $this->organisation ? '150px' : '200px');?>"></figure>
            </a>
        </div>
        <div class="uk-navbar-right">
            <div class="uk-navbar-item">
                <div><img class="uk-border-circle"
                        src="<?php echo getprofile_image((isset($this->userinfo->userprofilepic) ? 'profile/'.$this->userinfo->userprofilepic : ''));?>"
                        alt="" style="height: 36px;object-fit: cover;width: 38px;">
                    <?php echo ucwords($this->userinfo->firstname.' '.$this->userinfo->surname);?></div>
                <div uk-dropdown>
                    <ul class="uk-nav uk-dropdown-nav">
                        <li><a href="javascript:void(0);"
                                onClick="window.location.href='<?php echo website_url('dashboard/myprofile');?>'">My
                                profile</a></li>
                        <li class="uk-nav-divider"></li>
                        <?php if($this->userinfo->PowerUser == 1) :?>
                        <li><a href="javascript:void(0);"
                                onClick="window.location.href='<?php echo website_url('teams/settings');?>'">Settings</a>
                        </li>
                        <div uk-dropdown="pos: right-top">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="javascript:void(0);"
                                        onClick="window.location.href='<?php echo website_url('teams/myteam');?>'">My
                                        team</a></li>
                                <li class="uk-nav-divider"><a href="javascript:void(0);"
                                        onClick="window.location.href='<?php echo website_url('teams/roles');?>'">Organisation
                                        role master</a></li>
                                <li class="uk-nav-divider"><a href="javascript:void(0);"
                                        onClick="window.location.href='<?php echo website_url('teams/accounts');?>'">Account
                                        settings</a></li>
                                <li class="uk-nav-divider"><a href="javascript:void(0);"
                                        onClick="window.location.href='<?php echo website_url('accounts/styling');?>'">Branding</a>
                                </li>
                                <li class="uk-nav-divider"><a href="javascript:void(0);"
                                        onClick="window.location.href='<?php echo website_url('#');?>'">Integration</a>
                                </li>
                            </ul>
                        </div>
                        <li class="uk-nav-divider"></li>
                        <?php endif; ?>
                        <li><a href="#support_form" uk-toggle>Support</a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="javascript:void(0);"
                                onClick="window.location.href='<?php echo website_url('welcome/logout');?>'">Log out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div uk-grid class="uk-grid-collapse" uk-height-viewport="expand: true">
        <div class="dash_sidebar dfm-sidebar-left uk-width-small@s" style="max-width:6%;">
            <div class="uk-navbar-item">
                <a href="javascript:void(0);" class="sidebar_icon" uk-icon="home"
                    onClick="window.location.href='<?php echo website_url('homepage');?>'"></a>
            </div>
        </div>
        <div class="dashboard_content wd" style="max-width: 87%; width: 100%;">
            <?php $this->load->view($views, $data); ?>
        </div>
    </div>
    <footer uk-navbar class="uk-navbar uk-container uk-container-expand">
        <div class="uk-navbar-left">
            <a href="<?php echo website_url('solutions');?>">
                <figure class="uk-navbar-item" style="margin-bottom: 3px"><img
                        src="<?php echo assets_url('dash/pix/DoreyFM.svg'); ?>" alt="Financial Projector" width="140px">
                </figure>
            </a><span class="footer_logo">Financial Projector</span>
        </div>

        <div class="uk-navbar-right">
            <div class="uk-navbar-item">
                <ul class="uk-navbar-nav">
                    <li hidden><a href="<?php echo website_url('faqs');?>">User Guide </a></li>
                    <li hidden><a href="<?php echo website_url('legal');?>">Legal </a></li>
                    <li hidden><a href="#support_form" uk-toggle>Support</a></li>
                    <li><a>&copy; Dorey Limited</a></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </footer>
    <a id="toTopFromBottom"></a>
    <?php include 'modals.php';?>
    <script src="<?php echo assets_url('dash/js/jquery-ui.js'); ?>" defer></script>
    <script src="<?php echo assets_url('dash/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo assets_url('dash/js/helper.min.js?ver='.rand(1,99)); ?>" defer></script>
    <script src="<?php echo assets_url('dash/js/sweetalert2.min.js'); ?>" defer></script>
    <script src="<?php echo assets_url('dash/js/lity.js');?>" defer></script>
    <script src="//cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
    <script type="text/javascript">
    Dropzone.options.imageUpload = {
        parallelUploads: 12,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.docx,.xlsx",
        addRemoveLinks: false,
        timeout: 50000,
        uploadMultiple: true,
        success: function(file, response) {
            location.reload();
        }
    };
    </script>
</body>

</html>