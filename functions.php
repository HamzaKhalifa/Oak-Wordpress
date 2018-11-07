<?php 

class Dawn {
    function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'dawn_enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'dawn_enqueue_scripts' ) );

        add_action( 'after_setup_theme', array( $this, 'dawn_add_theme_support' ) );

        add_action( 'init', array( $this, 'dawn_register_post_types') );
        add_action( 'init', array( $this, 'dawn_register_taxonomies') );
        add_action( 'init', array( $this, 'dawn_add_options_page'));

        add_action( 'acf/init', array( $this, 'dawn_add_custom_field_groups') );

        add_filter('acf/load_field/name=list_of_disclosures', array( $this, 'dawn_link_disclosures' ) );

        $this->dawn_contact_form();

    }

    function dawn_enqueue_styles() {
        wp_enqueue_style( 'the_style', get_stylesheet_directory_uri() . '/style.css' );
    }

    function dawn_enqueue_scripts() {
    }

    function dawn_add_theme_support() {
        add_theme_support( 'menus' );
    }

    function dawn_add_options_page() {
        if( function_exists('acf_add_options_page') ) {
            acf_add_options_page();
        }
    }

    function dawn_link_disclosures( $field ) {
        $disclosures = get_field( 'disclosures', 'option' );

        $choices = [];
        foreach( $disclosures as $disclosure ) {
            $choices []= $disclosure['name'];
        }

        $field['choices'] = $choices;

        return $field;
    }

    function dawn_register_post_types() {
        register_post_type( 'organization', array(
            'labels' => array(
                'name' => 'Organisations',
                'singular_name' => 'Organisation',
                'add_new' => 'Ajouter',
                'add_new_item' => 'Ajouter une nouvelle Organisation',
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
                'add_new_item' => 'Ajouter une nouvelle Publication',
                'edit_item' => 'Editer'
            ), 
            'description' => 'Une publication est un texte, une norme, une loi, un cadre de référence (etc.) qui guide la rédaction d’un reporting, le structure et en uniformise les contenus.', 
            'public' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-welcome-add-page',
        ) );

        register_post_type( 'country', array(
            'labels' => array(
                'name' => 'Pays', 
                'singular_name' => 'Pays',
                'add_new' => 'Ajouter',
                'add_new_item' => 'Ajouter un nouveau Pays',
                'edit_item' => 'Editer'
            ), 
            'description' => '', 
            'public' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-admin-site',
        ) );

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

    function dawn_register_taxonomies() {
        register_taxonomy( 'org_size', 'organization', array(
            'label' => 'Taille de l\'organisation',
            'labels' => array(
                'name' => 'Tailles',
                'single_name' => 'Taille de l\'Organisation',
            )
        ) );

        register_taxonomy( 'org_type', 'organization', array(
            'label' => 'Type de l\'organisation',
            'labels' => array(
                'name' => 'Types',
                'single_name' => 'Type de l\'Organisation',
            )
        ) );


        register_taxonomy( 'org_activity', 'organization', array(
            'label' => 'Secteur d\'activité',
            'labels' => array(
                'name' => 'Secteurs d\'activité',
                'single_name' => 'Secteur d\'activité',
            )
        ) );

        register_taxonomy( 'langue', 'country', array(
            'label' => 'langue',
            'labels' => array(
                'name' => 'Langues',
                'single_name' => 'Langue',
            )
        ) );

        register_taxonomy( 'region', 'country', array(
            'label' => 'Régions',
            'labels' => array(
                'name' => 'Régions',
                'single_name' => 'Régions',
            )
        ) );

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

        include get_template_directory() . '/functions/organizations.php';
        include get_template_directory() . '/functions/org-sizes.php';
        include get_template_directory() . '/functions/activities.php';
        include get_template_directory() . '/functions/countries.php';
        include get_template_directory() . '/functions/regions.php';
        include get_template_directory() . '/functions/publications.php';
        include get_template_directory() . '/functions/quali-indics.php';
        include get_template_directory() . '/functions/quanti-indics.php';
        include get_template_directory() . '/functions/glossary.php';
        include get_template_directory() . '/functions/gri.php';
        include get_template_directory() . '/functions/standards-series.php';
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
}

$dawn = new Dawn();

