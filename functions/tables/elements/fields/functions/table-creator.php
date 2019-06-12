<?php
$charset_collate = Oak::$charset_collate;

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
    field_content_language varchar(10) DEFAULT 'fr',
    field_type varchar(555),
    field_function varchar(555),
    field_tag varchar(555),
    field_help varchar(555),
    field_description LONGTEXT,
    field_selector_options varchar(555),
    field_publication TEXT,
    field_synchronized TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $fields_sql );