<?php
$current_user_id = get_current_user_id();
$sf_balance = mycred_display_users_balance($current_user_id, 'synergy_francs');
?>
<div class="light-style input-small">

    <div class="account-text-block">
        <div class="account-title-block borderb spb">
            <div class="title-content va">
                <img width="45" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/francs_wallet.svg" alt="SF icon" />
                <h5 class="big-title"><?php _e('ACCOUNT OVERVIEW', 'the-synergy-group-addon'); ?>: TODATE</h5>
            </div>
        </div>
        <h6 class="mt25"><strong><?php _e('SF Received from', 'the-synergy-group-addon'); ?>:</strong></h6>

        <div class="block-lines">

            <div class="block-line spb">
                <div class="line-left va">
                    <div class="line-square square-green"></div>
                    <p><?php _e('My Subscription', 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2"><?php echo do_shortcode('[mycred_total_points type="synergy_francs" ref="registration"]') ?></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left va">
                    <div class="line-square"></div>
                    <p><?php _e('My Sales', 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 510</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left va">
                    <div class="line-square square-dblue"></div>
                    <p><?php _e('My Affiliates Fee Income', 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 180</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left va">
                    <div class="line-square square-violet"></div>
                    <p><?php _e('My Exchange Purchases', 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 750</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p><?php _e('Total', 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val"><?php echo do_shortcode('[mycred_total_points type="synergy_francs"]') ?></p>
                </div>
            </div>
        </div>

        <h6 class="mt25"><strong><?php _e('Trend', 'the-synergy-group-addon'); ?>:</strong></h6>
        <div class="chart-image">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/chart_lines.jpg" alt="chart with lines" />
        </div>

        <h6 class="mt25"><strong><?php _e('Paid For', 'the-synergy-group-addon'); ?>:</strong></h6>

        <div class="block-lines">
            <div class="block-line spb">
                <div class="line-left va">
                    <div class="line-square square-green"></div>
                    <p><?php _e('Services I\'ve Purchased' ,'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 350</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left va">
                    <div class="line-square"></div>
                    <p><?php _e('Fees on Services I\'ve Purchased', 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 510</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left va">
                    <div class="line-square square-dblue"></div>
                    <p><?php _e('Fees on Sales I\'ve Made', 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 180</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left va">
                    <div class="line-square square-violet"></div>
                    <p><?php _e('Fees on SF I\'ve Bought' , 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 750</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left va">
                    <div class="line-square square-rose"></div>
                    <p><?php _e('Fees on SF I\'ve Sold' ,'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 580</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p><?php _e('Total', 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val">SF 1,525</p>
                </div>
            </div>
        </div>

        <h6 class="mt25"><strong><?php _e('Trend' ,'the-synergy-group-addon'); ?>:</strong></h6>
        <div class="chart-image last">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/chart2.jpg" alt="chart 2" />
        </div>

        <div class="block-lines mt2">
            <div class="block-line spb">
                <div class="line-left">
                    <h6><strong><?php _e('Current Balance', 'the-synergy-group-addon'); ?></strong></h6>
                </div>
                <div class="line-right">
                    <p class="main-val">SF 1,525</p>
                </div>
            </div>

            <div class="block-line spb media-full">
                <div class="line-left">
                    <h6><?php _e('Full Transaction Details', 'the-synergy-group-addon'); ?>:</h6>
                </div>
                <div class="line-right">
                    <div class="btn-block">
                        <a href="#" class="btn style2"><?php _e('Show All Transactions', 'the-synergy-group-addon'); ?></a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="52" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/francs_exchange.svg" alt="SF Exchange icon" />
                <h5><?php _e('SF Exchange', 'the-synergy-group-addon'); ?></h5>
            </div>
        </div>

        <div class="block-lines small-lines media-full">

            <div class="block-line spb">
                <div class="line-left">
                    <p><?php _e('Sell SF', 'the-synergy-group-addon'); ?></p>
                </div>


                <div class="line-right input-field width2">
					<div class="btn-block">
						<a href="#" class="btn style2 w100 user-withdraw-btn">Sell</a>
					</div>
					<form class="user-withdraw-form" action="" method="POST">
						<input type="hidden" name="form-type" value="selling-request" />
						<p class="form-row">
							<input type="number" class="woocommerce-Input woocommerce-Input--text input-text" name="selling_amount" id="selling_amount" value="0" max="<?php echo esc_attr($sf_balance); ?>" />
						</p>
						<div class="btn-block">
							<button type="submit" class="btn style2 w100">Submit</button>
						</div>
					</form>
				</div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p><?php _e('Buy SF', 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right width-field width2">
                    <div class="btn-block">
                        <a href="#" class="btn style2 w100 customer-buy-sf-btn"><?php _e('Buy', 'the-synergy-group-addon'); ?></a>
                    </div>
                    <div id="customer-buy-sf-form">
                    <?php echo do_shortcode('[mycred_buy_form]') ?>
                    </div>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p><?php _e('Trading History', 'the-synergy-group-addon'); ?></p>
                </div>
                <div class="line-right width-field width2">
                    <div class="btn-block">
                        <a href="#" class="btn style2 w100 customer-sf-history-btn"><?php _e('Show Details', 'the-synergy-group-addon'); ?></a>
                    </div>
                </div>
            </div>

            <div id="customer-sf-history">
                <?php echo do_shortcode('[mycred_sales_history]'); ?>
            </div>

        </div>
    </div>

</div>