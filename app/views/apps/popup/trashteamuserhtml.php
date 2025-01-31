<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="uk-modal-dialog uk-modal-body">
		<h2 class="uk-modal-title">Are you sure you want to delete this user?</h2>
		<div class="uk-grid-small uk-flex-middle" uk-grid>
			<div class="uk-width-auto">
				<img class="uk-border-circle" width="40" height="40" src="<?php echo getprofile_image((isset($info->userprofilepic) ? 'profile/'.$info->userprofilepic : ''));?>">
			</div>
			<div class="uk-width-expand">
				<h3 class="uk-card-title uk-margin-remove-bottom"><?php echo $info->username ;?></h3>
				<p class="uk-text-meta uk-margin-remove-top">Last log in: <time datetime="2016-04-01T19:00"><?php echo getLastLoginInfo($info->id);?></time></p>
			</div>
		</div>
		<p>Select ARCHIVE and this person will be archived for 30 days.</p>
		<p>Click DELETE NOW to remove them immediately.</p>
		<hr>
		<p class="uk-text-right">
			<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
			<button class="uk-button uk-button-primary uk-border-pill Signity_RemoveTeamusers" type="button" data-actiontype="<?php echo encryptKey('archive');?>" data-userid="<?php echo encryptKey($info->id);?>">Archive</button>
			<button class="uk-button uk-button-danger uk-border-pill Signity_RemoveTeamusers" type="button" data-actiontype="<?php echo encryptKey('delete');?>" data-userid="<?php echo encryptKey($info->id);?>">Delete now</button>			
		</p>
	</div>