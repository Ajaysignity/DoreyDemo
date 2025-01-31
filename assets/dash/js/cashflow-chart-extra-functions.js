var MyAPIChartVars = {};
var BindChart =0;

function loadcashflowAPIdata(objectParams, params, datalist) {
    objectParams = JSON.parse(objectParams);
    let cashFlowObject = objectParams[0];
        params.splice(50, 1);
        params.splice(50, 1);
        params.splice(60, 1);
        params.splice(60, 1);

    let AssetCollectionObject = JSON.parse(params[63]);
    let AssetClassMix = AssetCollectionObject.AssetClassMix;
    let AssetInfo = AssetCollectionObject.AssetInfo;

    console.log('cashFlowObject=>');
    console.log(cashFlowObject);
    console.log("graph api params:: ", params);
    let ModelHigh = [];
    let ModelMid = [];
    let ModelLow = [];
    let SecurityLine = [];
    var XTickLabel = [];    
    let YTickLabel = [];
    let sclrSolve = [];
    let ProbabilitySolve = [];
    let FlowChartData = [];
    let TimeSelection = [document.querySelector('input[name="RadioTime"]:checked').value];
    var params = { "nargout": 1, "rhs": params };
    jQuery("#finacial-loader") .show();
    jQuery(".cashflowoutputsection").addClass('uk-hidden');
    jQuery.ajax({
        url: base_url + controller + '/request-graphparameters-json',
        data: { parameters: JSON.stringify(params) },
        method: 'POST',
        dataType: 'json',
        success: function(result) {
            jQuery("#finacial-loader").hide();
            if ('lhs' in result) {
                document.getElementById("graphapierror").innerHTML = "";
                sclrPot = 1;
                vecETL = result.lhs[0].mwdata.vecETL[0].mwdata;
                vecETLProb = result.lhs[0].mwdata.vecETLProb[0].mwdata;
                vecTotalProbabilityLoss = (result.lhs[0].mwdata.vecPotProbabilityShortfall[0].mwdata);
                vecTotalAmountExpectedLoss = (result.lhs[0].mwdata.vecTotalExpectedShortfall[0].mwdata);

                for (iPot = 0; iPot < cashFlowObject.PotOptions.length; iPot++) {
                    try {
                        sclrSolve[iPot] = result.lhs[0].mwdata.Pot[0].mwdata.FullOutput[iPot].mwdata.sclrSolveInput[0].mwdata[0];
                    } catch {
                        sclrSolve[iPot] = 0;
                    }
                    try {
                        ModelHigh[iPot] = result.lhs[0].mwdata.Pot[0].mwdata.FullOutput[iPot].mwdata.ModelHigh[0].mwdata;
                        ModelMid[iPot] = result.lhs[0].mwdata.Pot[0].mwdata.FullOutput[iPot].mwdata.ModelMid[0].mwdata;
                        ModelLow[iPot] = result.lhs[0].mwdata.Pot[0].mwdata.FullOutput[iPot].mwdata.ModelLow[0].mwdata;
                        SecurityLine[iPot] = result.lhs[0].mwdata.Pot[0].mwdata.FullOutput[iPot].mwdata.SecurityLine[0].mwdata;
                        ProbabilitySolve[iPot] = result.lhs[0].mwdata.Pot[0].mwdata.FullOutput[iPot].mwdata.sclrSolvePrctile[0].mwdata
                        XTickLabel[iPot] = result.lhs[0].mwdata.Pot[0].mwdata.FullOutput[iPot].mwdata.XTickLabel[0].mwdata;
                        YTickLabel[iPot] = result.lhs[0].mwdata.Pot[0].mwdata.FullOutput[iPot].mwdata.YTickLabel[0].mwdata;
                        FlowChartData[iPot] = JSON.parse(JSON.stringify(result.lhs[0].mwdata.Pot[0].mwdata.FullOutput[iPot].mwdata.Flows[0].mwdata));
                        FlowChartData.XData = XTickLabel;
                    } catch {
                        ModelHigh[iPot] = 0;
                        ModelMid[iPot] = 0;
                        ModelLow[iPot] = 0;
                        XTickLabel[iPot] = 0;
                        YTickLabel[iPot] = 0;
                        SecurityLine[iPot] = 0;
                        ProbabilitySolve[iPot] = 0;
                    };
                }
                isAsynchronousExecuted = true;
                sclrSolveInput = result.lhs[0].mwdata.sclrSolveInput[0].mwdata[0];
                sclrSolveAmount = result.lhs[0].mwdata.sclrSolveAmount[0].mwdata[0];

                if (sclrSolveInput != 0) {
                    if (Math.round(sclrSolveAmount) == 4.90041187e+08) {
                        strValue = "Unsolvable-Check Inputs";
                    } else {
                        if (vecInputSymbol[sclrSolveInput - 1] == 0) {
                            strValue = "£" + String(Math.round(sclrSolveAmount).toLocaleString('en'));
                        } else {
                            strValue = String(sclrSolveAmount.toLocaleString('en')) + "%";
                        }
                    };
                    //jQuery('.investmentcashflowrowTable').find('tr[row-index=' + +(sclrSolveInput - 1) + '] :input:first').val(strValue);
                }
                
                
                LiveChart = jQuery('.PotToViewDropDown select option:selected').val();
                if (LiveChart == 'totalassets') {
                    LiveChart = jQuery('.PotToViewDropDown select option').length;
                }

                try {
                    var XTickLabelArray = convertJSON2char(XTickLabel[LiveChart - 1], TimeSelection);
                } catch (error) {
                    XTickLabelArray = convertJSON2char(XTickLabel[LiveChart - 2], TimeSelection);
                };

                sclrUseThisForLabels = 0;
                for (iRow = 1; iRow < XTickLabel.length; iRow++) {
                    if (XTickLabel[iRow] != 0) {
                        sclrUseThisForLabels = iRow;
                    }
                }

                var XTickLabelArray0 = convertJSON2char(XTickLabel[sclrUseThisForLabels]);
                //alert(LiveChart + '====' + cashFlowObject.PotOptions.length);
                if (LiveChart <= cashFlowObject.PotOptions.length) {
                    //alert('single pot chart');
                    setChartData(XTickLabelArray, ModelLow, ModelMid, ModelHigh, SecurityLine, cashFlowObject.LiveColourOptions, cashFlowObject.PotOptions, LiveChart, sclrSolve, ProbabilitySolve, TimeSelection, cashFlowObject.RealNominalSelection);
                } else {
                    // alert('Total pot chart');
                    plotAssetValues(XTickLabelArray0, ModelLow, ModelMid, ModelHigh, SecurityLine, cashFlowObject.LiveColourOptions, cashFlowObject.PotOptions, LiveChart, sclrSolve, ProbabilitySolve, cashFlowObject.RealNominalSelection);
                }
                ChangeChartProjectionTypeToShow(window.ChartTypeToShow);

                /* start Export these variables */
                MyAPIChartVars.XTickLabel = XTickLabel;
                MyAPIChartVars.XTickLabelArray = XTickLabelArray;
                MyAPIChartVars.FlowChartData = FlowChartData;
                MyAPIChartVars.TimeSelection = TimeSelection;
                MyAPIChartVars.RealNominalSelection = cashFlowObject.RealNominalSelection;
                MyAPIChartVars.InputLabel = cashFlowObject.InputLabel;
                MyAPIChartVars.TypePot = cashFlowObject.TypePot;
                MyAPIChartVars.LiveColourOptions = cashFlowObject.LiveColourOptions;
                /* End Export these variables */

                sclrShowSolve = sclrSolve[LiveChart - 1];  
              
                bindPieChart(cashFlowObject, datalist, vecETL, vecETLProb, AssetClassMix, AssetInfo);          

            } else {
                UIkit.notification({ message: result.error.message, pos: 'top-center', status: 'warning', timeout: 1800 });
            }
        }
    });
}

function bindPieChart(cashFlowObject, datalist, vecETL, vecETLProb, AssetClassMix, AssetInfo){
    console.log("cashFlowObject BindPiechart::: ", cashFlowObject);
    for (iControl = 0; iControl < cashFlowObject.GlobalNCashFlowBars; ++iControl) {
        let iControlCodeVal = iControl + parseInt(1);
        ActivePiePopUp = jQuery('#infoPopupdetailPieChart_' + iControlCodeVal);
        if (ActivePiePopUp !== null) {
            sclrShortfall = Math.round(vecETL[iControl]);
            if (isNaN(sclrShortfall)) { sclrShortfall = 0; }
            sclrShortfall = (sclrShortfall.toLocaleString('en', { maximumSignificantDigits: 3 }))
            sclrProbability = Math.round(vecETLProb[iControl] * 1000) / 10;
            if (isNaN(sclrProbability)) { sclrProbability = 0 };

            vecLiveAssetMix = [];
            AssetClassName = [];

           // vecLiveAssetMix = [0.055, 0.0875, 0.2, 0.075, 0.07, 0.2775, 0.065, 0, 0.0125, 0.0225, 0.135];
            SelectedPotnumber = jQuery('#infoPopupdetailPieChart_' + iControlCodeVal).attr('data-potid');

            sclrPotSelected = SelectedPotnumber - parseInt(1);
            sclrPotAssetAllocation = cashFlowObject.TypeOverallStrategy[sclrPotSelected][0];

            txtPotName = jQuery('.solutionform_investomentgrid_table_' + SelectedPotnumber).find('tr[row-index=' + iControlCodeVal + '] :input:first').val();

            txtAssetValue = datalist.assetselection2[sclrPotAssetAllocation];
            //AssetClassName = ['Cash', 'Sovereign Debt', 'Investment Grade', 'High Yield', 'Index Linked', 'DW Equity', 'EM Equity', 'Property', 'Resources', 'Gold', 'Alternatives'];
            CurrencyIndicator = jQuery('.curentcurrencysetting').val();

          
            for (iAsset=0;iAsset<AssetClassMix[sclrPotAssetAllocation].length;iAsset++){
				vecLiveAssetMix.push(AssetClassMix[sclrPotAssetAllocation][iAsset]); //datasets value
                AssetClassName.push( AssetInfo[iAsset].Name ); //labels name
			}

            piedata = {
                labels: AssetClassName,
                //labels: AssetClassMixName,
                datasets: [{
                    label: 'Asset Allocation:' + txtAssetValue,
                    data: vecLiveAssetMix,
                    backgroundColor: vecAssetBackgroundColour,
                    //backgroundColor: '#000000',
                }]
            };
            let LEDColorSection = jQuery('.solutionform_investomentgrid_table_' + SelectedPotnumber).find('tr[row-index=' + iControlCodeVal + ']').find('.defaultcolor-area');

            let idInflowOutflow = jQuery('.solutionform_investomentgrid_table_' + SelectedPotnumber).find('tr[row-index=' + iControlCodeVal + ']').find('.CashflowAllarrinoutflow').val();
            if (idInflowOutflow == 1) {
                if (sclrProbability > 55) {
                    LEDColorSection.css('background', '#F00');
                } else if (sclrProbability > 20) {
                    LEDColorSection.css('background', '#FF0');
                } else {
                    LEDColorSection.css('background', '#ABFF00');
                }
            } else {
                LEDColorSection.css('background', '#39f');
            }
            ActivePiePopUp.html(" <button class='uk-modal-close-default uk-drop-close' type='button' aria-label='Close' uk-close></button> <div class = 'PotHeaderRow'> Cashflow: " + txtPotName + " </div> <br>Shortfall  " + CurrencyIndicator + ": " + sclrShortfall + "in nominal terms.<br>P(Shortfall): " + sclrProbability + "%<br>Chance of running out of money, so cannot payout cashflow in full." + " <br><br><div class = 'PotHeaderRow'> Starting Asset Allocation of Pot <br>" + txtAssetValue + "</div><canvas class='myChartPopPie"+iControl+"' id='myChartPopPie" + iControl + "' width='800' height='1200'></canvas>");

            const ctxpiechart = document.getElementById('myChartPopPie' + iControl);
            var myChartPopPie = new Chart( ctxpiechart , {
                type: 'pie',
                data: piedata
            });        
            myChartPopPie.render();
        }
    }
}
function convertJSON2char(XTickLabel, TimeSelection) {

    TimeSelection = [document.querySelector('input[name="RadioTime"]:checked').value];
    var dt = new Date();
    sclrYearToday = dt.getYear() + 1900;
    switch (String(TimeSelection)) {
        case "Age":
            sclrBaseYear = Number(document.getElementById("Age_value").value) - sclrYearToday;
            break;
        case "CalendarYears":
            sclrBaseYear = 0;
            break;
        case "Time":
            sclrBaseYear = -sclrYearToday;
            break;
    }
    var myArray = ["", ""];
    var i;
    for (i = 0; i < XTickLabel.length; i++) {
        myArray[i] = Number(XTickLabel[i].mwdata) + sclrBaseYear;
    }
    return myArray;
}

function cashflowoutputsection_output() {
    jQuery(".cashflowoutputsection").removeClass('uk-hidden');
}

function setChartData(varLabels, varLow, varMed, varHigh, varSecurityLine, hexColour, txtTitleForChart, LiveChart, sclrSolve, ProbabilitySolve, xChartLabel, RealNominalSelection) {

    txtTitle = setChartTitle(txtTitleForChart, LiveChart, RealNominalSelection);
    if (LiveChart < (txtTitleForChart.length + 1)) {
        varLow = varLow[LiveChart - 1];
        varMed = varMed[LiveChart - 1];
        varHigh = varHigh[LiveChart - 1];

        sclrShowSolve = sclrSolve[LiveChart - 1];
        varSecurityLine = varSecurityLine[LiveChart - 1];
        hexColourTemp = hexColour[LiveChart - 1];
    }

    vecRGB = hexToRgb(hexColourTemp);

    sclrMinColour = Math.min(vecRGB.r, vecRGB.g, vecRGB.b);
    if (sclrMinColour < 210) {
        txtCentralBackgroundColor = "rgba(255,255,255,1)";
    } else {
        txtCentralBackgroundColor = "rgba(44, 92, 163,1)";
    };
    if (sclrMinColour > 250) {
        hexColourTemp = '#5d45a1';
        vecRGB = hexToRgb(hexColourTemp);
    };
    if (sclrShowSolve != 0) {
        txtGoalSeek = 'Goal confidence:' + (100 - ProbabilitySolve[LiveChart - 1]) + '%';
        vecDataSecurity = varSecurityLine;
        tfGoalSeekHidden = false;
        tfGoalSeekShow = true;
        txtBorderColour = "rgba(" + [150] + "," + [50] + "," + [50] + "," + "1)";
    } else {
        txtGoalSeek = [];
        vecDataSecurity = [];
        tfGoalSeekHidden = true;
        tfGoalSeekShow = false;
        txtBorderColour = [];
    }
    let SoluionChartSection = document.getElementById('soluionchartsection').getContext('2d');
    //alert('sclrSolveInput=' + sclrSolveInput + '=GoalSeekPotValue=' + GoalSeekPotValue + '=GoalSeekTime=' + GoalSeekTime + '=GoalSeekPercentile=' + GoalSeekPercentile + '=GoalSeekRealNominal=' + GoalSeekRealNominal);

    data = {
        labels: varLabels,
        datasets: [{
            label: 'Low: 90th percentile step1',
            data: (varLow),
            pointRadius: '0',
            backgroundColor: "rgba(" + vecRGB.r + "," + vecRGB.g + "," + vecRGB.b + "," + "0.9)",
            borderColor: "rgba(" + vecRGB.r + "," + vecRGB.g + "," + vecRGB.b + "," + "1.0)",
            fill: '1',
            order: 3,
        }, {
            label: 'Medium: 50th percentile',
            data: varMed,
            borderWidth: '5',
            backgroundColor: txtCentralBackgroundColor,
            borderColor: txtCentralBackgroundColor,
            pointRadius: '0',
            fill: false,
            order: 2,
        }, {
            label: 'High: 25th percentile',
            data: varHigh,
            backgroundColor: "rgba(" + vecRGB.r + "," + vecRGB.g + "," + vecRGB.b + "," + "0.9)",
            borderColor: "rgba(" + vecRGB.r + "," + vecRGB.g + "," + vecRGB.b + "," + "1.0)",
            pointRadius: '0',
            fill: '1',
            order: 1
        }]
    };

    if (sclrShowSolve != 0) {
        let goalseekdottedlines = {
            label: txtGoalSeek,
            data: vecDataSecurity,
            backgroundColor: "rgba(" + vecRGB.r + "," + vecRGB.g + "," + vecRGB.b + "," + "1)",
            borderColor: "rgba(" + 255 + "," + 50 + "," + 50 + "," + "1.0)",
            borderDash: [5, 5],
            pointRadius: '0',
            order: 0,
            fill: false
        };
        data.datasets = [goalseekdottedlines].concat(data.datasets);
    }
    if (GlobalVarChartCreated == 0) {
        var myChart = new Chart(SoluionChartSection, {
            type: 'line',
            labels: varLabels,
            data: data,
            options: {
                defaultFontSize: '18',
                lineTension: 0,
                title: {
                    display: true,
                    text: 'Accumulation for fund: ' + txtTitle,
                    fontFamily: 'Santral-Book, sans-serif',
                    fontStyle: 'normal',
                    fontSize: '15'
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: xChartLabel,
                            fontSize: 16,
                            fontFamily: "'Santral-Book', sans-serif"
                        },
                        ticks: {
                            fontSize: 13,
                            fontFamily: "'Santral-Book', sans-serif",
                            fontColor: '#000'
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            callback: function(value, index, values) {
                                return value.toLocaleString("en-UK", { style: "currency", currency: "GBP" }).slice(0, -3);
                            },
                            fontSize: 14,
                            fontFamily: "'Santral-Book', sans-serif",
                            fontColor: '#000'
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        beforeTitle: function(tooltipItems, data) {
                            return;
                        },
                        title: function(tooltipItems, data) {
                            return;
                        },
                        label: function(tooltipItems, data) {
                            return xChartLabel + ' : ' + tooltipItems.xLabel;
                        },
                        footer: function(tooltipItems, data) {
                            var sum = 0;
                            tooltipItems.forEach(function(tooltipItem) {
                                n1 = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                str1 = "£";
                                n1 = Number(n1.toPrecision(3));
                                str2 = str1.concat(n1.toLocaleString(undefined, { maximumFractionDigits: 0 }));
                            });
                            return 'Value: ' + str2;
                        },
                    },
                    bodyFontStyle: 'normal',
                    bodyFontFamily: 'Santral-Book, sans-serif',
                    footerFontStyle: 'normal',
                    footerFontFamily: 'Santral-Book, sans-serif'
                }
            }
        });
        GlobalVarChartCreated = 1;
        GlobalVarChartHandle = myChart;
        defaultChartOptions = {...myChart.options };
        defaultChartData = {...myChart.data };
    } else {
        GlobalVarChartHandle.data = {...defaultChartData };
        GlobalVarChartHandle.options = {...defaultChartOptions };
        GlobalVarChartHandle.data = data;

        GlobalVarChartHandle.options.scales.xAxes[0].scaleLabel.labelString = xChartLabel;
        GlobalVarChartHandle.options.scales.xAxes[0].scaleLabel.fontSize = 14;

        GlobalVarChartHandle.options.title.text = 'Accumulation for fund: ' + txtTitle;

        GlobalVarChartHandle.options.defaultFontFamily = 'Santral-Book, sans-serif';
        GlobalVarChartHandle.tooltip._chart.config.options.defaultFontFamily = 'Santral-Book, sans-serif';
        GlobalVarChartHandle.options.legend.labels.fontFamily = 'Santral-Book, sans-serif';
        GlobalVarChartHandle.update();

    }
}

function setChartTitle(txtTitleForChart, LiveChart, RealNominalSelection) {
    txtTitle = '';
    txtTitle = txtTitleForChart[LiveChart - 1];
    if (RealNominalSelection.localeCompare('Real') == 0) {
        txtTitle = [txtTitle + "; Real, inflation at 5y:" + (Math.round(window.Inflation * 10000) / 100).toFixed(2) + "%; 6y+:" + (Math.round(window.InflationLongTerm * 10000) / 100).toFixed(2) + "%"];
    } else {
        txtTitle = [txtTitle + "; Nominal"];
    }
    var assumptionName = jQuery('.apiassumptionlists select.assumption_name_select').find("option:selected").text(); //get selected assumption name
    txtTitle = [txtTitle + "; Investment basis : "+ assumptionName];
    return txtTitle;
}

function hexToRgb(hex) {
    hex = hex.slice(0, 7);
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function getFlowBar_BorderWidthFactor(XAxis_length) {
    XTickLabelArray = MyAPIChartVars.XTickLabelArray;
    if (XTickLabelArray.length > 80) {
        factor = 210;
    } else if (XTickLabelArray.length > 70) {
        factor = 185;
    } else if (XTickLabelArray.length > 60) {
        factor = 165;
    } else if (XTickLabelArray.length > 50) {
        factor = 155;
    } else if (XTickLabelArray.length > 40) {
        factor = 140;
    } else if (XTickLabelArray.length > 30) {
        factor = 120;
    } else if (XTickLabelArray.length > 25) {
        factor = 100;
    } else if (XTickLabelArray.length > 20) {
        factor = 80;
    } else if (XTickLabelArray.length > 15) {
        factor = 70;
    } else if (XTickLabelArray.length > 10) {
        factor = 50;
    } else if (XTickLabelArray.length > 8) {
        factor = 40;
    } else if (XTickLabelArray.length > 5) {
        factor = 30;
    } else { // note minimum chart length is 5 anyway.
        factor = 12;
    }
    return (factor / XAxis_length);
}

function sumArray(a, b) {
    var c = [];
    for (var i = 0; i < Math.max(a.length, b.length); i++) {
        c.push((a[i] || 0) + (b[i] || 0));
    }
    return c;
}

function convertHex(hexCode, opacity = 1) {
    var hex = hexCode.replace('#', '');
    if (hex.length === 3) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
    var r = parseInt(hex.substring(0, 2), 16),
        g = parseInt(hex.substring(2, 4), 16),
        b = parseInt(hex.substring(4, 6), 16);
    if (opacity > 1 && opacity <= 100) {
        opacity = opacity / 100;
    }
    return 'rgba(' + r + ',' + g + ',' + b + ',' + opacity + ')';
}
jQuery(document).on('change', '.chartprojectiontypedropdown select', function() {
    let ChartTypeToShow = jQuery(this).val();
    if (ChartTypeToShow == 1) {
        jQuery('.solutionbar_graph').removeClass('uk-hidden');
        jQuery('.solutionline_graph').addClass('uk-hidden');
    } else {
        jQuery('.solutionbar_graph').addClass('uk-hidden');
        jQuery('.solutionline_graph').removeClass('uk-hidden');
    }
});

function createFlowsChart(FlowType) {
    FlowType = jQuery('.InflowsChartButtonClass:checked').val();
    let boolFlowTypeToUse;
    if (jQuery('.PotToViewDropDown select option:selected').index() == jQuery('.PotToViewDropDown select option').length - 1) {
        StartPot = 0;
        EndPot = jQuery('.PotToViewDropDown select option').length - 2;
    } else {
        StartPot = jQuery('.PotToViewDropDown select option:selected').index();
        EndPot = StartPot;
    }
    if (FlowType == "inflow") {
        boolFlowTypeToUse = true;
    } else if (FlowType == "outflow") {
        boolFlowTypeToUse = false;
    }
    XTickLabel = MyAPIChartVars.XTickLabel;
    FlowChartData = MyAPIChartVars.FlowChartData;
    xChartLabel = MyAPIChartVars.TimeSelection;
    CashFlowInputLabel = MyAPIChartVars.InputLabel;
    //CashFlowTypePot = MyAPIChartVars.TypePot;
    CashFlowLiveColourOptions = MyAPIChartVars.LiveColourOptions;

    XTickLabelArray = convertJSON2char(XTickLabel[0]);
    XTickLabelArray.pop();
    var DATA = {
        labels: XTickLabelArray,
        datasets: []
    };
    rawCashflowBlock = {
        label: [],
        data: [],
        backgroundColor: [],
    }
    const repeatFn = (arr, n) => Array(n).fill(arr).flat();
    var YData_TotalFlows = new Array(XTickLabelArray.length).fill(0);
    var YData = [];
    var CashflowNames = [];
    jj = -1;
    kk = -1;


    for (iiPot = StartPot; iiPot <= EndPot; iiPot++) {
        if (FlowChartData[iiPot] != undefined) {
            thisPotsCashflow_InputLabel = [];
            uu = FlowChartData[iiPot].Struct[0].mwdata.Cashflow.length;
            
            CashFlowTypePot = MyAPIChartVars.TypePot.replace('[', '').replace(']', '').split(',');
            console.log(uu + '==second=>' + CashFlowTypePot.length);
            for (ii = 0; ii < CashFlowTypePot.length; ii++) {
                if (CashFlowTypePot[ii] == String(iiPot)) {
                    uu = uu - 1;
                    //thisPotsCashflow_InputLabel[uu] = $SessionVariablesCF.InputLabel[ii];
                    thisPotsCashflow_InputLabel[uu] = CashFlowInputLabel[ii];
                    console.log(CashFlowInputLabel[ii] + '=====ii===>uu<=' + uu + '====' + ii);
                }
            }
            // console.log(thisPotsCashflow_InputLabel);
            for (ii = FlowChartData[iiPot].Struct[0].mwdata.Cashflow.length - 1; ii >= 0; ii--) {
                kk = kk + 1;
                if (FlowType == "allcashflows") {
                    boolDisplayCashflow = true;
                } else {
                    boolDisplayCashflow = FlowChartData[iiPot].Struct[0].mwdata.IsInflow[ii].mwdata[0] == boolFlowTypeToUse;
                }
                if (FlowChartData[iiPot].Struct[0].mwdata.HideThisFlow[ii].mwdata[0] == true) {
                    boolDisplayCashflow = false;
                }
                if (boolDisplayCashflow) {
                    jj = jj + 1;
                    newDataBlock = JSON.parse(JSON.stringify(rawCashflowBlock));
                    if (FlowChartData[iiPot].Struct[0].mwdata.IsPercentage[ii].mwdata[0] == true || FlowChartData[iiPot].Struct[0].mwdata.IsInflow[ii].mwdata[0] == false) {
                        if (SelecedPercentileFlowChart_Index == 0) {
                            YDataPre = FlowChartData[iiPot].Struct[0].mwdata.Cashflow[ii].mwdata;
                        } else {
                            if (FlowChartData[iiPot].Struct[0].mwdata.CashflowRange[ii].mwdata.length == 0) {
                                YDataPre = Array(XTickLabelArray.length).fill(0);
                            } else {
                                YDataPre = FlowChartData[iiPot].Struct[0].mwdata.CashflowRange[ii].mwdata.values[SelecedPercentileFlowChart_Index - 1].mwdata;
                            }
                        }
                    } else {
                        YDataPre = FlowChartData[iiPot].Struct[0].mwdata.Cashflow[ii].mwdata;
                    }
                    if (FlowType == "outflow") {
                        YData[jj] = YDataPre.map(value => -value);
                    } else {
                        YData[jj] = YDataPre;
                    }
                    CashflowNames[jj] = thisPotsCashflow_InputLabel[ii] + "- " + FlowChartData[iiPot].Struct[0].mwdata.CashflowName[ii].mwdata[0].mwdata[0].replace(/[0-9]/g, '');

                    newDataBlock.data = YData[jj];
                    newDataBlock.label = CashflowNames[jj];
                    newDataBlock.borderColor = CashFlowLiveColourOptions[iiPot];
                    newDataBlock.borderWidth = getFlowBar_BorderWidthFactor(XTickLabelArray.length);

                    newDataBlock.backgroundColor = repeatFn(convertHex(ColourBlock[kk], 0.31), YData[jj].length);

                    DATA.datasets[jj] = JSON.parse(JSON.stringify(newDataBlock));

                    YData_TotalFlows = sumArray(YData_TotalFlows, YData[jj]);
                }
            }
        } else {}
    }
    if (boolShowOverallFlows == 0) {
        newDataBlock = JSON.parse(JSON.stringify(rawCashflowBlock));
        newDataBlock.data = YData_TotalFlows;
        newDataBlock.label = "Overall Cashflows";
        newDataBlock.type = 'line';
        newDataBlock.fill = 'false';
        newDataBlock.lineTension = 0.2;
        newDataBlock.borderColor = 'rgba(0,0,0,0.2)';
        DATA.datasets[jj + 1] = JSON.parse(JSON.stringify(newDataBlock));
    };
    const config = {
        type: 'bar',
        data: DATA,
        options: {
            scales: {
                xAxes: [{
                    stacked: true,
                    scaleLabel: {
                        display: true,
                        labelString: xChartLabel,
                        fontSize: 16,
                        fontFamily: "'Santral-Book', sans-serif"
                    },
                    ticks: {
                        fontSize: 13,
                        fontFamily: "'Santral-Book', sans-serif",
                        fontColor: '#000'
                    }
                }],
                yAxes: [{
                    stacked: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return value.toLocaleString("en-UK", { style: "currency", currency: "GBP" }).slice(0, -3);
                        },
                        fontSize: 14,
                        fontFamily: "'Santral-Book', sans-serif",
                        fontColor: '#000'
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    beforeTitle: function(tooltipItems, data) {
                        return;
                    },
                    title: function(tooltipItems, data) {
                        tooltipItems.forEach(function(tooltipItem) {
                            str1 = data.datasets[tooltipItem.datasetIndex].label;
                        });
                        return str1;
                    },
                    label: function(tooltipItems, data) {
                        return xChartLabel + ' : ' + tooltipItems.xLabel;
                    },
                    footer: function(tooltipItems, data) {
                        var sum = 0;
                        tooltipItems.forEach(function(tooltipItem) {
                            n1 = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            str1 = "£";
                            n1 = Number(n1.toPrecision(3));
                            str2 = str1.concat(n1.toLocaleString(undefined, { maximumFractionDigits: 0 }));
                        });
                        return 'Value: ' + str2;
                    }
                }
            }
        }
    };
    //const stackedBar = new Chart(soluionchartsection_bar, config);
    if (window.MyChartBar != undefined) {
        window.MyChartBar.destroy();
    }
    window.MyChartBar = new Chart(soluionchartsection_bar, config);

}



function plotAssetValues(varLabels, varLow, varMed, varHigh, varSecurityLine, hexColour, txtTitleForChart, LiveChart, sclrSolve, ProbabilitySolve, RealNominalSelection) {
    xChartLabel = MyAPIChartVars.TimeSelection;
    if (GlobalVarChartCreated == 0) {
        setChartData(varLabels, varLow, varMed, varHigh, varSecurityLine, hexColour, txtTitleForChart, 0, sclrSolve, ProbabilitySolve, RealNominalSelection);
    } else {
        if (LiveChart < (txtTitleForChart.length + 1)) {
            hexColourTemp = hexColour[LiveChart - 1];
        }
        vecRGB = hexToRgb(hexColourTemp);

        data = buildDefaultDataObject(vecRGB);
        GlobalVarChartHandle.data.datasets = data.data.datasets;
        sclrMinColour = Math.min(vecRGB.r, vecRGB.g, vecRGB.b);
        sclrMaxDataLength = 0;
        for (iRow = 0; iRow < (LiveChart - 1); iRow++) {
            if (varMed[iRow] == 0) {
                sclrLen = 0
            } else {
                sclrLen = varMed[iRow].length;
            }
            sclrMaxDataLength = Math.max(sclrLen, sclrMaxDataLength);
        }
        //alert(LiveChart + "==(LiveChart-1)==>" + (LiveChart - 1));
        for (iRow = 0; iRow < (LiveChart - 1); iRow++) {

            if (iRow > 0) {
                GlobalVarChartHandle.data.datasets[iRow] = {...GlobalVarChartHandle.data.datasets[0] };
                GlobalVarChartHandle.data.datasets[iRow].data = AddTogether(varMed[iRow], GlobalVarChartHandle.data.datasets[iRow - 1].data);
                GlobalVarChartHandle.data.datasets[iRow].fill = '-1';
            } else {
                if (varMed[iRow] == 0) {
                    varData = [];
                    for (iRowSet = 0; iRowSet < sclrMaxDataLength; iRowSet++) {
                        varData.push(0);
                    }
                    GlobalVarChartHandle.data.datasets[iRow].data = varData;
                } else {
                    GlobalVarChartHandle.data.datasets[iRow].data = varMed[iRow];
                }
            }
            var PotOptions = txtTitleForChart;
            vecRGB = hexToRgb(hexColour[iRow]);
            GlobalVarChartHandle.data.datasets[iRow].backgroundColor = "rgba(" + vecRGB.r + "," + vecRGB.g + "," + vecRGB.b + "," + "0.9)";
            GlobalVarChartHandle.data.datasets[iRow].borderColor = "rgba(" + vecRGB.r + "," + vecRGB.g + "," + vecRGB.b + "," + "1)";
            GlobalVarChartHandle.data.datasets[iRow].label = PotOptions[iRow];


        }
        GlobalVarChartHandle.data.labels = varLabels;
        GlobalVarChartHandle.options.scales.xAxes[0].scaleLabel.labelString = xChartLabel;
        GlobalVarChartHandle.options.scales.xAxes[0].scaleLabel.fontSize = 14;
        GlobalVarChartHandle.options.title.text = setChartTitleTotal();
        GlobalVarChartHandle.options.scales.yAxes[0].beginAtZero = true;
        GlobalVarChartHandle.update();

    }
}

function AddTogether(vecA, vecB) {
    var result = [];
    var sclrLength = 0;
    if (vecA == 0) {
        sclrLengthA = 0;
    } else {
        sclrLengthA = vecA.length;
    }
    if (vecB == 0) {
        sclrLengthB = 0;
    } else {
        sclrLengthB = vecB.length;
    }
    sclrMaxLength = Math.max(sclrLengthA, sclrLengthB);
    if (sclrLengthA == 0) {
        vecA = [];
        for (var i = 0; i < sclrMaxLength; i++) {
            vecA.push(0);
        }
    }
    if (sclrLengthB == 0) {
        vecB = [];
        for (var i = 0; i < sclrMaxLength; i++) {
            vecB.push(0);
        }
    }
    for (var i = 0; i < sclrMaxLength; i++) {
        result.push(vecA[i] + vecB[i]);
    }
    return result;
}

function setChartTitleTotal() {
    RealNominalSelection = MyAPIChartVars.RealNominalSelection;
    txtTitle = '';
    if (RealNominalSelection.localeCompare('Real') == 0) {
        txtTitle = [txtTitle + "; Real, inflation at 5y:" + (Math.round(window.Inflation * 10000) / 100).toFixed(2) + "%; 6y+:" + (Math.round(window.InflationLongTerm * 10000) / 100).toFixed(2) + "%"];
    } else {
        txtTitle = [txtTitle + "; Nominal"];
    }
    txtTitle = 'Accumulation: Total' + txtTitle;

    return txtTitle;
}

function buildDefaultDataObject(vecRGB) {
    xChartLabel = MyAPIChartVars.TimeSelection;
    objDefault = {
        type: 'line',
        data: {
            labels: 'Asset value-test',
            datasets: [{
                label: 'Asset 1',
                data: [0, 0, 0, 0, 0, 0],
                pointRadius: '0',
                backgroundColor: "rgba(" + vecRGB.r + "," + vecRGB.g + "," + vecRGB.b + "," + "0.9)",
                borderColor: "rgba(" + vecRGB.r + "," + vecRGB.g + "," + vecRGB.b + "," + "1.0)",
                fill: 'origin'
            }]
        },
        options: {
            defaultFontSize: '18',
            lineTension: 0,
            title: {
                display: true,
                text: "Asset value in today's terms"
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: xChartLabel,
                        fontSize: '16'
                    }
                }],
                yAxes: [{
                    ticks: {
                        callback: function(value, index, values) {
                            return value.toLocaleString("en-UK", { style: "currency", currency: "GBP" }).slice(0, -3);
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    beforeTitle: function(tooltipItems, data) {
                        return;
                    },
                    title: function(tooltipItems, data) {
                        return;
                    },
                    label: function(tooltipItems, data) {
                        return xChartLabel + ' : ' + tooltipItems.xLabel;
                    },
                    footer: function(tooltipItems, data) {
                        var sum = 0;
                        tooltipItems.forEach(function(tooltipItem) {
                            n1 = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            str1 = "£";
                            n1 = Number(n1.toPrecision(3));
                            str2 = str1.concat(n1.toLocaleString(undefined, { maximumFractionDigits: 0 }));
                        });
                        return 'Value: ' + str2;
                    },
                },
                footerFontStyle: 'normal'
            }
        }
    }
    return objDefault;
}

function ChangeChartProjectionTypeToShow(selectedIndex_) {
    ChartTypeToShow = selectedIndex_;
    let LastSelectedFlowType = jQuery('.InflowsChartButtonClass:checked').val();
    if (ChartTypeToShow == 1) {
        jQuery(".solutionline_graph").addClass("uk-hidden");
        jQuery(".solutionbar_graph").removeClass("uk-hidden");
        createFlowsChart(LastSelectedFlowType);
        jQuery(".cashflowprojection_sectionarea").removeClass("uk-hidden");

    } else {
        jQuery(".solutionline_graph").removeClass("uk-hidden");
        jQuery(".solutionbar_graph").addClass("uk-hidden");
        jQuery(".cashflowprojection_sectionarea").addClass("uk-hidden");
    }
}

function setRealNominal_OnEditorView(selectedIndex_) {
    if (selectedIndex_ == 0) {
        var RealNominalSelection = 'Real';
        document.getElementById("SelectReal1").checked = true;
    } else { // nominal
        var RealNominalSelection = 'Nominal';
        document.getElementById("SelectReal2").checked = true;
    }
}

function ShowOverallFlowsChart(this_) {
    let LastSelectedFlowType = jQuery('.InflowsChartButtonClass:checked').val();
    boolShowOverallFlows = this_.selectedIndex;
    createFlowsChart(LastSelectedFlowType);
}

function ChoosePercentileFlowsChart(this_) {
    let LastSelectedFlowType = jQuery('.InflowsChartButtonClass:checked').val();
    SelecedPercentileFlowChart_Index = this_.selectedIndex;
    createFlowsChart(LastSelectedFlowType);
}
jQuery(document).ready(function() {
    ClickcollectionAllTypeOfData();
    setHints();
});

function setHints(){
     //get hint value
     var hint = jQuery("input[name='screenhits']:checked").val();
     if(hint == 0){
        jQuery(".solutionformpopup").removeAttr("uk-tooltip").removeAttr("title");
     }else{
        var hint_arr = ["title: Start here- insert client information; pos: right", "title: Add sources of income; pos: right", "title: Set up investment strategy, cashflows and fee structure; pos: right", "title: Solution settings; pos: right", "title: Assumptions; pos: right", "title: Export; pos: right", "title: Adjust cashflow and set pot value to a selected amount at a chosen time, and specified level of security (confidence level).; pos: right"]
        jQuery(".solutionformpopup").each(function(index){
            jQuery(this).attr("uk-tooltip", hint_arr[index]);
        })
     }
}