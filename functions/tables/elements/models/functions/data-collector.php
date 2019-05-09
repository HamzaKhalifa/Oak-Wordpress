<?php
global $wpdb;

$models_table_name = Oak::$models_table_name;
Oak::$models = $wpdb->get_results ( "
    SELECT * 
    FROM  $models_table_name
" );
$reversed_models = array_reverse( Oak::$models );
$models_without_redundancy = [];
foreach( $reversed_models as $model ) :
    $added = false;
    foreach( $models_without_redundancy as $model_without_redundancy ) :
        if ( $model_without_redundancy->model_identifier == $model->model_identifier ) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $models_without_redundancy[] = $model;
    endif;
endforeach;
Oak::$models_without_redundancy = $models_without_redundancy;