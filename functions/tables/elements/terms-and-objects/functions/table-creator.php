<?php
$charset_collate = Oak::$charset_collate;

$terms_and_objects_table_name = Oak::$terms_and_objects_table_name;
$terms_and_objects_sql= "CREATE TABLE $terms_and_objects_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    term_identifier varchar(555) DEFAULT '' NOT NULL,
    object_identifier varchar(555) DEFAULT '' NOT NULL,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $terms_and_objects_sql );