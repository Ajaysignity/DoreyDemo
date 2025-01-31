<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="uk-modal-dialog uk-modal-body">
		<?php if( $info->Type == 'Folder') { ?>
		<h2 class="uk-modal-title">Are you sure you want to delete this folder and its contents?</h2>
		<h3><span uk-icon="folder"></span> <?php echo ucwords($info->Solution); ?></h3>
		<p>Select ARCHIVE and the folder and its contents will be archived for 30 days.</p>
		<p>Click DELETE NOW to delete immediately.</p>
	<?php } else { ?>
		<h2 class="uk-modal-title">Are you sure you want to delete this solution?</h2>
		<h3><span uk-icon="file-text"></span> <?php echo ucwords($info->Solution); ?></h3>
		<p>Select ARCHIVE and the solution will be archived for 30 days</p>
		<p>Click DELETE NOW to delete immediately.</p>
	<?php }  ?>
    <hr>
    <p class="uk-text-right">
		<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
		<button onclick="Final_removeFolderSolutions(this);" class="uk-button uk-button-primary uk-border-pill" type="button" data-SolRow="<?php echo encryptKey($info->idusersolutions); ?>" data-modeltype="<?php echo encryptKey($info->Type); ?>" data-FolderUniQIDS="<?php echo encryptKey(!empty($info->UniqueFolderID) ? $info->UniqueFolderID : 0 ); ?>" data-isarchived="<?php echo encryptKey('archive'); ?>" data-frompage="<?php echo $frompage;?>">Archive</button>
		<button onclick="Final_removeFolderSolutions(this);" class="uk-button uk-button-danger uk-border-pill" type="button" data-SolRow="<?php echo encryptKey($info->idusersolutions); ?>" data-modeltype="<?php echo encryptKey($info->Type); ?>" data-FolderUniQIDS="<?php echo encryptKey(!empty($info->UniqueFolderID) ? $info->UniqueFolderID : 0 ); ?>" data-isarchived="<?php echo encryptKey('delete'); ?>" data-frompage="<?php echo $frompage;?>">Delete now</button>
    </p>
</div>