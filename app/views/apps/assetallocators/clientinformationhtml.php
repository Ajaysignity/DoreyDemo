<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="uk-width-expand@m assetallocator-dashboard">
    <div class=" uk-padding">
		<h2><?php echo $ClientName; ?> :  <span class="uk-text-normal uk-text-lighter"><?php echo ucwords($BasicInfo->reportdate); ?></span></h2>
		<div class="uk-margin-small uk-align-right top-btns">
			<div class="uk-inline">
				<div class="current-currency-selected uk-text-success uk-text-small uk-text-capitalize">Current Currency: <?php echo $BasicInfo->referencecurrency; ?></div>
				<button class="uk-button uk-button-primary uk-button-small currencyupdateassetbtn" type="button">Reference currency<span uk-icon="icon: triangle-down"></span></button>
				<div uk-dropdown="animation: slide-top; animate-out: true; duration: 700" class="currencycommondropdownlistupdate">
					<ul class="uk-nav uk-dropdown-nav">
					<?php if( !empty($Currencylists) ): ?>
						<?php foreach($Currencylists as $key => $Currencyname  ): ?>
							<li class="uk-active"><a href="javascript:void(0);" data-minimumhorizon="1" data-key="<?php echo $Currencyname; ?>" data-key="<?php echo $Currencyname; ?>" data-token="<?php echo $tokenkey; ?>" data-type="currency" onclick="clientinfochangesoldata(this)" class="updateassetanchor_<?php echo ($Currencyname == 'U$' ? 'usdollar' : $Currencyname); ?>"><span uk-icon="icon: chevron-double-right"></span><?php echo $Currencyname; ?></a></li>
							<li class="uk-nav-divider"></li>
						<?php endforeach; ?>
					<?php endif; ?>
					</ul>
				</div>
			</div>
			<div class="uk-inline">
				<div class="current-portfolio-selected uk-text-success uk-text-small uk-text-capitalize">Current: <?php echo $BasicInfo->portfoliostrategy; ?></div>
				<button class="uk-button uk-button-primary uk-button-small portfolioupdateassetbtn" type="button">Portfolio Strategy<span uk-icon="icon: triangle-down"></span></button>
				<div uk-dropdown="animation: slide-top; animate-out: true; duration: 700" class="portfoliocommondropdownlistupdate">
					<ul class="uk-nav uk-dropdown-nav">
					<?php if( !empty($InitialiseApidata->PortfolioNames) ): ?>
						<?php foreach($InitialiseApidata->PortfolioNames as $keypair => $portfolioname  ):?>
							<li class="uk-active"><a href="javascript:void(0)" data-minimumhorizon="1" data-type="portfolio" data-key="<?php echo $portfolioname['pair']; ?>" data-token="<?php echo $tokenkey; ?>" onclick="clientinfochangesoldata(this)" class="updateassetanchor_<?php echo $portfolioname['pair']; ?>"> <span uk-icon="icon: chevron-double-right"></span><?php echo $portfolioname['pair']; ?></a></li>
							<li class="uk-nav-divider"></li>
						<?php endforeach; ?>
					<?php endif; ?>
					</ul>
				</div>
			</div>
			<div class="uk-inline">
				<div>&nbsp;</div>
				<button class="uk-button uk-button-primary uk-button-small" type="button">Download reports <span class="download-reportcharacterstcis" uk-icon="icon: triangle-down"></span></button>
				<div uk-dropdown="mode: hover">
					<ul class="uk-nav uk-dropdown-nav">
					<li class="uk-active" hidden><a onClick="window.open('<?php echo website_url('assetallocator/generatereport?tokenkey='.$tokenkey);?>');"><span uk-icon="icon: download"></span>Full Portfolio range</a></li>
					<li class="uk-nav-divider"></li>
					<li><a onClick="generatereportblobxml(this)" ><span uk-icon="icon: download"></span>Portfolio characteristics</a></li>
					<li class="uk-nav-divider"></li>
					<li><a onClick="advancegeneratereportblobxml(this)"><span uk-icon="icon: download"></span>Advanced Portfolio range</a></li>
					</ul>
				</div>
			</div>
		</div>
		<h4>Asset Allocation  </h4>
		<p>Enter current portfolio allocation, and then expand the columns to view Asset Allocator's proposed strategic allocations.</p>
		<div class="uk-grid-small" uk-grid>
			<img class="commom-preloader-assetgrpah" src="<?php echo assets_url('dash/images/dorey-tool-admin-loader.gif'); ?>" style="margin:auto; display:none;">
			<div class="uk-width-2-3@xl uk-width-2-3@l uk-width-1-1@m uk-first-column AssetClassesAllocationTableGrid uk-overflow-auto">
				<img src="<?php echo assets_url('dash/images/dorey-tool-admin-loader.gif'); ?>" style="margin:auto;">
			</div>
			<div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-1@m uk-first-column">
				<div class="uk-visible@m"></div>
				<div class="PortfolioClassesAllocationTableGrid"></div>
			</div>
		</div>
		<div uk-grid class="uk-grid-small uk-grid commom-preloader-chartoptions">
			<div class="uk-width-1-4">
				<div class="assetallocator_grapgdatadropdown">
					<select id="graph-type" class="uk-select GraphAssetDropdownlistData" ></select>
				</div>
			</div>
			<div class="uk-width-1-3">
				<button class="uk-button uk-button-default uk-margin-small-bottom  uk-border-pill uk-text-uppercase yellow_btn" type="button">Chart options <span uk-icon="plus"></span></button>
				<div uk-dropdown="mode: click">
					<ul class="uk-nav uk-dropdown-nav AssetAllocatorChartColorlists">
						<li>
							<div>
								<label class="uk-form-label">Currents</label>
								<div class="uk-form-controls"><input class="uk-input uk-form-small AssetAllocatorChartColorOption" type="color" value="#f0d156"></div>
							</div>
						</li>
						<li class="uk-nav-divider"></li>
						<li>
							<div>
								<label class="uk-form-label">Proposed</label>
								<div class="uk-form-controls"><input class="uk-input uk-form-small AssetAllocatorChartColorOption" type="color" value="#e6f09e"></div>
							</div>
						</li>
						<li class="uk-nav-divider"></li>
						<li>
							<div>
								<label class="uk-form-label">Tailored</label>
								<div class="uk-form-controls"><input class="uk-input uk-form-small AssetAllocatorChartColorOption" type="color" value="#a8d4ed"></div>
							</div>
						</li>
					</ul>
				</div>
				
			</div>
		</div>
		
		<div class="return_graph">
			<canvas id="assetallocator_grapgdata" width="100" height="50">
				<img src="">
			</canvas>
		</div>
    </div>
</div>
<input type="hidden" id="Organisationame" value="<?php echo $this->OrganisationName; ?>" />
<input type="hidden" id="txtSessionIDtxtUserID" value="<?php echo ($this->organisation.'::'.$this->userid.'::'.$this->OrganisationApiName); ?>" />
<input type="hidden" id="tokenkey" value="<?php echo $tokenkey; ?>" />
<input type="hidden" id="iduserallocatorKey" value="<?php echo $iduserallocator; ?>" />
<input type="hidden" id="currenttimestamp" value="<?php echo date('d F Y, h:i:s A'); ?>" />
<style type="text/css">
.top-btns .uk-button {
    border-radius: 15px;
    font-size: 14px;
    text-transform: none;
}



header {
    height: 80px;
}
.uk-notification.uk-notification-bottom-center {
    width: 90%;
    left: 17%;
}
.dfm-sidebar-left {
    background-color: rgba(250,250,250,1.00)
}
.dfm-sidebar-subnav {
    background-color: white;
    border-right: 1px solid rgba(0,0,0,0.05);
}
.dfm-sidebar-left div.nav-icon {
    text-align: center;
    font-size: 10px;
    line-height: 14px;
    padding: 10px 0;
    cursor: pointer;
}
/*
.dfm-sidebar-left a, .dfm-sidebar-left a:hover {
    text-decoration: none;
    color: rgb(117,117,117);
}
*/
.uk-card-hover {
    cursor: pointer
}
.dfm-sidebar-left div.nav-icon:hover {
    background-color: white;
}
.uk-label-warning svg {
    margin-top: -3px;
}
table.uk-table-small tr td, table.uk-table-small thead tr th {
    text-align: center;
    font-size: 14px;
    padding: 4px 8px !important;
}
table.uk-table-small tbody tr td {
    vertical-align: middle !important;
}
table.uk-table-small tr td:first-child {
    text-align: left;
    background-color: rgba(75, 131, 13, .05);
}
table.uk-table-small tfoot {
    color: white;
    font-size: 16px;
    text-align: center;
}
table.uk-table-small tr td input {
    width: 80px;
    text-align: center;
}
.uk-button-group-pill button {
    padding: 0 20px 0 5px;
}
.uk-button-group-pill button:first-child {
    padding: 0 5px 0 20px;
}
/* table.uk-table.uk-table-striped.uk-table-small.uk-table-hover.Advanced_TypeTable td {
    text-align: center;
} */
</style>






