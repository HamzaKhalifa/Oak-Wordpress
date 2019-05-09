<?php
$charset_collate = Oak::$charset_collate;

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
    model_content_language varchar(10) DEFAULT 'fr',
    model_types varchar(555),
    model_publications_categories varchar(555),
    model_separators varchar(100),
    model_fields_names LONGTEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $models_sql );