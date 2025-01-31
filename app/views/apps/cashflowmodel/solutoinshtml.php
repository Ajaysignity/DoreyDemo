<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div id="graphapierror" style="color:red;text-align: center;"></div>
<div class="uk-section uk-width-expand@m cashflowsoltion-dashboard">
	<div class="uk-grid-small uk-grid client_info">
		<div class="uk-width-1-3@m uk-border-right padding_right cashflowleftsidebar" >
			<?php include('basicformsolutoinshtml.php');?>
			<?php include('incomeformsolutoinshtml.php');?>
			<?php include('investmentformsolutoinshtml.php');?>
			<?php include('assumptionsinfohtml.php');?>
			<?php include('goalseekformsolutionhtml.php');?>
			<?php include('settingsinfohtml.php');?>
		</div>
		<div class="uk-width-2-3@m rightpanel cashflowrightsidebar">
			<div class="outer_fdiv">
			<fieldset class="uk-fieldset info_form">
				<legend class="uk-legend"><?php echo $info->Solution;?></legend>
				<p>Real Term | Infalation 5 years: 2.60%; 6 +years:2.00%</p>
			</fieldset>
			<div class="double_btns pot_btns">
				<div class="graphinvestmentpotdropdown PotToViewDropDown">
					<label>Pot to view</label>
					<select class="uk-select uk-margin-small-bottom uk-border-pill potToView" onchange="ClickcollectionAllTypeOfData();createFlowsChart('allcashflows');">
						<option value="1">Investment pot 1</option>
						<option value="totalassets">Total Assets</option>
					</select>
				</div>

				<div class="graphinvestmentpotdropdown">
					<label>Chart projection Type</label>
					<select class="uk-select uk-margin-small-bottom uk-border-pill" onchange="ChangeChartProjectionTypeToShow(this.selectedIndex)">
						<option selected="selected">Wealth Projection</option>
						<option>Cashflow Projection</option>
					</select>
				</div>

				<div class="graphinvestmentpotdropdown">
					<label>Display Type</label>
					<select class="uk-select uk-margin-small-bottom uk-border-pill" onchange="setRealNominal_OnEditorView(this.selectedIndex);ClickcollectionAllTypeOfData()">
						<option selected="selected">Real</option>
						<option>Nominal</option>
					</select>
				</div>
				
				<div class="cashflowprojection_sectionarea uk-hidden">
				 <div class="flex_btns">
				   <div class="display_view">
						<label>Display percentile</label>
						<select class="uk-select uk-margin-small-bottom uk-border-pill" onchange="ChoosePercentileFlowsChart(this)">
							<option hidden="">Non probabilistic</option>
							<option>High 25th</option>
							<option>40th</option>
							<option selected="selected">Medium 50th</option>
							<option>60th</option>
							<option>70th</option>
							<option>80th</option>
							<option>90th</option>
							<option>Low 95th</option>
						</select>
					</div>
					<div class="over_view">
						<label>View Overall Cashflows</label>
						<select class="uk-select uk-margin-small-bottom uk-border-pill" onchange="ShowOverallFlowsChart(this);">
							<option>Yes</option>
							<option selected="selected">No</option>
						</select>
					</div>
                   </div>
				  </div>
				   <div class="cashflowprojection_sectionarea uk-hidden">
						<div class="uk-margin uk-grid-small uk-child-width-auto uk-grid radio_btns">
						<div class="flow_brand">
					  	<input class="uk-radio InflowsChartButtonClass" type="radio" name="radio2" onchange="createFlowsChart('inflow')" id="InflowsChartButton0" value="inflow"><label>inflows</label>
						</div>
						<div class="flow_brand">
					 	<input class="uk-radio InflowsChartButtonClass" type="radio" name="radio2" onchange="createFlowsChart('outflow')" id="OutflowsChartButton0" value="outflow"> <label>Outflows</label>
                         </div>
						 <div class="flow_brand">
					  	<input class="uk-radio InflowsChartButtonClass" type="radio" name="radio2" checked onchange="createFlowsChart('allcashflows')" id="AllCashflowsChartButton0" value="allcashflows"><label>All Cashflows</label>
						 </div>
				    	</div>
					</div>	
				</div>
           </div>
			<div class="chartprojectiontypedropdown">
				<label>&nbsp;</label>
				<button href="javascript:void(0);" class="uk-button uk-button-default uk-margin-small-bottom  uk-border-pill uk-text-uppercase yellow_btn" aria-expanded="false">Chart options <span><a href="javascript:void(0);" uk-icon="plus"></a></span></button>
			</div>

			<div class="graph_img">
				<div class="solutionline_graph">
					<canvas id="soluionchartsection" width="100" height="50">
						<img src="<?php echo assets_url('pix/graph.png'); ?>">
					</canvas>
				</div>
				<div class="solutionbar_graph uk-hidden">
					<canvas id="soluionchartsection_bar" width="100" height="50">
						<img src="<?php echo assets_url('pix/graph.png'); ?>">
					</canvas>
				</div>
	  		</div>
		</div>
	</div>
</div>
<input type="hidden" id="currentcashSolutionname" value="Psigma<?php //echo (isset($UserInfo->OrganisationName) ? $UserInfo->OrganisationName : ''); ?>" />
<input type="hidden" id="tokenkey" value="<?php echo (isset($tokenkey) ? decryptKey($tokenkey) : ''); ?>" />
<input type="hidden" id="currenttimestamp" value="<?php echo date('d F Y, h:i:s A'); ?>" />
<style>
	 .cashflowleftsidebar{ display: none;}
	.cashflowrightsidebar{ width: 100%;}
	.cashflowleftsidebarlayout{ display: none;} 
</style>
