<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<ul class="uk-tab uk-tab-left list_tabs" uk-tab>
	<li class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'mysolutions') !== false ? 'folder_active' : ''); ?> uk-flex uk-margin-small-bottom"><span class="uk-margin-small-right uk-icon" uk-icon="folder"></span><a href="javascript:void(0)" onClick="window.location.href='<?php echo website_url('solutions/mysolutions');?>'">My solutions <span class="uk-icon" uk-icon="chevron-right"></span></a></li>
	
	<li class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'recentsolutions') !== false ? 'folder_active' : ''); ?> uk-flex uk-margin-small-bottom"><span class="uk-margin-small-right uk-icon" uk-icon="folder"></span> <a href="javascript:void(0)" onClick="window.location.href='<?php echo website_url('solutions/recentsolutions');?>'">Recent solutions <span class="uk-icon" uk-icon="chevron-right"></span></a> </li>

	<li class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'teamsolutions') !== false ? 'folder_active' : ''); ?> uk-flex uk-margin-small-bottom teamsolutionsSortableSolution_drag"><?php echo DRAGHANDLERICON;?><span class="uk-margin-small-right uk-icon" uk-icon="folder"></span> <a href="javascript:void(0)" onClick="window.location.href='<?php echo website_url('teamsolutions');?>'">Team solutions <span class="uk-icon" uk-icon="chevron-right"></span></a></li>
	
	<li class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'wastesolutions') !== false ? 'folder_active' : ''); ?> uk-flex uk-margin-small-bottom"><span class="uk-margin-small-right uk-icon" uk-icon="folder"></span> <a href="javascript:void(0)" onClick="window.location.href='<?php echo website_url('wastesolutions');?>'">Waste basket <span class="uk-icon" uk-icon="chevron-right"></span></a></li>

	
</ul>