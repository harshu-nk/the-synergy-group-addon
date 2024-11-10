
  
<div class="account-text-block">
  <div class="account-title-block va">
    <img width="48" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/admin_guides.svg" alt="admin guides icon" />
    <h5>Admin Guides</h5>
  </div>

  <div class="block-lines small-lines media-full mt2">
    <div class="block-line spb small-line">
      <div class="line-left">
        <p>Documentation for managing fee panel</p>
      </div>
      <div class="line-right va btns-part">
        <div class="btn-block">
          <a href="#" class="btn style2">read more</a>
        </div>
      </div>
    </div>

    <div class="block-line spb small-line">
      <div class="line-left">
        <p>Documentation for managing withdrawal processes</p>
      </div>
      <div class="line-right va btns-part">
        <div class="btn-block">
          <a href="#" class="btn style2">read more</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="account-text-block">
  <div class="account-title-block va">
    <img width="52" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/support_tickets.svg" alt="support tickets icon" />
    <h5>Support Tickets</h5>
  </div>

  <div class="block-lines small-lines media-full mt2">
    <div class="block-line spb small-line">
      <div class="line-left">
        <p>My fee-related Tickets</p>
      </div>
      <div class="line-right va btns-part">
        <?php 
          $args = array(
              'post_type'      => 'emd_ticket', 
              'post_status'    => 'publish', 
              'posts_per_page' => -1, 
              'fields'         => 'ids',
              'author'         => get_current_user_id()  
          );
      
          $tickets = new WP_Query($args);
          $ticket_count = $tickets->found_posts;
        ?>
        <div class="btn-block">
          <a href="#" class="btn style2 minw tsg-item-toggle-btn" data-target="#tsg-admin-my-tickets-container"><?php echo $ticket_count; ?> active tickets</a>
        </div>
      </div>
    </div>
    <div class="block-line spb" id="tsg-admin-my-tickets-container" style="display: none;"><?php echo do_shortcode('[support_tickets]'); ?></div>

    <div class="block-line spb small-line">
      <div class="line-left">
        <p>Raise a New fee-related Ticket</p>
      </div>
      <div class="line-right va btns-part">
        <div class="btn-block">
          <a href="#" class="btn style2 minw tsg-item-toggle-btn" data-target="#tsg-submit-admin-ticket-container">Raise a New Ticket</a>
        </div>
      </div>
    </div>
    <div class="block-line spb" id="tsg-submit-admin-ticket-container" style="display: none;"><?php echo do_shortcode('[submit_tickets]'); ?></div> 

    <div class="block-line spb small-line">
      <div class="line-left">
        <p>My withdrawal Tickets</p>
      </div>
      <div class="line-right va btns-part">
        <?php 
          $args = array(
              'post_type'      => 'emd_ticket', 
              'post_status'    => 'publish', 
              'posts_per_page' => -1, 
              'fields'         => 'ids',
              'author'         => get_current_user_id(),
              'ping-status'    => 'closed'
          );
      
          $withdrawal_tickets = new WP_Query($args);
          $withdrawal_ticket_count = $withdrawal_tickets->found_posts;
        ?>
        <div class="btn-block">
          <a href="#" class="btn style2 minw"><?php echo $withdrawal_ticket_count; ?> active tickets</a>
        </div>
      </div>
    </div>

    <div class="block-line spb small-line">
      <div class="line-left">
        <p>Raise a New withdrawal Ticket</p>
      </div>
      <div class="line-right va btns-part">
        <div class="btn-block">
          <a href="#" class="btn style2 minw">Raise a New Ticket</a>
        </div>
      </div>
    </div>
  </div>
</div>


         