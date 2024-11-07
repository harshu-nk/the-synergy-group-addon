<?php
$mycred_transactions = mycred_get_users_reference_sum(get_current_user_id(), 'synergy_francs');
?>
<div class="light-style input-small">
    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/hands.svg" alt="My Affiliate Earnings icon" />
                <div class="title-text">
                    <h5 class="big-title">My Affiliate Earnings</h5>
                    <p>from Transaction Fees from ALL the members</p>
                </div>
            </div>
        </div>

        <div class="block-lines">
        <?php 
        foreach($mycred_transactions as $label => $amount){ 
            if($amount < 0){
                continue;
            }
            ?>
            <div class="block-line spb">
                <div class="line-left">
                    <p><?php echo ucwords(str_replace('_', ' ' , $label)); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF <?php echo number_format(abs($amount), 2); ?></p>
                </div>
            </div>
        <?php } ?>
        </div>

        <h6 class="mt25"><strong>Trend:</strong></h6>
        <div class="chart-image">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_chart1.jpg" alt="chart 1" />
        </div>
    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="47" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_progress.svg" alt="Transaction Fees icon" />
                <div class="title-text">
                    <h5 class="big-title">Transaction Fees </h5>
                    <p>I've paid to Josh Johansen</p>
                </div>
            </div>
        </div>

        <div class="block-lines">

        <div class="block-lines">
            <?php 
            foreach($mycred_transactions as $label => $amount){ 
                if($amount > 0){
                    continue;
                }
                ?>
                <div class="block-line spb">
                    <div class="line-left">
                        <p><?php echo ucwords(str_replace('_', ' ' , $label)); ?></p>
                    </div>
                    <div class="line-right">
                        <p class="main-val2">SF <?php echo number_format(abs($amount), 2); ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>

            <!-- <div class="block-line spb">
                <div class="line-left">
                    <p>Services Purchased</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 350</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Sales Made</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 150</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>SF Purchased</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 150</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>SF Sold</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 150</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Total SF Paid To-Date</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 550</p>
                </div>
            </div> -->

        </div>

        <h6 class="mt25"><strong>Trend:</strong></h6>
        <div class="chart-image">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_chart2.jpg" alt="chart 2" />
        </div>
    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="47" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_progress.svg" alt="Net Affiliate Transaction Fee Position icon" />
                <div class="title-text">
                    <h5 class="big-title">Net Affiliate Transaction Fee Position</h5>
                </div>
            </div>
        </div>

        <div class="block-lines mt2">

            <div class="block-line spb">
                <div class="line-left">
                    <p>Services Purchased</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 350</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Sales Made</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 150</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>SF Purchased</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 150</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>SF Sold</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 150</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Total SF Net Position To-Date</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 550</p>
                </div>
            </div>

        </div>

        <h6 class="mt25"><strong>Trend:</strong></h6>
        <div class="chart-image last">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_chart3.jpg" alt="chart 3" />
        </div>

        <div class="block-lines mt2 media-full">
            <div class="block-line spb">
                <div class="line-left">
                    <p>You</p>
                </div>
                <div class="line-right input-field width3">
                    <div class="progress-line">
                        <div class="progress-value" style="width: 80%;"></div>
                    </div>
                </div>
            </div>
            <div class="block-line spb">
                <div class="line-left">
                    <p>Josh Jansen</p>
                </div>
                <div class="line-right input-field width3">
                    <div class="progress-line">
                        <div class="progress-value" style="width: 40%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="47" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_progress.svg" alt="Affiliate Leaderboard icon" />
                <div class="title-text">
                    <h5 class="big-title">Affiliate Leaderboard</h5>
                </div>
            </div>
        </div>

        <div class="block-lines mt2">

            <div class="block-line spb media-full">
                <div class="line-left">
                    <p>My Affiliate Link:</p>
                </div>
                <div class="line-right">
                    <p class="main-val2"><a target="_blank" href="http://thesynergygroup.ch/8247" class="blue-link">http://thesynergygroup.ch/8247</a></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Current Position</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">15</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Position Last Month</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">12</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Change from Last Month</p>
                </div>
                <div class="line-right">
                    <img width="24" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/green_arrow_top.svg" alt="green arrow" />
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Affiliate Name</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">Aff23434</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Nr. Members Referred</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">8</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Affiliate Income Earned</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 550</p>
                </div>
            </div>
        </div>
    </div>
</div>