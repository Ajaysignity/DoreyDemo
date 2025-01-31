<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<section class="uk-section withoulogin-faqs" uk-height-viewport="expand: true" style="background: none; padding-top: 33px;">
	<div class="uk-container">
        <h2><?php echo (str_replace('-',' ',$subcatname)); ?></h2>
        <hr>
        <article class="uk-article faqs_qsnartcile">
            <?php if( !empty($lists) ) : ?>
                <?php foreach($lists as $list ) : ?>
                    <div class="faqs_qsntitle" id="<?php echo url_title(strtolower($list->faqtitle),'dash',true);?>">
                        <h1 class="uk-article-title" style="color: #333 !important;"><?php echo ($list->faqtitle);?></h1>
                        <div class="uk-article-meta"><?php echo $list->faqdescription;?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </article>
        
    </div>
</section>
<style>
.faqs_qsntitle h1 {
    font-size: 24px;
    font-weight: 500;
    margin-bottom: 15px; 
}

.faqs_qsntitle p {
    color: #757575;
    font-size: 16px;
}
.faqs_qsntitle img {
    max-width: 100%;
    margin: 10px auto;
}
.faqs_qsntitle {
    margin-bottom: 30px;
}
</style>