<?php
global $wpdb; 

$forms_and_fields_table_name = Oak::$forms_and_fields_table_name;
Oak::$all_forms_and_fields = $wpdb->get_results ( "
    SELECT * 
    FROM  $forms_and_fields_table_name
" );