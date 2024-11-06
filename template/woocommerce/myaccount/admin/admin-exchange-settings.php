<div class="light-style">
    <?php
    $mycred_pref_buycreds = mycred_get_option('mycred_pref_buycreds');
    $mycred_pref_cashcreds = mycred_get_option('mycred_pref_cashcreds');

    $cred_sell_rate_history = get_history_by_context('log_type', 'selling_sf', 5);
    $cred_buy_rate_history = get_history_by_context('log_type', 'buying_sf', 5);
    $rate_updates = array_merge($cred_buy_rate_history, $cred_sell_rate_history); ?>
    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="68" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/sf_exchange.svg" alt="SF exchange icon" />
                <h5><?php _e('SF Exchange Rate', 'the-synergy-group-addon'); ?></h5>
            </div>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="form-type" value="admin-exchange-settings" />
            <div class="block-lines small-lines mt2">
                <div class="block-line spb">
                    <div class="line-left">
                        <p><?php _e('Buying SF', 'the-synergy-group-addon'); ?></p>
                    </div>
                    <div class="line-right input-field input-equal width3 va">
                        <input type="text" id="buying-sf" name="buying-sf" placeholder="CHF 100" value="<?php echo reset($mycred_pref_buycreds['gateway_prefs'])['exchange']['synergy_francs']; ?>" />
                        <div class="spb text-main2">
                            <p>=</p>
                            <p>CHF 1</p>
                        </div>
                    </div>
                </div>

                <div class="block-line spb">
                    <div class="line-left">
                        <p><?php _e('Selling CHF', 'the-synergy-group-addon'); ?></p>
                    </div>
                    <div class="line-right input-field input-equal width3 va">
                        <input type="text" id="selling-sf" name="selling-sf" placeholder="SF 100" value="<?php echo reset($mycred_pref_cashcreds['gateway_prefs'])['exchange']['synergy_francs']; ?>" />
                        <div class="spb text-main2">
                            <p>=</p>
                            <p>SF 1</p>
                        </div>
                    </div>
                </div>

                <div class="block-line spb">
                    <div class="line-left">
                        <p><?php _e('Effective date', 'the-synergy-group-addon'); ?> : <strong><?php echo date('d.m.Y'); ?></strong></p>
                    </div>
                    <div class="line-right va btns-part">
                        <div class="btn-block">
                            <button type="submit" class="btn minw"><?php _e('Confirm', 'the-synergy-group-addon'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <h6 class="borderb"><strong><?php _e('History of previous rate', 'the-synergy-group-addon'); ?> </strong></h6>
        <div class="messages">
            <div class="messages-sub-block last-bord">
                <?php foreach ($rate_updates as $rate_update) { ?>
                    <div class="message-block spb">
                        <div class="message-icon">
                            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/sf_exchange.svg" alt="sf exchange icon " />
                        </div>
                        <div class="message-text">
                            <p><strong>Transaction <?php echo $rate_update['date']; ?></strong><br>
                                <?php echo $rate_update['message']; ?>
                            </p>
                        </div>
                        <!-- <div class="btn-block">
                            <a href="#" class="btn">read more</a>
                        </div> -->
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>

    <form action="" method="POST">
        <input type="hidden" name="form-type" value="admin-exchange-thresholds" />
        <div class="account-text-block">
            <div class="account-title-block spb">
                <div class="title-content va">
                    <img width="47" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/sf_docs.svg" alt="Thresholds and Limits icon" />
                    <h5><?php _e('Thresholds and Limits', 'the-synergy-group-addon'); ?></h5>
                </div>
            </div>


            <div class="block-lines small-lines mt2">
                <div class="block-line spb">
                    <div class="line-left">
                        <p><?php _e('Minimum SF limits for transactions', 'the-synergy-group-addon'); ?></p>
                    </div>
                    <div class="line-right input-field">
                        <div class="select">
                            <p class="select-name"><span>1</span></p>
                            <input type="hidden" id="min-sf-limits" name="min-sf-limits" value="1" />
                            <ul class="select-list hauto">
                                <li>1</li>
                                <li>2</li>
                                <li>3</li>
                                <li>4</li>
                                <li>5</li>
                                <li>6</li>
                                <li>7</li>
                                <li>8</li>
                                <li>9</li>
                                <li>10</li>
                                <li>More</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="block-line spb">
                    <div class="line-left">
                        <p><?php _e('Maximum SF limits for transactions', 'the-synergy-group-addon'); ?></p>
                    </div>
                    <div class="line-right input-field">
                        <div class="select">
                            <p class="select-name"><span>10,000</span></p>
                            <input type="hidden" id="max-sf-limits" name="max-sf-limits" value="10,000" />
                            <ul class="select-list hauto">
                                <li>5,000</li>
                                <li>10,000</li>
                                <li>15,000</li>
                                <li>20,000</li>
                                <li>25,000</li>
                                <li>30,000</li>
                                <li>35,000</li>
                                <li>40,000</li>
                                <li>45,000</li>
                                <li>50,000</li>
                                <li>More</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="block-line spb">
                    <div class="line-left">
                        <p><?php _e('Notifications threshold', 'the-synergy-group-addon'); ?></p>
                    </div>
                    <div class="line-right input-field">
                        <div class="select">
                            <p class="select-name"><span>1,000</span></p>
                            <input type="hidden" id="notification-threshold" name="notification-threshold" value="1,000" />
                            <ul class="select-list hauto">
                                <li>1,000</li>
                                <li>2,000</li>
                                <li>3,000</li>
                                <li>4,000</li>
                                <li>5,000</li>
                                <li>6,000</li>
                                <li>7,000</li>
                                <li>8,000</li>
                                <li>9,000</li>
                                <li>10,000</li>
                                <li>More</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="block-line spb">
                    <div class="line-left">
                        <p><?php _e('Alerts threshold', 'the-synergy-group-addon'); ?></p>
                    </div>
                    <div class="line-right input-field">
                        <div class="select">
                            <p class="select-name"><span>10,000</span></p>
                            <input type="hidden" id="alerts" name="alerts" value="10,000" />
                            <ul class="select-list hauto">
                                <li>5,000</li>
                                <li>10,000</li>
                                <li>15,000</li>
                                <li>20,000</li>
                                <li>25,000</li>
                                <li>30,000</li>
                                <li>35,000</li>
                                <li>40,000</li>
                                <li>45,000</li>
                                <li>50,000</li>
                                <li>More</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="btn-block fl-end mt25">
            <button type="submit" class="btn btn-small minw"><?php _e('SAVE', 'the-synergy-group-addon'); ?></button>
        </div>
    </form>
</div>