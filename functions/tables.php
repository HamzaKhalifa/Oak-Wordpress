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
    field_trashed boolean,
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
    form_trashed boolean,
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
    model_trashed boolean,
    model_modification_time datetime,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $models_sql );

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
    organization_company boolean,
    organization_type varchar(55),
    organization_side boolean,
    organization_sectors varchar(555),
    organization_state varchar(55),
    organization_trashed boolean,
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
    publication_local boolean,
    publication_country varchar(55),
    publication_report_type varchar(55),
    publication_frame_type varchar(55),
    publication_sectorial_frame boolean,
    publication_sectors varchar(55),
    publication_language varchar(55),
    publication_gri_type varchar(55),
    publication_sectorial_supplement varchar(55),
    publication_state varchar(55),
    publication_trashed boolean,
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
    glossary_depends boolean,
    glossary_parent varchar(555),
    glossary_definition varchar(555),
    glossary_close varchar(55),
    glossary_close_indicators varchar(55),
    glossary_state varchar(55),
    glossary_trashed boolean,
    glossary_modification_time datetime,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $glossaries_sql );
