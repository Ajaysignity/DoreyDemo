var ChartColorVal = ["#f0d156", "#e6f09e", "#a8d4ed", "#e21da3", "#75e18b", "#4ae1d1"];

function FooterCustomToolTipText(tooltipItems) {
    return '';
}

function RemoveQoutes(Strings) {
    if (Strings != '') {
        let d = JSON.stringify(Strings).replace(/\"/g, "");
        return JSON.parse(d);
    }
}

function ResetGroupColmnHeaderTop() {
    console.log('ResetGroupColmnHeaderTop loaded');
    var SumEachGroup = '';
    jQuery('.MainGroupCurrentColsHeaderValClass').each(function() {
        SumEachGroup = jQuery('#' + jQuery(this).attr('id')).text();
        jQuery('.GetGroupCurrentColsHeaderColVal_' + jQuery(this).attr('id')).html('<b>' + SumEachGroup + '</b>');
    });
}

function APIErrorMessage(APIerrMessage) {
    UIkit.notification({ message: 'Warning: ' + APIerrMessage, pos: 'top-center', status: 'warning', timeout: 5000 });
}
function updateLocalStorageItem(t, e, a) {
    var o = JSON.parse(localStorage.getItem(t));
    (o.lhs[0].mwdata[e] = a), localStorage.setItem(t, JSON.stringify(o));
}
function generateGrphwithLocalStorage(ResponseApi) {
    let AssetClassNamesWithDatas = ResponseApi.lhs[0].mwdata.tbleUserIOPortfolioMixes[0].mwdata;
    let PortfolioStatisticsWithDatas = ResponseApi.lhs[0].mwdata.tblePortfolioStatistics[0].mwdata;
    let UserIOPortfolioMixesType = AssetClassNamesWithDatas.Type[0].mwdata[0];
    let FOutputHtml;
    if (UserIOPortfolioMixesType == 'Advanced') {
        FOutputHtml = Advanced_TypeTable(AssetClassNamesWithDatas);
    } else {
        FOutputHtml = Standrad_TypeTable(AssetClassNamesWithDatas);
    }
    SOutputHtml = PortfolioStatisticsWithDatas_Table(PortfolioStatisticsWithDatas);
    TOutputHtml = LoadGraphData(ResponseApi);
    return { AssetClassesTable: FOutputHtml, PortfolioTable: SOutputHtml, GraphDropdownlist: TOutputHtml.SelectOptions };
}
function PrintLineDataValue(graphparams, ColorVal = '') {
    let LegendTitle = graphparams.LegendTitle[0].mwdata;
    let graphYaxiesDataSize = graphparams.mxData[0];
    parameters = convertMWArray(graphYaxiesDataSize);
    let datasets = [];
    jQuery.each(parameters, function(key, linesdata) {
        let datavals = [];
        jQuery.each(linesdata, function(datakey, dataval) {
            datavals[datakey] = (dataval == 'NaN' ? 0 : dataval.toFixed(2));
        });
        let ChartColor = (ColorVal != '' ? ColorVal[key] : defaultColor(key));
        datasets[key] = {
            'data': datavals,
            'label': LegendTitle[key],
            'borderColor': ChartColor,
            'fill': false
        };
    });
    return datasets;
}
function convertMWArray(mxArrayIn) {
    let vecSize = mxArrayIn.mwsize;
    let mxOutput = [];
    let nRow = vecSize[0];
    let nCol = vecSize[1];
    for (iRow = 0; iRow < nRow; iRow++) {
        mxOutput[iRow] = [];
    }
    for (iCol = 0; iCol < nCol; iCol++) {
        for (iRow = 0; iRow < nRow; iRow++) {
            mxOutput[iRow][iCol] = mxArrayIn.mwdata[iCol * (nRow) + iRow];
        }
    }
    return mxOutput;
}
function getDataSetlLoop(parameters, Type = '') {
    let returnlist = [];
    jQuery.each(parameters, function(index, values) {
        if (Type == 'timestamp') {
            DateYear = new Date(values);
            returnlist[index] = DateYear.getFullYear() + ',';
        } else {
            returnlist[index] = values + ',';
        }
    });
    return returnlist;
}
function RiskSetCustomToolTipText(tooltipItems) {
    var tooltipItem = tooltipItems[0];
    if (tooltipItem.dataset.hasOwnProperty('pointLabels')) {
        var totalDataSetLegnth = tooltipItem.dataset.pointLabels.labels;
        var CurrentDataIndex = tooltipItem.dataIndex;
        return totalDataSetLegnth[CurrentDataIndex];
    }
}
function RoundNumbers(Numbers) {
    if (jQuery.isNumeric(Numbers)) {
        return Numbers.toFixed(2);
    } else {
        return Numbers;
    }
}
function defaultColor(key = '') {
    let ColorCode = ["#f0d156", "#e6f09e", "#a8d4ed", "#e21da3", "#75e18b", "#4ae1d1"];
    if (key == 0 || key != '') {
        return ColorCode[key];
    } else {
        return ColorCode;
    }
}
function ChartDynamicColorSet(DefaultGraph, RiskRetColor) {
    let Legendlists = DefaultGraph[0].mwdata.LegendTitle[0].mwdata;
    let RiskRetColors = '';
    let lists = '';
    jQuery.each(Legendlists, function(key, pair) {
        RiskRetColors = (RiskRetColor === undefined || RiskRetColor === null ? defaultColor(key) : RiskRetColor[key]);
        lists += '<li>';
        lists += '<div>';
        lists += '<label class="uk-form-label">' + pair + '</label>';
        lists += '<div class="uk-form-controls"><input class="uk-input uk-form-small AssetAllocatorChartColorOption" type="color" value="' + RiskRetColors + '"></div>';
        lists += '</div>';
        lists += '</li>';
    });
    jQuery('.assetallocator-dashboard').find('.AssetAllocatorChartColorlists').html(lists);
}

function clientinfochangesoldata(...args) {
    let key = args[0].getAttribute('data-key');
    let type = args[0].getAttribute('data-type');
    let token = args[0].getAttribute('data-token');
    let minimumhorizon = args[0].getAttribute('data-minimumhorizon');

    let BtnLabel = (type == 'portfolio' ? 'Portfolio Strategy' : 'Reference currency');
    jQuery('.' + type + 'commondropdownlistupdate a').css('color', '');
    let currentdate = new Date().toISOString().split('T')[0];
    let txtSessionIDtxtUserID = document.getElementById("txtSessionIDtxtUserID").value.split('::');
    var assetobj = { "nargout": 1, "rhs": ['txtAction', 'Initialise', 'txtOrganisationID', txtSessionIDtxtUserID[2], 'txtDateSelected', currentdate, 'txtCurrencySelected', '£', 'txtSessionID', txtSessionIDtxtUserID[0], 'txtUserID', txtSessionIDtxtUserID[1]] };
    jQuery.ajax({
        url: base_url + controller + '/Updateallocatorbasicinfo_Ajax',
        data: { ajax: true, tokenkey: token, key: key, minimumhorizon: minimumhorizon, type: type, currentdate: currentdate },
        method: 'POST',
        async: true,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        beforeSend: function() {
            jQuery('.' + type + 'updateassetbtn').html('Processing please wait...' + '<span uk-icon="icon: refresh"></span>');
            jQuery('.' + type + 'updateassetbtn').addClass('uk-spinner');
            jQuery('.assetallocator-dashboard').find('.commom-preloader-assetgrpah').show();
            jQuery('.assetallocator-dashboard').find('.AssetClassesAllocationTableGrid').hide();
            jQuery('.assetallocator-dashboard').find('.PortfolioClassesAllocationTableGrid').hide();
            jQuery('.assetallocator-dashboard').find('.commom-preloader-chartoptions').hide();
            jQuery('.assetallocator-dashboard').find('#assetallocator_grapgdata').hide();
        },
        success: function(response) {
            jQuery('.assetallocator-dashboard').find('.commom-preloader-assetgrpah').hide();
            jQuery('.assetallocator-dashboard').find('.AssetClassesAllocationTableGrid').show();
            jQuery('.assetallocator-dashboard').find('.PortfolioClassesAllocationTableGrid').show();
            jQuery('.assetallocator-dashboard').find('#assetallocator_grapgdata').show();
            jQuery('.assetallocator-dashboard').find('.commom-preloader-chartoptions').show();
            jQuery('.updateassetanchor_' + (key == 'U$' ? 'usdollar' : key)).css('color', '#1e88e5');
            jQuery('.current-' + type + '-selected').html('Current' + (type == 'currency' ? ' Currency: ' : ': ') + key);

            jQuery('.' + type + 'updateassetbtn').html(BtnLabel + '<span uk-icon="icon: triangle-down"></span>');
            jQuery('.' + type + 'updateassetbtn').removeClass('uk-spinner');
            let ResponseApiParse = JSON.parse(response.apiresponse);
            APIErrorMessage(ResponseApiParse.lhs[0].mwdata.Message[0].mwdata[0]);
            if (response.apiresponse) {
                localStorage.setItem('apiresponse_graphcodedecode_' + response.iduserallocator, response.apiresponse);
            }
            let graphcodedecode = localStorage.getItem('apiresponse_graphcodedecode_' + response.iduserallocator);
            var ResultTable = generateGrphwithLocalStorage(JSON.parse(graphcodedecode));

            jQuery('.assetallocator-dashboard').find('.AssetClassesAllocationTableGrid').html(ResultTable.AssetClassesTable);
            jQuery('.assetallocator-dashboard').find('.PortfolioClassesAllocationTableGrid').html(ResultTable.PortfolioTable);
            jQuery('.assetallocator-dashboard').find('.GraphAssetDropdownlistData').html(ResultTable.GraphDropdownlist);

            ResetGroupColmnHeaderTop();
            console.log('ResetGroupColmnHeaderTop loaded..');
        }
    });
}
function confirmdeteleassetcollatoraction(iduserallocator, type) {
    jQuery.ajax({
        url: base_url + controller + '/confirmdeteleassetcollatoraction',
        data: { ajax: true, type: type, iduserallocator: iduserallocator, version: new Date().toISOString().split('T')[0] },
        method: 'POST',
        async: true,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        beforeSend: function() {
            ShowLoader();
        },
        success: function(response) {
            HideLoader();
            if (response.apidata) {
                localStorage.setItem('apiresponse_graphcodedecode_' + response.iduserallocator, response.apidata);
            }
            if (response.status) {
                window.location.href = response.http_redirect;
            }
        }
    });
}
jQuery.getScript(base_url + "assets/dash/js/assetallocator-extend.js?ver=3."+new Date().toISOString().split('T')[0]);