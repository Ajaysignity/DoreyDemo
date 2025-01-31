<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div>
    <div class="uk-container">
        <div class="uk-alert-primary uk-margin-small-top uk-margin-medium-bottom" uk-alert> <a href
                class="uk-alert-close" uk-close></a>
            <p>Your Plan may have rules about holding cash. Please review your Plan Documentation to understand your
                liquidity options.</p>
        </div>
        <h1 class="atr-planting"><?php echo $this->headerLabel; ?></h1>
        <div class="atr-primary-nav">
            <?php echo doreyjtcSteps('liquidity'); ?>
        </div>
        <?php echo form_open(base_url(), 'class="SaveFormInfo" method="POST" data-action="savecontributingtransparency" data-controller="'.$this->controller.'" onkeydown="if(event.keyCode === 13) { return false; }"');?>
        <h4 class="uk-margin-medium-top uk-text-light margin-remove-top-mobile">Over the next three years I might need
            to withdraw a percentage of my portfolio as cash, up to:</h4>
        <div class='wrap'>
            <input id='planting_liquidity_range' name="withdraw_percentage" type='range'
                value="<?php echo number_format($info->withdraw_percentage); ?>" />
        </div>
        <div class="uk-text-center">
            <div class="uk-button-group uk-button-group-pill uk-width-1-3 uk-margin-medium-top">
                <button class="uk-button uk-button-default uk-text-capitalize uk-width-1-2"
                    onClick="window.location='<?php echo website_url($this->controller.'/contributing-missing-out');?>'"
                    type="button">Back</button>
                <input type="hidden" name="httpredirect" value="<?php echo $httpredirect; ?>">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <button class="uk-button uk-button-default uk-text-capitalize button-focus uk-width-1-2"
                    onclick="ValidateFormSubmit_JTC('SaveFormInfo','Confirm');" type="submit">Confirm</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<style>
/*
    * {    color: red !important;
}
*/
@keyframes float {
to {
transform: translateY(0.75em);
}
}
.wrap.full output:before, .wrap:not(.full) output {
    position: absolute;
    width: 2.5em;
    height: 2.5em;
    opacity: 0;
    color: #fff;
    pointer-events: none;
    transition: opacity 0.5s ease-in-out;
}
.wrap {
    margin: 0 auto -1em;
    /*    margin: 2em auto -2em;*/
    width: 8em;
    /*    width: 16em;*/
/*    width: 20em;*/
    font-size: 2vmin;
}

@media (max-width: 500px), (max-height: 500px) {
.wrap {
    font-size: 10px;
}
}

@media (min-width: 1600px), (min-height: 1600px) {
.wrap {
    font-size: 26px;/*    font-size: 32px;*/
}
}
.wrap:not(.full) {
    position: relative;
}
.wrap:not(.full) output {
    top: 0;
transform: translate(calc(var(--val)/100*22.5em));
/*transform: translate(calc(var(--val)/100*22.5em));*/
}
.wrap.full {
    position: relative;
    height: 8em;/*    height: 16em;*/
/*    height: 20em;*/
}
.wrap.full [type=range] {
    display: block;
    transform-origin: 100% 0;
    transform: rotate(-90deg) translatey(-100%);
}
.wrap.full output {
    width: 80%;
    height: 80%;
    border-radius: 50%;
    color: #6e8191;
    font-size: 1em;
    /*    font-size: 2.5em;*/
    font-weight: 100;
}
.wrap.full output:before {
    right: 0;
    bottom: 0;
transform: translatey(calc(var(--val)/-100*23.0em));
    /*    line-height: 1.8em;*/
    text-align: center;
    font-size: 0.25em;
    font-weight: 100;
    counter-reset: val var(--val);
    content: counter(val) "%";
}
[type=range] {
    padding: 0;
    width: 6.5em;
    /*    width: 13em;*/
/*    width: 16em;*/
/*    width: 20em;*/
    height: 1.5em;
    /*    height: 3em;*/
/*    height: 2.5em;*/
    background: transparent;
    font: inherit;
    cursor: pointer;
    margin-left: 1.8em;/*    margin-left: 3em;*/
}
[type=range], [type=range]::-webkit-slider-thumb {
-webkit-appearance: none;
}
[type=range]::-webkit-slider-runnable-track {
border: none;
width: 8em;
/*    width: 16em;*/
/*    width: 20em;*/
    height: 0.5em;
border-radius: 0.25em;
background: #6e8191;
}
input[type=range]::-moz-range-track {
border: none;
width: 7em;
/*    width: 16em;*/
/*    width: 20em;*/
    height: 0.5em;
border-radius: 0.25em;
/*    background: red;*/
    background: #6e8191;
}
[type=range]::-ms-track {
border: none;
width: 8em;
/*    width: 16em;*/
/*    width: 20em;*/
    height: 0.5em;
border-radius: 0.25em;
background: #6e8191;
}
[type=range]::-webkit-slider-thumb {
margin-top: -0.35em;
border: none;
width: 1.2em;
height: 1.2em;
/*
    width: 2.5em;
    height: 2.5em;
*/
    border-radius: 50%;
transform: scale(0.9);
/*    transform: scale(0.7);*/
/*    background: black;*/
    background: #ebb800;
/*    filter: saturate(0.7);*/
    transition: transform 0.5s linear, filter 0.5s;
}
[type=range]::-moz-range-thumb {
border: none;
width: 1.2em;
height: 1.2em;
/*
    width: 1.8em;
    height: 1.8em;
*/
/*
    width: 2.5em;
    height: 2.5em;
*/
    border-radius: 50%;
transform: scale(.9);
/*    transform: scale(0.6);*/
/*    background: black;*/
    background: #ebb800;
/*    filter: saturate(0.7);*/
    transition: transform 0.5s linear, filter 0.5s;
}
[type=range]::-ms-thumb {
margin-top: 0;
border: none;
width: 1.8em;
height: 1.8em;
/*
    width: 2.5em;
    height: 2.5em;
*/
    border-radius: 50%;
transform: scale(0.6);
background: #ebb800;
/*    filter: saturate(0.7);*/
    transition: transform 0.5s linear, filter 0.5s;
}
[type=range]::-ms-tooltip {
display: none;
}
[type=range] + output {
    display: flex;
    align-items: center;
    justify-content: center;
background: radial-gradient(#fff 39%, transparent 39.5%), conic-gradient(#ebb800 calc(var(--val)*1%), #e1e1e1 0%);
    margin-top: -1.6em;/*    margin-top: -1.1em;*/
}
[type=range] + output:after {
    content: "%";
}
[type=range]:focus {
    outline: none;
}
[type=range]:focus::-webkit-slider-thumb {
transform: none;
filter: none;
}
[type=range]:focus::-moz-range-thumb {
transform: none;
filter: none;
}
[type=range]:focus::-ms-thumb {
transform: none;
filter: none;
}
.wrap:not(.full) [type=range]:focus + output, .wrap.full [type=range]:focus + output:before {
    opacity: 1;
}
</style>