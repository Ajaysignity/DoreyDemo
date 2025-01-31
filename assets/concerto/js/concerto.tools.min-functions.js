jQuery(document).ready(function() {
    let Container = jQuery('.jtc-tools-formsection');
    jQuery(".onhoveringcheckactive").hover(
        function() {
            let btnId = jQuery(this).attr('data-btnid');
            let btnValue = jQuery(this).attr("data-btnVal");
            jQuery('[data-btnid="' + btnId + '"]').removeClass("uk-active");
            jQuery(this).addClass("uk-active");
            Container.find('#' + btnId).val(btnValue);
        },
        function() {
            console.log('step2');
        }
    );

    if (ActiveMethod.includes("contributing_risk") || ActiveMethod.includes("investing_risk") || ActiveMethod.includes("withdrawing_risk")) {
        loadRiskScreenApiCall();
    }

    if (ActiveMethod.includes("contributing_results") || ActiveMethod.includes("investing_results") || ActiveMethod.includes("withdrawing_results")) {
        loadRiskResultApiCall();
    }

    if (ActiveMethod.includes("contributing") || ActiveMethod.includes("investing") || ActiveMethod.includes("withdrawing")) {
        setTimeout(function() {
            PingServer_ApiCall();
        }, 10000);
    }

    jQuery('.remove-default-rquired button.onhoveringcheckactive').removeClass('uk-active');
    jQuery('.jtc-tools-formsection').find('.remove-default-rquired-li li').removeClass('uk-active');


    if (jQuery('.jtcatrbind_' + ActiveMethod).length > 0) {
        jQuery('.SaveFormInfo').find(":submit").hide('');
        var serializedData = jQuery('.SaveFormInfo').serialize();
        serializedData += '&modetype=' + ActiveMethod + '&version:' + new Date().toISOString().split('T')[0];
        jQuery.ajax({
            url: base_url + 'concerto-json/loadrATR_ApiCall',
            data: serializedData,
            method: 'POST',
            async: true,
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            dataType: 'html',
            beforeSend: function() {
                jQuery('.jtcatrbind_' + ActiveMethod).html('<img class="commom-preloader-resultTable uk-first-column" src="' + base_url + 'assets/dash/images/dorey-tool-admin-loader.gif" style="margin: auto;"></img>');
            },
            success: function(result) {
                jQuery('.SaveFormInfo').find(":submit").attr("hidden", false);
                jQuery('.SaveFormInfo').find(".formbackbuttontext").attr("hidden", false);
                jQuery('.jtcatrbind_' + ActiveMethod).html(result);
                setTimeout(function() {
                    jQuery('.jtcatrbind_' + ActiveMethod).find('.remove-default-rquired-li li').removeClass('uk-active');
                }, 100);
            }
        });
    }
    /**
     * Blur & MouseOut Event on contribution start
     */
    let pressedEnterBtn = 'notpressed';
    jQuery('#rangeContributionsText').on('keypress', function(e) {
        if (e.which == 13) {
            document.getElementById("Contributions_per_annum").value = jQuery(this).val();
            loadRiskResultApiCall();
            pressedEnterBtn = 'pressed';
        }
    });
    jQuery('#rangeContributionsText').on('blur', function(e) {
        if(pressedEnterBtn == 'notpressed') {
            document.getElementById("Contributions_per_annum").value = jQuery(this).val();
            loadRiskResultApiCall();
        }else {
            pressedEnterBtn = 'notpressed';
        }
    });

    /**
     * Blur & MouseOut Event on contribution end
     */


    /**
     * Blur & MouseOut Event on Anual Incom start
     */
    jQuery('#rangeMonthlyTargetText').on('keypress', function(e) {
        if (e.which == 13) {
            document.getElementById("target_annual_income").value = jQuery(this).val();
            loadRiskResultApiCall(true, false, true);
            pressedEnterBtn = 'pressed';
        }
    });
    jQuery('#rangeMonthlyTargetText').on('blur', function(e) {
        if(pressedEnterBtn == 'notpressed') {
            document.getElementById("target_annual_income").value = jQuery(this).val();
            loadRiskResultApiCall(true, false, true);
        }else {
            pressedEnterBtn = 'notpressed';
        }
    });



    jQuery('#retirementincomegoalText').on('keypress', function(e) {
        if (e.which == 13) {
            document.getElementById("retirementincomegoalValue").value = jQuery(this).val();
            loadRiskResultApiCall(true, false, true);
            pressedEnterBtn = 'pressed';
        }
    });
    jQuery('#retirementincomegoalText').on('blur', function(e) {
        if(pressedEnterBtn == 'notpressed') {
            document.getElementById("retirementincomegoalValue").value = jQuery(this).val();
            loadRiskResultApiCall(true, false, true);
        }else {
            pressedEnterBtn = 'notpressed';
        }
    });

    /**
     * Blur & MouseOut Event on  Anual Incom end
     */


    /** Calculate the incomeper */

    /** Calculate the incomeper */

    const Income_per_annum_input = document.getElementById('Income_per_annum');
    const Contributions_percentage_input = document.getElementById('Contributions_percentage');
    const Contributions_per_annum_input = document.getElementById('Contributions_per_annum');

    function calculateFromInputs() {
        const incomeperannum = cleanNumbers(Income_per_annum_input.value) || 0;
        const contri_percentage = cleanNumbers(Contributions_percentage_input.value) || 0;
        const calculatedValue = ((incomeperannum * (contri_percentage / 100)) / 12);
        Contributions_per_annum_input.value = Number(calculatedValue.toFixed(2)).toLocaleString('en-US');
    }

    function calculateFromInput3() {
        const incomeperannum = cleanNumbers(Income_per_annum_input.value) || 0;
        const contri_amount = cleanNumbers(Contributions_per_annum_input.value) || 0;
        const percentage = (contri_amount * 12) / incomeperannum;
        Contributions_percentage_input.value = (percentage * 100).toFixed(2);
    }
    if (document.getElementById('Contributions_percentage') != null) {
        Income_per_annum_input.addEventListener('input', calculateFromInputs);
        Contributions_percentage_input.addEventListener('input', calculateFromInputs);
        Contributions_per_annum_input.addEventListener('input', calculateFromInput3);
    }

});

function cleanNumbers(number) {
    let retunNumber = number.replace(/\,/g, '');
    return parseFloat(retunNumber);
}

function validateInputPercentage(event) {
    const percentageInput = event.target;
    const value = parseFloat(percentageInput.value);
    // if (value < 0) {
    //     percentageInput.value = 100;
    // }
    return true;
}
jQuery('.onchangegetretirenment_mobile select').on('change', function() {
    document.getElementById("retirerment_age").value = jQuery(this).find('option:selected').val();
    loadRiskResultApiCall();
});

jQuery('.onchangegetrisknumber_mobile select').on('change', function() {
    document.getElementById("risknumber").value = jQuery(this).find('option:selected').val();
    loadRiskResultApiCall();
});

jQuery('.OnInputContributionsPer_annum').on('input', function() {
    document.getElementById("Contributions_per_annum").value = jQuery(this).val();
    loadRiskResultApiCall();
});


function getbuttonvalue(identifier) {
    let Container = jQuery('.jtc-tools-formsection');
    let btnId = jQuery(identifier).attr("data-btnId");
    let btnIdInfo = jQuery(identifier).attr("data-btnIdInfo");
    let btnValue = jQuery(identifier).attr("data-btnVal");
    Container.find('#' + btnId).val(btnValue);
    Container.find('#' + btnIdInfo).val(jQuery(identifier).attr('data-btnValInfo'));
    Container.find('.growthstatsdatainformations').attr("hidden", false);
    Container.find('.missingoutstatsdatainformations').css("background-size", '100% 100%');
}

function numberWithCommas(inputId) {
    let x = jQuery('#' + inputId).val().replace(/,/g, '');
    x = x.replace(/\D/g, '');
    var formattedNumber = x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    jQuery('#' + inputId).val(formattedNumber);
}

if (document.getElementById("planting_liquidity_range") != null) {
    const _R = document.getElementById("planting_liquidity_range"),
        _W = _R.parentNode,
        _O = document.createElement("output");
    let val = null,
        conic = false;

    function update() {
        let newval = +_R.value;
        if (val !== newval) {
            _W.style.setProperty("--val", (_O.value = val = newval));
            if (conic) _O.setAttribute("aria-label", `${val}%`);
        }
    }
    update();
    _O.setAttribute("for", _R.id);
    _W.appendChild(_O);
    if (getComputedStyle(_O).backgroundImage !== "none") {
        conic = true;
        _W.classList.add("full");
        _O.setAttribute("role", "img");
        _O.setAttribute("aria-label", `${val}%`);
    }
    addEventListener("input", update, false);
    addEventListener("change", update, false);
}

function changeTableClassPlantingRisk(elementId, newClass) {
    var element = document.getElementById(elementId);
    if (element) {
        let RiskNumner = '';
        let risklabel = '';
        if (newClass.indexOf('one') != -1) {
            RiskNumner = 1;
            risklabel = 'one';
        } else if (newClass.indexOf('two') != -1) {
            RiskNumner = 2;
            risklabel = 'two';
        } else if (newClass.indexOf('three') != -1) {
            RiskNumner = 3;
            risklabel = 'three';
        } else if (newClass.indexOf('four') != -1) {
            RiskNumner = 4;
            risklabel = 'four';
        } else if (newClass.indexOf('five') != -1) {
            RiskNumner = 5;
            risklabel = 'five';
        } else if (newClass.indexOf('six') != -1) {
            RiskNumner = 6;
            risklabel = 'six';
        }
        document.getElementById('risknumber').value = RiskNumner;
        document.getElementById('risklabel').value = risklabel;
        element.className = newClass;
    }
}

function RedirectPageView(PageType, RedirectUrl) {
    var myDate = new Date();
    myDate.setMonth(myDate.getMonth() + 12);
    document.cookie = "LandingPageiTem =" + PageType + ";expires=" + myDate + ";";
    window.location.href = RedirectUrl;
}

function setCurrencyonchange(identifier) {
    var selectedIndexData = identifier.options[identifier.selectedIndex];
    var myDate = new Date();
    myDate.setMonth(myDate.getMonth() + 12);
    document.cookie = "selectedcurrencyvalue=" + selectedIndexData.value + "; path=/" + ";expires=" + myDate + ";";
    document.cookie = "selectedcurrencytext=" + selectedIndexData.text + "; path=/" + ";expires=" + myDate + ";";
    window.location.reload();
}

/**
 * 
 */

function rangeRetirement(value) {
    document.getElementById('rangeRetirement').innerHTML = value;
    loadRiskResultApiCall();
}

function rangeAge(value) {
    document.getElementById('rangeAge').innerHTML = value;
    loadRiskResultApiCall();
}

function rangePot(value) {
    document.getElementById('rangePot').innerHTML = value;
    loadRiskResultApiCall();
}

function rangeContributionsOnchange(value) {
    document.getElementById('rangeContributions').innerHTML = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    document.getElementById('rangeContributionsText').value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    loadRiskResultApiCall();
}

function rangeContributionsMouseHover(value) {
    document.getElementById('rangeContributions').innerHTML = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function rangeRetirement(value) {
    document.getElementById('rangeRetirement').innerHTML = value;
    loadRiskResultApiCall();
}


function rangeRiskOnchange(value) {
    document.getElementById('rangeRisk').innerHTML = value;
    loadRiskResultApiCall();
}

function rangeRiskMouseHover(value) {
    document.getElementById('rangeRisk').innerHTML = value;
}


function rangeMonthlyTargetOnchange(value) {
    document.getElementById('rangeMonthlyTarget').innerHTML = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    document.getElementById('rangeMonthlyTargetText').value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    loadRiskResultApiCall(true, false, true);
}

function rangeMonthlyTargetMouseHover(value) {
    console.log('loaded value: ' + value);
    document.getElementById('rangeMonthlyTarget').innerHTML = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function generate_report(type) {
    let RetirementGoal = (document.getElementById("retirementincomegoalValue").value == '' ? 20000 : document.getElementById("retirementincomegoalValue").value);
    jQuery.ajax({
        url: base_url + 'concerto-json/generate-report',
        data: { ajax: true, version: new Date().toISOString().split('T')[0],screen: ActiveMethod , type: type, RetirementGoal: RetirementGoal},
        method: 'POST',
        async: true,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        beforeSend: function () {
            jQuery('.' + type + 'Resultbtn').html('<span uk-spinner></span> &nbsp; '+type+' Results');
            jQuery('.commonbtnreportclass').prop('disabled', true);
        },
        success: function (response) {
            jQuery('.' + type + 'Resultbtn').html('<span uk-icon="icon: file-pdf"></span> &nbsp; '+type+' Results');
            jQuery('.commonbtnreportclass').prop('disabled', false);
            if (response.status) {
                if (response.http_redirect) {
                    var a = document.createElement('a');
                    a.href = response.http_redirect;
                    a.download = '';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                } else {
                    window.location.reload(true);
                }
            } else {
                openErrorPopup(response.message, response.title);
            }
        }
    });
}