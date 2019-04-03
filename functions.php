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
    public static $goodpractices_table_name;
    public static $performances_table_name;
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

    public static $terms;
    public static $terms_without_redundancy = [];
    public static $objects;
    public static $objects_without_redundancy = [];
    public static $all_objects;
    public static $all_terms;
    public static $all_objects_without_redundancy = [];
    public static $all_terms_without_redundancy = [];

    public static $terms_and_objects = [];

    public static $models;
    public static $models_without_redundancy = [];
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

    public static $goodpractices;
    public static $goodpractices_without_redundancy;
    public static $goodpractice_properties;

    public static $performances;
    public static $performances_without_redundancy;
    public static $performance_properties;

    public static $taxonomies;
    public static $taxonomies_without_redundancy = [];
    public static $taxonomy_properties;

    public static $frame_publications_identifiers = [];
    public static $frame_terms_identifiers = [];
    public static $all_frame_objects_without_redundancy = [];

    public static $term_objects_without_redundancy = [];

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
        Oak::$goodpractices_table_name = $wpdb->prefix . 'oak_goodpractices';
        Oak::$performances_table_name = $wpdb->prefix . 'oak_performances';
        Oak::$terms_and_objects_table_name = $wpdb->prefix . 'oak_terms_and_objects';
        Oak::$forms_and_fields_table_name = $wpdb->prefix . 'oak_forms_and_fields';
        Oak::$models_and_forms_table_name = $wpdb->prefix . 'oak_models_and_forms';

        Oak::$forms_attributes = [];
        Oak::$all_objects = [];
        Oak::$all_terms = [];
        Oak::$all_terms_without_redundancy = [];

        // $this->delete_everything();

        Oak::$field_types = array (
            array ( 'value' => 'Texte', 'innerHTML' => 'Texte' ), 
            array ( 'value' => 'Zone de Texte', 'innerHTML' => 'Zone de Texte'), 
            array ( 'value' => 'Image', 'innerHTML' => 'Image' ),
            array ( 'value' => 'Fichier', 'innerHTML' => 'Fichier' ),
            array ( 'value' => 'Url', 'innerHTML' => 'Url' ),
            array ( 'value' => 'Indicateur Qualitatif', 'innerHTML' => 'Indicateur Qualitatif' ),
            array ( 'value' => 'Indicateur Quantitatif', 'innerHTML' => 'Indicateur Quantitatif' ),
            array ( 'value' => 'Selecteur', 'innerHTML' => 'Selecteur' ),
        );

        add_action( 'wp_enqueue_scripts', array( $this, 'oak_enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'oak_enqueue_scripts' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'oak_admin_enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'oak_admin_enqueue_scripts' ) );

        add_action( 'add_meta_boxes', array ( $this, 'oak_add_meta_box_to_posts' ) );

        add_action( 'init', array( $this, 'add_cors_http_header' ) );

        add_action( 'after_setup_theme', array( $this, 'oak_add_theme_support' ) );

        add_action( 'admin_head', array ( $this, 'oak_wordpress_dashboard' ) );
        
        $this->oak_elementor_initialization();
        
        add_action( 'admin_menu', array( $this, 'oak_handle_admin_menu' ) );

        add_action( 'save_post', array ( $this, 'oak_save_post_meta_fields' ) );

        
        $this->oak_ajax_calls();

        $this->oak_contact_form();
    }
    
    function oak_ajax_calls() {
        add_action('wp_ajax_oak_save_configuration', array( $this, 'oak_save_configuration') );
        add_action('wp_ajax_nopriv_oak_save_configuration', array( $this, 'oak_save_configuration') );

        add_action('wp_ajax_oak_save_analysis_model', array( $this, 'oak_save_analysis_model') );
        add_action('wp_ajax_nopriv_oak_save_analysis_model', array( $this, 'oak_save_analysis_model') );

        add_action( 'wp_ajax_oak_save_analyzes', array( $this, 'oak_save_analyzes') );
        add_action( 'wp_ajax_nopriv_oak_save_analyzes', array( $this, 'oak_save_analyzes') );

        add_action( 'wp_ajax_oak_get_organizations', array( $this, 'oak_get_organizations') );
        add_action( 'wp_ajax_nopriv_oak_get_organizations', array( $this, 'oak_get_organizations') );

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

        add_action('wp_ajax_oak_get_all_data_for_corn', array( $this, 'oak_get_all_data_for_corn') );
        add_action('wp_ajax_nopriv_oak_get_all_data_for_corn', array( $this, 'oak_get_all_data_for_corn') );

        add_action('wp_ajax_corn_save_data', array( $this, 'corn_save_data') );
        add_action('wp_ajax_nopriv_corn_save_data', array( $this, 'corn_save_data') );
    }

    function oak_enqueue_styles() {
        wp_enqueue_style( 'the_style', get_stylesheet_directory_uri() . '/style.css' );
        wp_enqueue_style( 'oak_global', get_template_directory_uri() . '/src/css/global.css' );
    }
    
    function oak_enqueue_scripts() {

        wp_enqueue_media();

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
        wp_enqueue_media();
        
        wp_enqueue_style( 'oak_global', get_template_directory_uri() . '/src/css/global.css' );

        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 

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

        // For the media library
        wp_enqueue_script( 'oak_media_library', get_template_directory_uri() . '/src/js/vendor/wp-media-modal.js', array('jquery'), false, true );

        // Admin menu
        wp_enqueue_script( 'admin_menu_script', get_template_directory_uri() . '/src/js/admin-menu.js', array('jquery'), false, true );
        wp_localize_script( 'admin_menu_script', 'DATA', array(
            'ajaxUrl' => admin_url('admin-ajax.php')
        ) );

        // Auto complete
        wp_enqueue_script( 'auto_complete', get_template_directory_uri() . '/src/js/autocomplete.js', array('jquery'), false, true );

        // Configuration page
        if ( get_current_screen()->id == 'toplevel_page_oak_materiality_reporting' ) :
            wp_enqueue_script( 'oak_configuration_script', get_template_directory_uri() . '/src/js/configuration-page.js', array('jquery'), false, true );
            wp_localize_script( 'oak_configuration_script', 'DATA', array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'oakWhichPerimeter' => get_option('oak_which_perimeter') != false ? get_option('oak_which_perimeter') : 0
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

        // data studio
        if ( get_current_screen()->id == 'toplevel_page_oak_data_studio' ) :
            wp_enqueue_script( 'oak_charts', get_template_directory_uri() . '/src/js/vendor/chart.bundle.min.js', array(), false, true);
            wp_enqueue_script( 'oak_data_studio', get_template_directory_uri() . '/src/js/data-studio.js', array('jquery'), false, true );
            wp_localize_script( 'oak_data_studio', 'DATA', array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'allData' => array(
                    'organizations' => array(
                        'organizations' => Oak::$organizations,
                        'organizationsWithoutRedundancy' => Oak::$organizations_without_redundancy,
                    ),
                    'publications' => array(
                        'publications' => Oak::$publications,
                        'publicationsWithoutRedundancy' => Oak::$publications_without_redundancy,
                    ),
                    'quantis' => array(
                        'quantis' => Oak::$quantis,
                        'quantisWithoutRedundancy' => Oak::$quantis_without_redundancy,
                    ),
                    'performances' => array(
                        'performances' => Oak::$performances,
                        'performancesWithoutRedundancy' => Oak::$performances_without_redundancy,
                    )
                )
            ) );
        endif;

        if ( get_current_screen()->id == 'toplevel_page_oak_corn_configuration_page' ) :
            wp_enqueue_script( 'oak_corn_configuration_page', get_template_directory_uri() . '/src/js/corn-configuration-page.js', array(), false, true);
            wp_localize_script( 'oak_data_studio', 'DATA', array(
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
                    'formsAndFields' => Oak::$all_forms_and_fields,
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
            if ( $_GET['elements'] == 'goodpractices' ) :
                $table = 'goodpractice';
                $table_in_plural = 'goodpractices';
                $elements = Oak::$goodpractices;
                $properties = array_merge( $properties, Oak::$goodpractice_properties );
            endif;
            if ( $_GET['elements'] == 'performances' ) :
                $table = 'performance';
                $table_in_plural = 'performances';
                $elements = Oak::$performances;
                $properties = array_merge( $properties, Oak::$performance_properties );
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
                foreach( $elements as $object ) :
                    $object->object_model_identifier = $_GET['model_identifier'];
                endforeach;
                
                foreach( Oak::$current_model_fields as $key => $field ) :
                    $input_type = 'text';
                    if ( $field->field_type == 'Image' ) :
                        $input_type = 'image';
                    elseif( $field->field_type == 'Fichier' ) :
                        $input_type = 'file';
                    elseif( $field->field_type == 'Zone de Texte' ) :
                        $input_type = 'textarea';
                    elseif( $field->field_type == 'Indicateur Qualitatif' ) :
                        $input_type = 'quali';
                    elseif( $field->field_type == 'Indicateur Quantitatif' ) :
                        $input_type = 'quanti';
                    elseif( $field->field_type == 'Selecteur' ) :
                        $input_type = 'selector';
                    endif;;

                    Oak::$object_properties[] = array (
                        'name' => $key . '_' . $field->field_identifier,
                        'property_name' => 'object_' . $key . '_' . $field->field_identifier, 
                        'type' => 'text',
                        'input_type' => $input_type,
                        'placeholder' => $field->form_and_field_properties->field_designation != '' ? $field->form_and_field_properties->field_designation : $field->field_designation,
                        'description' => $field->form_and_field_properties->field_designation != '' ? $field->form_and_field_properties->field_designation : $field->field_designation,
                        'selector' => $field->field_selector,
                        'width' => '50',
                        'model_and_form_instance' => $field->model_and_form_instance,
                        'form' => $field->form
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

            if ( $_GET['elements'] == 'term_objects' ) :
                $title = __( 'Objets', Oak::$text_domain );
                $term_identifier = $_GET['term_identifier'];
                foreach( Oak::$terms_and_objects as $term_and_object ) :
                    if ( $term_and_object->term_identifier == $term_identifier ) :
                        foreach( Oak::$all_objects_without_redundancy as $object ) :
                            if ( $object->object_identifier == $term_and_object->object_identifier ) :
                                Oak::$term_objects_without_redundancy[] = $object;
                            endif;
                        endforeach;
                    endif;
                endforeach;

                $table = 'object';
                $table_in_plural = 'objects';
                $elements = Oak::$term_objects_without_redundancy;
                // $properties = array_merge( $properties, Oak::$glossary_properties );
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
                'termIdentifier' => isset ( $_GET['term_identifier'] ) ? $_GET['term_identifier'] : ''
            );
            $final_data_to_pass = array_merge( $basic_data_to_pass, $additional_data_to_pass );
            
            if ( $_GET['listorformula'] == 'formula' ) :
                wp_enqueue_script( 'corn_add_element', get_template_directory_uri() . '/src/js/add-element.js', array( 'jquery', 'wp-color-picker' ), false, true );
                wp_localize_script( 'corn_add_element', 'DATA', $final_data_to_pass );
            endif;

            if ( $_GET['listorformula'] == 'list' ) :
                wp_enqueue_script( 'corn_elements_list', get_template_directory_uri() . '/src/js/elements-list.js', array('jquery'), false, true );
                wp_localize_script( 'corn_elements_list', 'DATA', $final_data_to_pass );
            endif;
        endif;
    }

    

    function oak_add_meta_box_to_posts() {
        $this->oak_add_meta_data();

        $posts = [ 'post', 'page' ];
        foreach( $posts as $post ) :
            add_meta_box(
                'objects_selector', // $id
                'Objets', // $title
                array( $this, 'oak_add_meta_box_to_posts_view' ), // $callback
                $post, // $screen
                'normal', // $context
                'high' // $priority
            );
        endforeach;
    }

    static function oak_add_meta_data() {
        $the_returned_fields = [];
        // We need to delete all post meta first to avoid old unneccesary data
        // $metas = get_post_meta( get_the_ID() );
        // foreach( $metas as $key => $meta ) :
        //     if ( $key != 'objects_selector' ) :
        //         delete_post_meta( get_the_ID(), $key );
        //     endif;
        // endforeach;

        global $wpdb; 

        $selected_objects = get_post_meta( get_the_ID(), 'objects_selector' ) ? get_post_meta( get_the_ID(), 'objects_selector' ) [0] : [];

        $our_objects = [];

        foreach( Oak::$models_without_redundancy as $model ) :
            $table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
            $objects = $wpdb->get_results ( "
                SELECT * 
                FROM  $table_name
            " );
            $objects = array_reverse( $objects );
            foreach( $objects as $object ) : 
                if ( in_array( $object->object_identifier, $selected_objects ) ) :
                    $exists = false;
                    foreach( $our_objects as $already_added_object ) :
                        if ( $already_added_object->object_identifier == $object->object_identifier ) :
                            $exists = true;
                        endif;
                    endforeach;
                    if ( !$exists ) :
                        $our_objects[] = $object;
                    endif;
                endif;
            endforeach;
        endforeach;

        foreach( $our_objects as $index => $object ) :
            $field_designations_used = [];
            foreach( $object as $key => $value ) :

                if ( $value == NULL ) :
                    $value = '';
                endif;

                if ( $key != 'object_form_selectors' ) :
                    $key_devided = explode( '_', $key );
                    $field_name = '';
                    switch ( $key ) :
                        case 'object_modification_time' :
                            $field_name = __( 'Dernière modification', Oak::$text_domain );
                        break;
                        case 'object_state' :
                            $field_name = __( 'Etat', Oak::$text_domain );
                        break;
                        case 'object_identifier' :
                            $field_name = __( 'Identifiant', Oak::$text_domain );
                        break;
                        case 'object_trashed' :
                            $field_name = __( 'Corbeille', Oak::$text_domain );
                        break;
                        default :
                            $field_name = $key_devided[ count( $key_devided ) - 1 ];
                        break;
                    endswitch;
                    $field_designation = __( 'Objet', Oak::$text_domain ) . ' ' . $index . ': ' . $field_name;
                    $field_type = '';
                    if ( count ( $key_devided ) > 2 ) :
                        $field_identifier = $key_devided[2];
                        foreach( Oak::$fields_without_redundancy as $field ) :
                            if ( $field->field_identifier == $field_identifier ) :

                                $number_of_times_designation_was_used = 0;
                                foreach( $field_designations_used as $used_designation ) :
                                    if ( $used_designation == $field->field_designation ) :
                                        $number_of_times_designation_was_used++;
                                    endif;
                                endforeach;

                                $number_of_times_designation_was_used = $number_of_times_designation_was_used == 0 ? '' : $number_of_times_designation_was_used + 1;
                                $field_designations_used[] = $field->field_designation;
                                $field_designation = __( 'Objet', Oak::$text_domain ) . ' ' . $index . ': ' . $field->field_designation . ' ' . $number_of_times_designation_was_used;
                                $field_type = $field->field_type;
                            endif;
                        endforeach;
                    endif;
                    $the_returned_fields [] = array(
                        'field_designation' => $field_designation,
                        'value' => $value,
                        'field_type' => $field_type
                    );
                    update_post_meta( get_the_ID(), $field_designation, $value );
                endif;
            endforeach;
        endforeach;

        $query_images_args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => - 1,
        );
        
        $query_images = new WP_Query( $query_images_args );	
        $images = array();
        foreach ( $query_images->posts as $image ) {
            $images[] = array ( 'url' => wp_get_attachment_url( $image->ID ), 'id' => $image->ID );
        }	

        // I pass the data to dynamic tags via the table options (Because there is an error of denied access if I happen to do this in the register controls function)
        update_option( 'oak_post_elementor_fields', $the_returned_fields );
        update_option( 'oak_all_images', $images );

        return $the_returned_fields;
    }

    function oak_add_meta_box_to_posts_view( $post, $args ) {
        $selected_objects = get_post_meta( get_the_ID(), 'objects_selector' ) ? get_post_meta( get_the_ID(), 'objects_selector' ) [0] : [];
        ?>
        <select multiple name="objects_selector[]" class="oak_post_objects_selector">
            <?php
            foreach( Oak::$all_objects_without_redundancy as $object ) : 
                $selected = '';
                foreach( $selected_objects as $selected_object_identifier ) :
                    if ( $selected_object_identifier == $object->object_identifier ) :
                        $selected = 'selected';
                    endif;
                endforeach;
                ?>
                <option <?php echo( $selected ); ?> value="<?php echo( $object->object_identifier ); ?>"><?php echo( $object->object_designation ); ?></option>
                <?php
            endforeach;
            ?>
        </select>

        <?php
    }

    function oak_save_post_meta_fields( $post_id ) {
        if ( !isset( $_POST['objects_selector'] ) ) :
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
        $new = $_POST['objects_selector'];

        if ( $new && $new !== $old ) {
            update_post_meta( $post_id, 'objects_selector', $new );
        } elseif ( '' === $new && $old ) {
            delete_post_meta( $post_id, 'objects_selector', $old );
        }
    }

    
    function oak_add_theme_support() {
        add_theme_support('menus');
        include get_template_directory() . '/functions/tables.php';
        include get_template_directory() . '/functions/properties-initialization.php';
    }

    function add_cors_http_header() {
        header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Origin: http://localhost:8888/test/wp-admin/admin-ajax.php');
    }

    function oak_elementor_initialization() {
        if ( get_option('oak_corn') == 'true' ) :
            if ( !did_action( 'elementor/loaded' ) == 1 ) :
                add_action( 'admin_notices', array( $this, 'oak_admin_notice_missing_elementor_plugin' ) );
            else :
                // This is corn, and elementor is installed. So we do everything related to elementor :) 
                $this->oak_add_tags();
                $this->oak_add_widget_categories();
                $this->oak_add_widgets();
            endif;
        endif;
    }

    function oak_add_tags() {
        add_action( 'elementor/dynamic_tags/register_tags', function( $dynamic_tags ) {
            \Elementor\Plugin::$instance->dynamic_tags->register_group( 'oak', [
                'title' => __( 'Oak', Oak::$text_domain ) 
            ] );

            include_once get_template_directory() . '/functions/elementor/dynamic_tag.php';

            $tag = new Dynamic_Tag();
            $dynamic_tags->register_tag( 'Dynamic_Tag' );
        } );
    }

    function oak_add_widget_categories() {
        add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
            $elements_manager->add_category(
                'oak',
                [
                    'title' => __( 'OAK', Oak::$text_domain ),
                    'icon' => 'fa fa-plug',
                ]
            );
        } );
    }

    function oak_add_widgets() {
        add_action('elementor/widgets/widgets_registered', function( $widgets_manager ) {

            include_once get_template_directory() . '/functions/elementor/generic_widget.php';

            global $wpdb; 

            $selected_objects = get_post_meta( get_the_ID(), 'objects_selector' ) ? get_post_meta( get_the_ID(), 'objects_selector' ) [0] : [];

            $our_objects = [];

            foreach( Oak::$models_without_redundancy as $model ) :
                $table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
                $objects = $wpdb->get_results ( "
                    SELECT * 
                    FROM  $table_name
                " );
                $objects = array_reverse( $objects );
                foreach( $objects as $object ) : 
                    if ( in_array( $object->object_identifier, $selected_objects ) ) :
                        $exists = false;
                        foreach( $our_objects as $already_added_object ) :
                            if ( $already_added_object->object_identifier == $object->object_identifier ) :
                                $exists = true;
                            endif;
                        endforeach;
                        if ( !$exists ) :
                            $our_objects[] = $object;
                        endif;
                    endif;
                endforeach;
            endforeach;

            $variables = [];
            foreach( $our_objects as $index => $object ) :
                $input_type = 'text';
                $field_designations_used = [];
                foreach( $object as $key => $value ) :

                    if ( $value == NULL ) :
                        $value = '';
                    endif;

                    if ( $key != 'object_form_selectors' ) :
                        $key_devided = explode( '_', $key );
                        $field_name = '';
                        switch ( $key ) :
                            case 'object_modification_time' :
                                $field_name = __( 'Dernière modification', Oak::$text_domain );
                            break;
                            case 'object_state' :
                                $field_name = __( 'Etat', Oak::$text_domain );
                            break;
                            case 'object_identifier' :
                                $field_name = __( 'Identifiant', Oak::$text_domain );
                            break;
                            case 'object_trashed' :
                                $field_name = __( 'Corbeille', Oak::$text_domain );
                            break;
                            default :
                                $field_name = $key_devided[ count( $key_devided ) - 1 ];
                            break;
                        endswitch;
                        $field_designation = __( 'Objet', Oak::$text_domain ) . ' ' . $index . ': ' . $field_name;
                        $field_type = 'Texte';
                        if ( count ( $key_devided ) > 2 ) :
                            $field_identifier = $key_devided[2];
                            foreach( Oak::$fields_without_redundancy as $field ) :
                                if ( $field->field_identifier == $field_identifier ) :

                                    $number_of_times_designation_was_used = 0;
                                    foreach( $field_designations_used as $used_designation ) :
                                        if ( $used_designation == $field->field_designation ) :
                                            $number_of_times_designation_was_used++;
                                        endif;
                                    endforeach;

                                    $number_of_times_designation_was_used = $number_of_times_designation_was_used == 0 ? '' : $number_of_times_designation_was_used + 1;
                                    $field_designations_used[] = $field->field_designation;
                                    $field_designation = __( 'Objet', Oak::$text_domain ) . ' ' . $index . ': ' . $field->field_designation . ' ' . $number_of_times_designation_was_used;
                                    $field_type = $field->field_type;
                                endif;
                            endforeach;
                        endif;
                        
                        $widget_options = array(
                            'name' => preg_replace( '/\s+/', '', $field_designation ),
                            'title' => $field_designation,
                            'icon' => $field_type == 'Image' ? 'eicon-image' : 'eicon-type-tool',
                            'categories' => [ 'oak' ],
                            'value' => $value,
                            'field_type' => $field_type,
                        );
                        $generic_widget = new Generic_Widget();
                        $generic_widget->set_widgets_options( $widget_options );
                        $widgets_manager->register_widget_type( $generic_widget );
                    endif;
                endforeach;
            endforeach;
        }, 14);
    }

    function oak_admin_notice_missing_elementor_plugin() {
        
		$message = sprintf(
			esc_html__( 'Pour assurer un bon fonctionnement du "%1$s" , vous devriez avoir "%2$s" installé dans votre environnement.', Oak::$text_domain ),
			'<strong>' . esc_html__( 'Web Publisher', Oak::$text_domain ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', Oak::$text_domain ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

    function oak_handle_admin_menu() {
        // add_menu_page( 'Admin Menu', 'Admin Menu', 'manage_options', 'admin_menu', , $icon_url, $position)
        add_menu_page( 'OAK (Materiality Reporting)', 'OAK (Materiality Reporting)', 'manage_options', 'oak_materiality_reporting', array( $this, 'oak_materility_reporting' ), 'dashicons-chart-pie', 99 );

        add_menu_page( 'Importation des données', 'Importation des données', 'manage_options', 'oak_import_page', array( $this, 'oak_import_page' ), 'dashicons-chart-pie', 100 );

        add_menu_page( 'Data Studio', 'Data Studio', 'manage_options', 'oak_data_studio', array( $this, 'oak_data_studio' ), 'dashicons-chart-pie', 100 );

        add_menu_page( 'Paramètres', 'Paramètres', 'manage_options', 'oak_corn_configuration_page', array( $this, 'oak_corn_configuration_page' ), 'dashicons-chart-pie', 100 );

        add_submenu_page( 'oak_materiality_reporting', __('Analyse Critique', Oak::$text_domain), __('Analyse Critique', Oak::$text_domain), 'manage_options', 'oak_critical_analysis', array( $this, 'oak_critical_analysis') );
        add_submenu_page( 'oak_materiality_reporting', 'Modèle d\'analyse', 'Cofiguration', 'manage_options', 'oak_critical_analysis_configuration', array( $this, 'oak_critical_analysis_configuration') );

        add_menu_page( __( 'Elements', Oak::$text_domain ), 'Elements', 'manage_options', 'oak_elements_list', array ( $this, 'oak_elements_list'), 'dashicons-index-card', 100 );
        add_submenu_page( 'oak_elements_list', 'Ajouter un Element', __( 'Ajouter un Element', Oak::$text_domain ), 'manage_options', 'oak_add_element',  array( $this, 'oak_add_element' ) );

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

    function oak_data_studio() {
        include get_template_directory() . '/template-parts/data-studio.php';
    }

    function oak_corn_configuration_page() {
        include get_template_directory() . '/template-parts/corn-configuration-page.php';
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

    static function oak_get_countries_names() {

        if ( get_option('oak_countries_names') ) :
            return get_option('oak_countries_names');
        endif;

        $country_query_result = wp_remote_get( 'https://restcountries.eu/rest/v2/all' );
        $countries = json_decode( $country_query_result['body'] );
        $names = [];
        foreach( $countries as $country ) :
            $names[] = $country->name;
        endforeach;

        update_option( 'oak_countries_names', $names );

        return $names;
    }

    static function oak_get_languages() {
        if ( get_option('oak_languages') ) :
            return get_option('oak_languages');
        endif;

        $languages = [];
        $country_query_result = wp_remote_get( 'https://restcountries.eu/rest/v2/all' );
        $countries = json_decode( $country_query_result['body'] );

        foreach( $countries as $country ) :
            foreach( $country->languages as $language ) :
                if ( !in_array( $language->name, $languages ) )
                    $languages[] = $language->name;
            endforeach;
        endforeach;

        update_option( 'oak_languages', $languages );

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

    function oak_save_configuration() {
        $data = $_POST['data'];
        $default_menu = $data['defaultMenu'];
        $central = $data['central'];
        $central_url = $data['centralUrl'];
        $business_line = $data['businessLine'];
        $which_perimeter = $data['whichPerimeter'];
        $regions = $data['regions'];
        $custom_perimeter = $data['customPerimeter'];

        update_option( 'oak_default_menu', $default_menu );
        update_option( 'oak_corn', $central );
        update_option( 'oak_central_url', $central_url );
        update_option( 'oak_business_line', $business_line );
        update_option( 'oak_which_perimeter', $which_perimeter );
        update_option( 'oak_regions', $regions );
        update_option( 'oak_custom_perimeter', $custom_perimeter );

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
            case 'goodpractices':
                $properties = Oak::$goodpractice_properties;
                $table = 'goodpractice';
                $title = __( 'Ajouter une Bonne Pratique', Oak::$text_domain );
            break;
            case 'performances':
                $properties = Oak::$performance_properties;
                $table = 'performance';
                $title = __( 'Ajouter une Donnée de performance', Oak::$text_domain );
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
                $first_property = array ( 'title' => __( 'Année', Oak::$text_domain ), 'property' => 'publication_year' );
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
            case 'goodpractices' :
                $title = __( 'Bonnes Pratiques', Oak::$text_domain );
                $elements = Oak::$goodpractices_without_redundancy;
                $table = 'goodpractice';
                $first_property = array ( 'title' => __( 'Nom', Oak::$text_domain ), 'property' => 'goodpractice_designation' );
                $second_property = array ( 'title' => __( 'Nom Court', Oak::$text_domain ), 'property' => 'goodpractice_short_designation' );
                $third_property = array ( 'title' => __( 'Lien', Oak::$text_domain ), 'property' => 'goodpractice_link' );;
            break;
            case 'performances' :
                $title = __( 'Données de performances', Oak::$text_domain );
                $elements = Oak::$performances_without_redundancy;
                $table = 'performance';
                $first_property = array ( 'title' => __( 'Nom', Oak::$text_domain ), 'property' => 'performance_designation' );
                $second_property = array ( 'title' => __( 'Type', Oak::$text_domain ), 'property' => 'performance_type' );
                $third_property = array ( 'title' => __( 'Objectif', Oak::$text_domain ), 'property' => 'performance_goal' );;
            break;
            case 'objects' :
                $reversed_objects = array_reverse( Oak::$objects  );
                foreach( $reversed_objects as $object ) :
                    $added = false;
                    foreach( Oak::$objects_without_redundancy as $object_without_redundancy ) :
                        if ( $object_without_redundancy->object_identifier == $object->object_identifier) :
                            $added = true;
                        endif;
                    endforeach;
                    if ( !$added ) :
                        Oak::$objects_without_redundancy[] = $object;
                    endif;
                endforeach;
                
                $title = __( 'Objets', Oak::$text_domain );
                $elements = Oak::$objects_without_redundancy;
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
            case 'term_objects' :
                $title = __( 'Objets', Oak::$text_domain );
                $elements = Oak::$term_objects_without_redundancy;

                $table = 'object';
                $first_property = array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'object_identifier' );
                $second_property = array ( 'title' => __( 'Sélecteur de cadres RSE', Oak::$text_domain ), 'property' => 'object_selector' );
                $third_property = array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'object_identifier' );
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

        // $element = $_POST['element'];
        $element = json_decode( stripslashes( $_POST['element'] ), true );

        foreach( $element as $key => $value ) :
            $element[ $key ] = $this->oak_filter_word( $value );
        endforeach;

        $table = $_POST['table'];

        // We are gonna be unsetting the objet_model_identifier property to not receive a databse error: 
        if ( $table == "object" && isset( $element['object_model_identifier'] ) ) :
            unset( $element['object_model_identifier'] );
        endif;

        $prefix = $wpdb->prefix . 'oak_';
        if ( $table == 'object' ) : 
            $prefix = $wpdb->prefix . 'oak_model_';
        elseif( $table == 'term' ) :
            $prefix = $wpdb->prefix . 'oak_taxonomy_';
        endif;

        $table_name = $prefix . $_POST['tableInPlural'];

        $array_data = array_merge( $element, array( $table . '_modification_time' => date("Y-m-d H:i:s") ) );

        // Other elements: fields for forms and forms for models
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

        $properties = '';
        if ( ( $_POST['table'] == 'form' || $_POST['table'] == 'model' ) && isset( $_POST['copy'] ) ) :
            $other_table = $_POST['table'] == 'form' ? 'field' : 'form';
            $associative_table_name = $_POST['table'] == 'form' ? Oak::$forms_and_fields_table_name : Oak::$models_and_forms_table_name;
            $identifier = $element['copy_identifier'];
            $associative_table_instances = $wpdb->get_results ( "
                SELECT * 
                FROM  $associative_table_name
            " );

            foreach( $associative_table_instances as $instance ) :
                $other_element_identifier_property = $other_table . '_identifier';
                $identifier_property = $_POST['table'] . '_identifier';
                $designation_property = $other_table . '_designation';
                $required_property = $other_table . '_required';
                $index_property = $other_table . '_index';
                $revision_number_property = $_POST['table'] . '_revision_number';
                $properties = array( $other_element_identifier_property, $identifier_property, $designation_property, $required_property,
                $index_property, $revision_number_property );
                if ( $instance->$identifier_property == $element['copy_identifier'] ) : 
                    $result = $wpdb->insert(
                        $associative_table_name,
                        array (
                            $_POST['table'] . '_identifier' => $element[ $table . '_identifier' ],
                            $other_table . '_identifier' => $instance->$other_element_identifier_property,
                            $other_table . '_designation' => $instance->$designation_property,
                            $other_table . '_required' => $instance->$required_property,
                            $other_table . '_index' => $instance->$index_property,
                            $_POST['table'] . '_revision_number' => $instance->$revision_number_property
                        )
                    );
                endif;
            endforeach;   
        endif;

        unset( $array_data['otherElements'] );
        unset( $array_data['otherElementsProperties'] );
        unset( $array_data['copy_identifier'] );
        
        // For the files/images: 
        // $test_file_url = '';
        // foreach( $array_data as $key => $value ) :
        //     foreach( $_POST['properties'] as $property ) :
        //         $property_name_divided = explode( '_', $property['name'] );
        //         $key_divided = explode( '_', $key ); 
        //         if ( $property_name_divided[ count( $property_name_divided ) - 1 ] == $key_divided[ count( $key_divided ) - 1 ] ) :
        //             if ( $property['input_type'] == 'image' || $property['input_type'] == 'file' ) :
        //                 if ( !filter_var( $value, FILTER_VALIDATE_URL ) && $value != '' ) :
        //                     $file_url = $this->upload_image( $value );
        //                     $array_data[ $key ] = $file_url;
        //                 endif;
        //             endif;
        //         endif;
        //     endforeach;

        // endforeach;

        // For objects' terms
        if ( $table = 'object' ) : 
            $terms_identifiers = $array_data['selected_terms'];

            foreach( Oak::$terms_and_objects as $term_and_object ) :
                if ( $term_and_object->object_identifier == $array_data['object_identifier'] 
                    && !in_array( $terms_identifiers, $term_and_object->term_identifier )
                ) :
                    $wpdb->delete( 
                        $wpdb->prefix . 'oak_terms_and_objects',  
                        array( 'term_identifier' => $term_and_object->term_identifier, 'object_identifier' => $array_data['object_identifier'] )
                    );
                endif;
            endforeach;

            foreach( $terms_identifiers as $term_identifier ) :
                $result = $wpdb->insert(
                    $wpdb->prefix . 'oak_terms_and_objects', 
                    array(
                        'term_identifier' => $term_identifier,
                        'object_identifier' => $array_data['object_identifier']
                    )
                );
            endforeach;
            unset( $array_data['selected_terms'] );
        endif;
        
        $result = $wpdb->insert(
            $table_name, 
            $array_data
        );

        wp_send_json_success( array(
            'properties' => $_POST['properties'],
            'array_data' => $array_data,
            'result' => $properties,
            'test' => $test_file_url
        ) );
    }

    function upload_file( $file ) {
        $file_url = '';
        
        $file_type = explode( ';', explode( '/', $file )[1] )[0];

        if ( !filter_var( $file, FILTER_VALIDATE_URL ) ) :
            // Uploading the image
            $uplad_dir  = wp_upload_dir();
            $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
            
            $file             = str_replace( 'data:application/' . $file_type . ';base64,', '', $file );
            $file             = str_replace( ' ', '+', $file );
            $decoded         = base64_decode( $file );
            $filename        = 'random.' . $file_type;
            $file_type       = 'application/' . $file_type;
            $hashed_filename = md5( $filename . microtime() ) . '_' . $filename;
            $upload_file = file_put_contents( $upload_path . $hashed_filename, $decoded );
            // $attachment = array(
            //     'post_mime_type' => $file_type,
            //     'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $hashed_filename ) ),
            //     'post_content'   => '',
            //     'post_status'    => 'inherit',
            //     'guid'           => $upload_dir['url'] . '/' . basename( $hashed_filename )
            // );
        
            // $attach_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $hashed_filename );
            // $file_url = wp_get_attachment_image_url( $attach_id );
        endif;

        return $hashed_filename;
    } 

    function upload_image( $image ) {
        $image_url = '';
        
        $image_type = explode( ';', explode( '/', $image )[1] )[0];

        if ( !filter_var( $image, FILTER_VALIDATE_URL ) ) :
            // Uploading the image
            $upload_dir  = wp_upload_dir();
            $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
            
            $img             = str_replace( 'data:image/' . $image_type . ';base64,', '', $image );
            $img             = str_replace( ' ', '+', $img );
            $decoded         = base64_decode( $img );
            $filename        = '.' . $image_type;
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

        $table_name = $wpdb->prefix . 'oak_' . $table_in_plural;
        if ( $table == 'term' ) :
            $table_name = $wpdb->prefix . 'oak_taxonomy_' . $table_in_plural; 
        elseif( $table == 'object' ) :
            $table_name = $wpdb->prefix . 'oak_model_' . $table_in_plural; 
        endif;

        foreach( $identifiers as $identifier ) :
        
            $result = $wpdb->update(
                $table_name,
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

        $table_name = $wpdb->prefix . 'oak_' . $table_in_plural;
        if ( $table == 'term' ) :
            $table_name = $wpdb->prefix . 'oak_taxonomy_' . $table_in_plural; 
        elseif( $table == 'object' ) :
            $table_name = $wpdb->prefix . 'oak_model_' . $table_in_plural; 
        endif;

        foreach( $identifiers as $identifier ) :
        
            $wpdb->delete( 
                $table_name, 
                array( $table . '_identifier' => $identifier )
            );

            if ( $data['otherElementsTableName'] ) :
                $wpdb->delete( 
                    $data['otherElementsTableName'], 
                    array( $table . '_identifier' => $identifier )
                );
            endif;

            // We are deleting the tables for models or taxonomies
            if ( $table == 'model' || $table == 'taxonomy' ) : 
                $table_name_to_delete = $wpdb->prefix . 'oak_' . $table . '_' . $identifier;
                $wpdb->query( "DROP TABLE IF EXISTS $table_name_to_delete" );
            endif;

        endforeach;

        wp_send_json_success( array(
            'table' => $table,
            'table_in_plural' => $table_in_plural,
            'identifiers' => $identifiers
        ) );
    }

    function oak_restore_from_trash() {
        $data = $_POST['data'];
        $table = $data['table'];
        $table_in_plural = $data['tableInPlural'];
        $identifiers = $data['identifiers'];

        global $wpdb;

        $table_name = $wpdb->prefix . 'oak_' . $table_in_plural;
        if ( $table == 'term' ) :
            $table_name = $wpdb->prefix . 'oak_taxonomy_' . $table_in_plural; 
        elseif( $table == 'object' ) :
            $table_name = $wpdb->prefix . 'oak_model_' . $table_in_plural; 
        endif;
        
        foreach( $identifiers as $identifier ) :
        
            $result = $wpdb->update(
                $table_name,
                array (
                    $table . '_trashed' => 'false',
                ),
                array( $table . '_identifier' => $identifier )
            );

        endforeach;

        wp_send_json_success();
    }

    function oak_import_csv() {
        // The well defined table name in this function is for the associative tables' names
        global $wpdb;

        $table = $_POST['table'];
        $rows = $_POST['rows'];
        $single_name = $_POST['single_name'];

        $table_name = $table;
        if ( $_POST['wellDefinedTableName'] == 'false' ) :
            $table_name = $wpdb->prefix . 'oak_' . $table;
            if ( $single_name == 'term' ) :
                $table_name = $wpdb->prefix . 'oak_taxonomy_' . $table; 
            elseif( $single_name == 'object' ) :
                $table_name = $wpdb->prefix . 'oak_model_' . $table; 
            endif;
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
        
        wp_send_json_success();
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

        $forms_and_fields_table_name = $wpdb->prefix . 'oak_forms_and_fields';
        $forms_and_fields = $wpdb->get_results ( "
            SELECT * 
            FROM  $forms_and_fields_table_name
        " );

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

        $models_and_forms_table_name = $wpdb->prefix . 'oak_models_and_forms';
        $models_and_forms = $wpdb->get_results ( "
            SELECT * 
            FROM  $models_and_forms_table_name
        " );
        
        $all_objects = [];
        foreach( $models_without_redundancy as $model ) :
            $model_table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
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

        $goodpractices_table_name = $wpdb->prefix . 'oak_goodpractices';
        $goodpractices = $wpdb->get_results ( "
            SELECT * 
            FROM  $goodpractices_table_name
        " );
        $reversed_goodpractices = array_reverse( $goodpractices );
        $goodpractices_without_redundancy = [];
        foreach( $reversed_goodpractices as $goodpractice ) :
            $added = false;
            foreach( $goodpractices_without_redundancy as $goodpractice_without_redundancy ) :
                if ( $goodpractice_without_redundancy->goodpractice_identifier == $goodpractice->goodpractice_identifier ) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $goodpractices_without_redundancy[] = $goodpractice;
            endif;
        endforeach;

        $performances_table_name = $wpdb->prefix . 'oak_performances';
        $performances = $wpdb->get_results ( "
            SELECT * 
            FROM  $performances_table_name
        " );
        $reversed_performances = array_reverse( $performances );
        $performances_without_redundancy = [];
        foreach( $reversed_performances as $performance ) :
            $added = false;
            foreach( $performances_without_redundancy as $performance_without_redundancy ) :
                if ( $performance_without_redundancy->performance_identifier == $performance->performance_identifier ) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $performances_without_redundancy[] = $performance;
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
            'formsAndFields' => $forms_and_fields,
            'models' => $models,
            'modelsWihoutRedundancy' => $models_without_redundancy,
            'modelsAndForms' => $models_and_forms,
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
            'goodpractices' => $goodpractices,
            'goodpracticesWithoutRedundancy' => $goodpractices_without_redundancy,
            'performances' => $performances,
            'performancesWithoutRedundancy' => $performances_without_redundancy,
            'glossaries' => $glossaries,
            'glossariesWithoutRedundancy' => $glossaries_without_redundancy,
            'termsAndObjects' => $terms_and_objects
        ) );
    }

    function corn_simple_register_element( $element, $table_name ) {
        global $wpdb;

        foreach( $element as $key => $value ) :
            $element[ $key ] = $this->oak_filter_word( $value );
        endforeach;

        $result = $wpdb->insert(
            $table_name, 
            $element
        );
    }

    function corn_save_element( $elements, $table_name ) {
        global $wpdb;
        
        if ( isset( $table_name ) ) :
            $columns = $wpdb->get_results( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'" );
            $columns_names = [];
            foreach( $columns as $column ) :
                if ( $column->COLUMN_NAME != 'id' )
                    $columns_names[] = $column->COLUMN_NAME;
            endforeach;
        endif;

        foreach ( $elements as $element ) :
            $new_table_name = '';
            if ( !isset( $table_name ) ) :
                if ( isset( $element['term_taxonomy_identifier'] ) ) :
                    $new_table_name = $wpdb->prefix . 'oak_taxonomy_' . $element['term_taxonomy_identifier'];
                elseif ( isset( $element['model'] ) ) :
                    $new_table_name = $wpdb->prefix . 'oak_model_' . $element['model'];
                endif;

                $columns = $wpdb->get_results( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$new_table_name'" );
                $columns_names = [];
                foreach( $columns as $column ) :
                    if ( $column->COLUMN_NAME != 'id' )
                        $columns_names[] = $column->COLUMN_NAME;
                endforeach;
            else :
                $new_table_name = $table_name;
            endif;

            foreach( $element as $key => $value ) :
                // check if the key is included in the model: 
                if ( !in_array( $key, $columns_names ) ) :
                    unset( $element[ $key ] );
                endif;
            endforeach;
            

            $this->corn_simple_register_element( $element, $new_table_name );
        endforeach;
    }

    function delete_everything() {
        global $wpdb;
        $tables = [ Oak::$fields_table_name, Oak::$forms_table_name, Oak::$models_table_name, Oak::$taxonomies_table_name
            , Oak::$organizations_table_name, Oak::$publications_table_name, Oak::$glossaries_table_name, Oak::$qualis_table_name
            , Oak::$quantis_table_name, Oak::$forms_and_fields_table_name, Oak::$models_and_forms_table_name, Oak::$terms_and_objects_table_name
        ];

        // Lets get the taxonomies (because delete_everything is called before tables.php) :
        $taxonomies_table_name = Oak::$taxonomies_table_name;
        Oak::$taxonomies = $wpdb->get_results ( "
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
        Oak::$taxonomies_without_redundancy = $taxonomies_without_redundancy;

        // Now lets get the models :
        $models_table_name = Oak::$models_table_name;
        Oak::$models = $wpdb->get_results ( "
            SELECT * 
            FROM  $models_table_name
        " );
        $reversed_models = array_reverse( Oak::$models );
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
        Oak::$models_without_redundancy = $models_without_redundancy;
                

        // Now lets delete the tables related to the taxonomies we found:
        foreach( Oak::$taxonomies_without_redundancy as $taxonomy ) :
            $table_name_to_delete = $wpdb->prefix . 'oak_taxonomy_' . $taxonomy->taxonomy_identifier;
            $wpdb->query( "DROP TABLE IF EXISTS $table_name_to_delete" );
        endforeach;

        // And the tables related to the models we found:
        foreach( Oak::$models_without_redundancy as $model ) :
            $table_name_to_delete = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
            $wpdb->query( "DROP TABLE IF EXISTS $table_name_to_delete" );
        endforeach;

        foreach( $tables as $table ) :
            $delete = $wpdb->query("DELETE FROM $table");
        endforeach;
    }

    function corn_save_data() {
        // wp_send_json_success(  );

        global $wpdb; 

        $this->delete_everything();

        $selected_data = json_decode( stripslashes( $_POST['selectedData'] ), true );

        // wp_send_json_success( array( 'data' => $selected_data ) );

        $organizations = [];
        $organizations[] = $selected_data['organization'];
        $publications = $selected_data['publications'];
        $frame_publications = $selected_data['framePublications'];
        $fields = $selected_data['fields'];
        $forms = $selected_data['forms'];
        $models = $selected_data['models'];
        $taxonomies = $selected_data['taxonomies'];
        $objects = $selected_data['objects'];
        $terms = $selected_data['terms'];
        $glossaries = $selected_data['glossaries'];
        $qualis = $selected_data['qualis'];
        $quantis = $selected_data['quantis'];
        $goodpractices = $selected_data['goodpractices'];
        $performances = $selected_data['performances'];
        $terms_and_objects = $selected_data['termsAndObjects'];
        $models_and_forms = $selected_data['modelsAndForms'];
        $forms_and_fields = $selected_data['formsAndFields'];

        $this->corn_save_element( $organizations, Oak::$organizations_table_name );
        $this->corn_save_element( $publications, Oak::$publications_table_name );
        $this->corn_save_element( $frame_publications, Oak::$publications_table_name );
        $this->corn_save_element( $fields, Oak::$fields_table_name );
        $this->corn_save_element( $forms, Oak::$forms_table_name );
        $this->corn_save_element( $models, Oak::$models_table_name );
        $this->corn_save_element( $taxonomies, Oak::$taxonomies_table_name );
        $this->corn_save_element( $glossaries, Oak::$glossaries_table_name );
        $this->corn_save_element( $qualis, Oak::$qualis_table_name );
        $this->corn_save_element( $quantis, Oak::$quantis_table_name );
        $this->corn_save_element( $goodpractices, Oak::$goodpractices_table_name );
        $this->corn_save_element( $performances, Oak::$performances_table_name );
        $this->corn_save_element( $terms_and_objects, Oak::$terms_and_objects_table_name );
        
        $this->corn_save_element( $forms_and_fields, Oak::$forms_and_fields_table_name );
        $this->corn_save_element( $models_and_forms, Oak::$models_and_forms_table_name );

        // Creating the tables for models
        foreach( $models as $model ) :
            
            $model_fields = [];
            $number_of_fields = 0;
            foreach( $models_and_forms as $model_and_form_instance ) :
                if ( $model_and_form_instance['model_identifier'] == $model['model_identifier'] 
                    && $model_and_form_instance['model_revision_number'] == $model['model_revision_number'] 
                ) :
                    $form_identifier = $model_and_form_instance['form_identifier'];
                    foreach( $forms as $form ) :
                        if ( $form['form_identifier'] == $form_identifier ) :
                            foreach ( $forms_and_fields as $form_and_field_instance ) :
                                if ( $form_and_field_instance['form_identifier'] == $form['form_identifier'] 
                                    && $form_and_field_instance['form_revision_number'] == $form['form_revision_number'] 
                                ) :

                                    $number_of_fields++;
                                    foreach( $fields as $field ) :
                                        if ( $field['field_identifier'] == $form_and_field_instance['field_identifier'] ) :
                                            $field_copy = $field;
                                            $field_copy['form_and_field_properties'] = $form_and_field_instance;
                                            array_push( $model_fields, $field_copy );
                                        endif;
                                    endforeach;
                                endif;
                            endforeach;
                        endif;
                    endforeach;
                endif;
            endforeach;

            $table_name = $wpdb->prefix . 'oak_model_' . $model['model_identifier'];
            $models_sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                object_designation varchar(555) DEFAULT '' NOT NULL,
                object_identifier varchar(555) DEFAULT '' NOT NULL,
                object_selector varchar(555),
                object_locked varchar(555),
                object_trashed varchar(555),
                object_state varchar(555),
                object_modification_time datetime,
                object_selectors varchar(999),
                object_form_selectors varchar(999),
                PRIMARY KEY (id)
            ) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $models_sql );

            foreach( $model_fields as $key => $field ) :
                $column_name = 'object_' . $key . '_' . $field['field_identifier'];
                $columns = $wpdb->get_results( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'" );
                $exists = false;
                foreach( $columns as $column ) :
                    if ( $column->COLUMN_NAME == $column_name ) :
                        $exists = true;
                    endif;
                endforeach;
                
                if ( !$exists ) {
                    if ( $field->field_type == 'Zone de Texte' ) :
                        $wpdb->query("ALTER TABLE $table_name ADD $column_name LONGTEXT");
                    else :
                        $wpdb->query("ALTER TABLE $table_name ADD $column_name TEXT");
                    endif;
                    // $wpdb->query("ALTER TABLE $table_name ADD $column_name varchar(555)");
                }
            endforeach;
        endforeach;

        // Lets now add the objects 

        $this->corn_save_element( $objects );

        // // Creating the tables for taxonomies
        foreach( $taxonomies as $taxonomy ) :
            $table_name = $wpdb->prefix . 'oak_taxonomy_' . $taxonomy['taxonomy_identifier'];
            $terms_sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                term_designation varchar(555) DEFAULT '' NOT NULL,
                term_identifier varchar(555) DEFAULT '' NOT NULL,
                term_selector varchar(555),
                term_locked varchar(555),
                term_trashed varchar(555),
                term_state varchar(555),
                term_modification_time datetime,
                term_numerotation varchar(555),
                term_title varchar(555),
                term_description varchar(555),
                term_color varchar(555),
                term_logo varchar(555),
                term_order varchar(555),
                term_parent varchar(555),
                PRIMARY KEY (id)
            ) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $terms_sql );
        endforeach;

        $this->corn_save_element( $terms );

        wp_send_json_success( array(
            'functionReturn' => $this->corn_save_element( $fields, Oak::$fields_table_name ),
            'return' => $this->corn_save_element( $organizations, Oak::$organizations_table_name ),
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

