<?php

class Oak {
    public static $charset_collate; 

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
    public static $graphs_table_name;
    public static $sources_table_name;

    public static $revisions;

    public static $fields;
    public static $fields_without_redundancy;
    public static $field_properties;
    public static $field_first_property;
    public static $field_second_property;
    public static $field_third_property;

    public static $forms;
    public static $forms_without_redundancy;
    public static $forms_attributes;
    public static $form_properties;
    public static $all_forms_and_fields = [];
    public static $form_first_property;
    public static $form_second_property;
    public static $form_third_property;

    public static $objects;
    public static $objects_without_redundancy = [];
    public static $all_objects;
    public static $all_objects_without_redundancy = [];
    public static $object_first_property;
    public static $object_second_property;
    public static $object_third_property;

    public static $terms;
    public static $terms_without_redundancy = [];
    public static $all_terms;
    public static $all_terms_without_redundancy = [];
    public static $term_first_property;
    public static $term_second_property;
    public static $term_third_property;

    public static $terms_and_objects = [];

    public static $models;
    public static $models_without_redundancy = [];
    public static $model_properties;
    public static $model_other_elements;
    public static $all_models_and_forms = [];
    public static $current_model_fields = [];
    public static $object_properties = [];
    public static $term_properties = [];
    public static $model_first_property;
    public static $model_second_property;
    public static $model_third_property;

    public static $organizations;
    public static $organizations_without_redundancy;
    public static $organization_properties;
    public static $organization_first_property;
    public static $organization_second_property;
    public static $organization_third_property;

    public static $publications;
    public static $publications_without_redundancy;
    public static $publication_properties;
    public static $publication_first_property;
    public static $publication_second_property;
    public static $publication_third_property;

    public static $glossaries;
    public static $glossaries_without_redundancy;
    public static $glossary_properties;
    public static $glossary_first_property;
    public static $glossary_second_property;
    public static $glossary_third_property;

    public static $qualis;
    public static $qualis_without_redundancy;
    public static $quali_properties;
    public static $quali_first_property;
    public static $quali_second_property;
    public static $quali_third_property;

    public static $quantis;
    public static $quantis_without_redundancy;
    public static $quanti_properties;
    public static $quanti_first_property;
    public static $quanti_second_property;
    public static $quanti_third_property;

    public static $goodpractices;
    public static $goodpractices_without_redundancy;
    public static $goodpractice_properties;
    public static $goodpractice_first_property;
    public static $goodpractice_second_property;
    public static $goodpractice_third_property;

    public static $sources;
    public static $sources_without_redundancy;
    public static $source_properties;

    public static $performances;
    public static $performances_without_redundancy;
    public static $performance_properties;
    public static $performance_first_property;
    public static $performance_second_property;
    public static $performance_third_property;

    public static $taxonomies;
    public static $taxonomies_without_redundancy = [];
    public static $taxonomy_properties;
    public static $taxonomy_first_property;
    public static $taxonomy_second_property;
    public static $taxonomy_third_property;

    public static $frame_publications_identifiers = [];
    public static $frame_terms_identifiers = [];
    public static $all_frame_objects_without_redundancy = [];

    public static $term_objects_without_redundancy = [];

    public static $main_color = '#003366';
    public static $secondary_text_color = '#bcc7d9';
    public static $selected_color = '#7b7b7b';

    public static $site_language;

    // Properties initialization
    public static $social_medias;
    public static $publications_array = [];
    public static $frame_publications_array = [];
    public static $organizations_array = [];
    public static $glossaries_array = [];
    public static $quantis_and_qualis = [];
    public static $qualis_array = [];
    public static $quantis_array = [];
    public static $terms_array = [];
    public static $objects_array = [];
    public static $sources_array = [];
    public static $countries = [];
    public static $countries_names = [];
    public static $languages = [];
    public static $languages_names = [];
    public static $years = [];
    public static $business_line = [];
    public static $custom_perimeter = [];
    public static $regions = [];
    public static $all_images = [];

    function __construct() {
        global $wpdb;

        var_dump( get_option('oak_indexes') );

        Oak::$text_domain = 'oak';
        Oak::$charset_collate = $wpdb->get_charset_collate();

        include( get_template_directory() . '/functions/elements_to_show_properties.php' );

        Oak::$revisions = [];

        include get_template_directory() . '/functions/tables/constants/table-names.php';

        Oak::$forms_attributes = [];
        Oak::$all_objects = [];
        Oak::$all_terms = [];
        Oak::$all_terms_without_redundancy = [];

        // $this->delete_everything();

        Oak::$site_language = substr( get_locale(), 0, 2 );

        add_action( 'wp_enqueue_scripts', array( $this, 'oak_enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'oak_enqueue_scripts' ) );

        add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'oak_enqueue_styles' ) );
        add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'oak_elementor_editor_enqueue_scripts' ) );
        

        add_action( 'admin_enqueue_scripts', array( $this, 'oak_admin_enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'oak_admin_enqueue_scripts' ) );

        add_action( 'add_meta_boxes', array ( $this, 'oak_add_meta_box_to_posts' ) );

        add_action( 'init', array( $this, 'add_cors_http_header' ) );

        add_action( 'after_setup_theme', array( $this, 'oak_add_theme_support' ) );
        add_action( 'after_setup_theme', array( $this, 'oak_translation_setup' ) );

        add_action( 'widgets_init', array( $this, 'oak_widgets_init' ) );        

        add_action( 'admin_head', array ( $this, 'oak_wordpress_dashboard' ) );

        $this->oak_elementor_initialization();

        add_action( 'admin_menu', array( $this, 'oak_handle_admin_menu' ) );

        add_action( 'save_post', array ( $this, 'oak_save_post_meta_fields' ) );

        $this->oak_ajax_calls();

        $this->oak_contact_form();

        add_action('wp_dashboard_setup', array( $this, 'oak_dashboard' ) );
    }

    function oak_ajax_calls() {
        add_action('wp_ajax_oak_save_configuration', array( $this, 'oak_save_configuration') );
        add_action('wp_ajax_nopriv_oak_save_configuration', array( $this, 'oak_save_configuration') );

        add_action('wp_ajax_oak_corn_save_general_configuration', array( $this, 'oak_corn_save_general_configuration') );
        add_action('wp_ajax_nopriv_oak_corn_save_general_configuration', array( $this, 'oak_corn_save_general_configuration') );

        add_action('wp_ajax_oak_corn_save_social_media_configuration', array( $this, 'oak_corn_save_social_media_configuration') );
        add_action('wp_ajax_nopriv_oak_corn_save_social_media_configuration', array( $this, 'oak_corn_save_social_media_configuration') );

        add_action('wp_ajax_oak_corn_save_app_bar_settings', array( $this, 'oak_corn_save_app_bar_settings') );
        add_action('wp_ajax_nopriv_oak_corn_save_app_bar_settings', array( $this, 'oak_corn_save_app_bar_settings') );

        add_action('wp_ajax_oak_corn_save_styles_settings', array( $this, 'oak_corn_save_styles_settings') );
        add_action('wp_ajax_nopriv_oak_corn_save_styles_settings', array( $this, 'oak_corn_save_styles_settings') );

        add_action('wp_ajax_oak_corn_save_nav_bar_settings', array( $this, 'oak_corn_save_nav_bar_settings') );
        add_action('wp_ajax_nopriv_oak_corn_save_nav_bar_settings', array( $this, 'oak_corn_save_nav_bar_settings') );

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

        add_action('wp_ajax_oak_save_graph', array( $this, 'oak_save_graph') );
        add_action('wp_ajax_nopriv_oak_save_graph', array( $this, 'oak_save_graph') );

        add_action('wp_ajax_oak_regenerate_indexes', array( $this, 'oak_regenerate_indexes') );
        add_action('wp_ajax_nopriv_oak_regenerate_indexes', array( $this, 'oak_regenerate_indexes') );
    }

    function oak_enqueue_styles() {
        wp_enqueue_style( 'oak_the_style', get_stylesheet_directory_uri() . '/style.css' );
        wp_enqueue_style( 'oak_global', get_template_directory_uri() . '/src/css/global.css' );
        wp_enqueue_style( 'oak_front_global', get_template_directory_uri() . '/src/css/front/global.css' );
        wp_enqueue_style( 'oak_front_elementor_editor', get_template_directory_uri() . '/src/css/front/elementor-editor.css' );
    }

    function oak_enqueue_scripts() {
        wp_enqueue_script( 'oak_charts', get_template_directory_uri() . '/src/js/vendor/chart.bundle.min.js', array(), false, true);
        $this->oak_elementor_editor_enqueue_scripts();
    }

    function oak_elementor_editor_enqueue_scripts() {
        wp_enqueue_media();

        if ( strpos( get_page_template(), "critical-analysis" ) != false ) :
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

        wp_enqueue_script( 'oak_front_graphs', get_template_directory_uri() . '/src/js/front/graphs.js', array('jquery'), false, true );
        wp_enqueue_script( 'oak_front_sidebar', get_template_directory_uri() . '/src/js/front/sidebar.js', array('jquery'), false, true );
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

        if ( get_current_screen()->id == 'post' || get_current_screen()->id == 'page' ) :
            wp_enqueue_script( 'oak_edit_post', get_template_directory_uri() . '/src/js/edit-post.js', array('jquery'), false, true );
        endif;

        // Admin menu
        wp_enqueue_script( 'admin_menu_script', get_template_directory_uri() . '/src/js/admin-menu.js', array('jquery'), false, true );
        wp_localize_script( 'admin_menu_script', 'DATA', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'siteLanguage' => Oak::$site_language
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

        // For the corn configuration page
        if ( get_current_screen()->id == 'toplevel_page_oak_corn_configuration_page' ) :
            wp_enqueue_script( 'oak_corn_configuration_page', get_template_directory_uri() . '/src/js/corn-configuration-page.js', array( 'jquery', 'wp-color-picker' ), false, true);
            wp_localize_script( 'oak_corn_configuration_page', 'DATA', array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'socialMedias' => Oak::$social_medias,
                'oakColors' => get_option( 'oak_colors' ) != false ? get_option( 'oak_colors' ) : [],
                'oakNavBarData' => get_option( 'oak_nav_bar_data' ) != false ? get_option( 'oak_nav_bar_data' ) : [],
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
                $properties = array_merge( $properties, Fields::$properties );
                $filters = Fields::$filters;
            endif;
            if ( $_GET['elements'] == 'forms' ) :
                $table = 'form';
                $table_in_plural = 'forms';
                $elements = Oak::$forms;
                $additional_data_to_pass = array(
                    'otherElementProperties' => Forms::$other_elements,
                    'attributes' => Oak::$forms_attributes
                );
                $properties = array_merge( $properties, Forms::$properties );
                $properties[] = array( 'name' => 'revision_number', 'type' => 'text', 'input_type' => 'checkbox' );
                $filters = Forms::$filters;
            endif;
            if ( $_GET['elements'] == 'models' ) :
                $table = 'model';
                $table_in_plural = 'models';
                $elements = Oak::$models;
                $additional_data_to_pass = array(
                    'fields' => Oak::$fields,
                    'formsAndFields' => Oak::$all_forms_and_fields,
                    'otherElementProperties' => Models::$other_elements,
                    'attributes' => Forms::$attributes
                );
                $properties = array_merge( $properties, Models::$properties );
                $properties[] = array( 'name' => 'revision_number', 'type' => 'text', 'input_type' => 'checkbox' );
                $filters = Models::$filters;
            endif;
            if ( $_GET['elements'] == 'taxonomies' ) :
                $table = 'taxonomy';
                $table_in_plural = 'taxonomies';
                $elements = Oak::$taxonomies;
                $properties = array_merge( $properties, Taxonomies::$properties );
                $filters = Taxonomies::$filters;
            endif;
            if ( $_GET['elements'] == 'organizations' ) :
                $table = 'organization';
                $table_in_plural = 'organizations';
                $elements = Oak::$organizations;
                $properties = array_merge( $properties, Organizations::$properties );
                $filters = Organizations::$filters;
            endif;
            if ( $_GET['elements'] == 'publications' ) :
                $table = 'publication';
                $table_in_plural = 'publications';
                $elements = Oak::$publications;
                $properties = array_merge( $properties, Publications::$properties );
                $filters = Publications::$filters;
            endif;
            if ( $_GET['elements'] == 'glossaries' ) :
                $table = 'glossary';
                $table_in_plural = 'glossaries';
                $elements = Oak::$glossaries;
                $properties = array_merge( $properties, Glossaries::$properties );
                $filters = Glossaries::$filters;
            endif;
            if ( $_GET['elements'] == 'qualis' ) :
                $table = 'quali';
                $table_in_plural = 'qualis';
                $elements = Oak::$qualis;
                $properties = array_merge( $properties, Qualis::$properties );
                $filters = Qualis::$filters;
            endif;
            if ( $_GET['elements'] == 'quantis' ) :
                $table = 'quanti';
                $table_in_plural = 'quantis';
                $elements = Oak::$quantis;
                $properties = array_merge( $properties, Quantis::$properties );
                $filters = Quantis::$filters;
            endif;
            if ( $_GET['elements'] == 'goodpractices' ) :
                $table = 'goodpractice';
                $table_in_plural = 'goodpractices';
                $elements = Oak::$goodpractices;
                $properties = array_merge( $properties, Good_Practices::$properties );
                $filters = Good_Practices::$filters;
            endif;
            
            if ( $_GET['elements'] == 'performances' ) :
                $table = 'performance';
                $table_in_plural = 'performances';
                $elements = Oak::$performances;
                $properties = array_merge( $properties, Performances::$properties );
                $filters = Performances::$filters;
            endif;
            if ( $_GET['elements'] == 'sources' ) :
                $table = 'source';
                $table_in_plural = 'sources';
                $elements = Oak::$sources;
                $properties = array_merge( $properties, Sources::$properties );
                $filters = Sources::$filters;
            endif;
            if ( $_GET['elements'] == 'objects' ) :
                $table = 'object';
                $table_in_plural = $_GET['model_identifier'];

                $elements = Oak::$objects;
                foreach( $elements as $object ) :
                    $object->object_model_identifier = $_GET['model_identifier'];
                endforeach;

                foreach( Oak::$current_model_fields as $key => $field ) :
                    $input_type = $field->field_type;

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
                        'form' => $field->form,
                        'translatable' => true
                    );
                endforeach;

                $properties = array_merge( $properties, Oak::$object_properties );
                $filters = Objects::$filters;
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

                $properties = array_merge( $properties, Terms::$properties );
                $filters = Terms::$filters;
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
                'termIdentifier' => isset ( $_GET['term_identifier'] ) ? $_GET['term_identifier'] : '',
                'siteLanguage' => Oak::$site_language,
                'filters' => $filters,
                'termsAndObjects' => Oak::$terms_and_objects,
                
                'addingElementMessage' => __( 'Êtes vous sur de vouloir ajouter cet element?', Oak::$text_domain ),
                'modifyingElementMessage' => __( 'Êtes vous sûr de vouloir modifier cet element?', Oak::$text_domain ),
                'addingToRegisteredElementsListMessage' => __( 'Êtes vous sûr de vouloir ajouter cet element à la liste des elements enregistrés?', Oak::$text_domain ),
                'enterDesignationFirstMessage' => __( 'Veuillez entrer la désignation d\'abord', Oak::$text_domain ),
                'modifyAndDiffuseMessage' => __( 'Êtes vous sûr de vouloir modifier et diffuser cet element ?', Oak::$text_domain ),
                'sendToDraftMessage' => __( 'Êtes vous sûr de vouloir modifier et renvoyer ce champ à l\'état de Brouillon ?', Oak::$text_domain ),
                'revisionsListMessage' => __( 'Liste des révisions', Oak::$text_domain ),

                'restoringSelectedElementsMessage' => __( 'Êtes vous sûr de vouloir restaurer les élements sélectionnés ?', Oak::$text_domain ),
                'choosingModelMessage' => __( 'Veuillez choisir le modèle ?', Oak::$text_domain ),
            );

            $final_data_to_pass = array_merge( $basic_data_to_pass, $additional_data_to_pass );

            if ( $_GET['listorformula'] == 'formula' ) :
                wp_enqueue_script( 'corn_add_element', get_template_directory_uri() . '/src/js/add-element.js', array( 'jquery', 'wp-color-picker' ), false, true );
                wp_localize_script( 'corn_add_element', 'DATA', $final_data_to_pass );
            endif;

            if ( $_GET['listorformula'] == 'list' ) :
                wp_enqueue_script( 'corn_elements_list', get_template_directory_uri() . '/src/js/elements-list.js', array('jquery'), false, true );
                wp_enqueue_script( 'oak_infinite_scroll', get_template_directory_uri() . '/src/js/vendor/infinite-scroll.js', array(), false, true );
                wp_localize_script( 'corn_elements_list', 'DATA', $final_data_to_pass );
            endif;
        endif;
    }

    function oak_widgets_init() {
        $side_bars = array ( 
            array ( 'name' => __( 'Sidebar CSR', Oak::$text_domain ), 'id' => 'csr_sidebar' ),
            array ( 'name' => __( 'Sidebar 1', Oak::$text_domain ), 'id' => 'sidebar_1' ),
            array ( 'name' => __( 'Sidebar 2', Oak::$text_domain ), 'id' => 'sidebar_2' ),
            array ( 'name' => __( 'Sidebar 3', Oak::$text_domain ), 'id' => 'sidebar_3' ),
            array ( 'name' => __( 'Sidebar 4', Oak::$text_domain ), 'id' => 'sidebar_4' ),
            array ( 'name' => __( 'Sidebar 5', Oak::$text_domain ), 'id' => 'sidebar_5' ),
        );

        foreach( $side_bars as $side_bar ) :
            register_sidebar( $side_bar );
        endforeach;
    }

    function oak_add_meta_box_to_posts() {
        // $this->oak_add_meta_data();

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

    static function oak_add_meta_data() {
        $the_returned_fields = [];

        global $wpdb;

        $selected_objects = get_post_meta( get_the_ID(), 'objects_selector' ) ? get_post_meta( get_the_ID(), 'objects_selector' ) [0] : [];

        $our_objects = [];

        foreach( Oak::$models_without_redundancy as $model ) :
            $table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
            // Lets get the model fields

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
                        $object->object_model = $model;
                        $our_objects[] = $object;
                    endif;
                endif;
            endforeach;
        endforeach;

        return $the_returned_fields;
    }

    function oak_add_meta_box_to_posts_view( $post, $args ) {
        $selected_elements = get_post_meta( get_the_ID(), $args['id'] ) ? get_post_meta( get_the_ID(), $args['id'] ) [0] : [];
        $elements = $args['args']['elements'];
        ?>
        <div class="oak_post_elements_selector__container">
            <div class="oak_post_elements_selector_container__select_container">
                <input type="text" placeholder="<?php _e( 'Rechercher', Oak::$text_domain ); ?>" class="oak_post_search_input">
                <select multiple name="<?php echo( $args['args']['select_name'] ); ?>" class="oak_post_selector oak_post_elements_selector" size="<?php echo( count( $elements ) ); ?>">
                    <?php
                    $identifier_property = $args['args']['element'] . '_identifier';
                    $designation_property = $args['args']['element'] . '_designation';
                    foreach( $elements as $element ) :
                        $selected = '';
                        foreach( $selected_elements as $selected_element_identifier ) :
                            if ( $selected_element_identifier == $element->$identifier_property ) :
                                $selected = 'selected';
                            endif;
                        endforeach;
                        ?>
                        <option <?php echo( $selected ); ?> value="<?php echo( $element->$identifier_property ); ?>"><?php echo( $element->$designation_property ); ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="oak_post_elements_selector__selected_elements">
                <div class="oak_post_elements_selector_selected_elements__single_element">
                    <h3 class="oak_post_elements_selector_selected_elements_single_element__element_name">Element Name</h3>
                    <i class="fas fa-times oak_post_elements_selector_selected_elements_single_element_element_remove_button"></i>
                </div>
            </div>
        </div>

        <?php
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

        $old_goodpractices = get_post_meta( $post_id, 'sources_selector', true );
        if ( isset( $_POST['sources_selector'] ) ) :
            $new_goodpractices = $_POST['sources_selector'];

            if ( $new_goodpractices && $new_goodpractices !== $old_goodpractices ) {
                update_post_meta( $post_id, 'sources_selector', $new_goodpractices );
            } elseif ( '' === $new_goodpractices && $old_goodpractices ) {
                delete_post_meta( $post_id, 'sources_selector', $old_goodpractices );
            };
        else :
            delete_post_meta( $post_id, 'sources_selector', $old_goodpractices );
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


    function oak_add_theme_support() {
        add_theme_support( 'post-thumbnails' ); 
        add_theme_support('menus');
        add_theme_support( 'custom-logo', array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array( 'site-title', 'site-description' ),
        ) );

        include get_template_directory() . '/functions/tables.php';
        include get_template_directory() . '/functions/properties-initialization.php';
        // include get_template_directory() . '/functions/auto-index.gen.php';
    }

    function oak_translation_setup() {
        load_theme_textdomain( Oak::$text_domain, get_template_directory() . '/languages' );
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

            \Elementor\Plugin::$instance->dynamic_tags->register_group( 'oak_indexes', [
                'title' => __( 'Oak Indexes', Oak::$text_domain )
            ] );
            
            include_once get_template_directory() . '/functions/elementor/dynamic_tag.php';
            include_once get_template_directory() . '/functions/elementor/dynamic_index_tag.php';

            $tag = new Dynamic_Tag();
            $dynamic_tags->register_tag( 'Dynamic_Tag' );

            $indexes_tag = new Dynamic_Index_Tag();
            $dynamic_tags->register_tag( 'Dynamic_Index_Tag' );
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

            $elements_manager->add_category(
                'oak_charts',
                [
                    'title' => __( 'OAK CHARTS', Oak::$text_domain ),
                    'icon' => 'fa fa-plug',
                ]
            );
        } );
    }

    function oak_add_widgets() {
        add_action('elementor/widgets/widgets_registered', function( $widgets_manager ) {

            include_once get_template_directory() . '/functions/elementor/generic_widget.php';

            $this->oak_add_side_bar_widgets( $widgets_manager );

            global $wpdb;

            $selected_objects = get_post_meta( get_the_ID(), 'objects_selector' ) ? get_post_meta( get_the_ID(), 'objects_selector' ) [0] : [];
            $selected_goodpractices = get_post_meta( get_the_ID(), 'good_practices_selector' ) ? get_post_meta( get_the_ID(), 'good_practices_selector' ) [0] : [];
            $selected_sources = get_post_meta( get_the_ID(), 'sources_selector' ) ? get_post_meta( get_the_ID(), 'sources_selector' ) [0] : [];
            $selected_quantis = get_post_meta( get_the_ID(), 'quantis_selector' ) ? get_post_meta( get_the_ID(), 'quantis_selector' ) [0] : [];
            $selected_qualis = get_post_meta( get_the_ID(), 'qualis_selector' ) ? get_post_meta( get_the_ID(), 'qualis_selector' ) [0] : [];

            $our_objects = Oak::oak_get_selected_objects_data( $selected_objects, true );
            $the_returned_fields = [];

            Sidebar_Widget::$post_selected_objects[] = $our_objects;

            $metas = get_post_meta( get_the_ID() );
            foreach( $metas as $key => $meta ) :
                if ( strpos( $key, 'Oak:' ) !== false ) :
                    delete_post_meta( get_the_ID(), $key );
                endif;
            endforeach;
            
            foreach( $our_objects as $index => $object ) :
                $widget_options = array(
                    'name' => 'object_' . $index . '_designation',
                    'title' => __( 'Designation Objet ' . $index . ' ', Oak::$text_domain ),
                    'icon' => 'eicon-type-tool',
                    'categories' => [ 'oak' ],
                    'value' => $object->object_designation,
                    'field_type' => 'text',
                );

                $object_number = $index + 1;
                update_post_meta( get_the_ID(), 'Oak: Designation Objet ' . $object_number, $object->object_designation );
                $generic_widget = new Generic_Widget();
                $generic_widget->set_widgets_options( $widget_options );
                $widgets_manager->register_widget_type( $generic_widget );

                $object_model_field_names_array = explode( '|', $object->object_model_fields_names );
                foreach( $object->object_model_fields as $key => $object_model_field ) :
                    $field_number = $key + 1;
                    $column_name = 'object_' . $key . '_' . $object_model_field->field_identifier;
                    $value = $object->$column_name;
                    $widget_options = array (
                        'name' => preg_replace( '/\s+/', '', count( $the_returned_fields ) . $object_model_field_names_array[ $key ] ),
                        'title' => $object_model_field_names_array[ $key ],
                        'icon' => $object_model_field->field_type == 'Image' ? 'eicon-image' : 'eicon-type-tool',
                        'categories' => [ 'oak' ],
                        'value' => $value,
                        'field_type' => $object_model_field->field_type,
                    );
                    $the_returned_fields [] = array(
                        'field_designation' => count( $the_returned_fields ) . ' ' . $object_model_field_names_array[ $key ],
                        'value' => $value,
                        'field_type' => $object_model_field->field_type
                    );

                    update_post_meta( get_the_ID(), 'Oak: ' . count( $the_returned_fields ) . ' ' . $object_model_field_names_array[ $key ], $value );
                    $generic_widget = new Generic_Widget();
                    $generic_widget->set_widgets_options( $widget_options );
                    $widgets_manager->register_widget_type( $generic_widget );
                endforeach;
            endforeach;

            $post_images_to_show = array();
            update_option( 'oak_post_images_to_show', array() );

            // For the good practices: 
            $good_practice = __( 'Bonne Pratique', Oak::$text_domain );
            $good_practice_number = 1;
            foreach( $selected_goodpractices as $good_practice_key => $goodpractice_identifier ) :
                $incrementer = 0;
                $found_goodpractice = false;
                do {
                    if ( Oak::$goodpractices_without_redundancy[ $incrementer ]->goodpractice_identifier == $goodpractice_identifier) :
                        // For the designation: 
                        $the_goodpractice = Oak::$goodpractices_without_redundancy[ $incrementer ];
                        update_post_meta( get_the_ID(), 'Oak: ' . $good_practice . ' ' . $good_practice_number . ': Designation', $the_goodpractice->goodpractice_designation );
                        foreach( Good_Practices::$properties as $key => $goodpractice_property ) :
                            $property_name = $goodpractice_property['property_name'];
                            if ( $goodpractice_property['input_type'] != 'image' && $goodpractice_property['input_type'] != 'select' ) :
                                update_post_meta( get_the_ID(), 'Oak: ' . $good_practice . ' ' . $good_practice_number . ': ' . $goodpractice_property['description'], $the_goodpractice->$property_name );
                            elseif ( $goodpractice_property['input_type'] == 'image' ):
                                $image_id = attachment_url_to_postid( $the_goodpractice->$property_name );
                                $post_images_to_show[] = array ( 'url' => $the_goodpractice->$property_name, 'id' => $image_id, 'label' => 'Oak: ' . $good_practice . ' ' . $good_practice_number . ': ' .$goodpractice_property['description'] );
                                // Handle the images: We are gonna have to find the id of the image in the database for elementor to be able to handle it: 
                            endif;
                        endforeach;
                        $good_practice_number++;
                    endif;
                    $incrementer++;
                } while( $incrementer < count( Oak::$goodpractices_without_redundancy ) && !$found_goodpractice );
            endforeach;

            // For sources
            $source_number = 1;
            $source = __( 'Source', Oak::$text_domain );
            foreach( $selected_sources as $source_key => $selected_identifier ) :
                $incrementer = 0;
                $found_source = false;
                do {
                    if ( Oak::$sources_without_redundancy[ $incrementer ]->source_identifier == $selected_identifier) :
                        // For the designation: 
                        $the_source = Oak::$sources_without_redundancy[ $incrementer ];
                        update_post_meta( get_the_ID(), 'Oak: ' . $source . ' ' . $source_number . ': Designation', $the_source->source_designation );
                        foreach( Sources::$properties as $key => $source_property ) :
                            $property_name = $source_property['property_name'];
                            if ( $source_property['input_type'] != 'image' && $source_property['input_type'] != 'select' ) :
                                update_post_meta( get_the_ID(), 'Oak: ' . $source . ' ' . $source_number . ': ' . $source_property['description'], $the_source->$property_name );
                            elseif ( $source_property['input_type'] == 'image' ):
                                $image_id = attachment_url_to_postid( $the_source->$property_name );
                                $post_images_to_show[] = array ( 'url' => $the_source->$property_name, 'id' => $image_id, 'label' => 'Oak: ' . $source . ' ' . $source_number . ': ' .$source_property['description'] );
                                // Handle the images: We are gonna have to find the id of the image in the database for elementor to be able to handle it: 
                            endif;
                        endforeach;
                        $source_number++;
                    endif;
                    $incrementer++;
                } while( $incrementer < count( Oak::$sources_without_redundancy ) && !$found_source );
            endforeach;

            $performance_number = 1;
            foreach( $selected_quantis as $quanti_identifier ) :
                foreach( Oak::$performances_without_redundancy as $performance_key => $performance ) :
                    if ( $performance->performance_quantis == $quanti_identifier ) :
                        $performance_text = __( 'Donnée de performance', Oak::$text_domain );
                        update_post_meta( get_the_ID(), 'Oak: ' . $performance_text . ' ' . $performance_number . ': Designation', $performance->performance_designation );

                        $unity_type_text = __( 'Type de l’unité', Oak::$text_domain );
                        update_post_meta( get_the_ID(), 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $unity_type_text, $performance->performance_type );

                        foreach( Performances::$properties as $key => $performance_property ) :
                            $performance_results = explode( '|', $performance->performance_results );
                            foreach( $performance_results as $result_key => $result ) :
                                if ( $result != '' ) :
                                    $result_values = explode( ':', $result );
                                    $year = $result_values[0];
                                    $value = $result_values[1];

                                    update_post_meta( get_the_ID(), 'Oak: ' . $performance_text . ' ' . $performance_number . ': Année ' . $result_key, $year );
                                    update_post_meta( get_the_ID(), 'Oak: ' . $performance_text . ' ' . $performance_number . ': Résultalt ' . $year, $value );
                                endif;
                            endforeach;
                            $property_name = $performance_property['property_name'];
                            if ( $performance_property['input_type'] != 'image' && $performance_property['input_type'] != 'select' ) :
                                update_post_meta( get_the_ID(), 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance_property['description'], $performance->$property_name );
                            elseif ( $performance_property['input_type'] == 'image' ):
                                $image_id = attachment_url_to_postid( $performance->$property_name );
                                $post_images_to_show[] = array ( 'url' => $performance->$property_name, 'id' => $image_id, 'label' => 'Oak: ' . $performance . ' ' . $performance_number . ': ' .$performance_property['description'] );
                                // Handle the images: We are gonna have to find the id of the image in the database for elementor to be able to handle it: 
                            elseif( $performance_property['input_type'] == 'select' ) :
                                if ( isset( $performance_property['depends'] ) ) :
                                    if( $performance_property['depends'][0]['name'] = 'type' ) :
                                        if ( $performance_property['depends'][0]['values'][0] == $performance->performance_type ) :
                                            $value = '';
                                            foreach( $performance_property['choices'] as $choice ) :
                                                if ( $choice['value'] == $performance->$property_name ) :
                                                    $value = $choice['innerHTML'];
                                                endif;
                                            endforeach;
                                            update_post_meta( get_the_ID(), 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance_property['description'], $value );
                                        endif;
                                    endif;
                                endif;
                            endif;
                        endforeach;
                        $performance_number++;
                    endif;
                endforeach;
            endforeach;

            $quali_number = 1;
            $quali = __( 'Indicateur Qualitatif', Oak::$text_domain );
            foreach( $selected_qualis as $quali_key => $selected_identifier ) :
                $incrementer = 0;
                $found_quali = false;
                do {
                    if ( Oak::$qualis_without_redundancy[ $incrementer ]->quali_identifier == $selected_identifier) :
                        // For the designation: 
                        $the_quali = Oak::$qualis_without_redundancy[ $incrementer ];
                        update_post_meta( get_the_ID(), 'Oak: ' . $quali . ' ' . $quali_number . ': Designation', $the_quali->quali_designation );
                        foreach( Qualis::$properties as $key => $quali_property ) :
                            $property_name = $quali_property['property_name'];
                            if ( $quali_property['input_type'] != 'image' && $quali_property['input_type'] != 'select' ) :
                                update_post_meta( get_the_ID(), 'Oak: ' . $quali . ' ' . $quali_number . ': ' . $quali_property['description'], $the_quali->$property_name );
                            elseif ( $quali_property['input_type'] == 'image' ):
                                $image_id = attachment_url_to_postid( $the_quali->$property_name );
                                $post_images_to_show[] = array ( 'url' => $the_quali->$property_name, 'id' => $image_id, 'label' => 'Oak: ' . $quali . ' ' . $quali_number . ': ' .$quali_property['description'] );
                                // Handle the images: We are gonna have to find the id of the image in the database for elementor to be able to handle it: 
                            endif;
                        endforeach;
                        $quali_number++;
                    endif;
                    $incrementer++;
                } while( $incrementer < count( Oak::$qualis_without_redundancy ) && !$found_quali );
            endforeach;

            // var_dump($post_images_to_show);
            update_option( 'oak_post_images_to_show', $post_images_to_show );

            // For the images
            $images = array();
            $query_images_args = array(
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'post_status'    => 'inherit',
                'posts_per_page' => - 1,
            );
    
            $query_images = new WP_Query( $query_images_args );
            foreach ( $query_images->posts as $image ) {
                $images[] = array ( 'url' => wp_get_attachment_url( $image->ID ), 'id' => $image->ID );
            }
            // I pass the data to dynamic tags via the table options (Because there is an error of denied access if I happen to do this in the register controls function)
            update_option( 'oak_post_elementor_fields', $the_returned_fields );
            update_option( 'oak_all_images', $images );

            // For site parameters
            $social_media_data = get_option( 'oak_social_media_data' );
            if ( $social_media_data != false && is_array( $social_media_data ) ) :
                foreach( $social_media_data as $key => $social_media ) :
                    if ( $social_media['checked'] == 'true' ) :
                        $widget_options = array(
                            'name' => preg_replace( '/\s+/', '', Oak::$social_medias[ $key ]['name'] ),
                            'title' => Oak::$social_medias[ $key ]['title'],
                            'icon' => 'eicon-type-tool',
                            'categories' => [ 'theme-elements' ],
                            'value' => $social_media['value'],
                            'field_type' => 'social_media',
                        );
                        $generic_widget = new Generic_Widget();
                        $generic_widget->set_widgets_options( $widget_options );
                        $widgets_manager->register_widget_type( $generic_widget );
                    endif;
                endforeach;
            endif;

            // For the organization name:
            if ( get_option( 'oak_show_organization_name' ) == 'true' ) :
                $widget_options = array (
                    'name' => __( 'organization_name', Oak::$text_domain ),
                    'title' => __( 'Nom de l\'organisation', Oak::$text_domain ),
                    'icon' => 'eicon-type-tool',
                    'categories' => [ 'theme-elements' ],
                    'value' => get_option( 'oak_organization_name' ),
                    'field_type' => 'organization_name',
                );
                $generic_widget = new Generic_Widget();
                $generic_widget->set_widgets_options( $widget_options );
                $widgets_manager->register_widget_type( $generic_widget );
            endif;

            // To unregister the logo and site title widgets:
            if ( get_option( 'oak_show_logo' ) != 'true' ) :
                $widgets_manager->unregister_widget_type( 'theme-site-logo' );
            endif;

            if ( get_option( 'oak_show_site_title' ) != 'true' ) :
                $widgets_manager->unregister_widget_type( 'theme-site-title' );
            endif;

            // To create the graph widgets: 
            Graphs::create_widgets( $widgets_manager );

        }, 14);
    }
    
    static function oak_get_selected_objects_data( $selected_objects, $modify_current_model_fields ) {
        global $wpdb;
        
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
                        $model_fields = Models::get_model_fields( $model, $modify_current_model_fields );
                        $object->object_model_fields = $model_fields;

                        $object->object_model_fields_names = $model->model_fields_names;
                        $our_objects[] = $object;
                    endif;
                endif;
            endforeach;
        endforeach;

        return $our_objects;
    }

    function oak_add_side_bar_widgets( $widgets_manager ) {
        include_once get_template_directory() . '/functions/elementor/sidebar_widget.php';

        $sidebar_widget = new Sidebar_Widget();
        $widgets_manager->register_widget_type( $sidebar_widget );
    }

    function oak_get_all_images() {
        $query_images_args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => - 1,
        );

        $query_images = new WP_Query( $query_images_args );

        return $query_images;
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

    static function get_languages_codes() {
        if ( get_option('oak_languages_codes') ) :
            return get_option('oak_languages_codes');
        endif;

        $country_query_result = wp_remote_get( 'https://restcountries.eu/rest/v2/all' );
        $countries = json_decode( $country_query_result['body'] );
        $codes = [];
        $languages = [];
        foreach( $countries as $key => $country ) :
            foreach( $country->languages as $language ) :
                if ( !in_array( $language->name, $languages ) ) :
                    $languages[] = $language->name;
                    $codes[] = $language->iso639_1;
                endif;
            endforeach;
        endforeach;

        $languages_codes = array(
            'languages' => $languages,
            'codes' => $codes
        );

        update_option( 'oak_languages_codes', $languages_codes );

        return $languages_codes;
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

    public static function oak_get_all_wordpress_menus(){
        return get_terms( 'nav_menu', array( 'hide_empty' => true ) );
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

    function oak_add_element() {
        $revisions = Oak::$revisions;
        switch ( $_GET['elements'] ) :
            case 'fields':
                $properties = Fields::$properties;
                $table = 'field';
                $title = __( 'Ajouter un champ', Oak::$text_domain );
                $elements = Oak::$fields_without_redundancy;
            break;
            case 'forms':
                $properties = Forms::$properties;
                $table = 'form';
                $title = __( 'Nouveau formulaire', Oak::$text_domain );
                $elements = Oak::$forms_without_redundancy;
            break;
            case 'models':
                $properties = Models::$properties;
                $table = 'model';
                $title = __( 'Ajouter un modèle', Oak::$text_domain );
                $elements = Oak::$models_without_redundancy;
            break;
            case 'taxonomies':
                $properties = Taxonomies::$properties;
                $table = 'taxonomy';
                $title = __( 'Ajouter une taxonomie', Oak::$text_domain );
                $elements = Oak::$taxonomies_without_redundancy;
            break;
            case 'publications':
                $properties = Publications::$properties;
                $table = 'publication';
                $title = __( 'Ajouter une publication', Oak::$text_domain );
                $elements = Oak::$publications_without_redundancy;
            break;
            case 'organizations':
                $properties = Organizations::$properties;
                $table = 'organization';
                $title = __( 'Ajouter une organisation', Oak::$text_domain );
                $elements = Oak::$publications_without_redundancy;
            break;
            case 'quantis':
                $properties = Quantis::$properties;
                $table = 'quanti';
                $title = __( 'Ajouter un indicateur quantitatif', Oak::$text_domain );
                $elements = Oak::$quantis_without_redundancy;
            break;
            case 'qualis':
                $properties = Qualis::$properties;
                $table = 'quali';
                $title = __( 'Ajouter un indicateur qualitatif', Oak::$text_domain );
                $elements = Oak::$qualis_without_redundancy;
            break;
            case 'goodpractices':
                $properties = Good_Practices::$properties;
                $table = 'goodpractice';
                $title = __( 'Ajouter une Bonne Pratique', Oak::$text_domain );
                $elements = Oak::$goodpractices_without_redundancy;
            break;
            case 'performances':
                $properties = Performances::$properties;
                $table = 'performance';
                $title = __( 'Ajouter une Donnée de performance', Oak::$text_domain );
                $elements = Oak::$performances_without_redundancy;
            break;
            case 'sources':
                $properties = Sources::$properties;
                $table = 'source';
                $title = __( 'Ajouter une Source', Oak::$text_domain );
                $elements = Oak::$sources_without_redundancy;
            break;
            case 'glossaries':
                $properties = Glossaries::$properties;
                $table = 'glossary';
                $title = __( 'Ajouter une términologie', Oak::$text_domain );
                $elements = Oak::$glossaries_without_redundancy;
            break;
            case 'objects' :
                $properties = Oak::$object_properties;
                $table = 'object';
                $title = __( 'Ajouter un objet', Oak::$text_domain );

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

                $elements = Oak::$objects_without_redundancy;
            break;
            case 'terms' :
                $properties = Terms::$properties;
                $table = 'term';
                $title = __( 'Ajouter un terme', Oak::$text_domain );
                $elements = Oak::$terms_without_redundancy;
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
                $elements_with_redundancy = Oak::$fields;
                $table = 'field';
                $filters = Fields::$filters;
            break;
            case 'forms' :
                $title = __( 'Formes', Oak::$text_domain );
                $elements = Oak::$forms_without_redundancy;
                $elements_with_redundancy = Oak::$forms;
                $table = 'form';
                $filters = Forms::$filters;
            break;
            case 'models' :
                $title = __( 'Modèles', Oak::$text_domain );
                $elements = Oak::$models_without_redundancy;
                $elements_with_redundancy = Oak::$models;
                $table = 'model';
                $filters = models::$filters;
            break;
            case 'taxonomies' :
                $title = __( 'Taxonomies', Oak::$text_domain );
                $elements = Oak::$taxonomies_without_redundancy;
                $elements_with_redundancy = Oak::$taxonomies;
                $table = 'taxonomy';
                $filters = Taxonomies::$filters;
            break;
            case 'organizations' :
                $title = __( 'Organisations', Oak::$text_domain );
                $elements = Oak::$organizations_without_redundancy;
                $elements_with_redundancy = Oak::$organizations;
                $table = 'organization';
                $filters = Organizations::$filters;
            break;
            case 'publications' :
                $title = __( 'Publications', Oak::$text_domain );
                $elements = Oak::$publications_without_redundancy;
                $elements_with_redundancy = Oak::$publications;
                $table = 'publication';
                $filters = Publications::$filters;
            break;
            case 'quantis' :
                $title = __( 'Indicateurs Quantitatifs', Oak::$text_domain );
                $elements = Oak::$quantis_without_redundancy;
                $elements_with_redundancy = Oak::$quantis;
                $table = 'quanti';
                $filters = Quantis::$filters;
            break;
            case 'qualis' :
                $title = __( 'Indicateurs Qualitatifs', Oak::$text_domain );
                $elements = Oak::$qualis_without_redundancy;
                $elements_with_redundancy = Oak::$qualis;
                $table = 'quali';
                $filters = Qualis::$filters;
            break;
            case 'glossaries' :
                $title = __( 'Terminologies', Oak::$text_domain );
                $elements = Oak::$glossaries_without_redundancy;
                $elements_with_redundancy = Oak::$glossaries;
                $table = 'glossary';
                $filters = Glossaries::$filters;
            break;
            case 'goodpractices' :
                $title = __( 'Bonnes Pratiques', Oak::$text_domain );
                $elements = Oak::$goodpractices_without_redundancy;
                $elements_with_redundancy = Oak::$goodpractices;
                $table = 'goodpractice';
                $filters = Good_Practices::$filters;
            break;
            case 'performances' :
                $title = __( 'Données de performances', Oak::$text_domain );
                $elements = Oak::$performances_without_redundancy;
                $elements_with_redundancy = Oak::$performances;
                $table = 'performance';
                $filters = Performances::$filters;
            break;
            case 'sources' :
                $title = __( 'Sources', Oak::$text_domain );
                $elements = Oak::$sources_without_redundancy;
                $elements_with_redundancy = Oak::$sources;
                $table = 'source';
                $filters = Sources::$filters;
            break;
            case 'objects' :
                $title = __( 'Objets', Oak::$text_domain );
                $elements = Oak::$objects_without_redundancy;
                $elements_with_redundancy = Oak::$objects;
                $table = 'object';
                $filters = Objects::$filters;
            break;
            case 'terms' :
                $title = __( 'Termes', Oak::$text_domain );
                $elements = Oak::$terms_without_redundancy;
                $elements_with_redundancy = Oak::$terms;
                $table = 'term';
                $filters = Terms::$filters;
            break;
            case 'term_objects' :
                $title = __( 'Objets', Oak::$text_domain );
                $elements = Oak::$term_objects_without_redundancy;
                $elements_with_redundancy = Oak::$objects;
                $table = 'object';
                $filters = Objects::$filters;
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

        // Handling the copying of terms to the new copy of the object
        if ( $table == 'object' && isset( $_POST['copy'] ) ) :
            $new_terms_and_objects_to_insert = [];
            foreach( Oak::$terms_and_objects as $term_and_object ) :
                if ( $term_and_object->object_identifier == $element['copy_identifier'] ) :
                    // Check if term and object already exists by reparsing the terms and objects instances again: 
                    $exists = false;
                    $terms_and_objects_table_name = Oak::$terms_and_objects_table_name;
                    $all_terms_and_objects = $wpdb->get_results ( "
                        SELECT * 
                        FROM $terms_and_objects_table_name
                    " );
                    foreach( $all_terms_and_objects as $checking_term_and_object ) :
                        if ( $checking_term_and_object->object_identifier == $element['object_identifier']
                            && $checking_term_and_object->term_identifier == $term_and_object->term_identifier ) :
                                $exists = true;
                        endif;
                    endforeach;
                    
                    if ( !$exists ) :
                        $new_term_and_object = clone $term_and_object;
                        $new_term_and_object->object_identifier = $element['object_identifier'];
                        
                        $new_term_and_object_to_insert = array(
                            'term_identifier' => $new_term_and_object->term_identifier,
                            'object_identifier' => $new_term_and_object->object_identifier
                        );
                        $new_terms_and_objects_to_insert[] = $new_term_and_object_to_insert;
                    endif;
                endif;
            endforeach;

            foreach( $new_terms_and_objects_to_insert as $term_and_object) :
                $result = $wpdb->insert(
                    Oak::$terms_and_objects_table_name,
                    $term_and_object
                );
            endforeach;
        endif;

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

        // If we are updating a form, set the models_fields_names to empty for the models that use that form (simplified version):
        if ( $table == 'form' ) :
            // Check if the form exists already or not (to know whether we are updating or adding a new form)
            $form_exists = false;
            $form_fields_changed = false;
            $form_identifier = '';
            $the_form = null;
            foreach( Oak::$forms_without_redundancy as $form ) :
                if ( $form->form_identifier == $element['form_identifier'] ) :
                    $form_exists = true;
                    $the_form = $form;
                    // Lets see if the form's fields changed:
                    $form_fields = [];
                    foreach( Oak::$all_forms_and_fields as $form_and_field ) :
                        if ( $form_and_field->form_identifier == $the_form->form_identifier && $form_and_field->form_revision_number == $the_form->form_revision_number ) :
                            $form_fields[] = $form_and_field->field_identifier;
                        endif;
                    endforeach;

                    foreach( $form_fields as $key => $field_identifier ) :
                        if ( isset( $element['otherElements'][ $key ] ) ) :
                            if ( $element['otherElements'][ $key ]['elementIdentifier'] != $field_identifier ) :
                                $form_fields_changed = true;
                            endif;
                        else :
                            $form_fields_changed = true;
                        endif;
                    endforeach;

                    foreach( $element['otherElements'] as $key => $other_element ) :
                        if ( isset( $form_fields[ $key ] ) ) :
                            if ( $form_fields[ $key ] != $other_element['elementIdentifier'] ) :
                                $form_fields_changed = true;
                            endif;
                        else :
                            $form_fields_changed = true;
                        endif;
                    endforeach;
                endif;
            endforeach;


            if ( $form_exists && $form_fields_changed ) :
                foreach( Oak::$models_without_redundancy as $model ) :
                    $the_model_uses_the_form = false;
                    foreach( Oak::$all_models_and_forms as $model_and_form ) :


                        if ( $model_and_form->model_identifier == $model->model_identifier
                            && $model_and_form->model_revision_number == $model->model_revision_number
                            && $model_and_form->form_identifier == $the_form->form_identifier ) :
                            // This is a model that uses the form we are updating :
                                $the_model_uses_the_form = true;
                        endif;
                    endforeach;

                    if ( $the_model_uses_the_form ) :
                        $fields_names = [];
                        foreach( Oak::$all_models_and_forms as $model_and_form ) :

                            if ( $model_and_form->model_identifier == $model->model_identifier &&
                                $model_and_form->model_revision_number == $model->model_revision_number ) :
                                    if ( $model_and_form->form_identifier == $the_form->form_identifier ) :

                                        foreach( $element['otherElements'] as $field ) :
                                            if ( $field['elementOtherDesignation'] != '' ) :
                                                $fields_names[] = $field['elementOtherDesignation'];
                                            else :
                                                foreach( Oak::$fields_without_redundancy as $single_field_without_redundancy ) :
                                                    if ( $single_field_without_redundancy->field_identifier == $field['elementIdentifier'] ) :
                                                        $fields_names[] = $single_field_without_redundancy->field_designation;
                                                    endif;
                                                endforeach;
                                            endif;
                                        endforeach;
                                    else :
                                        // find the form revision number
                                        foreach( Oak::$forms_without_redundancy as $form ) :
                                            if ( $form->form_identifier == $model_and_form->form_identifier ) :
                                                foreach( Oak::$all_forms_and_fields as $form_and_field ) :
                                                    if ( $form_and_field->form_identifier == $form->form_identifier && $form_and_field->form_revision_number == $form->form_revision_number ) :
                                                        if ( $form_and_field->field_designation != '' ) :
                                                            $fields_names[] = $form_and_field->field_designation;
                                                        else :
                                                            foreach( Oak::$fields_without_redundancy as $field ) :
                                                                if ( $field->field_identifier == $form_and_field->field_identifier ) :
                                                                    $fields_names[] = $field->field_designation;
                                                                endif;
                                                            endforeach;
                                                        endif;
                                                    endif;
                                                endforeach;
                                            endif;
                                        endforeach;
                                    endif;
                            endif;
                        endforeach;

                        $fields_names_string = '';
                        foreach( $fields_names as $key => $field_name ) :
                            $delimiter = '|';
                            if ( $key == count( $fields_names ) - 1 ) :
                                $delimiter = '';
                            endif;
                            $fields_names_string .= $field_name . $delimiter;
                        endforeach;

                        $result = $wpdb->update(
                            Oak::$models_table_name,
                            array (
                                'model_fields_names' => $fields_names_string,
                            ),
                            array( 'model_identifier' => $model->model_identifier, 'model_revision_number' => $model->model_revision_number )
                        );
                    endif;

                endforeach;
            endif;
        endif;

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
                if ( $instance->$identifier_property == $element['copy_identifier'] && $instance->$revision_number_property == $element[ $table . '_revision_number' ] ) :
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

        // For objects' terms
        if ( $table == 'object' ) :
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

        $sources_table_name = $wpdb->prefix . 'oak_sources';
        $sources = $wpdb->get_results ( "
            SELECT *
            FROM  $sources_table_name
        " );
        $reversed_sources = array_reverse( $sources );
        $sources_without_redundancy = [];
        foreach( $reversed_sources as $source ) :
            $added = false;
            foreach( $sources_without_redundancy as $source_without_redundancy ) :
                if ( $source_without_redundancy->source_identifier == $source->source_identifier ) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $sources_without_redundancy[] = $source;
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
            'sources' => $sources,
            'sourcesWithoutRedundancy' => $sources_without_redundancy,
            'glossaries' => $glossaries,
            'glossariesWithoutRedundancy' => $glossaries_without_redundancy,
            'termsAndObjects' => $terms_and_objects
        ) );
    }

    static function oak_simple_register_element( $element, $table_name ) {
        require_once get_template_directory() . '/functions/class-download-remote-image.php';

        global $wpdb;

        $element_array = (array) $element;
        foreach( $element_array as $key => $value ) :
            $element_array[ $key ] = stripslashes_deep( $value );
        endforeach;
        unset( $element_array['id'] );

        $result = $wpdb->insert(
            $table_name,
            $element_array
        );
    }

    function corn_simple_register_element( $element, $table_name ) {
        require_once get_template_directory() . '/functions/class-download-remote-image.php';

        global $wpdb;

        foreach( $element as $key => $value ) :
            $the_value = $value;
            if ( strpos( $value, 'ttps://' ) != false || strpos( $value, 'ttp://' ) != false ) :
                if (  wp_http_validate_url( $value ) ) :
                    if ( @getimagesize( $value ) ) :
                        $value_exploded = explode( '/', $value );
                        $image_name = $value_exploded[ count( $value_exploded ) - 1 ];

                        $image_incrementer = 0;
                        $found_image = false;
                        do {
                            $oak_image_exploded = explode( '/', Oak::$all_images[ $image_incrementer ]->guid );
                            $oak_image_name = $oak_image_exploded[ count( $oak_image_exploded ) - 1 ];
                            if ( $image_name == $oak_image_name ) :
                                $found_image = true;
                                $the_value = Oak::$all_images[ $image_incrementer ]->guid;

                                $found_images = get_option('oak_corn_found_images') ? get_option('oak_corn_found_images') : [];
                                $found_images[] = Oak::$all_images[ $image_incrementer ]->ID;
                                update_option( 'oak_corn_found_images', $found_images );
                            endif;

                            $image_incrementer++;
                        } while( !$found_image && $image_incrementer < count( Oak::$all_images ) );
                        if ( !$found_image ) :
                            $download_remote_image = new KM_Download_Remote_Image( $value, array() );
                            $id = $download_remote_image->download();
                            $the_value = get_post( $id )->guid;
                        endif;
                    endif;
                endif;
            endif;

            $element[ $key ] = $this->oak_filter_word( $the_value );
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
            , Oak::$sources_table_name, Oak::$performances_table_name, Oak::$goodpractices_table_name
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

        Oak::$all_images = $this->oak_get_all_images()->posts;

        $this->delete_everything();

        $selected_data = json_decode( stripslashes( $_POST['selectedData'] ), true );

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
        $sources = $selected_data['sources'];
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
        $this->corn_save_element( $sources, Oak::$sources_table_name );
        $this->corn_save_element( $terms_and_objects, Oak::$terms_and_objects_table_name );

        $this->corn_save_element( $forms_and_fields, Oak::$forms_and_fields_table_name );
        $this->corn_save_element( $models_and_forms, Oak::$models_and_forms_table_name );

        // Creating the tables for models
        foreach( $models as $model ) :
            // Lets look for the model fields: 
            $model_fields = [];
            $found_object = false;
            $counter = 0;
            do {
                if ( $objects[ $counter ]['model'] == $model['model_identifier'] ) :
                    $found_object = true;
                    $the_object = $objects[ $counter ];
                    $properties_to_neglect = array('id', 'model', 'object_designation', 'object_identifier', 'object_modification_time', 'object_content_language', 'object_model_selector', 'object_selector',
                        'object_locked', 'object_state', 'object_trashed', 'object_selectors', 'object_form_selectors', 'object_model_selector');
                    foreach( $the_object as $key => $value ) :
                        if ( !in_array( $key, $properties_to_neglect ) ) :
                            $model_properties_array = explode( '_', $key );
                            $field_identifier = '';
                            if ( count( $model_properties_array == 3 ) ) :
                                $field_identifier = $model_properties_array[2];
                            endif;

                            foreach( $fields as $field ) :
                                if ( $field['field_identifier'] == $field_identifier ) :
                                    $field_copy = $field;
                                    $field_copy['form_and_field_properties'] = $form_and_field_instance;
                                    $field_copy['field_key'] = $key;
                                    array_push( $model_fields, $field_copy );
                                endif;
                            endforeach;
                        endif;
                    endforeach;
                endif;
                $counter++;
            } while( $counter < count( $objects ) - 1 && !$found_object );

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
                object_content_language varchar(10) DEFAULT 'fr',
                object_selectors varchar(999),
                object_form_selectors varchar(999),
                object_model_selector TEXT,
                PRIMARY KEY (id)
            ) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $models_sql );

            foreach( $model_fields as $key => $field ) :
                // $column_name = 'object_' . $key . '_' . $field['field_identifier'];
                $column_name = $field['field_key'];
                $columns = $wpdb->get_results( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'" );
                $exists = false;
                foreach( $columns as $column ) :
                    if ( $column->COLUMN_NAME == $column_name ) :
                        $exists = true;
                    endif;
                endforeach;

                if ( !$exists ) {
                    if ( $field->field_type == 'textarea' ) :
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
                term_content_language varchar(10) DEFAULT 'fr',
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

        $this->oak_delete_images_that_are_not_needed();

        wp_send_json_success();
    }

    function oak_delete_images_that_are_not_needed() {
        $found_images = get_option( 'oak_corn_found_images' ) ? get_option( 'oak_corn_found_images' ) : [];
        foreach( Oak::$all_images as $image ) :
            $is_in_found_images = false;
            foreach( $found_images as $found_image ) :
                if ( $found_image == $image->ID ) :
                    $is_in_found_images = true;
                endif;
            endforeach;
            if ( !$is_in_found_images ) :
                wp_delete_attachment( $image->ID, true );
            endif;
        endforeach;
    }

    function oak_wordpress_dashboard() {
        include get_template_directory() . '/template-parts/admin-menu.php';
        include get_template_directory() . '/template-parts/system-bar.php';
        include get_template_directory() . '/template-parts/app-bar.php';
    }

    function oak_save_graph() {
        Graphs::save_graph();
    }

    static function oak_automatic_element_publication_association( $element, $objects_identifiers, $publication_property, $table_name ) {
        foreach( $objects_identifiers as $object_identifier ) :
            foreach( Oak::$terms_and_objects as $term_and_object ) :
                if ( $term_and_object->object_identifier == $object_identifier ) :
                    $found_term = false; 
                    $terms_incrementer = 0;
                    do {
                        if ( count( Oak::$all_terms_without_redundancy ) > $terms_incrementer ) :
                            if ( Oak::$all_terms_without_redundancy[ $terms_incrementer ]->term_identifier == $term_and_object->term_identifier ) :
                                $found_term = true;
                                $term_without_redundancy = Oak::$all_terms_without_redundancy[$terms_incrementer];

                                $taxonomy_identifier = $term_without_redundancy->term_taxonomy_identifier;
                                
                                $found_taxonomy = false;
                                $taxonomy_incrementer = 0;
                                do {
                                    if ( Oak::$taxonomies_without_redundancy[ $taxonomy_incrementer ]->taxonomy_identifier == $taxonomy_identifier ) :
                                        $found_taxonomy = true;
                                        $taxonomy = Oak::$taxonomies_without_redundancy[ $taxonomy_incrementer ];
                                        $publication_identifier = $taxonomy->taxonomy_publication;
                                        $element->$publication_property = $publication_identifier;
                                        
                                        Oak::oak_simple_register_element( $element, $table_name );
                                    endif;
                                    $taxonomy_incrementer++;
                                } while( !$found_taxonomy && $taxonomy_incrementer < count( Oak::$taxonomies_without_redundancy ) );
                            endif;
                        endif;
                        $terms_incrementer++;
                    } while( $terms_incrementer < count( Oak::$all_terms_without_redundancy ) && !$found_term );
                endif;
            endforeach;
        endforeach;
    }

    function oak_dashboard() {
        include get_template_directory() . '/functions/dashboard/index.php';
    }

    static function var_dump( $text ) {
        echo('<pre>');
        var_dump( $text );
        echo('</pre>');
    }

    function oak_regenerate_indexes() {
        include get_template_directory() . '/functions/auto-index.gen.php';
    }
}

$oak = new oak();

