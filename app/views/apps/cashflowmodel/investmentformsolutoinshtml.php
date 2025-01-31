<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<fieldset class="uk-fieldset info_form solutioninvestmentinfoform" style="display:none;">
	<legend class="uk-legend uk-text-capitalize">Client A</legend>
	<h6 class="uk-text-capitalize"> Investment pots</h6>
	<p>Set up investment strategies and their fee structures</p>
	<ul class="solution_form commoninvestomentgridform pot_html">
		<!-- <li class="uk-margin investomentpotslisection investomentpotlist_1">
			<input class="uk-input listinputtextpotname solutionform_investomentgridinput_1" type="text" value="Investment pot 1">
			<span class="pot_actions">
				<a href="javascript:void(0);"><input class="potcolorcodebox potcolorcodeboxvalue" type="color" value="#697d8a" data-item="1" oninput="getpotcolorcode(this)"></a>
				<a href="javascript:void(0);" uk-icon="trash" class="trashsolutionform_investment" data-item="1"></a>
				<a href="javascript:void(0);" uk-icon="plus" uk-toggle="target: #solutionform_investomentgrid_1" class="expandsolutionform investomentgrid_1formtoggle"></a>
			</span>
			<div id="solutionform_investomentgrid_1" class="uk-grid-small salary_grid invest_grid" uk-grid hidden>
				<div uk-accordion>
					<div class="invest_li">
						<a class="uk-accordion-title" href="#">Investment Strategy</a>
						<div class="uk-accordion-content">
							<p>The investment strategy chosen at NOW represents the investment strategy until END unless the strategy is changed.<br>
								Select Add strategy node to change the investment strategy. Click on the + to select the Risk Rating to shift to Glide or Static.
							</p>
							<div class="uk-flex uk-flex-right cc_btns">
								<button type="button" class="uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-capitalize yellow_btn addInvestmentStrategyColmn" aria-expanded="false" aria-expanded="false" data-CashFlowitem="1"  onclick="addInvestmentStrategyColmn(this);">Add strategy node</button>
							</div>
							<div class="uk-flex uk-flex-middle rating_area">
								<p class="uk-width-1-5">AT AGE</p>
							</div>
							<table class="table InvestmentStrategycashflow_table investmentcashflowrowTableCommon solutionform_InvestmentStrategy_table_1">
								<thead>
									<tr>
										<th class="currentagevalue colsIndex1">50: Now</th>
										<th class="addothercolsbefore currentprojectionagevalue">100: End</th>
									</tr>
								</thead>
								<tbody>
									<tr class="colorRef54 custom_background">
										<td class="colsIndex1 CloneInvestmentStrategyColumn typeyear_strategycolmn">
											<a class="selectedRating" aria-expanded="false" name="Cautious Balanced" data-value="3">Cautious Balanced</a>
											<div uk-dropdown="mode: click;" class="investmentstrategy_lists">
												<div class="uk-dropdown-grid uk-child-width-1-1@m uk-grid uk-grid-stack projectionrating" >
													<div>
														<div class="uk-nav uk-dropdown-nav">
															<p class="uk-nav-header">STRATEGY</p>
															<?php foreach( $TypeOverallStrategy as $key=>$list) : ?> 
															<p style="hover"><a class="chooseinvestmentstrategy" data-value="<?php echo $key;?>" data-list="1"><?php echo $list;?></a></p>
															<?php endforeach; ?>
														</div>
													</div>
												</div>
											</div>
										</td>
										<td class="addothercolsbefore"><span class="shiftArrow1">➤</span></td>
									</tr>
								</tbody>
							</table>	
							
						</div>
					</div>
					<div class="invest_li">
						<a class="uk-accordion-title" href="#">Fee structure</a>
						<div class="uk-accordion-content">
							<p>Select fee model and insert any other charges. Expenses are set at organisational level</p>
							<table class="table freestructuregridcashflow_table investmentcashflowrowTableCommon solutionform_freestructure_table_1">
								<thead>
									<tr>
										<th>Fee model <a href="javascript:void(0);" uk-icon="plus" class="expandfeestructuremodel" data-CashFlowitem="1"></a></th>
										<th class="hideexpanse" hidden>Expenses</th>
										<th>Other charges</th>
										<th>Indicator</th>
										<th>Detail</th>
									</tr>
								</thead>
								<tbody>
									<tr class="light_grey">
										<td>
											<select class="uk-select extrapadding idFeeModelSelect">
												<option value="1">Standard</option>
												<option value="2">Wealth</option>
												<option value="3">Bespoke</option>
											</select>
										</td>
										<td class="hideexpanse" hidden><input type="text" class="idExpensesValue" value="1.5%"></td>
										<td><input type="text" value="0%" class="idTaxValue"></td>
										<td><div class="color-area"></div></td>
										<td><span><a href="javascript:void(0);" uk-icon="info"></a></span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="invest_li uk-hidden">
						<a class="uk-accordion-title" href="#">Projection events</a>
						<div class="uk-accordion-content">
							<p>Choose between normal and mean reverting markets, and add a market downturn to test different economic scenarios.</p>
							<div class="uk-flex uk-flex-right cc_btns">
								<button type="button" class="uk-button uk-button-default uk-margin-small-bottom uk-border-pill uk-text-capitalize yellow_btn addprojectioneventrow" aria-expanded="false" data-CashFlowitem="1" aria-expanded="false">Add market downturn</button>
							</div>
							<table class="table projectioneventgridcashflow_table investmentcashflowrowTableCommon___ solutionform_projectioneventgrid_table_1_____">
								<tbody></tbody>
							</table>
						</div>
					</div>
					<div class="invest_li">
						<a class="uk-accordion-title" href="#">Cashflows</a>
						<div class="uk-accordion-content">
							<p>Add and edit cashflows by selecting inflow or outflow and toggle the format of the amount (£ or %)</p>
							<div class="table_responsive">
							<table class="table cashflow_table investmentcashflowrowTable solutionform_investomentgrid_table_1">
								<thead>
									<tr>
										<th>Cashflow name</th>
										<th><div class="uk-inline objInOutFlowIndicator"></div></th>
										<th data-uk-tooltip title="Choose &euro; or %">Amount</th>
										<th>Goal Seek</th>
										<th>Type</th>
										<th>Start</th>
										<th>End</th>
										<th>Indicator<div class="uk-inline objHelpIndicator"></div></th>
										<th>Details</th>
										<th class="expandallcolms"><span  uk-icon="arrow-right"></span></th>
										<th class="hidecolmns" hidden>Probability of shortfall</th>
										<th class="hidecolmns" hidden>Expected shortfall</th>
										<th class="hidecolmns" hidden><span class="collapseallcolms" uk-icon="arrow-left"></span></th>
									</tr>
								</thead>
								<tbody>
									<tr class="light_grey" Row-Index="1" data-idTypePot="1">
										<td><input class="uk-input uk-form-small readonlyArea investmentcashflowname" type="text" value="Cashflow name"></td> 
										<td class="info_select">
											<select class="uk-select CashflowAllarrinoutflow">
												<option value="0">inflow</option>
												<option value="1">Outflow</option>
											</select>
										</td>
										<td class="amount_field">
											<select class="uk-select investmentcashflowcurrency">
												<option value="0">£</option>
												<option value="1">%</option>
											</select>
											<input class="uk-input uk-form-small investmentcashflowvalue" type="text" value="22000">
										</td>
										<td><span data-formtype="goalseekinfo" uk-icon="uikit" class="goal_icon solutionformpopup" style="cursor: pointer;"></span></td>
										<td>
											<select class="uk-select CashFlowAllTypebegin">
												<?php if( isset($typebeginlists) && !empty($typebeginlists)) : ?>
													<?php $typevalue=0;foreach($typebeginlists as $text=> $title ): ?>
														<option title="<?php echo $title; ?>" value="<?php echo $typevalue++;?>"><?php echo $text; ?></option>
													<?php endforeach; ?>
												<?php endif; ?>
											</select>
										</td>
										<td>
										<select class="uk-select LoadgoalseekprojectionAtTimelist">
											<?php if( isset($timelistdropdown) && !empty($timelistdropdown)) : ?>
												<?php foreach($timelistdropdown as $text=> $title ): ?>
													<option value="<?php echo $text;?>" <?php echo ($text == 1 ? 'selected':'');?>><?php echo $title; ?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									 	</td>
										<td>
										<select class="uk-select LoadAllTypeEndOptions" hidden>
										</select>
										</td>
										<td class="expand_icon">
											<div class="defaultcolor-area"></div>
										</td>
										<td>
											<a class="selectedRating" aria-expanded="false"><i uk-icon="info"></i></a>
											<div uk-drop="mode: click;" class="investmentcashflownamepotnamesmodel infoPopupdetailPieChart uk-card uk-card-body uk-card-default uk-drop uk-drop-bottom-right" data-potid='1' id="infoPopupdetailPieChart_1">
												
											</div>
											<input class="investmentcashflownamepotnames" type="hidden" value="1">
										</td>
										<td class="hidecolmns" hidden>10%</td>
										<td class="hidecolmns" hidden>0%</td>
										<td><a href="javascript:void(0);" uk-icon="trash" class="trashsolutionform_investmentCashFlow" data-CashFlowitem="1" data-rowindexitem="1" onclick="trashsolutionform_investmentCashFlow(this);"></a>
										</td>
										<td class="hidecolmns" hidden></td>
									</tr>
								</tbody>
							</table>
							</div>
							<div class="uk-flex cc_btns">
								<button type="button" class="uk-button uk-button-default uk-margin-small-top uk-border-pill uk-text-capitalize addinvestmentcashflowrow" aria-expanded="false" data-CashFlowitem="1">Add cashflow</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</li> -->

	</ul>
	<div class="uk-flex uk-flex-wrap uk-flex-between uk-margin-small-top">
		<button type="button" class="addnewinvestomentgrid uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-capitalize" >Add investment pot</button>
		<button type="button" data-formtype="investmentinfo" class="uk-button uk-button-default uk-border-pill uk-text-uppercase white_btn discmisssolutionformpopup" aria-expanded="false" onclick="ClickcollectionAllTypeOfData();">Close</button>
	</div>
</fieldset>