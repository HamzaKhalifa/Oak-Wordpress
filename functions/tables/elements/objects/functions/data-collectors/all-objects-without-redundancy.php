<?php
global $wpdb; 

$objects_reversed = array_reverse( Oak::$all_objects );
foreach( $objects_reversed as $object ) :
    $exists = false;
    foreach( Oak::$all_objects_without_redundancy as $object_without_redundancy) :
        if ( $object_without_redundancy->object_identifier == $object->object_identifier ) 
            $exists = true;
    endforeach;
    if ( !$exists )
        Oak::$all_objects_without_redundancy[] = $object;
endforeach;