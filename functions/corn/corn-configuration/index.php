<?php 

class Corn_Configuration {
    function __construct() {
        add_action( 'admin_menu', array( $this, 'handle_admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        $this->handle_ajax_calls();
    }

    function handle_admin_menu() {
        add_menu_page( 'Paramètres', 'Paramètres', 'manage_options', 'oak_corn_configuration_page', array( $this, 'oak_corn_configuration_page' ), 'dashicons-chart-pie', 100 );
    }

    function oak_corn_configuration_page() {
        include get_template_directory() . '/functions/corn/corn-configuration/views/corn-configuration-page.php';
    }

    function admin_enqueue_scripts() {
        // For the corn configuration page
        if ( get_current_screen()->id == 'toplevel_page_oak_corn_configuration_page' ) :
            wp_enqueue_script( 'oak_corn_configuration_page', get_template_directory_uri() . '/functions/corn/corn-configuration/src/js/corn-configuration-page.js', array( 'jquery', 'wp-color-picker' ), false, true);
            wp_localize_script( 'oak_corn_configuration_page', 'DATA', array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'socialMedias' => Oak::$social_medias,
                'oakColors' => get_option( 'oak_colors' ) != false ? get_option( 'oak_colors' ) : [],
                'oakNavBarData' => get_option( 'oak_nav_bar_data' ) != false ? get_option( 'oak_nav_bar_data' ) : [],
            ) );
        endif;
    }

    function handle_ajax_calls() {
        add_action( 'wp_ajax_oak_corn_save_general_configuration', array( $this, 'oak_corn_save_general_configuration') );
        add_action( 'wp_ajax_nopriv_oak_corn_save_general_configuration', array( $this, 'oak_corn_save_general_configuration') );

        add_action( 'wp_ajax_oak_corn_save_social_media_configuration', array( $this, 'oak_corn_save_social_media_configuration') );
        add_action( 'wp_ajax_nopriv_oak_corn_save_social_media_configuration', array( $this, 'oak_corn_save_social_media_configuration') );

        add_action( 'wp_ajax_oak_corn_save_app_bar_settings', array( $this, 'oak_corn_save_app_bar_settings') );
        add_action( 'wp_ajax_nopriv_oak_corn_save_app_bar_settings', array( $this, 'oak_corn_save_app_bar_settings') );;

        add_action( 'wp_ajax_oak_corn_save_nav_bar_settings', array( $this, 'oak_corn_save_nav_bar_settings') );
        add_action( 'wp_ajax_nopriv_oak_corn_save_nav_bar_settings', array( $this, 'oak_corn_save_nav_bar_settings') );

        add_action( 'wp_ajax_oak_corn_save_styles_settings', array( $this, 'oak_corn_save_styles_settings') );
        add_action( 'wp_ajax_nopriv_oak_corn_save_styles_settings', array( $this, 'oak_corn_save_styles_settings') );

        add_action('wp_ajax_oak_regenerate_indexes', array( $this, 'oak_regenerate_indexes') );
        add_action('wp_ajax_nopriv_oak_regenerate_indexes', array( $this, 'oak_regenerate_indexes') );
    }

    function oak_corn_save_general_configuration() {
        global $wpdb;

        $general_settings = json_decode( stripslashes( $_POST['generalSettings'] ), true );

        $site_logo = $general_settings['siteLogo'];
        $blog_description = $general_settings['tagline'];
        $blog_name = $general_settings['siteTitle'];
        $organization_name = $general_settings['organizationName'];
        $site_icon = $general_settings['siteIcon'];

        $custom_logo_id = get_theme_mod( 'custom_logo' );

        $site_logo_upload_string_position = strpos( $site_logo, 'uploads/' );
        $site_logo_to_store = substr( $site_logo, $site_logo_upload_string_position + 8, strlen( $site_logo ) - $site_logo_upload_string_position );

        $result = $wpdb->update(
            $wpdb->prefix . 'postmeta',
            array (
                'meta_value' => $site_logo_to_store
            ),
            array(
                'post_id' => $custom_logo_id,
                'meta_key' => '_wp_attached_file'
            )
        );

        $custom_site_icon_id = get_option('site_icon');

        $site_icon_upload_string_position = strpos( $site_icon, 'uploads/' );
        $site_icon_to_store = substr( $site_icon, $site_icon_upload_string_position + 8, strlen( $site_icon ) - $site_icon_upload_string_position );

        $result = $wpdb->update(
            $wpdb->prefix . 'postmeta',
            array (
                'meta_value' => $site_icon_to_store
            ),
            array(
                'post_id' => $custom_site_icon_id,
                'meta_key' => '_wp_attached_file'
            )
        );

        $table_name = $wpdb->prefix . 'postmeta';

        update_option( 'blogdescription', $blog_description );
        update_option( 'blogname', $blog_name );
        update_option( 'oak_organization_name', $organization_name );

        wp_send_json_success( array(
            'generalSettings' => $general_settings,
            'result' => $result,
            'site_icon' => $site_icon,
            'site_logo_id' => $custom_logo_id
        ) );
    }

    function oak_corn_save_social_media_configuration() {
        $social_media_data = $_POST['socialMediaData'];

        update_option( 'oak_social_media_data', $social_media_data );
        update_option( 'oak_social_system_bar_background_color', $_POST['socialMediaBackgroundColor'] );

        wp_send_json_success();
    }

    function oak_corn_save_app_bar_settings() {
        $app_bar_settings = $_POST['appBarSettings'];
        foreach( $app_bar_settings as $single_setting ) :
            update_option( $single_setting['name'], $single_setting['value'] );
        endforeach;

        update_option( 'oak_app_bar_background_color', $_POST['appBarBackgroundColor'] );

        wp_send_json_success();
    }

    function oak_corn_save_nav_bar_settings() {
        $nav_bar_data = json_decode( stripslashes( $_POST['navBarData'] ) );
        update_option( 'oak_nav_bar_data', $nav_bar_data );

        wp_send_json_success();
    }

    function oak_corn_save_styles_settings() {
        $colors = json_decode( stripslashes( $_POST['colors'] ) );
        update_option( 'oak_colors', $colors );

        wp_send_json_success();
    }

    function oak_regenerate_indexes() {
        include get_template_directory() . '/functions/auto-index.gen.php';
    }
    
}

$corn_configuration = new Corn_Configuration();