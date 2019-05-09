<?php
global $wpdb; 

$terms_and_objects_table_name = Oak::$terms_and_objects_table_name;
Oak::$terms_and_objects = $wpdb->get_results ( "
    SELECT * 
    FROM $terms_and_objects_table_name
" );