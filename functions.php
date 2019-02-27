<?php 

class Oak {
    public static $text_domain;
    public static $fields_table_name;
    public static $forms_table_name;
    public static $models_table_name;
    public static $organizations_table_name;
    public static $publications_table_name;
    public static $glossaries_table_name;
    public static $qualis_table_name;
    public static $quantis_table_name;
    public static $taxonomies_table_name;
    public static $terms_and_objects_table_name;
    public static $forms_and_fields_table_name;
    public static $models_and_forms_table_name;

    public static $revisions;

    public static $fields;
    public static $fields_without_redundancy;
    public static $field_properties;
    public static $field_types;

    public static $forms;
    public static $forms_without_redundancy;
    public static $forms_attributes;
    public static $form_properties;
    public static $form_other_elements;
    public static $all_forms_and_fields = [];

    public static $objects;
    public static $terms;
    public static $all_objects;
    public static $all_terms;
    public static $all_objects_without_redundancy = [];
    public static $all_terms_without_redundancy = [];
    public static $terms_without_redundancy = [];

    public static $models;
    public static $models_without_redundancy;
    public static $model_properties;
    public static $model_other_elements;
    public static $all_models_and_forms = [];
    public static $current_model_fields = [];
    public static $object_properties = [];
    public static $term_properties = [];
    
    public static $organizations;
    public static $organizations_without_redundancy;
    public static $organization_properties;

    public static $publications;
    public static $publications_without_redundancy;
    public static $publication_properties;

    public static $glossaries;
    public static $glossaries_without_redundancy;
    public static $glossary_properties;

    public static $qualis;
    public static $qualis_without_redundancy;
    public static $quali_properties;

    public static $quantis;
    public static $quantis_without_redundancy;
    public static $quanti_properties;

    public static $taxonomies;
    public static $taxonomies_without_redundancy;
    public static $taxonomy_properties;

    public static $main_color = '#003366';
    public static $secondary_text_color = '#bcc7d9';
    public static $selected_color = '#7b7b7b';

    function __construct() {
        Oak::$text_domain = 'oak';

        global $wpdb;

        Oak::$revisions = [];
        
        Oak::$fields_table_name = $wpdb->prefix . 'oak_fields';
        Oak::$forms_table_name = $wpdb->prefix . 'oak_forms';
        Oak::$models_table_name = $wpdb->prefix . 'oak_models';
        Oak::$taxonomies_table_name = $wpdb->prefix . 'oak_taxonomies';
        Oak::$organizations_table_name = $wpdb->prefix . 'oak_organizations';
        Oak::$publications_table_name = $wpdb->prefix . 'oak_publications';
        Oak::$glossaries_table_name = $wpdb->prefix . 'oak_glossaries';
        Oak::$qualis_table_name = $wpdb->prefix . 'oak_qualis';
        Oak::$quantis_table_name = $wpdb->prefix . 'oak_quantis';
        Oak::$terms_and_objects_table_name = $wpdb->prefix . 'oak_terms_and_objects';
        Oak::$forms_and_fields_table_name = $wpdb->prefix . 'oak_forms_and_fields';
        Oak::$models_and_forms_table_name = $wpdb->prefix . 'oak_models_and_forms';

        Oak::$forms_attributes = [];
        Oak::$all_objects = [];
        Oak::$all_terms = [];
        Oak::$all_terms_without_redundancy = [];

        Oak::$field_types = array ( 
            array ( 'value' => 'Texte', 'innerHTML' => 'Texte' ), 
            array ( 'value' => 'Zone de Texte', 'innerHTML' => 'Zone de Texte'), 
            array ( 'value' => 'Image', 'innerHTML' => 'Image' ), 
            array ( 'value' => 'Fichier', 'innerHTML' => 'Fichier' ) 
        );

        add_action( 'wp_enqueue_scripts', array( $this, 'oak_enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'oak_enqueue_scripts' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'oak_admin_enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'oak_admin_enqueue_scripts' ) );

        add_action( 'after_setup_theme', array( $this, 'oak_add_theme_support' ) );

        // add_action( 'init', array( $this, 'add_cors_http_header' ) );
        add_action('wp_dashboard_setup', array ( $this, 'oak_wordpress_dashboard' ) );
        
        add_action( 'admin_menu', array( $this, 'oak_handle_admin_menu' ) );
        
        $this->oak_ajax_calls();

        $this->oak_contact_form();
    }
    
    function oak_ajax_calls() {
        add_action('wp_ajax_oak_save_save_configuration', array( $this, 'oak_save_save_configuration') );
        add_action('wp_ajax_nopriv_oak_save_save_configuration', array( $this, 'oak_save_save_configuration') );

        add_action('wp_ajax_oak_save_analysis_model', array( $this, 'oak_save_analysis_model') );
        add_action('wp_ajax_nopriv_oak_save_analysis_model', array( $this, 'oak_save_analysis_model') );

        add_action( 'wp_ajax_oak_save_analyzes', array( $this, 'oak_save_analyzes') );
        add_action( 'wp_ajax_nopriv_oak_save_analyzes', array( $this, 'oak_save_analyzes') );

        add_action( 'wp_ajax_oak_get_organizations', array( $this, 'oak_get_organizations') );
        add_action( 'wp_ajax_nopriv_oak_get_organizations', array( $this, 'oak_get_organizations') );

        add_action( 'wp_ajax_oak_corn_import_publications_data', array( $this, 'oak_corn_import_publications_data') );
        add_action( 'wp_ajax_nopriv_oak_corn_import_publications_data', array( $this, 'oak_corn_import_publications_data') );

        add_action( 'wp_ajax_oak_corn_content_library_search', array( $this, 'oak_corn_content_library_search') );
        add_action( 'wp_ajax_nopriv_oak_corn_content_library_search', array( $this, 'oak_corn_content_library_search') );

        add_action( 'wp_ajax_oak_register_element', array( $this, 'oak_register_element') );
        add_action( 'wp_ajax_nopriv_oak_register_element', array( $this, 'oak_register_element') );

        add_action( 'wp_ajax_oak_send_to_trash', array( $this, 'oak_send_to_trash') );
        add_action( 'wp_ajax_nopriv_oak_send_to_trash', array( $this, 'oak_send_to_trash') );

        add_action( 'wp_ajax_oak_delete_definitely', array( $this, 'oak_delete_definitely') );
        add_action( 'wp_ajax_nopriv_oak_delete_definitely', array( $this, 'oak_delete_definitely') );

        add_action( 'wp_ajax_oak_restore_from_trash', array( $this, 'oak_restore_from_trash') );
        add_action( 'wp_ajax_nopriv_oak_restore_from_trash', array( $this, 'oak_restore_from_trash') );

        add_action( 'wp_ajax_oak_import_csv', array( $this, 'oak_import_csv') );
        add_action( 'wp_ajax_nopriv_oak_import_csv', array( $this, 'oak_import_csv') );

        add_action( 'wp_ajax_oak_corn_configuration', array( $this, 'oak_corn_configuration') );
        add_action( 'wp_ajax_nopriv_oak_corn_configuration', array( $this, 'oak_corn_configuration') );

        add_action('wp_ajax_oak_get_all_data_for_corn', array( $this, 'oak_get_all_data_for_corn') );
        add_action('wp_ajax_nopriv_oak_get_all_data_for_corn', array( $this, 'oak_get_all_data_for_corn') );

        add_action('wp_ajax_corn_save_data', array( $this, 'corn_save_data') );
        add_action('wp_ajax_nopriv_corn_save_data', array( $this, 'corn_save_data') );
    }

    function oak_enqueue_styles() {
        wp_enqueue_style( 'the_style', get_stylesheet_directory_uri() . '/style.css' );
    }

    function oak_enqueue_scripts() {
        if ( strpos( get_page_template(), "critical-analysis" ) != false ) :
            wp_enqueue_script( 'oak_charts', get_template_directory_uri() . '/src/js/vendor/chart.bundle.min.js', array(), false, true);
            wp_enqueue_script( 'oak_critical_analysis_front', get_template_directory_uri() . '/src/js/critical-analysis-front.js', array('jquery'), false, true);
            
            $analyzes = get_option('oak_analyzes');
            $analyzes_field = get_field_object('analyzes');
            $selected_analyze = $analyzes_field['choices'][ get_field('analyzes') ];
            $analyzes = get_option('oak_analyzes');
            $analysis; 
            for ( $i = 0; $i < sizeof( $analyzes ); $i++ ) :
                if ( $analyzes[$i]['title'] == $selected_analyze ) :
                    $analysis = $analyzes[$i];
                endif;
            endfor;
            wp_localize_script('oak_critical_analysis_front', 'DATA', array(
                'analysis' => $analysis
            ));
        endif;
    }

    function oak_admin_enqueue_styles( $hook ) {
        wp_enqueue_style( 'oak_global', get_template_directory_uri() . '/src/css/global.css' );
        // if ( isset( $_GET['elements'] ) ) :
            wp_enqueue_style( 'oak_the_style', get_stylesheet_directory_uri() . '/style.css' );
            // wp_enqueue_style( 'oak_font_awesome', get_template_directory_uri() . '/src/css/vendor/font-awesome.min.css' );
            // wp_enqueue_style( 'oak_googleapifont_roboto', get_template_directory_uri() . '/src/css/vendor/googleapi-font-roboto.css' );
            ?>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
            
            <?php
        // endif;
    }

    function oak_admin_enqueue_scripts( $hook ) { 
        global $wpdb;

        // Admin menu
        wp_enqueue_script( 'admin_menu_script', get_template_directory_uri() . '/src/js/admin-menu.js', array('jquery'), false, true );
        wp_localize_script( 'admin_menu_script', 'DATA', array(
            'ajaxUrl' => admin_url('admin-ajax.php')
        ) );

        // Configuration page
        if ( get_current_screen()->id == 'toplevel_page_oak_materiality_reporting' ) :
            wp_enqueue_script( 'oak_configuration_script', get_template_directory_uri() . '/src/js/configuration-page.js', array('jquery'), false, true );
            wp_localize_script( 'oak_configuration_script', 'DATA', array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' )
            ) );
        endif;

        // Corn import page
        $corn = get_option( 'oak_corn' ) != false ? get_option('oak_corn') : true;
        $central_url = get_option( 'oak_central_url' ) != false ? get_option('oak_central_url') : true;
        if ( get_current_screen()->id == 'toplevel_page_oak_import_page' ) :
            wp_enqueue_script( 'oak_import_script', get_template_directory_uri() . '/src/js/import-page.js', array('jquery'), false, true );
            wp_localize_script( 'oak_import_script', 'DATA', array(
                'corn' => get_option('oak_corn'),
                'centralUrl' => $central_url,
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            ) );
        endif;

        // Critical analysis configuration
        if ( get_current_screen()->id == 'oak-materiality-reporting_page_oak_critical_analysis_configuration' ) :
            wp_enqueue_script( 'oak_critical_analysis_configuration', get_template_directory_uri() . '/src/js/critical-analysis-configuration.js', array('jquery'), false, true);

            $data = wp_remote_get( 'http://demo1291769.mockable.io/base_data' );
            $base_data = json_decode( $data['body'], true );

            wp_localize_script( 'oak_critical_analysis_configuration', 'DATA', array (
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'adminUrl' => admin_url(),
                'templateDirectoryUri' => get_template_directory_uri(),
                'principles' => get_option('oak_principles') ? get_option('oak_principles') : [],
                'baseData' => $base_data
            ));
        endif;

        // Critical analysis creation
        if ( get_current_screen()->id == 'oak-materiality-reporting_page_oak_critical_analysis' ) :
            wp_enqueue_script( 'oak_charts', get_template_directory_uri() . '/src/js/vendor/chart.bundle.min.js', array(), false, true);
            wp_enqueue_script( 'oak_critical_analysis', get_template_directory_uri() . '/src/js/critical-analysis.js', array('jquery'), false, true);
            wp_localize_script( 'oak_critical_analysis', 'DATA', array (
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'adminUrl' => admin_url(),
                'principles' => get_option('oak_principles') ? get_option('oak_principles') : [],
                'analyzes' => get_option('oak_analyzes') ? get_option('oak_analyzes') : []
            ));
        endif;

        // For elements
        if ( isset( $_GET['elements'] ) ) :
            $table = '';
            $table_in_plural = '';
            $elements = [];
            $properties = array(
                array( 'name' => 'designation', 'type' => 'text', 'input_type' => 'text' ),
                array( 'name' => 'identifier', 'type' => 'text', 'input_type' => 'text' ),
                array( 'name' => 'selector', 'type' => 'text', 'input_type' => 'checkbox' ),
                array( 'name' => 'locked', 'type' => 'text', 'input_type' => 'checkbox' ),
                array( 'name' => 'trashed', 'type' => 'text', 'input_type' => 'checkbox' ),
                array( 'name' => 'state', 'type' => 'text', 'input_type' => 'checkbox' ),
            );
            $additional_data_to_pass = array();
            
            if ( $_GET['elements'] == 'fields' ) :
                $table = 'field';
                $table_in_plural = 'fields';
                $elements = Oak::$fields;
                $properties = array_merge( $properties, Oak::$field_properties );
            endif;
            if ( $_GET['elements'] == 'forms' ) :
                $table = 'form';
                $table_in_plural = 'forms';
                $elements = Oak::$forms;
                $additional_data_to_pass = array(
                    'otherElementProperties' => Oak::$form_other_elements,
                    'attributes' => Oak::$forms_attributes
                );
                $properties = array_merge( $properties, Oak::$form_properties );
                $properties[] = array( 'name' => 'revision_number', 'type' => 'text', 'input_type' => 'checkbox' );
            endif;
            if ( $_GET['elements'] == 'models' ) :
                $table = 'model';
                $table_in_plural = 'models';
                $elements = Oak::$models;
                $additional_data_to_pass = array(
                    'fields' => Oak::$fields,
                    'otherElementProperties' => Oak::$model_other_elements,
                    'attributes' => Oak::$forms_attributes
                );
                $properties = array_merge( $properties, Oak::$model_properties );
                $properties[] = array( 'name' => 'revision_number', 'type' => 'text', 'input_type' => 'checkbox' );
            endif;
            if ( $_GET['elements'] == 'taxonomies' ) :
                $table = 'taxonomy';
                $table_in_plural = 'taxonomies';
                $elements = Oak::$taxonomies;
                $properties = array_merge( $properties, Oak::$taxonomy_properties );
            endif;
            if ( $_GET['elements'] == 'organizations' ) :
                $table = 'organization';
                $table_in_plural = 'organizations';
                $elements = Oak::$organizations;
                $properties = array_merge( $properties, Oak::$organization_properties );
            endif;
            if ( $_GET['elements'] == 'publications' ) :
                $table = 'publication';
                $table_in_plural = 'publications';
                $elements = Oak::$publications;
                $properties = array_merge( $properties, Oak::$publication_properties );
            endif;
            if ( $_GET['elements'] == 'glossaries' ) :
                $table = 'glossary';
                $table_in_plural = 'glossaries';
                $elements = Oak::$glossaries;
                $properties = array_merge( $properties, Oak::$glossary_properties );
            endif;
            if ( $_GET['elements'] == 'qualis' ) :
                $table = 'quali';
                $table_in_plural = 'qualis';
                $elements = Oak::$qualis;
                $properties = array_merge( $properties, Oak::$quali_properties );
            endif;
            if ( $_GET['elements'] == 'quantis' ) :
                $table = 'quanti';
                $table_in_plural = 'quantis';
                $elements = Oak::$quantis;
                $properties = array_merge( $properties, Oak::$quanti_properties );
            endif;
            if ( $_GET['elements'] == 'objects' ) :
                $table = 'object';
                $table_in_plural = $_GET['model_identifier'];
                $object_table_name = $wpdb->prefix . 'oak_model_' . $_GET['model_identifier'];
                Oak::$objects = $wpdb->get_results ( "
                    SELECT *
                    FROM  $object_table_name
                " );
                $elements = Oak::$objects;

                foreach( Oak::$current_model_fields as $key => $field ) :
                    $input_type = 'text';
                    if ( $field->field_type == 'Image' ) :
                        $input_type = 'image';
                    elseif( $field->field_type == 'Fichier' ) :
                        $input_type = 'file';
                    endif;

                    Oak::$object_properties[] = array (
                        'name' => $key . '_' . $field->field_identifier,
                        'property_name' => 'object_' . $key . '_' . $field->field_identifier, 
                        'type' => 'text',
                        'input_type' => $input_type,
                        'placeholder' => $field->form_and_field_properties->field_designation,
                        'description' => $field->form_and_field_properties->field_designation,
                        'width' => '50'
                    );
                endforeach;

                $properties = array_merge( $properties, Oak::$object_properties );
            endif;

            if ( $_GET['elements'] == 'terms' ) :
                $table = 'term';
                $table_in_plural = $_GET['taxonomy_identifier'];
                $term_table_name = $wpdb->prefix . 'oak_taxonomy_' . $_GET['taxonomy_identifier'];
                Oak::$terms = $wpdb->get_results ( "
                    SELECT *
                    FROM $term_table_name
                " );
                $elements = Oak::$terms;

                $properties = array_merge( $properties, Oak::$term_properties );
            endif;

            Oak::$revisions = $this->oak_get_revisions( $table, $elements );

            $basic_data_to_pass = array(
                'ajaxUrl' => admin_url ('admin-ajax.php'),
                'table' => $table,
                'tableInPlural' => $table_in_plural,
                'revisions' => Oak::$revisions,
                'properties' => $properties,
                'adminUrl' => admin_url(),
                'elements' => $elements,
                'elementsType' => $_GET['elements'],
                'templateDirectoryUri' => get_template_directory_uri(),
            );
            $final_data_to_pass = array_merge( $basic_data_to_pass, $additional_data_to_pass );

            if ( $_GET['listorformula'] == 'formula' ) :
                wp_enqueue_script( 'corn_add_element', get_template_directory_uri() . '/src/js/add-element.js', array('jquery'), false, true );
                wp_localize_script( 'corn_add_element', 'DATA', $final_data_to_pass );
            endif;

            if ( $_GET['listorformula'] == 'list' ) :
                wp_enqueue_script( 'corn_elements_list', get_template_directory_uri() . '/src/js/elements-list.js', array('jquery'), false, true );
                wp_localize_script( 'corn_elements_list', 'DATA', $final_data_to_pass );
            endif;
        endif;

        // For models objects
        // if ( strpos( get_current_screen()->id, 'oak_model' ) == true && $_GET['page'] != 'oak_models_list' ) :
        //     $page_name = $_GET['page'];
        //     $page_name_array = explode( '_', $page_name );
        //     if ( count( $page_name_array ) > 3 ) :
        //         $model_identifier = $page_name_array[3];
        //     else :
        //         $model_identifier = $page_name_array[2];
        //     endif;
        //     $table_name = $wpdb->prefix . 'oak_' . $model_identifier;
        //     Oak::$objects = $wpdb->get_results ( "
        //         SELECT * 
        //         FROM $table_name
        //     " );

        //     if ( strpos( get_current_screen()->id, 'oak_model_add' ) == true ) :
        //         // This is the add page
        //         $revisions = [];
        //         if ( isset( $_GET['object_identifier'] ) ) :
        //             foreach( Oak::$objects as $object ) :
        //                 if ( $object->object_identifier == $_GET['object_identifier'] ) :
        //                     $revisions[] = $object;
        //                 endif;
        //             endforeach;
        //         endif;
                
        //         wp_enqueue_script( 'oak_add_object', get_template_directory_uri() . '/src/js/add-object.js', array('jquery'), false, true );
        //         wp_localize_script( 'oak_add_object', 'DATA', array(
        //             'ajaxUrl' => admin_url ('admin-ajax.php'),
        //             'revisions' => $revisions,
        //             'objects' => Oak::$objects,
        //             'adminUrl' => admin_url(),
        //             'templateDirectoryUri' => get_template_directory_uri(),
        //             'modelIdentifier' => $model_identifier,
        //             'allObjectsWithoutRedundancy' => Oak::$all_objects_without_redundancy
        //         ) );
        //     else :
        //         // This is the list page
        //         wp_enqueue_script( 'oak_objects_list', get_template_directory_uri() . '/src/js/objects-list.js', array('jquery'), false, true );
        //         wp_localize_script( 'oak_objects_list', 'DATA', array(
        //             'ajaxUrl' => admin_url ('admin-ajax.php'),
        //             'objects' => Oak::$objects,
        //             'adminUrl' => admin_url(),
        //             'modelIdentifier' => $model_identifier
        //         ) );
        //     endif;
        // endif;  
        // // Done with models objects

        // // For taxonomies terms
        // if ( strpos( get_current_screen()->id, 'oak_taxonomy' ) == true && $_GET['page'] != 'oak_taxonomies_list' ) :
        //     // For the color picker: 
        //     wp_enqueue_style( 'wp-color-picker' );

        //     $page_name = $_GET['page'];
        //     $page_name_array = explode( '_', $page_name );
        //     if ( count( $page_name_array ) > 3 ) :
        //         $taxonomy_identifier = $page_name_array[3];
        //     else :
        //         $taxonomy_identifier = $page_name_array[2];
        //     endif;
        //     $table_name = $wpdb->prefix . 'oak_taxonomy_' . $taxonomy_identifier;
        //     Oak::$terms = $wpdb->get_results ( "
        //         SELECT * 
        //         FROM $table_name
        //     " );

        //     if ( strpos( get_current_screen()->id, 'oak_taxonomy_add' ) == true ) :
        //         // This is the add page
        //         $revisions = [];
        //         if ( isset( $_GET['term_identifier'] ) ) :
        //             foreach( Oak::$terms as $term ) :
        //                 if ( $term->term_identifier == $_GET['term_identifier'] ) :
        //                     $revisions[] = $term;
        //                 endif;
        //             endforeach;
        //         endif;
                
        //         wp_enqueue_script( 'oak_add_term', get_template_directory_uri() . '/src/js/add-term.js', array('jquery', 'wp-color-picker'), false, true );
        //         wp_localize_script( 'oak_add_term', 'DATA', array(
        //             'ajaxUrl' => admin_url ('admin-ajax.php'),
        //             'revisions' => $revisions,
        //             'terms' => Oak::$terms,
        //             'adminUrl' => admin_url(),
        //             'templateDirectoryUri' => get_template_directory_uri(),
        //             'taxonomyIdentifier' => $taxonomy_identifier
        //         ) );
        //     else :
        //         // This is the list page
        //         wp_enqueue_script( 'oak_terms_list', get_template_directory_uri() . '/src/js/terms-list.js', array('jquery'), false, true );
        //         wp_localize_script( 'oak_terms_list', 'DATA', array(
        //             'ajaxUrl' => admin_url ('admin-ajax.php'),
        //             'terms' => Oak::$terms,
        //             'adminUrl' => admin_url(),
        //             'taxonomyIdentifier' => $taxonomy_identifier
        //         ) );
        //     endif;
        // endif;  
        // Done with taxonomies terms
    }
    
    function oak_add_theme_support() {
        add_theme_support('menus');
        include get_template_directory() . '/functions/tables.php';
        include get_template_directory() . '/functions/properties-initialization.php';
    }

    function add_cors_http_header() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Origin: http://localhost:8888/boilerplate/');
    }

    function oak_handle_admin_menu() {
        // add_menu_page( 'Admin Menu', 'Admin Menu', 'manage_options', 'admin_menu', , $icon_url, $position)
        add_menu_page( 'OAK (Materiality Reporting)', 'OAK (Materiality Reporting)', 'manage_options', 'oak_materiality_reporting', array( $this, 'oak_materility_reporting' ), 'dashicons-chart-pie', 99 );

        $central = get_option( 'oak_corn' );
        if ( $central == 'true' ) :
            add_menu_page( 'Importation des données', 'Importation des données', 'manage_options', 'oak_import_page', array( $this, 'oak_import_page' ), 'dashicons-chart-pie', 100 );
        endif;

        add_submenu_page( 'oak_materiality_reporting', __('Analyse Critique', Oak::$text_domain), __('Analyse Critique', Oak::$text_domain), 'manage_options', 'oak_critical_analysis', array( $this, 'oak_critical_analysis') );
        add_submenu_page( 'oak_materiality_reporting', 'Modèle d\'analyse', 'Cofiguration', 'manage_options', 'oak_critical_analysis_configuration', array( $this, 'oak_critical_analysis_configuration') );

        add_menu_page( __( 'Elements', Oak::$text_domain ), 'Elements', 'manage_options', 'oak_elements_list', array ( $this, 'oak_elements_list'), 'dashicons-index-card', 100 );
        add_submenu_page( 'oak_elements_list', 'Ajouter un Element', __( 'Ajouter un Element', Oak::$text_domain ), 'manage_options', 'oak_add_element',  array( $this, 'oak_add_element' ) );

        // add_menu_page( __( 'Formes', Oak::$text_domain ), 'Formes', 'manage_options', 'oak_forms_list', array ( $this, 'oak_forms_list'), 'dashicons-index-card', 100 );
        // add_submenu_page( 'oak_forms_list', 'Ajouter un formulaire', __( 'Ajouter un formulaire', Oak::$text_domain ), 'manage_options', 'oak_add_form',  array( $this, 'oak_add_form' ) );

        // add_menu_page( __( 'Modèles', Oak::$text_domain ), 'Modèles', 'manage_options', 'oak_models_list', array ( $this, 'oak_models_list'), 'dashicons-index-card', 100 );
        // add_submenu_page( 'oak_models_list', 'Ajouter un modèle', __( 'Ajouter un modèle', Oak::$text_domain ), 'manage_options', 'oak_add_model',  array( $this, 'oak_add_model' ) );

        // add_menu_page( __( 'Taxonomies', Oak::$text_domain ), 'Taxonomies', 'manage_options', 'oak_taxonomies_list', array ( $this, 'oak_taxonomies_list'), 'dashicons-index-card', 100 );
        // add_submenu_page( 'oak_taxonomies_list', 'Ajouter une Taxonomy', __( 'Ajouter une Taxonomy', Oak::$text_domain ), 'manage_options', 'oak_add_taxonomy',  array( $this, 'oak_add_taxonomy' ) );

        // add_menu_page( __( 'Organisations', Oak::$text_domain ), 'Organisations', 'manage_options', 'oak_organizations_list', array ( $this, 'oak_organizations_list'), 'dashicons-index-card', 100 );
        // add_submenu_page( 'oak_organizations_list', 'Ajouter une Organisation', __( 'Ajouter une Organisation', Oak::$text_domain ), 'manage_options', 'oak_add_organization',  array( $this, 'oak_add_organization' ) );

        // add_menu_page( __( 'Publications', Oak::$text_domain ), 'Publications', 'manage_options', 'oak_publications_list', array ( $this, 'oak_publications_list'), 'dashicons-index-card', 100 );
        // add_submenu_page( 'oak_publications_list', 'Ajouter une Publication', __( 'Ajouter une Publication', Oak::$text_domain ), 'manage_options', 'oak_add_publication',  array( $this, 'oak_add_publication' ) );

        // add_menu_page( __( 'Glossaire', Oak::$text_domain ), 'Glossaire', 'manage_options', 'oak_glossaries_list', array ( $this, 'oak_glossaries_list'), 'dashicons-index-card', 100 );
        // add_submenu_page( 'oak_glossaries_list', 'Ajouter une Terminologie', __( 'Ajouter une Terminologie', Oak::$text_domain ), 'manage_options', 'oak_add_glossary',  array( $this, 'oak_add_glossary' ) );

        // add_menu_page( __( 'Indicateurs Qualitatifs', Oak::$text_domain ), 'Indicateurs Qualitatifs', 'manage_options', 'oak_qualis_list', array ( $this, 'oak_qualis_list'), 'dashicons-index-card', 100 );
        // add_submenu_page( 'oak_qualis_list', 'Ajouter un indicateur qualitatif', __( 'Ajouter un indicateur qualitatif', Oak::$text_domain ), 'manage_options', 'oak_add_quali',  array( $this, 'oak_add_quali' ) );

        // add_menu_page( __( 'Indicateurs Quantitatifs', Oak::$text_domain ), 'Indicateurs Quantitatifs', 'manage_options', 'oak_quantis_list', array ( $this, 'oak_quantis_list'), 'dashicons-index-card', 100 );
        // add_submenu_page( 'oak_quantis_list', 'Ajouter un indicateur quantitatif', __( 'Ajouter un indicateur quantitatif', Oak::$text_domain ), 'manage_options', 'oak_add_quanti',  array( $this, 'oak_add_quanti' ) );

        if ( get_option( 'oak_corn' ) == 'true' ) :
            foreach( Oak::$all_terms_without_redundancy as $term ) :
                add_menu_page( $term->term_designation, $term->term_designation, 'manage_options', 'oak_term_' . $term->term_identifier, array( $this, 'oak_term_objects_list' ), 'dashicons-index-card', 100 );
                add_submenu_page( 'oak_term_' . $term->term_identifier, 'Ajouter un objet', 'Ajouter', 'manage_options', 'oak_object_add_' . $term->term_identifier, array( $this, 'oak_add_term_object' ) );
            endforeach;
        endif;
    }

    function add_admin_menu_separator( $position ) {
        global $menu;
        $index = 0;
        foreach( $menu as $offset => $section ) {
          if ( substr( $section [2], 0, 9 ) =='separator')
            $index++;
          if ( $offset>=$position ) {
            $menu [ $position ] = array ('', 'read', "separator{$index}", '', 'wp-menu-separator' );
            break;
          }
        }
        ksort ( $menu );
    }

    function oak_materility_reporting() {
        include get_template_directory() . '/template-parts/configuration-page.php';
    } 

    function oak_import_page() {
        include get_template_directory() . '/template-parts/import-page.php';
    }

    function oak_critical_analysis() {
        include get_template_directory() . '/template-parts/critical-analysis.php';
    }

    function oak_critical_analysis_configuration() {
        include get_template_directory() . '/template-parts/critical-analysis-configuration.php';
    }

    function oak_set_analyzes( $field ) {
        $choices = $field['choices'];
        $analyzes = get_option( 'oak_analyzes' ) ? get_option( 'oak_analyzes') : [];
        for ( $i = 0; $i < sizeof( $analyzes ); $i++) {
            $choices[] = $analyzes[$i]['title'];
        }
        $field['choices'] = $choices;
        return $field;
    }

    static function oak_get_countries() {
        $country_query_result = wp_remote_get( 'https://restcountries.eu/rest/v2/all' );
        $countries = json_decode( $country_query_result['body'] );
        return $countries;
    }

    static function oak_get_countries_names() {
        $country_query_result = wp_remote_get( 'https://restcountries.eu/rest/v2/all' );
        $countries = json_decode( $country_query_result['body'] );
        $names = [];
        foreach( $countries as $country ) :
            $names[] = $country->name;
        endforeach;
        return $names;
    }

    static function oak_get_languages() {
        $languages = [];
        $country_query_result = wp_remote_get( 'https://restcountries.eu/rest/v2/all' );
        $countries = json_decode( $country_query_result['body'] );

        foreach( $countries as $country ) :
            foreach( $country->languages as $language ) :
                if ( !in_array( $language->name, $languages ) )
                    $languages[] = $language->name;
            endforeach;
        endforeach;

        return $languages;
    }

    function generateRandomString( $length = 20 ) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function oak_contact_form() {
        if ( ( !isset( $_GET['email'] ) ) || ( !isset( $_GET['subject'] ) ) || ( !isset( $_GET['content'] ) || ( !is_email( $_GET['email'] ) ) || ( trim( $_GET['content'] ) == '' ) ))
            return;
        if ( wp_mail( $_GET['email'], $_GET['subject'], $_GET['content']) ) {
            var_dump('Success');
        } else {
            var_dump('Error');
        }
    }

    function oak_save_analysis_model() {
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
        

        update_option( 'oak_principles', $principles, false );
        wp_send_json_success( array(
            'image' => $principles['0']['image'],
        ) );
    }

    function oak_save_analyzes() {
        $analyzes = $_POST['analyzes'];
        update_option( 'oak_analyzes', $analyzes );
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

    function oak_save_save_configuration() {
        $data = $_POST['data'];
        $central = $data['central'];
        $central_url = $data['centralUrl'];

        update_option( 'oak_corn', $central );
        update_option( 'oak_central_url', $central_url );

        wp_send_json_success( array(
            'central' => $central,
            'centralUrl' => $central_url
        ) );
    }

    function oak_add_element() {
        $revisions = Oak::$revisions;
        switch ( $_GET['elements'] ) :
            case 'fields': 
                $properties = Oak::$field_properties;
                $table = 'field';
                $title = __( 'Ajouter un champ', Oak::$text_domain );
            break;
            case 'forms': 
                $properties = Oak::$form_properties;
                $table = 'form';
                $title = __( 'Nouveau formulaire', Oak::$text_domain );
            break;
            case 'models': 
                $properties = Oak::$model_properties;
                $table = 'model';
                $title = __( 'Ajouter un modèle', Oak::$text_domain );
            break;
            case 'taxonomies': 
                $properties = Oak::$taxonomy_properties;
                $table = 'taxonomy';
                $title = __( 'Ajouter une taxonomie', Oak::$text_domain );
            break;
            case 'publications': 
                $properties = Oak::$publication_properties;
                $table = 'publication';
                $title = __( 'Ajouter une publication', Oak::$text_domain );
            break;
            case 'organizations': 
                $properties = Oak::$organization_properties;
                $table = 'organization';
                $title = __( 'Ajouter une organisation', Oak::$text_domain );
            break;
            case 'quantis': 
                $properties = Oak::$quanti_properties;
                $table = 'quanti';
                $title = __( 'Ajouter un indicateur quantitatif', Oak::$text_domain );
            break;
            case 'qualis':
                $properties = Oak::$quali_properties;
                $table = 'quali';
                $title = __( 'Ajouter un indicateur qualitatif', Oak::$text_domain );
            break;
            case 'glossaries': 
                $properties = Oak::$glossary_properties;
                $table = 'glossary';
                $title = __( 'Ajouter une términologie', Oak::$text_domain );
            break;
            case 'objects' :
                $properties = Oak::$object_properties;
                $table = 'object';
                $title = __( 'Ajouter un objet', Oak::$text_domain );
            break;
            case 'terms' :
                $properties = Oak::$term_properties;
                $table = 'term';
                $title = __( 'Ajouter un terme', Oak::$text_domain );
            break;
        endswitch;
        include get_template_directory() . '/template-parts/elements/add-element.php';
    }

    function oak_add_form() {
        $revisions = Oak::$revisions;
        $table = 'form';
        include get_template_directory() . '/template-parts/forms/add-form.php';
    }

    function oak_add_model() {
        $table = 'model';
        $revisions = Oak::$revisions;
        include get_template_directory() . '/template-parts/models/add-model.php';
    }

    function oak_add_taxonomy() {
        $table = 'taxonomy';
        $revisions = Oak::$revisions;
        include get_template_directory() . '/template-parts/taxonomies/add-taxonomy.php';
    }

    function oak_add_organization() {
        $table = 'organization';
        $revisions = Oak::$revisions;
        include get_template_directory() . '/template-parts/organizations/add-organization.php';
    }

    function oak_add_publication() {
        $table = 'publication';
        $revisions = Oak::$revisions;
        include get_template_directory() . '/template-parts/publications/add-publication.php';
    }

    function oak_add_glossary() {
        $table = 'glossary';
        $revisions = Oak::$revisions;
        include get_template_directory() . '/template-parts/glossaries/add-glossary.php';
    }

    function oak_add_quali() {
        $table = 'quali';
        $revisions = Oak::$revisions;
        include get_template_directory() . '/template-parts/qualis/add-quali.php';
    }

    function oak_add_quanti() {
        $table = 'quanti';
        $revisions = Oak::$revisions;
        include get_template_directory() . '/template-parts/quantis/add-quanti.php';
    }
    
    function get_model_fields( $model, $fields_without_redundancy ) {
        $reversed_forms = array_reverse( Oak::$forms );
        $forms_without_redundancy = [];
        foreach( $reversed_forms as $form ) :
            $added = false;
            foreach( $forms_without_redundancy as $form_without_redundancy ) :
                if ( $form_without_redundancy->form_identifier == $form->form_identifier) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $forms_without_redundancy[] = $form;
            endif;
        endforeach;

        $tables_fields = [];
        $model_forms_data = explode( '|', $model->model_forms );
        foreach( $model_forms_data as $form_data ) :
            $form_data_array = explode( ':', $form_data );
            if ( count( $form_data_array ) > 1 ) :
                $form_identifier = $form_data_array['1'];
                foreach( $forms_without_redundancy as $form ) :
                    if ( $form->form_identifier == $form_identifier ) :
                        $form_fields_data = explode( '|', $form->form_fields );
                        foreach( $form_fields_data as $form_field_data ) :
                            $form_field_data_array = explode( ':', $form_field_data );
                            if ( count( $form_field_data_array ) > 1 ) :
                                $field_identifier = $form_field_data_array['1'];
                                foreach( $fields_without_redundancy as $field ) :
                                    if ( $field->field_identifier == $field_identifier ) :
                                        $tables_fields[] = $field;
                                    endif;
                                endforeach;
                            endif;
                        endforeach;
                    endif;
                endforeach;
            endif;
        endforeach;
        return $tables_fields;
    }

    function oak_elements_list() {
        global $wpdb;
        $elements = [];
        $table = '';
        $title = '';
        switch( $_GET['elements'] ) :
            case 'fields' :
                $title = __( 'Champs', Oak::$text_domain );
                $elements = Oak::$fields_without_redundancy;
                $table = 'field';
                $first_property = array ( 'title' => __( 'Nature', Oak::$text_domain ), 'property' => 'field_type' );
                $second_property = array ( 'title' => __( 'Fonction', Oak::$text_domain ), 'property' => 'field_function' );
                $third_property = array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'field_function' );;
            break;
            case 'forms' :
                $title = __( 'Formes', Oak::$text_domain );
                $elements = Oak::$forms_without_redundancy;
                $table = 'form';
                $first_property = array ( 'title' => __( 'Structure', Oak::$text_domain ), 'property' => 'form_structure' );
                $second_property = array ( 'title' => __( 'Attributs', Oak::$text_domain ), 'property' => 'form_attributes' );
                $third_property = array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'form_attributes' );;
            break;
            case 'models' :
                $title = __( 'Modèles', Oak::$text_domain );
                $elements = Oak::$models_without_redundancy;
                $table = 'model';
                $first_property = array ( 'title' => __( 'Types', Oak::$text_domain ), 'property' => 'model_types' );
                $second_property = array ( 'title' => __( 'Catégories de publications', Oak::$text_domain ), 'property' => 'model_publications_categories' );
                $third_property = array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'model_publications_categories' );;
            break;
            case 'taxonomies' :
                $title = __( 'Taxonomies', Oak::$text_domain );
                $elements = Oak::$taxonomies_without_redundancy;
                $table = 'taxonomy';
                $first_property = array ( 'title' => __( 'Description', Oak::$text_domain ), 'property' => 'taxonomy_description' );
                $second_property = array ( 'title' => __( 'Structure', Oak::$text_domain ), 'property' => 'taxonomy_structure' );
                $third_property = array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'taxonomy_structure' );;
            break;
            case 'organizations' : 
                $title = __( 'Organisations', Oak::$text_domain );
                $elements = Oak::$organizations_without_redundancy;
                $table = 'organization';
                $first_property = array ( 'title' => __( 'Acronyme', Oak::$text_domain ), 'property' => 'organization_acronym' );
                $second_property = array ( 'title' => __( 'Description', Oak::$text_domain ), 'property' => 'organization_description' );
                $third_property = array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'organization_description' );;
            break;
            case 'publications' : 
                $title = __( 'Publications', Oak::$text_domain );
                $elements = Oak::$publications_without_redundancy;
                $table = 'publication';
                $first_property = array ( 'title' => __( 'Organisation', Oak::$text_domain ), 'property' => 'publication_organization' );
                $second_property = array ( 'title' => __( 'Format', Oak::$text_domain ), 'property' => 'publication_format' );
                $third_property = array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'publication_format' );;
            break; 
            case 'quantis' : 
                $title = __( 'Indicateurs Quantitatifs', Oak::$text_domain );
                $elements = Oak::$quantis_without_redundancy;
                $table = 'quanti';
                $first_property = array ( 'title' => __( 'Publication', Oak::$text_domain ), 'property' => 'quanti_publication' );
                $second_property = array ( 'title' => __( 'Parent', Oak::$text_domain ), 'property' => 'quanti_parent' );
                $third_property = array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'quanti_parent' );;
            break;
            case 'qualis' :
                $title = __( 'Indicateurs Qualitatifs', Oak::$text_domain );
                $elements = Oak::$qualis_without_redundancy;
                $table = 'quali';
                $first_property = array ( 'title' => __( 'Publication', Oak::$text_domain ), 'property' => 'quali_publication' );
                $second_property = array ( 'title' => __( 'Parent', Oak::$text_domain ), 'property' => 'quali_parent' );
                $third_property = array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'quali_parent' );;
            break;
            case 'glossaries' :
                $title = __( 'Terminologies', Oak::$text_domain );
                $elements = Oak::$glossaries_without_redundancy;
                $table = 'glossary';
                $first_property = array ( 'title' => __( 'Publication', Oak::$text_domain ), 'property' => 'glossary_publication' );
                $second_property = array ( 'title' => __( 'Parent', Oak::$text_domain ), 'property' => 'glossary_parent' );
                $third_property = array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'glossary_parent' );;
            break;
            case 'objects' :
                $object_table_name = $wpdb->prefix . 'oak_model_' . $_GET['model_identifier'];
                Oak::$objects = $wpdb->get_results ( "
                    SELECT * 
                    FROM $object_table_name
                " );
                $title = __( 'Objets', Oak::$text_domain );
                $elements = Oak::$objects;
                $table = 'object';
                $first_property = array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'object_identifier' );
                $second_property = array ( 'title' => __( 'Sélecteur de cadres RSE', Oak::$text_domain ), 'property' => 'object_selector' );
                $third_property = array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'object_identifier' );
            break;
            case 'terms' :
                $term_table_name = $wpdb->prefix . 'oak_taxonomy_' . $_GET['taxonomy_identifier'];
                Oak::$objects = $wpdb->get_results ( "
                    SELECT * 
                    FROM $term_table_name
                " );
                $reversed_terms = array_reverse( Oak::$terms  );
                foreach( $reversed_terms as $term ) :
                    $added = false;
                    foreach( Oak::$terms_without_redundancy as $term_without_redundancy ) :
                        if ( $term_without_redundancy->term_identifier == $term->term_identifier) :
                            $added = true;
                        endif;
                    endforeach;
                    if ( !$added ) :
                        Oak::$terms_without_redundancy[] = $term;
                    endif;
                endforeach;

                $title = __( 'Termes', Oak::$text_domain );
                $elements = Oak::$terms_without_redundancy;
                $table = 'term';
                $first_property = array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'term_identifier' );
                $second_property = array ( 'title' => __( 'Sélecteur de cadres RSE', Oak::$text_domain ), 'property' => 'term_selector' );
                $third_property = array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'term_identifier' );
            break;
        endswitch;
        include get_template_directory() . '/template-parts/elements/elements-list.php';
    }

    function oak_get_revisions( $table, $elements ) {
        $revisions = [];
        $identifier_property = $table . '_identifier';
        if ( isset( $_GET[ $table . '_identifier'] ) ) :
            foreach( $elements as $element ) :
                if ( $element->$identifier_property == $_GET[ $table . '_identifier'] ) :
                    $revisions[] = $element;
                endif;
            endforeach;
        endif;
        return $revisions;
    }

    function oak_forms_list() {
        global $wpdb;
        $forms_table_name = Oak::$forms_table_name;
        $forms = $wpdb->get_results ( "
            SELECT * 
            FROM  $forms_table_name
        " );
        include get_template_directory() . '/template-parts/forms/forms-list.php';
    }

    function oak_models_list() {
        global $wpdb;
        $models = Oak::$models;
        include get_template_directory() . '/template-parts/models/models-list.php';
    }

    function oak_taxonomies_list() {
        global $wpdb;
        $taxonomies = Oak::$taxonomies;
        include get_template_directory() . '/template-parts/taxonomies/taxonomies-list.php';
    }

    function oak_organizations_list() {
        global $wpdb;
        $organizations_table_name = Oak::$organizations_table_name;
        $organizations = $wpdb->get_results ( "
            SELECT * 
            FROM  $organizations_table_name
        " );
        include get_template_directory() . '/template-parts/organizations/organizations-list.php';
    }

    function oak_publications_list() {
        global $wpdb;
        $publications_table_name = Oak::$publications_table_name;
        $publications = $wpdb->get_results ( "
            SELECT * 
            FROM  $publications_table_name
        " );
        include get_template_directory() . '/template-parts/publications/publications-list.php';
    }

    function oak_glossaries_list() {
        global $wpdb;
        $glossaries_table_name = Oak::$glossaries_table_name;
        $glossaries = $wpdb->get_results ( "
            SELECT * 
            FROM  $glossaries_table_name
        " );
        include get_template_directory() . '/template-parts/glossaries/glossaries-list.php';
    }

    function oak_qualis_list() {
        global $wpdb;
        $qualis_table_name = Oak::$qualis_table_name;
        $qualis = $wpdb->get_results ( "
            SELECT * 
            FROM  $qualis_table_name
        " );
        include get_template_directory() . '/template-parts/qualis/qualis-list.php';
    }

    function oak_quantis_list() {
        global $wpdb;
        $quantis_table_name = Oak::$quantis_table_name;
        $quantis = $wpdb->get_results ( "
            SELECT * 
            FROM  $quantis_table_name
        " );
        include get_template_directory() . '/template-parts/quantis/quantis-list.php';
    }

    function oak_model_objects_list() {
        include get_template_directory() . '/template-parts/models-objects/models-objects-list.php';
    }

    function oak_taxonomy_terms_list() {
        include get_template_directory() . '/template-parts/taxonomies-terms/taxonomies-terms-list.php';
    }

    function oak_term_objects_list() {
        include get_template_directory() . '/template-parts/term-objects/term-objects-list.php';
    }

    function oak_add_term_object() {
        include get_template_directory() . '/template-parts/term-objects/add-term-object.php';
    }

    function oak_filter_word( $value ) {
        return stripslashes_deep( $value );
    }

    function oak_register_element() {
        global $wpdb;

        $element = $_POST['element'];
        foreach( $element as $key => $value ) :
            $element[ $key ] = $this->oak_filter_word( $value );
        endforeach;

        $table = $_POST['table'];
        $prefix = $wpdb->prefix . 'oak_';
        if ( $table == 'object' ) : 
            $prefix = $wpdb->prefix . 'oak_model_';
        elseif( $table == 'term' ) :
            $prefix = $wpdb->prefix . 'oak_taxonomy_';
        endif;

        $table_name = $prefix . $_POST['tableInPlural'];

        $array_data = array_merge( $element, array( $table . '_modification_time' => date("Y-m-d H:i:s") ) );


        if ( isset( $element['otherElements'] ) && !$_GET['fromRevision'] ) :
            $other_elements = $element['otherElements'];
            $other_elements_properties = $element['otherElementsProperties'];

            foreach( $other_elements as $other_element ) :
                $result = $wpdb->insert(
                    $other_elements_properties['table_name'],
                    array (
                        $other_elements_properties['element_column_name'] => $element[ $table . '_identifier' ],
                        $other_elements_properties['other_element_column_name'] => $other_element['elementIdentifier'],
                        $other_elements_properties['table'] . '_designation' => $other_element['elementOtherDesignation'],
                        $other_elements_properties['table'] . '_required' => $other_element['elementRequired'],
                        $other_elements_properties['table'] . '_index' => $other_element['elementIndex'],
                        $table . '_revision_number' => $element[ $table . '_revision_number' ]
                    )
                );
            endforeach;
        endif;

        unset( $array_data['otherElements'] );
        unset( $array_data['otherElementsProperties'] );
        
        $file = '';
        foreach( $array_data as $key => $value ) :
            if ( strpos( $key, 'logo' ) != false || strpos( $key, 'image' ) != false || strpos( $key, 'headpiece' ) != false ) :
                if ( strpos( $value, 'uploads/' ) == false ) :
                    $image = $this->upload_image( $value );
                    $array_data[ $key ] = $image;
                endif;
            endif;

            if ( strpos( $key, 'file' ) != false ) :
                if ( strpos( $value, 'uploads/' ) == false ) :
                    // $file  = $this->upload_user_file( $value );
                    $file = $this->upload_image( $value );
                    $array_data[ $key ] = $file;
                endif;
            endif;
        endforeach;
        
        $result = $wpdb->insert(
            $table_name, 
            $array_data
        );

        wp_send_json_success( array(
            'tableName' => $table_name,
            'element' => $array_data,
            'theFile' => $file
        ) );
    }

    function upload_user_file( $file = array() ) {
        require_once( ABSPATH . 'wp-admin/includes/admin.php' );
          $file_return = wp_handle_upload( $file, array('test_form' => false ) );
          if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
              return false;
          } else {
              $filename = $file_return['file'];
              $attachment = array(
                  'post_mime_type' => $file_return['type'],
                  'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                  'post_content' => '',
                  'post_status' => 'inherit',
                  'guid' => $file_return['url']
              );
              $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
              require_once(ABSPATH . 'wp-admin/includes/image.php');
              $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
              wp_update_attachment_metadata( $attachment_id, $attachment_data );
              if( 0 < intval( $attachment_id ) ) {
                return $attachment_id;
              }
          }
          return false;
    }

    function upload_image( $image ) {
        if ( strpos( $image, 'uploads/' ) == true ) :
            return $image;
        endif;
        
        $image_url = '';
        
        $image_type = explode( ';', explode( '/', $image )[1] )[0];

        if ( !filter_var( $image, FILTER_VALIDATE_URL ) ) :
            // Uploading the image
            $upload_dir  = wp_upload_dir();
            $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
            
            $img             = str_replace( 'data:image/' . $image_type . ';base64,', '', $image );
            $img             = str_replace( ' ', '+', $img );
            $decoded         = base64_decode( $img );
            $filename        = 'random.' . $image_type;
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
            $image = $url;
            $image_url = $image;
        endif;

        return $image_url;
    }

    function oak_send_to_trash() {
        $data = $_POST['data'];
        $table = $data['table'];
        $table_in_plural = $data['tableInPlural'];
        $identifiers = $data['identifiers'];

        global $wpdb;

        foreach( $identifiers as $identifier ) :
        
            $result = $wpdb->update(
                $wpdb->prefix . 'oak_' . $table_in_plural,
                array (
                    $table . '_trashed' => 'true',
                ),
                array( $table . '_identifier' => $identifier )
            );

        endforeach;

        wp_send_json_success();
    }

    function oak_delete_definitely() {
        $data = $_POST['data'];
        $table = $data['table'];
        $table_in_plural = $data['tableInPlural'];
        $identifiers = $data['identifiers'];

        global $wpdb;

        foreach( $identifiers as $identifier ) :
        
            $wpdb->delete( 
                $wpdb->prefix . 'oak_' . $table_in_plural, 
                array( $table . '_identifier' => $identifier )
            );

            if ( $data['otherElementsTableName'] ) :
                $wpdb->delete( 
                    $data['otherElementsTableName'], 
                    array( $table . '_identifier' => $identifier )
                );
            endif;

        endforeach;

        wp_send_json_success();
    }

    function oak_restore_from_trash() {
        $data = $_POST['data'];
        $table = $data['table'];
        $table_in_plural = $data['tableInPlural'];
        $identifiers = $data['identifiers'];

        global $wpdb;

        foreach( $identifiers as $identifier ) :
        
            $result = $wpdb->update(
                $wpdb->prefix . 'oak_' . $table_in_plural,
                array (
                    $table . '_trashed' => 'false',
                ),
                array( $table . '_identifier' => $identifier )
            );

        endforeach;

        wp_send_json_success();
    }

    function oak_import_csv() {
        global $wpdb; 

        $table = $_POST['table'];
        $rows = $_POST['rows'];

        $table_name = $table;
        if ( $_POST['wellDefinedTableName'] == 'false' ) :
            $table_name = $wpdb->prefix . 'oak_' . $table;
        endif;

        foreach( $rows as $key => $row ) :
            if ( $key != 0 && !is_null( $row[1] ) ) :
                $arguments = [];
                foreach( $rows[0] as $property_key => $property ) : 
                    if ( $property != 'id' && $property_key < count( $rows[0] ) && $property != '' ) :
                        $arguments[ $property ] = $this->oak_filter_word( $row[ $property_key ] );
                    endif;
                    if ( strpos( $property, '_trashed' ) != false ) :
                        $arguments[ $_POST['single_name'] . '_trashed' ] = $row[ $property_key ];
                    endif;
                endforeach;
                $result = $wpdb->insert(
                    $table_name, 
                    $arguments
                );
            endif;
        endforeach;
        
        wp_send_json_success( array(
            'table name' => $table_name,
            'rows' => $rows,
            'wellDefinedTableName' => $_POST['wellDefinedTableName'],
            'table_name' => $table_name,
            'arguments' => $arguments
        ) );
    }

    // Everything related to corn
    function oak_corn_configuration() {
        $conditions = $_GET['conditions'];

        $the_query = new WP_Query( array(
            'post_type' => 'publication'
        ) );
        $filtered_publications = [];
        $publications = $the_query->posts;

        foreach( $publications as $single_publication ) :
            $single_publication->fields = get_fields( $single_publication->ID );
            if ( 
                ( $conditions['organization'] == '' || $conditions['organization'] == $single_publication->fields['slug_org']['0']->post_title ) 
                // && ( $conditions['reportOrFrame'] == '0' || ( $conditions['reportOrFrame'] != '0' && $conditions['reportOrFrame'] == strval ( $single_publication->fields['report_publication'] + 1 ) ) )
                // && ( $conditions['reportOrFrame'] == '0' || ( $conditions['reportOrFrame'] == '1' && $conditions['reportType'] == '0' ) || ( $conditions['reportOrFrame'] == '1' && $conditions['reportOrFrame'] == strval ( $single_publication->fields['report_publication'] + 1 ) && $conditions['reportType'] == strval ( $single_publication->fields('type_report') + 1 ) ) || ( $conditions['reportOrFrame'] == '2' && $conditions['frameType'] == '0' ) || ( $conditions['reportOrFrame'] == '2' && $conditions['reportOrFrame'] == strval ( $single_publication->fields['report_publication'] + 1 ) && $conditions['frameType'] == strval ( $single_publication->fields['type_manager'] + 1 ) ) )
                && ( $single_publication->fields['report_publication'] == 1 )
                && ( $conditions['frameType'] == '0' || ( $conditions['frameType'] == strval ( $single_publication->fields['type_manager'] + 1 ) ) )
                && ( $conditions['year'] == '' || $conditions['year'] == $single_publication->fields['pub_year'] )
                && ( $conditions['language'] == '0' || $conditions['language'] != '0' && $conditions['language'] == strval ( $single_publication->fields['language_publication'] + 1 ) )
            ) :
                $filtered_publications[] = $single_publication;
            endif;
        endforeach;


        wp_send_json_success( array(
            'conditions' => $conditions,
            'unfilteredPublications' => $publications,
            'filteredPublications' => $filtered_publications,
        ) );
    }

    function oak_corn_import_publications_data() {
        $publication_ids = $_GET['publication_ids'];

        $my_publications = [];
        $all_publications_query = new WP_Query( array ( 'post_type' => 'publication' ) );
        $all_publications = $all_publications_query->posts;

        foreach( $all_publications as $single_publication ) : 
            if ( in_array( $single_publication->ID, $publication_ids ) ) :
                $single_publication->fields = get_fields( $single_publication->ID );
                $single_publication->unique_identifier = get_post_meta( $single_publication->ID, 'unique_identifier', true );
                $my_publications[] = $single_publication;
            endif;
        endforeach;
        
        $all_oak_cpts = get_option('oak_custom_post_types') ? get_option('oak_custom_post_types') : [];
        $my_oak_cpts = [];
        $my_oak_posts = [];
        foreach( $all_oak_cpts as $cpt ) :
            if ( in_array ( $cpt['publication'], $publication_ids ) ) :
                $my_oak_cpts[] = $cpt;
                $posts_query = new WP_Query( array( 'post_type' => $cpt['slug'] ) );
                $posts = $posts_query->posts;
                foreach( $posts as $post ) :
                    $post->fields = get_fields( $post->ID );
                    $post->unique_identifier = get_post_meta( $post->ID, 'unique_identifier', true );
                    $my_oak_posts[] = $post;
                endforeach;
            endif;
        endforeach;


        $all_oak_taxonomies = get_option('oak_taxonomies') ? get_option('oak_taxonomies') : [];
        $my_oak_taxonomies = [];
        $my_oak_terms = [];
        foreach( $all_oak_taxonomies as $taxonomy ) :
            $exists = false;
            foreach( $my_oak_cpts as $my_single_oak_cpt ) :
                if ( is_array( $taxonomy['objectModel'] ) ) : 
                    if ( in_array( $my_single_oak_cpt['slug'], $taxonomy['objectModel'] ) ) :
                        $exists = true;
                    endif;
                elseif ( $my_single_oak_cpt['slug'] == $taxonomy['objectModel'] ) :
                    $exists = true;
                endif;
            endforeach;
            if ( $exists ) :
                $my_oak_taxonomies[] = $taxonomy;
                $terms = get_terms( array(
                    'taxonomy' => $taxonomy['slug'],
                    'hide_empty' => false,
                ) );
                foreach( $terms as $term ) :
                    $term->fields = get_fields( $term );
                    $my_oak_terms[] = $term;
                endforeach;
            endif;
        endforeach;

        // Lets get the posts' terms
        foreach( $my_oak_posts as $my_oak_post ) :
            $my_oak_post->taxonomies_terms = [];
            foreach( $my_oak_taxonomies as $my_oak_taxonomy ) :
                if ( 
                    ( is_array( $my_oak_taxonomy['objectModel'] ) && in_array( $my_oak_post->post_type, $my_oak_taxonomy['objectModel'] ) ) 
                    || ( !is_array( $my_oak_taxonomy['objectModel'] ) && $my_oak_taxonomy['objectModel'] == $my_oak_post->post_type ) 
                ) :
                    $terms = wp_get_post_terms( $my_oak_post->ID, $my_oak_taxonomy['slug'] );
                    foreach( $terms as $term ) :
                        $my_oak_post->taxonomies_terms[] = $term;
                    endforeach;
                endif;
            endforeach; 
        endforeach;
        
        
        $glossay_query = new WP_Query( array(
            'post_type' => 'glossary'
        ) );
        $glossaries = $glossay_query->posts;
        $my_oak_glossaries = [];
        foreach( $glossaries as $glossary ) :
            $glossary->fields = get_fields( $glossary->ID );
            $glossary->unique_identifier = get_post_meta( $glossary->ID, 'unique_identifier', true );
            $exists = false;
            foreach( $my_oak_posts as $post ) :
                if ( $post->ID == $glossary->fields['slug_object_glossary']->ID ) :
                    $exitsts = true;
                endif;
            endforeach;
            foreach( $my_publications as $publication ) :
                if ( $publication->ID == $glossary->fields['slug_publication_glossary']->ID ) :
                    $exists = true;
                endif;
            endforeach;
            if ( $exists ) :
                $my_oak_glossaries[] = $glossary;
            endif;
        endforeach;

        $quali_indicators_query = new WP_Query( array(
            'post_type' => 'quali_indic'
        ) );
        $quali_indicators = $quali_indicators_query->posts;
        $my_oak_quali_indicators = [];
        foreach( $quali_indicators as $quali_indic ) :
            $quali_indic->fields = get_fields( $quali_indic->ID );
            $quali_indic->unique_identifier = get_post_meta( $quali_indic->ID, 'unique_identifier', true );
            $exists = false;
            foreach( $my_oak_posts as $oak_post ) :
                if ( $oak_post->ID == $quali_indic->fields['slug_object_quali']->ID ) :
                    $exists = true;
                endif;
            endforeach;
            foreach( $my_publications as $publication ) :
                if ( $publication->ID == $quali_indic->fields['slug_publication_quali']->ID ) :
                    $exists = true;
                endif;
            endforeach;
            if ( $exists ) :
                $my_oak_quali_indicators[] = $quali_indic;
            endif;
        endforeach;

        $quanti_indicators_query = new WP_Query( array(
            'post_type' => 'quanti_indic'
        ) );
        $quanti_indicators = $quanti_indicators_query->posts;
        $my_oak_quanti_indicators = [];
        foreach( $quanti_indicators as $quanti_indic ) :
            $quanti_indic->fields = get_fields( $quanti_indic->ID );
            $quanti_indic->unique_identifier = get_post_meta( $quanti_indic->ID, 'unique_identifier', true );
            $exists = false;
            foreach( $my_oak_posts as $oak_post ) :
                if ( $oak_post->ID == $quanti_indic->fields['slug_object_quanti']->ID ) :
                    $exists = true;
                endif;
            endforeach;
            foreach( $my_publications as $publication ) :
                if ( $publication->ID == $quanti_indic->fields['slug_publication_quanti']->ID ) :
                    $exists = true;
                endif;
            endforeach;
            if ( $exists ) :
                $my_oak_quanti_indicators[] = $quanti_indic;
            endif;
        endforeach;

        wp_send_json_success( array(
            'myPublications' => $my_publications,
            'myOakCpts' => $my_oak_cpts,
            'myOakPosts' => $my_oak_posts,
            'myOakTaxonomies' => $my_oak_taxonomies,
            'myOakTerms' => $my_oak_terms,
            'myOakGlossaries' => $my_oak_glossaries,
            'myOakQualiIndicators' => $my_oak_quali_indicators,
            'myOakQuantiIndicators' => $my_oak_quanti_indicators,
        ) );
    }

    function oak_corn_content_library_search() {
        $conditions = $_GET['conditions'];

        $the_query = new WP_Query( array(
            'post_type' => 'publication'
        ) );
        $filtered_publications = [];
        $publications = $the_query->posts;

        foreach( $publications as $single_publication ) :
            $single_publication->fields = get_fields( $single_publication->ID );
            if ( 
                ( $conditions['organization'] == '' || $conditions['organization'] == $single_publication->fields['slug_org']['0']->post_title ) 
                && ( $single_publication->fields['report_publication'] == 0 )
                && ( $conditions['reportType'] == '0' || ( $conditions['reportType'] == strval ( $single_publication->fields['type_report'] + 1 ) ) )
                && ( $conditions['year'] == '' || $conditions['year'] == $single_publication->fields['pub_year'] )
                && ( $conditions['language'] == '0' || $conditions['language'] != '0' && $conditions['language'] == strval ( $single_publication->fields['language_publication'] + 1 ) )
            ) :
                $filtered_publications[] = $single_publication;
            endif;
        endforeach;


        wp_send_json_success( array(
            'conditions' => $conditions,
            'unfilteredPublications' => $publications,
            'filteredPublications' => $filtered_publications,
        ) );
    }

    function oak_get_all_data_for_corn() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'oak_organizations';
        $organizations = $wpdb->get_results ( "
            SELECT * 
            FROM $table_name
        " );
        $organizations_without_redundancy = [];
        $reversed_organizations = array_reverse( $organizations );
        foreach ( $reversed_organizations as $organization ) :
            $exists = false;
            foreach( $organizations_without_redundancy as $organization_without_redundancy ) :
                if ( $organization_without_redundancy->organization_identifier == $organization->organization_identifier ) :
                    $exists = true;
                endif;
            endforeach;
            if ( !$exists ) :
                $organizations_without_redundancy[] = $organization;
            endif;
        endforeach; 

        $table_name = $wpdb->prefix . 'oak_publications';
        $publications = $wpdb->get_results ( "
            SELECT * 
            FROM $table_name
        " );
        $publications_without_redundancy = [];
        $reversed_publications = array_reverse( $publications );
        foreach ( $reversed_publications as $publication ) :
            $exists = false;
            foreach( $publications_without_redundancy as $publication_without_redundancy ) :
                if ( $publication_without_redundancy->publication_identifier == $publication->publication_identifier ) :
                    $exists = true;
                endif;
            endforeach;
            if ( !$exists ) :
                $publications_without_redundancy[] = $publication;
            endif;
        endforeach; 

        $fields_table_name = $wpdb->prefix . 'oak_fields';
        $fields = $wpdb->get_results ( "
            SELECT * 
            FROM  $fields_table_name
        " );
        $fields_without_redundancy = [];
        $reversed_fields = array_reverse( $fields );
        foreach( $reversed_fields as $field ) :
            $added = false;
            foreach( $fields_without_redundancy as $field_without_redundancy ) :
                if ( $field_without_redundancy->field_identifier == $field->field_identifier ) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $fields_without_redundancy[] = $field;
            endif;
        endforeach;

        $forms_table_name = $wpdb->prefix . 'oak_forms';
        $forms = $wpdb->get_results ( "
            SELECT * 
            FROM  $forms_table_name
        " );
        $forms_without_redundancy = [];
        $reversed_forms = array_reverse( $forms );
        foreach( $reversed_forms as $form ) :
            $added = false;
            foreach( $forms_without_redundancy as $form_without_redundancy ) :
                if ( $form_without_redundancy->form_identifier == $form->form_identifier) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $forms_without_redundancy[] = $form;
            endif;
        endforeach;

        $models_table_name = $wpdb->prefix . 'oak_models';
        $models = $wpdb->get_results ( "
            SELECT * 
            FROM  $models_table_name
        " );
        $reversed_models = array_reverse( $models );
        $models_without_redundancy = [];
        foreach( $reversed_models as $model ) :
            $added = false;
            foreach( $models_without_redundancy as $model_without_redundancy ) :
                if ( $model_without_redundancy->model_identifier == $model->model_identifier ) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $models_without_redundancy[] = $model;
            endif;
        endforeach;

        $all_objects = [];
        foreach( $models_without_redundancy as $model ) :
            $model_table_name = $wpdb->prefix . 'oak_' . $model->model_identifier;
            $objects = $wpdb->get_results ( "
                SELECT * 
                FROM  $model_table_name
            " );
            $reversed_objects = array_reverse( $objects );
            $objects_without_redundancy = [];
            foreach( $reversed_objects as $object ) :
                $added = false;
                foreach( $objects_without_redundancy as $object_without_redundancy ) :
                    if ( $object_without_redundancy->object_identifier == $object->object_identifier) :
                        $added = true;
                    endif;
                endforeach;
                if ( !$added ) :
                    $objects_without_redundancy[] = $object;
                endif;
            endforeach;
            
            $all_objects[] = array(
                'model_identifier' => $model->model_identifier,
                'objects' => $objects,
                'objectsWithoutRedundancy' => $objects_without_redundancy
            );
        endforeach;

        $taxonomies_table_name = $wpdb->prefix . 'oak_taxonomies';
        $taxonomies = $wpdb->get_results ( "
            SELECT * 
            FROM  $taxonomies_table_name
        " );
        $reversed_taxonomies = array_reverse( Oak::$taxonomies );
        $taxonomies_without_redundancy = [];
        foreach( $reversed_taxonomies as $taxonomy ) :
            $added = false;
            foreach( $taxonomies_without_redundancy as $taxonomy_without_redundancy ) :
                if ( $taxonomy_without_redundancy->taxonomy_identifier == $taxonomy->taxonomy_identifier) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $taxonomies_without_redundancy[] = $taxonomy;
            endif;
        endforeach;

        $all_terms = [];
        foreach( $taxonomies_without_redundancy as $taxonomy ) :
            $taxonomy_table_name = $wpdb->prefix . 'oak_taxonomy_' . $taxonomy->taxonomy_identifier;
            $terms = $wpdb->get_results ( "
                SELECT * 
                FROM  $taxonomy_table_name
            " );
            $reversed_terms = array_reverse( $terms );
            $terms_without_redundancy = [];
            foreach( $reversed_terms as $term ) :
                $added = false;
                foreach( $terms_without_redundancy as $term_without_redundancy ) :
                    if ( $term_without_redundancy->term_identifier == $term->term_identifier) :
                        $added = true;
                    endif;
                endforeach;
                if ( !$added ) :
                    $terms_without_redundancy[] = $term;
                endif;
            endforeach;
            
            $all_terms[] = array(
                'taxonomy_identifier' => $taxonomy->taxonomy_identifier,
                'terms' => $terms,
                'termsWithoutRedundancy' => $terms_without_redundancy
            );
        endforeach;

        $qualis_table_name = $wpdb->prefix . 'oak_qualis';
        $qualis = $wpdb->get_results ( "
            SELECT * 
            FROM  $qualis_table_name
        " );
        $reversed_quali = array_reverse( $qualis );
        $qualis_without_redundancy = [];
        foreach( $reversed_quali as $quali ) :
            $added = false;
            foreach( $qualis_without_redundancy as $quali_without_redundancy ) :
                if ( $quali_without_redundancy->quali_identifier == $quali->quali_identifier ) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $qualis_without_redundancy[] = $quali;
            endif;
        endforeach;

        $quantis_table_name = $wpdb->prefix . 'oak_quantis';
        $quantis = $wpdb->get_results ( "
            SELECT * 
            FROM  $quantis_table_name
        " );
        $reversed_quanti = array_reverse( $quantis );
        $quantis_without_redundancy = [];
        foreach( $reversed_quanti as $quanti ) :
            $added = false;
            foreach( $quantis_without_redundancy as $quanti_without_redundancy ) :
                if ( $quanti_without_redundancy->quanti_identifier == $quanti->quanti_identifier ) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $quantis_without_redundancy[] = $quanti;
            endif;
        endforeach;

        $glossaries_table_name = $wpdb->prefix . 'oak_glossaries';
        $glossaries = $wpdb->get_results ( "
            SELECT * 
            FROM  $glossaries_table_name
        " );
        $reversed_glossary = array_reverse( $glossaries );
        $glossaries_without_redundancy = [];
        foreach( $reversed_glossary as $glossary ) :
            $added = false;
            foreach( $glossaries_without_redundancy as $glossary_without_redundancy ) :
                if ( $glossary_without_redundancy->glossary_identifier == $glossary->glossary_identifier ) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $glossaries_without_redundancy[] = $glossary;
            endif;
        endforeach;

        $terms_and_objects_table_name = Oak::$terms_and_objects_table_name;
        $terms_and_objects = $wpdb->get_results ( "
            SELECT * 
            FROM $terms_and_objects_table_name
        " );

        wp_send_json_success( array(
            'fields' => $fields,
            'fieldsWithoutRedundancy' => $fields_without_redundancy,
            'forms' => $forms,
            'formsWithoutRedundancy' => $forms_without_redundancy,
            'models' => $models,
            'modelsWihoutRedundancy' => $models_without_redundancy,
            'taxonomies' => $taxonomies,
            'taxonomiesWithoutRedundancy' => $taxonomies_without_redundancy,
            'publications' => $publications,
            'publicationsWithoutRedundancy' => $publications_without_redundancy,
            'organizations' => $organizations,
            'organizationsWithoutRedundancy' => $organizations_without_redundancy,
            'allTerms' => $all_terms,
            'allObjects' => $all_objects,
            'qualis' => $qualis,
            'qualisWithoutRedundancy' => $qualis_without_redundancy,
            'quantis' => $quantis,
            'quantisWithoutRedundancy' => $quantis_without_redundancy,
            'glossaries' => $glossaries,
            'glossariesWithoutRedundancy' => $glossaries_without_redundancy,
            'termsAndObjects' => $terms_and_objects
        ) );
    }

    function corn_save_data() {
        global $wpdb; 

        $selected_data = $_POST['selectedData'];
        $fields = $selected_data['fields'];
        $forms = $selected_data['forms'];
        $models = $selected_data['models'];
        $taxonomies = $selected_data['taxonomies'];
        $objects = $selected_data['objects'];
        $terms = $selected_data['terms'];
        $glossaries = $selected_data['glossaries'];
        $qualis = $selected_data['qualis'];
        $quantis = $selected_data['quantis'];
        $terms_and_objects = $selected_data['termsAndObjects'];

        foreach ( $fields as $field ) :
            $this->oak_register_field( $field );
        endforeach;

        foreach( $forms as $form ) :
            $this->oak_register_form( $form );
        endforeach;

        foreach( $models as $model ) :
            $this->oak_register_model( $model );
        endforeach;

        foreach( $taxonomies as $taxonomy ) :
            $this->oak_register_taxonomy( $taxonomy );
        endforeach;

        foreach( $glossaries as $glossary ) :
            $this->oak_register_glossary( $glossary );
        endforeach;

        foreach( $qualis as $quali ) :
            $this->oak_register_quali( $quali );
        endforeach;

        foreach( $quantis as $quanti ) :
            $this->oak_register_quanti( $quanti );
        endforeach;

        $this->oak_register_organization( $selected_data['organization'] );
        $this->oak_register_publication( $selected_data['publication'] );

        foreach( $terms_and_objects as $term_and_object ) :
            $table_name = $wpdb->prefix . 'oak_terms_and_objects';
            unset( $term_and_object['id'] );
            $result = $wpdb->insert(
                $table_name,
                $term_and_object
            );
        endforeach;

        foreach( $objects as $object ) :
            $table_name = $wpdb->prefix . 'oak_' . $object['model'];
            unset( $object['model'] );
            unset( $object['id'] );

            $result = $wpdb->insert( 
                $table_name,
                $object
             );
        endforeach;

        foreach( $terms as $term ) :
            $table_name = $wpdb->prefix . 'oak_taxonomy_' . $term['term_taxonomy_identifier'];
            unset( $term['term_taxonomy_identifier'] );
            unset( $term['term_taxonomy_designation'] );
            unset( $term['id'] );

            $result = $wpdb->insert( 
                $table_name,
                $term
            );
        endforeach;

        wp_send_json_success( array( 
            'selected data' => $selected_data,
            'objects' => $objects

        ) );
    }

    function oak_wordpress_dashboard() {
        include get_template_directory() . '/template-parts/admin-menu.php';
        include get_template_directory() . '/template-parts/system-bar.php';
        include get_template_directory() . '/template-parts/app-bar.php';
    }
}

$oak = new oak();

