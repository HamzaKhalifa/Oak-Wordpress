<?php
class Sources {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['sources'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Sources::$filters = array(
            array ( 'title' => __( 'Désignation', Oak::$text_domain ), 'property' => 'source_designation' ),
            array ( 'title' => __( 'Titre Court', Oak::$text_domain ), 'property' => 'source_short_title' ),
            array ( 'title' => __( 'Type', Oak::$text_domain ), 'property' => 'source_type' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'source';
        $elements = Oak::$sources;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'source',
            'table_in_plural' => 'sources',
            'elements' => Oak::$sources,
            'properties' => array_merge( Oak::$shared_properties, Sources::$properties ),
            'filters' => Sources::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/sources/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/sources/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/sources/functions/data-collector.php';
    }

    public static function get_source_of_corresponding_language( $source ) {
        $found_corresponding_language_source = false; 

        $counter = count( Oak::$sources ) - 1;
        do {
            if ( Oak::$sources[ $counter ]->source_content_language == Oak::$site_language && Oak::$sources[ $counter ]->source_identifier == $source->source_identifier ) :
                return Oak::$sources[ $counter ];
            endif;
            $counter--;
        } while ( $counter >= 0 && !$found_corresponding_language_source );

        return $source;
    }

    public static function get_tabs_data( $identifier  ) {
        return array();
    }
}

if ( 
    ( 
        isset( $_GET['elements'] ) && 
        in_array( $_GET['elements'], ['sources'] ) 
    ) || 
    ( 
        did_action( 'elementor/loaded' ) &&
        \Elementor\Plugin::$instance->editor->is_edit_mode() 
    ) ||
    ( 
        isset( $_GET['post'] ) 
    )
) 
    $sources = new Sources();