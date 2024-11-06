<form class="light-style input-small" method="post">
    <input type="hidden" name="form-type" value="customer-settings">
    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="49" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/account_settings.svg" alt="account settings icon" />
                <h5>Account Settings</h5>
            </div>
        </div>

        <div class="block-lines small-lines media-full">

            <div class="block-line spb">
                <div class="line-left">
                    <p>Password</p>
                </div>
                <div class="line-right input-field">
                    <input type="password" name="password" id="client-password">
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Two-Factor Authentication</p>
                </div>
                <div class="line-right input-field">
                    <div class="select">
                        <p class="select-name"><span>On</span></p>
                        <input type="hidden" id="two-factor" name="two-factor" value="<?php echo $settings['2fa'] ?>" />
                        <ul class="select-list hauto">
                            <li data-value="On">On</li>
                            <li data-value="Off">Off</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="49" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/profile_settings.svg" alt="profile settings icon" />
                <h5>Profile Settings</h5>
            </div>
        </div>

        <div class="block-lines small-lines media-full">

            <div class="block-line spb">
                <div class="line-left">
                    <p>Profile Visibility</p>
                </div>
                <div class="line-right input-field">
                    <div class="select">
                        <p class="select-name"><span>Visible</span></p>
                        <input type="hidden" id="profile-visibility" name="profile-visibility" value="<?php echo $settings['profile_visibility'] ?>" />
                        <ul class="select-list hauto">
                            <li>Visible</li>
                            <li>Invisible</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Payment Methods</p>
                </div>
                <div class="line-right input-field">
                    <div class="select">
                        <p class="select-name"><span>Stripe</span></p>
                        <input type="hidden" id="payment-methods" name="payment-methods" value="<?php echo $settings['payment_method'] ?>" />
                        <ul class="select-list hauto">
                            <li>Stripe</li>
                            <li>PayPal</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Default Currency</p>
                </div>
                <div class="line-right input-field">
                    <div class="select">
                        <p class="select-name"><span>CHF</span></p>
                        <input type="hidden" id="default-currency" name="default-currency" value="<?php echo $settings['default_currency'] ?>" />
                        <ul class="select-list hauto">
                            <li>CHF</li>
                            <li>$</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Notification Preferences</p>
                </div>
                <div class="line-right input-field">
                    <div class="select">
                        <p class="select-name"><span>Enable</span></p>
                        <input type="hidden" id="preferences" name="preferences" value="<?php echo $settings['notification_preferences'] ?>" />
                        <ul class="select-list hauto">
                            <li>Enable</li>
                            <li>Disable</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Affiliate Earnings</p>
                </div>
                <div class="line-right input-field">
                    <div class="select">
                        <p class="select-name"><span>Enable</span></p>
                        <input type="hidden" id="affiliate-earnings" name="affiliate-earnings" value="<?php echo $settings['affiliate_earnings'] ?>" />
                        <ul class="select-list hauto">
                            <li>Enable</li>
                            <li>Disable</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Data Export</p>
                </div>
                <div class="line-right input-field">
                    <div class="select">
                        <p class="select-name"><span>Enable</span></p>
                        <input type="hidden" id="data-export" name="data-export" value="<?php echo $settings['data_export'] ?>" />
                        <ul class="select-list hauto">
                            <li>Enable</li>
                            <li>Disable</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Language and Localization Preferences</p>
                </div>
                <div class="line-right">
                    <p><strong>English</strong></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-right va btns-part">
                    <div class="btn-block">
                        <button type="submit" class="btn minw"><?php _e('Save', 'the-synergy-group-addon'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>