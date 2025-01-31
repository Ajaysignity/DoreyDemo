<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<section class="uk-section" uk-height-viewport="expand: true">
	<div class="uk-container">
      <h2>Legal</h2>
	  <ul class="uk-breadcrumb">
			<li><a href="<?php echo website_url('/dashboard/mysolutions'); ?>">Home</a></li>
			<li class="uk-active"><span>Legal</span></li>
		</ul>
      <hr>
		<div class="uk-child-width-1-3@s uk-grid-match" uk-grid>
			<div>
				<div class="uk-card uk-card-default uk-card-hover uk-card-body" onclick="window.location='<?php echo website_url('disclaimer');?>'" style="cursor: pointer">
					<h3 class="uk-card-title">Disclaimer</h3>
					<p>Before proceeding, please read the following information...</p>
				</div>
			</div>
			<div>
				<div class="uk-card uk-card-default uk-card-hover uk-card-body" onclick="window.location='<?php echo website_url('term-and-conditions');?>'" style="cursor: pointer">
					<h3 class="uk-card-title">Terms and conditions</h3>
					<p>Dorey Limited, a company incorporated in the Island...</p>
				</div>
			</div>
			<div>
				<div class="uk-card uk-card-default uk-card-hover uk-card-body" onclick="window.location='<?php echo website_url('privacy-policy');?>'" style="cursor: pointer">
					<h3 class="uk-card-title">Privacy Policy</h3>
					<p>Dorey Limited (“We”) are committed to protecting and respecting... </p>
				</div>
			</div>
		</div>
    </div>
</section>