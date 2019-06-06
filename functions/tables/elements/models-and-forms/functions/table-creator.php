<?php
$charset_collate = Oak::$charset_collate;

$models_and_forms_table_name = Oak::$models_and_forms_table_name;
$models_and_forms_sql= "CREATE TABLE $models_and_forms_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    model_identifier varchar(555) DEFAULT '' NOT NULL,
    form_identifier varchar(555) DEFAULT '' NOT NULL,
    form_designation varchar(555),
    form_required varchar(555),
    form_index varchar(555),
    model_revision_number varchar(555),
    model_content_language TEXT,
    model_and_form_synchronized TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $models_and_forms_sql );