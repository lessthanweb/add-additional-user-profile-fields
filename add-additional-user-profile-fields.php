<?php
/*
Plugin Name: Add Additional User Profile Fields
Plugin URI: https://www.lessthanweb.com/blog/add-additional-profile-fields-to-the-user-profile
Description: lessthanweb. How To: Add Additional Fields To The User Profile example code.
Version: 1.0
Author: lessthanweb.
Author URI: https://www.lessthanweb.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: lessthanweb
*/

/*
Add Additional Fields To The User Profile is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Add Additional Fields To The User Profile is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Add Additional Fields To The User Profile. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Make sure we don't expose any info if called directly
if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	die();
}

/**
 * Display extra profile fields in user profile page.
 *
 * @param object $user
 * @return string
 *
 */
function lessthanweb_display_extra_profile_fields( $user ) {
    ?>
    <h3><?php _e( 'Extra profile information', 'lessthanweb' ); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="lessthanweb-message"><?php _e( 'Message', 'lessthanweb' ); ?></label></th>
            <td>
                <textarea type="text" name="lessthanweb_message" id="lessthanweb-message" class="regular-text"><?php echo esc_html( get_user_meta( $user->ID, 'lessthanweb_message', true ) ); ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="lessthanweb-phone"><?php _e( 'Phone', 'lessthanweb' ); ?></label></th>
            <td>
                <input type="text" type="text" name="lessthanweb_phone" id="lessthanweb-phone" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'lessthanweb_phone', true ) ); ?>" />
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'lessthanweb_display_extra_profile_fields' );
add_action( 'edit_user_profile', 'lessthanweb_display_extra_profile_fields' );

/**
 * Save information in the extra profile fields to user meta.
 *
 * @param   integer $user_id
 * @return  boolean
 *
 */
function lessthanweb_save_extra_profile_fields( $user_id ) {
    //  We should check if current user can edit users.
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
 
    //  Get the posted fields.
    //  Do note that you should always escape any information that was posted.
    $message = isset( $_POST['lessthanweb_message'] ) ? wp_strip_all_tags( $_POST['lessthanweb_message'] ) : '';            
    $phone = isset( $_POST['lessthanweb_phone'] ) ? sanitize_text_field( $_POST['lessthanweb_phone'] ) : '';
     
    //  Update the user meta.
    update_user_meta( $user_id, 'lessthanweb_message', $message );
    update_user_meta( $user_id, 'lessthanweb_phone', $phone );
 
    return true;
}
add_action( 'personal_options_update', 'lessthanweb_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'lessthanweb_save_extra_profile_fields' );
