<?php defined('BASEPATH') OR exit('No direct script access allowed');
	$url_segment = $this->uri->segment(2);
	$seg = explode('-', $url_segment);
?>
<section class="uk-section withoulogin-faqs jot" uk-height-viewport="expand: true" style="background: none; padding-top: 33px;">
	<div class="uk-container">
	 <div uk-grid>
		<div class="uk-width-1-3@m uk-width-1-4@l">
		 <ul class="uk-nav-default sidebar_faqs" uk-nav>
			<?php $openClass = ''; if( !empty($mainCatLists) ) : ?>
		    	<?php foreach($mainCatLists as $mlist ) : 
		    		
		    		if($mlist->catid == $seg[0]){
		    			$openClass = 'uk-open';
		    		}
		    	?>
					<li class="uk-parent">
						<!-- <a href="#" class="uk-active" onclick="window.location='<?php echo SeoUrlTitle($mlist->catid.'-'.$mlist->catname); ?>'"><?php echo $mlist->catname; ?></a> -->
						<a href="#" class="uk-active <?php echo $openClass; ?>"><?php echo $mlist->catname; ?></a>
						<?php if( !empty($mlist->subcategory) ) : ?>
							<ul class="uk-nav-sub">
		    					<?php foreach($mlist->subcategory as $mlist ) : ?>								
									<li><a href="#"><?php echo $mlist->catname; ?></a></li>								
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		 </ul>
		</div>

		
	<div class="uk-width-2-3@m uk-width-3-4@l">
        <h2><?php echo $info->catname;?></h2>
        <ul class="uk-breadcrumb">
			<li><a href="javascript:void();" onclick="window.location='<?php echo website_url('/faqs'); ?>'">User Guide</a></li>
			<li class="uk-active"><span><?php echo ($info->catname);?></span></li>
		</ul>
        <hr>
        <?php if( !empty($lists) ) : ?>
		    <?php foreach($lists as $list ) :
                //$detailsUrl = website_url(strtolower($this->router->fetch_class()).'/'.url_title(($info->catid.'-'.$info->catname),'dash',true).'/'.url_title(($list->catid.'-'.$list->catname),'dash',true));
                $detailsUrl = website_url('jtctools/faqs-details/'.$info->catid.'-'.$info->catname);
                 ?>
                <div class="support-topic-article-list__section ">
                    <a id="<?php echo SeoUrlTitle($list->catname); ?>" href="javascript:void();" class="support-topic-article-list__article-title" onclick="window.location='<?php echo $detailsUrl; ?>'" alt="<?php echo $list->catname; ?>" title="<?php echo SeoUrlTitle($list->catname); ?>">
                        <h2 class="h5 mb-4 row"><?php echo ($list->catname); ?></h2>
                    </a>
                    <ul class="support-topic-article-list__article-sections-grid">
                        <?php 
                        $qsnlists = $this->faqs->getallFaqlist($list->catid);
                        foreach($qsnlists as $qsnlist ) : ?>  
                            <li class="mb-2">
                                <a class="text-link text-link--bare" href="javascript:void();" onclick="window.location='<?php echo $detailsUrl; ?>#<?php echo url_title(strtolower($qsnlist->faqtitle),'dash',true);?>'" alt="<?php echo $qsnlist->faqtitle; ?>" title="<?php echo SeoUrlTitle($qsnlist->faqtitle); ?>"><?php echo ($qsnlist->faqtitle);?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
             <?php endforeach; ?>
		<?php endif; ?>
    </div>
	  </div>
    </div>
</section>
<style>
.support-topic-article-list__section h2 {
    font-size: 18px;
}

ul.support-topic-article-list__article-sections-grid {
    display: flex;
    padding: 0;
    flex-wrap: wrap;
}

ul.support-topic-article-list__article-sections-grid li {
    width: 33%;
    padding: 10px 0;
}
.faq_categorySection .uk-card {
    text-align: center;
}
.support-topic-article-list__section {
    border-bottom: 1px solid #ddd;
    padding: 20px 0;
}
.sidebar_faqs li a {
    color: #333 !important;
    font-weight: 600;
    border-bottom: 1px solid #ddd;
    padding: 10px 5px;
}
.sidebar_faqs li a:hover {
    background: #f7f7f7;
}
.sidebar_faqs li ul a {
    color: #666 !important;
}
.sidebar_faqs .uk-active, .sidebar_faqs .uk-active:hover {
    background: #425563;
    color: #fff !important;
}
</style>