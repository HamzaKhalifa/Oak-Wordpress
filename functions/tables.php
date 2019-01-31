<?php 
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

$fields_table_name = Oak::$fields_table_name;
$fields_sql = "CREATE TABLE $fields_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    field_designation varchar(55) DEFAULT '' NOT NULL,
    field_identifier varchar(55) DEFAULT '' NOT NULL,
    field_type varchar(55),
    field_function varchar(55),
    field_default_value varchar(55),
    field_instructions varchar(55),
    field_placeholder varchar(55),
    field_before varchar(55),
    field_after varchar(55),
    field_max_length varchar(55),
    field_selector varchar(55),
    field_state varchar(55),
    field_modification_time datetime,
    field_trashed varchar(55),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $fields_sql );

$forms_table_name = Oak::$forms_table_name;
$forms_sql = "CREATE TABLE $forms_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    form_designation varchar(55) DEFAULT '' NOT NULL,
    form_identifier varchar(55) DEFAULT '' NOT NULL,
    form_fields varchar(555),
    form_selector varchar(55),
    form_state varchar(55),
    form_modification_time datetime,
    form_trashed varchar(55),
    form_structure varchar(55),
    form_attributes varchar(100),
    form_separators varchar(100),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $forms_sql );

$models_table_name = Oak::$models_table_name;
$models_sql = "CREATE TABLE $models_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    model_designation varchar(55) DEFAULT '' NOT NULL,
    model_identifier varchar(55) DEFAULT '' NOT NULL,
    model_types varchar(55),
    model_publications_categories varchar(555),
    model_selector varchar(55),
    model_forms varchar (555),
    model_separators varchar(100),
    model_state varchar(55),
    model_trashed varchar(55),
    model_modification_time datetime,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $models_sql );

$taxonomies_table_name = Oak::$taxonomies_table_name;
$taxonomies_sql = "CREATE TABLE $taxonomies_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    taxonomy_designation varchar(55) DEFAULT '' NOT NULL,
    taxonomy_identifier varchar(55) DEFAULT '' NOT NULL,
    taxonomy_description varchar(555),
    taxonomy_structure varchar(55),
    taxonomy_numerotation varchar(55),
    taxonomy_title varchar(55),
    taxonomy_term_description varchar(55),
    taxonomy_color varchar(55),
    taxonomy_logo varchar(55),
    taxonomy_publication varchar(55),
    taxonomy_state varchar(55),
    taxonomy_trashed varchar(55),
    taxonomy_modification_time datetime,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $taxonomies_sql );

$organizations_table_name = Oak::$organizations_table_name;
$organizations_sql = "CREATE TABLE $organizations_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    organization_designation varchar(55) DEFAULT '' NOT NULL,
    organization_identifier varchar(55) DEFAULT '' NOT NULL,
    organization_acronym varchar(55),
    organization_logo varchar(555),
    organization_description varchar(555),
    organization_url varchar(55),
    organization_address varchar(55),
    organization_country varchar(55),
    organization_company varchar(55),
    organization_type varchar(55),
    organization_side varchar(55),
    organization_sectors varchar(555),
    organization_state varchar(55),
    organization_trashed varchar(55),
    organization_modification_time datetime,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $organizations_sql );

$publications_table_name = Oak::$publications_table_name;
$publications_sql = "CREATE TABLE $publications_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    publication_designation varchar(55) DEFAULT '' NOT NULL,
    publication_identifier varchar(55) DEFAULT '' NOT NULL,
    publication_organization varchar(55),
    publication_year varchar(55),
    publication_headpiece varchar(555),
    publication_format varchar(555),
    publication_file varchar(555),
    publication_description varchar(555),
    publication_report_or_frame varchar(555),
    publication_local varchar(55),
    publication_country varchar(55),
    publication_report_type varchar(55),
    publication_frame_type varchar(55),
    publication_sectorial_frame varchar(55),
    publication_sectors varchar(55),
    publication_language varchar(55),
    publication_gri_type varchar(55),
    publication_sectorial_supplement varchar(55),
    publication_state varchar(55),
    publication_trashed varchar(55),
    publication_modification_time datetime,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $publications_sql );

$glossaries_table_name = Oak::$glossaries_table_name;
$glossaries_sql = "CREATE TABLE $glossaries_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    glossary_designation varchar(55) DEFAULT '' NOT NULL,
    glossary_identifier varchar(55) DEFAULT '' NOT NULL,
    glossary_publication varchar(55),
    glossary_object varchar(55),
    glossary_depends varchar(55),
    glossary_parent varchar(555),
    glossary_definition varchar(555),
    glossary_close varchar(55),
    glossary_close_indicators varchar(55),
    glossary_state varchar(55),
    glossary_trashed varchar(55),
    glossary_modification_time datetime,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $glossaries_sql );

$qualis_table_name = Oak::$qualis_table_name;
$qualis_sql = "CREATE TABLE $qualis_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    quali_designation varchar(55) DEFAULT '' NOT NULL,
    quali_identifier varchar(55) DEFAULT '' NOT NULL,
    quali_publication varchar(55),
    quali_object varchar(55),
    quali_depends varchar(55),
    quali_parent varchar(555),
    quali_numerotation_type varchar(55),
    quali_numerotation varchar(55),
    quali_description varchar(555),
    quali_close varchar(55),
    quali_close_indicators varchar(55),
    quali_state varchar(55),
    quali_trashed varchar(55),
    quali_modification_time datetime,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $qualis_sql );

$quantis_table_name = Oak::$quantis_table_name;
$quantis_sql = "CREATE TABLE $quantis_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    quanti_designation varchar(55) DEFAULT '' NOT NULL,
    quanti_identifier varchar(55) DEFAULT '' NOT NULL,
    quanti_publication varchar(55),
    quanti_object varchar(55),
    quanti_depends varchar(55),
    quanti_parent varchar(555),
    quanti_numerotation_type varchar(55),
    quanti_numerotation varchar(55),
    quanti_description varchar(555),
    quanti_close varchar(55),
    quanti_close_indicators varchar(55),
    quanti_state varchar(55),
    quanti_trashed varchar(55),
    quanti_modification_time datetime,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $quantis_sql );

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
endforeach;
Oak::$forms_without_redundancy = $forms_without_redundancy;


$models_table_name = Oak::$models_table_name;
Oak::$models = $wpdb->get_results ( "
    SELECT * 
    FROM  $models_table_name
" );
$reversed_models = array_reverse( Oak::$models );
$models_without_redundancy = [];
foreach( Oak::$models as $model ) :
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
endforeach;
Oak::$publications_without_redundancy = $publications_without_redundancy;

// Lets get the fields that are gonna be in the table
foreach( $models_without_redundancy as $key => $model ) :
    $tables_fields = [];
    $table_name = $wpdb->prefix . 'oak_' . $model->model_identifier;
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

    $models_sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        object_designation varchar(55) DEFAULT '' NOT NULL,
        object_identifier varchar(55) DEFAULT '' NOT NULL,
        object_state varchar(55),
        object_trashed varchar(55),
        object_modification_time datetime,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $models_sql );

    foreach( $tables_fields as $key => $field ) :
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
        term_designation varchar(55) DEFAULT '' NOT NULL,
        term_identifier varchar(55) DEFAULT '' NOT NULL,
        term_numerotation varchar(55),
        term_title varchar(55),
        term_description varchar(55),
        term_color varchar(55),
        term_logo varchar(555),
        term_state varchar(55),
        term_trashed varchar(55),
        term_modification_time datetime,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $terms_sql );
endforeach;

