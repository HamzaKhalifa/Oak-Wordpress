<?php
$charset_collate = Oak::$charset_collate;

$publishers_table_name = Oak::$publishers_table_name;
$publishers_sql = "CREATE TABLE $publishers_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    publisher_designation varchar(555) DEFAULT '' NOT NULL,
    publisher_identifier varchar(555) DEFAULT '' NOT NULL,
    publisher_selector varchar(555),
    publisher_locked varchar(555),
    publisher_trashed varchar(555),
    publisher_state varchar(555),
    publisher_modification_time datetime,
    publisher_content_language varchar(10) DEFAULT 'fr',
    publisher_url TEXT,
    publisher_synchronized TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $publishers_sql );