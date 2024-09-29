<?php
class Notifier
{

    function my_account_admin_notifications(): void
    {
?>
        <form id="communications-form" method="post" enctype="multipart/form-data">
            <h3><?php _e('Communications', 'textdomain'); ?></h3>

            <!-- Select Members Field -->
            <div>
                <label for="select-members"><?php _e('Select Members', 'textdomain'); ?></label>
                <select id="select-members" name="members[]" multiple="multiple"></select>
            </div>

            <!-- Checkboxes for options -->
            <div>
                <input type="radio" id="exchange-rate-updates" value="exchange-rate-updates" name="notification-type">
                <label for="exchange-rate-updates"><?php _e('Updates on exchange rates', 'textdomain'); ?></label>
            </div>
            <div>
                <input type="radio" id="policies-updates" value="policies-update" name="notification-type">
                <label for="policies-updates"><?php _e('Policies updates', 'textdomain'); ?></label>
            </div>

            <!-- Greeting -->
            <div>
                <label for="greeting"><?php _e('Greeting:', 'textdomain'); ?></label>
                <textarea id="greeting" name="greeting"></textarea>
            </div>
            <!-- Subject -->
            <div>
                <label for="subject"><?php _e('Subject:', 'textdomain'); ?></label>
                <input type="text" id="subject" name="subject">
            </div>
            <!-- Body -->
            <div>
                <label for="body"><?php _e('Body:', 'textdomain'); ?></label>
                <textarea id="body" name="body"></textarea>
            </div>
            <!-- Attachment -->
            <div>
                <label for="attachment"><?php _e('Attachment:', 'textdomain'); ?></label>
                <input type="file" id="attachment" name="attachment">
            </div>
            <!-- Submit Button -->
            <div>
                <button type="submit" id="send-now"><?php _e('Send Now', 'textdomain'); ?></button>
            </div>
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
        $this->show_user_recent_messages();

        $this->show_user_system_notifications();
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
        $messages = $wpdb->get_results($prepared_query);
    ?>
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
