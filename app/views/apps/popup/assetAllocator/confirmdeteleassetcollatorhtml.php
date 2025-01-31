<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="uk-modal-dialog uk-modal-body">
		<h2 class="uk-modal-title">Are you sure you want to delete this solution?</h2>
		<h3><span uk-icon="file-text"></span> <?php echo $ClientName;?></h3>
		<p>Select ARCHIVE and the solution will be archived for 30 days</p>
		<p>Click DELETE NOW to delete immediately.</p>
		<hr>
		<p class="uk-text-right">
			<button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
			<button class="uk-button uk-button-primary uk-border-pill" type="button" onclick="confirmdeteleassetcollatoraction('<?php echo ($iduserallocator);?>','<?php echo encryptKey('2');?>');">Archive</button>
			<button class="uk-button uk-button-danger uk-border-pill" type="button" onclick="confirmdeteleassetcollatoraction('<?php echo ($iduserallocator);?>','<?php echo encryptKey('1');?>');">Delete now</button>
		</p>
</div>