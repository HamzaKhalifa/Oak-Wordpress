<?php 
$charset_collate = Oak::$charset_collate;

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
    form_and_fiel_synchronized TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $forms_and_fields_sql );