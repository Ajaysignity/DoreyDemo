function loadDynamicAgeDropdown(potnumber = 1) {
    let Agevalue = CD.find('.solutionbasicinfoform').find('#Age_value').val();
    jQuery.ajax({
        url: base_url + controller + '/get_uptoprojectionage',
        data: { ajax: true, Agevalue: Agevalue },
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            markup = '<tr class="light_grey">'
            markup += '<td>' + response.firstrowcolm + '</td>'
            markup += '<td><select class="uk-select LoadAllreturnpath"></select ></td>'
            markup += '<td><a href="javascript: void(0);" uk-icon="trash" class="trashsolutionform_projectionevent " data-CashFlowitem="1" data-rowindexitem="1" onclick="trashsolutionform_projectionevent(this);"></a></td>'
            markup += '</tr>';

            CD.find('.solutionform_projectioneventgrid_table_' + potnumber).append(markup);
            jQuery.each(response.projectioninfo, function(key, value) {
                CD.find('.LoadAllreturnpath').append(jQuery("<option></option>").attr("value", key).text(value));
            });
            // cloneTableRow.attr('Row-Index', parseInt(RowIndex + 1));
            //cloneTableRow.find('.trashsolutionform_investmentCashFlow').attr('data-RoWIndexitem', parseInt(RowIndex + 1));
        }
    });
}

function trashsolutionform_investmentCashFlow(identifier) {
    let CashFlowitem = jQuery(identifier).attr("data-CashFlowitem");
    let rowindexitem = jQuery(identifier).attr("data-rowindexitem");
    if (jQuery(".solutionform_investomentgrid_table_" + CashFlowitem + " tbody tr ").length > 1) {
        jQuery(".solutionform_investomentgrid_table_" + CashFlowitem + " tbody").find("[Row-Index='" + rowindexitem + "']").remove();
        jQuery('.investmentcashflowrowTable tbody tr').each(function(index) {
            jQuery(this).attr('potcashflowinumber', parseInt(index + 1)).attr('row-index', parseInt(index + 1));
            jQuery(this).find('.investmentcashflownamepotnamesmodel').attr('id', 'infoPopupdetailPieChart_' + parseInt(index + 1));
            jQuery(this).find('a.trashsolutionform_investmentCashFlow').attr('data-rowindexitem', parseInt(index + 1));
        });
    } else {
        UIkit.notification({ message: cantRemoveText, pos: 'bottom-center', status: 'grey', timeout: 1800 });
    }
}

function trashsolutionform_projectionevent(identifier) {
    let CashFlowitem = jQuery(identifier).attr("data-CashFlowitem");
    let rowindexitem = jQuery(identifier).attr("data-rowindexitem");
    jQuery(".solutionform_projectioneventgrid_table_" + CashFlowitem + " tbody").find("[Row-Index='" + rowindexitem + "']").remove();
    ClickcollectionAllTypeOfData('setting_btn');
}


function graphinvestmentpotdropdown(potnumber, method = 'add') {
    let potDiv = jQuery('.PotToViewDropDown');
    let potGeekDiv = jQuery('.solutiongoalseekinfo_potlist');
    if (method == 'remove') {
        potDiv.find("select option[value='" + potnumber + "']").remove();
        potGeekDiv.find("select option[value='" + potnumber + "']").remove();
        //change pot index value same as pots
        var tLen = 1;
        potDiv.find('select option').each(function(poIndex){
            if(tLen != jQuery('ul.commoninvestomentgridform').children('li').length ){
                if(tLen == 1){
                    jQuery(this).attr('option', parseInt(poIndex + 1));
                }else{
                    jQuery(this).attr('value', parseInt(poIndex + 1)).attr('data-invespot', parseInt(poIndex + 1));
                }
            }
            tLen++;   
        })
    } else {
        potDiv.find('select option:last').before('<option value="' + potnumber + '" data-invespot="' + potnumber + '">Investment pot ' + potnumber + '</option>');
        potGeekDiv.find('select option:last').after('<option value="' + potnumber + '" data-invespot="' + potnumber + '">Investment pot ' + potnumber + '</option>');
    }
}

function commonyeardropdowns(Agevalue, projectionage) {
    var dropdown = [];
    var Agevalue = parseInt(Agevalue) + 1;
    var counter = 0;
    for (var inc = Agevalue; inc < projectionage; inc++) {
        dropdown[counter++] = inc;
    }
    return dropdown;
}

function getAgeDropdown(ColsCount){
    let Agevalue = jQuery('.solutionbasicinfoform').find('#Age_value').val();
    let nextAgevalue = parseInt(Agevalue) + parseInt(ColsCount - 1);
    let measureTime ='';
    measureTime = jQuery("input[name='RadioTime']:checked").val();
    var arr = ["Retirement", "Now"];
    arr1=[];
    nextAgevalue = parseInt(Agevalue)+1;
    if(measureTime == 'Age'){
        //for (let inc = parseInt(nextAgevalue); inc < 105; inc++) {
      //  for (let inc = 50; inc < 105; inc++) {
        for (let inc = nextAgevalue; inc < 105; inc++) {
            arr1.push(inc);
         }
     }else if(measureTime == 'CalendarYears'){
         var currentYear = new Date().getFullYear();
        for (let inc = parseInt(currentYear); inc < 2073; inc++) {
            arr1.push(inc);
        }
     }else if( measureTime == 'Time'){
         var timee= 1;
        for (let inc = timee; inc < 50; inc++) {
            arr1.push(inc);
        }
     }
     var arr3 = $.merge( arr, arr1 )
     return arr3;
}

function addInvestmentStrategyColmn(identifier) {
    let CashFlowitem = jQuery(identifier).attr("data-CashFlowitem");
    console.log("addInvestmentStrategyColmn CashFlowitem:: ", CashFlowitem);
    let plus_length = jQuery('.solutionform_InvestmentStrategy_table_'+CashFlowitem+' .plus_symbol').length;
    let Last_value = parseInt(plus_length) +1;

    let Agevalue = jQuery('.solutionbasicinfoform').find('#Age_value').val();
    let Horizon_value = jQuery('.solutionbasicinfoform').find('#Horizon_value').val();
    let colorcodeboxvalue = jQuery('.investomentpotlist_' + CashFlowitem).find('.potcolorcodeboxvalue').val();

    let ColsCount = jQuery(".solutionform_InvestmentStrategy_table_" + CashFlowitem + " tr td").length;

   // let nextAgevalue = parseInt(Agevalue) + parseInt(ColsCount - 1);
    if (ColsCount > DefaultInvestmentStrategyCount) {
        UIkit.notification({ message: cantAddText, pos  : 'bottom-center', status: 'grey', timeout: 1800 });
    } else {
        var measureTime ='';
        measureTime = jQuery("input[name='RadioTime']:checked").val();
        dropdownVal= getAgeDropdown(ColsCount);
       
               
        let nextagedropdown = '<select class="uk-select node_select" id="idDatePicker_'+ColsCount+'" onchange="changeGRIDSelectDates('+ColsCount+', '+CashFlowitem+')">';
        if (ColsCount == 2) {
            var counter = 1;
        } else if (ColsCount == 3) {
            var counter = 2;
        } else if (ColsCount == 4) {
            var counter = 3;
        } else if (ColsCount == 5) {
            var counter = 4;
        }

        //Get last value of node
        let node_length = jQuery('.solutionform_InvestmentStrategy_table_'+CashFlowitem+' .colsIndex'+parseInt(ColsCount - 1) ).find('option:selected').val();
      
        if(node_length > 0){
            Last_value = parseInt(node_length)+1;
        }else{
            Last_value = parseInt(Last_value) +1;
        }

        var LastValue = jQuery("#idDatePicker_"+ColsCount).val();

        var measureTxt ='';
        if(measureTime == 'CalendarYears'){
             measureTxt ='from ';
        }else if(measureTime == 'Time'){
            measureTxt ='In year ';
        }

        for (let inc = 0; inc < dropdownVal.length; inc++) {
            if(Last_value > inc){
                nextagedropdown += '<option value="' + inc + '" hidden="hidden" disabled> ' + dropdownVal[inc] + '</option>';
            }else{
                nextagedropdown += '<option value="' + inc + '">'+measureTxt+ dropdownVal[inc] + '</option>';
            }
        }
		
        nextagedropdown += '</select>';
        jQuery(".solutionform_InvestmentStrategy_table_" + CashFlowitem + " tr").find("th.addothercolsbefore").before('<th class="center_head colsIndex' + ColsCount + '" cols-Index="' + ColsCount + '">' + nextagedropdown + '<a href="javascript: void(0);" uk-icon="minus-circle" class="trashStrategyAddedColumn" data-CashFlowitem="' + CashFlowitem + '" data-rowindexitem="' + ColsCount + '" onclick="trashStrategyAddedColumn(this);"></a></th>');
        let ExpandedColsHtml = jQuery(".solutionform_InvestmentStrategy_table_" + CashFlowitem + " tr .CloneInvestmentStrategyColumn").find('.projectionrating').html();
        console.log("ExpandedColsHtml:: ", ExpandedColsHtml);
        let ExtraExpandedColsHtml = '<div><div class="uk-nav uk-dropdown-nav">'
        ExtraExpandedColsHtml += '<p class="uk-nav-header">Tools</p>';
        ExtraExpandedColsHtml += '<p><a class="RemoveStrategySwitch" data-value="" data-list="1" >Remove Strategy</a></p>';
        ExtraExpandedColsHtml += '<p><a class="UpdateStrategyPath_GlideStatic" data-value="" data-list="1" >Glide</a></p>';
        ExtraExpandedColsHtml += '<p><a class="UpdateStrategyPath_GlideStatic" data-value="" data-list="1" >Static</a></p>';
        ExtraExpandedColsHtml += '</div></div>';
        jQuery('.RatingDropdownTools').attr('hidden', false);
        let expandedTd = '<td class="colsIndex' + ColsCount + ' plus_symbol typeyear_strategycolmn">'
        expandedTd += '<a class="selectedRating" onclick="addhoverclass('+CashFlowitem+','+ColsCount+')" aria-expanded="false" style="background: ' + colorcodeboxvalue + ';"><span uk-icon="plus"></span></a>'
        expandedTd += '<div uk-dropdown="mode: click" class="investmentstrategy_lists">'
        expandedTd += '<div class="uk-dropdown-grid uk-child-width-1-1@m uk-grid uk-grid-stack strategyColmn_' + CashFlowitem + '">'
        expandedTd += ExpandedColsHtml
        expandedTd += ExtraExpandedColsHtml
        expandedTd += '</div>'
        expandedTd += '</div>'
        expandedTd += '</td>';
        jQuery(".solutionform_InvestmentStrategy_table_" + CashFlowitem + " tr").find("td.addothercolsbefore").before(expandedTd);
    }

}



function changeGRIDSelectDates(val, CashFlowitem){
    var total_nodes = jQuery(".solutionform_InvestmentStrategy_table_"+CashFlowitem+" .center_head").length;
 
    for(var index=val; index<5; index++){
        var select_val = jQuery(".solutionform_InvestmentStrategy_table_"+CashFlowitem+" .center_head.colsIndex" + parseInt(index)+" select").val();
        var next_val = jQuery(".center_head.colsIndex" + parseInt(index+1)+" select").val();

        var measureTime ='';
        measureTime = jQuery("input[name='RadioTime']:checked").val();
        var measureTxt ='';
        if(measureTime == 'CalendarYears'){
             measureTxt ='from ';
        }else if(measureTime == 'Time'){
            measureTxt ='In year ';
        }

        if(parseInt(next_val) > 0){ 
            if(parseInt(select_val) > parseInt(next_val) ){ 
                dropdownVal= getAgeDropdown(select_val);
                select_val++;
                var nextagedropdown = '<select class="uk-select node_select" id="idDatePicker_'+parseInt(index +1)+'" onchange="changeGRIDSelectDates('+parseInt(index +1)+', '+CashFlowitem+')">';
                

                for (var inc = 0; inc < dropdownVal.length; inc++) {
                    if(select_val > inc){
                        console.log("Dropdown Last_value:: ", select_val);
                        nextagedropdown += '<option value="' + inc + '" hidden="hidden" disabled> ' + dropdownVal[inc] + '</option>';
                    }else{
                        nextagedropdown += '<option value="' + inc + '"> '+measureTxt + dropdownVal[inc] + '</option>';
                    }
                }
                
                nextagedropdown += '</select>';
                nextagedropdown += '<a href="javascript: void(0);" uk-icon="minus-circle" class="trashStrategyAddedColumn uk-icon" data-cashflowitem="'+CashFlowitem+'" data-rowindexitem="'+parseInt(index + 1)+'" onclick="trashStrategyAddedColumn(this);"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle><line fill="none" stroke="#000" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg></a>';

                jQuery(".solutionform_InvestmentStrategy_table_"+CashFlowitem+" .center_head.colsIndex" + parseInt(index + 1)).html(nextagedropdown);
            }
        }else{
            console.log("Else check next val:: ", next_val);
        }
    }           
}

function trashStrategyAddedColumn(identifier) {
    let CashFlowitem = jQuery(identifier).attr("data-CashFlowitem");
    let rowindexitem = jQuery(identifier).attr("data-rowindexitem");
    let rowindexitemm = jQuery(identifier).parent('th').attr("cols-index");
 
   
    //INDEX INCREMENT IN ALL NODES
    let total_th = jQuery(".solutionform_InvestmentStrategy_table_" + CashFlowitem + " tr th").length;

    if(total_th == rowindexitemm){
        console.log("NOTHING TO DO...");
        //nothing do
    }else{
       jQuery(".solutionform_InvestmentStrategy_table_" + CashFlowitem + " thead tr > .colsIndex" + rowindexitemm).remove(); //remove selected node
       jQuery(".solutionform_InvestmentStrategy_table_" + CashFlowitem + " tbody tr > .colsIndex" + rowindexitemm).remove(); //remove selected node

        var measureTime ='';
        measureTime = jQuery("input[name='RadioTime']:checked").val();
        var measureTxt ='';
        if(measureTime == 'CalendarYears'){
             measureTxt ='from ';
        }else if(measureTime == 'Time'){
            measureTxt ='In year ';
        }

        jQuery(".solutionform_InvestmentStrategy_table_" + CashFlowitem + " thead tr th").each(function(index) {
            if(index != 0 && total_th-1 != parseInt(index+1) ){
                jQuery(this).attr('class', 'center_head colsIndex' + parseInt(index + 1)).attr("cols-index", parseInt(index + 1)).find("select").attr("id", "idDatePicker_"+parseInt(index+1)).attr("onchange", "changeGRIDSelectDates("+parseInt(index+1)+", 1)");
                if(index > 1){
                    var select_val = jQuery(".center_head.colsIndex" + parseInt(index)+" select").val();
                    dropdownVal= getAgeDropdown(select_val);
                    select_val++;
                    var nextagedropdown = '<select class="uk-select node_select" id="idDatePicker_'+parseInt(index +1)+'" onchange="changeGRIDSelectDates('+parseInt(index +1)+', '+CashFlowitem+')">';

                    //Get last value of node
                    let node_length = jQuery('.solutionform_InvestmentStrategy_table_'+CashFlowitem+' .colsIndex'+parseInt(rowindexitemm - 1) ).find('option:selected').val();
                    console.log("node length::: >> ", node_length);
                
                    if(node_length > 0){
                        Last_value = parseInt(node_length)+1;
                    }else{
                        Last_value = parseInt(Last_value) +1;
                    }


                    for (var inc = 0; inc < dropdownVal.length; inc++) {
                        if(parseInt(select_val) > inc){
                            nextagedropdown += '<option value="' + inc + '" hidden="hidden" disabled> ' + dropdownVal[inc] + '</option>';
                        }else{
                            nextagedropdown += '<option value="' + inc + '"> '+ measureTxt + dropdownVal[inc] + '</option>';
                        }
                    }
                    
                    nextagedropdown += '</select>';
                    nextagedropdown += '<a href="javascript: void(0);" uk-icon="minus-circle" class="trashStrategyAddedColumn uk-icon" data-cashflowitem="'+CashFlowitem+'" data-rowindexitem="'+parseInt(index + 1)+'" onclick="trashStrategyAddedColumn(this);"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle><line fill="none" stroke="#000" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg></a>';

                    jQuery(".solutionform_InvestmentStrategy_table_"+CashFlowitem+" .center_head.colsIndex" + parseInt(index + 1)).html(nextagedropdown);
                }               
            }
        })
        jQuery(".solutionform_InvestmentStrategy_table_" + CashFlowitem + " tbody tr td").each(function(index) {
            if(index != 0 && total_th-1 != parseInt(index+1) ){
                jQuery(this).attr('class', 'plus_symbol typeyear_strategycolmn colsIndex' + parseInt(index + 1));
            }
        })       
    }

    //jQuery(".solutionform_InvestmentStrategy_table_" + CashFlowitem + " tbody tr > .colsIndex" + rowindexitemm).remove();
    ClickcollectionAllTypeOfData("confirm_btn");
}

function getpotcolorcode(element) {
    if (element.hasAttribute("data-item")) {
        let gridno = element.getAttribute('data-item');
        let freestructureTable = jQuery('#solutionform_investomentgrid_' + gridno).find(' tbody tr');
        jQuery('#solutionform_investomentgrid_' + gridno).find(' tbody tr p.uk-nav-header').attr('data-color', element.value);
        jQuery('#solutionform_investomentgrid_' + gridno).find(' tbody tr p a.selected').css('background', element.value);
       // jQuery('#solutionform_investomentgrid_' + gridno).find(' tbody tr p a.invest-head').css('background', element.value);
        freestructureTable.css('background', element.value);
        jQuery('#solutionform_investomentgrid_' + gridno).find('.solutionform_InvestmentStrategy_table_' + gridno + ' tbody tr').css('background', "linear-gradient(180deg, white calc(50% - 2px), " + element.value + " calc(50% - 2px), " + element.value + " calc(50%), " + element.value + " calc(50% + 2px), white calc(50% + 2px) )");
        freestructureTable.find('.shiftArrow1').css('color', element.value);
        freestructureTable.find('.selectedRating').css('background', element.value);
        freestructureTable.addClass('TextwhiteColor');
    }
}

function collectGoalSeekInputs() {

    let GoalSeekSection = jQuery('.solutiongoalseekinfoform');

    let agevalue = document.getElementById("Age_value").value;
    let retirementage = document.getElementById("Retirement_value").value;
    let projectionage = document.getElementById("Horizon_value").value;

    GoalPotnumber = GoalSeekSection.find('.solutiongoalseekinfo_potlist').find('select option:selected').val();

    GoalSeekPotValue = GoalSeekSection.find('.idGoalSeekPotValue').val();
    GoalSeekRealNominal = GoalSeekSection.find('.idGoalSeekRealNominal').val();
    GoalSeekPercentileVal = GoalSeekSection.find('.idGoalSeekPercentile').find('option:selected').val();
    CashFlowName = GoalSeekSection.find('.solutiongoalseekinfo_cashFlowlist').find('select option:selected').val();
    CashFlowNumber = GoalSeekSection.find('.solutiongoalseekinfo_cashFlowlist').find('select option:selected').index();

    GoalSeekTime_Index = GoalSeekSection.find('.LoadgoalseekprojectionAtTimelisttab').find('option:selected').val();
    if (GoalSeekTime_Index == 0) {
        GoalSeekTime = 'CANCHANGE';
    } else if (GoalSeekTime_Index == 1) {
        GoalSeekTime = Number(retirementage) - Number(agevalue);
    } else if (GoalSeekTime_Index == 2) {
        GoalSeekTime = Number(projectionage) - Number(agevalue);
    } else {
        GoalSeekTime = GoalSeekTime_Index - parseInt(3);
    }
    GoalSeekPercentile = parseInt(window.goalSeekDefaulPotCount) - parseInt(GoalSeekPercentileVal);
    params = { 'sclrSolveInput': CashFlowNumber, 'GoalSeekPotValue': GoalSeekPotValue, 'GoalSeekTime': GoalSeekTime, 'GoalSeekPercentile': GoalSeekPercentile, 'GoalSeekRealNominal': GoalSeekRealNominal };

    ClickcollectionAllTypeOfData(params);
}

function CollectOfInput_Data(agevalue, retirementage, projectionage) {
    let strVal = numValue = '';
    let DrawdownStart = [];
    let FundExpenses = [];
    let FundTax = [];
    let InputLabel = [];
    let InflowOutflow = [];
    let CashFlowArr = [];
    let Type = [];
    let TypeText = [];
    let Startdb = [];
    let Startapi = [];
    let TypeEnd = [];
    let TypeEndapi = [];
    let TypeAsset = [];
    let TypePot = [];
    let TypeYearStrategy = [];
    let TypeOverallStrategy = [];
    let TypeGlideOrFixedStrategy = [];
    let StrategyOptimisationMax = [];
    let vecInputSymbol = [];
    let vecGoalSeekPotValue = [];
    let vecGoalSeekPercentile = [];
    let vecGoalSeekTime = [];
    let LastSclrSolveInput = [];
    let ReturnsPot = [];
    let WasLastRunGoalSeek = false;
    let FeeModelPot = [];
    let LiveColourOptions = [];
    let PotOptions = [];
    let vecSolverInputFinalAmount = [
        [0]
    ];
    var multipleCashFlowPotsArrays = [];
    let totalpots = jQuery('.commoninvestomentgridform > li.investomentpotslisection ').length;
    let GlobalNCashFlowBars = jQuery('.investmentcashflowrowTable tbody > tr').length;
    for (asseCount = 1; asseCount <= GlobalNCashFlowBars; asseCount++) {
        TypeAsset.push("0");
    }
    for (potCount = 0; potCount < totalpots; potCount++) {
        //TypePot.push(potCount);
        StrategyOptimisationMax.push(10);
    }

    for (iControl = 1; iControl <= totalpots; iControl++) {
        let nStrategyOptionsOverTime = jQuery('.InvestmentStrategycashflow_table.solutionform_InvestmentStrategy_table_' + iControl).find('thead th').length - parseInt(1);
        let tempRowEntryYear = [];
        let tempRowEntryStrat = [];
        let tempTypeGlideStrategy = [];
        for (iStrategyVariation = 1; iStrategyVariation <= nStrategyOptionsOverTime; iStrategyVariation++) {
            sclrStrat = jQuery('.solutionform_InvestmentStrategy_table_' + iControl).find('td.colsIndex' + iStrategyVariation + ' > a.selectedRating').attr('data-value');

            if (typeof sclrStrat == 'undefined' || sclrStrat == '') {
                sclrStrat = tempRowEntryStrat[tempRowEntryStrat.length - 1];
            }
            if (iStrategyVariation == 1) {
                sclrYear = 0;
            } else {
                sclrYear = jQuery('.solutionform_InvestmentStrategy_table_' + iControl + ' thead').find('th.colsIndex' + iStrategyVariation + ' select option:selected').val();

            };
            //console.log('sclrYear=>' + sclrYear + '-iControl=>' + iControl + '-sclrStrat=>' + sclrStrat + '-iStrategyVariation=>' + iStrategyVariation);
            if (sclrYear <= 0 || sclrYear == null) {
                sclrYear = 0;
            }
            tempTypeGlideStrategy.push(0);
            tempRowEntryStrat.push(sclrStrat);
            tempRowEntryYear.push(sclrYear);
        }
        let CashFlowPerTable = jQuery('.solutionform_investomentgrid_table_' + iControl + ' tbody').find('tr').length;

        TypePot = Array.apply(null, Array(CashFlowPerTable)).map(Number.prototype.valueOf, iControl - 1);
        multipleCashFlowPotsArrays.push(TypePot);


        console.log("TypeYearStrategy :: ", tempRowEntryYear);
        TypeYearStrategy.push(tempRowEntryYear);        
        TypeOverallStrategy.push(tempRowEntryStrat);
        TypeGlideOrFixedStrategy.push(tempTypeGlideStrategy);

        ReturnsPot.push(JSON.stringify(0));
    }
    var CashFlowPotsArrays = [].concat.apply([], multipleCashFlowPotsArrays);
    TypePot = JSON.stringify(CashFlowPotsArrays);
    for (let kcount = 0; kcount < GlobalNCashFlowBars; kcount++) {
        //TypePot.push(JSON.stringify(kcount));
        vecGoalSeekPotValue.push(0);
        vecGoalSeekPercentile.push(0);
        vecGoalSeekTime.push(2);
    }
    //console.log(ReturnsPot);
    //vecSolverInputFinalAmount.push(SolverInputFinalAmount);

    jQuery('.projectioneventgridcashflow_table tbody > tr').each(function() {
        DrawdownStart.push(jQuery(this).find('.LoadAllprojectioninfopath option:selected').val());
    });
    jQuery('.investomentpotslisection').each(function() {
        PotOptions.push(jQuery(this).find('.listinputtextpotname').val());
        LiveColourOptions.push(jQuery(this).find('.potcolorcodeboxvalue').val());
    });
    jQuery('.freestructuregridcashflow_table tbody > tr').each(function() {
        strVal = jQuery(this).find('.idExpensesValue').val();
        numValue1 = parseFloat(strVal) / 100;
        if (isNaN(numValue1)) {
            numValue1 = 0;
        };
        strVal = jQuery(this).find('.idTaxValue').val();
        numValue2 = parseFloat(strVal) / 100;
        if (isNaN(numValue2)) {
            numValue2 = 0;
        };
        FundExpenses.push(numValue1);
        FundTax.push(numValue2);
        FeeModelPot.push(jQuery(this).find('.idFeeModelSelect option:selected').val());
    });

    jQuery('.investmentcashflowrowTable tbody > tr').each(function(indexControl) {
        InputLabel.push(jQuery(this).find('.investmentcashflowname').val());
        InflowOutflow.push(jQuery(this).find('.CashflowAllarrinoutflow').val());
        CashFlowArr.push(jQuery(this).find('.investmentcashflowvalue').val());
        Type.push(jQuery(this).find('.CashFlowAllTypebegin option:selected').val());
        vecInputSymbol.push(JSON.parse(jQuery(this).find('.investmentcashflowcurrency option:selected').val()));

        TypeText.push(jQuery(this).find('.CashFlowAllTypebegin option:selected').text());

        var te= jQuery(this).find('.LoadAllTypeEndOptions option:selected').val();
       
        TypeEnd.push(Number(te) );


        var v = jQuery(this).find('.LoadgoalseekprojectionAtTimelist option:selected').val();
        Startdb.push(Number(v));
        if (jQuery(this).find('.LoadgoalseekprojectionAtTimelist option:selected').val() == 0) {
            sclrStartIndex = Number(retirementage) - Number(agevalue);
        } else if (jQuery(this).find('.LoadgoalseekprojectionAtTimelist option:selected').val() == 1) {
            sclrStartIndex = 0;
        } else {
            sclrStartIndex = jQuery(this).find('.LoadgoalseekprojectionAtTimelist option:selected').val() - 2;
        }
        Startapi.push(sclrStartIndex);

        if (jQuery(this).find('.LoadAllTypeEndOptions option:selected').val() == 0) {
            sclrEndIndex = sclrStartIndex;
        } else if (jQuery(this).find('.LoadAllTypeEndOptions option:selected').val() == 1) {
            sclrEndIndex = Number(retirementage) - Number(agevalue);
        } else if (jQuery(this).find('.LoadAllTypeEndOptions option:selected').val() == 2) {
            sclrEndIndex = Number(projectionage) - Number(agevalue);
        } else {
            sclrEndIndex = jQuery(this).find('.LoadAllTypeEndOptions').val() - 3;
        }
        TypeEndapi.push(sclrEndIndex);
    });


    if(FundExpenses.length == 0){ FundExpenses.push(0.015) }
    if(FundTax.length == 0){ FundTax.push(0) }
    if(InputLabel.length == 0){ InputLabel.push('Cashflow name') }
    if(InflowOutflow.length == 0){ InflowOutflow.push("0") }
    if(CashFlowArr.length == 0){ CashFlowArr.push("22000") }
    if(Type.length == 0){ Type.push(0) }
    if(Startdb.length == 0 || Startdb == null){ Startdb.push(0);   }
    if(TypeText.length == 0){ TypeText.push('One off amount today') }
    if(Startapi.length == 0  || Startapi < 0){Startapi=[];  Startapi.push(0) }
    if(TypeEnd.length == 0){ TypeEnd.push(0) }
    if(TypeEndapi.length == 0){ TypeEndapi.push(-3) }
    if(TypeAsset.length == 0){ TypeAsset.push("0") }
        
    arr =[0];
    arr2 =["3"];

    if(TypePot.length == 0 || TypePot == '[]'){   TypePot= JSON.stringify(arr);   }
    if(TypeYearStrategy.length == 0){ TypeYearStrategy.push(arr) }
    if(TypeOverallStrategy.length == 0){ TypeOverallStrategy.push(arr2) }
    if(TypeGlideOrFixedStrategy.length == 0){ TypeGlideOrFixedStrategy.push(arr) }
    if(StrategyOptimisationMax.length == 0){ StrategyOptimisationMax.push(10) }
    if(vecInputSymbol.length == 0){ vecInputSymbol.push(0) }
    if(vecSolverInputFinalAmount.length == 0){ vecSolverInputFinalAmount.push(arr) }
    if(vecGoalSeekPotValue.length == 0){ vecGoalSeekPotValue.push(0) }
    if(vecGoalSeekTime.length == 0){ vecGoalSeekTime.push(2) }
    if(vecGoalSeekPercentile.length == 0){ vecGoalSeekPercentile.push(2) }
    if(ReturnsPot.length == 0){ ReturnsPot.push("0") }
    if(FeeModelPot.length == 0){ FeeModelPot.push(1) }
    if(PotOptions.length == 0){ PotOptions.push("Investment pot 1") }
    if(LiveColourOptions.length == 0){ LiveColourOptions.push("#697d8a") }

    return { DrawdownStart: (DrawdownStart.length === 0 ? [0] : DrawdownStart), GlobalNCashFlowBars: GlobalNCashFlowBars, NStrategyYears: 1, FundExpenses: FundExpenses, FundTax: FundTax, InputLabel: InputLabel, InflowOutflow: InflowOutflow, CashFlowArr: CashFlowArr, Type: Type, TypeText: TypeText, Start: Startdb, Startapi: Startapi, TypeEnd: TypeEnd, TypeEndapi: TypeEndapi, TypeAsset: TypeAsset, TypePot: TypePot, TypeYearStrategy: TypeYearStrategy, TypeOverallStrategy: TypeOverallStrategy, TypeGlideOrFixedStrategy: TypeGlideOrFixedStrategy, StrategyOptimisationMax: StrategyOptimisationMax, vecInputSymbol: vecInputSymbol, vecSolverInputFinalAmount: vecSolverInputFinalAmount, vecGoalSeekPotValue: vecGoalSeekPotValue, vecGoalSeekTime: vecGoalSeekTime, vecGoalSeekPercentile: vecGoalSeekPercentile, WasLastRunGoalSeek: WasLastRunGoalSeek, LastSclrSolveInput: LastSclrSolveInput, ReturnsPot: ReturnsPot, FeeModelPot: FeeModelPot, PotOptions: PotOptions, LiveColourOptions: LiveColourOptions };
}

function getSettingTabInfo(agevalue, retirementage, projectionage) {
    let vecGoalSeekRealNominal = [];
    let AssumptionsSet2Use = 1; /* count number of assumptions */
    let NumberOfDrawdowns = jQuery('.projectioneventgridcashflow_table tbody > tr > td').length;
    vecGoalSeekRealNominal.push(jQuery('.idGoalSeekRealNominal  option:selected').text());
    return { NumberOfDrawdowns: NumberOfDrawdowns == 0 ? 1 : NumberOfDrawdowns, AssumptionsSet2Use: AssumptionsSet2Use, vecGoalSeekRealNominal: vecGoalSeekRealNominal };
}

function Create2DArray(rows) {
    let arr = [];
    for (let i = 0; i < rows; i++) {
        arr[i] = [];
    }
    return arr;
}

function updateDrawdownSequence(DrawdownSequenceIn, sclrRow, vecArray) {
    DrawdownSequenceIn[sclrRow - 1] = vecArray;
    return DrawdownSequenceIn;
}

function getAssumptionData1(agevalue, retirementage, projectionage, AssumptionsSet2Use) {

    let DrawdownSequence;
    let DrawdownSequence1 = Create2DArray(10);
    let DrawdownSequence2 = Create2DArray(10);

    DrawdownSequence1 = updateDrawdownSequence(DrawdownSequence1, 1, [0.11]); // 2022 Q4
    DrawdownSequence1 = updateDrawdownSequence(DrawdownSequence1, 2, [-15.75, 18.70]); // 2022 Q4
    DrawdownSequence1 = updateDrawdownSequence(DrawdownSequence1, 3, [-14.21, 15.63]); // 2022 Q4
    DrawdownSequence1 = updateDrawdownSequence(DrawdownSequence1, 4, [-18.86, -1.66, 22.33, 3.58]); // 2022 Q4
    DrawdownSequence1 = updateDrawdownSequence(DrawdownSequence1, 5, [-20.70, -2.24, 24.20, 4.19]); // 2022 Q4
    DrawdownSequence1 = updateDrawdownSequence(DrawdownSequence1, 6, [-22.69, -3.15, 26.04, 6.07]); // 2022 Q4
    DrawdownSequence1 = updateDrawdownSequence(DrawdownSequence1, 7, [-24.89, -3.85, 28.19, 11.51]); // 2022 Q4
    DrawdownSequence1 = updateDrawdownSequence(DrawdownSequence1, 8, [-15.20, -14.13, -7.20, 17.96, 7.01, 18.57]); // 2022 Q4
    DrawdownSequence1 = updateDrawdownSequence(DrawdownSequence1, 9, [-16.67, -15.16, -7.79, 18.36, 7.29, 18.96, 4.39]); // 2022 Q4
    DrawdownSequence1 = updateDrawdownSequence(DrawdownSequence1, 10, [-22.39, -18.10, -11.28, 20.22, 7.93, 22.33, 14.22]);

    DrawdownSequence2 = updateDrawdownSequence(DrawdownSequence2, 1, [0.21]);
    DrawdownSequence2 = updateDrawdownSequence(DrawdownSequence2, 2, [-4.40, 4.98]);
    DrawdownSequence2 = updateDrawdownSequence(DrawdownSequence2, 3, [-5.97, 6.64]);
    DrawdownSequence2 = updateDrawdownSequence(DrawdownSequence2, 4, [-3.48, -5.70, -1.71, 13.88]);
    DrawdownSequence2 = updateDrawdownSequence(DrawdownSequence2, 5, [-7.84, -9.30, -3.50, 15.23, 5.77, 2.66]);
    DrawdownSequence2 = updateDrawdownSequence(DrawdownSequence2, 6, [-10.53, -11.21, -4.68, 16.92, 6.16, 7.44]);
    DrawdownSequence2 = updateDrawdownSequence(DrawdownSequence2, 7, [-12.15, -12.75, -5.34, 18.67, 6.71, 10.81]);
    DrawdownSequence2 = updateDrawdownSequence(DrawdownSequence2, 8, [-16.21, -15.10, -7.22, 20.31, 7.06, 20.63]);
    DrawdownSequence2 = updateDrawdownSequence(DrawdownSequence2, 9, [-17.46, -15.99, -7.78, 20.98, 7.37, 21.14]);
    DrawdownSequence2 = updateDrawdownSequence(DrawdownSequence2, 10, [-23.17, -18.40, -10.85, 22.29, 7.42, 22.99, 13.09]);
    var Cash = { "Name": "Cash", "Colour": [119, 190, 139] };
    var Sovereign = { "Name": "Sovereign Debt", "Colour": [67, 115, 64] };
    var InvGrade = { "Name": "Investment Grade", "Colour": [75, 189, 211] };
    var HighYield = { "Name": "High Yield", "Colour": [27, 93, 117] };
    var IndexLinked = { "Name": "Index Yield", "Colour": [30, 36, 71] };
    var DWEquity = { "Name": "DW Equity", "Colour": [48, 48, 129] };
    var EMEquity = { "Name": "EM Equity", "Colour": [92, 50, 137] };
    var Property = { "Name": "Property", "Colour": [240, 133, 151] };
    var Resources = { "Name": "Resources", "Colour": [255, 29, 67] };
    var Gold = { "Name": "Gold", "Colour": [247, 167, 81] };
    var Alternatives = { "Name": "Alternatives", "Colour": [255, 212, 0] };
    var AssetSelection2 = ["Cash", "Defensive", "Cautious", "Cautious Balanced", "Balanced", "Balanced Growth", "Growth", "High Growth", "Aggressive Growth", "Equity"];
    var AssetClassMix1 = [1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; //01/10/2022
    var AssetClassMix2 = [0.0875, 0.135, 0.245, 0.045, 0.2, 0.1375, 0.03, 0, 0, 0.02, 0.1]; //01/10/2022
    var AssetClassMix3 = [0.0895, 0.115, 0.22, 0.045, 0.185, 0.1655, 0.045, 0, 0.0125, 0.0225, 0.1]; //01/10/2022
    var AssetClassMix4 = [0.055, 0.0875, 0.2, 0.075, 0.07, 0.2775, 0.065, 0, 0.0125, 0.0225, 0.135]; //01/10/2022
    var AssetClassMix5 = [0.0425, 0.085, 0.155, 0.095, 0.05, 0.3475, 0.065, 0, 0.015, 0.025, 0.12]; //01/10/2022
    var AssetClassMix6 = [0.0575, 0.06, 0.1225, 0.095, 0.025, 0.4175, 0.075, 0, 0.015, 0.025, 0.1075]; //01/10/2022
    var AssetClassMix7 = [0.035, 0.05, 0.1025, 0.105, 0, 0.47, 0.085, 0, 0.0175, 0.025, 0.11]; //01/10/2022
    var AssetClassMix8 = [0.0375, 0.03, 0.025, 0.08, 0, 0.58, 0.1125, 0, 0.0175, 0.025, 0.0925]; //01/10/2022
    var AssetClassMix9 = [0.0375, 0.02, 0.02, 0.08, 0, 0.62, 0.1175, 0, 0.0175, 0.025, 0.0625]; //01/10/2022
    var AssetClassMix10 = [0.05, 0, 0, 0, 0, 0.795, 0.155, 0, 0, 0, 0]; //01/10/2022
    var PortfolioAssetAllocations = [AssetClassMix1, AssetClassMix2, AssetClassMix3, AssetClassMix4, AssetClassMix5, AssetClassMix6, AssetClassMix7, AssetClassMix8, AssetClassMix9, AssetClassMix10];
    var ModelDate = '01/10/2022a';
    var ReturnActive = [0, 6.95, 6.98, 7.28, 7.32, 7.35, 7.43, 7.34, 7.37, 7.24];
    var AssetClassReturn05 = [3.6, 4, 6.2, 6.4, 2.9, 4.8, 6.1, 3.3, 4.3, 7.8, 4.1];
    var Risk = [0.6, 5.9, 6.5, 8.6, 9.9, 11.2, 12.4, 14.7, 15.5, 18.7];
    var Inflation = window.Inflation;
    var ReturnLongerTermActive = [1.5, 5.8, 6.3, 6.8, 7.3, 7.8, 8.3, 8.7, 9, 9.3];
    var AssetClassReturn15 = [0.8, 1.5, 2.3, 5.0, 2.0, 5.5, 7.0, 3.0, 5.0, 5.0, 3.5];
    var InflationLongTerm = window.InflationLongTerm;
    portfolioObj05_1 = { "ModelDate": ModelDate, "ForecastYearStart": [0], "PortReturn": ReturnActive, "AssetReturn": AssetClassReturn05, "PortfolioRisk": Risk, "Inflation": Inflation, "AssetAllocation": PortfolioAssetAllocations, "CalculateReturns": false };
    portfolioObj15_1 = { "ModelDate": ModelDate, "ForecastYearStart": [6], "PortReturn": ReturnLongerTermActive, "AssetReturn": AssetClassReturn15, "PortfolioRisk": Risk, "Inflation": InflationLongTerm, "AssetAllocation": PortfolioAssetAllocations, "CalculateReturns": false };

    var objAssetCollectionStore = {
        "UseObject": true,
        "Title": 'Development Balance Sheet',
        "AssetInfo": [Cash, Sovereign, InvGrade, HighYield, IndexLinked, DWEquity, EMEquity, Property, Resources, Gold, Alternatives],
        "Assumptions": [portfolioObj05_1, portfolioObj15_1],
        "AssetClassMix": PortfolioAssetAllocations,
        "AssetClassMixName": AssetSelection2,
        "DrawdownSequence": DrawdownSequence1
    };

    if (AssumptionsSet2Use == 0) {
        DrawdownSequence = DrawdownSequence2;
    } else if (AssumptionsSet2Use == 1) {
        DrawdownSequence = DrawdownSequence1;
    }

    jQuery.getJSON(base_url + controller + '/get-assumption-info', function(response, status) {
        console.log("assumption-info status:: ", status);
        console.log("assumption-info response:: ", response);
        console.log("assumption-info response drawdown:: ", JSON.parse(response.DrawdownSequence) );
        //if(status == 'success'){
        return { DrawdownSequence: response.DrawdownSequence, objAssetCollectionStore: response };
        // }else{
        //     return { DrawdownSequence: DrawdownSequence, objAssetCollectionStore: objAssetCollectionStore };
        // }
    });

   
}

function getAssumptionData(agevalue, retirementage, projectionage, AssumptionsSet2Use) {

    jQuery.getJSON(base_url + controller + '/get-assumption-info', function(response, status) {
        console.log("assumption-info status:: ", status);
        console.log("assumption-info response:: ", response);
        console.log("assumption-info response drawdown:: ", JSON.parse(response.DrawdownSequence) );
        //if(status == 'success'){
        return { DrawdownSequence: response.DrawdownSequence, objAssetCollectionStore: response };
        // }else{
        //     return { DrawdownSequence: DrawdownSequence, objAssetCollectionStore: objAssetCollectionStore };
        // }
    });

   
}


function ClickcollectionAllTypeOfData(element) {
    console.log("Elements values:: ", element);

    let buttonType = '';
    if(element == 'confirm_btn'){
        buttonType = 'update';
    } else if(element == 'setting_btn'){
        buttonType = 'setting_update';
    }   

    let currentcashSolutionname = [];
    let ClientName = document.getElementById("ClientName").value;
    let agevalue = document.getElementById("Age_value").value;
    let retirementage = document.getElementById("Retirement_value").value;
    let projectionage = document.getElementById("Horizon_value").value;

    let SettingTabData = getSettingTabInfo(agevalue, retirementage, projectionage);
    
    //console.log("AssumptionTablData response::: ", AssumptionTablData);

    let currenttimestamp = document.getElementById("currenttimestamp").value;
    currentcashSolutionname.push(document.getElementById("currentcashSolutionname").value);
    let tokenkey = document.getElementById("tokenkey").value;
    let RealNominalSelection = document.querySelector('input[name="RadioReal"]:checked').value;
    let RadioPosOrNegChart = document.querySelector('input[name="RadioPosOrNegChart"]:checked').value;
    let TimeSelection = document.querySelector('input[name="RadioTime"]:checked').value;
    let fielddata = CollectOfInput_Data(agevalue, retirementage, projectionage);
    let settingsfielddata = CollectOfSettingsInput_Data();
    

    if (typeof element != "undefined") {
        sclrSolveInput = element.sclrSolveInput;
        GoalSeekPotValue = element.GoalSeekPotValue;
        if (element.GoalSeekTime == 'CANCHANGE') {
            GoalSeekTime = fielddata.Startapi;
        } else {
            GoalSeekTime = element.GoalSeekTime;
        }
        GoalSeekPercentile = element.GoalSeekPercentile;
        GoalSeekRealNominal = element.GoalSeekRealNominal;
    } else {
        sclrSolveInput = 0;
        GoalSeekPotValue = [];
        GoalSeekTime = [];
        GoalSeekPercentile = [];
        GoalSeekRealNominal = [];
    }

    
    let CashObj = [];
    let OthersObj = [];
    let SettingsObj = [];

    CashObj.push({
        'solnRow': tokenkey,
        'Model': 'CashflowModel',
        'ClientName': ClientName,
        'DrawdownStart': fielddata.DrawdownStart,
        'Age': agevalue,
        'RetirementAge': retirementage,
        'GlobalNCashFlowBars': fielddata.GlobalNCashFlowBars,
        'NStrategyYears': fielddata.NStrategyYears,
        'ProjectionHorizon': projectionage,
        'FundExpenses': fielddata.FundExpenses,
        'FundTax': fielddata.FundTax,
        'InputLabel': fielddata.InputLabel,
        'InflowOutflow': fielddata.InflowOutflow,
        'CashFlowArr': fielddata.CashFlowArr,
        'Type': fielddata.Type,
        'Start': fielddata.Start,
        'TypeEnd': fielddata.TypeEnd,
        'TypeAsset': fielddata.TypeAsset,
        'TypePot': fielddata.TypePot,
        'TypeYearStrategy': fielddata.TypeYearStrategy,
        'TypeOverallStrategy': fielddata.TypeOverallStrategy,
        'TypeGlideOrFixedStrategy': fielddata.TypeGlideOrFixedStrategy,
        'StrategyOptimisationMax': fielddata.StrategyOptimisationMax,
        'vecInputSymbol': fielddata.vecInputSymbol,
        'vecSolverInputFinalAmount': fielddata.vecSolverInputFinalAmount,
        'vecGoalSeekPotValue': fielddata.vecGoalSeekPotValue,
        'vecGoalSeekTime': fielddata.vecGoalSeekTime,
        'vecGoalSeekPercentile': fielddata.vecGoalSeekPercentile,
        'WasLastRunGoalSeek': fielddata.WasLastRunGoalSeek,
        'LastSclrSolveInput': fielddata.LastSclrSolveInput,
        'ReturnsPot': fielddata.ReturnsPot,
        'FeeModelPot': fielddata.FeeModelPot,
        'RealNominalSelection': RealNominalSelection,
        'ChartPos_Neg': RadioPosOrNegChart,
        'TimeSelection': TimeSelection,
        'NumberOfDrawdowns': SettingTabData.NumberOfDrawdowns,
        'AssumptionsSet2Use': SettingTabData.AssumptionsSet2Use,
        'LiveColourOptions': fielddata.LiveColourOptions,
        'PotOptions': fielddata.PotOptions,
        'timestamp': currenttimestamp,
        'vecGoalSeekRealNominal': SettingTabData.vecGoalSeekRealNominal,
        'MeanReversion': false,
        'RiskArrestation': false,
    });
  
    SettingsObj.push({
        'MeasureTime': settingsfielddata.measureTime,
        'RealOrNominalTerms': settingsfielddata.RealOrNominalTerms,
        'NegativePositive': settingsfielddata.NegativePositive,
        'ScreenHints': settingsfielddata.ScreenHints,
        'ProjectionEvents': settingsfielddata.ProjectionEvents,
        'CurrencySelect': settingsfielddata.CurrencySelect,
    })

    jQuery('.InvestmentStrategycashflow_table').find('.currentagevalue').html(agevalue + ': Now');
    jQuery('.InvestmentStrategycashflow_table').find('.currentprojectionagevalue').html(projectionage + ': End');
    console.log("Collection OthersObj responseee:: ", OthersObj);

    var assumption_id = $('.assumption_name_select').find(":selected").val(); //get selected assumption name

    jQuery.getJSON(base_url + controller + '/get-assumption-info', {"assumption_id" : assumption_id }, function(response, status) {
       
        let AssumptionTablData = response;
        var objAssetCollectionStore = {
            "UseObject": AssumptionTablData.UseObject,
            "Title": AssumptionTablData.Title,
            "AssetInfo": AssumptionTablData.AssetInfo,
            "Assumptions": AssumptionTablData.Assumptions,
            "AssetClassMix": AssumptionTablData.AssetClassMix,
            "AssetClassMixName": AssumptionTablData.AssetClassMixName,
            "DrawdownSequence": AssumptionTablData.DrawdownSequence
        };
    
        OthersObj.push({
            'Type': fielddata.TypeText,
            'Start': fielddata.Startapi,
            'TypeEnd': fielddata.TypeEndapi,
            'Organisation': currentcashSolutionname,
            'DrawdownSequence': objAssetCollectionStore.DrawdownSequence,
            'objAssetCollectionStore': objAssetCollectionStore,
            'sclrSolveInput': sclrSolveInput,
            'GoalSeekPotValue': GoalSeekPotValue,
            'GoalSeekTime': GoalSeekTime,
            'GoalSeekPercentile': GoalSeekPercentile,
            'GoalSeekRealNominal': GoalSeekRealNominal,
        });

    

        jQuery.ajax({
            url: base_url + controller + '/collection-alltype-data',
            data: { ajax: true, type: buttonType, obj: (JSON.stringify(CashObj)), others: (JSON.stringify(OthersObj)), settingObj: (JSON.stringify(SettingsObj)) },
            method: 'POST',
            async: true,
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            dataType: 'json',
            success: function(response) {
                //showDropdownList('LoadgoalseekprojectionAtTimelist', response.datalist.goalseekprojectionAtTimelist);
                //showDropdownList('LoadgoalseekprojectionAtTimelisttab', response.datalist.goalseekprojectionAtTimelist);

                console.log("Collection responseee:: ", response);
            
                document.getElementById("Age_value").value = JSON.parse(response.params[15]);
                document.getElementById("Retirement_value").value = JSON.parse(response.params[17]);
                document.getElementById("Horizon_value").value = JSON.parse(response.params[19]);

                document.getElementById("Age_slider").value = JSON.parse(response.params[15]);
                document.getElementById("Retirement_slider").value = JSON.parse(response.params[17]);
                document.getElementById("Horizon_slider").value = JSON.parse(response.params[19]);


                // Settings value set in html
                if(response.settingParams != null){ 
                    jQuery('input[name="RadioTime"][value="' + response.settingParams.MeasureTime + '"]').prop('checked', true);
                    jQuery('input[name="RadioReal"][value="' + response.settingParams.RealOrNominalTerms + '"]').prop('checked', true);
                    jQuery('input[name="RadioPosOrNegChart"][value="' + response.settingParams.NegativePositive + '"]').prop('checked', true);
                    jQuery('input[name="screenhits"][value="' + response.settingParams.ScreenHints + '"]').prop('checked', true);
                    jQuery('input[name="currency"][value="' + response.settingParams.CurrencySelect + '"]').prop('checked', true);
                    if(response.settingParams.ProjectionEvents.length >0 ){
                        getProjectionEventHTML(response.settingParams.ProjectionEvents, JSON.parse(response.params[15]) )
                    }
                    console.log("response.settingParams.CurrencySelect ::: ", response.settingParams.CurrencySelect);
                }  

                setHints(); //set hints

                if(element != 'confirm_btn' && element != 'setting_btn'){                
                    //Append investment pots data
                    investmentPotHtml(response);  
                    createPotToViewHtml(response);
                }
                

                var data_cashObj = createGraphInputValues(tokenkey, ClientName, response.params, fielddata, SettingTabData, response.extraParams);
                console.log("data_cashObj>>> ", data_cashObj);
                loadcashflowAPIdata(JSON.stringify(data_cashObj), response.params, response.datalist);

            }
        });
    });
}

function createGraphInputValues(tokenkey, ClientName, params, fielddata, SettingTabData, extraParams){
    let CashObjj = [];
    let RealNominalSelection = document.querySelector('input[name="RadioReal"]:checked').value;
    let RadioPosOrNegChart = document.querySelector('input[name="RadioPosOrNegChart"]:checked').value;
    let TimeSelection = document.querySelector('input[name="RadioTime"]:checked').value;
   console.log("check createGraphInputValues:::", params);
    CashObjj.push({
        'solnRow': tokenkey,
        'Model': 'CashflowModel',
        'ClientName': ClientName,
        'DrawdownStart': JSON.parse(params[61]),
        'Age': JSON.parse(params[15]),
        'RetirementAge': JSON.parse(params[17]),
        'GlobalNCashFlowBars': fielddata.GlobalNCashFlowBars,
        'NStrategyYears': fielddata.NStrategyYears,
        'ProjectionHorizon': JSON.parse(params[19]),
        'FundExpenses': JSON.parse(params[59]),
        'FundTax': JSON.parse(params[61]),
        'InputLabel': JSON.parse(params[21]),
        'InflowOutflow': JSON.parse(params[23]),
        'CashFlowArr': fielddata.CashFlowArr,
        'Type': JSON.parse(params[27]),
        'Start': JSON.parse(params[31]),
        'TypeEnd': JSON.parse(params[33]),
        'TypeAsset': JSON.parse(params[35]),
        'TypePot': JSON.parse(params[47]),
        'TypeYearStrategy': JSON.parse(params[37]),
        'TypeOverallStrategy': JSON.parse(params[39]),
        'TypeGlideOrFixedStrategy': JSON.parse(params[41]),
        'StrategyOptimisationMax': JSON.parse(params[3]),
        'vecInputSymbol': JSON.parse(params[29]),
        'vecSolverInputFinalAmount': JSON.parse(params[25]),
        'vecGoalSeekPotValue': params[7],
        'vecGoalSeekTime': params[9],
        'vecGoalSeekPercentile': params[11],
        'WasLastRunGoalSeek': fielddata.WasLastRunGoalSeek,
        'LastSclrSolveInput': fielddata.LastSclrSolveInput,
        'ReturnsPot': fielddata.ReturnsPot,
        'FeeModelPot': fielddata.FeeModelPot,
        'RealNominalSelection': RealNominalSelection,
        'ChartPos_Neg': RadioPosOrNegChart,
        'TimeSelection': TimeSelection,
        'NumberOfDrawdowns': SettingTabData.NumberOfDrawdowns,
        'AssumptionsSet2Use': SettingTabData.AssumptionsSet2Use,
        'LiveColourOptions': JSON.parse(extraParams[5]),
        'PotOptions': JSON.parse(params[53]),
        'timestamp': currenttimestamp,
        'vecGoalSeekRealNominal': RealNominalSelection,
        'MeanReversion': false,
        'RiskArrestation': false,
        'DrawdownSequence': JSON.parse(params[55]),
    });

    console.log("check createGraphInputValues CashObjj:::", CashObjj);

    return CashObjj;
    
}

function CollectOfSettingsInput_Data() {
    //alert("collect data:: ");
    let measureTime = 'Age';
    let RealOrNominalTerms = 'Real';
    let NegativePositive = 'PositiveOnly_Y';
    let ScreenHints = '0';
    let CurrencySelect = '&#163';
    let ProjectionEvents = [];


    measureTime = jQuery("input[name='RadioTime']:checked").val();
    RealOrNominalTerms = jQuery("input[name='RadioReal']:checked").val();
    NegativePositive = jQuery("input[name='RadioPosOrNegChart']:checked").val();
    ScreenHints = jQuery("input[name='screenhits']:checked").val();
    CurrencySelect = jQuery(".curentcurrencysetting").children('option:selected').val();
    jQuery('.LoadAllprojectioninfopath').each(function(indexControl) {     
        ProjectionEvents.push(jQuery(this).find('option:selected').val());
    });
    console.log("ProjectionEvents:: ", ProjectionEvents);
    console.log("ProjectionEvents CurrencySelect:: ", CurrencySelect);
   // ProjectionEvents = ['0'];
     
    return { measureTime: measureTime, RealOrNominalTerms: RealOrNominalTerms, NegativePositive: NegativePositive, ScreenHints: ScreenHints, CurrencySelect: CurrencySelect, ProjectionEvents: ProjectionEvents };
}
 
function getProjectionEventHTML(ProjectionEvents, age){
    var ii=1;    str ='';
    for (let index = 0; index < ProjectionEvents.length; index++) {

        markup =''; markupEnd ='';
        markup += '<tr class="light_grey" row-index="'+index+'">'
        markup += '<td>Market downturn</td>'
        markup += '<td><select class="uk-select LoadAllreturnpath LoadAllprojectioninfopath">';
        
        markupEnd +'</select ></td>'
        markupEnd += '<td><a href="javascript: void(0);" uk-icon="trash" class="trashsolutionform_projectionevent " data-CashFlowitem="1" data-rowindexitem="'+index+'" onclick="trashsolutionform_projectionevent(this);"></a></td>'
        markupEnd += '</tr>';
    
        age_inc = age; text_val = ''; t=0; options_str= '';
        for(let j= age; j<=107; j++){  
            if(t== 0){ 
                text_val = 'Retirement'; 
                if(t == ProjectionEvents[index]){
                    options_str += '<option value="'+t+'" selected>At '+text_val+'</option>';                
                }else{
                    options_str += '<option value="'+t+'">At '+text_val+'</option>';
                }               
            } else if(t== 1){ 
                text_val = 'Now';   
                if(t == ProjectionEvents[index]){
                    options_str += '<option value="'+t+'" selected>At '+text_val+'</option>';
                }else{
                    options_str += '<option value="'+t+'" >At '+text_val+'</option>';
                }
            }else{ 
                text_val = age_inc++;     
                if(t == ProjectionEvents[index]){  
                    options_str += '<option value="'+t+'" selected>At '+text_val+'</option>';
                }else{
                    options_str += '<option value="'+t+'" >At '+text_val+'</option>';
                }
            }           
            t++;            
        }
        str += markup+' '+options_str+markupEnd;       
        ii++;
    }
    jQuery('.solutionform_projectioneventgrid_table_1 tbody').html(str);
}


var counter_global =0;
function createPotToViewHtml(response){
    var viewDropdown = ''; var select =0;
    var pots_options_val= JSON.parse(response.params[53]);
    if(pots_options_val.length > 0){ 
        for (let index = 0; index < pots_options_val.length; index++) {
            if(select == 0){
                viewDropdown = viewDropdown+ '<option value="'+parseInt(index+1) +'" >'+pots_options_val[index]+'</option>';    
            }else{
                viewDropdown = viewDropdown+ '<option value="'+parseInt(index+1) +'" data-invespot="'+parseInt(index+1)+'">'+pots_options_val[index]+'</option>';                    
            } 
            select++;                  
        }
        viewDropdown = viewDropdown+ '<option value="totalassets">Total Assets</option>'; 

    }else{
        viewDropdown = viewDropdown+ '<option value="1">Investment pot 1</option>';  
        viewDropdown = viewDropdown+ '<option value="totalassets">Total Assets</option>';  
    }
    if(counter_global == 0){
        jQuery('.potToView').html(viewDropdown);
        // setTimeout(function(){  
        //     $('.potToView').on('change', createFlowsChart("allcashflows")).trigger('change'); 
        // }, 4000);
    }
  
    counter_global++;
}

function investmentPotHtml(response){
    var pots_name= response.params[50];
    var pots_name_val= JSON.parse(response.params[53]);
    var pots_color_val= JSON.parse(response.params[51]);

    var strategyYearDropdown_val = JSON.parse(response.params[37]);
    var strategyDropdown_val = JSON.parse(response.params[39]);
    var pots_FundExpense_val= JSON.parse(response.params[59]);
    var pots_FundTax_val= JSON.parse(response.params[61]);
    var pots_FeeModal_val= JSON.parse(response.params[63]);

    var pots_inputLabel_val= JSON.parse(response.params[21]);
    var pots_amount_val= JSON.parse(response.params[25]);
    var pots_inputOutFlow_val= JSON.parse(response.params[23]);
    var pots_type_val= JSON.parse(response.extraParams[1]);
    var pots_currencySymbol_val= JSON.parse(response.params[29]);
    var pots_start_val= JSON.parse(response.params[31]);
    var pots_end_val= JSON.parse(response.params[33]);
    var pots_Type_val= JSON.parse(response.extraParams[3]);

    var str = ''; var t=1;
    if(pots_name_val.length > 0){ 
        for(var i=0; i <pots_name_val.length; i++){        
            str = str+'<li class="uk-margin investomentpotslisection investomentpotlist_'+t+'"><input class="uk-input listinputtextpotname solutionform_investomentgridinput_1" type="text" value="'+pots_name_val[i]+'" onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')">          <span class="pot_actions"> <a href="javascript:void(0);"><input class="potcolorcodebox potcolorcodeboxvalue" type="color" value="'+pots_color_val[i]+'" data-item="'+t+'" oninput="getpotcolorcode(this)" onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')"></a>  <a href="javascript:void(0);" uk-icon="trash" class="trashsolutionform_investment uk-icon" data-item="'+t+'"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" points="6.5 3 6.5 1.5 13.5 1.5 13.5 3"></polyline><polyline fill="none" stroke="#000" points="4.5 4 4.5 18.5 15.5 18.5 15.5 4"></polyline><rect x="8" y="7" width="1" height="9"></rect><rect x="11" y="7" width="1" height="9"></rect><rect x="2" y="3" width="16" height="1"></rect></svg></a> <a href="javascript:void(0);" uk-icon="plus" uk-toggle="target: #solutionform_investomentgrid_'+t+'" class="expandsolutionform investomentgrid_'+t+'formtoggle uk-icon" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect x="9" y="1" width="1" height="17"></rect><rect x="1" y="9" width="17" height="1"></rect></svg></a></span>     <div id="solutionform_investomentgrid_'+t+'" class="uk-grid-small salary_grid invest_grid" uk-grid hidden>   <div uk-accordion=""> ';
          
            sHtml = investmentPot_strategyHtml(str, t, response, pots_color_val[i], strategyDropdown_val[i], strategyYearDropdown_val[i])
           
            FeeHtml = investmentPot_FeeHtml(sHtml, t, pots_color_val[i], pots_FundExpense_val[i], pots_FundTax_val[i], pots_FeeModal_val[i])
            CashFlowHtml = investmentPot_CashFlowHtml(FeeHtml, t, response, pots_color_val[i],  pots_inputLabel_val, pots_amount_val, pots_inputOutFlow_val, pots_type_val, pots_currencySymbol_val, pots_start_val, pots_end_val, pots_Type_val)
            str = CashFlowHtml+' </div></div></li> ';
            t++;
        }   
    }
    jQuery('.pot_html').html(str);
    getCashFlowTR(response, pots_color_val, pots_inputLabel_val, pots_amount_val, pots_inputOutFlow_val, pots_type_val, pots_currencySymbol_val, pots_start_val, pots_end_val, pots_Type_val);
}
//Dynamic investment strategy html
function investmentPot_strategyHtml(str, t, response, color, strategyDropdown_val, strategyYearDropdown_val){
    getinvestmentstrategyData(strategyDropdown_val, t, color, response, strategyYearDropdown_val);
   
    str = str+ '<div class="invest_li"> <a class="uk-accordion-title" href="#">Investment Strategy</a><div class="uk-accordion-content"> <p>The investment strategy chosen at NOW represents the investment strategy until END unless the strategy is changed.<br> Select Add strategy node to change the investment strategy. Click on the + to select the Risk Rating to shift to Glide or Static. </p> <div class="uk-flex uk-flex-right cc_btns"> <button type="button" class="uk-button uk-button-default uk-margin-small-right uk-border-pill uk-text-capitalize yellow_btn addInvestmentStrategyColmn" aria-expanded="false" aria-expanded="false" data-CashFlowitem="'+t+'"  onclick="addInvestmentStrategyColmn(this);">Add strategy node</button> </div> <div class="uk-flex uk-flex-middle rating_area"> <p class="uk-width-1-5">AT AGE</p> </div>         <table class="table InvestmentStrategycashflow_table investmentcashflowrowTableCommon solutionform_InvestmentStrategy_table_'+t+'" ><thead class="strategy_head_html_'+t+'"> </thead><tbody><tr class="colorRef54 custom_background mainStr_html_'+t+'" style="background: linear-gradient(180deg, white calc(50% - 2px), ' + color + ' calc(50% - 2px), ' + color + ' calc(50%), ' + color + ' calc(50% + 2px), white calc(50% + 2px) )"></tr></tbody></table>       </div> </div>' ;
    return str;
}
//Dynamic investment Fees html
function investmentPot_FeeHtml(str, t, color, pots_FundExpense_val, pots_FundTax_val, FeeModal_val){
    var expense_val = pots_FundExpense_val * 100;
    var tax_val = pots_FundTax_val * 100;
    var selected1= '';
    var selected2= '';
    var selected3= '';
    if(FeeModal_val == 1){ selected1 = 'selected' }
    if(FeeModal_val == 2){ selected2= 'selected' }
    if(FeeModal_val == 3){ selected3 = 'selected' }
    str = str+ '<div class="invest_li"><a class="uk-accordion-title" href="#">Fee structure</a><div class="uk-accordion-content" hidden=""><p>Select fee model and insert any other charges. Expenses are set at organisational level</p><table class="table freestructuregridcashflow_table investmentcashflowrowTableCommon solutionform_freestructure_table_'+t+'"><thead><tr><th>Fee model <a href="javascript:void(0);" uk-icon="plus" class="expandfeestructuremodel uk-icon" data-cashflowitem="'+t+'"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect x="9" y="1" width="1" height="17"></rect><rect x="1" y="9" width="17" height="1"></rect></svg></a></th><th class="hideexpanse" hidden="">Expenses</th><th>Other charges</th><th>Indicator</th><th>Detail</th></tr></thead><tbody><tr class="light_grey" style="background: '+color+'"><td><select class="uk-select extrapadding idFeeModelSelect" onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')"><option value="1" '+selected1+'>Standard</option><option value="2" '+selected2+'>Wealth</option><option value="3" '+selected3+'>Bespoke</option></select></td><td class="hideexpanse" hidden=""><input type="text" class="idExpensesValue" value="'+expense_val+'%" onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')"></td><td><input type="text" value="'+tax_val+'%" class="idTaxValue" onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')"></td><td><div class="color-area"></div></td><td><span><a href="javascript:void(0);" uk-icon="info" class="uk-icon"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M12.13,11.59 C11.97,12.84 10.35,14.12 9.1,14.16 C6.17,14.2 9.89,9.46 8.74,8.37 C9.3,8.16 10.62,7.83 10.62,8.81 C10.62,9.63 10.12,10.55 9.88,11.32 C8.66,15.16 12.13,11.15 12.14,11.18 C12.16,11.21 12.16,11.35 12.13,11.59 C12.08,11.95 12.16,11.35 12.13,11.59 L12.13,11.59 Z M11.56,5.67 C11.56,6.67 9.36,7.15 9.36,6.03 C9.36,5 11.56,4.54 11.56,5.67 L11.56,5.67 Z"></path><circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9"></circle></svg></a></span></td></tr></tbody></table></div></div>';
    return str;
}

//Dynamic investment Cashflow html
function investmentPot_CashFlowHtml(str, t, response, color, inputLabel_val, amount_val, inputOutFlow_val, type, currencySymbol, start, end, pot_type){  
    
    str = str+ '<div class="invest_li"><a class="uk-accordion-title" href="#">Cashflows</a><div class="uk-accordion-content" hidden=""><p>Add and edit cashflows by selecting inflow or outflow and toggle the format of the amount (£ or %)</p><div class="table_responsive"><table class="table cashflow_table investmentcashflowrowTable solutionform_investomentgrid_table_'+t+'"><thead><tr><th>Cashflow name</th><th><div class="uk-inline objInOutFlowIndicator"></div></th><th data-uk-tooltip="" title="" aria-expanded="false" tabindex="0">Amount</th><th>Goal Seek</th><th>Type</th><th>Start</th><th>End</th><th>Indicator<div class="uk-inline objHelpIndicator"></div></th><th>Detail</th><th><span class="expandallcolms uk-icon" uk-icon="arrow-right"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" points="10 5 15 9.5 10 14"></polyline><line fill="none" stroke="#000" x1="4" y1="9.5" x2="15" y2="9.5"></line></svg></span></th><th class="hidecolmns" hidden="">Probability of shortfall</th><th class="hidecolmns" hidden="">Expected shortfall</th><th class="hidecolmns" hidden=""><span class="collapseallcolms uk-icon" uk-icon="arrow-left"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" points="10 14 5 9.5 10 5"></polyline><line fill="none" stroke="#000" x1="16" y1="9.5" x2="5" y2="9.52"></line></svg></span></th><th></th></tr></thead><tbody class="cashFlowDynamic_html_'+t+'">';
    //str = str+ getCashFlowTR();   
    
    str = str+'</tbody></table></div><div class="uk-flex cc_btns"><button type="button" class="uk-button uk-button-default uk-margin-small-top uk-border-pill uk-text-capitalize addinvestmentcashflowrow" aria-expanded="false" data-cashflowitem="'+t+'">Add cashflow</button></div></div></div>';
    return str;
}

function getCashFlowTR(response, color, inputLabel_val, amount_val, inputOutFlow_val, type, currencySymbol, start, end, pot_type ){
    var inc = 0;  //increment for array values
    var tr_inc=1; //increment for <tr> index values
    var tr_no = 1;
    var tHtml =''; total_tr =1;

  for (let ind = 0; ind<pot_type.length; ind++) { 
    for (let si = 0; si<pot_type[ind]; si++) { 
        var selected0= ''; var selected1= ''; 
        var currency0= ''; var currency1= '';
        if(inputOutFlow_val[inc] == 0){ selected0 = 'selected' }else{ selected1 = 'selected' }
        if(currencySymbol[inc] == 0){ currency0 = 'selected' }else{ currency1 = 'selected' } 
   
        tHtml= tHtml+'<tr class="light_grey" row-index="'+tr_inc+'" style="background: '+color[ind]+'" potcashflowinumber="'+tr_inc+'" data-idtypepot="'+total_tr+'" ><td><input class="uk-input uk-form-small readonlyArea investmentcashflowname" type="text" value="'+inputLabel_val[inc]+'" onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')"></td> <td class="info_select"><select class="uk-select CashflowAllarrinoutflow" onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')"><option value="0" '+selected0+'>inflow</option><option value="1" '+selected1+'>Outflow</option></select></td><td class="amount_field">      <select class="uk-select investmentcashflowcurrency" ClickcollectionAllTypeOfData(\'confirm_btn\')><option value="0" '+currency0+'>£</option><option value="1" '+currency1+'>%</option></select>        <input class="uk-input uk-form-small investmentcashflowvalue" type="text" onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')" value="'+amount_val[inc]+'"> </td>         <td  data-formtype="goalseekinfo" class="goal_icon_btn"><span uk-icon="uikit" class="goal_icon uk-icon"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polygon points="14.4,3.1 11.3,5.1 15,7.3 15,12.9 10,15.7 5,12.9 5,8.5 2,6.8 2,14.8 9.9,19.5 18,14.8 18,5.3"></polygon><polygon points="9.8,4.2 6.7,2.4 9.8,0.4 12.9,2.3"></polygon></svg></span></td>             <td><select class="uk-select CashFlowAllTypebegin Typebegin_'+tr_inc+'" onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')">   </select></td>                                                                                                 <td class="uk-width-small"><select class="uk-select LoadgoalseekprojectionAtTimelist Startbegin_'+tr_inc+'"  onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')"></select> </td>                                                                                                       <td class="uk-width-small"><select class="uk-select LoadAllTypeEndOptions Endbegin_'+tr_inc+'" onchange="ClickcollectionAllTypeOfData(\'confirm_btn\')"></select></td>              <td class="expand_icon"><div class="defaultcolor-area"></div></td><td>  <a class="selectedRating" aria-expanded="false" style="background: '+color[ind]+';"><i uk-icon="info"></i></a>  <div uk-drop="mode: click;" class="investmentcashflownamepotnamesmodel infoPopupdetailPieChart uk-card uk-card-body uk-card-default uk-drop uk-drop-bottom-right infoPopupdetailPieChart_'+tr_inc+'" data-potid="'+total_tr+'" id="infoPopupdetailPieChart_'+tr_inc+'"></div><input class="investmentcashflownamepotnames" type="hidden" value="'+total_tr+'"></td>  <td class="hidecolmns" hidden="">10%</td><td class="hidecolmns" hidden="">0</td>   <td><a href="javascript:void(0);" uk-icon="trash" class="trashsolutionform_investmentCashFlow uk-icon" data-cashflowitem="'+tr_inc+'" data-rowindexitem="1" onclick="trashsolutionform_investmentCashFlow(this);"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" points="6.5 3 6.5 1.5 13.5 1.5 13.5 3"></polyline><polyline fill="none" stroke="#000" points="4.5 4 4.5 18.5 15.5 18.5 15.5 4"></polyline><rect x="8" y="7" width="1" height="9"></rect><rect x="11" y="7" width="1" height="9"></rect><rect x="2" y="3" width="16" height="1"></rect></svg></a></td></tr>';
        if(tr_no == pot_type[ind]){
            $('.cashFlowDynamic_html_'+total_tr).append(tHtml);
            tHtml =''; total_tr++; tr_no=1;
        }else{  tr_no++;  }
    
    getCashflowTypesData(type[inc], JSON.parse(response.params[15]), tr_inc)
    getCashflowStartData(start[inc], JSON.parse(response.params[15]), tr_inc)
    getCashflowEndData(end[inc], JSON.parse(response.params[15]), tr_inc)
    inc++; tr_inc++;
  }
} 
}

function getinvestmentstrategyHeadData(type, response, t, year_arr){
    var head_start_html = '<tr><th class="currentagevalue colsIndex1">'+JSON.parse(response.params[15])+': Now</th>';
    var s_age = JSON.parse(response.params[15])
    var e_age = JSON.parse(response.params[17])
    var p_age = JSON.parse(response.params[19])
    var head_end_html = '<th class="addothercolsbefore currentprojectionagevalue">'+JSON.parse(response.params[19])+': End</th></tr>';
    var html_st = ''; 
    let measureTime ='';
    measureTime = jQuery("input[name='RadioTime']:checked").val();
    var dropdownVal = getAgeDropdown();

    var measureTxt ='';
    if(measureTime == 'CalendarYears'){
         measureTxt ='from ';
    }else if(measureTime == 'Time'){
        measureTxt ='In year ';
    }
    Last_value =2; u =2;
    
    for (let index = 1; index < year_arr.length; index++) {
        op_val =1; 
        html_st+='<th class="center_head colsIndex'+u+'" cols-index="'+u+'"><select class="uk-select node_select"  id="idDatePicker_'+parseInt(index + 1)+'" onchange="changeGRIDSelectDates('+parseInt(index + 1)+', '+t+')">';

   
        for (let index1 = 0; index1 < dropdownVal.length; index1++) {
            if(Last_value > index1){
                html_st += '<option value="' + index1 + '" hidden="hidden" disabled> ' + dropdownVal[index1] + '</option>';
            }else{
                if(index1 == year_arr[index]){
                    html_st += '<option value="' + index1 + '" selected>'+measureTxt+ dropdownVal[index1] + '</option>';
                }else{
                    html_st += '<option value="' + index1 + '">'+measureTxt+ dropdownVal[index1] + '</option>';

                }
            }
        }
        Last_value++;
       
         html_st +='</select> <a href="javascript: void(0);" uk-icon="minus-circle" class="trashStrategyAddedColumn uk-icon" data-cashflowitem="'+t+'" data-rowindexitem="'+index+'" onclick="trashStrategyAddedColumn(this);"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle><line fill="none" stroke="#000" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg></a></th>';  
        u++;      
    }

    jQuery("table thead.strategy_head_html_"+t).html(head_start_html+html_st+head_end_html);  
}

jQuery(document).on("click", function(event){
    var $trigger = jQuery(".custom_background ");
    if($trigger !== event.target && !$trigger.has(event.target).length){
        jQuery(".investmentstrategy_lists").slideUp("fast");
    }            
});


function addhoverclass(inc, val){
    jQuery("#solutionform_investomentgrid_"+inc+" .investmentstrategy_lists .uk-nav p.uk-nav-header").addClass("invest-head");
    //jQuery("#solutionform_investomentgrid_"+inc+" .investmentstrategy_lists .uk-nav p").
    if(parseInt(val) > 0){
        jQuery("#solutionform_investomentgrid_"+inc+" .investmentstrategy_lists .uk-nav ").find('p').attr("onclick", "unselectItem(this, '"+val+"')");
    }
    

    jQuery(".investmentstrategy_lists").hide();

  // jQuery("#solutionform_investomentgrid_"+inc+" .colsIndex"+val+" .investmentstrategy_lists").dropdown('toggle');
   //UIkit.dropdown(jQuery("#solutionform_investomentgrid_"+inc+" .colsIndex"+val+" .investmentstrategy_lists")).show(200);   
    jQuery("#solutionform_investomentgrid_"+inc+" .colsIndex"+val+" .investmentstrategy_lists").show();   

}

function unselectItem(element, index){
    var item = jQuery(element).find('a').attr("data-list");
    var dvalue = jQuery(element).find('a').attr("data-value");

    var s_color = jQuery("#solutionform_investomentgrid_"+item+" .investmentstrategy_lists .uk-nav p.invest-head").attr("data-color");

    jQuery("#solutionform_investomentgrid_"+item+" .colsIndex"+index+" .investmentstrategy_lists .uk-nav p a").removeClass('selected');
    jQuery("#solutionform_investomentgrid_"+item+" .colsIndex"+index+" .investmentstrategy_lists .uk-nav p a").css('background-color', 'white');
    jQuery("#solutionform_investomentgrid_"+item+" .colsIndex"+index+" .investmentstrategy_lists .uk-nav p").find("a[data-value='"+dvalue+"']").addClass('selected').css("background-color", s_color);
    jQuery(this).find("a").css("background-color", s_color);


 

   //jQuery("#solutionform_investomentgrid_"+inc+" .colsIndex"+index+" .investmentstrategy_lists").stop().slideToggle(500);  
   jQuery("#solutionform_investomentgrid_"+item+" .colsIndex"+index+" .investmentstrategy_lists").hide();
 
}

jQuery(document).on('mouseenter','.investmentstrategy_lists .uk-nav p', function (event) {
    //console.log("mouseenter Event:: ", event);
   // console.log("mouseenter Event target:: ", event.target);
    var ind = jQuery(event.target).attr("data-list");
    var s_color = jQuery("#solutionform_investomentgrid_"+ind+" .investmentstrategy_lists .uk-nav p.invest-head").attr("data-color");
    
    if( !jQuery(this).find("a").hasClass("selected")){
        jQuery(this).find("a").css("background-color", s_color);
    }        
}).on('mouseleave','.investmentstrategy_lists .uk-nav p',  function(){
    if( !jQuery(this).find("a").hasClass("selected")){
        jQuery(this).find("a").css("background-color", 'white');
    }
});

//get value of strategy dropdown
function getinvestmentstrategyData(type, t, color, response_age, year_arr){   
    //Stragetgy head html
    var getinvestmentstrategyHtml ='';
    jQuery.ajax({
        method: "POST",
        url: base_url + controller + '/getinvestmentstrategyData',
        data: {val: JSON.stringify(type), inc: t, color: color  },
        dataType: "html",
        success: function(response) {
            jQuery(".mainStr_html_"+t).html(response ); 
            getinvestmentstrategyHeadData(type, response_age, t, year_arr); 
        }
    })
    return getinvestmentstrategyHtml;
}

//get value of cashFlowTypes
function getCashflowTypesData(type, age, t){    
    var cashFlowTypesHtml ='';
    jQuery.ajax({
        method: "POST",
        url: base_url + controller + '/getCashflowTypesData',
        data: { value: type, age: age  },
        dataType: "html",
        success: function(response) {
            jQuery(".Typebegin_"+t).html(response);  
        }
    })
    return cashFlowTypesHtml;
}

//get value of cashFlow start data
function getCashflowStartData(start, age, t){    
    var cashFlowStartHtml ='';
    var measureTime ='';
    measureTime = jQuery("input[name='RadioTime']:checked").val();
    jQuery.ajax({
        method: "POST",
        url: base_url + controller + '/getCashflowStartData',
        data: { value: start, age: age, measureTime: measureTime },
        dataType: "html",
        success: function(response) {
            jQuery(".Startbegin_"+t).html(response);  
        }
    })
    return cashFlowStartHtml;
}

//get value of cashFlow end data
function getCashflowEndData(end, age, t){    
    var cashFlowEndHtml ='';
    jQuery.ajax({
        method: "POST",
        url: base_url + controller + '/getCashflowEndData',
        data: { value: end, age: age  },
        dataType: "html",
        success: function(response) {
            jQuery(".Endbegin_"+t).html(response);  
        }
    })
    return cashFlowEndHtml;
}



function splitsolnParameters_db(ParametersCF) {
    let getsolnparameters = JSON.parse(decodeURIComponent(ParametersCF));
    if (typeof getsolnparameters.LastSclrSolveInput === "undefined") {
        LastSclrSolveInput = 0;
    } else {
        LastSclrSolveInput = getsolnparameters.LastSclrSolveInput;
    }
    return LastSclrSolveInput;
}

function GoalSeekPotValue_fn() {
    let GoalSeekPotValue = [];
    return GoalSeekPotValue;
}

function collectStrategyLifestyleData() {
    let PotOptions = jQuery('.solutiongoalseekinfo_potlist select').children('option').length - 1;
    for (iControl = 0; iControl < PotOptions; iControl++) {
        if (iControl == 0 || iControl == 1) {
            var idStrategySeekPot = 0;
        } else {
            var idStrategySeekPot = 0;
        }
        StrategyOptimisationMax[iControl] = Number(idStrategySeekPot) + 1;
    }
    return StrategyOptimisationMax;
}

function SliderAgeOnInput() {
    document.getElementById("Age_value").value = document.getElementById("Age_slider").value;
    document.getElementById("Retirement_value").value = document.getElementById("Retirement_slider").value;
    document.getElementById("Horizon_value").value = document.getElementById("Horizon_slider").value;
}

function UpdateAgeInputsBoxes(Type, ID_value, ID_slider, txtTimeType) {
    sclrAge = Math.max(Math.min(parseInt(document.getElementById("Age_value").value), window.sclrGlobalMaxAge - 4), 16);
    document.getElementById("Age_value").value = sclrAge;
    sclrRetirement = Math.max(Math.min(parseInt(document.getElementById("Retirement_value").value), window.sclrGlobalMaxAge - 2), 50);
    document.getElementById("Retirement_value").value = sclrRetirement;
    sclrProjectionHorizon = Math.max(Math.min(parseInt(document.getElementById("Horizon_value").value), window.sclrGlobalMaxAge), 16);
    if (sclrProjectionHorizon - sclrAge < 5) {
        sclrProjectionHorizon = sclrAge + 5;
    }
    document.getElementById("Horizon_value").value = sclrProjectionHorizon;
    document.getElementById("Age_slider").value = document.getElementById("Age_value").value;
    document.getElementById("Retirement_slider").value = document.getElementById("Retirement_value").value;
    document.getElementById("Horizon_slider").value = document.getElementById("Horizon_value").value;
    if (Type == "TypeAge") {
        rebuilddropdown();
        ClickcollectionAllTypeOfData('confirm_btn');
    } else {
        ClickcollectionAllTypeOfData('confirm_btn');
    };
};

function rebuilddropdown() {
    let agevalue = document.getElementById("Age_value").value;
    let url = base_url + controller + '/rebuilddropdown?agevalue=' + agevalue;
    jQuery.getJSON(url, function(response) {
        showDropdownList('LoadgoalseekprojectionAtTimelist', response.params.agedropdown);
    });
}

function SliderAgeOnDrop(Type, ID_value, ID_slider, txtTimeType) {
    UpdateAgeInputsBoxes(Type, ID_value, ID_slider, txtTimeType);
}

function showDropdownList(classname, data) {
    jQuery('.' + classname).empty();
    //jQuery('.' + classname).prepend("<option value='' selected='selected'>Choose</option>");
    var increment = 0;
    jQuery.each(data, function(val, text) {
        if ('LoadAllTypebegin' == classname) {
            jQuery('.' + classname).append(
                jQuery('<option title="' + text + '"></option>').val(increment).html(val)
            );
        } else {
            jQuery('.' + classname).append(
                jQuery('<option></option>').val(val).html(text)
            );
        }
        increment++;
    });
}

function ToggleErrorMessage(selector) {
    jQuery('.' + selector).removeAttr('style');
    jQuery('.' + selector).delay(3000).fadeOut('slow');
}
jQuery.getScript(base_url + "assets/dash/js/cashflow-chart-extra-functions.js");