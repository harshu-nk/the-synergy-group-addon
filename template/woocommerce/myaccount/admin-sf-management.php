<?php ?>

<form action="" method="post">
    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="57" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/auto_issue.svg" alt="auto issue sf icon" />
                <h5>Auto Issue SF</h5>
            </div>
        </div>

        <div class="block-lines mt2">

            <div class="block-line spb small-line">
                <div class="line-left">
                    <p>Configure for each Subscription Plan</p>
                </div>
                <div class="line-right va btns-part">
                    <div class="btn-block">
                        <a href="#" class="btn style2 minw2">Configure</a>
                    </div>
                </div>
            </div>

            <div class="block-line spb small-line plans-loop">
                <pre>
                    <?php //print_r($plans); ?>
                </pre>
                <?php foreach($plans as $plan_product_id){
                    echo 'Plan ID: ' . $plan_product_id . '<br>';
                } ?>
            </div>

            <div class="sf-block-parent">
                <div class="block-line spb small-line">
                    <div class="line-left">
                        <p>Adjust SF bonus allocations</p>
                    </div>
                    <div class="line-right va btns-part">
                        <div class="btn-block">
                            <a href="#" class="btn style2 minw2">Adjust</a>
                        </div>
                    </div>
                </div>
                <div class="block-line spb small-line">
                    <input type="number" name="sf_bonus_allocation" value="<?php echo $options['sf_bonus_allocation']; ?>">
                </div>
            </div>

            <div class="block-line light-style small-line spb">
                <div class="line-left">
                    <p>Effective dates</p>
                </div>
                <div class="line-right input-field">
                    <input type="text" id="calendar" name="date" data-position="bottom left" class="date-field" placeholder="Select date">
                </div>
                <!--
                    <div class="line-right input-field">
                      <div class="select">
                        <p class="select-name"><span>Select Date</span></p>
                        <input type="hidden" id="effective-dates" name="effective-dates" value="Select Date" />
                        <ul class="select-list hauto">
                          <li>Date 1</li>
                          <li>Date 2</li>
                        </ul>
                      </div>
                    </div>-->
            </div>

        </div>
    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="56" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/manual_issue.svg" alt="Manual Issue SF icon" />
                <h5>Manual Issue SF</h5>
            </div>
        </div>

        <div class="block-lines mt2">

            <div class="block-line spb small-line">
                <div class="line-left">
                    <p>Allocate SF to a member</p>
                </div>
                <div class="line-right va btns-part">
                    <div class="btn-block">
                        <a href="#" class="btn style2 minw2">Allocate</a>
                    </div>
                </div>
            </div>

            <div class="block-line spb small-line">
                <div class="line-left">
                    <p>Withdraw SF from a member</p>
                </div>
                <div class="line-right va btns-part">
                    <div class="btn-block">
                        <a href="#" class="btn style2 minw2">Withdraw</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="account-text-block rose">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="40" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/burn.svg" alt="burn SF icon" />
                <h5>Burn SF</h5>
            </div>
        </div>

        <div class="block-lines mt2">

            <div class="block-line spb small-line">
                <div class="line-left">
                    <p>Permanently remove SF from circulation</p>
                </div>
                <div class="line-right va btns-part">
                    <div class="btn-block">
                        <a href="#" class="btn red-btn minw2">remove</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>