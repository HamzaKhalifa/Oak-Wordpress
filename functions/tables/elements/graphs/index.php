<?php
class Graphs {
    function __construct() {
        $this->table_creator();
        $this->data_collector();
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/graphs/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/fields/functions/data-collector.php';
    }

    static function save_graph() {
        global $wpdb; 

        $graph_data = json_decode( stripslashes( $_POST['data'] ), true );
        foreach( $graph_data as $key => $data ) :
            $graph_data[ $key ] = stripslashes_deep( $data );
        endforeach;

        $result = $wpdb->insert(
            Oak::$graphs_table_name,
            $graph_data
        );

        wp_send_json_success();
    }

    static function create_widgets() {
        // global $wpdb; 

        // $graphs_table_name = Oak::$graphs_table_name;
        // $graphs = $wpdb->get_results ( "
        //     SELECT * 
        //     FROM  $graphs_table_name
        // " );

        // foreach( $graphs as $single_graph ) :
        //     $widget_options = array (
        //         'name' => $single_graph->graph_identifier,
        //         'title' => $single_graph->graph_title,
        //         'icon' => 'eicon-type-tool',
        //         'categories' => [ 'theme-elements' ],
        //         'value' => get_option( 'oak_organization_name' ),
        //         'field_type' => 'organization_name',
        //     );
        //     $generic_widget = new Generic_Widget();
        //     $generic_widget->set_widgets_options( $widget_options );
        //     $widgets_manager->register_widget_type( $generic_widget );
        // endforeach;
    }
}

$graphs = new Graphs();