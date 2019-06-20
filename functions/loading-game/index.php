<?php 

class Loading_Game {
    function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'loading_game_admin_enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'loading_game_admin_enqueue_scripts' ) );

        $this->render_game();
    }

    function loading_game_admin_enqueue_scripts() {
        // wp_enqueue_script( 'oak_loading_game', get_template_directory_uri() . '/functions/loading-game/src/js/loading-game.js', array('jquery'), false, true );
        
        $character_idl_animations = [];
        for ( $i = 1; $i < 13; $i++ ) :
            $character_idl_animations[] = get_template_directory_uri() . '/functions/loading-game/src/sprites/drone/idle/' . $i . '.png';
        endfor;
        wp_localize_script( 'oak_loading_game', 'LOADING_GAME_DATA', array(
            'characterIdlAnimationImage' => $character_idl_animations,
            'fireBeamImage' => get_template_directory_uri() . '/functions/loading-game/src/sprites/beams/bluebeam.png'
        ) );
    }

    function loading_game_admin_enqueue_styles() {
        wp_enqueue_style( 'oak_loading_game_style', get_template_directory_uri() . '/functions/loading-game/src/css/loading-game.css' );
    }

    function render_game() {
        include_once get_template_directory() . '/functions/loading-game/views/game-view.php';
    }
}

$loading_game = new Loading_Game();