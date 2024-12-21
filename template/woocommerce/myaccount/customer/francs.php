<?php 
  $user_id = get_current_user_id();
  //$sf_balance = mycred_get_users_total_balance($user_id, 'synergy_francs');

  function get_current_user_sf_received($user_id) {
    global $wpdb;

    $sum_subscription_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ( ref LIKE %s OR ref LIKE %s )", $user_id, '%logging_in%', '%registration%'
    ));
    $sum_service_sale_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $user_id, '%sale_of_service%'
    ));
    $sum_affiliates_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $user_id, '%ref_fee%'
    ));
    $sum_purchases_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $user_id, '%buy_creds_with%'
    ));
    $sum_all_received_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND creds > 0", $user_id
    ));

    return [
      'sum_subscription_creds' => $sum_subscription_creds,
      'sum_service_sale_creds' => $sum_service_sale_creds,
      'sum_affiliates_creds' => $sum_affiliates_creds,
      'sum_purchases_creds' => $sum_purchases_creds,
      'sum_all_received_creds' => $sum_all_received_creds
    ];
  } 

  function get_current_user_sf_paid($user_id) {
    global $wpdb;

    $sum_service_buy_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $user_id, '%buy_service%'
    ));
    $sum_sell_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $user_id, '%sf_deduction%'
    ));
    $sum_withdrawal_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $user_id, '%withdrawal%'
    ));
    $sum_admin_deduction_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $user_id, '%admin_deduction%'
    ));
    $sum_ref_cost_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $user_id, '%buyer_ref_cost%'
    ));
    $sum_all_paid_creds = $wpdb->get_var( $wpdb->prepare(
      "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND creds < 0", $user_id
    ));

    return [
      'sum_service_buy_creds' => $sum_service_buy_creds,
      'sum_sell_creds' => $sum_sell_creds,
      'sum_withdrawal_creds' => $sum_withdrawal_creds,
      'sum_admin_deduction_creds' => $sum_admin_deduction_creds,
      'sum_ref_cost_creds' => $sum_ref_cost_creds,
      'sum_all_paid_creds' => $sum_all_paid_creds
    ];
  }  

  $sf_received = get_current_user_sf_received($user_id);
  $sf_paid = get_current_user_sf_paid($user_id);

?>
  
  <div class="light-style input-small">

    <div class="account-text-block">
      <div class="account-title-block borderb spb">
        <div class="title-content va">
          <img width="45" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/francs_wallet.svg" alt="SF icon" />
          <h5 class="big-title">ACCOUNT OVERVIEW: TODATE</h5>
        </div>
      </div>
      <h6 class="mt25"><strong>SF Received from:</strong></h6>

      <div class="block-lines">

        <div class="block-line spb">
          <div class="line-left va">
            <div class="line-square square-green"></div>
            <p>My Subscription</p>
          </div>
          <div class="line-right">
            <p class="main-val2"><?php echo "SF " . ( !empty($sf_received['sum_subscription_creds']) ? $sf_received['sum_subscription_creds'] : "0" ); ?></p>
          </div>
        </div>

        <div class="block-line spb">
          <div class="line-left va">
            <div class="line-square"></div>
            <p>My Sales</p>
          </div>
          <div class="line-right">
            <p class="main-val2"><?php echo "SF " . ( !empty($sf_received['sum_service_sale_creds']) ? $sf_received['sum_service_sale_creds'] : "0" ); ?></p>
          </div>
        </div>

        <div class="block-line spb">
          <div class="line-left va">
            <div class="line-square square-dblue"></div>
            <p>My Affiliates Fee Income</p>
          </div>
          <div class="line-right">
            <p class="main-val2"><?php echo "SF " . ( !empty($sf_received['sum_affiliates_creds']) ? $sf_received['sum_affiliates_creds'] : "0" ); ?></p>
          </div>
        </div>

        <div class="block-line spb">
          <div class="line-left va">
            <div class="line-square square-violet"></div>
            <p>My Exchange Purchases</p>
          </div>
          <div class="line-right">
            <p class="main-val2"><?php echo "SF " . ( !empty($sf_received['sum_purchases_creds']) ? $sf_received['sum_purchases_creds'] : "0" ); ?></p>
          </div>
        </div>

        <div class="block-line spb">
          <div class="line-left">
            <p>Total</p>
          </div>
          <div class="line-right">
            <p class="main-val"><?php echo "SF " . ( !empty($sf_received['sum_all_received_creds']) ? $sf_received['sum_all_received_creds'] : "0" ); ?></p>
          </div>
        </div>
      </div>

      <h6 class="mt25"><strong>Trend:</strong></h6>
      <div class="chart-image">
        <div class="chart-container" style="width: 100%; height: 400px;">
            <canvas id="sfReceivedChart"></canvas>
        </div>
      </div>

      <h6 class="mt25"><strong>Paid For:</strong></h6>

      <div class="block-lines">
        <div class="block-line spb">
          <div class="line-left va">
            <div class="line-square square-green"></div>
            <p>Services I've Purchased</p>
          </div>
          <div class="line-right">
            <p class="main-val2"><?php echo "SF " . ( !empty($sf_paid['sum_service_buy_creds']) ? $sf_paid['sum_service_buy_creds'] : "0" ); ?></p>
          </div>
        </div>

        <div class="block-line spb">
          <div class="line-left va">
            <div class="line-square"></div>
            <p>SF I've Sold</p>
          </div>
          <div class="line-right">
            <p class="main-val2"><?php echo "SF " . ( !empty($sf_paid['sum_sell_creds']) ? $sf_paid['sum_sell_creds'] : "0" ); ?></p>
          </div>
        </div>

        <div class="block-line spb">
          <div class="line-left va">
            <div class="line-square square-dblue"></div>
            <p>Fees on withdrawal I've Made</p>
          </div>
          <div class="line-right">
            <p class="main-val2"><?php echo "SF " . ( !empty($sf_paid['sum_withdrawal_creds']) ? $sf_paid['sum_withdrawal_creds'] : "0" ); ?></p>
          </div>
        </div>

        <div class="block-line spb">
          <div class="line-left va">
            <div class="line-square square-violet"></div>
            <p>Admin deduction</p>
          </div>
          <div class="line-right">
            <p class="main-val2"><?php echo "SF " . ( !empty($sf_paid['sum_admin_deduction_creds']) ? $sf_paid['sum_admin_deduction_creds'] : "0" ); ?></p>
          </div>
        </div>

        <div class="block-line spb">
          <div class="line-left va">
            <div class="line-square square-rose"></div>
            <p>Fees on SF I've Paid for Affiliates</p>
          </div>
          <div class="line-right">
            <p class="main-val2"><?php echo "SF " . ( !empty($sf_paid['sum_ref_cost_creds']) ? $sf_paid['sum_ref_cost_creds'] : "0" ); ?></p>
          </div>
        </div>

        <div class="block-line spb">
          <div class="line-left">
            <p>Total</p>
          </div>
          <div class="line-right">
            <p class="main-val"><?php echo "SF " . ( !empty($sf_paid['sum_all_paid_creds']) ? $sf_paid['sum_all_paid_creds'] : "0" ); ?></p>
          </div>
        </div>
      </div>

      <h6 class="mt25"><strong>Trend:</strong></h6>
      
      <div class="chart-image" style="border-bottom: none; padding-bottom: 0;">
        <div class="chart-container" style="width: 100%; height: 400px;">
            <canvas id="sfPaidChart"></canvas>
        </div>
      </div>
      
      <div class="block-lines mt2">
        <div class="block-line spb">
          <div class="line-left">
            <h6><strong>Current Balance</strong></h6>
          </div>
          <div class="line-right">
            <p class="main-val"><?php echo "SF " . ( get_current_user_current_sf_balance($user_id) ); ?></p>
          </div>
        </div>

        <div class="block-line spb media-full">
          <div class="line-left">
            <h6>Full Transaction Details:</h6>
          </div>
          <div class="line-right">
            <div class="btn-block">
              <a href="#" class="btn style2" id="tsg-customer-show-all-transactions" data-id="<?php echo $user_id; ?>">Show All Transactions</a>
            </div>
          </div>
        </div>

        <div class="messages tsg-display-transaction-history">
          
        </div>

      </div>

    </div>

    <div class="account-text-block" id="tsg-sf-exchange-section">
      <div class="account-title-block spb">
        <div class="title-content va">
          <img width="52" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/francs_exchange.svg" alt="SF Exchange icon" />
          <h5>SF Exchange</h5>
        </div>
      </div>

      <div class="block-lines small-lines media-full">

        <div class="block-line spb">
          <div class="line-left">
            <p>Buy SF</p>
          </div>
          <div class="line-right width-field width2">
            <div class="btn-block">
              <a href="#" class="btn style2 w100 tsg-item-toggle-btn" data-target="#tsg-buy-sf-cred-toggle">Buy</a>
            </div>
          </div>
        </div>

        <div class="block-line spb myCRED-buy-form-wrapper" id="tsg-buy-sf-cred-toggle" style="display: none;">
          <?php echo do_shortcode('[mycred_buy_form]');?>
        </div>

        <div class="block-line spb">
          <div class="line-left">
            <p>Sell SF</p>
          </div>
          <div class="line-right width-field width2">
            <div class="btn-block">
              <a href="#" class="btn style2 w100 tsg-item-toggle-btn" data-target="#tsg-sell-sf-cred-toggle">Sell</a>
            </div>
          </div>
        </div>

        <div class="block-line spb" id="tsg-sell-sf-cred-toggle" style="display: none;">
          <?php echo do_shortcode('[mycred_cashcred]');?>
        </div>

        <div class="block-line spb">
          <div class="line-left">
            <p>Trading History</p>
          </div>
          <div class="line-right width-field width2">
            <div class="btn-block">
              <a href="#" class="btn style2 w100" id="tsg-show-trading-history" data-id="<?php echo $user_id; ?>">Show Details</a>
            </div>
          </div>
        </div>

        <div class="block-line spb" id="tsg-show-trading-history-container" style="display: none;">
        </div>

      </div>
    </div>
  
  </div>

          