<?php

class Post_meta_boxes {
    function __construct() {
        add_action( 'add_meta_boxes', array ( $this, 'oak_add_meta_box_to_posts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'save_post', array ( $this, 'oak_save_post_meta_fields' ) );
    }

    function oak_add_meta_box_to_posts() {
        $posts = [ 'post', 'page' ];
        foreach( $posts as $post ) :
            add_meta_box(
                'objects_selector', // $id
                __( 'Objets', Oak::$text_domain ), // $title
                array( $this, 'oak_add_meta_box_to_posts_view' ), // $callback
                $post, // $screen
                'normal', // $context
                'high', // $priority
                array( 'element' => 'object', 'elements' => Oak::$all_objects_without_redundancy, 'select_name' => 'objects_selector[]' ) 
            );

            add_meta_box(
                'good_practices_selector', // $id
                __( 'Bonnes pratiques', Oak::$text_domain ), // $title
                array( $this, 'oak_add_meta_box_to_posts_view' ),
                $post, // $screen
                'normal', // $context
                'high', // $priority
                array( 'element' => 'goodpractice', 'elements' => Oak::$goodpractices_without_redundancy, 'select_name' => 'good_practices_selector[]' ) 
            );

            add_meta_box(
                'sources_selector', // $id
                __( 'Sources', Oak::$text_domain ), // $title
                array( $this, 'oak_add_meta_box_to_posts_view' ),
                $post, // $screen
                'normal', // $context
                'high', // $priority
                array( 'element' => 'source', 'elements' => Oak::$sources_without_redundancy, 'select_name' => 'sources_selector[]' ) 
            );

            add_meta_box(
                'quantis_selector', // $id
                __( 'Indicateurs Quantitatifs', Oak::$text_domain ), // $title
                array( $this, 'oak_add_meta_box_to_posts_view' ),
                $post, // $screen
                'normal', // $context
                'high', // $priority
                array( 'element' => 'quanti', 'elements' => Oak::$quantis_without_redundancy, 'select_name' => 'quantis_selector[]' ) 
            );

            add_meta_box(
                'qualis_selector', // $id
                __( 'Indicateurs Qualitatifs', Oak::$text_domain ), // $title
                array( $this, 'oak_add_meta_box_to_posts_view' ),
                $post, // $screen
                'normal', // $context
                'high', // $priority
                array( 'element' => 'quali', 'elements' => Oak::$qualis_without_redundancy, 'select_name' => 'qualis_selector[]' ) 
            );
        endforeach;
    }

    function oak_add_meta_box_to_posts_view( $post, $args ) {
        include get_template_directory() . '/functions/post_meta_boxes/views/meta_box_view.php';
    }

    function enqueue_scripts() {
        if ( get_current_screen()->id == 'post' || get_current_screen()->id == 'page' ) :
            wp_enqueue_script( 'oak_edit_post', get_template_directory_uri() . '/functions/post_meta_boxes/src/js/metax_boxes.js', array('jquery'), false, true );
        endif;
    }

    function oak_save_post_meta_fields( $post_id ) {
        if ( !isset( $_POST['objects_selector'] ) 
            && !isset( $_POST['good_practices_selector'] ) 
            && !isset( $_POST['quantis_selector'] ) 
            && !isset( $_POST['sources_selector'] ) 
            && !isset( $_POST['qualis_selector'] )) :
            return;
        endif;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // check permissions
        if ( 'page' === $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        $old = get_post_meta( $post_id, 'objects_selector', true );
        if ( isset( $_POST['objects_selector'] ) ) :

            $new = $_POST['objects_selector'];

            if ( $new && $new !== $old ) {
                update_post_meta( $post_id, 'objects_selector', $new );
            } elseif ( '' === $new && $old ) {
                delete_post_meta( $post_id, 'objects_selector', $old );
            };
        else : 
            delete_post_meta( $post_id, 'objects_selector', $old );
        endif;

        $old_goodpractices = get_post_meta( $post_id, 'good_practices_selector', true );
        if ( isset( $_POST['good_practices_selector'] ) ) :
            $new_goodpractices = $_POST['good_practices_selector'];

            if ( $new_goodpractices && $new_goodpractices !== $old_goodpractices ) {
                update_post_meta( $post_id, 'good_practices_selector', $new_goodpractices );
            } elseif ( '' === $new_goodpractices && $old_goodpractices ) {
                delete_post_meta( $post_id, 'good_practices_selector', $old_goodpractices );
            };
        else :
            delete_post_meta( $post_id, 'good_practices_selector', $old_goodpractices );
        endif;

        $old_sources = get_post_meta( $post_id, 'sources_selector', true );
        if ( isset( $_POST['sources_selector'] ) ) :
            $new_sources = $_POST['sources_selector'];

            if ( $new_sources && $new_sources !== $old_sources ) {
                update_post_meta( $post_id, 'sources_selector', $new_sources );
            } elseif ( '' === $new_sources && $old_sources ) {
                delete_post_meta( $post_id, 'sources_selector', $old_sources );
            };
        else :
            delete_post_meta( $post_id, 'sources_selector', $old_sources );
        endif;

        $old_quantis = get_post_meta( $post_id, 'quantis_selector', true );
        if ( isset( $_POST['quantis_selector'] ) ) :
            $new_quantis = $_POST['quantis_selector'];

            if ( $new_quantis && $new_quantis !== $old_quantis ) {
                update_post_meta( $post_id, 'quantis_selector', $new_quantis );
            } elseif ( '' === $new_quantis && $old_quantis ) {
                delete_post_meta( $post_id, 'quantis_selector', $old_quantis );
            };
        else :
            delete_post_meta( $post_id, 'quantis_selector', $old_quantis );
        endif;

        $old_qualis = get_post_meta( $post_id, 'qualis_selector', true );
        if ( isset( $_POST['qualis_selector'] ) ) :
            $new_qualis = $_POST['qualis_selector'];

            if ( $new_qualis && $new_qualis !== $old_qualis ) {
                update_post_meta( $post_id, 'qualis_selector', $new_qualis );
            } elseif ( '' === $new_qualis && $old_qualis ) {
                delete_post_meta( $post_id, 'qualis_selector', $old_qualis );
            };
        else :
            delete_post_meta( $post_id, 'qualis_selector', $old_qualis );
        endif;
    }
}

$meta_boxes = new Post_meta_boxes();