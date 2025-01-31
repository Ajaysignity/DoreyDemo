<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="uk-width-expand@m" id="usersolutionlist-container">
	<div class=" uk-padding dashboard_right">
		<div class="uk-grid-small" uk-grid>
			<div class="uk-width-1-2 uk-border-right buttons_lft">
			<?php $this->load->view($this->template.'/solutions/solutions-navigation',$data); ?>
			</div>
			<div class="uk-width-1-2">
				<form class="uk-form-stacked ajaxsolutionsearchform" method="get">
					<div class="uk-margin">
						<label class="uk-form-label" for="search">Search <small>(Please type atleast 3 characters)</smalll> </label>
						<div class="uk-form-controls">
							<input class="uk-input ajaxsolutionsearchinput uk-width-2-3" name="search" type="text" placeholder="Search..." >
							<button class="ajaxsolutionsearchinputbtn uk-button uk-width-1-6 uk-modal-close uk-button-default" type="button"><span uk-search-icon></span></button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<hr>
		<div class="folder_box" id="myfoldersection">
			<div class="uk-grid-small folders_era" uk-grid>
				<div class="uk-width-1-5@xl uk-width-1-4@l uk-width-1-3@m">
					<?php $this->load->view($this->template.'/solutions/solutions-tabs',$data); ?>
				</div>
				<div id="folderlistboxsectiondiv1" class="uk-width-1-5@xl uk-width-1-4@l uk-width-1-3@m folderlistboxsection height_div" data-subfolderbox="box1" data-boxnumber="1">
					<ul class=" uk-tab uk-tab-left list_tabs parentfolderbox_ul1" uk-tab >
						<li class="uk-flex uk-margin-small-bottom droppedSolutionArea"></li>
					</ul>
				</div>
				<?php for( $placement = 2; $placement <= 7; $placement++ ): ?>
					<div style="display:none;"  id="folderlistboxsectiondiv<?php echo $placement; ?>" class="uk-width-1-5@xl uk-width-1-4@l uk-width-1-3@m height_div folderlistboxsection" data-subfolderbox="box<?php echo $placement; ?>" data-boxnumber="<?php echo $placement; ?>">
						<ul class=" uk-tab uk-tab-left list_tabs folderlistboxsection_ul<?php echo $placement; ?>" uk-tab >
							<li class="uk-flex uk-margin-small-bottom droppedSolutionArea">
								box<?php echo $placement; ?>
							</li>
						</ul>
					</div>
				<?php endfor;;?>
			</div>
		</div>
		<hr>
		<div id="reloaddatarefresh">
			<table class="uk-table uk-table-hover uk-table-divider uk-table-small" id="SolutionDataTableColmn" data-action="mysolutions_json" data-mode="mysolutions">
				<thead>
					<tr>
						<th>Solutions</th>
						<th>Date modified</th>
						<th class="uk-text-right">Edit</th>
					</tr>
				</thead>
				<tbody id="mysolutionsTargetcontent">
					<tr>
						<td colspan="3" style="text-align:center;">
							<img src="<?php echo assets_url('dash/pix/ajax-loader.gif'); ?>">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>