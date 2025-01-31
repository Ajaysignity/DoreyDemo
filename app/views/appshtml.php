<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="uk-width-expand@m">
    <div class="uk-padding-small">
        <div class="uk-container">
            <h2>Welcome to Financial Projector</h2>
            <div class="uk-grid-large uk-child-width-1-3@m uk-text-center" uk-grid style="padding-bottom: 20px;">
                <?php  
                foreach (applists() as $appdetails) {
                    echo '
                    <div class="'.HasAppMenuAccess($appdetails['methods'],'canview').'">
                        <div class="uk-card uk-card-default uk-card-hover uk-card-body"
                          onClick="'.( $appdetails['iswindow'] == 0 ? $appdetails['moduleaccess'] : 'window.location.href=\''.website_url($appdetails['moduleaccess']).'\' ').'">
                            <p class="uk-text-center mainpage_logo"><img src="'.assets_url().'pix/'.$appdetails['biggericon'].'"
                                    width="80px;" /></p>
                            <h3 class="uk-card-title">'.$appdetails['modulename'].'</h3>
                            <p class="DefaultAllocatorDataProcessor"><img src="'.assets_url().'pix/'.$appdetails['smallicons'].'" width="26px;" /></p>
                        </div>
                    </div>';
                }
              ?>
                <input type="hidden" id="txtSessionIDtxtUserID"
                    value="<?php echo ($this->organisation.'::'.$this->userid.'::'.$this->OrganisationApiName); ?>" />
            </div>
        </div>
    </div>
</div>