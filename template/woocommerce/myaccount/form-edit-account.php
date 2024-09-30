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

do_action('woocommerce_before_edit_account_form'); ?>

<div class="account-text-block">
	<div class="account-title-block va">
		<img width="45" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" class="mr2" alt="avatar icon" />
		<h5>Main</h5>
	</div>

	<div class="fl mt25">
		<div class="profile-desc">
			<div class="block-lines big-p">

				<div class="block-line spb">
					<div class="line-left">
						<p><strong>First Name</strong></p>
					</div>
					<div class="line-right icon-right va">
						<p class="name-block">Mike</p>
						<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
					</div>
				</div>

				<div class="block-line spb">
					<div class="line-left">
						<p><strong>Surname</strong></p>
					</div>
					<div class="line-right icon-right va">
						<p class="name-block">Harson</p>
						<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
					</div>
				</div>

				<div class="block-line spb">
					<div class="line-left">
						<p><strong>Bio</strong></p>
					</div>
					<div class="line-right icon-right va">
						<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
					</div>
				</div>

			</div>

			<div class="bio mt25">
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididuntipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt...</p>
			</div>
		</div>
		<div class="profile-photo-block">
			<div class="profile-photo">
				<img src="<?php echo esc_url( bp_core_fetch_avatar( array( 'item_id' => get_current_user_id(), 'type' => 'full', 'width' => '150', 'html' => false ) ) ); ?>" class="mr2" alt="">
				<!-- <img width="80" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/empty_pic.svg" class="mr2" alt="empty photo icon" /> -->
			</div>
			<div class="btn-block jc mt20">
				<a href="#" class="btn style2 btn-small w100">ADD PIC</a>
			</div>
		</div>
	</div>
</div>

<div class="account-text-block">
	<div class="account-title-block spb">
		<div class="title-content va">
			<img width="42" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/message2.svg" alt="recent messages icon" />
			<h5>Contact Information</h5>
		</div>
	</div>

	<div class="block-lines links-black media-full big-p mt2">

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>Email</strong></p>
			</div>
			<div class="line-right icon-right va">
				<p><a href="mailto:mikeharson@gmail.com">mikeharson@gmail.com</a></p>
				<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
			</div>
		</div>

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>Mobile</strong></p>
			</div>
			<div class="line-right icon-right va">
				<p><a href="tel:+1230094444">+1230094444</a></p>
				<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
			</div>
		</div>

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>WhatsApp</strong></p>
			</div>
			<div class="line-right icon-right va">
				<p><a href="https://api.whatsapp.com/send?phone=230094444">230094444</a></p>
				<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
			</div>
		</div>

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>Other</strong></p>
			</div>
			<div class="line-right icon-right va">
				<p><a href="tg://user?id=230094444">t.me/230094444</a></p>
				<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
			</div>
		</div>

	</div>
</div>

<div class="account-text-block">
	<div class="account-title-block spb">
		<div class="title-content va">
			<img width="47" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/social_media.svg" alt="social media icon" />
			<h5>Social Media</h5>
		</div>
	</div>

	<div class="block-lines links-black media-full big-p mt2">

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>LinkedIn</strong></p>
			</div>
			<div class="line-right icon-right va">
				<p><a href="linjedin.com/230094444">linjedin.com/230094444</a></p>
				<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
			</div>
		</div>

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>Twitter</strong></p>
			</div>
			<div class="line-right icon-right va">
				<p><a href="x.com/230094444">x.com/230094444</a></p>
				<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
			</div>
		</div>

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>Facebook</strong></p>
			</div>
			<div class="line-right icon-right va">
				<p><a href="facebook.com/230094444">facebook.com/230094444</a></p>
				<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
			</div>
		</div>

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>Instagram</strong></p>
			</div>
			<div class="line-right icon-right va">
				<p><a href="instagram.com//230094444">instagram.com//230094444</a></p>
				<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
			</div>
		</div>

	</div>
</div>

<div class="account-text-block">
	<div class="account-title-block borderb spb">
		<div class="title-content va">
			<img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/certifications.svg" alt="certifications icon" />
			<h5>Certifications and Awards</h5>
		</div>
	</div>

	<div class="items equal pt25">

		<div class="item w2">
			<div class="itemr">
				<div class="award-block tc">
					<a href="#" class="block-edit"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon" /></a>
					<div class="award-icon">
						<img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/award.svg" alt="award icon" />
					</div>
					<p class="fs-20 mt18">Microsoft Senior Professional Certificate</p>
				</div>
			</div>
		</div>

		<div class="item w2">
			<div class="itemr">
				<a href="#" class="award-block add-block va jc">
					<svg id="plus" width="55" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66.52 67.04">
						<defs>
							<style>
								.cls-1 {
									fill-rule: evenodd;
								}
							</style>
						</defs>
						<title>plus</title>
						<path class="cls-1" d="M30.84,48.9H36.7V37.45H48.07V31.53H36.7V20.08H30.84V31.53H19.47v5.92H30.84ZM33.77,68a32.07,32.07,0,0,1-13-2.64A33.5,33.5,0,0,1,3.13,47.57,32.72,32.72,0,0,1,.51,34.49,32.67,32.67,0,0,1,3.13,21.42,33.59,33.59,0,0,1,20.79,3.61,32.12,32.12,0,0,1,33.77,1a32.07,32.07,0,0,1,13,2.64A33.56,33.56,0,0,1,64.41,21.42,32.67,32.67,0,0,1,67,34.49a32.75,32.75,0,0,1-2.62,13.08,33.5,33.5,0,0,1-17.67,17.8A32,32,0,0,1,33.77,68Zm0-5.91a26.33,26.33,0,0,0,19.42-8,26.76,26.76,0,0,0,8-19.57,26.76,26.76,0,0,0-8-19.57,26.36,26.36,0,0,0-19.42-8,26.36,26.36,0,0,0-19.42,8,26.76,26.76,0,0,0-8,19.57,26.76,26.76,0,0,0,8,19.57A26.33,26.33,0,0,0,33.77,62.1Z" transform="translate(-0.51 -0.97)" />
					</svg>
				</a>
			</div>
		</div>

	</div>
</div>

<div class="account-text-block">
	<div class="account-title-block spb">
		<div class="title-content va">
			<img width="61" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_status.svg" alt="affiliate status icon" />
			<h5>Affiliate Status</h5>
		</div>
	</div>

	<div class="block-lines media-full big-p mt2">

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>Affiliate Status</strong></p>
			</div>
			<div class="line-right icon-right va">
				<p>Active</p>
				<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/check_small.svg" alt="small check icon" /></a>
			</div>
		</div>

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>Affiliate code</strong></p>
			</div>
			<div class="line-right icon-right va">
				<p>879871230094444</p>
				<a href="#" class="icon-a edit-pencil"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/check_small.svg" alt="small check icon" /></a>
			</div>
		</div>

		<div class="block-line spb">
			<div class="line-left">
				<p><strong>Affiliate link </strong></p>
			</div>
			<div class="line-right icon-right va">
				<p><a href="thesynergygroup.ch/230094444">thesynergygroup.ch/230094444</a></p>
				<a href="#" class="icon-a edit-pencil"><img width="23" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/copy.svg" alt="copy icon" /></a>
			</div>
		</div>

	</div>
</div>

<div class="account-text-block">
	<div class="account-title-block spb">
		<div class="title-content va">
			<img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/members.svg" alt="referred members icon" />
			<h5>Referred Members</h5>
		</div>
	</div>

	<div class="block-lines media-full big-p mt2">

		<div class="block-line spb">
			<div class="line-left va">
				<div class="line-icon wauto">
					<img width="37" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/member.svg" alt="member icon" />
				</div>
				<p>John Berdenson</p>
			</div>
		</div>

		<div class="block-line spb">
			<div class="line-left va">
				<div class="line-icon wauto">
					<img width="37" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/member.svg" alt="member icon" />
				</div>
				<p>Sarah Parker</p>
			</div>
		</div>

		<div class="block-line spb">
			<div class="line-left va">
				<div class="line-icon wauto">
					<img width="37" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/member.svg" alt="member icon" />
				</div>
				<p>Anna Terro</p>
			</div>
		</div>

	</div>
</div>

<div class="btn-block fl-end mt25">
	<a href="#" class="btn btn-small minw">SAVE</a>
</div>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>

	<?php do_action('woocommerce_edit_account_form_start'); ?>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
		<label for="account_first_name"><?php esc_html_e('First name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>" />
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
		<label for="account_last_name"><?php esc_html_e('Last name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>" />
	</p>
	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_display_name"><?php esc_html_e('Display name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>" /> <span><em><?php esc_html_e('This will be how your name will be displayed in the account section and in reviews', 'woocommerce'); ?></em></span>
	</p>
	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>" />
	</p>

	<?php
	/**
	 * Hook where additional fields should be rendered.
	 *
	 * @since 8.7.0
	 */
	do_action('woocommerce_edit_account_form_fields');
	?>

	<fieldset>
		<legend><?php esc_html_e('Password change', 'woocommerce'); ?></legend>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_2"><?php esc_html_e('Confirm new password', 'woocommerce'); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
		</p>
	</fieldset>
	<div class="clear"></div>

	<?php
	/**
	 * My Account edit account form.
	 *
	 * @since 2.6.0
	 */
	do_action('woocommerce_edit_account_form');
	?>

	<p>
		<?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
		<button type="submit" class="woocommerce-Button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="save_account_details" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action('woocommerce_edit_account_form_end'); ?>
</form>

<?php do_action('woocommerce_after_edit_account_form'); ?>