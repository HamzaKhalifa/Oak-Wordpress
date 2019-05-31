<?php
$charset_collate = Oak::$charset_collate;

$quantis_table_name = Oak::$quantis_table_name;
$quantis_sql = "CREATE TABLE $quantis_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    quanti_designation varchar(555) DEFAULT '' NOT NULL,
    quanti_identifier varchar(555) DEFAULT '' NOT NULL,
    quanti_selector varchar(555),
    quanti_locked varchar(555),
    quanti_trashed varchar(555),
    quanti_state varchar(555),
    quanti_modification_time datetime,
    quanti_content_language varchar(10) DEFAULT 'fr',
    quanti_publication varchar(555),
    quanti_object varchar(555),
    quanti_depends varchar(555),
    quanti_parent varchar(555),
    quanti_parent_object varchar(555),
    quanti_numerotation_type varchar(555),
    quanti_numerotation varchar(555),
    quanti_description LONGTEXT,
    quanti_close varchar(555),
    quanti_close_indicators varchar(555),
    quanti_close_objects varchar(555),
    quanti_synchronized TEXT,
    quanti_frame_objects TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $quantis_sql );