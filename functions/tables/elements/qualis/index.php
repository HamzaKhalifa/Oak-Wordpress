<?php
class Qualis {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['qualis'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Qualis::$filters = array(
            array ( 'title' => __( 'Publication', Oak::$text_domain ), 'property' => 'quali_publication' ),
            array ( 'title' => __( 'Parent', Oak::$text_domain ), 'property' => 'quali_parent' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'quali_parent' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'quali';
        $elements = Oak::$qualis;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'quali',
            'table_in_plural' => 'qualis',
            'elements' => Oak::$qualis,
            'properties' => array_merge( Oak::$shared_properties, Qualis::$properties ),
            'filters' => Qualis::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/qualis/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/qualis/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/qualis/functions/data-collector.php';
    }

    public static function get_tabs_data( $identifier  ) {
        return array();
    }
}

if (
    (
        isset( $_GET['elements'] ) && 
        in_array( $_GET['elements'], ['qualis', 'publishers'] ) 
    ) ||
    (
        did_action( 'elementor/loaded' ) &&
        \Elementor\Plugin::$instance->editor != null &&
        \Elementor\Plugin::$instance->editor->is_edit_mode() 
    ) ||
    ( 
        isset( $_GET['post'] ) 
    ) || 
    ( 
        isset( $_GET['page'] ) && 
        $_GET['page'] == 'oak_import_page'
    )
) 
    $qualis = new Qualis();