<?php 

class Oak {
    public static $text_domain; 
    public static $fields_table_name;
    public static $forms_table_name;
    public static $fields;
    public static $forms;

    function __construct() {
        Oak::$text_domain = 'oak';

        global $wpdb;
        Oak::$fields_table_name = $wpdb->prefix . 'oak_fields';
        Oak::$forms_table_name = $wpdb->prefix . 'oak_forms';

        add_action( 'wp_enqueue_scripts', array( $this, 'oak_enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'oak_enqueue_scripts' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'oak_admin_enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'oak_admin_enqueue_scripts' ) );

        add_action( 'after_setup_theme', array( $this, 'oak_add_theme_support' ) );

        add_action( 'init', array( $this, 'oak_register_post_types') );
        add_action( 'init', array( $this, 'oak_register_taxonomies') );
        add_action( 'init', array( $this, 'oak_add_options_page') );
        add_action( 'init', array( $this, 'oak_remove_post_type_editors' ) ); 
        add_action( 'init', array( $this, 'add_cors_http_header' ) );
        
        add_action( 'admin_menu', array( $this, 'oak_handle_admin_menu' ) );

        add_action( 'acf/init', array( $this, 'oak_add_custom_field_groups') );
        add_filter( 'acf/load_field/name=analyzes', array( $this, 'oak_set_analyzes' ) );
        add_filter( 'acf/load_field/name=contacts', array( $this, 'oak_set_organizations_contacts' ) );
        add_filter( 'acf/load_field/name=countries', array( $this, 'oak_set_countries' ) );
        add_filter( 'acf/load_field/name=org-countries', array( $this, 'oak_set_countries' ) );
        add_filter( 'acf/load_field/name=language_publication', array( $this, 'oak_set_languages' ) );

        add_action( 'transition_post_status', function ( $new_status, $old_status, $post )  {
            if( 'publish' == $new_status && 'publish' != $old_status ) {
                update_post_meta( $post->ID, 'unique_identifier', $this->generateRandomString() );
            }
        }, 10, 3 );
        add_action( 'save_post', array( $this, 'oak_set_contacts_organizations') );
        
        $this->oak_ajax_calls();

        $this->oak_contact_form();
    }

    function oak_ajax_calls() {
        add_action('wp_ajax_oak_save_analysis_model', array( $this, 'oak_save_analysis_model') );
        add_action('wp_ajax_nopriv_oak_save_analysis_model', array( $this, 'oak_save_analysis_model') );

        add_action( 'wp_ajax_oak_save_analyzes', array( $this, 'oak_save_analyzes') );
        add_action( 'wp_ajax_nopriv_oak_save_analyzes', array( $this, 'oak_save_analyzes') );

        add_action( 'wp_ajax_oak_save_taxonomy', array( $this, 'oak_save_taxonomy') );
        add_action( 'wp_ajax_nopriv_oak_save_taxonomy', array( $this, 'oak_save_taxonomy') );

        add_action( 'wp_ajax_oak_delete_taxonomy', array( $this, 'oak_delete_taxonomy') );
        add_action( 'wp_ajax_nopriv_oak_delete_taxonomy', array( $this, 'oak_delete_taxonomy') );

        add_action( 'wp_ajax_oak_save_cpt', array( $this, 'oak_save_cpt') );
        add_action( 'wp_ajax_nopriv_oak_save_cpt', array( $this, 'oak_save_cpt') );

        add_action( 'wp_ajax_oak_delete_cpt', array( $this, 'oak_delete_cpt') );
        add_action( 'wp_ajax_nopriv_oak_delete_cpt', array( $this, 'oak_delete_cpt') );

        add_action( 'wp_ajax_oak_get_organizations', array( $this, 'oak_get_organizations') );
        add_action( 'wp_ajax_nopriv_oak_get_organizations', array( $this, 'oak_get_organizations') );

        add_action( 'wp_ajax_oak_corn_configuration', array( $this, 'oak_corn_configuration') );
        add_action( 'wp_ajax_nopriv_oak_corn_configuration', array( $this, 'oak_corn_configuration') );

        add_action( 'wp_ajax_oak_corn_import_publications_data', array( $this, 'oak_corn_import_publications_data') );
        add_action( 'wp_ajax_nopriv_oak_corn_import_publications_data', array( $this, 'oak_corn_import_publications_data') );

        add_action( 'wp_ajax_oak_corn_content_library_search', array( $this, 'oak_corn_content_library_search') );
        add_action( 'wp_ajax_nopriv_oak_corn_content_library_search', array( $this, 'oak_corn_content_library_search') );

        add_action( 'wp_ajax_oak_register_field', array( $this, 'oak_register_field') );
        add_action( 'wp_ajax_nopriv_oak_register_field', array( $this, 'oak_register_field') );

        add_action( 'wp_ajax_oak_delete_field', array( $this, 'oak_delete_field') );
        add_action( 'wp_ajax_nopriv_oak_delete_field', array( $this, 'oak_delete_field') );

        add_action( 'wp_ajax_oak_update_field', array( $this, 'oak_update_field') );
        add_action( 'wp_ajax_nopriv_oak_update_field', array( $this, 'oak_update_field') );

        add_action( 'wp_ajax_oak_send_field_to_trash', array( $this, 'oak_send_field_to_trash') );
        add_action( 'wp_ajax_nopriv_oak_send_field_to_trash', array( $this, 'oak_send_field_to_trash') );

        add_action( 'wp_ajax_oak_register_form', array( $this, 'oak_register_form') );
        add_action( 'wp_ajax_nopriv_oak_register_form', array( $this, 'oak_register_form') );
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
        if ( get_current_screen()->id == 'oak-materiality-reporting_page_oak_critical_analysis' 
            || get_current_screen()->id == 'oak-materiality-reporting_page_oak_critical_analysis_configuration' 
            || get_current_screen()->id == 'oak-materiality-reporting_page_oak_add_taxonomies' 
            || get_current_screen()->id == 'oak-materiality-reporting_page_oak_add_object_model' 
            || get_current_screen()->id == 'toplevel_page_oak_fields'
            || get_current_screen()->id == 'toplevel_page_oak_fields_list'
            || get_current_screen()->id == 'champs_page_oak_add_field'
            || get_current_screen()->id == 'formes_page_oak_add_form'
            || get_current_screen()->id == 'toplevel_page_oak_forms_list'
        ) :
            wp_enqueue_style( 'oak_the_style', get_stylesheet_directory_uri() . '/style.css' );
            ?>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
            <?php
        endif;
    }

    function oak_admin_enqueue_scripts( $hook ) { 
        global $wpdb; 

        if ( get_current_screen()->id == 'oak-materiality-reporting_page_oak_import_csv_files' ) :
            wp_enqueue_script( 'oak_import_csv_file', get_template_directory_uri() . '/src/js/import-csv-files.js', array('jquery'), false, true );
        endif;

        wp_enqueue_script( 'admin_menu_script', get_template_directory_uri() . '/src/js/admin-menu.js', array('jquery'), false, true );
        wp_localize_script( 'admin_menu_script', 'DATA', array(
            'ajaxUrl' => admin_url('admin-ajax.php')
        ) );

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

        if ( get_current_screen()->id == 'oak-materiality-reporting_page_oak_critical_analysis' ) :
            wp_enqueue_script( 'oak_charts', get_template_directory_uri() . '/src/js/vendor/chart.bundle.min.js', array(), false, true);
            wp_enqueue_script( 'oak_critical_analysis', get_template_directory_uri() . '/src/js/critical-analysis.js', array('jquery'), false, true);
            wp_localize_script( 'oak_critical_analysis', 'DATA', array (
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'adminUrl' => admin_url(),
                'principles' => get_option('oak_principles') ? get_option('oak_principles') : [],
                // 'baseData' => $base_data,
                'analyzes' => get_option('oak_analyzes') ? get_option('oak_analyzes') : []
            ));
        endif;

        if ( get_current_screen()->id == 'oak-materiality-reporting_page_oak_add_taxonomies' ) :
            $result_taxonomies = get_taxonomies(false, 'objects');
            $taxonomies = [];
            foreach( $result_taxonomies as $result_taxonomy ) : 
                $taxonomies[] = $result_taxonomy;
            endforeach;
            wp_enqueue_script( 'oak_add_taxonomies', get_template_directory_uri() . '/src/js/add-taxonomies.js', array('jquery'), false, true);
            wp_localize_script( 'oak_add_taxonomies', 'DATA', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'taxonomies' => $taxonomies
            ));
        endif;

        if ( get_current_screen()->id == 'oak-materiality-reporting_page_oak_add_object_model' ) :
            $post_types_data = get_post_types();
            $post_types = [];
            foreach ( $post_types_data as $key => $single_post_type ) :
                $post_types[] = $single_post_type;
            endforeach;
            wp_enqueue_script( 'oak_add_object_model', get_template_directory_uri() . '/src/js/add-object-model.js', array('jquery'), false, true);
            wp_localize_script( 'oak_add_object_model', 'DATA', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'customPostTypes' => $post_types
            ));
        endif;

        $fields_table_name = Oak::$fields_table_name;
        Oak::$fields = $wpdb->get_results ( "
            SELECT * 
            FROM  $fields_table_name
        " );

        if ( get_current_screen()->id == 'champs_page_oak_add_field' ) :
            $revisions = $this->oak_get_revisions();

            wp_enqueue_script( 'corn_add_field', get_template_directory_uri() . '/src/js/add-field.js', array('jquery'), false, true );
            wp_localize_script( 'corn_add_field', 'DATA', array(
                'ajaxUrl' => admin_url ('admin-ajax.php'),
                'fields' => Oak::$fields,
                'revisions' => $revisions,
                'adminUrl' => admin_url()
            ) );
        endif;

        if ( get_current_screen()->id == 'toplevel_page_oak_fields_list' ) :
            wp_enqueue_script( 'corn_fields_list', get_template_directory_uri() . '/src/js/fields-list.js', array('jquery'), false, true );
            wp_localize_script( 'corn_fields_list', 'DATA', array(
                'ajaxUrl' => admin_url( 'admin-ajax.php'),
                'adminUrl' => admin_url(),
                'fields' => Oak::$fields
            ) );
        endif;

        if ( get_current_screen()-> id == 'formes_page_oak_add_form' || get_current_screen()->id == 'toplevel_page_oak_forms_list' ) :
            $forms_table_name = Oak::$forms_table_name;
            Oak::$forms = $wpdb->get_results ( "
                SELECT * 
                FROM  $forms_table_name
            " );
        endif;

        if ( get_current_screen()->id == 'formes_page_oak_add_form' ) :
            $revisions = [];
            if ( isset( $_GET['form_identifier'] ) ) :
                foreach( Oak::$forms as $form ) :
                    if ( $form->form_identifier == $_GET['form_identifier'] ) :
                        $revisions[] = $form;
                    endif;
                endforeach;
            endif;

            wp_enqueue_script( 'corn_add_form', get_template_directory_uri() . '/src/js/add-form.js', array('jquery'), false, true );
            wp_localize_script( 'corn_add_form', 'DATA', array(
                'ajaxUrl' => admin_url ('admin-ajax.php'),
                'forms' => Oak::$forms,
                'fields' => Oak::$fields,
                'revisions' => $revisions,
                'adminUrl' => admin_url(),
                'templateDirectoryUri' => get_template_directory_uri()
            ) );
        endif;
    }
    
    function oak_add_theme_support() {
        add_theme_support('menus');
        include get_template_directory() . '/functions/tables.php';
    }

    function add_cors_http_header() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Origin: http://localhost:8888/boilerplate/');
    }

    function oak_add_options_page() {
        if( function_exists('acf_add_options_page') ) {
            acf_add_options_page( array(
                'page_title' => 'Options',
                'menu_title' => 'Options',
                'menu_slug' => 'options'
             ) );
        }
    }

    function oak_handle_admin_menu() {
        add_menu_page( 'OAK (Materiality Reporting)', 'OAK (Materiality Reporting)', 'manage_options', 'oak_materiality_reporting', array( $this, 'oak_materility_reporting' ), 'dashicons-chart-pie', 99 );

        add_submenu_page( 'oak_materiality_reporting', __( 'Ogranisations', Oak::$text_domain ), __( 'Ogranisations', Oak::$text_domain ), 'manage_options', 'edit.php?post_type=organization' );
        add_submenu_page( 'oak_materiality_reporting', __( 'Ajouter', Oak::$text_domain ), __( 'Ajouter', Oak::$text_domain ), 'manage_options', 'post-new.php?post_type=organization' );
        add_submenu_page( 'oak_materiality_reporting', __( 'Sécteurs d\'activité', Oak::$text_domain ), __( 'Sécteurs d\'activité', Oak::$text_domain ), 'manage_options', 'edit-tags.php?taxonomy=org_activity&post_type=organization' );

        add_submenu_page( 'oak_materiality_reporting', __( 'Publications', Oak::$text_domain ), __( 'Publications', Oak::$text_domain ), 'manage_options', 'edit.php?post_type=publication' );
        add_submenu_page( 'oak_materiality_reporting', __( 'Ajouter', Oak::$text_domain ), __( 'Ajouter', Oak::$text_domain ), 'manage_options', 'post-new.php?post_type=publication' );
        add_submenu_page( 'oak_materiality_reporting', __( 'Types de Publication', Oak::$text_domain ), __( 'Type de Publication', Oak::$text_domain ), 'manage_options', 'edit-tags.php?taxonomy=publication_type&post_type=publication' );

        add_submenu_page( 'oak_materiality_reporting', __( 'Résultats', Oak::$text_domain ), __( 'Résultats', Oak::$text_domain ), 'manage_options', 'edit.php?post_type=results' );

        add_submenu_page( 'oak_materiality_reporting', __( 'Élément d\'Information', Oak::$text_domain ), __( 'Élément d\'Information', Oak::$text_domain ), 'manage_options', 'edit.php?post_type=gri' );
        add_submenu_page( 'oak_materiality_reporting', __( 'Ajouter', Oak::$text_domain ), __( 'Ajouter', Oak::$text_domain ), 'manage_options', 'post-new.php?post_type=gri' );
        add_submenu_page( 'oak_materiality_reporting', __( 'Standards/Series', Oak::$text_domain ), __( 'Standards/Series', Oak::$text_domain ), 'manage_options', 'edit-tags.php?taxonomy=standards_series&post_type=gri' );

        add_submenu_page( 'oak_materiality_reporting', __( 'Indicateurs Quali', Oak::$text_domain ), __( 'Indicateurs Quali', Oak::$text_domain ), 'manage_options', 'edit.php?post_type=quali_indic' );
        add_submenu_page( 'oak_materiality_reporting', __( 'Ajouter', Oak::$text_domain ), __( 'Ajouter', Oak::$text_domain ), 'manage_options', 'post-new.php?post_type=quali_indic' );

        add_submenu_page( 'oak_materiality_reporting', __( 'Indicateurs Quanti', Oak::$text_domain ), __( 'Indicateurs Quanti', Oak::$text_domain ), 'manage_options', 'edit.php?post_type=quanti_indic' );
        add_submenu_page( 'oak_materiality_reporting', __( 'Ajouter', Oak::$text_domain ), __( 'Ajouter', Oak::$text_domain ), 'manage_options', 'post-new.php?post_type=quanti_indic' );
        add_submenu_page( 'oak_materiality_reporting', __( 'Types de Données', Oak::$text_domain ), __( 'Type de Données', Oak::$text_domain ), 'manage_options', 'edit-tags.php?taxonomy=value_type&post_type=quanti_indic' );

        add_submenu_page( 'oak_materiality_reporting', __( 'Glossaire', Oak::$text_domain ), __( 'Glossaire', Oak::$text_domain ), 'manage_options', 'edit.php?post_type=glossary' );

        add_submenu_page( 'oak_materiality_reporting', __('Analyse Critique', Oak::$text_domain), __('Analyse Critique', Oak::$text_domain), 'manage_options', 'oak_critical_analysis', array( $this, 'oak_critical_analysis') );
        add_submenu_page( 'oak_materiality_reporting', 'Modèle d\'analyse', 'Cofiguration', 'manage_options', 'oak_critical_analysis_configuration', array( $this, 'oak_critical_analysis_configuration') );
        
        add_submenu_page( 'oak_materiality_reporting', __('Modèle d\'Objet', Oak::$text_domain), __('Modèle d\'Objet', Oak::$text_domain), 'manage_options', 'oak_add_object_model', array( $this, 'oak_add_object_model') );
        add_submenu_page( 'oak_materiality_reporting', __('Taxonomie', Oak::$text_domain), __('Taxonomie', Oak::$text_domain), 'manage_options', 'oak_add_taxonomies', array( $this, 'oak_add_taxonomies') );

        add_submenu_page( 'oak_materiality_reporting', __('Importation', Oak::$text_domain), __('Importation', Oak::$text_domain), 'manage_options', 'oak_import_csv_files', array( $this, 'oak_import_csv_files') );

        add_menu_page( __( 'Champs', Oak::$text_domain ), 'Champs', 'manage_options', 'oak_fields_list', array ( $this, 'oak_fields_list'), 'dashicons-index-card', 100 );
        add_submenu_page( 'oak_fields_list', 'Ajouter un Champ', __( 'Ajouter un champ', Oak::$text_domain ), 'manage_options', 'oak_add_field',  array( $this, 'oak_add_field' ) );

        add_menu_page( __( 'Formes', Oak::$text_domain ), 'Formes', 'manage_options', 'oak_forms_list', array ( $this, 'oak_forms_list'), 'dashicons-index-card', 100 );
        add_submenu_page( 'oak_forms_list', 'Ajouter un formulaire', __( 'Ajouter un formulaire', Oak::$text_domain ), 'manage_options', 'oak_add_form',  array( $this, 'oak_add_form' ) );
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
        ?>
        <h1>Materiality Reporting</h1>
        <?php
    } 

    function oak_critical_analysis() {
        include get_template_directory() . '/template-parts/critical-analysis.php';
    }

    function oak_critical_analysis_configuration() {
        include get_template_directory() . '/template-parts/critical-analysis-configuration.php';
    }

    function oak_add_taxonomies() {
        include get_template_directory() . '/template-parts/taxonomies/add_taxonomy.php';
    }

    function oak_add_object_model() {
        include get_template_directory() . '/template-parts/objects/add-objects-model.php';
    }

    function oak_register_post_types() {
        register_post_type( 'organization', array(
            'labels' => array(
                'name' => 'Organisations',
                'singular_name' => 'Organisation',
                'add_new' => 'Ajouter',
                'add_new_item' => __('Ajouter une nouvelle Organisation', Oak::$text_domain),
                'edit_item' => 'Editer'
            ),
            'description' => 'Une organisation est un organisme émetteur/concepteur d’une ou plusieurs publication(s).', 
            'public' => true,
            'menu_position' => 101,
            'menu_icon' => 'dashicons-groups',
            'show_in_menu' => false
        ) );

        register_post_type( 'publication', array(
            'labels' => array(
                'name' => 'Publications', 
                'singular_name' => 'Publication',
                'add_new' => 'Ajouter',
                'add_new_item' => __('Ajouter une nouvelle Publication', Oak::$text_domain),
                'edit_item' => 'Editer'
            ), 
            'description' => 'Une publication est un texte, une norme, une loi, un cadre de référence (etc.) qui guide la rédaction d’un reporting, le structure et en uniformise les contenus.', 
            'public' => true,
            'menu_position' => 102,
            'menu_icon' => 'dashicons-welcome-add-page',
            'show_in_menu' => false
        ) );

        register_post_type( 'results', array(
            'labels' => array(
                'name' => __( 'Resultats', Oak::$text_domain ), 
                'singular_name' => __ ('Resultats', Oak::$text_domain ),
                'add_new' => 'Ajouter',
                'add_new_item' => __( 'Ajouter un nouveau Résultat', Oak::$text_domain ),
                'edit_item' => 'Editer'
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 103,
            'menu_icon' => 'dashicons-admin-site',
            'show_in_menu' => false
        ) );

        register_post_type( 'gri', array(
            'labels' => array(
                'name' => 'Éléments d\'Information', 
                'singular_name' => __( 'Élément d\'Information', Oak::$text_domain ),
                'add_new' => 'Ajouter',
                'add_new_item' => 'Ajouter un nouvel élément d\'Information',
                'edit_item' => 'Editer'
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 104,
            'menu_icon' => 'dashicons-video-alt',
            'show_in_menu' => false
        ) );

        $oak_cpts = get_option('oak_custom_post_types') ? get_option('oak_custom_post_types') : [];
        foreach( $oak_cpts as $cpt ) :
            if ( isset( $cpt ) ) : 
                $name = str_replace( '\\', '', $cpt['name'] );
                register_post_type( $cpt['slug'], array(
                    'labels' => array(
                        'name' => $name, 
                        'singular_name' => $cpt['singleName'],
                        'add_new' => 'Ajouter',
                        'add_new_item' => 'Ajouter',
                        'edit_item' => 'Editer'
                    ), 
                    'description' => $cpt['description'], 
                    'public' => true,
                    'menu_position' => 105,
                    'menu_icon' => $cpt['icon'],
                    // 'show_in_menu' => false
                ) );
            endif; 
        endforeach;

        register_post_type( 'quali_indic', array(
            'labels' => array(
                'name' => 'Indicateurs Qualitatifs', 
                'singular_name' => __( 'Indicateur Qualitatif', Oak::$text_domain ),
                'add_new' => 'Ajouter',
                'add_new_item' => __( 'Ajouter un nouvel Indicateur Qualitatif', Oak::$text_domain ),
                'edit_item' => 'Editer'
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 106,
            'menu_icon' => 'dashicons-admin-post',
            'show_in_menu' => false
        ) );

        register_post_type( 'quanti_indic', array(
            'labels' => array(
                'name' => 'Indicateurs Quantitatifs', 
                'singular_name' => __( 'Indicateur Quantitatif', Oak::$text_domain ),
                'add_new' => 'Ajouter',
                'add_new_item' => __( 'Ajouter un nouvel Indicateur Quantitatif', Oak::$text_domain),
                'edit_item' => 'Editer'
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 107,
            'menu_icon' => 'dashicons-admin-post',
            'show_in_menu' => false
        ) );

        register_post_type( 'glossary', array(
            'labels' => array(
                'name' => 'Gloassaire', 
                'singular_name' => 'Gloassaire',
                'add_new' => __('Ajouter', Oak::$text_domain ),
                'add_new_item' => __( 'Ajouter une nouvelle terminologie', Oak::$text_domain ),
                'edit_item' => __( 'Editer', Oak::$text_domain )
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 108,
            'menu_icon' => 'dashicons-welcome-write-blog',
            'show_in_menu' => false
        ) );
    }

    function oak_remove_post_type_editors() {
        remove_post_type_support( 'publication', 'editor' );
        remove_post_type_support( 'results', 'editor' );
        remove_post_type_support( 'organization', 'editor' );
        remove_post_type_support( 'quanti_indic', 'editor' );
        remove_post_type_support( 'quali_indic', 'editor' );
    }

    function oak_register_taxonomies() {
        register_taxonomy( 'org_activity', 'organization', array(
            'label' => 'Secteur d\'activité',
            'labels' => array(
                'name' => 'Secteurs d\'activité',
                'single_name' => 'Secteur d\'activité',
            ),
            'show_in_quick_edit' => false,
            'meta_box_cb' => false
        ) );

        register_taxonomy( 'publication_type', 'publication', array(
            'label' => 'Type',
            'labels' => array(
                'name' => 'Types',
                'single_name' => 'Type',
            ),
        ) );

        register_taxonomy( 'value_type', array ( 'quanti_indic' ), array(
            'label' => 'Type de Donnée',
            'labels' => array(
                'name' => 'Types de Donnée',
                'single_name' => 'Type de Donnée',
            )
        ) );

        register_taxonomy( 'standards_series', 'gri', array(
            'label' => 'Standards/Séries',
            'labels' => array(
                'name' => 'Standard ou Séries',
                'single_name' => 'Standards/Séries',
            )
        ) );

        $oak_taxonomies = get_option('oak_taxonomies') ? get_option('oak_taxonomies') : [];
        foreach( $oak_taxonomies as $taxonomy) :
            if ( isset( $taxonomy ) ) :
                register_taxonomy( $taxonomy['slug'], $taxonomy['objectModel'], array(
                    'label' => $taxonomy['name'],
                    'labels' => array(
                        'name' => $taxonomy['name'],
                        'single_name' => $taxonomy['singleName']
                    )
                ) );
            endif;
        endforeach;
    }

    function oak_add_custom_field_groups() {
        if ( !function_exists('acf_add_local_field_group') ) return;

        include get_template_directory() . '/functions/options.php';
        include get_template_directory() . '/functions/organizations.php';
        include get_template_directory() . '/functions/results.php';
        include get_template_directory() . '/functions/activities.php';
        include get_template_directory() . '/functions/regions.php';
        include get_template_directory() . '/functions/publications.php';
        include get_template_directory() . '/functions/quali-indics.php';
        include get_template_directory() . '/functions/quanti-indics.php';
        include get_template_directory() . '/functions/glossary.php';
        include get_template_directory() . '/functions/gri.php';
        include get_template_directory() . '/functions/standards-series.php';
        include get_template_directory() . '/functions/critical_analyzes.php';
        include get_template_directory() . '/functions/custom-taxes-fields.php';
        include get_template_directory() . '/functions/custom-post-types-fields.php';
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

    function oak_set_organizations_contacts( $field ) {
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

    function oak_get_countries() {
        $country_query_result = wp_remote_get( 'https://restcountries.eu/rest/v2/all' );
        $countries = json_decode( $country_query_result['body'] );
        return $countries;
    }

    function oak_set_countries( $field ) {
        $choices = $field['choices'];

        $countries = $this->oak_get_countries();
        foreach( $countries as $country ) :
            $choices[] = $country->name;
        endforeach;
    
        $field['choices'] = $choices;
        return $field;
    }

    function oak_set_languages( $field ) {
        $choices = $field['choices'];

        $countries = $this->oak_get_countries();

        foreach( $countries as $country ) :
            foreach( $country->languages as $language ) :
                if ( !in_array( $language->name, $choices ) )
                    $choices[] = $language->name;
            endforeach;
        endforeach;

        $field['choices'] = $choices;
 
        return $field;
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

    function oak_set_contacts_organizations( $post_id ) {
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
            if ( isset( $selected_contacts_indexes ) && is_array( $selected_contacts_indexes )) :
                foreach ( $selected_contacts_indexes as $selected_contact_index ) :
                    if ( isset( $contacts_object['choices'][ $selected_contact_index ] ) ) :
                        $selected_contact_name = $contacts_object['choices'][ $selected_contact_index ];
                        $selected_contacts[] = $selected_contact_name;
                    endif;
                endforeach;
            endif;

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
            'image' => $principles['0']['image']
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

    function oak_save_taxonomy() {
        $taxonomy = $_POST['data'];
        $oak_taxonomies = get_option( 'oak_taxonomies' ) ? get_option( 'oak_taxonomies' ) : [];
        $oak_taxonomies[] = $taxonomy;
        update_option( 'oak_taxonomies', $oak_taxonomies );
        wp_send_json_success( array(
            'taxonomy' => $taxonomy
        ) );
    }

    function oak_delete_taxonomy() {
        $taxonomy_name = $_POST['data'];
        $current_taxonomies = get_option('oak_taxonomies') ? get_option('oak_taxonomies') : [];
        $taxonomies = [];
        foreach( $current_taxonomies as $taxonomy ) :
            if ( $taxonomy['slug'] != $taxonomy_name) :
                $taxonomies[] = $taxonomy;
            endif;
        endforeach;
        update_option('oak_taxonomies', $taxonomies);
        wp_send_json_success();
    }

    function oak_save_cpt() {
        $cpt = $_POST['data'];
        $oak_cpts = get_option('oak_custom_post_types') ? get_option('oak_custom_post_types') : [];
        $oak_cpts[] = $cpt;
        update_option( 'oak_custom_post_types', $oak_cpts );
        wp_send_json_success();
    }

    function oak_delete_cpt() {
        $cpt_name = $_POST['data'];
        $current_cpts = get_option('oak_custom_post_types') ? get_option('oak_custom_post_types') : [];
        $cpts = [];
        foreach( $current_cpts as $cpt ) :
            if ( $cpt['slug'] != $cpt_name) :
                $cpts[] = $cpt;
            endif;
        endforeach;
        update_option('oak_custom_post_types', $cpts);
        wp_send_json_success();
    }

    function oak_import_csv_files() {
        include get_template_directory() . '/template-parts/import-csv-files/import-csv-files.php';
    }

    function oak_add_field() {
        $revisions = $this->oak_get_revisions();

        include get_template_directory() . '/template-parts/fields/add-field.php';
    }

    function oak_add_form() {
        $revisions = [];
        if ( isset( $_GET['form_identifier'] ) ) :
            foreach( Oak::$forms as $form ) :
                if ( $form->form_identifier == $_GET['form_identifier'] ) :
                    $revisions[] = $form;
                endif;
            endforeach;
        endif;

        include get_template_directory() . '/template-parts/forms/add-form.php';
    }

    function oak_fields_list() {
        global $wpdb;
        $fields_table_name = Oak::$fields_table_name;
        $fields = $wpdb->get_results ( "
            SELECT * 
            FROM  $fields_table_name
        " );
        include get_template_directory() . '/template-parts/fields/fields-list.php';
    }

    function oak_get_revisions() {
        $revisions = [];
        if ( isset( $_GET['field_identifier'] ) ) :
            foreach( Oak::$fields as $field ) :
                if ( $field->field_identifier == $_GET['field_identifier'] ) :
                    $revisions[] = $field;
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

    function oak_get_organizations() {
        $the_query = new WP_Query( array( 'post_type'=> 'organization' ) );
        $organizations = $the_query->posts;
        foreach ( $organizations as $organization ) :
            $organization->fields = get_fields($organization->ID);
        endforeach;
        
        $countries_details = $this->oak_get_countries();
        // $countries = [];
        $languages = [];
        foreach( $countries_details as $country_detail ) :
            // $countries[] = $country_detail->name;
            foreach( $country_detail->languages as $language ) :
                if ( !in_array( $language->name, $languages ) )
                    $languages[] = $language->name;
            endforeach;
        endforeach;


        wp_send_json_success( array(
            'organizations' => $the_query->posts,
            'languages' => $languages,
        ) );
    }

    function oak_register_field() {
        global $wpdb;

        $field = $_POST['data'];

        $result = $wpdb->insert(
            Oak::$fields_table_name, 
            array(
                'field_designation' => $field['designation'],
                'field_identifier' => $field['identifier'],
                'field_type' => $field['type'],
                'field_function' => $field['functionField'],
                'field_default_value' => $field['defaultValue'],
                'field_instructions' => $field['instructions'],
                'field_placeholder' => $field['placeholder'],
                'field_before' => $field['before'],
                'field_after' => $field['after'],
                'field_max_length' => $field['maxLength'],
                'field_selector' => $field['selector'],
                'field_state' => $field['state'],
                'field_modification_time' => date("Y-m-d H:i:s"),
                'field_trashed' => $field['trashed']
            )
        );

        wp_send_json_success();
    }

    function oak_register_form() {
        global $wpdb;

        $form = $_POST['data'];

        $result = $wpdb->insert(
            Oak::$forms_table_name, 
            array(
                'form_designation' => $form['designation'],
                'form_identifier' => $form['identifier'],
                'form_fields_identifiers' => $form['fieldsIdentifiers'],
                'form_selector' => $form['selector'],
                'form_state' => $form['state'],
                'form_modification_time' => date("Y-m-d H:i:s"),
                'form_trashed' => $form['trashed']
            )
        );

        wp_send_json_success();
    }

    function oak_delete_field() {
        $field_identifier = $_POST['data'];
        $fields = get_option('oak_custom_fields') ? get_option('oak_custom_fields') : [];
        foreach( $fields as $key => $field ) :
            if ( $field['identifier'] == $field_identifier ) :
                unset( $fields[ $key ] );
            endif;
        endforeach;
        update_option( 'oak_custom_fields', $fields);
        
        wp_send_json_success();
    }

    function oak_send_field_to_trash() {
        $field_to_trash;
        $field_identifier = $_POST['data'];
        $fields = get_option('oak_custom_fields') ? get_option('oak_custom_fields') : [];
        foreach( $fields as $key => $field ) :
            if ( $field['identifier'] == $field_identifier ) :
                $field_to_trash = $fields[ $key ];
                unset( $fields[ $key ] );
            endif;
        endforeach;
        update_option( 'oak_custom_fields', $fields);

        $fields_in_trash = get_option('oak_custom_fields_trash') ? get_option('oak_custom_fields_trash') : [];
        $fields_in_trash[] = $field_to_trash;
        update_option( 'oak_custom_fields_trash', $fields_in_trash );
        
        wp_send_json_success();
    }

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

}

$oak = new oak();

