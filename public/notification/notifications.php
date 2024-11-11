<?php
class Notifier
{

    function my_account_admin_notifications(): void
    {
?>


        <form id="communications-form" class="light-style" method="post" enctype="multipart/form-data">


            <div class="account-text-block">
                <div class="account-title-block spb">
                    <div class="title-content va">
                        <img width="48" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/bell.svg" alt="bell icon" />
                        <h5><?php _e('Manage Alerts', 'the-synergy-group-addon'); ?></h5>
                    </div>
                </div>

                <div class="block-lines small-lines mt2">
                    <div class="block-line spb">
                        <div class="line-left">
                            <p><?php _e('Transaction volumes', 'the-synergy-group-addon'); ?></p>
                        </div>
                        <div class="line-right va btns-part">
                            <div class="btn-block">
                                <a href="#" class="btn style2 minw2 tsg-item-toggle-btn" data-target="#tsg-notify-volume-container"><?php _e('Setup alert', 'the-synergy-group-addon'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div id="tsg-notify-volume-container" style="display: none;">
                        <div class="block-line light-style small-line spb">
                            <div class="line-left">
                                <p>Volume: </p>
                            </div>
                            <div class="line-right input-field">
                                <input type="text" id="" name="" data-position="bottom left" class="" placeholder="Select">
                            </div>
                        </div>
                        <div class="block-line spb">
                            <div class="line-right va btns-part">
                                <div class="btn-block">
                                    <a href="#" class="btn style2 minw2"><?php _e('Setup', 'the-synergy-group-addon'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-line spb">
                        <div class="line-left">
                            <p><?php _e('Member activities', 'the-synergy-group-addon'); ?></p>
                        </div>
                        <div class="line-right va btns-part">
                            <div class="btn-block">
                                <a href="#" class="btn style2 minw2 tsg-item-toggle-btn" data-target="#tsg-notify-activity-container"><?php _e('Setup alert', 'the-synergy-group-addon'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div id="tsg-notify-activity-container" style="display: none;">
                        <div class="block-line light-style small-line spb">
                            <div class="line-left">
                                <p>Activities :</p>
                            </div>
                            <div class="line-right input-field">
                                <input type="text" id="" name="" data-position="bottom left" class="" placeholder="Select ">
                            </div>
                        </div>
                        <div class="block-line spb">
                            <div class="line-right va btns-part">
                                <div class="btn-block">
                                    <a href="#" class="btn style2 minw2"><?php _e('Setup', 'the-synergy-group-addon'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h6><strong><?php _e('Affliate Activity Alerts', 'the-synergy-group-addon'); ?>:</strong></h6>
                <div class="block-lines small-lines">
                    <div class="block-line spb">
                        <div class="line-left">
                            <p><?php _e('Affiliates earn fees', 'the-synergy-group-addon'); ?></p>
                        </div>
                        <div class="line-right va btns-part">
                            <div class="btn-block">
                                <a href="#" class="btn style2 minw2 tsg-item-toggle-btn" data-target="#tsg-notify-affiliates-earn-container"><?php _e('Setup alert', 'the-synergy-group-addon'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div id="tsg-notify-affiliates-earn-container" style="display: none;">
                        <div class="block-line light-style small-line spb">
                            <div class="line-left">
                                <p>Earn fees :</p>
                            </div>
                            <div class="line-right input-field">
                                <input type="text" id="" name="" data-position="bottom left" class="" placeholder="Select ">
                            </div>
                        </div>
                        <div class="block-line spb">
                            <div class="line-right va btns-part">
                                <div class="btn-block">
                                    <a href="#" class="btn style2 minw2"><?php _e('Setup', 'the-synergy-group-addon'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block-line spb">
                        <div class="line-left">
                            <p><?php _e('Referred members join or upgrade their plans', 'the-synergy-group-addon'); ?></p>
                        </div>
                        <div class="line-right va btns-part">
                            <div class="btn-block">
                                <a href="#" class="btn style2 minw2 tsg-item-toggle-btn" data-target="#tsg-notify-referred-members-container"><?php _e('Setup alert', 'the-synergy-group-addon'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div id="tsg-notify-referred-members-container" style="display: none;">
                        <div class="block-line light-style small-line spb">
                            <div class="line-left">
                                <p>Earn fees :</p>
                            </div>
                            <div class="line-right input-field">
                                <input type="text" id="" name="" data-position="bottom left" class="" placeholder="Select ">
                            </div>
                        </div>
                        <div class="block-line spb">
                            <div class="line-right va btns-part">
                                <div class="btn-block">
                                    <a href="#" class="btn style2 minw2"><?php _e('Setup', 'the-synergy-group-addon'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block-line spb">
                        <div class="line-left">
                            <p><?php _e('Aaffiliate-specific milestones alerts', 'the-synergy-group-addon'); ?></p>
                        </div>
                        <div class="line-right va btns-part">
                            <div class="btn-block">
                                <a href="#" class="btn style2 minw2 tsg-item-toggle-btn" data-target="#tsg-notify-specific-milestones-container"><?php _e('Setup alert', 'the-synergy-group-addon'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div id="tsg-notify-specific-milestones-container" style="display: none;">
                        <div class="block-line light-style small-line spb">
                            <div class="line-left">
                                <p>Earn fees :</p>
                            </div>
                            <div class="line-right input-field">
                                <input type="text" id="" name="" data-position="bottom left" class="" placeholder="Select ">
                            </div>
                        </div>
                        <div class="block-line spb">
                            <div class="line-right va btns-part">
                                <div class="btn-block">
                                    <a href="#" class="btn style2 minw2"><?php _e('Setup', 'the-synergy-group-addon'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Code -->

            <div class="account-text-block">
                <div class="account-title-block spb">
                    <div class="title-content va">
                        <img width="45" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/communications.svg" alt="communications icon" />
                        <h5><?php _e('Communications', 'the-synergy-group-addon'); ?></h5>
                    </div>
                </div>

                <!-- <div class="block-lines small-lines mt2">
                  <div class="block-line spb">
                    <div class="line-left">
                      <p>Select Members</p>
                    </div>
                    <div class="line-right input-field">
                      <div class="select multi-select">
                        <p class="select-name"><span>Select</span></p>
                        <input type="hidden" id="number-members" name="number-members" value="" />
                        <ul class="select-list">
                          <li>John</li>
                          <li>Mike</li>
                          <li>Lisa</li>
                          <li>Jessy</li>
                          <li>Robert</li>
                          <li>Michael</li>
                          <li>Richard</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div> -->


                <div class="block-lines small-lines mt2">
                    <div class="block-line spb">
                        <div class="line-left">
                            <p><?php _e('Select Members', 'the-synergy-group-addon'); ?></p>
                        </div>
                        <div class="line-right input-field">
                            <select class="select2-list" id="select-members" name="members[]" multiple="multiple" required></select>
                            <!-- <div class="select">
                        <p class="select-name"><span>Select</span></p>
                        <input type="hidden" id="number-members" name="number-members" value="" />
                        <ul class="select-list">
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
                      </div> -->
                        </div>
                    </div>
                </div>

                <div class="checkbox-block checks-first">
                    <input type="hidden" id="updates" name="updates" class="hidfield req" value="updates on exchange rates" />
                    <div class="checks multi">
                        <label for="updates1" class="check-container"><span class="span-text"><?php _e('Updates on exchange rates', 'the-synergy-group-addon'); ?></span>
                            <input type="radio" id="updates1" value="exchange-rate-updates" name="notification-type" checked required /> <span class="checkmark"></span>
                        </label>
                        <label for="updates2" class="check-container"><span class="span-text"><?php _e('Policies updates', 'the-synergy-group-addon'); ?></span>
                            <input type="radio" id="updates2" name="notification-type" value="policies-update" required /> <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="spb mt30">
                    <h6><strong>Greeting:</strong></h6>
                    <div class="btns-part va">
                        <div class="btn-block">
                            <a href="#" class="btn btn-small style2"><?php _e('Plain text', 'the-synergy-group-addon'); ?></a>
                        </div>
                        <div class="btn-block">
                            <a href="#" class="btn btn-small style4"><?php _e('HTML', 'the-synergy-group-addon'); ?></a>
                        </div>
                    </div>
                </div>
                <textarea id="greeting" name="greeting" class="small-textarea mt20" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod "></textarea>

                <h6><strong><?php _e('Subject', 'the-synergy-group-addon'); ?>:</strong></h6>
                <textarea id="greeting" name="subject" class="small-textarea mt20" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do " required></textarea>

                <h6><strong><?php _e('Body', 'the-synergy-group-addon'); ?>:</strong></h6>
                <textarea id="greeting" name="body" class="mt20" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  consectetur adipiscing elit," required></textarea>

                <h6><strong><?php _e('Attachment', 'the-synergy-group-addon'); ?>:</strong></h6>
                <div class="block-lines">
                    <div class="block-line two-btns spb">
                        <div class="btn-block">
                            <a href="#" class="btn style2 minw"><?php _e('Browse', 'the-synergy-group-addon'); ?></a>
                        </div>
                        <div class="btn-block">
                            <!-- <a href="#" class="btn minw">Send Now</a> -->
                            <button type="submit" class="btn minw" id="send-now"><?php _e('Send Now', 'the-synergy-group-addon'); ?></button>

                        </div>
                    </div>
                </div>

            </div>
            <div class="btn-block fl-end mt25">
                <a href="#" class="btn btn-small minw"><?php _e('SAVE', 'the-synergy-group-addon'); ?></a>
            </div>
            <!-- End - Form Code -->

            <!-- <div>
                <label for="select-members"><?php _e('Select Members', 'the-synergy-group-addon'); ?></label>
                <select id="select-members" name="members[]" multiple="multiple"></select>
            </div>
            <div>
                <input type="radio" id="exchange-rate-updates" value="exchange-rate-updates" name="notification-type">
                <label for="exchange-rate-updates"><?php _e('Updates on exchange rates', 'the-synergy-group-addon'); ?></label>
            </div>
            <div>
                <input type="radio" id="policies-updates" value="policies-update" name="notification-type">
                <label for="policies-updates"><?php _e('Policies updates', 'the-synergy-group-addon'); ?></label>
            </div>
            <div>
                <label for="greeting"><?php _e('Greeting:', 'the-synergy-group-addon'); ?></label>
                <textarea id="greeting" name="greeting"></textarea>
            </div>
            <div>
                <label for="subject"><?php _e('Subject:', 'the-synergy-group-addon'); ?></label>
                <input type="text" id="subject" name="subject">
            </div>
            <div>
                <label for="body"><?php _e('Body:', 'the-synergy-group-addon'); ?></label>
                <textarea id="body" name="body"></textarea>
            </div>
            <div>
                <label for="attachment"><?php _e('Attachment:', 'the-synergy-group-addon'); ?></label>
                <input type="file" id="attachment" name="attachment">
            </div>
            <div>
                <button type="submit" id="send-now"><?php _e('Send Now', 'the-synergy-group-addon'); ?></button>
            </div> -->
        </form>
    <?php
    }

    function ajax_search_users()
    {
        $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

        if (empty($search)) {
            wp_send_json([]);
        }

        $args = array(
            'search'         => '*' . esc_attr($search) . '*',
            'search_columns' => array('user_login', 'user_email', 'display_name'),
            'number'         => 10, // Limit the number of results
        );

        $user_query = new WP_User_Query($args);

        $results = array();
        if (! empty($user_query->get_results())) {
            foreach ($user_query->get_results() as $user) {
                $results[] = array(
                    'id'   => $user->ID,
                    'text' => $user->display_name,
                );
            }
        }

        wp_send_json($results);
    }


    function admin_send_notification(): void
    {
        if (current_user_can('manage_options')) {
            // If Event needs to send
            // if( class_exists('Better_Messages_WebSocket') ){
            //     Better_Messages_WebSocket()->send_realtime_event( [1,2,3], [
            //         'custom data' => 'test'
            //     ] );
            // }

            // // If messages to send
            $sender_id  = get_current_user_id();
            $recipients = $_POST['members'];
            $content    = $_POST['body'];
            $subject = $_POST['subject'];

            $thread_id = Better_Messages()->functions->new_message([
                'sender_id'    => $sender_id,
                'content'      => $content,
                'subject'      => $subject,
                'recipients'   => $recipients,
                'return'       => 'thread_id',
                'error_type'   => 'wp_error'
            ]);

            if (is_wp_error($thread_id)) {
                $error = $thread_id->get_error_message();
                echo $error;
            } else {
                echo $thread_id;
            }
        }
        wp_die();
    }

    // View for User's Messages Tab
    function my_account_user_notifications(): void
    {
        // set_current_screen('dashboard');

        do_action('wc_account_before_recent_messages');

        $this->show_user_recent_messages();

        do_action('wc_account_after_recent_messages');

        $this->show_user_system_notifications();

        do_action('wc_account_after_system_notifications');
    }

    function show_user_recent_messages(): void
    {
        global $wpdb;
        $current_user_id = get_current_user_id();

        // Define the timestamp for "recently read" (e.g., within the last 30 days)
        $recent_time = date('Y-m-d H:i:s', strtotime('-30 days'));

        // Write the SQL query
        $query = "SELECT DISTINCT m.*, t.subject
        FROM {$wpdb->prefix}bm_message_messages m
        JOIN {$wpdb->prefix}bm_message_recipients r ON m.thread_id = r.thread_id
        JOIN {$wpdb->prefix}bm_threads t ON m.thread_id = t.id
        WHERE r.user_id = %d  -- Ensure the message is for the current user
        AND (r.last_read IS NULL OR r.last_read < %s)";

        // Execute the query
        $prepared_query = $wpdb->prepare($query, $current_user_id, $recent_time);
        $messages = $wpdb->get_results($prepared_query); ?>
        <div class="account-text-block">
            <div class="account-title-block borderb spb">
                <div class="title-content va">
                    <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/recent_messages.svg" alt="recent messages icon">
                    <h5><?php _e('Member Messages', 'the-synergy-group-addon'); ?></h5>
                </div>
                <div class="mes-num">
                    <p><?php echo count($messages); ?></p>
                </div>
            </div>

            <div class="messages">

                <?php if (! empty($messages)) {
                    foreach ($messages as $message) {
                        $messageUrl = Better_Messages()->functions->get_user_messages_url($current_user_id, $message->thread_id); ?>
                        <div class="message-block spb">
                            <div class="message-icon">
                                <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/message2.svg" alt="message icon ">
                            </div>
                            <div class="message-text">
                                <p><?php echo $message->subject ? sanitize_text_field($message->subject) : substr(sanitize_text_field($message->message), 0, 40) . "..."; ?></p>
                            </div>
                            <div class="btn-block">
                                <a href="<?php echo esc_url($messageUrl); ?>" class="btn"><?php _e('read more', 'the-synergy-group-addon'); ?></a>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <div class="message-block spb">
                        <div class="message-icon">
                            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/message2.svg" alt="message icon " />
                        </div>
                        <div class="message-text">
                            <p><?php _e('No recent messages at the moment.', 'the-synergy-group-addon'); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php
    }

    function show_user_system_notifications(): void
    {
        global $wpdb;

        $admin_users = get_users(array('role' => 'administrator'));
        $admin_ids = wp_list_pluck($admin_users, 'ID');
        $current_user_id = get_current_user_id();

        $admin_ids_string = implode(',', array_map('intval', $admin_ids));

        // Define the timestamp for "recently read" (e.g., within the last 30 days)
        $recent_time = date('Y-m-d H:i:s', strtotime('-30 days'));

        // Write the SQL query
        $query = "SELECT DISTINCT m.*, t.subject
            FROM {$wpdb->prefix}bm_message_messages m
            JOIN {$wpdb->prefix}bm_message_recipients r ON m.thread_id = r.thread_id
            JOIN {$wpdb->prefix}bm_threads t ON m.thread_id = t.id
            WHERE m.sender_id IN ($admin_ids_string)
            AND r.user_id = %d  -- Ensure the message is for the current user
            AND r.last_read < %s";

        // Execute the query
        $prepared_query = $wpdb->prepare($query, $current_user_id, $recent_time);
        $messages = $wpdb->get_results($prepared_query);
    ?>
        <div class="account-text-block">
            <div class="account-title-block borderb spb">
                <div class="title-content va">
                    <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/recent_messages.svg" alt="recent messages icon">
                    <h5><?php _e('System Notifications', 'the-synergy-group-addon'); ?></h5>
                </div>
                <div class="mes-num">
                    <p><?php echo count($messages); ?></p>
                </div>
            </div>

            <div class="messages">

                <?php if (! empty($messages)) {
                    foreach ($messages as $message) {
                        $messageUrl = Better_Messages()->functions->get_user_messages_url($current_user_id, $message->thread_id); ?>
                        <div class="message-block spb">
                            <div class="message-icon">
                                <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/message2.svg" alt="message icon ">
                            </div>
                            <div class="message-text">
                                <p><?php echo $message->subject ? sanitize_text_field($message->subject) : substr(sanitize_text_field($message->message), 0, 40) . "..."; ?></p>
                            </div>
                            <div class="btn-block">
                                <a href="<?php echo esc_url($messageUrl); ?>" class="btn"><?php _e('read more', 'the-synergy-group-addon'); ?></a>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <div class="message-block spb">
                        <div class="message-icon">
                            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/message2.svg" alt="message icon " />
                        </div>
                        <div class="message-text">
                            <p><?php _e('No recent notifications at the moment.', 'the-synergy-group-addon'); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
<?php
    }
}
