<?php

/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined('ABSPATH') || exit;

$user_info = wp_get_current_user();
$amend_user = new WP_User($user_info);
$user_data_set = array('Mobile', 'Whatsapp', 'Other Tel', 'Linkedin', 'Twitter', 'Facebook', 'Instagram');

foreach ($user_data_set as $field_name) {
	$field_value = wp_strip_all_tags(xprofile_get_field_data($field_name, $user_info->ID));
	$field_name = sanitize_title($field_name);
	if ($field_value) {
		$amend_user->__set($field_name, $field_value);
	}
}

$referral_code = (new Referrals)->generateRefCode($user_info->ID);
$referral_url = site_url('/register') . '?ref=' . $referral_code;
$referred_users = get_user_meta($user_info->ID, 'referred_users', true);

do_action('woocommerce_before_edit_account_form'); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>

	<?php do_action('woocommerce_edit_account_form_start'); ?>

	<div class="account-text-block">
		<div class="account-title-block va">
			<img width="45" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" class="mr2" alt="avatar icon" />
			<h5><?php esc_html_e('Main', 'the-synergy-group-addon'); ?></h5>
		</div>

		<div class="fl mt25">
			<div class="profile-desc">
				<div class="block-lines big-p">

					<div class="block-line spb">
						<div class="line-left">
							<p><strong><?php esc_html_e('First Name', 'the-synergy-group-addon') ?></strong></p>
						</div>
						<div class="line-right line-row icon-right va">
							<p class="name-block form-curr-value"><?php echo $user_info->first_name; ?></p>
							<p class="form-row tsg-entry-hidden">
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($amend_user->first_name); ?>" />
							</p>
							<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
						</div>
					</div>

					<div class="block-line spb">
						<div class="line-left">
							<p><strong><?php esc_html_e('Surname', 'the-synergy-group-addon'); ?></strong></p>
						</div>
						<div class="line-right line-row icon-right va">
							<p class="name-block form-curr-value"><?php echo $user_info->last_name; ?></p>
							<p class="form-row tsg-entry-hidden">
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($amend_user->last_name); ?>" />
							</p>
							<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
						</div>
					</div>

					<div class="block-line spb">
						<div class="line-left">
							<p><strong><?php esc_html_e('Bio', 'the-synergy-group-addon') ?></strong></p>
						</div>
						<div class="line-right line-row icon-right va">
							<a href="#" class="icon-a bio-edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
						</div>
					</div>
					<input type="hidden" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($amend_user->display_name); ?>" />
				</div>

				<div class="bio mt25">
					<p class="form-curr-value"><?php echo $user_info->description; ?></p>
					<p class="form-row tsg-entry-hidden">
						<textarea class="woocommerce-Input woocommerce-Input--text input-text" name="account_bio" id="account_bio"><?php echo esc_attr($user_info->description); ?></textarea>
					</p>
				</div>
			</div>
			<div class="profile-photo-block">
				<div class="profile-photo">
					<img src="<?php echo esc_url(bp_core_fetch_avatar(array('item_id' => get_current_user_id(), 'type' => 'full', 'width' => '150', 'html' => false))); ?>" class="mr2" alt="" id="tsg-profile-img-preview">
				</div>
				<div class="btn-block jc mt20">
					<input type="file" name="bp-avatar-upload" accept="image/*" id="tsg-avatar-upload-input" style="display: none;">
					<a href="#" class="btn style2 btn-small w100 tsg-avatar-upload-btn"><?php esc_html_e('ADD PIC', 'the-synergy-group-addon'); ?></a>
				</div>
			</div>
		</div>
	</div>

	<?php
	/**
	 * Hook where additional fields should be rendered.
	 *
	 * @since 8.7.0
	 */
	do_action('woocommerce_edit_account_form_fields');
	?>

	<div class="account-text-block">
		<div class="account-title-block spb">
			<div class="title-content va">
				<img width="42" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/message2.svg" alt="recent messages icon" />
				<h5><?php esc_html_e('Contact Information', 'the-synergy-group-addon') ?></h5>
			</div>
		</div>

		<div class="block-lines links-black media-full big-p mt2">

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php _e('Email', 'the-synergy-group-addon'); ?></strong></p>
				</div>
				<div class="line-right line-row icon-right va">
					<p class="form-curr-value"><a href="mailto:<?php echo esc_attr($user_info->user_email); ?>"><?php echo esc_attr($user_info->user_email); ?></a></p>
					<p class="form-row tsg-entry-hidden">
						<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr($amend_user->user_email); ?>" />
					</p>
					<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php esc_html_e('Mobile', 'the-synergy-group-addon'); ?></strong></p>
				</div>
				<div class="line-right line-row icon-right va">
					<p class="form-curr-value"><a href="tel:<?php echo esc_attr($amend_user->mobile); ?>"><?php echo esc_attr($amend_user->mobile); ?></a></p>
					<p class="form-row tsg-entry-hidden">
						<input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="mobile" id="mobile" autocomplete="mobile" value="<?php echo esc_attr($amend_user->mobile); ?>" />
					</p>
					<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php esc_html_e('WhatsApp', 'the-synergy-group-addon'); ?></strong></p>
				</div>
				<div class="line-right line-row icon-right va">
					<p class="form-curr-value"><a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr($amend_user->whatsapp); ?>"><?php echo esc_attr($amend_user->whatsapp); ?></a></p>
					<p class="form-row tsg-entry-hidden">
						<input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="whatsapp" id="whatsapp" autocomplete="whatsapp" value="<?php echo esc_attr($amend_user->whatsapp); ?>" />
					</p>
					<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php esc_html_e('Other', 'the-synergy-group-addon') ?></strong></p>
				</div>
				<div class="line-right line-row icon-right va">
					<p class="form-curr-value"><a href="<?php echo esc_attr($amend_user->other_tel); ?>"><?php echo esc_attr($amend_user->other_tel); ?></a></p>
					<p class="form-row tsg-entry-hidden">
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="other_tel" id="other_tel" autocomplete="other_tel" value="<?php echo esc_attr($amend_user->other_tel); ?>" />
					</p>
					<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
				</div>
			</div>

		</div>
	</div>

	<div class="account-text-block">
		<div class="account-title-block spb">
			<div class="title-content va">
				<img width="47" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/social_media.svg" alt="social media icon" />
				<h5><?php esc_html_e('Social Media', 'the-synergy-group-addon'); ?></h5>
			</div>
		</div>

		<div class="block-lines links-black media-full big-p mt2">

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php esc_html_e('LinkedIn', 'the-synergy-group-addon'); ?></strong></p>
				</div>
				<div class="line-right line-row icon-right va">
					<p class="form-curr-value"><a href="<?php echo esc_attr($amend_user->linkedin); ?>"><?php echo esc_attr($amend_user->linkedin); ?></a></p>
					<p class="form-row tsg-entry-hidden">
						<input type="url" class="woocommerce-Input woocommerce-Input--text input-text" name="linkedin" id="linkedin" autocomplete="linkedin" value="<?php echo esc_attr($amend_user->linkedin); ?>" />
					</p>
					<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php esc_html_e('Twitter', 'the-synergy-group-addon'); ?></strong></p>
				</div>
				<div class="line-right line-row icon-right va">
					<p class="form-curr-value"><a href="<?php echo esc_attr($amend_user->twitter); ?>"><?php echo esc_attr($amend_user->twitter); ?></a></p>
					<p class="form-row tsg-entry-hidden">
						<input type="url" class="woocommerce-Input woocommerce-Input--text input-text" name="twitter" id="twitter" autocomplete="twitter" value="<?php echo esc_attr($amend_user->twitter); ?>" />
					</p>
					<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php esc_html_e('Facebook', 'the-synergy-group-addon'); ?></strong></p>
				</div>
				<div class="line-right line-row icon-right va">
					<p class="form-curr-value"><a href="<?php echo esc_attr($amend_user->facebook); ?>"><?php echo esc_attr($amend_user->facebook); ?></a></p>
					<p class="form-row tsg-entry-hidden">
						<input type="url" class="woocommerce-Input woocommerce-Input--text input-text" name="facebook" id="facebook" autocomplete="facebook" value="<?php echo esc_attr($amend_user->facebook); ?>" />
					</p>
					<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php esc_html_e('Instagram', 'the-synergy-group-addon'); ?></strong></p>
				</div>
				<div class="line-right line-row icon-right va">
					<p class="form-curr-value"><a href="<?php echo esc_attr($amend_user->instagram); ?>"><?php echo esc_attr($amend_user->instagram); ?></a></p>
					<p class="form-row tsg-entry-hidden">
						<input type="url" class="woocommerce-Input woocommerce-Input--text input-text" name="instagram" id="instagram" autocomplete="instagram" value="<?php echo esc_attr($amend_user->instagram); ?>" />
					</p>
					<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
				</div>
			</div>

		</div>
	</div>

	<div class="account-text-block">
		<div class="account-title-block borderb spb">
			<div class="title-content va">
				<img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/certifications.svg" alt="certifications icon" />
				<h5><?php esc_html_e('Certifications and Awards', 'the-synergy-group-addon'); ?></h5>
			</div>
		</div>

		<div class="items equal pt25">

			<!-- Input Field for Adding Certificate -->
			<div class="line-right line-row icon-right va tsg-certificate-wrapper tsg-entry-hidden">
				<p class="">
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" 
						name="certificate-input" id="certificate-input" autocomplete="off" 
						value="" placeholder="Enter certificate name" />
				</p>
				<a href="#" class="icon-a edit-certificate" id="tsg-user-add-certificate-btn">
					<img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" />
				</a>
				<!-- Error Message for Empty Input -->
			</div>
			<p class="va" id="tsg-certificate-error-message" style="color: red; display: none; width: 100%;">
				Please enter a certificate name.
			</p>

    		<!-- Sample Certificate Item -->
			<!-- <div class="item w2">
				<div class="itemr">
					<div class="award-block tc">
						<a href="#" class="block-edit delete-certificate-btn" data-id="sample-certificate">
							<img src="<?php //echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" />
						</a>
						<div class="award-icon">
							<img src="<?php //echo THE_SYNERGY_GROUP_URL; ?>public/img/account/award.svg" alt="award icon" />
						</div>
						<p class="fs-20 mt18 tsg-certificate-name">
							<?php //esc_html_e('Microsoft Senior Professional Certificate', 'the-synergy-group-addon'); ?>
						</p>
					</div>
				</div>
			</div> -->

    		<!-- Add New Certificate Button -->
			<div class="item w2">
				<div class="itemr">
					<a href="#" class="award-block add-block va jc" id="tsg-add-certificate">
						<svg id="plus" width="55" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66.52 67.04">
							<defs>
								<style>
									.cls-1 {
										fill-rule: evenodd;
									}
								</style>
							</defs>
							<title><?php _e('plus', 'the-synergy-group-addon'); ?></title>
							<path class="cls-1" d="M30.84,48.9H36.7V37.45H48.07V31.53H36.7V20.08H30.84V31.53H19.47v5.92H30.84ZM33.77,68a32.07,32.07,0,0,1-13-2.64A33.5,33.5,0,0,1,3.13,47.57,32.72,32.72,0,0,1,.51,34.49,32.67,32.67,0,0,1,3.13,21.42,33.59,33.59,0,0,1,20.79,3.61,32.12,32.12,0,0,1,33.77,1a32.07,32.07,0,0,1,13,2.64A33.56,33.56,0,0,1,64.41,21.42,32.67,32.67,0,0,1,67,34.49a32.75,32.75,0,0,1-2.62,13.08,33.5,33.5,0,0,1-17.67,17.8A32,32,0,0,1,33.77,68Zm0-5.91a26.33,26.33,0,0,0,19.42-8,26.76,26.76,0,0,0,8-19.57,26.76,26.76,0,0,0-8-19.57,26.36,26.36,0,0,0-19.42-8,26.36,26.36,0,0,0-19.42,8,26.76,26.76,0,0,0-8,19.57,26.76,26.76,0,0,0,8,19.57A26.33,26.33,0,0,0,33.77,62.1Z" transform="translate(-0.51 -0.97)" />
						</svg>
					</a>
				</div>
			</div>
		</div>
		<div class="line-row icon-right va" id="tsg-certificate-container"></div>
		<input type="hidden" id="tsg-certificate-input" value=""/>							
	</div>

	<div class="account-text-block">
		<div class="account-title-block spb">
			<div class="title-content va">
				<img width="61" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_status.svg" alt="affiliate status icon" />
				<h5><?php esc_html_e('Affiliate Status', 'the-synergy-group-addon'); ?></h5>
			</div>
		</div>

		<div class="block-lines media-full big-p mt2">

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php esc_html_e('Affiliate Status', 'the-synergy-group-addon'); ?></strong></p>
				</div>
				<div class="line-right icon-right va">
					<p><?php esc_html_e('Active', ''); ?></p>
					<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/check_small.svg" alt="small check icon" /></a>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php esc_html_e('Affiliate code', 'the-synergy-group-addon'); ?></strong></p>
				</div>
				<div class="line-right icon-right va">
					<p><?php echo esc_attr($referral_code); ?></p>
					<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/check_small.svg" alt="small check icon" /></a>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
					<p><strong><?php esc_html_e('Affiliate link', 'the-synergy-group-addon'); ?> </strong></p>
				</div>
				<div class="line-right icon-right va">
					<p><a href="<?php echo esc_attr($referral_url); ?>" target="_blank"><?php echo esc_attr($referral_url); ?></a></p>
					<a href="#" class="icon-a edit-pencil"><img width="23" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/copy.svg" alt="copy icon" /></a>
				</div>
			</div>

		</div>
	</div>

	<div class="account-text-block">
		<div class="account-title-block spb">
			<div class="title-content va">
				<img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/members.svg" alt="referred members icon" />
				<h5><?php esc_html_e('Referred Members', 'the-synergy-group-addon'); ?></h5>
			</div>
		</div>

		<div class="block-lines media-full big-p mt2">

			<?php if (!empty($referred_users)) {
				foreach ($referred_users as $referred_user_id) {
					$ref_user_info = get_userdata($referred_user_id); ?>
					<div class="block-line spb">
						<div class="line-left va">
							<div class="line-icon wauto">
								<img width="37" src="<?php echo esc_url(bp_core_fetch_avatar(array('item_id' => $referred_user_id, 'type' => 'full', 'width' => '150', 'html' => false))); ?>" alt="member icon" />
							</div>
							<p><?php echo esc_html($user_info->display_name); ?></p>
						</div>
					</div>
				<?php } ?>
			<?php }else{ ?>
				<div class="block-line spb">
				<div class="line-left va">
					<div class="line-icon wauto">
						<img width="37" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/member.svg" alt="member icon" />
					</div>
					<p><?php _e('No Users yet registered as your referrals', 'the-synergy-group-addon'); ?></p>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>

	<?php
	/**
	 * My Account edit account form.
	 *
	 * @since 2.6.0
	 */
	do_action('woocommerce_edit_account_form');
	?>

	<div class="btn-block fl-end mt25">

		<p>
			<?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
			<button type="submit" class="btn btn-small minw <?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="save_account_details" value="<?php esc_attr_e('Save changes', 'the-synergy-group-addon'); ?>"><?php esc_html_e('Save', 'the-synergy-group-addon'); ?></button>
			<input type="hidden" name="action" value="save_account_details" />
		</p>
	</div>

	<?php do_action('woocommerce_edit_account_form_end'); ?>
</form>

<?php do_action('woocommerce_after_edit_account_form'); ?>