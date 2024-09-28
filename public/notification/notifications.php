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
                <input type="checkbox" id="exchange-rate-updates" name="exchange-rate-updates">
                <label for="exchange-rate-updates"><?php _e('Updates on exchange rates', 'textdomain'); ?></label>
            </div>
            <div>
                <input type="checkbox" id="policies-updates" name="policies-updates">
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


    function my_account_user_notifications(): void
    {
        echo 'User notifications hehe';
    }
}
