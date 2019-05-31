<?php
$charset_collate = Oak::$charset_collate;

$performances_table_name = Oak::$performances_table_name;
$performance_sql = "CREATE TABLE $performances_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    performance_designation varchar(555) DEFAULT '' NOT NULL,
    performance_identifier varchar(555) DEFAULT '' NOT NULL,
    performance_selector varchar(555),
    performance_locked varchar(555),
    performance_trashed varchar(555),
    performance_state varchar(555),
    performance_modification_time datetime,
    performance_content_language varchar(10) DEFAULT 'fr',
    performance_type TEXT,
    performance_distance_unity_filter TEXT,
    performance_distance_unity_meter TEXT,
    performance_distance_unity_feet TEXT,
    performance_volume_unity_filter TEXT,
    performance_volume_unity_meter TEXT,
    performance_volume_unity_leter TEXT,
    performance_mass_unity_filter TEXT,
    performance_mass_unity_kg TEXT,
    performance_mass_unity_lb TEXT,
    performance_energy_unity_filter TEXT,
    performance_energy_unity_watt TEXT,
    performance_energy_consumption_unity_filter TEXT,
    performance_energy_consumption_unity_watt TEXT,
    performance_co2_emission_unity_filter TEXT,
    performance_co2_emission_unity_tonne TEXT,
    performance_surface_unity_filter TEXT,
    performance_surface_unity_meter TEXT,
    performance_money_unity TEXT,
    performance_ratio_unity TEXT,
    performance_raw_unity TEXT,
    performance_business_line TEXT,
    performance_country TEXT,
    performance_region TEXT,
    performance_custom_perimeter TEXT,
    performance_results TEXT,
    performance_publication TEXT,
    performance_quantis TEXT,
    performance_objects TEXT,
    performance_synchronized TEXT,
    performance_selectors TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $performance_sql );