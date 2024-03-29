<?php
$charset_collate = Oak::$charset_collate;

$graphs_table_name = Oak::$graphs_table_name;
$graphs_sql = "CREATE TABLE $graphs_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    graph_designation varchar(555) DEFAULT '' NOT NULL,
    graph_identifier varchar(555) DEFAULT '' NOT NULL,
    graph_selector varchar(555),
    graph_locked varchar(555),
    graph_trashed varchar(555),
    graph_state varchar(555),
    graph_modification_time datetime,
    graph_content_language varchar(10) DEFAULT 'fr',
    graph_data LONGTEXT,
    graph_links LONGTEXT,
    graph_synchronized TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $graphs_sql );