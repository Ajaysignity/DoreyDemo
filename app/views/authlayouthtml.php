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
    <?php if( $this->method == 'apphomepage') { ?>
    localStorage.clear();
    <?php } ?>
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
                        src="<?php echo getprofile_image((!empty($this->userinfo->userprofilepic) ? 'profile/'.$this->userinfo->userprofilepic : ''));?>"
                        alt="" style="height: 36px;object-fit: cover;width: 38px;">
                    <?php echo ucwords($this->userinfo->firstname.' '.$this->userinfo->surname);?></div>
                <div uk-dropdown>
                    <ul class="uk-nav uk-dropdown-nav">
                        <li><a href="javascript:void(0);"
                                onClick="window.location.href='<?php echo website_url('apps/myprofile');?>'">My
                                profile</a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="javascript:void(0);"
                                onClick="window.location.href='<?php echo website_url('teams/settings');?>'">Settings</a>
                        </li>
                        <div uk-dropdown="pos: right-top">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="<?php echo HasAppMenuAccess('myteams','canview');?>"><a
                                        href="javascript:void(0);"
                                        onClick="window.location.href='<?php echo website_url('teams/myteam');?>'">My
                                        team</a></li>
                                <li class="uk-nav-divider "
                                    <?php echo HasAppMenuAccess('organisation_role','canview');?>"><a
                                        href="javascript:void(0);"
                                        onClick="window.location.href='<?php echo website_url('teams/roles');?>'">Organisation
                                        role master</a></li>
                                <li class="uk-nav-divider " <?php echo HasAppMenuAccess('branding','canview');?>"><a
                                        href="javascript:void(0);"
                                        onClick="window.location.href='<?php echo website_url('apps/styling');?>'">Branding</a>
                                </li>

                            </ul>
                        </div>
                        <li class="uk-nav-divider"></li>
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
        <div class="dfm-sidebar-left uk-width-medium@m" style="width: 70px;">
            <div class="nav-icon" onClick="window.location.href='<?php echo website_url('apps');?>'">
                <div><span class="uk-icon-link" uk-icon="home"></span></div>
                <div>Home</div>
            </div>
            <?php  
            if($this->controller == 'apps' && $this->method == 'index'):
                foreach (applists() as $applist ) {
                    echo '<div class="nav-icon '.HasAppMenuAccess($applist['methods'],'canview').' " onClick="'.( $applist['iswindow'] == 0 ? $applist['moduleaccess'] : 'window.location.href=\''.website_url($applist['moduleaccess']).'\' ').'" '.($applist['methods'] == $this->controller ? 'style="background: #efe;"':'').'>
						<div><img src="'.assets_url().'pix/'.$applist['biggericon'].'" width="26px;" /></div>
						<div>'.$applist['modulename'].'</div>
					</div>';
				}  
            endif;        
			?>
        </div>
        <?php if($this->controller == 'assetallocator'): ?>
        <div class="dfm-sidebar-left dfm-sidebar-subnav uk-width-medium@m" style="width: 70px;">
            <div class="nav-icon" style="border-right: 3px solid rgba(75, 131, 13, 1);"
                onClick="window.location.href='<?php echo website_url('assetallocator');?>'">
                <div><span class="uk-icon-link" uk-icon="users"></span></div>
                <div>Clients</div>
            </div>
            <div class="nav-icon" onclick="common_view_modal('assetallocator/addnewassetallocator',this);">
                <div><span class="uk-icon-link" uk-icon="plus-circle"></span></div>
                <div>Create</div>
            </div>
            <div class="nav-icon" style="border-right: 3px solid rgba(75, 131, 13, 0);"
                onClick="window.location.href='<?php echo website_url('assetallocator');?>'">
                <div><span class="uk-icon-link" uk-icon="list"></span></div>
                <div>Returns</div>
            </div>
        </div>
        <?php endif;?>
        <?php if($this->controller == 'cashflow'): ?>
        <div class="dash_sidebar dfm-sidebar-left uk-width-small@s" style="max-width:6%;">
            <div class="uk-navbar-item">
                <a href="javascript:void(0);" class="solutionformpopup sidebar_icon" uk-icon="info"
                    uk-tooltip="title: Start here- insert client information; pos: right" data-formtype="basicinfo"
                    onclick="ClickcollectionAllTypeOfData();"></a>
                <a href="javascript:void(0);" class="solutionformpopup sidebar_icon" uk-icon="database"
                    uk-tooltip="title: Add sources of income; pos: right" data-formtype="incomeinfo"
                    onclick="ClickcollectionAllTypeOfData();"></a>
                <a href="javascript:void(0);" class="solutionformpopup sidebar_icon chart_icon"
                    uk-tooltip="title: Set up investment strategy, cashflows and fee structure; pos: right"
                    data-formtype="investmentinfo"
                    onclick="ClickcollectionAllTypeOfData();"><?php echo INVESTOMENTICON; ?></a>
                <a href="javascript:void(0);" class="solutionformpopup sidebar_icon" uk-icon="cog"
                    uk-tooltip="title: Solution settings; pos: right" data-formtype="settingsinfo"
                    onclick="ClickcollectionAllTypeOfData();"></a>

                <a href="javascript:void(0);" class="solutionformpopup sidebar_icon" uk-icon="nut"
                    uk-tooltip="title: Assumptions; pos: right" data-formtype="assumptionsinfo"
                    onclick="ClickcollectionAllTypeOfData();"></a>

                <a href="javascript:void(0);" class="solutionformpopup sidebar_icon" uk-icon="push"
                    uk-tooltip="title: Export; pos: right" data-formtype="export"></a>
                <a href="javascript:void(0);"
                    class="solutionformpopup uk-button uk-button-default uk-margin-small-bottom  uk-border-pill uk-text-capitalize yellow_btn goal_btn"
                    aria-expanded="false"
                    uk-tooltip="title: Adjust cashflow and set pot value to a selected amount at a chosen time, and specified level of security (confidence level).; pos: right"
                    data-formtype="goalseekinfo" onclick="ClickcollectionAllTypeOfData();">Goal Seek</a>
            </div>
        </div>
        <?php endif;?>
        <div class="dashboard_content " style="width: 100%;max-width: 87%;">
            <?php $this->load->view($views, $data); ?>
            <input type="hidden" id="txtSessionIDtxtUserID"
                value="<?php echo ($this->organisation.'::'.$this->userid.'::'.$this->OrganisationApiName); ?>" />
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
    <?php include 'modal-popup.php';?>
    <script src="<?php echo assets_url('dash/js/jquery-ui.js'); ?>" defer></script>
    <script src="<?php echo assets_url('dash/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo assets_url('dash/js/helper.min.js?ver='.rand(1,99)); ?>" defer></script>
    <script src="<?php echo assets_url('dash/js/sweetalert2.min.js'); ?>" defer></script>
    <script src="<?php echo assets_url('dash/js/lity.js');?>" defer></script>
    <script src="//cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</body>
<?php if($this->controller === 'assetallocator'): ?>
<script src="<?php echo assets_url('dash/js/chart.min-asset.js?ver=4.3.3');?>"></script>
<script src="<?php echo assets_url('dash/js/assetallocator.js?ver='.rand(1,99));?>"></script>
<?php endif;?>
<?php if($this->controller=='solutions' && $this->method=='mysolutions'): ?>
<script src="<?php echo assets_url('dash/js/solution.min.js');?>"></script>
<?php endif; ?>
<?php if($this->controller=='cashflow'): ?>
<script src="<?php echo assets_url('dash/js/chart.min.js?ver=2.7.3');?>"></script>
<script src="<?php echo assets_url('dash/js/cashflow.chart.min.js');?>"></script>
<?php endif; ?>
<?php if($this->controller === 'lucio'): ?>
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
<?php endif;?>
<style type="text/css">
header {
    Height: 80px;
}

.dfm-sidebar-left {
    background-color: rgba(250, 250, 250, 1.00)
}

.dfm-sidebar-left div.nav-icon {
    text-align: center;
    font-size: 10px;
    line-height: 14px;
    padding: 10px 0;
    cursor: pointer;
}

.uk-card-hover {
    cursor: pointer
}

.dfm-sidebar-left div.nav-icon:hover {
    background-color: white;
}

header.uk-navbar {
    margin-bottom: 4px !important;
}

/* a .uk-navbar-item img {	height: 72px !important;} */
.dfm-sidebar-subnav {
    background-color: white;
    border-right: 1px solid rgba(0, 0, 0, 0.05);
}

.uk-card-hover {
    cursor: pointer
}

.dfm-sidebar-left div.nav-icon:hover {
    background-color: white;
}

.uk-label-warning svg {
    margin-top: -3px;
}

.uk-table a {
    text-decoration: none !important;
    color: rgb(117, 117, 117);
}
</style>

</html>