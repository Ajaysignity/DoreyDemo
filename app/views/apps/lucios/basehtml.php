<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div uk-height-viewport="expand: true">
    <div class="uk-width-1-1">
        <div class="uk-padding">
            <div class="uk-grid-small uk-child-width-1-1@m" uk-grid>
                <div>
                    <div class="uk-margin">
                        <form action="<?php echo website_url('lucio/dropzoneImagesStore');?>" method="post"
                            enctype="multipart/form-data" id="image-upload" class="dropzone">
                            <div class="uk-margin-bottom">
                                <h3>Upload Single/Multiple pdf/docx By Clicking On the Box</h3>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="uk-width-expand@m" id="usersolutionlist-container">
    <div class="uk-padding">
        <div class="uk-grid-divider uk-child-width-expand@m" uk-grid>
            <div>
                <h2>Existing Files</h2>
                <p>Lists of all doccuments.</p>
            </div>
            <div>
                <form class="uk-form-stacked">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="search">Search</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="ajax-search-input" type="text" placeholder="Search...">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="uk-overflow-auto__">
            <table class="uk-table uk-table-hover uk-table-divider uk-table-small dataTable no-footer"
                id="datatableCommon" data-action="doccumentslist_json" data-mode="doccuments">
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>File Name</th>
                        <th class="uk-text-right">View File</th>
                        <th class="uk-text-right">Uploaded Date</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
</div>