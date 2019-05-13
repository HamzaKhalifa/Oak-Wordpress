<?php
$charset_collate = Oak::$charset_collate;

$graphs_table_name = Oak::$graphs_table_name;
$graphs_sql = "CREATE TABLE $graphs_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    graph_title varchar(555) DEFAULT '' NOT NULL,
    graph_identifier varchar(555) DEFAULT '' NOT NULL,
    graph_data LONGTEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $graphs_sql );