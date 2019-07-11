<?php
class Taxonomies {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['taxonomies'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Taxonomies::$filters = array(
            array ( 'title' => __( 'Description', Oak::$text_domain ), 'property' => 'taxonomy_description' ),
            array ( 'title' => __( 'Structure', Oak::$text_domain ), 'property' => 'taxonomy_structure' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'taxonomy_structure' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'taxonomy';
        $elements = Oak::$taxonomies;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'taxonomy',
            'table_in_plural' => 'taxonomies',
            'elements' => Oak::$taxonomies,
            'properties' => array_merge( Oak::$shared_properties, Taxonomies::$properties ),
            'filters' => Taxonomies::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/taxonomies/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/taxonomies/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/taxonomies/functions/data-collector.php';
    }

    public static function get_tabs_data( $identifier  ) {
        return array();
    }
}

if ( 
    ( 
        isset( $_GET['elements'] )
    ) || 
    ( 
        did_action( 'elementor/loaded' ) &&
        \Elementor\Plugin::$instance->editor != null &&
        \Elementor\Plugin::$instance->editor->is_edit_mode() 
    )
) 
    $taxonomies = new Taxonomies();