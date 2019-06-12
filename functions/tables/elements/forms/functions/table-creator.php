<?php
$charset_collate = Oak::$charset_collate;
$forms_table_name = Oak::$forms_table_name;
$forms_sql = "CREATE TABLE $forms_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    form_designation varchar(555) DEFAULT '' NOT NULL,
    form_identifier varchar(555) DEFAULT '' NOT NULL,
    form_selector varchar(555),
    form_locked varchar(555),
    form_trashed varchar(555),
    form_state varchar(555),
    form_modification_time datetime,
    form_revision_number varchar(555),
    form_content_language varchar(10) DEFAULT 'fr',
    form_structure varchar(555),
    form_attributes varchar(100),
    form_separators varchar(100),
    form_synchronized TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $forms_sql );