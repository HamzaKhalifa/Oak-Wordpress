<?php 

class Oak_Chat {
    function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'chat_enqueue_style' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'chat_enqueue_scripts' ) );

        add_action( 'wp_ajax_modify_authenticated', array( $this, 'modify_authenticated') );
        add_action( 'wp_ajax_nopriv_modify_authenticated', array( $this, 'modify_authenticated') );

        $this->render_chat();
    }

    function chat_enqueue_style() {
        wp_enqueue_style( 'oak_main_chat_style', get_template_directory_uri() . '/functions/chat/src/css/chat-main-style.css' );
    }

    function chat_enqueue_scripts() {
        // Firebase
        wp_enqueue_script( 'oak_firebase_core', 'https://www.gstatic.com/firebasejs/6.2.4/firebase-app.js', array(), false, true );
        wp_enqueue_script( 'oak_firebase_auth', 'https://www.gstatic.com/firebasejs/6.2.4/firebase-auth.js', array(), false, true );
        wp_enqueue_script( 'oak_firebase_firestore', 'https://www.gstatic.com/firebasejs/6.2.4/firebase-firestore.js', array(), false, true );
        wp_enqueue_script( 'oak_firebase_database', 'https://www.gstatic.com/firebasejs/3.1.0/firebase-database.js', array(), false, true );

        wp_enqueue_script( 'oak_main_firebase_conf', get_template_directory_uri() . '/functions/chat/src/js/firebase-conf.js', array(), false, true );
        wp_enqueue_script( 'oak_main_chat_script', get_template_directory_uri() . '/functions/chat/src/js/chat-main-script.js', array('jquery'), false, true );
        wp_localize_script( 'oak_main_chat_script', 'OAK_MAIN_CHAT_DATA', array(
            'ajaxUrl' => admin_url ('admin-ajax.php'),
            'authenticated' => get_option( 'oak_chat_authenticated' ) ? get_option( 'oak_chat_authenticated' ) : 'false'
        ) );
    }

    function render_chat() {
        include_once get_template_directory() . '/functions/chat/views/chat-view.php';
    }

    function modify_authenticated() {
        $authenticated = $_POST['data'];
        update_option( 'oak_chat_authenticated', $authenticated );

        wp_send_json_success( array(
            'sign in' => get_option( 'oak_chat_authenticated' )
        ) );
    }
}

$oak_chat = new Oak_Chat();