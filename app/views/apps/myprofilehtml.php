<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<section class="uk-section" uk-height-viewport="expand: true">
    <div class="uk-container">
        <ul class="uk-breadcrumb">
            <li><a href="<?php echo website_url('apps'); ?>">Home</a></li>
            <li class="uk-active"><span>My profile</span></li>
        </ul>
        <hr>
        <p>Change your photo, and update your password and mobile number here. All changes are confirmed with an email
            notification.</p>
        <div class="uk-grid-divider uk-child-width-expand@s" uk-grid style="margin-left: auto;">
            <div class="united-form" uk-grid style="padding-left: inherit;">
                <div class="uk-width-1-3@m">
                    <div class="uk-inline uk-margin">
                        <a data-lity
                            href="<?php echo getprofile_image((isset($this->userinfo->userprofilepic) ? 'profile/'.$this->userinfo->userprofilepic : ''));?>"><img
                                class="uk-border-circle"
                                src="<?php echo getprofile_image((isset($this->userinfo->userprofilepic) ? 'profile/'.$this->userinfo->userprofilepic : ''));?>"
                                alt="" style="object-fit: cover; width: 160px;"></a>
                        <div class="uk-position-bottom uk-overlay uk-overlay-default uk-text-center uk-padding-small">
                            <span class="loadingimageshow"></span>
                            <div uk-form-custom class="loadingimagediv">
                                <input type="file" id="userprofilepic" name="userprofilepic">
                                <span class="uk-link">Change</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-2-3@s">
                    <?php echo form_open(base_url(), ['class' => 'uk-form-stacked updatecurrentuserForm', 'method' => 'POST', 'data-action' => 'updatecurrentprofile']); ?>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="username">Email*</label>
                        <div class="uk-form-controls">
                            <input required class="uk-input" name="username" type="text"
                                value="<?php echo (isset($this->userinfo) ? $this->userinfo->email : '');?>">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="first-name">First name</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" type="text"
                                value="<?php echo (isset($this->userinfo) ? $this->userinfo->firstname : '');?>"
                                disabled>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="surname">Surname</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" type="text"
                                value="<?php echo (isset($this->userinfo) ? $this->userinfo->surname : '');?>" disabled>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="last-log-in">Last log in</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" type="text"
                                value="<?php echo (isset($this->userinfo) ? getLastLoginInfo($this->userinfo->id) : '');?>"
                                disabled>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="account">Account</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" type="text"
                                value="<?php echo (isset($this->userinfo) ? $this->userinfo->OrganisationName : '');?>"
                                disabled>
                        </div>
                    </div>
                    <div class="uk-text-right">
                        <button class="uk-button uk-button-primary uk-border-pill" type="submit"
                            onclick="ValidateFormSubmit('updatecurrentuserForm','Update');">Update</button>
                        <input name="action" type="hidden" value="profile">
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="uk-width-1-3@m">
                <h3>Change password</h3>
                <?php echo form_open(base_url(), ['class' => 'uk-form-stacked updatePasswordForm', 'method' => 'POST', 'data-action' => 'updatecurrentprofile']); ?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="current-password">Current password</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="currentpassword" type="password" placeholder="Current password..."
                            required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="new-password">Set new password</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="newpassword" type="password" placeholder="Set new password..."
                            data-uk-tooltip
                            title="<div class='custom-passwordtoolip'>Passwords must include:<ul><li>At least 8 characters - the more characters, the better.</li><li>A mixture of both uppercase and lowercase letters.</li><li>Both letters and numbers.</li><li>At least one special character, e.g., ! @ # ? ]</li></ul></div>"
                            required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="new-confirm-password">Confirm new password</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="confirmpassword" type="password"
                            placeholder="Confirm new password..." data-uk-tooltip
                            title="<div class='custom-passwordtoolip'>Passwords must include:<ul><li>At least 8 characters - the more characters, the better.</li><li>A mixture of both uppercase and lowercase letters.</li><li>Both letters and numbers.</li><li>At least one special character, e.g., ! @ # ? ]</li></ul></div>"
                            required>
                    </div>
                </div>
                <div class="uk-text-right">
                    <button class="uk-button uk-button-primary uk-border-pill" type="submit"
                        onclick="ValidateFormSubmit('updatePasswordForm','Change');">Change</button>
                    <input name="action" type="hidden" value="password">
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="uk-width-1-4@m">
                <h3>T2FA</h3>
                <?php echo form_open(base_url(), ['class' => 'uk-form-stacked updatePasswordForm', 'method' => 'POST', 'data-action' => 'updatecurrentprofile']); ?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="current-password">Current password</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="twofa">
                            <option value="1" <?php echo (isset($this->userinfo) && $this->userinfo->twofa == 1 ? 'selected' : '');?>>Enable</option>
                            <option value="0" <?php echo (isset($this->userinfo) && $this->userinfo->twofa == 0 ? 'selected' : '');?>>Disable</option>
                        </select>
                    </div>
                </div>
                <div class="uk-text-right">
                    <button class="uk-button uk-button-primary uk-border-pill" type="submit"
                        onclick="ValidateFormSubmit('updatePasswordForm','Change');">Update</button>
                    <input name="action" type="hidden" value="twofaupdate">
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>