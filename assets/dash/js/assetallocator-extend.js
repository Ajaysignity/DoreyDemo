function OnLoadDefaultAllocatorData() {
    let currentdate = new Date().toISOString().split('T')[0];
    let txtSessionIDtxtUserID = document.getElementById("txtSessionIDtxtUserID").value.split('::');
    var assetobj = { "nargout": 1, "rhs": ['txtAction', 'Initialise', 'txtOrganisationID', txtSessionIDtxtUserID[2], 'txtDateSelected', currentdate, 'txtCurrencySelected', '£', 'txtSessionID', txtSessionIDtxtUserID[0], 'txtUserID', txtSessionIDtxtUserID[1]] };
    jQuery.ajax({
        url: base_url + controller + '/SaveAllocatorDataInfo',
        data: { ajax: true, type: 'initials', parameters: (JSON.stringify(assetobj)) },
        method: 'POST',
        async: true,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        success: function(result) {
            console.log('Api run successfully!!');
        }
    });
}

jQuery(document).on('change', '.AssumptionSelectContainer select', function() {
    let txtSessionIDtxtUserID = document.getElementById("txtSessionIDtxtUserID").value.split('::');
    jQuery.ajax({
        url: base_url + controller + '/PortfoliosSelectContainerByAssumption',
        data: { token: txtSessionIDtxtUserID[2], ajax: true, key: jQuery(this).val(), version: new Date().toISOString().split('T')[0] },
        method: 'POST',
        async: true,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        beforeSend: function() {
            jQuery('.RegeneratePortfolioStrategy').html('<span uk-icon="icon: refresh" class="uk-spinner"></span>');
            jQuery('.PortfoliosSelectContainerByAssumption select').html('<option>loading please wait for a while..........</option>');
        },
        success: function(response) {
            jQuery('.RegeneratePortfolioStrategy').html('');
            jQuery('.InitialiseApidata').val(JSON.stringify(response));
            let options = '';
            jQuery(response.PortfolioNames).each(function(index, value) {
                options += '<option value="' + value.pair + '">' + value.pair + '</option>';
            });
            jQuery('.PortfoliosSelectContainerByAssumption select').html(options);
        }
    });
});
if (controller.includes("assetallocator") && ActiveMethod.includes("index") ) {
    setTimeout(function() {
        OnLoadDefaultAllocatorData();
    }, 2000);
}

function viewclientinformation(iduserallocator) {
    let currentdate = new Date().toISOString().split('T')[0];
    jQuery.ajax({
        url: base_url + controller + '/viewclientinformation',
        data: { ajax: true, type: 'allocatorid', iduserallocator: iduserallocator, version: currentdate },
        method: 'POST',
        async: true,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        beforeSend: function() {
            jQuery('.processingspinner' + iduserallocator).attr('hidden', false);
        },
        success: function(response) {
            jQuery('.processingspinner' + iduserallocator).attr('hidden', true);
            if (response.apidata) {
                localStorage.setItem('apiresponse_graphcodedecode_' + response.iduserallocator, response.apidata);
            }
            if (response.status) {
                window.location.href = response.http_redirect;
            }
        }
    });
}
jQuery(document).on('input', '.AssetAllocatorChartColorOption', function() {
    jQuery('.AssetAllocatorChartColorOption').each(function(index) {
        ChartColorVal[index] = jQuery(this).val();
    });
    let iduserallocator = document.getElementById("iduserallocatorKey").value;
    let TypeGraph = jQuery('select.GraphAssetDropdownlistData option:selected').val();
    if ("apiresponse_graphcodedecode_" + iduserallocator in localStorage) {
        let graphcodedecode = localStorage.getItem('apiresponse_graphcodedecode_' + iduserallocator);
        LoadGraphData(JSON.parse(graphcodedecode), TypeGraph, ChartColorVal);
    }
});
jQuery(document).on('change', '.GraphAssetDropdownlistData', function() {
    TypeGraph = jQuery(this).val();
    let iduserallocator = document.getElementById("iduserallocatorKey").value;
    jQuery('.AssetAllocatorChartColorOption').each(function(index) {
        ChartColorVal[index] = jQuery(this).val();
    });

    if ("apiresponse_graphcodedecode_" + iduserallocator in localStorage) {
        let graphcodedecode = localStorage.getItem('apiresponse_graphcodedecode_' + iduserallocator);
        LoadGraphData(JSON.parse(graphcodedecode), TypeGraph, ChartColorVal);
    }
});

jQuery(document).on('input', '.CurrentAssetInputBox', function() {
    var vecCurrentPortfolio = [];
    jQuery('.CurrentAssetInputBox').each(function() {
        vecCurrentPortfolio.push(Number(jQuery(this).val()));
    });
    var NewText = (RemoveQoutes(vecCurrentPortfolio).reduce((a, b) => a + b, 0));
    jQuery(".CurrentAssetInputBoxTotal").text(NewText.toFixed(2));
});

jQuery(document).on('input', '.BespokeAssetInputBox', function() {
    var vecBespokePortfolio = [];
    jQuery('.BespokeAssetInputBox').each(function() {
        vecBespokePortfolio.push(Number(jQuery(this).val()));
    });
    var NewText = (RemoveQoutes(vecBespokePortfolio).reduce((a, b) => a + b, 0));
    jQuery(".BespokeAssetInputBoxTotal").text(NewText.toFixed(2));
});

jQuery(document).on('change', '.GraphAssetDropdownlistData', function() {
    TypeGraph = jQuery(this).val();
    let iduserallocator = document.getElementById("iduserallocatorKey").value;
    jQuery('.AssetAllocatorChartColorOption').each(function(index) {
        ChartColorVal[index] = jQuery(this).val();
    });

    if ("apiresponse_graphcodedecode_" + iduserallocator in localStorage) {
        let graphcodedecode = localStorage.getItem('apiresponse_graphcodedecode_' + iduserallocator);
        LoadGraphData(JSON.parse(graphcodedecode), TypeGraph, ChartColorVal);
    }
});

jQuery(document).on('click', '.UpdateCurrentBespokeDataAPiButton', function() {
    var RevealiTemStatus = jQuery('.reveal-items:hidden').length;
    let txtSessionIDtxtUserID = document.getElementById("txtSessionIDtxtUserID").value.split('::');
    let iduserallocator = document.getElementById("iduserallocatorKey").value;
    let tokenkey = document.getElementById("tokenkey").value;
    if (jQuery(".CurrentAssetInputBoxTotal").text() != 100) {
        APIErrorMessage('Warninig: Current total should be 100 only');
    } else if (jQuery(".BespokeAssetInputBoxTotal").text() != 100) {
        APIErrorMessage('Warninig: Tailored total should be 100 only');
    } else {
        var vecCurrentPortfolio = [];
        var vecBespokePortfolio = [];
        jQuery('.CurrentAssetInputBox').each(function() {
            vecCurrentPortfolio.push(jQuery(this).val());
        });
        jQuery('.BespokeAssetInputBox').each(function() {
            vecBespokePortfolio.push(jQuery(this).val());
        });
        jQuery.getJSON(base_url + controller + '/getCurrentTailoredData_json', { tokenkey: tokenkey, ajax: true, version: new Date(), RevealiTemStatus: RevealiTemStatus }, function(response) {
            var assetUpdateobj = { "nargout": 1, "rhs": ["txtAction", "getFullPage1Call", "txtSessionID", response.txtSessionID, "txtOrganisationID", response.txtOrganisationID, "txtUserID", response.txtUserID, "txtDataSetName", response.txtDataSetName, "txtCurrencySelected", response.txtCurrencySelected, "txtPortfolioName2Set", response.txtPortfolioName2Set, "vecCurrentPortfolio", RemoveQoutes(vecCurrentPortfolio), "vecBespokePortfolio", RemoveQoutes(vecBespokePortfolio)] };
            jQuery.ajax({
                url: base_url + controller + '/request_graphparameters_json',
                data: { ajax: true, tokenkey: tokenkey, action: 'setUpdatedCurrentPortfolio', parameters: JSON.stringify(assetUpdateobj), RevealiTemStatus: response.RevealiTemStatus },
                method: 'POST',
                async: true,
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                dataType: 'json',
                beforeSend: function() {
                    jQuery('.UpdateCurrentBespokeDataAPiButton').addClass('uk-spinner');
                },
                success: function(result) {
                    jQuery('.UpdateCurrentBespokeDataAPiButton').removeClass('uk-spinner');
                    if ("apiresponse_graphcodedecode_" + iduserallocator in localStorage) {
                        APIErrorMessage(result.lhs[0].mwdata.Message[0].mwdata[0]);
                        updateLocalStorageItem('apiresponse_graphcodedecode_' + iduserallocator, 'tbleUserIOPortfolioMixes', result.lhs[0].mwdata.tbleUserIOPortfolioMixes);
                        updateLocalStorageItem('apiresponse_graphcodedecode_' + iduserallocator, 'GraphData', result.lhs[0].mwdata.GraphData);
                        updateLocalStorageItem('apiresponse_graphcodedecode_' + iduserallocator, 'tblePortfolioStatistics', result.lhs[0].mwdata.tblePortfolioStatistics);

                        let graphcodedecode = localStorage.getItem('apiresponse_graphcodedecode_' + iduserallocator);
                        var ResultTable = generateGrphwithLocalStorage(JSON.parse(graphcodedecode));

                        jQuery('.assetallocator-dashboard').find('.AssetClassesAllocationTableGrid').html(ResultTable.AssetClassesTable);
                        jQuery('.assetallocator-dashboard').find('.PortfolioClassesAllocationTableGrid').html(ResultTable.PortfolioTable);
                        jQuery('.assetallocator-dashboard').find('.GraphAssetDropdownlistData').html(ResultTable.GraphDropdownlist);

                        ResetGroupColmnHeaderTop();
                        console.log('ResetGroupColmnHeaderTop loaded');
                    }
                    if (response.RevealiTemStatus == 0) {
                        jQuery('.reveal-items').removeAttr('hidden');
                    }
                }
            });
        });
    }
});

jQuery(document).ready(function() {
    let MainDashboard = jQuery('.assetallocator-dashboard');
    if (controller == 'assetallocator' && ActiveMethod == 'clientinformation') {
        let iduserallocator = document.getElementById("iduserallocatorKey").value;
        if ("apiresponse_graphcodedecode_" + iduserallocator in localStorage) {
            let graphcodedecode = localStorage.getItem('apiresponse_graphcodedecode_' + iduserallocator);
            let ResponseApiParse = JSON.parse(graphcodedecode);
            if (ResponseApiParse.lhs[0].mwdata.hasOwnProperty('tbleUserIOPortfolioMixes')) {
                var ResultTable = generateGrphwithLocalStorage(ResponseApiParse);
                MainDashboard.find('.AssetClassesAllocationTableGrid').html(ResultTable.AssetClassesTable);
                MainDashboard.find('.PortfolioClassesAllocationTableGrid').html(ResultTable.PortfolioTable);
                MainDashboard.find('.GraphAssetDropdownlistData').html(ResultTable.GraphDropdownlist);
            } else {
                let ErrorMessage = ResponseApiParse.lhs[0].mwdata.Message[0].mwdata[0];
                if (ErrorMessage.indexOf('NoSessionIDInCache') != -1) {
                    APIErrorMessage(ErrorMessage + ':: ' + ' Initialising API again... please wait for few seconds');
                    let txtSessionIDtxtUserID = document.getElementById("txtSessionIDtxtUserID").value.split('::');
                    var assetobj = { "nargout": 1, "rhs": ['txtAction', 'Initialise', 'txtOrganisationID', txtSessionIDtxtUserID[2], 'txtDateSelected', '18/07/2023', 'txtCurrencySelected', '£', 'txtSessionID', txtSessionIDtxtUserID[0], 'txtUserID', txtSessionIDtxtUserID[1]] };
                    jQuery.ajax({
                        url: base_url + controller + '/request_graphparameters_json',
                        data: { type: 'reInitialise', idallocator: iduserallocator, ajax: true, tokenkey: '', parameters: JSON.stringify(assetobj) },
                        method: 'POST',
                        async: true,
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        dataType: 'json',
                        success: function(result) {
                            localStorage.setItem('apiresponse_graphcodedecode_' + iduserallocator, JSON.stringify(result));
                            window.location.reload(true);
                        }
                    });
                } else {
                    APIErrorMessage(ErrorMessage);
                }
            }
        }
    }
    var topMatchTd;
    var previousValue = "";
    var rowSpan = 1;
    jQuery('.AssetClassesAllocationTableGrid').find('td.assetGroupnamebindings').each(function() {
        if (jQuery(this).text() == previousValue) {
            rowSpan++;
            jQuery(topMatchTd).attr('rowspan', rowSpan);
            jQuery(this).remove();
        } else {
            topMatchTd = jQuery(this);
            rowSpan = 1;
        }
        previousValue = jQuery(this).text();
    });
});


function LoadGraphData(t, e = "", a = "") {
    (TOutputHtml = ""), (DefaultGraphOptions = "");
    let o = t.lhs[0].mwdata.GraphData[0].mwdata,
        s = Object.keys(o)[0];
    "" != e && (s = e);
    let r = "" != a ? a : defaultColor();
    return (
        jQuery.each(o, function(t, o) {
            if (((DefaultGraphOptions += '<option value="' + t + '">' + t + "</option>"), s == t)) {
                ChartDynamicColorSet(o, r), o[0].mwdata.txtTitle[0].mwdata[0];
                let l = o[0].mwdata.txtXLabel[0].mwdata[0],
                    i = o[0].mwdata.txtYLabel[0].mwdata[0];
                if ("RiskRet" === e)
                    var n = o[0].mwdata.vecXData[0].mwdata,
                        d = o[0].mwdata.mxData[0],
                        c = o[0].mwdata.Points[0].mwdata.y_Return[0].mwdata,
                        p = o[0].mwdata.Points[0].mwdata.Name[0].mwdata,
                        u = [
                            { label: "", data: d.mwdata, fill: !1, borderColor: "#f0d156" },
                            { label: "", data: c, fill: !1, pointRadius: 12, pointHoverRadius: 14, pointBackgroundColor: r, borderColor: "#fff", pointStyle: "circle", pointLabels: { labels: p } },
                        ],
                        h = { y: { type: "linear", title: { display: !0, text: i } }, x: { type: "linear", title: { display: !0, text: l } } },
                        m = !0,
                        f = n.map(function(t) {
                            return Math.round(t);
                        }),
                        $ = RiskSetCustomToolTipText;
                else {
                    var m = !1;
                    let g = o[0].mwdata.vecXData[0].mwdata.TimeStamp.mwdata;
                    var d = o[0].mwdata,
                        f = getDataSetlLoop(g, "timestamp"),
                        u = PrintLineDataValue(d, a),
                        h = { y: { title: { display: !0, text: i } }, x: { title: { display: !0, text: l } } },
                        $ = FooterCustomToolTipText;
                }
                if (null != document.getElementById("assetallocator_grapgdata")) {
                    let v = document.getElementById("assetallocator_grapgdata").getContext("2d");
                    void 0 != window.mixedChart && window.mixedChart.destroy(),
                        (window.mixedChart = new Chart(v, {
                            type: "line",
                            data: { labels: f, datasets: u },
                            options: {
                                legend: { display: !0 },
                                tooltips: { enabled: m },
                                title: { display: !0, text: t },
                                scales: h,
                                plugins: { tooltip: { callbacks: { footer: $ } }, title: { display: !0, text: t, color: "navy", position: "top", align: "center", font: { weight: "bold" }, padding: 8, fullSize: !0 } },
                                animation: {
                                    onComplete(t) {
                                        "RiskRet" === e &&
                                            (t.chart.data.datasets.forEach(function(e, a) {
                                                e.hasOwnProperty("pointStyle") &&
                                                    e.data.forEach(function(a, o) {
                                                        var s = e.pointLabels.labels[o],
                                                            r = t.chart.data.labels[o],
                                                            l = t.chart.scales.y.getPixelForValue(a),
                                                            i = t.chart.scales.x.getPixelForValue(r);
                                                        window.mixedChart.ctx.fillText(s, i, l - 15);
                                                    });
                                            }));
                                    },
                                },
                            },
                        }));
                }
            }
        }), { GraphDatalist: TOutputHtml, SelectOptions: DefaultGraphOptions }
    );
}

function Advanced_TypeTable(AssetClassNamesWithDatas) {
    let tablecolumdata = JSON.parse(AssetClassNamesWithDatas.Table[0].mwdata[0]);

    FOutputHtml = '<table class="uk-table uk-table-striped uk-table-small uk-table-hover Advanced_TypeTable">';
    FOutputHtml += '<thead>';
    FOutputHtml += '<tr>';
    FOutputHtml += '<th rowspan="2"><a href="javascript:void(0);" class="uk-icon-button uk-margin-small-right uk-button-primary UpdateCurrentBespokeDataAPiButton" uk-icon="refresh" style="color: #fff;float: left;" data-type="bespoke"></a><a href="javascript:void(0);" class="uk-icon-button" uk-icon="code" uk-toggle="target: .reveal-items; animation: uk-animation-slide-left; duration: 300" style="float: right;"></a></th>';
    FOutputHtml += '<th></th>';
    FOutputHtml += '<th></th>';
    FOutputHtml += '<th class="reveal-items" hidden></th>';
    FOutputHtml += '<th class="reveal-items" hidden></th>';
    FOutputHtml += '<th class="reveal-items" hidden></th>';
    FOutputHtml += '<th class="reveal-items" hidden></th>';
    FOutputHtml += '<th class="reveal-items" hidden></th>';
    FOutputHtml += '</tr>';
    FOutputHtml += '<tr>';
    for (nCol = 0; nCol < AssetClassNamesWithDatas.ColName[0].mwdata.length; nCol++) {
        FOutputHtml += '<th ' + (nCol == 0 || nCol == 1 || nCol == 2 ? '' : 'class="reveal-items" hidden') + '>' + AssetClassNamesWithDatas.ColName[0].mwdata[nCol].mwdata[0] + '</th>';
    }
    FOutputHtml += '</tr>';
    FOutputHtml += '</thead>';
    FOutputHtml += '<tbody>';
    let CurrentTotals = 0;
    let SuggestedTotals = 0;
    let BespokeTotals = 0;
    let CurrentColsName;
    var GroupHeadCommon = {};
    let ColspanArray = Array();

    for (nRow = 0; nRow < AssetClassNamesWithDatas.GroupName[0].mwdata.length; nRow++) {
        ColspanArray.push(AssetClassNamesWithDatas.GroupName[0].mwdata[nRow].mwdata[0]);
    }
    for (var i = 0; i < ColspanArray.length; i++) {
        var key = ColspanArray[i];
        GroupHeadCommon[key] = (GroupHeadCommon[key]) ? GroupHeadCommon[key] + 1 : 1;
    }
    Object.keys(GroupHeadCommon).forEach(function(key, index) {
        let CurrentColSum = 0;
        let TailoredColsName = 0;
        let SuggestedColsName = 0;
        let rowSums = [];

        FOutputHtml += '<tr class="groupnames">';
        FOutputHtml += '<td colspanf="' + AssetClassNamesWithDatas.ColName[0].mwdata.length + '"><b>' + key + '</b></td>';
        for (nCol = 0; nCol < AssetClassNamesWithDatas.ColName[0].mwdata.length; nCol++) {
            FOutputHtml += '<td ' + (nCol == 0 || nCol == 1 || nCol == 2 ? '' : 'class="reveal-items" hidden') + ' data-nCol="' + nCol + '"><span class="GetGroupCurrentColsHeaderColVal_' + index + '_' + nCol + '">-</span></td>';
        }
        FOutputHtml += '</tr>';
        for (nRowAd = 0; nRowAd < AssetClassNamesWithDatas.RowName[0].mwdata.length; nRowAd++) {
            if (AssetClassNamesWithDatas.GroupNumber[0].mwdata[nRowAd] == index + parseInt(1)) {
                FOutputHtml += '<tr class="subgroupnames ' + (parseInt(index) + parseInt(1)) + '">';
                FOutputHtml += '<td>' + AssetClassNamesWithDatas.RowName[0].mwdata[nRowAd].mwdata[0] + '</td>';
                let OtherColsSumVal = [];
                for (nCols = 0; nCols < AssetClassNamesWithDatas.ColName[0].mwdata.length; nCols++) {
                    CurrentColsName = AssetClassNamesWithDatas.ColName[0].mwdata[nCols].mwdata[0];
                    if (AssetClassNamesWithDatas.GroupNumber[0].mwdata[nRowAd] == index + parseInt(1)) {
                        OtherColsSumVal.push(parseInt(tablecolumdata[nRowAd][CurrentColsName]));
                    }
                    if (CurrentColsName === 'Current') {
                        if (AssetClassNamesWithDatas.GroupNumber[0].mwdata[nRowAd] == index + parseInt(1)) {
                            CurrentColSum = (parseInt(CurrentColSum) + parseInt(tablecolumdata[nRowAd][CurrentColsName]));
                        }
                        FOutputHtml += '<td><input value="' + tablecolumdata[nRowAd][CurrentColsName].toFixed(2) + '" class="uk-input uk-form-small CurrentAssetInputBox" data-action="setUpdatedCurrentPortfolio"></td>';
                    } else if (CurrentColsName === 'Tailored') {
                        if (AssetClassNamesWithDatas.GroupNumber[0].mwdata[nRowAd] == index + parseInt(1)) {
                            TailoredColsName = (parseInt(TailoredColsName) + parseInt(tablecolumdata[nRowAd][CurrentColsName]));
                        }
                        FOutputHtml += '<td><input value="' + tablecolumdata[nRowAd][CurrentColsName].toFixed(2) + '" class="uk-input uk-form-small BespokeAssetInputBox" data-action="setUpdatedBespokePortfolio"></td>';
                    } else if (CurrentColsName === 'Suggested') {
                        if (AssetClassNamesWithDatas.GroupNumber[0].mwdata[nRowAd] == index + parseInt(1)) {
                            SuggestedColsName = (parseInt(SuggestedColsName) + parseInt(tablecolumdata[nRowAd][CurrentColsName]));
                        }
                        FOutputHtml += '<td>' + tablecolumdata[nRowAd][CurrentColsName].toFixed(2) + '</td>';
                    } else {
                        FOutputHtml += '<td id="' + index + '_' + nCols + '"  ' + (nCols == 0 || nCols == 1 || nCols == 2 ? 'class="EachSubgroupColmnDataValue"' : 'class="EachSubgroupColmnDataValue reveal-items" hidden') + '>' + tablecolumdata[nRowAd][CurrentColsName].toFixed(2) + '</td>';
                    }
                }
                CurrentTotals = (CurrentTotals + tablecolumdata[nRowAd].Current);
                SuggestedTotals = (SuggestedTotals + tablecolumdata[nRowAd].Suggested);
                BespokeTotals = (BespokeTotals + tablecolumdata[nRowAd].Tailored);
                FOutputHtml += '</tr>';
                rowSums.push(OtherColsSumVal);
            }
        }
        FOutputHtml += '<tr class="totalofeachgroup" hidden>';
        FOutputHtml += '<td style="background: #fff;"></td>';
        for (nCols = 0; nCols < AssetClassNamesWithDatas.ColName[0].mwdata.length; nCols++) {
            if (AssetClassNamesWithDatas.ColName[0].mwdata[nCols].mwdata[0] === 'Current') {
                FOutputHtml += '<td><span class="MainGroupCurrentColsHeaderValClass"  id="' + index + '_' + nCols + '">' + CurrentColSum.toFixed(2) + '</span></td>';
            } else if (AssetClassNamesWithDatas.ColName[0].mwdata[nCols].mwdata[0] === 'Suggested') {
                FOutputHtml += '<td><span class="MainGroupCurrentColsHeaderValClass" id="' + index + '_' + nCols + '">' + SuggestedColsName.toFixed(2) + '</span></td>';
            } else if (AssetClassNamesWithDatas.ColName[0].mwdata[nCols].mwdata[0] === 'Tailored') {
                FOutputHtml += '<td><span class="MainGroupCurrentColsHeaderValClass" id="' + index + '_' + nCols + '">' + TailoredColsName.toFixed(2) + '</span></td>';
            } else {
                FOutputHtml += '<td ' + (nCols == 0 || nCols == 1 || nCols == 2 ? '' : 'class="reveal-items" hidden') + '"></td>';
            }
        }
        FOutputHtml += '</tr>';
    });
    FOutputHtml += '</tbody>';
    FOutputHtml += '<tfoot>';
    FOutputHtml += '<tr><td>Total</td><td><span class="CurrentAssetInputBoxTotal">' + CurrentTotals.toFixed(2) + '</span><td><span ' + SuggestedTotals + ' class="SuggestedAssetInputBoxTotal"></span></td><td><span class="BespokeAssetInputBoxTotal">' + BespokeTotals.toFixed(2) + '</span></td><td class="reveal-items" hidden></td><td class="reveal-items" hidden></td><td class="reveal-items" hidden></td><td class="reveal-items" hidden></td><td colspan="15" class="reveal-items" hidden></td></tr>';
    FOutputHtml += '</tfoot>';
    FOutputHtml += '</table>';
    return FOutputHtml;
}
function Standrad_TypeTable(AssetClassNamesWithDatas) {
    let tablecolumdata = JSON.parse(AssetClassNamesWithDatas.Table[0].mwdata[0]);
    FOutputHtml = '<table class="uk-table uk-table-striped uk-table-small uk-table-hover Standrad_TypeTable">';
    FOutputHtml += '<thead>';
    FOutputHtml += '<tr>';
    FOutputHtml += '<th rowspan="2"><a href="javascript:void(0);" class="uk-icon-button uk-margin-small-right uk-button-primary UpdateCurrentBespokeDataAPiButton" uk-icon="refresh" style="color: #fff;float: left;" data-type="bespoke"></a><a href="javascript:void(0);" class="uk-icon-button" uk-icon="code" uk-toggle="target: .reveal-items; animation: uk-animation-slide-left; duration: 300" style="float: right;"></a></th>';
    FOutputHtml += '<th></th>';
    FOutputHtml += '<th></th>';
    FOutputHtml += '<th class="reveal-items" hidden></th>';
    FOutputHtml += '<th class="reveal-items" hidden></th>';
    FOutputHtml += '<th class="reveal-items" hidden></th>';
    FOutputHtml += '<th class="reveal-items" hidden></th>';
    FOutputHtml += '<th class="reveal-items" hidden></th>';
    FOutputHtml += '</tr>';
    FOutputHtml += '<tr>';
    for (nCol = 0; nCol < AssetClassNamesWithDatas.ColName[0].mwdata.length; nCol++) {
        FOutputHtml += '<th ' + (nCol == 0 || nCol == 1 || nCol == 2 ? '' : 'class="reveal-items" hidden') + ' data-nCol="' + nCol + '">' + AssetClassNamesWithDatas.ColName[0].mwdata[nCol].mwdata[0] + '</th>';
    }
    FOutputHtml += '</tr>';
    FOutputHtml += '</thead>';
    FOutputHtml += '<tbody>';
    let CurrentTotals = 0;
    let SuggestedTotals = 0;
    let BespokeTotals = 0;
    let CurrentColsName;

    for (nRow = 0; nRow < AssetClassNamesWithDatas.RowName[0].mwdata.length; nRow++) {
        FOutputHtml += '<tr>';
        FOutputHtml += '<td>' + AssetClassNamesWithDatas.RowName[0].mwdata[nRow].mwdata[0] + '</td>';
        for (nCols = 0; nCols < AssetClassNamesWithDatas.ColName[0].mwdata.length; nCols++) {
            CurrentColsName = AssetClassNamesWithDatas.ColName[0].mwdata[nCols].mwdata[0];
            if (CurrentColsName === 'Current') {
                FOutputHtml += '<td><input value="' + tablecolumdata[nRow][CurrentColsName].toFixed(2) + '" class="uk-input uk-form-small CurrentAssetInputBox" data-action="setUpdatedCurrentPortfolio"></td>';
            } else if (CurrentColsName === 'Tailored') {
                FOutputHtml += '<td><input value="' + tablecolumdata[nRow][CurrentColsName].toFixed(2) + '" class="uk-input uk-form-small BespokeAssetInputBox" data-action="setUpdatedBespokePortfolio"></td>';
            } else {
                FOutputHtml += '<td ' + (nCols == 0 || nCols == 1 || nCols == 2 ? '' : 'class="reveal-items" hidden') + '>' + tablecolumdata[nRow][CurrentColsName].toFixed(2) + '</td>';
            }
        }
        CurrentTotals = (CurrentTotals + tablecolumdata[nRow].Current);
        SuggestedTotals = (SuggestedTotals + tablecolumdata[nRow].Suggested);
        BespokeTotals = (BespokeTotals + tablecolumdata[nRow].Tailored);
        FOutputHtml += '</tr>';
    }
    FOutputHtml += '</tbody>';
    FOutputHtml += '<tfoot>';
    FOutputHtml += '<tr><td>Total</td><td><span class="CurrentAssetInputBoxTotal">' + CurrentTotals.toFixed(2) + '</span><td><span ' + SuggestedTotals + ' class="SuggestedAssetInputBoxTotal"></span></td><td><span class="BespokeAssetInputBoxTotal">' + BespokeTotals.toFixed(2) + '</span></td><td class="reveal-items" hidden></td><td class="reveal-items" hidden></td><td class="reveal-items" hidden></td><td class="reveal-items" hidden></td><td colspan="15" class="reveal-items" hidden></td></tr>';
    FOutputHtml += '</tfoot>';
    FOutputHtml += '</table>';
    return FOutputHtml;
}

function PortfolioStatisticsWithDatas_Table(PortfolioStatisticsWithDatas) {
    let TablePortfolioStat = JSON.parse(PortfolioStatisticsWithDatas.Table[0].mwdata[0]);
    let SOutputHtml = '<table class="uk-table uk-table-striped uk-table-small uk-table-hover">';
    SOutputHtml += '<thead>';
    SOutputHtml += '<tr>';
    SOutputHtml += '<th></th>';
    for (nCol = 0; nCol < PortfolioStatisticsWithDatas.ColumnName[0].mwdata.length; nCol++) {
        SOutputHtml += '<th ' + (nCol == 0 || nCol == 1 ? '' : 'class="reveal-items" hidden') + '>' + PortfolioStatisticsWithDatas.ColumnName[0].mwdata[nCol].mwdata[0] + '</th>';
    }
    SOutputHtml += '</tr>';
    SOutputHtml += '</thead>';
    SOutputHtml += '<tbody>';
    for (nRow = 0; nRow < PortfolioStatisticsWithDatas.RowName[0].mwdata.length; nRow++) {
        SOutputHtml += '<tr>';
        SOutputHtml += '<td>' + PortfolioStatisticsWithDatas.RowName[0].mwdata[nRow].mwdata[0] + '</td>';
        SOutputHtml += '<td>' + RoundNumbers(TablePortfolioStat[nRow].Current) + '</td>';
        SOutputHtml += '<td>' + RoundNumbers(TablePortfolioStat[nRow].Suggested) + '</td>';
        SOutputHtml += '<td class="reveal-items" hidden>' + RoundNumbers(TablePortfolioStat[nRow].Tailored) + '</td>';
        SOutputHtml += '</tr>';
    }
    SOutputHtml += '</tbody>';
    SOutputHtml += '</table>';
    return SOutputHtml;
}

