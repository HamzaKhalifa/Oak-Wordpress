<?php
global $wpdb;

$models_and_forms_table_name = Oak::$models_and_forms_table_name;
Oak::$all_models_and_forms = $wpdb->get_results ( "
    SELECT * 
    FROM  $models_and_forms_table_name
" );