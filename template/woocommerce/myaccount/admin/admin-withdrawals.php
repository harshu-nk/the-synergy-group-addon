<?php ?>

<form class="account-col-right light-style">
              
    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/pending_withdrawal.svg" alt="pending withdrawal icon" />
                <h5>Pending Withdrawals</h5>
            </div>
        </div>

        <?php

        $args = array(
            'post_type' => 'cashcred_withdrawal',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'status',
                    'value' => 'Pending',
                    'compare' => '=',
                ),
            ),
        );


        $withdrawals = new WP_Query($args);

        if ($withdrawals->have_posts()) :
            while ($withdrawals->have_posts()) : $withdrawals->the_post();

            $member_name = get_the_author_meta('display_name', get_the_author_meta('ID'));
            $amount = get_the_title();
            $date = get_the_date('d.m.Y');
            $payment_currency = get_post_meta(get_the_ID(), 'currency', true);
            $payment_method = get_post_meta(get_the_ID(), 'gateway', true); ?>

        <div class="messages mt2" >
            <div class="messages-sub-block">
                <div class="message-block message-media spb" data-post-id="<?php echo get_the_ID(); ?>">
                    <div class="message-icon">
                        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="money icon" />
                    </div>
                    <div class="message-text">
                        <div class="message-line spb">
                            <p class="message-line-name">Member:</p>
                            <p class="message-line-value"><strong><?php echo esc_html($member_name); ?></strong><br></p>
                        </div>
                        <div class="message-line spb">
                            <p class="message-line-name">Amount:</p>
                            <p class="message-line-value"><strong><?php echo esc_html($payment_currency); ?>  <?php echo esc_html($amount); ?></strong><br></p>
                        </div>
                        <div class="message-line spb">
                            <p class="message-line-name">Date:</p>
                            <p class="message-line-value"><strong><?php echo esc_html($date); ?></strong><br></p>
                        </div>
                        <div class="message-line spb">
                            <p class="message-line-name">Payment method:</p>
                            <p class="message-line-value"><strong><?php echo esc_html($payment_method); ?></strong><br></p>
                        </div>
                    </div>
                    <div class="message-btns">
                        <div class="btns-first-line va">
                            <div class="btn-block">
                                <a href="#" class="btn green-btn approve-button" data-post-id="<?php echo get_the_ID(); ?>">approve</a>
                            </div>
                            <div class="btn-block">
                                <a href="#" class="btn red-btn reject-button" data-post-id="<?php echo get_the_ID(); ?>">reject</a>
                            </div>
                        </div>
                        <div class="btn-block">
                            <a href="#" class="btn">Request Additional info</a>
                        </div>
                    </div>
                </div>
        
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo "<p>No pending withdrawals found.</p>";
                endif;
                ?>

            </div>
        </div>
    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/approved_withdrawal.svg" alt="approved withdrawal icon" />
                <h5>Approved Withdrawals</h5>
            </div>
        </div>

        <?php

        $args = array(
            'post_type' => 'cashcred_withdrawal',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'status',
                    'value' => 'Approved',
                    'compare' => '=',
                ),
            ),
        );


        $approvedwithdrawals = new WP_Query($args);

        if ($approvedwithdrawals->have_posts()) :
            while ($approvedwithdrawals->have_posts()) : $approvedwithdrawals->the_post();

            $member_name = get_the_author_meta('display_name', get_the_author_meta('ID'));
            $amount = get_the_title();
            $date = get_the_date('d.m.Y');
            $payment_currency = get_post_meta(get_the_ID(), 'currency', true);
            $approvedstatus = get_post_meta(get_the_ID(), 'status', true);
            $payment_method = get_post_meta(get_the_ID(), 'gateway', true); ?>

    <div class="messages mt2">
        <div class="messages-sub-block">

            <div class="message-block message-media spb">
                <div class="message-icon">
                    <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="money icon" />
                </div>

                <div class="message-text">
                    <div class="message-line spb">
                        <p class="message-line-name">Member:</p>
                        <p class="message-line-value"><strong><?php echo esc_html($member_name); ?></strong><br></p>
                    </div>
                    <div class="message-line spb">
                        <p class="message-line-name">Amount:</p>
                        <p class="message-line-value"><strong><?php echo esc_html($payment_currency); ?>  <?php echo esc_html($amount); ?></strong><br></p>
                    </div>
                    <div class="message-line spb">
                        <p class="message-line-name">Date:</p>
                        <p class="message-line-value"><strong><?php echo esc_html($date); ?></strong><br></p>
                    </div>
                    <div class="message-line spb">
                        <p class="message-line-name">Payment method:</p>
                        <p class="message-line-value"><strong><?php echo esc_html($payment_method); ?></strong><br></p>
                    </div>
                </div>

                <div class="message-btns">
                    <div class="btns-first-line fl-end">
                        <div class="btn-block">
                        <a href="#" class="btn green-btn">export</a>
                        </div>
                    </div>
                    <div class="status">
                        <p>Status: <span class="goldc"><?php echo esc_html($approvedstatus); ?></span></p>
                    </div>
                </div>
            </div>
            
            <?php
            endwhile;
                wp_reset_postdata();
            else :
                echo "<p>No pending withdrawals found.</p>";
            endif;
            ?>

        </div>
    </div>

    </div>

    <div class="account-text-block">
    <div class="account-title-block spb">
        <div class="title-content va">
        <img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/withdrawal_history.svg" alt="withdrawal history icon" />
        <h5>Withdrawal History</h5>
        </div>
    </div>
    <div class="block-lines small-lines mt2">
        <div class="block-line spb">
        <div class="line-left">
            <p>Period:</p>
        </div>
        <div class="line-right input-field width3 from-to-block va">
            <div class="from-to">
            <input type="text" id="date-from" name="date" data-position="bottom left" class="date-field" placeholder="Date From">
            </div>
            <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
            </div>
            <div class="from-to">
            <input type="text" id="date-to" name="date" data-position="bottom left" class="date-field" placeholder="Date To">
            </div>
        </div>
        </div>

        <div class="block-line spb">
        <div class="line-left">
            <p>Member:</p>
        </div>
        <div class="line-right input-field width3">
            <select id="member" multiple class="select2-list" placeholder="Select">
            <option value="Member 1">Member 1</option>
            <option value="Member 2">Member 2</option>
            <option value="Member 3">Member 3</option>
            <option value="Member 4">Member 4</option>
            <option value="Member 5">Member 5</option>
            <option value="Member 6">Member 6</option>
            <option value="Member 7">Member 7</option>
            <option value="Member 8">Member 8</option>
            <option value="Member 9">Member 9</option>
            <option value="Member 10">Member 10</option>
            </select>
        </div>
        </div>

        <div class="block-line spb">
        <div class="line-left">
            <p>Status:</p>
        </div>
        <div class="line-right input-field width3">
            <div class="select">
            <p class="select-name"><span>Select</span></p>
            <input type="hidden" id="status" name="status" value="">
            <ul class="select-list hauto">
                <li>Processing</li>
                <li>Pending</li>
                <li>Rejected</li>
                <li>completed</li>
            </ul>
            </div>
        </div>
        </div>
    </div>

    <h6><strong>Withdrawal History:</strong></h6>

    <div class="messages mt2">
        <div class="messages-sub-block">

        <div class="message-block message-media spb">
            <div class="message-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="money icon" />
            </div>
            <div class="message-text">
            <div class="message-line spb">
                <p class="message-line-name">Member:</p>
                <p class="message-line-value"><strong>John Troomer</strong><br></p>
            </div>
            <div class="message-line spb">
                <p class="message-line-name">Amount:</p>
                <p class="message-line-value"><strong>CHF 923</strong><br></p>
            </div>
            <div class="message-line spb">
                <p class="message-line-name">Date:</p>
                <p class="message-line-value"><strong>21.10.2024</strong><br></p>
            </div>
            <div class="message-line spb">
                <p class="message-line-name">Payment method:</p>
                <p class="message-line-value"><strong>Bank Transfer</strong><br></p>
            </div>
            </div>
            <div class="message-btns">
            <div class="btns-first-line fl-end">
                <div class="btn-block">
                <a href="#" class="btn green-btn">export</a>
                </div>
            </div>
            <div class="status">
                <p>Status: <span class="goldc">Pending</span></p>
            </div>
            </div>
        </div>

        <div class="message-block message-media spb">
            <div class="message-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="money icon" />
            </div>
            <div class="message-text">
            <div class="message-line spb">
                <p class="message-line-name">Member:</p>
                <p class="message-line-value"><strong>John Troomer</strong><br></p>
            </div>
            <div class="message-line spb">
                <p class="message-line-name">Amount:</p>
                <p class="message-line-value"><strong>CHF 923</strong><br></p>
            </div>
            <div class="message-line spb">
                <p class="message-line-name">Date:</p>
                <p class="message-line-value"><strong>21.10.2024</strong><br></p>
            </div>
            <div class="message-line spb">
                <p class="message-line-name">Payment method:</p>
                <p class="message-line-value"><strong>Bank Transfer</strong><br></p>
            </div>
            </div>
            <div class="message-btns">
            <div class="btns-first-line fl-end">
                <div class="btn-block">
                <a href="#" class="btn green-btn">export</a>
                </div>
            </div>
            <div class="status">
                <p>Status: <span class="redc">rejected</span></p>
            </div>
            </div>
        </div>

        <div class="message-block message-media spb">
            <div class="message-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="money icon" />
            </div>
            <div class="message-text">
            <div class="message-line spb">
                <p class="message-line-name">Member:</p>
                <p class="message-line-value"><strong>John Troomer</strong><br></p>
            </div>
            <div class="message-line spb">
                <p class="message-line-name">Amount:</p>
                <p class="message-line-value"><strong>CHF 923</strong><br></p>
            </div>
            <div class="message-line spb">
                <p class="message-line-name">Date:</p>
                <p class="message-line-value"><strong>21.10.2024</strong><br></p>
            </div>
            <div class="message-line spb">
                <p class="message-line-name">Payment method:</p>
                <p class="message-line-value"><strong>Bank Transfer</strong><br></p>
            </div>
            </div>
            <div class="message-btns">
            <div class="btns-first-line fl-end">
                <div class="btn-block">
                <a href="#" class="btn green-btn">export</a>
                </div>
            </div>
            <div class="status">
                <p>Status: <span class="greenc">completed</span></p>
            </div>
            </div>
        </div>

        </div>
    </div>

    </div>

    <div class="account-text-block">
    <div class="account-title-block spb">
        <div class="title-content va">
        <img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/payment.svg" alt="payment icon" />
        <h5>Payment Methods</h5>
        </div>
    </div>
    <div class="block-lines small-lines mt2">

        <div class="block-line spb">
        <div class="line-left">
            <p>Available payment methods</p>
        </div>
        <div class="line-right input-field width4">
            <div class="select">
            <p class="select-name"><span>Bank transfer</span></p>
            <input type="hidden" id="payment-methods" name="payment-methods" value="Bank transfer">
            <ul class="select-list hauto">
                <li>Bank transfer</li>
                <li>Payment method 2</li>
                <li>Payment method 3</li>
            </ul>
            </div>
        </div>
        </div>

        <div class="block-line spb">
        <div class="line-left">
            <p>Payment processing details</p>
        </div>
        <div class="line-right input-field width4">
            <div class="select">
            <p class="select-name"><span>Select</span></p>
            <input type="hidden" id="payment-details" name="payment-details" value="">
            <ul class="select-list hauto">
                <li>Option 1</li>
                <li>Option 2</li>
                <li>Option 3</li>
                <li>Option 4</li>
            </ul>
            </div>
        </div>
        </div>

        <div class="block-line spb small-line">
        <div class="line-left">
            <p>Payment processing security settings </p>
        </div>
        <div class="line-right va btns-part">
            <div class="btn-block">
            <a href="#" class="btn style2 minw2">Configure</a>
            </div>
        </div>
        </div>
    </div>

    </div>
</form>
 