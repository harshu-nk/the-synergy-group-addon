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
        if ( current_user_can( 'manage_options' ) ) {

            echo json_encode($_POST);
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

            if ( is_wp_error( $thread_id ) ) {
                $error = $thread_id->get_error_message();
                echo $error;
            } else {
                echo $thread_id;
            }
        }
        wp_die();
    }

    // function admin_send_notification() : void {
        
    // }
}
