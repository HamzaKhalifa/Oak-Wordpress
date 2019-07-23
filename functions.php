<?php
@ini_set( 'upload_max_size' , '99M' );
@ini_set( 'post_max_size', '99M');
@ini_set( 'max_execution_time', '300' );

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
    public static $publishers_table_name;

    public static $shared_properties;

    public static $elements_script_properties_functions = [];
    public static $current_element_script_properties = [];

    public static $revisions = [];

    public static $fields = [];
    public static $fields_without_redundancy = [];
    public static $field_properties = [];

    public static $forms = [];
    public static $forms_without_redundancy = [];
    public static $forms_attributes = [];
    public static $form_properties = [];
    public static $all_forms_and_fields = [];

    public static $objects = [];
    public static $objects_without_redundancy = [];
    public static $all_objects = [];
    public static $all_objects_without_redundancy = [];

    public static $terms = [];
    public static $terms_without_redundancy = [];
    public static $all_terms = [];
    public static $all_terms_without_redundancy = [];

    public static $terms_and_objects = [];

    public static $models = [];
    public static $models_without_redundancy = [];
    public static $model_properties = [];
    public static $model_other_elements;
    public static $all_models_and_forms = [];
    public static $current_model_fields = [];
    public static $object_properties = [];
    public static $term_properties = [];

    public static $organizations = [];
    public static $organizations_without_redundancy = [];
    public static $organization_properties = [];

    public static $publications = [];
    public static $publications_without_redundancy = [];
    public static $publication_properties = [];

    public static $glossaries = [];
    public static $glossaries_without_redundancy = [];
    public static $glossary_properties = [];

    public static $qualis = [];
    public static $qualis_without_redundancy = [];
    public static $quali_properties = [];

    public static $quantis = [];
    public static $quantis_without_redundancy = [];
    public static $quanti_properties = [];

    public static $goodpractices = [];
    public static $goodpractices_without_redundancy = [];
    public static $goodpractice_properties = [];

    public static $sources = [];
    public static $sources_without_redundancy = [];
    public static $source_properties = [];

    public static $performances = [];
    public static $performances_without_redundancy = [];
    public static $performance_properties = [];

    public static $taxonomies = [];
    public static $taxonomies_without_redundancy = [];
    public static $taxonomy_properties = [];

    public static $publishers = [];
    public static $publishers_without_redundancy = [];
    public static $publisher_properties = [];

    public static $graphs = [];
    public static $graphs_without_redundancy = [];
    public static $graph_properties = [];

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
    public static $pdf_publications_array = [];
    public static $organizations_array = [];
    public static $glossaries_array = [];
    public static $quantis_and_qualis = [];
    public static $qualis_array = [];
    public static $quantis_array = [];
    public static $terms_array = [];
    public static $objects_array = [];
    public static $frame_objects_array = [];
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
    public static $content_filters = [];
    public static $all_posts_and_pages_array = [];

    function __construct() {
        global $wpdb;

        Oak::$elements_script_properties_functions = [];

        Oak::$text_domain = 'oak';
        Oak::$site_language = substr( get_locale(), 0, 2 );
        Oak::$content_filters = get_option( 'oak_fitler_content_variables' ) ? 
            isset( get_option( 'oak_fitler_content_variables' )[ wp_get_current_user()->ID ] ) ? 
                get_option( 'oak_fitler_content_variables' )[ wp_get_current_user()->ID ]
                : array (
                    'selected_steps' => array('0'),
                    'selected_publications' => array('0')
                ) : array (
                    'selected_steps' => array('0'),
                    'selected_publications' => array('0')
                );

        // Front end styles and scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'oak_enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'oak_enqueue_scripts' ) );
        
        // Back end styles and scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'oak_admin_enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'oak_admin_enqueue_scripts' ) );

        add_action('get_header', array( $this, 'oak_remove_admin_login_header' ) );

        // Initialize table names
        include_once get_template_directory() . '/functions/tables/constants/table-names.php';

        // Dashboard
        include_once get_template_directory() . '/functions/dashboard/index.php';

        // Configuration
        include_once get_template_directory() . '/functions/configuration/index.php';

        // Creating our tables
        include_once get_template_directory() . '/functions/tables/index.php';

        // Initializing all the tables properties
        include_once get_template_directory() . '/functions/properties-initialization.php';

        include_once get_template_directory() . '/functions/elementor/index.php';

        // Create post and page meta boxes
        include_once get_template_directory() . '/functions/post_meta_boxes/index.php';

        // Handle Elementor functionalities
        include_once get_template_directory() . '/functions/elementor/index.php';

        // Corn configuration
        include_once get_template_directory() . '/functions/corn/corn-configuration/index.php';

        // Corn (Web publisher)
        include_once get_template_directory() . '/functions/corn/corn-import/index.php';

        // Data studio
        include_once get_template_directory() . '/functions/data-studio/index.php';

        // Reporting safety
        include_once get_template_directory() . '/functions/reporting-safety/index.php';
        
        // For the loading game
        include_once get_template_directory() . '/functions/loading-game/index.php';
        
        // For the chat
        include_once get_template_directory() . '/functions/chat/index.php';

        // To permit cross origin communication 
        add_action( 'init', array( $this, 'add_cors_http_header' ) );

        // Theme support
        add_action( 'after_setup_theme', array( $this, 'oak_add_theme_support' ) );

        // To load languages files
        add_action( 'after_setup_theme', array( $this, 'oak_translation_setup' ) );

        // To register the sidebars
        add_action( 'widgets_init', array( $this, 'oak_register_sidebars' ) );

        // Too add new pages
        add_action( 'admin_menu', array( $this, 'oak_handle_admin_menu' ) );

        // Handle all ajax calls
        $this->oak_ajax_calls();
    }

    function oak_ajax_calls() {
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
    }

    public static function oak_enqueue_styles() {
        wp_enqueue_style( 'oak_the_style', get_stylesheet_directory_uri() . '/style.css' );
        wp_enqueue_style( 'oak_global', get_template_directory_uri() . '/src/css/global.css' );
        wp_enqueue_style( 'oak_front_global', get_template_directory_uri() . '/src/css/front/global.css' );
        wp_enqueue_style( 'oak_front_elementor_editor', get_template_directory_uri() . '/src/css/front/elementor-editor.css' );
    }

    function oak_enqueue_scripts() {
        wp_enqueue_script( 'oak_charts', get_template_directory_uri() . '/src/js/vendor/chart.bundle.min.js', array(), false, true );
        Oak_Elementor::oak_elementor_editor_enqueue_scripts();

        ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
        <?php
    }

    function oak_admin_enqueue_styles( $hook ) {
        wp_enqueue_media();

        wp_enqueue_style( 'oak_global', get_template_directory_uri() . '/src/css/global.css' );

        // Add the color picker css file
        wp_enqueue_style( 'wp-color-picker' );

        wp_enqueue_style( 'oak_the_style', get_stylesheet_directory_uri() . '/style.css' );
            
        ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">

        <?php
    }

    function oak_admin_enqueue_scripts( $hook ) {
        global $wpdb;

        // For the system bar 
        wp_enqueue_script( 'oak_chat', get_template_directory_uri() . '/functions/dashboard/src/js/system-bar.js', array('jquery'), false, true );

        // For the media library
        wp_enqueue_script( 'oak_media_library', get_template_directory_uri() . '/src/js/vendor/wp-media-modal.js', array('jquery'), false, true );

        // Auto complete
        wp_enqueue_script( 'auto_complete', get_template_directory_uri() . '/src/js/autocomplete.js', array('jquery'), false, true );

        // For elements
        if ( isset( $_GET['elements'] ) ) :
            
            Oak::$shared_properties = array (
                array( 'name' => 'designation', 'type' => 'text', 'input_type' => 'text' ),
                array( 'name' => 'identifier', 'type' => 'text', 'input_type' => 'text' ),
                array( 'name' => 'selector', 'type' => 'text', 'input_type' => 'checkbox' ),
                array( 'name' => 'locked', 'type' => 'text', 'input_type' => 'checkbox' ),
                array( 'name' => 'trashed', 'type' => 'text', 'input_type' => 'checkbox' ),
                array( 'name' => 'state', 'type' => 'text', 'input_type' => 'checkbox' ),
            );
            
            // var_dump( Oak::$elements_script_properties_functions );
            // Oak::$elements_script_properties_functions[ $_GET['elements'] ]();
            switch ( $_GET['elements'] ) :
                case 'fields':
                    Fields::properties_to_enqueue_for_script();
                break;
                case 'forms' :
                    Forms::properties_to_enqueue_for_script();
                break;
                case 'models' :
                    Models::properties_to_enqueue_for_script();
                break;
                case 'organizations' :
                    Organizations::properties_to_enqueue_for_script();
                break;
                case 'publications' :
                    Publications::properties_to_enqueue_for_script();
                break;
                case 'taxonomies' :
                    Taxonomies::properties_to_enqueue_for_script();
                break;
                case 'terms' :
                    Terms::properties_to_enqueue_for_script();
                break;
                case 'term_objects' :
                    Terms::properties_to_enqueue_for_script_if_term_objects();
                break;
                case 'glossaries' :
                    Glossaries::properties_to_enqueue_for_script();
                break;
                case 'qualis' :
                    Qualis::properties_to_enqueue_for_script();
                break;
                case 'quantis' :
                    Quantis::properties_to_enqueue_for_script();
                break;
                case 'objects' :
                    Objects::properties_to_enqueue_for_script();
                break;
                case 'performances' :
                    Performances::properties_to_enqueue_for_script();
                break;
                case 'goodpractices' :
                    Good_Practices::properties_to_enqueue_for_script();
                break;
                case 'sources' :
                    Sources::properties_to_enqueue_for_script();
                break;
                case 'publishers' :
                    Publishers::properties_to_enqueue_for_script();
                break;
                case 'graphs' :
                    Graphs::properties_to_enqueue_for_script();
                break;
            endswitch;

            $basic_data_to_pass = array(
                'ajaxUrl' => admin_url ('admin-ajax.php'),
                'adminUrl' => admin_url(),
                'elementsType' => $_GET['elements'],
                'templateDirectoryUri' => get_template_directory_uri(),
                'termIdentifier' => isset ( $_GET['term_identifier'] ) ? $_GET['term_identifier'] : '',
                'siteLanguage' => Oak::$site_language,
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

            $final_data_to_pass = array_merge( $basic_data_to_pass, Oak::$current_element_script_properties );

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

    function oak_register_sidebars() {
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
    }

    function oak_translation_setup() {
        load_theme_textdomain( Oak::$text_domain, get_template_directory() . '/languages' );
    }

    function add_cors_http_header() {
        header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Origin: http://localhost:8888/test/wp-admin/admin-ajax.php');
    }
    
    static function oak_get_selected_objects_data( $selected_objects, $modify_current_model_fields ) {
        global $wpdb;
        
        $our_objects = [];

        foreach( $selected_objects as $selected_object_identifier ) :
            foreach( Oak::$models_without_redundancy as $model ) :
                $table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
                $objects = $wpdb->get_results ( "
                    SELECT *
                    FROM  $table_name
                " );
                $objects = array_reverse( $objects );
                foreach( $objects as $object ) :
                    if ( $object->object_identifier == $selected_object_identifier ) :
                        $exists = false;
                        foreach( $our_objects as $already_added_object ) :
                            if ( $already_added_object->object_identifier == $object->object_identifier ) :
                                $exists = true;
                            endif;
                        endforeach;
                        if ( !$exists ) :
                            $model_fields = Models::get_model_fields( $model, $modify_current_model_fields );
                            $object = Objects::get_object_of_corresponding_language( $object );
                            $object->object_model_fields = $model_fields;

                            $object->object_model_fields_names = $model->model_fields_names;
                            $our_objects[] = $object;
                        endif;
                    endif;
                endforeach;
            endforeach;
        endforeach;

        return $our_objects;
    }

    function oak_handle_admin_menu() {
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

    public static function oak_get_all_wordpress_menus(){
        return get_terms( 'nav_menu', array( 'hide_empty' => true ) );
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
            case 'publishers':
                $properties = Publishers::$properties;
                $table = 'publisher';
                $title = __( 'Ajouter un IVWP', Oak::$text_domain );
                $elements = Oak::$publishers_without_redundancy;
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
            case 'graphs':
                $properties = Graphs::$properties;
                $table = 'graph';
                $title = __( 'Ajouter un Graphe', Oak::$text_domain );
                $elements = Oak::$graphs_without_redundancy;
            break;
        endswitch;
        include get_template_directory() . '/template-parts/elements/add-element.php';
    }

    function oak_elements_list() {
        global $wpdb;
        $elements = [];
        $table = '';
        $title = '';

        $arguments_handler = array(
            'fields' => array( 
                __( 'Champs', Oak::$text_domain ),
                Oak::$fields_without_redundancy,
                Oak::$fields,
                'field',
                Fields::$filters,
            ),
            'forms' =>  array( 
                __( 'Formes', Oak::$text_domain ),
                Oak::$forms_without_redundancy,
                Oak::$forms,
                'form',
                Forms::$filters,
            ),
            'models' =>  array( 
                __( 'Modèles', Oak::$text_domain ),
                Oak::$models_without_redundancy,
                Oak::$models,
                'model',
                models::$filters,
            ),
            'taxonomies' =>  array( 
                __( 'Taxonomies', Oak::$text_domain ),
                Oak::$taxonomies_without_redundancy,
                Oak::$taxonomies,
                'taxonomy',
                Taxonomies::$filters,
            ),
            'organizations' =>  array( 
                __( 'Organisations', Oak::$text_domain ),
                Oak::$organizations_without_redundancy,
                Oak::$organizations,
                'organization',
                Organizations::$filters,
            ),
            'publications' =>  array( 
                __( 'Publications', Oak::$text_domain ),
                Oak::$publications_without_redundancy,
                Oak::$publications,
                'publication',
                Publications::$filters,
            ),
            'quantis' =>  array( 
                __( 'Indicateurs Quantitatifs', Oak::$text_domain ),
                Oak::$quantis_without_redundancy,
                Oak::$quantis,
                'quanti',
                Quantis::$filters,
            ),
            'qualis' =>  array( 
                __( 'Indicateurs Qualitatifs', Oak::$text_domain ),
                Oak::$qualis_without_redundancy,
                Oak::$qualis,
                'quali',
                Qualis::$filters,
            ),
            'glossaries' =>  array( 
                __( 'Terminologies', Oak::$text_domain ),
                Oak::$glossaries_without_redundancy,
                Oak::$glossaries,
                'glossary',
                Glossaries::$filters,
            ),
            'goodpractices' =>  array( 
                __( 'Bonnes Pratiques', Oak::$text_domain ),
                Oak::$goodpractices_without_redundancy,
                Oak::$goodpractices,
                'goodpractice',
                Good_Practices::$filters,
            ),
            'performances' =>  array( 
                __( 'Données de performances', Oak::$text_domain ),
                Oak::$performances_without_redundancy,
                Oak::$performances,
                'performance',
                Performances::$filters,
            ),
            'sources' =>  array( 
                __( 'Sources', Oak::$text_domain ),
                Oak::$sources_without_redundancy,
                Oak::$sources,
                'source',
                Sources::$filters,
            ),
            'objects' =>  array( 
                __( 'Objets', Oak::$text_domain ),
                Oak::$objects_without_redundancy,
                Oak::$objects,
                'object',
                Objects::$filters,
            ),
            'terms' =>  array( 
                __( 'Termes', Oak::$text_domain ),
                Oak::$terms_without_redundancy,
                Oak::$terms,
                'term',
                Terms::$filters,
            ),
            'term_objects' =>  array( 
                __( 'Objets', Oak::$text_domain ),
                Oak::$term_objects_without_redundancy,
                Oak::$objects,
                'object',
                Objects::$filters,
            ),
            'publishers' =>  array( 
                __( 'IVWPs', Oak::$text_domain ),
                Oak::$publishers_without_redundancy,
                Oak::$publishers,
                'publisher',
                Publishers::$filters,
            ),
            'graphs' =>  array( 
                __( 'Graphes', Oak::$text_domain ),
                Oak::$graphs_without_redundancy,
                Oak::$graphs,
                'graph',
                Graphs::$filters,
            ),
        );
        $handler = $arguments_handler[ $_GET['elements'] ];
        $title = $handler[0];
        $elements = $handler[1];
        $elements_with_redundancy = $handler[2];
        $table = $handler[3];
        $filters = $handler[4];
        include get_template_directory() . '/template-parts/elements/elements-list.php';
    }

    public static function oak_get_revisions( $table, $elements ) {
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

    public static function oak_filter_word( $value ) {
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

        if ( get_option( 'oak_corn' ) == 'true' )
            $element[ $table . '_synchronized' ] = 'false';
        else 
            $element[ $table . '_synchronized' ] = 'true';

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

        error_log( print_r( $array_data, TRUE ) );
        error_log('---------');
        error_log( $result );

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

    public static function check_table_exists( $table_name ) {
        global $wpdb;
        $my_tables=$wpdb->get_results("SHOW TABLES");
        $exists = false;
        foreach( $my_tables as $table ) :
            foreach( $table as $key => $value ) :
                if ( $value == $table_name ) :
                    $exists = true;
                endif;
            endforeach;
        endforeach;

        return $exists;
    }

    public static function delete_everything() {
        global $wpdb;
        $tables = [ Oak::$fields_table_name, Oak::$forms_table_name, Oak::$models_table_name, Oak::$taxonomies_table_name
            , Oak::$organizations_table_name, Oak::$publications_table_name, Oak::$glossaries_table_name, Oak::$qualis_table_name
            , Oak::$quantis_table_name, Oak::$forms_and_fields_table_name, Oak::$models_and_forms_table_name, Oak::$terms_and_objects_table_name
            , Oak::$sources_table_name, Oak::$performances_table_name, Oak::$goodpractices_table_name
        ];

        // Lets get the taxonomies (because delete_everything is called before tables.php) :
        $taxonomies_table_name = Oak::$taxonomies_table_name;
        if ( Oak::check_table_exists( $taxonomies_table_name ) ) :
            Oak::$taxonomies = $wpdb->get_results ( "
                SELECT *
                FROM  $taxonomies_table_name
            " );
        endif;
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
        if ( Oak::check_table_exists( $models_table_name ) ) :
            Oak::$models = $wpdb->get_results ( "
                SELECT *
                FROM  $models_table_name
            " );
        endif;
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
            if ( Oak::check_table_exists( $table ) ) :
                $delete = $wpdb->query("DELETE FROM $table");
            endif;
        endforeach;
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

    static function var_dump( $text ) {
        echo('<pre>');
        var_dump( $text );
        echo('</pre>');
    }

    public static function oak_unset_properties_by_checking_table( $element, $table_name ) {
        $columns = $wpdb->get_results( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'" );
        $columns_names = [];
        foreach( $element as $property_name => $value ) :
            $property_exists = false;
            
            foreach( $columns as $column ) :
                if ( $column->COLUMN_NAME == $property_name )
                    $exists = true;
            endforeach;

            if ( !$exists ) :
                unset( $element[ $property_name ] );
            endif;
        endforeach;

        return $element;
    }

    function oak_remove_admin_login_header() {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }

    public static function oak_get_child_elements( $table, $child_elements ) {
        if ( $table == 'object' || $child_elements['table'] == 'object' || $table == 'field' ) :
            return null;
        endif;

        if ( $child_elements == null ) :
            if ( $table == 'organization' || $table == 'publication' || $table == 'taxonomy' || $table == 'term' ) :
                $child_elements = Organizations::get_child_elements();
            elseif ( $table == 'model' || $table == 'form' || $table == 'field') :
                $child_elements = Models::get_child_elements();
            endif;
        endif;

        if ( $child_elements['for_table'] == $table ) :
            return $child_elements;
        else :
            return ( Oak::oak_get_child_elements( $table, $child_elements['child_elements'] ) );
        endif;
    }

    public static function oak_handle_child_elements_display( $child_elements, $element_identifier, $table ) {
        if ( $child_elements == array() ) :
            return;
        endif;

        $the_child_elements = $child_elements['get_child_elements_function']( $element_identifier );
        foreach( $the_child_elements as $single_child_element ) : 
            $child_element_designation_property = $child_elements['table'] . '_designation';
            $child_element_identifier_property = $child_elements['table'] . '_identifier';
            ?>
            <div
                table="<?php echo( $child_elements['table'] ); ?>" 
                elements-name="<?php echo( $child_elements['elements_name'] ); ?>" 
                identifier="<?php echo( $single_child_element->$child_element_identifier_property ); ?>" 
                class="oak_single_list_row"
                <?php if ( $child_elements['table'] == 'object' ) : ?>
                    model-identifier="<?php echo( $single_child_element->object_model_identifier ); ?>"
                <?php endif; ?>
                <?php if ( $child_elements['table'] == 'term' ) : ?>
                    taxonomy-identifier="<?php echo( $element_identifier ) ?>"
                <?php endif; ?>
            >
                <div class="oak_list_row">
                    <div class="oak_list_row__container">
                        <i class="fas fa-sort-down oak_list_row__show_hide_children_button"></i>
                        <input class="oak_list_titles_container__checkbox" type="checkbox">
                        <span class="oak_list_titles_container__title"><?php echo( $single_child_element->$child_element_designation_property ); ?></span>
                    </div>
                </div>

                <div class="oak_list_row_child_elements_container oak_hidden">
                    <?php
                    Oak::oak_handle_child_elements_display( $child_elements['child_elements'], $single_child_element->$child_element_identifier_property, $child_elements['table'] );
                    ?>
                </div>
            </div>
            <?php
        endforeach;
    }

    public static function oak_get_all_posts_and_pages() {
        $posts = get_posts( array(
            'numberposts' => -1,
        ) );
    
        $pages = get_pages( array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        ) );
    
        $all_posts_and_pages = array_merge( $posts, $pages );

        return $all_posts_and_pages;
    }

    function oak_get_quali_indicators_and_specific_objects_linked_frame_objects( $post, $oak_indexes, $object, $table_name ) {
        $frame_objects_property_name = $table_name . '_frame_objects';
        $identifier_property_name = $table_name . '_identifier';
        $designation_property_name = $table_name . '_designation';
        $object_data_property_name = $table_name . '_data';

        $frame_linked_objects_identifiers_array_with_possible_empty_strings = explode( '|', $object->$frame_objects_property_name );
        $frame_linked_objects_array = [];
        foreach( $frame_linked_objects_identifiers_array_with_possible_empty_strings as $frame_linked_object_identifier ) :
            if ( $frame_linked_object_identifier != '' ) :
                $frame_linked_objects_array[] = $frame_linked_object_identifier;
            endif;
        endforeach;

        $object_data = array(
            'object' => array(
                'identifier' => $object->$identifier_property_name,
                'designation' => $object->$designation_property_name,
            ),
            'fields_data' => [],
            'forms_frame_linked_objects' => array(),
            'model_frame_linked_objects' => $frame_linked_objects_array,
            'post_url' => $post->guid,
            'post_title' => $post->post_title
        );
        $post_content = file_get_contents( $post->guid );
        foreach( $object->$object_data_property_name as $value => $field_name ) :
            $used_in_posts = [];
            if ( strpos( $post_content, $value ) !== false ) :
                $used_in_posts[] = array ( 
                    'id' => $post->ID,
                    'post_url' => $post->guid,
                    'post_title' => $post->post_title,
                    'object_designation' => $object->$designation_property_name
                );
            endif;
            $single_field_data = array(
                'field_name' => $field_name,
                'value' => $value,
                'frame_linked_objects' => $frame_linked_objects_array,
                'used_in_posts' => $used_in_posts
            );
            $object_data['fields_data'][] = $single_field_data;
        endforeach;

        $oak_indexes[] = $object_data;

        return $oak_indexes;
    }
}

$oak = new oak();

