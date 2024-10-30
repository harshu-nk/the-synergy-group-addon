<?php
// add_action( 'wp_ajax_nopriv_add_variable', 'add_variable_func' ); 

class Referrals
{

    function __construct()
    {
        add_filter('query_vars', array($this, 'add_query_vars_filter'));
        add_action('init', array($this, 'store_referral_in_session'));
        add_action('user_register', array($this, 'save_referral_data'));

        add_action('woocommerce_checkout_subscription_created', array($this, 'add_referral_info_on_subscription_checkout'), 10, 2);
    }

    function add_query_vars_filter($vars)
    {
        $vars[] = "ref";
        return $vars;
    }

    // Add referral ID to session
    function store_referral_in_session()
    {
        if (isset($_GET['ref']) && !is_user_logged_in()) {
            $referrer_id = get_query_var('ref') ? get_query_var('ref') : $_GET['ref'];
            setcookie('referrer_code', $referrer_id, time() + (86400 * 30), '/'); // 30 days
        }
    }

    // Store referral data on user registration
    function save_referral_data($user_id)
    {
        if (isset($_COOKIE['referrer_code'])) {
            $referral_code = sanitize_text_field($_COOKIE['referrer_code']);

            $this->updateRefDataToUsers($referral_code, $user_id);
        }

        $this->generateRefCode($user_id);
    }

    function updateRefDataToUsers($referral_code, $user_id): void
    {
        $referrer_user = get_users(array(
            'meta_key' => 'referral_code',
            'meta_value' => $referral_code,
            'number' => 1,
            'fields' => 'ID',
        ));

        if (!empty($referrer_user)) {
            $referrer_id = $referrer_user[0];

            // Save the referrer ID in the new user's meta
            update_user_meta($user_id, 'referred_by', $referrer_id);

            // Update the referrer’s meta with referred users
            $referred_users = get_user_meta($referrer_id, 'referred_users', true) ?: [];
            $referred_users[] = $user_id;
            update_user_meta($referrer_id, 'referred_users', $referred_users);

            mycred_add( 'referral_registered', $referrer_id, 10, 'Points for referral onboarding.' );
        }
    }

    function generateRefCode($user_id): string
    {
        $referral_code = get_user_meta($user_id, 'referral_code', true);
        if (empty(get_user_meta($user_id, 'referral_code', true))) {
            $referral_code = substr(md5(uniqid($user_id, true)), 0, 8);
            update_user_meta($user_id, 'referral_code', $referral_code);
        }
        return $referral_code;
    }

    // Add referral information to a new user created during WooCommerce subscription checkout
    function add_referral_info_on_subscription_checkout($subscription, $order)
    {
        $user_id = $order->get_user_id();

        if ($user_id) {
            $this->generateRefCode($user_id);

            // Check if a referrer code exists in a cookie or URL parameter (from a referral link)
            $referrer_code = isset($_COOKIE['referrer_code']) ? sanitize_text_field($_COOKIE['referrer_code']) : '';

            if ($referrer_code) {
                $this->updateRefDataToUsers($referrer_code, $user_id);
            }
        }
    }
}
