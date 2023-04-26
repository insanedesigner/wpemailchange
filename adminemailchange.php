<?php
/**
 * Plugin Name: Change Email
 * Plugin URI: https://plugins.sudeep.co.in/
 * Description: Allows administrators to change the admin email setting without needing to provide outbound email or recipient email credentials.
 * Version: 1.0.0
 * Author: Sudeep S
 * Author URI: https://www.sudeep.co.in/
 */

// Add the settings page to the admin menu
function change_admin_email_menu() {
    add_options_page( 'Change Admin Email Settings', 'Change Admin Email', 'manage_options', 'change-admin-email', 'change_admin_email_settings' );
}
add_action( 'admin_menu', 'change_admin_email_menu' );

// Define the settings page
function change_admin_email_settings() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'change-admin-email-settings-group' ); ?>
            <?php do_settings_sections( 'change-admin-email-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'New Admin Email', 'change-admin-email' ); ?></th>
                    <td><input type="email" name="admin_email" value="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <p>Developed by <a href="https://www.sudeep.co.in">Sudeep S</a> | If you are looking for a Web Development Company for your Project Feel free to have a discussion on <a href="mailto:sudeep@sudeep.co.in">sudeep@sudeep.co.in</a></p>
    </div>
    <?php
}

// Register the settings
function change_admin_email_register_settings() {
    register_setting( 'change-admin-email-settings-group', 'admin_email' );
}
add_action( 'admin_init', 'change_admin_email_register_settings' );

// Update the admin email address
function change_admin_email_update_email() {
    $admin_email = sanitize_email( $_POST['admin_email'] );
    update_option( 'admin_email', $admin_email );
    wp_mail( $admin_email, 'New Admin Email', 'Your admin email has been updated.' );
    add_settings_error( 'change-admin-email', 'change-admin-email-success', 'Your admin email has been updated.', 'updated' );
}
add_action( 'admin_post_change_admin_email', 'change_admin_email_update_email' );
