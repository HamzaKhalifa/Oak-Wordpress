<?php 
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$fields_table_name = Oak::$fields_table_name;
$fields_sql = "CREATE TABLE $fields_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    field_designation varchar(555) DEFAULT '' NOT NULL,
    field_identifier varchar(555) DEFAULT '' NOT NULL,
    field_selector varchar(555),
    field_locked varchar(555),
    field_trashed varchar(555),
    field_state varchar(555),
    field_modification_time datetime,
    field_type varchar(555),
    field_function varchar(555),
    field_tag varchar(555),
    field_help varchar(555),
    field_description varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $fields_sql );

$forms_table_name = Oak::$forms_table_name;
$forms_sql = "CREATE TABLE $forms_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    form_designation varchar(555) DEFAULT '' NOT NULL,
    form_identifier varchar(555) DEFAULT '' NOT NULL,
    form_selector varchar(555),
    form_locked varchar(555),
    form_trashed varchar(555),
    form_state varchar(555),
    form_modification_time datetime,
    form_revision_number varchar(555),
    form_structure varchar(555),
    form_attributes varchar(100),
    form_separators varchar(100),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $forms_sql );

$forms_and_fields_table_name = Oak::$forms_and_fields_table_name;
$forms_and_fields_sql= "CREATE TABLE $forms_and_fields_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    form_and_field_identifier varchar(555) DEFAULT '' NOT NULL,
    form_identifier varchar(555) DEFAULT '' NOT NULL,
    field_identifier varchar(555) DEFAULT '' NOT NULL,
    field_designation varchar(555),
    field_required varchar(555),
    field_index varchar(555),
    form_revision_number varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $forms_and_fields_sql );

$models_table_name = Oak::$models_table_name;
$models_sql = "CREATE TABLE $models_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    model_designation varchar(555) DEFAULT '' NOT NULL,
    model_identifier varchar(555) DEFAULT '' NOT NULL,
    model_selector varchar(555),
    model_locked varchar(555),
    model_trashed varchar(555),
    model_state varchar(555),
    model_modification_time datetime,
    model_revision_number varchar(555),
    model_types varchar(555),
    model_publications_categories varchar(555),
    model_separators varchar(100),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $models_sql );

$models_and_forms_table_name = Oak::$models_and_forms_table_name;
$models_and_forms_sql= "CREATE TABLE $models_and_forms_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    model_identifier varchar(555) DEFAULT '' NOT NULL,
    form_identifier varchar(555) DEFAULT '' NOT NULL,
    form_designation varchar(555),
    form_required varchar(555),
    form_index varchar(555),
    model_revision_number varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $models_and_forms_sql );


$taxonomies_table_name = Oak::$taxonomies_table_name;
$taxonomies_sql = "CREATE TABLE $taxonomies_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    taxonomy_designation varchar(555) DEFAULT '' NOT NULL,
    taxonomy_identifier varchar(555) DEFAULT '' NOT NULL,
    taxonomy_selector varchar(555),
    taxonomy_locked varchar(555),
    taxonomy_trashed varchar(555),
    taxonomy_state varchar(555),
    taxonomy_modification_time datetime,
    taxonomy_description varchar(555),
    taxonomy_structure varchar(555),
    taxonomy_numerotation varchar(555),
    taxonomy_title varchar(555),
    taxonomy_term_description varchar(555),
    taxonomy_color varchar(555),
    taxonomy_brand varchar(555),
    taxonomy_publication varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $taxonomies_sql );

$organizations_table_name = Oak::$organizations_table_name;
$organizations_sql = "CREATE TABLE $organizations_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    organization_designation varchar(555) DEFAULT '' NOT NULL,
    organization_identifier varchar(555) DEFAULT '' NOT NULL,
    organization_selector varchar(555),
    organization_locked varchar(555),
    organization_trashed varchar(555),
    organization_state varchar(555),
    organization_modification_time datetime,
    organization_acronym varchar(555),
    organization_logo varchar(555),
    organization_description varchar(555),
    organization_url varchar(555),
    organization_address varchar(555),
    organization_country varchar(555),
    organization_company varchar(555),
    organization_type varchar(555),
    organization_side varchar(555),
    organization_sectors varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $organizations_sql );

$publications_table_name = Oak::$publications_table_name;
$publications_sql = "CREATE TABLE $publications_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    publication_designation varchar(555) DEFAULT '' NOT NULL,
    publication_identifier varchar(555) DEFAULT '' NOT NULL,
    publication_selector varchar(555),
    publication_locked varchar(555),
    publication_trashed varchar(555),
    publication_state varchar(555),
    publication_modification_time datetime,
    publication_organization varchar(555),
    publication_year varchar(555),
    publication_headpiece varchar(555),
    publication_format varchar(555),
    publication_file varchar(555),
    publication_description varchar(555),
    publication_report_or_frame varchar(555),
    publication_local varchar(555),
    publication_country varchar(555),
    publication_report_type varchar(555),
    publication_frame_type varchar(555),
    publication_sectorial_frame varchar(555),
    publication_sectors varchar(555),
    publication_language varchar(555),
    publication_gri_type varchar(555),
    publication_sectorial_supplement varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $publications_sql );

$glossaries_table_name = Oak::$glossaries_table_name;
$glossaries_sql = "CREATE TABLE $glossaries_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    glossary_designation varchar(555) DEFAULT '' NOT NULL,
    glossary_identifier varchar(555) DEFAULT '' NOT NULL,
    glossary_selector varchar(555),
    glossary_locked varchar(555),
    glossary_trashed varchar(555),
    glossary_state varchar(555),
    glossary_modification_time datetime,
    glossary_publication varchar(555),
    glossary_object varchar(555),
    glossary_depends varchar(555),
    glossary_parent varchar(555),
    glossary_definition varchar(555),
    glossary_close varchar(555),
    glossary_close_indicators varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $glossaries_sql );

$qualis_table_name = Oak::$qualis_table_name;
$qualis_sql = "CREATE TABLE $qualis_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    quali_designation varchar(555) DEFAULT '' NOT NULL,
    quali_identifier varchar(555) DEFAULT '' NOT NULL,
    quali_selector varchar(555),
    quali_locked varchar(555),
    quali_trashed varchar(555),
    quali_state varchar(555),
    quali_modification_time datetime,
    quali_publication varchar(555),
    quali_object varchar(555),
    quali_depends varchar(555),
    quali_parent varchar(555),
    quali_numerotation_type varchar(555),
    quali_numerotation varchar(555),
    quali_description varchar(555),
    quali_close varchar(555),
    quali_close_indicators varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $qualis_sql );

$quantis_table_name = Oak::$quantis_table_name;
$quantis_sql = "CREATE TABLE $quantis_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    quanti_designation varchar(555) DEFAULT '' NOT NULL,
    quanti_identifier varchar(555) DEFAULT '' NOT NULL,
    quanti_selector varchar(555),
    quanti_locked varchar(555),
    quanti_trashed varchar(555),
    quanti_state varchar(555),
    quanti_modification_time datetime,
    quanti_publication varchar(555),
    quanti_object varchar(555),
    quanti_depends varchar(555),
    quanti_parent varchar(555),
    quanti_numerotation_type varchar(555),
    quanti_numerotation varchar(555),
    quanti_description varchar(555),
    quanti_close varchar(555),
    quanti_close_indicators varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $quantis_sql );

$terms_and_objects_table_name = Oak::$terms_and_objects_table_name;
$terms_and_objects_sql= "CREATE TABLE $terms_and_objects_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    term_identifier varchar(555) DEFAULT '' NOT NULL,
    object_identifier varchar(555) DEFAULT '' NOT NULL,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $terms_and_objects_sql );

// Done creating tables. Now getting data from tables. 

$fields_table_name = Oak::$fields_table_name;
Oak::$fields = $wpdb->get_results ( "
    SELECT * 
    FROM  $fields_table_name
" );
$reversed_fields = array_reverse( Oak::$fields );
$fields_without_redundancy = [];
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
Oak::$fields_without_redundancy = $fields_without_redundancy;

$forms_table_name = Oak::$forms_table_name;
Oak::$forms = $wpdb->get_results ( "
    SELECT * 
    FROM  $forms_table_name
" );
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

    // For form attributes:
    $form_attributes_Array = explode( ',', $form->form_attributes );
    foreach( $form_attributes_Array as $attribute ) :
        $exists = false;
        foreach( Oak::$forms_attributes as $oak_attribute ) :
            if ( $oak_attribute == $attribute || $attribute == '' )
                $exists = true;
        endforeach;
        if ( !$exists ) :
            Oak::$forms_attributes[] = $attribute;
        endif;
    endforeach;
endforeach;
Oak::$forms_without_redundancy = $forms_without_redundancy;

$forms_and_fields_table_name = Oak::$forms_and_fields_table_name;
Oak::$all_forms_and_fields = $wpdb->get_results ( "
    SELECT * 
    FROM  $forms_and_fields_table_name
" );

$models_and_forms_table_name = Oak::$models_and_forms_table_name;
Oak::$all_models_and_forms = $wpdb->get_results ( "
    SELECT * 
    FROM  $models_and_forms_table_name
" );

$publications_table_name = Oak::$publications_table_name;
Oak::$publications = $wpdb->get_results ( "
    SELECT * 
    FROM  $publications_table_name
" );
$reversed_publications = array_reverse( Oak::$publications );
$publications_without_redundancy = [];
foreach( $reversed_publications as $publication ) :
    $added = false;
    foreach( $publications_without_redundancy as $publication_without_redundancy ) :
        if ( $publication_without_redundancy->publication_identifier == $publication->publication_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $publications_without_redundancy[] = $publication;
    endif;

    if ( $publication->publication_report_or_frame == 'frame' ) :
        Oak::$frame_publications_identifiers[] = $publication->publication_identifier;
    endif;

endforeach;
Oak::$publications_without_redundancy = $publications_without_redundancy;

$organizations_table_name = Oak::$organizations_table_name;
Oak::$organizations = $wpdb->get_results ( "
    SELECT * 
    FROM  $organizations_table_name
" );
$reversed_organizations = array_reverse( Oak::$organizations );
$organizations_without_redundancy = [];
foreach( $reversed_organizations as $organization ) :
    $added = false;
    foreach( $organizations_without_redundancy as $organization_without_redundancy ) :
        if ( $organization_without_redundancy->organization_identifier == $organization->organization_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $organizations_without_redundancy[] = $organization;
    endif;
endforeach;
Oak::$organizations_without_redundancy = $organizations_without_redundancy;

$quantis_table_name = Oak::$quantis_table_name;
Oak::$quantis = $wpdb->get_results ( "
    SELECT * 
    FROM  $quantis_table_name
" );
$reversed_quantis = array_reverse( Oak::$quantis );
$quantis_without_redundancy = [];
foreach( $reversed_quantis as $quanti ) :
    $added = false;
    foreach( $quantis_without_redundancy as $quanti_without_redundancy ) :
        if ( $quanti_without_redundancy->quanti_identifier == $quanti->quanti_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $quantis_without_redundancy[] = $quanti;
    endif;
endforeach;
Oak::$quantis_without_redundancy = $quantis_without_redundancy;

$qualis_table_name = Oak::$qualis_table_name;
Oak::$qualis = $wpdb->get_results ( "
    SELECT * 
    FROM  $qualis_table_name
" );
$reversed_qualis = array_reverse( Oak::$qualis );
$qualis_without_redundancy = [];
foreach( $reversed_qualis as $quali ) :
    $added = false;
    foreach( $qualis_without_redundancy as $quali_without_redundancy ) :
        if ( $quali_without_redundancy->quali_identifier == $quali->quali_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $qualis_without_redundancy[] = $quali;
    endif;
endforeach;
Oak::$qualis_without_redundancy = $qualis_without_redundancy;

$glossaries_table_name = Oak::$glossaries_table_name;
Oak::$glossaries = $wpdb->get_results ( "
    SELECT * 
    FROM  $glossaries_table_name
" );
$reversed_glossaries = array_reverse( Oak::$glossaries );
$glossaries_without_redundancy = [];
foreach( $reversed_glossaries as $glossary ) :
    $added = false;
    foreach( $glossaries_without_redundancy as $glossary_without_redundancy ) :
        if ( $glossary_without_redundancy->glossary_identifier == $glossary->glossary_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $glossaries_without_redundancy[] = $glossary;
    endif;
endforeach;
Oak::$glossaries_without_redundancy = $glossaries_without_redundancy;

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

// Lets get the fields that are gonna be in the table
foreach( $models_without_redundancy as $key => $model ) :
    $model_fields = [];
    foreach( Oak::$all_models_and_forms as $model_and_form_instance ) :
        if ( $model_and_form_instance->model_identifier == $model->model_identifier 
            && $model_and_form_instance->model_revision_number == $model->model_revision_number 
        ) :
            $form_identifier = $model_and_form_instance->form_identifier;
            foreach( $forms_without_redundancy as $form ) :
                if ( $form->form_identifier == $form_identifier ) :
                    foreach ( Oak::$all_forms_and_fields as $form_and_field_instance ) :
                        if ( $form_and_field_instance->form_identifier == $form->form_identifier 
                            && $form_and_field_instance->form_revision_number == $form->form_revision_number 
                        ) :
                            foreach( $fields_without_redundancy as $field ) :
                                if ( $field->field_identifier == $form_and_field_instance->field_identifier ) :
                                    $field_copy = clone $field;
                                    $field_copy->form_and_field_properties = $form_and_field_instance;
                                    $field_copy->model_and_form_instance = $model_and_form_instance;
                                    $field_copy->form = $form;
                                    if ( isset( $_GET['model_identifier'] ) ) :
                                        if ( $model->model_identifier == $_GET['model_identifier'] ) :
                                            array_push( Oak::$current_model_fields, $field_copy );
                                        endif;
                                    endif;
                                    array_push( $model_fields, $field_copy );
                                endif;
                            endforeach;
                        endif;
                    endforeach;
                endif;
            endforeach;
        endif;
    endforeach;


    $table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
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
        $column_name = 'object_' . $key . '_' . $field->field_identifier;
        $columns = $wpdb->get_results( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'" );
        $exists = false;
        foreach( $columns as $column ) :
            if ( $column->COLUMN_NAME == $column_name ) :
                $exists = true;
            endif;
        endforeach;

        if ( !$exists ) {
            $wpdb->query("ALTER TABLE $table_name ADD $column_name varchar(555)");
        }
    endforeach;

endforeach;

// To get all objects associated to all models
foreach( Oak::$models as $model ) :
    $table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
    $model_objects = $wpdb->get_results ( "
        SELECT * 
        FROM $table_name
    " );

    foreach( $model_objects as $object ) :
        $object->object_model_identifier = $model->model_identifier;
    endforeach;

    Oak::$all_objects = array_merge( Oak::$all_objects, $model_objects );
endforeach;

// For taxonomies
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

foreach( $taxonomies_without_redundancy as $taxonomy ) :
    $table_name = $wpdb->prefix . 'oak_taxonomy_' . $taxonomy->taxonomy_identifier;
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

    // lets get all the terms: 
    $terms = $wpdb->get_results( "
        SELECT *
        FROM $table_name
    ");
    $terms = array_reverse( $terms );
    foreach( $terms as $term ) :
        $term->term_taxonomy_identifier = $taxonomy->taxonomy_identifier;
        $added = false;
        foreach( Oak::$all_terms_without_redundancy as $added_term ) :
            if ( $added_term->term_identifier == $term->term_identifier ) :
                $added = true;
            endif;
        endforeach;
        if ( !$added ) :
            Oak::$all_terms_without_redundancy[] = $term;

            if ( in_array( $taxonomy->taxonomy_publication, Oak::$frame_publications_identifiers ) ) :
                Oak::$frame_terms_identifiers[] = $term->term_identifier;
            endif;

        endif;
    endforeach;

    Oak::$all_terms = array_merge( Oak::$all_terms, $terms );
endforeach;

$objects_reversed = array_reverse( Oak::$all_objects );
foreach( $objects_reversed as $object ) :
    $exists = false;
    foreach( Oak::$all_objects_without_redundancy as $object_without_redundancy) :
        if ( $object_without_redundancy->object_identifier == $object->object_identifier ) 
            $exists = true;
    endforeach;
    if ( !$exists )
        Oak::$all_objects_without_redundancy[] = $object;
endforeach;

$terms_and_objects_table_name = Oak::$terms_and_objects_table_name;
Oak::$terms_and_objects = $wpdb->get_results ( "
    SELECT * 
    FROM $terms_and_objects_table_name
" );

// To get all frame objects
// var_dump( Oak::$all_objects_without_redundancy );
foreach( Oak::$all_objects_without_redundancy as $object ) :
    foreach( Oak::$terms_and_objects as $term_and_object ) :
        if ( $term_and_object->object_identifier == $object->object_identifier ) :
            $term_identifier = $term_and_object->term_identifier;
            if ( in_array( $term_identifier, Oak::$frame_terms_identifiers ) ) :
                // Check if the object has already been added: 
                $exists = false;
                foreach( Oak::$all_frame_objects_without_redundancy as $frame_object ) :
                    if ( $frame_object->object_identifier == $object->object_identifier ) :
                        $exists = true;
                    endif;
                endforeach;
                if ( !$exists ) :
                    Oak::$all_frame_objects_without_redundancy[] = $object;
                endif;
            endif;
        endif;
    endforeach;
endforeach;




