<?php
class Performances {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();
        
        Oak::$elements_script_properties_functions['performances'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Performances::$filters = array(
            array ( 'title' => __( 'Nom', Oak::$text_domain ), 'property' => 'performance_designation' ),
            array ( 'title' => __( 'Type', Oak::$text_domain ), 'property' => 'performance_type' ),
            array ( 'title' => __( 'Type', Oak::$text_domain ), 'property' => 'performance_type' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'performance';
        $elements = Oak::$performances;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'performance',
            'table_in_plural' => 'performances',
            'elements' => Oak::$performances,
            'properties' => array_merge( Oak::$shared_properties, Performances::$properties ),
            'filters' => Performances::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/performances/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/performances/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/performances/functions/data-collector.php';
    }

    public static function get_performance_of_corresponding_language( $performance ) {
        $found_corresponding_language_performance = false; 

        $counter = count( Oak::$performances ) - 1;
        do {
            if ( Oak::$performances[ $counter ]->performance_content_language == Oak::$site_language && Oak::$performances[ $counter ]->performance_identifier == $performance->performance_identifier ) :
                return Oak::$performances[ $counter ];
            endif;
            $counter--;
        } while ( $counter >= 0 && !$found_corresponding_language_performance );

        return $performance;
    }

    public static function get_tabs_data( $identifier  ) {
        return array();
    }
}

if ( 
    ( 
        isset( $_GET['elements'] ) && 
        in_array( $_GET['elements'], ['performances'] ) 
    ) ||
    (
        did_action( 'elementor/loaded' ) &&
        \Elementor\Plugin::$instance->editor != null &&
        \Elementor\Plugin::$instance->editor->is_edit_mode() 
    ) ||
    ( 
        isset( $_GET['post'] ) 
    )
) 
    $performances = new Performances();