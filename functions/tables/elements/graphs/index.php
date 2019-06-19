<?php
class Graphs {
    public static $filters; 
    public static $properties;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        add_action( 'admin_enqueue_scripts', array( $this, 'graphs_admin_enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'graphs_admin_enqueue_styles' ) );

        Oak::$elements_script_properties_functions['graphs'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Graphs::$filters = array(
            array ( 'title' => __( 'Etat', Oak::$text_domain ), 'property' => 'graph_state', 'choices' => array () ),
            array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'graph_identifier', 'choices' => array() ),
            array ( 'title' => __( 'Donées', Oak::$text_domain ), 'property' => 'graph_data', 'choices' => array() )
        );
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/graphs/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/graphs/functions/data-collector.php';
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/graphs/functions/properties-initialization.php';
    }

    function graphs_admin_enqueue_scripts() {
        ?>
        <?php
        
        wp_enqueue_script( 'oak_charts', get_template_directory_uri() . '/src/js/vendor/chart.bundle.min.js', array(), false, true );
        if ( isset( $_GET['graph_identifier'] ) ) :
            wp_enqueue_script( 'oak_add_element_graph_script', get_template_directory_uri() . '/functions/tables/elements/graphs/src/js/add-element-graph.js', array(), false, true );
        endif;
        wp_enqueue_script( 'oak_lodash', 'https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.10.1/lodash.min.js', array(), false, true );
    }
    
    function graphs_admin_enqueue_styles() {
        wp_enqueue_style( 'oak_add_element_graph_style', get_template_directory_uri() . '/functions/tables/elements/graphs/src/css/add-element-graph.css' );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'graph';
        $elements = Oak::$graphs;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => $table,
            'table_in_plural' => 'graphs',
            'elements' => $elements,
            'properties' => array_merge( Oak::$shared_properties, Graphs::$properties ),
            'filters' => Graphs::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function save_graph() {
        global $wpdb; 

        $graph_data = json_decode( stripslashes( $_POST['data'] ), true );
        
        foreach( $graph_data as $key => $data ) :
            $graph_data[ $key ] = stripslashes_deep( $data );
        endforeach;

        $graph_data = array_merge( $graph_data, array( 'graph_modification_time' => date("Y-m-d H:i:s") ) );

        $result = $wpdb->insert (
            Oak::$graphs_table_name,
            $graph_data
        );

        wp_send_json_success();
    }

    static function create_widgets( $widgets_manager ) {
        include get_template_directory() . '/functions/tables/elements/graphs/functions/graph_widget.php';

        global $wpdb; 

        $graphs_table_name = Oak::$graphs_table_name;
        $graphs = $wpdb->get_results ( "
            SELECT * 
            FROM  $graphs_table_name
        " );

        foreach( $graphs as $single_graph ) :
            $widget_options = array (
                'graph_identifier' => $single_graph->graph_identifier,
                'title' => $single_graph->graph_designation,
                'field_type' => 'organization_name',
            );
            $generic_widget = new Graph_Widget();
            $generic_widget->set_widgets_options( $widget_options );
            $widgets_manager->register_widget_type( $generic_widget );
        endforeach;
    }

    public static function data_studio_button() {
        include get_template_directory() . '/functions/tables/elements/graphs/views/data_studio_button.php';
    }

    public static function data_studio_graph_container() {
        include get_template_directory() . '/functions/tables/elements/graphs/views/graph_container.php';
    }
}

$graphs = new Graphs();