<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div uk-grid class="uk-grid-collapse" uk-height-viewport="expand: true">
    <div class="uk-container" style="padding: 3%;">
        <ul class="uk-breadcrumb">
            <li><a href="<?php echo website_url('apps'); ?>">Home</a></li>
            <li><a href="<?php echo website_url($this->controller.'/settings');  ?>">Settings</a></li>
            <li class="uk-active"><span>My team</span></li>
        </ul>
        <hr>
        <div class="uk-child-width-1-2@s uk-grid-match uk-grid-divider" uk-grid>
            <div>
                <p>Create new users, edit details of existing users, Control who is able to configure account settings.
                </p>
                <div class="uk-section uk-padding-small">
                    <a href="javascript:void(0)"
                        class="<?php echo HasAppMenuAccess('myteams','canadd');?> uk-button uk-button-default uk-margin-small-bottom uk-border-pill uk-text-capitalize"
                        style="cursor: pointer" onclick="team_view_modal('teams/add',this)">Create new user</a>

                    <a hidden href="<?php echo website_url("teams/addbyCSV");?>"
                        class="<?php echo HasAppMenuAccess('myteams','canadd');?> uk-button uk-button-default uk-margin-small-bottom uk-border-pill uk-text-capitalize"
                        style="cursor: pointer">Add Users by CSV</a>
                </div>
            </div>
            <div>
                <form class="uk-form-stacked">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="search">Search</label>
                        <div class="uk-form-controls">
                            <input class="uk-input uk-form-width-large" id="ajax-search-input" type="text"
                                placeholder="Search...">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-hover uk-table-divider uk-table-small" id="datatableCommon"
                data-action="myteam_json" data-mode="myteam">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>User name</th>
                        <th>Last log in</th>
                        <th>Status</th>
                        <th>2FA</th>
                        <th>Role</th>
                        <th class="uk-text-right">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>