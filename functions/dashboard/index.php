<?php 

class Oak_Dashboard {
    function __construct() {
        // For Admin side menu, system bar and app bar 
        add_action( 'admin_head', array ( $this, 'oak_wordpress_dashboard' ) );
        // For the dashboard view
        add_action('wp_dashboard_setup', array( $this, 'oak_dashboard_view' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        $this->handle_ajax_calls();
    }

    function oak_dashboard_view() {
        include get_template_directory() . '/functions/dashboard/views/dashboard.php';
    }

    function oak_wordpress_dashboard() {
        include get_template_directory() . '/functions/dashboard/views/admin-menu.php';
        include get_template_directory() . '/functions/dashboard/views/system-bar.php';
        include get_template_directory() . '/functions/dashboard/views/app-bar.php';

        if ( !isset( $_GET['elements'] ) ) :
            include get_template_directory() . '/functions/dashboard/views/modal.php';
        endif;
    }

    function admin_enqueue_scripts() {
        // Admin menu
        wp_enqueue_script( 'admin_menu_script', get_template_directory_uri() . '/functions/dashboard/src/js/admin-menu.js', array('jquery'), false, true );
        wp_localize_script( 'admin_menu_script', 'ADMIN_MENU_DATA', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'siteLanguage' => Oak::$site_language,
            'currentUser' => wp_get_current_user()->ID,
            'oak_fitler_content_variables' => get_option('oak_fitler_content_variables') ? get_option('oak_fitler_content_variables') : []
        ) );

        if ( !isset( $_GET['elements'] ) ) :
            wp_enqueue_script( 'admin_modal', get_template_directory_uri() . '/functions/dashboard/src/js/modal.js', array('jquery'), false, true );
        endif;
    }

    function handle_ajax_calls() {
        add_action('wp_ajax_oak_register_fitler_content_variables', array( $this, 'oak_register_fitler_content_variables') );
        add_action('wp_ajax_nopriv_oak_register_fitler_content_variables', array( $this, 'oak_register_fitler_content_variables') );
    }

    function oak_register_fitler_content_variables() {
        Oak::$content_filters[ $_POST['currentUser'] ] = array(
            'selected_steps' => $_POST['selected_steps'],
            'selected_publications' => $_POST['selected_publications'],
        );
        update_option( 'oak_fitler_content_variables', Oak::$content_filters );
        wp_send_json_success();
    }
}

$dashboard = new Oak_Dashboard();