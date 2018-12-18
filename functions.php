<?php 

class Dawn {
    public static $text_domain; 

    function __construct() {
        Dawn::$text_domain = 'oak';

        add_action( 'wp_enqueue_scripts', array( $this, 'dawn_enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'dawn_enqueue_scripts' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'dawn_admin_enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'dawn_admin_enqueue_scripts' ) );

        add_action( 'after_setup_theme', array( $this, 'dawn_add_theme_support' ) );

        add_action( 'init', array( $this, 'dawn_register_post_types') );
        add_action( 'init', array( $this, 'dawn_register_taxonomies') );
        add_action( 'init', array( $this, 'dawn_add_options_page') );
        add_action( 'init', array( $this, 'dawn_remove_post_type_editors' ) );  
        
        add_action( 'admin_menu', array( $this, 'dawn_handle_admin_menu' ) );

        add_action( 'acf/init', array( $this, 'dawn_add_custom_field_groups') );
        add_filter( 'acf/load_field/name=analyzes', array( $this, 'dawn_set_analyzes' ) );
        add_filter( 'acf/load_field/name=contacts', array( $this, 'dawn_set_organizations_contacts' ) );
        add_filter( 'acf/load_field/name=countries', array( $this, 'dawn_set_countries' ) );
        add_filter( 'acf/load_field/name=language_publication', array( $this, 'dawn_set_languages' ) );
        

        add_action( 'save_post', array( $this, 'dawn_set_contacts_organizations') );

        // For Ajax requests
        add_action('wp_ajax_dawn_save_analysis_model', array( $this, 'dawn_save_analysis_model') );
        add_action('wp_ajax_nopriv_dawn_save_analysis_model', array( $this, 'dawn_save_analysis_model') );

        add_action( 'wp_ajax_dawn_save_analyzes', array( $this, 'dawn_save_analyzes') );
        add_action( 'wp_ajax_nopriv_dawn_save_analyzes', array( $this, 'dawn_save_analyzes') );

        $this->dawn_contact_form();

    }

    function dawn_enqueue_styles() {
        wp_enqueue_style( 'the_style', get_stylesheet_directory_uri() . '/style.css' );
    }

    function dawn_enqueue_scripts() {
        if ( strpos( get_page_template(), "critical-analysis" ) != false ) :
            wp_enqueue_script( 'dawn_charts', get_template_directory_uri() . '/src/js/vendor/chart.bundle.min.js', array(), false, true);
            wp_enqueue_script( 'dawn_critical_analysis_front', get_template_directory_uri() . '/src/js/critical-analysis-front.js', array('jquery'), false, true);
            
            $analyzes = get_option('dawn_analyzes');
            $analyzes_field = get_field_object('analyzes');
            $selected_analyze = $analyzes_field['choices'][ get_field('analyzes') ];
            $analyzes = get_option('dawn_analyzes');
            $analysis; 
            for ( $i = 0; $i < sizeof( $analyzes ); $i++ ) :
                if ( $analyzes[$i]['title'] == $selected_analyze ) :
                    $analysis = $analyzes[$i];
                endif;
            endfor;
            wp_localize_script('dawn_critical_analysis_front', 'DATA', array(
                'analysis' => $analysis
            ));
        endif;
    }

    function dawn_admin_enqueue_styles( $hook ) {
        if ( get_current_screen()->id == 'toplevel_page_dawn_critical_analysis' || get_current_screen()->id == 'analyse-critique_page_dawn_critical_analysis_configuration' ) :
            wp_enqueue_style( 'dawn_the_style', get_stylesheet_directory_uri() . '/style.css' );
            // wp_enqueue_style( 'dawn_font-awesome', get_template_directory_uri() . '/src/css/vendor/font-awesome.min.css' );
            ?>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
            <?php
        endif;
    }

    function dawn_admin_enqueue_scripts( $hook ) { 
        if ( get_current_screen()->id == 'analyse-critique_page_dawn_critical_analysis_configuration' ) :
            wp_enqueue_script( 'dawn_critical_analysis_configuration', get_template_directory_uri() . '/src/js/critical-analysis-configuration.js', array('jquery'), false, true);
            $base_data = json_decode( file_get_contents( get_template_directory_uri() . '/src/data/basedata.json' ), true );
            wp_localize_script( 'dawn_critical_analysis_configuration', 'DATA', array (
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'adminUrl' => admin_url(),
                'templateDirectoryUri' => get_template_directory_uri(),
                'principles' => get_option('dawn_principles') ? get_option('dawn_principles') : [],
                'baseData' => $base_data
            ));
        endif;

        if ( get_current_screen()->id == 'toplevel_page_dawn_critical_analysis' ) :
            wp_enqueue_script( 'dawn_charts', get_template_directory_uri() . '/src/js/vendor/chart.bundle.min.js', array(), false, true);
            wp_enqueue_script( 'dawn_critical_analysis', get_template_directory_uri() . '/src/js/critical-analysis.js', array('jquery'), false, true);
            wp_localize_script( 'dawn_critical_analysis', 'DATA', array (
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'adminUrl' => admin_url(),
                'principles' => get_option('dawn_principles') ? get_option('dawn_principles') : [],
                // 'baseData' => $base_data,
                'analyzes' => get_option('dawn_analyzes') ? get_option('dawn_analyzes') : []
            ));
        endif;
    }

    function dawn_add_theme_support() {
        add_theme_support( 'menus' );
    }

    function dawn_add_options_page() {
        if( function_exists('acf_add_options_page') ) {
            acf_add_options_page( array(
                'page_title' => 'Options',
                'menu_title' => 'Options',
                'menu_slug' => 'options'
             ) );
        }
    }

    function dawn_handle_admin_menu() {
        add_menu_page( 'Analyse Critique', 'Analyse Critique', 'manage_options', 'dawn_critical_analysis', array( $this, 'dawn_critical_analysis' ), 'dashicons-chart-pie', 5);
        add_submenu_page( 'dawn_critical_analysis', 'Modèle d\'analyse', 'Cofiguration', 'manage_options', 'dawn_critical_analysis_configuration', array( $this, 'dawn_critical_analysis_configuration') );
    }

    function dawn_critical_analysis() {
        include get_template_directory() . '/template-parts/critical-analysis.php';
    }

    function dawn_critical_analysis_configuration() {
        include get_template_directory() . '/template-parts/critical-analysis-configuration.php';
    }

    function dawn_register_post_types() {
        register_post_type( 'organization', array(
            'labels' => array(
                'name' => 'Organisations',
                'singular_name' => 'Organisation',
                'add_new' => 'Ajouter',
                'add_new_item' => __('Ajouter une nouvelle Organisation', 'dawn'),
                'edit_item' => 'Editer'
            ),
            'description' => 'Une organisation est un organisme émetteur/concepteur d’une ou plusieurs publication(s).', 
            'public' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-groups',
        ) );

        register_post_type( 'publication', array(
            'labels' => array(
                'name' => 'Publications', 
                'singular_name' => 'Publication',
                'add_new' => 'Ajouter',
                'add_new_item' => __('Ajouter une nouvelle Publication', 'dawn'),
                'edit_item' => 'Editer'
            ), 
            'description' => 'Une publication est un texte, une norme, une loi, un cadre de référence (etc.) qui guide la rédaction d’un reporting, le structure et en uniformise les contenus.', 
            'public' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-welcome-add-page',
        ) );

        register_post_type( 'results', array(
            'labels' => array(
                'name' => __( 'Resultats', Dawn::$text_domain ), 
                'singular_name' => __ ('Resultats', Dawn::$text_domain ),
                'add_new' => 'Ajouter',
                'add_new_item' => __( 'Ajouter un nouveau Résultat', Dawn::$text_domain ),
                'edit_item' => 'Editer'
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-admin-site',
        ) );

        // register_post_type( 'country', array(
        //     'labels' => array(
        //         'name' => 'Pays', 
        //         'singular_name' => 'Pays',
        //         'add_new' => 'Ajouter',
        //         'add_new_item' => 'Ajouter un nouveau Pays',
        //         'edit_item' => 'Editer'
        //     ), 
        //     'description' => '', 
        //     'public' => true,
        //     'menu_position' => 25,
        //     'menu_icon' => 'dashicons-admin-site',
        // ) );

        register_post_type( 'quali_indic', array(
            'labels' => array(
                'name' => 'Indicateurs Qualitatifs', 
                'singular_name' => 'Indicateur Qualitatif',
                'add_new' => 'Ajouter',
                'add_new_item' => 'Ajouter un nouvel Indicateur Qualitatif',
                'edit_item' => 'Editer'
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-admin-post',
        ) );

        register_post_type( 'quanti_indic', array(
            'labels' => array(
                'name' => 'Indicateurs Quantitatifs', 
                'singular_name' => 'Indicateur Quantitatif',
                'add_new' => 'Ajouter',
                'add_new_item' => 'Ajouter un nouvel Indicateur Quantitatif',
                'edit_item' => 'Editer'
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-admin-post',
        ) );

        register_post_type( 'glossary', array(
            'labels' => array(
                'name' => 'Gloassaire', 
                'singular_name' => 'Gloassaire',
                'add_new' => 'Ajouter',
                'add_new_item' => 'Ajouter une nouvelle terminologie',
                'edit_item' => 'Editer'
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-welcome-write-blog',
        ) );

        register_post_type( 'gri', array(
            'labels' => array(
                'name' => 'Éléments d\'information', 
                'singular_name' => 'Élément d\'information',
                'add_new' => 'Ajouter',
                'add_new_item' => 'Ajouter un nouvel élément d\'information',
                'edit_item' => 'Editer'
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-video-alt',
        ) );
    }

    function dawn_remove_post_type_editors() {
        remove_post_type_support( 'publication', 'editor' );
        remove_post_type_support( 'results', 'editor' );
        remove_post_type_support( 'organization', 'editor' );
        remove_post_type_support( 'quanti_indic', 'editor' );
        remove_post_type_support( 'quali_indic', 'editor' );
    }

    function dawn_register_taxonomies() {
        // register_taxonomy( 'org_size', 'organization', array(
        //     'label' => 'Taille de l\'organisation',
        //     'labels' => array(
        //         'name' => 'Tailles',
        //         'single_name' => 'Taille de l\'Organisation',
        //     )
        // ) );

        // register_taxonomy( 'org_type', 'organization', array(
        //     'label' => 'Type de l\'organisation',
        //     'labels' => array(
        //         'name' => 'Types',
        //         'single_name' => 'Type de l\'Organisation',
        //     )
        // ) );


        register_taxonomy( 'org_activity', 'organization', array(
            'label' => 'Secteur d\'activité',
            'labels' => array(
                'name' => 'Secteurs d\'activité',
                'single_name' => 'Secteur d\'activité',
            ),
            'show_in_quick_edit' => false,
            'meta_box_cb' => false
        ) );

        // register_taxonomy( 'langue', 'country', array(
        //     'label' => 'langue',
        //     'labels' => array(
        //         'name' => 'Langues',
        //         'single_name' => 'Langue',
        //     )
        // ) );

        // register_taxonomy( 'region', 'country', array(
        //     'label' => 'Régions',
        //     'labels' => array(
        //         'name' => 'Régions',
        //         'single_name' => 'Régions',
        //     )
        // ) );

        register_taxonomy( 'publication_type', 'publication', array(
            'label' => 'Type',
            'labels' => array(
                'name' => 'Types',
                'single_name' => 'Type',
            )
        ) );

        register_taxonomy( 'code_type', array ( 'quali_indic', 'quanti_indic') , array(
            'label' => 'Type de code',
            'labels' => array(
                'name' => 'Types de code',
                'single_name' => 'Type de code',
            )
        ) );

        register_taxonomy( 'value_type', array ( 'quali_indic', 'quanti_indic' ), array(
            'label' => 'Type de code',
            'labels' => array(
                'name' => 'Types de code',
                'single_name' => 'Type de code',
            )
        ) );

        register_taxonomy( 'standards_series', 'gri', array(
            'label' => 'Standards/Séries',
            'labels' => array(
                'name' => 'Standard ou Séries',
                'single_name' => 'Standards/Séries',
            )
        ) );
    }

    function dawn_add_custom_field_groups() {
        if ( !function_exists('acf_add_local_field_group') ) return;

        include get_template_directory() . '/functions/options.php';
        include get_template_directory() . '/functions/organizations.php';
        include get_template_directory() . '/functions/results.php';
        // include get_template_directory() . '/functions/org-sizes.php';
        include get_template_directory() . '/functions/activities.php';
        // include get_template_directory() . '/functions/countries.php';
        include get_template_directory() . '/functions/regions.php';
        include get_template_directory() . '/functions/publications.php';
        include get_template_directory() . '/functions/quali-indics.php';
        include get_template_directory() . '/functions/quanti-indics.php';
        include get_template_directory() . '/functions/glossary.php';
        include get_template_directory() . '/functions/gri.php';
        include get_template_directory() . '/functions/standards-series.php';
        include get_template_directory() . '/functions/critical_analyzes.php';
    }

    function dawn_set_analyzes( $field ) {
        $choices = $field['choices'];
        $analyzes = get_option( 'dawn_analyzes' ) ? get_option( 'dawn_analyzes') : [];
        for ( $i = 0; $i < sizeof( $analyzes ); $i++) {
            $choices[] = $analyzes[$i]['title'];
        }
        $field['choices'] = $choices;
        return $field;
    }

    function dawn_set_organizations_contacts( $field ) {
        $choices = $field['choices'];

        $api_key = get_field('crm_api_key', 'options');
        $api_secret = get_field('crm_api_secret', 'options');
        $endpoint = get_field('crm_api_endpoint', 'options');

        if ( $api_key == '' || $api_secret == '' || $endpoint == '' ) :
            return $field;
        endif;
        
        // Lets get all the contacts first: 
        $get_contacts_url = $endpoint . 'customers?api_key=' . $api_key . '&api_secret=' . $api_secret;
        $contacts = json_decode( wp_remote_post( $get_contacts_url)['body'] );
        $choices = [];
        foreach( $contacts as $contact ) :
            $field['choices'][] = $contact->email;
        endforeach;

        return $field;
    }

    function dawn_get_countries() {
        $country_query_result = wp_remote_get( 'https://restcountries.eu/rest/v2/all' );
        $countries = json_decode( $country_query_result['body'] );
        return $countries;
    }

    function dawn_set_countries( $field ) {
        $choices = $field['choices'];

        $countries = $this->dawn_get_countries();
        foreach( $countries as $country ) :
            $choices[] = $country->name;
        endforeach;
    
        $field['choices'] = $choices;
        return $field;
    }

    function dawn_set_languages( $field ) {
        $choices = $field['choices'];

        $countries = $this->dawn_get_countries();

        foreach( $countries as $country ) :
            foreach( $country->languages as $language ) :
                if ( !in_array( $language->name, $choices ) )
                    $choices[] = $language->name;
            endforeach;
        endforeach;

        $field['choices'] = $choices;
 
        return $field;
    }

    function dawn_set_contacts_organizations( $post_id ) {
        if ( !function_exists ('get_field_object') )
            return; 
        
        $post_type = get_post_type( $post_id );
        if ( $post_type != 'organization' ) :
            return;
        endif;

        $api_key = get_field('crm_api_key', 'options');
        $api_secret = get_field('crm_api_secret', 'options');
        $endpoint = get_field('crm_api_endpoint', 'options');

        $contacts_object = get_field_object( 'contacts' );
        $the_query = new WP_Query( array( 'post_type'=> 'organization' ) );
        $posts = $the_query->posts;
        foreach( $posts as $post ) :
            $post_name = $post->post_name;
            $post_id = $post->ID;
            $selected_contacts_indexes = get_field( 'contacts', $post_id );
            $selected_contacts = [];
            // var_dump( $selected_contacts_indexes );
            foreach ( $selected_contacts_indexes as $selected_contact_index ) :
                if ( isset( $contacts_object['choices'][ $selected_contact_index ] ) ) :
                    $selected_contact_name = $contacts_object['choices'][ $selected_contact_index ];
                    $selected_contacts[] = $selected_contact_name;
                endif;
            endforeach;

            foreach ( $selected_contacts as $selected_contact ) :   
                $url = 'http://localhost:8888/boilerplate/zbs_api/create_customer?api_key=' . $api_key . '&api_secret=' . $api_secret;

                $params = array(      
                    'email'  => $selected_contact,
                    'organisation' => $post_name
                );

                $result = wp_remote_post( $url, array(
                    'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
                    'body'        => json_encode( $params ),
                    'method'      => 'POST',
                    'data_format' => 'body',
                ));
            endforeach;
        endforeach;
    }

    function dawn_contact_form() {
        if ( ( !isset( $_GET['email'] ) ) || ( !isset( $_GET['subject'] ) ) || ( !isset( $_GET['content'] ) || ( !is_email( $_GET['email'] ) ) || ( trim( $_GET['content'] ) == '' ) ))
            return;
        if ( wp_mail( $_GET['email'], $_GET['subject'], $_GET['content']) ) {
            var_dump('Success');
        } else {
            var_dump('Error');
        }
    }

    function dawn_save_analysis_model() {
        $principles = $_POST['data'];
        $image_url = '';

        foreach( $principles as $key => $single_principle) :
            if ( !filter_var( $single_principle['image'], FILTER_VALIDATE_URL ) ) :
                // Uploading the image
                $upload_dir  = wp_upload_dir();
                $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
            
                $img             = str_replace( 'data:image/png;base64,', '', $single_principle['image'] );
                $img             = str_replace( ' ', '+', $img );
                $decoded         = base64_decode( $img );
                $filename        = $single_principle['principle'] . '.jpeg';
                $file_type       = 'image/jpeg';
                $hashed_filename = md5( $filename . microtime() ) . '_' . $filename;
                $upload_file = file_put_contents( $upload_path . $hashed_filename, $decoded );
                $attachment = array(
                    'post_mime_type' => $file_type,
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $hashed_filename ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit',
                    'guid'           => $upload_dir['url'] . '/' . basename( $hashed_filename )
                );
            
                $attach_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $hashed_filename );
                $url = wp_get_attachment_image_url( $attach_id );
                $single_principle['image'] = $url;
                $image_url = $single_principle['image'];
                $principles[ $key ] = $single_principle;
                // Done uploading the image
            endif;
        endforeach;
        

        update_option( 'dawn_principles', $principles, false );
        wp_send_json_success( array(
            'image' => $principles['0']['image']
        ) );
    }

    function dawn_save_analyzes() {
        $analyzes = $_POST['analyzes'];
        update_option( 'dawn_analyzes', $analyzes );
        wp_send_json_success();
    }

    function save_image( $base64_img, $title ) {
        // Upload dir.
        $upload_dir  = wp_upload_dir();
        $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
    
        $img             = str_replace( 'data:image/png;base64,', '', $base64_img );
        $img             = str_replace( ' ', '+', $img );
        $decoded         = base64_decode( $img );
        $filename        = $title . '.jpeg';
        $file_type       = 'image/jpeg';
        $hashed_filename = md5( $filename . microtime() ) . '_' . $filename;
    
        // Save the image in the uploads directory.
        $upload_file = file_put_contents( $upload_path . $hashed_filename, $decoded );
    
        $attachment = array(
            'post_mime_type' => $file_type,
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $hashed_filename ) ),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'guid'           => $upload_dir['url'] . '/' . basename( $hashed_filename )
        );
    
        $attach_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $hashed_filename );
        $url = wp_get_attachment_image_url( $attach_id );
        // return $url;
    }
}

$dawn = new Dawn();

