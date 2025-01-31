<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="uk-modal-dialog uk-modal-body">
    <h2 class="uk-modal-title">Edit user profile</h2>
	<?php echo form_open(base_url(), ['class' => 'uk-form-stacked EditNewTeamForm', 'method' => 'POST', 'data-action' => 'updateteam']); ?>
    <div class="uk-width-1-3@m">
        <div class="uk-inline uk-margin">
            <img class="uk-border-circle"
                src="<?php echo getprofile_image((isset($info->userprofilepic) ? 'profile/'.$info->userprofilepic : ''));?>"
                alt="<?php echo $info->username;?>" id="previewnewuserImage" style="height: 190px;object-fit: cover;">
            <div class="uk-position-bottom uk-overlay uk-overlay-default uk-text-center uk-padding-small">
                <div uk-form-custom>
                    <input type="file" name="userprofilepic" id="uploadnewuserImage">
                    <span class="uk-link">Change</span>
                </div>
            </div>
        </div>
    </div>


    <div class="uk-margin">
        <label class="uk-form-label" for="first-name">First name</label>
        <div class="uk-form-controls">
            <input class="uk-input" name="firstname" type="text" value="<?php echo $info->firstname;?>">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="surname">Surname</label>
        <div class="uk-form-controls">
            <input class="uk-input" name="surname" type="text" value="<?php echo $info->surname;?>">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="surname">Two-Factor Authentication <small>(will enable the OTP at the time of login)</small></label>
        <div class="uk-form-controls">
            <select class="uk-select" name="twofa">
                <option value="1"
                    <?php echo (isset($info) && $info->twofa == 1 ? 'selected' : '');?>>Enable
                </option>
                <option value="0"
                    <?php echo (isset($info) && $info->twofa == 0 ? 'selected' : '');?>>Disable
                </option>
            </select>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="last-log-in">Last log in</label>
        <div class="uk-form-controls">
            <input class="uk-input" type="text" value="<?php echo getLastLoginInfo($info->id);?>" disabled>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="account">Account</label>
        <div class="uk-form-controls">
            <input class="uk-input" type="text" value="<?php echo $info->OrganisationName;?>" disabled>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="email">Email address</label>
        <div class="uk-form-controls">
            <input class="uk-input" name="email" type="email" value="<?php echo $info->email;?>">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="mobile">Mobile Number*</label>
        <div class="uk-form-controls">
            <input class="uk-input" name="mobile" type="text" value="<?php echo $info->mobile;?>">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="authorisation">Authorisation</label>
        <div class="uk-form-controls">
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                <label
                    uk-tooltip="title: Set up instructions will be sent via email to the New User/Super User.; delay: 500">
                    <input class="uk-radio" type="radio" name="authorisation" value="approved"
                        <?php echo ($info->active == 1 ? 'checked="checked"' : '');?>>
                    Approved</label>
                <label
                    uk-tooltip="title: A New User/Super User will be created but no set up instructions will be sent to the New User/Super User.; delay: 500">
                    <input class="uk-radio" type="radio" name="authorisation" value="pending"
                        <?php echo ($info->active == 0 ? 'checked="checked"' : '');?>>
                    Pending</label>
                <label>
                    <input class="uk-radio" type="radio" name="authorisation" value="archive"
                        <?php echo ($info->active == 2 ? 'checked="checked"' : '');?>>
                    Archive</label>
            </div>
        </div>
    </div>
    <div class="uk-margin" hidden>
        <label class="uk-form-label" for="role">User type</label>
        <div class="uk-form-controls">
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                <label ><input class="uk-radio useraccountlevelbtn" type="radio" name="useraccountlevel" 
                        value="no" <?php echo ($info->PowerUser == 0 ? 'checked="checked"' : '');?> >
                    User</label>
                <label
                    uk-tooltip="title: Super User can set up and remove Users and Super Users and view all User Solutions.; delay: 500">
                    <input class="uk-radio useraccountlevelbtn" type="radio" name="useraccountlevel" value="yes"
                        <?php echo ($info->PowerUser == 1 ? 'checked="checked"' : '');?> checked> Super user</label>
            </div>

        </div>
    </div>
    <div class="uk-margin DisplayRoleTypeSection">
        <label class="uk-form-label" for="first-name">Role Type</label>
        <div class="uk-form-controls">
            <?php echo AppRoleslist($info->roleid); ?>
        </div>
    </div>
    <div class="uk-text-right">
        <button class="uk-button uk-button-default uk-modal-close uk-border-pill" type="button">Cancel</button>
        <button class="uk-button uk-button-primary uk-border-pill" type="submit"
            onclick="ValidateFormSubmit('EditNewTeamForm','Update');">Update</button>
        <input value="<?php echo encryptKey($info->id); ?>" name="edit_teamuser_id" type="hidden">
    </div>
    <?php echo form_close();?>
</div>