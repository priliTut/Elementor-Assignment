
<?php 
/*
Theme Name:   twenty-twenty-child Theme
Theme URI:    http://example.com/twenty-twenty-child/
Description: Twenty Twenty Child Theme
Author: Erez Priel
Template: twentytwenty
Version: 1.0.0
*/

//create a new user
$username = "wp-test";
$password = "123456789";
$email = "wptest@elementor.com";
$user_id - wp_create_user( $username, $password, $email);

//assigning the 'editor role for the new created user 
$user_id_role = new WP_User($user_id);
$user_id_role->set_role('editor');

//disable wp admin bar for this user
if (!function_exists('disable_admin_bar')) {

    function disable_admin_bar() {
 
        if ($user == $user_id) {

            // for the admin page
            remove_action('admin_footer', 'wp_admin_bar_render', 1000);
            // for the front-end
            remove_action('wp_footer', 'wp_admin_bar_render', 1000);

            // css override for the admin page
            function remove_admin_bar_style_backend() { 
                echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
            }     
            add_filter('admin_head','remove_admin_bar_style_backend');

            // css override for the frontend
            function remove_admin_bar_style_frontend() {
                echo '<style type="text/css" media="screen">
                html { margin-top: 0px !important; }
                * html body { margin-top: 0px !important; }
                </style>';
            }
            add_filter('wp_head','remove_admin_bar_style_frontend', 99);

        }
    }
}
add_action('init','disable_admin_bar');


?>
