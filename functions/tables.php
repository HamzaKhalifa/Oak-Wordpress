<?php 
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

$table_name = Oak::$fields_table_name;
$sql = "CREATE TABLE $table_name (
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
dbDelta( $sql );

