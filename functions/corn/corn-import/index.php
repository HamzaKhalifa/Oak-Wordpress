<?php

class Corn_Import {
    function __construct() {
        add_action( 'admin_menu', array( $this, 'oak_handle_admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        $this->handle_ajax_calls();
    }

    function oak_handle_admin_menu() {
        add_menu_page( 'Importation des données', 'Importation des données', 'manage_options', 'oak_import_page', array( $this, 'oak_import_page' ), 'dashicons-chart-pie', 100 );
    }

    function oak_import_page() {
        include get_template_directory() . '/functions/corn/corn-import/views/import-page.php';
    }

    function admin_enqueue_scripts() {
        // Corn import page
        $corn = get_option( 'oak_corn' ) != false ? get_option('oak_corn') : true;
        $central_url = get_option( 'oak_central_url' ) != false ? get_option('oak_central_url') : true;
        if ( get_current_screen()->id == 'toplevel_page_oak_import_page' ) :
            wp_enqueue_script( 'oak_import_script', get_template_directory_uri() . '/functions/corn/corn-import/src/js/import-page.js', array('jquery'), false, true );
            wp_localize_script( 'oak_import_script', 'DATA', array(
                'corn' => get_option('oak_corn'),
                'centralUrl' => $central_url,
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            ) );
        endif;
    }

    function handle_ajax_calls() {
        add_action('wp_ajax_oak_get_all_data_for_corn', array( $this, 'oak_get_all_data_for_corn') );
        add_action('wp_ajax_nopriv_oak_get_all_data_for_corn', array( $this, 'oak_get_all_data_for_corn') );

        add_action('wp_ajax_corn_save_data', array( $this, 'corn_save_data') );
        add_action('wp_ajax_nopriv_corn_save_data', array( $this, 'corn_save_data') );
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

    function get_all_images() {
        $query_images_args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => - 1,
        );

        $query_images = new WP_Query( $query_images_args );

        return $query_images;
    }

    function corn_save_data() {
        update_option( 'oak_corn_found_images', [] );
        
        global $wpdb;

        Oak::$all_images = $this->get_all_images()->posts;

        Oak::delete_everything();

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
                object_synchronized TEXT,
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

        $this->delete_images_that_are_not_needed();

        wp_send_json_success();
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

            $element[ $key ] = Oak::oak_filter_word( $the_value );
        endforeach;

        $result = $wpdb->insert(
            $table_name,
            $element
        );
    }


    function delete_images_that_are_not_needed() {
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
        update_option( 'oak_corn_found_images', [] );
    }
}

$corn_import = new Corn_Import();
