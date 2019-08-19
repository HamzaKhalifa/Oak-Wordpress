<?php 
class Oak_Elementor {
    function __construct() {
        $this->oak_elementor_initialization();
        add_action( 'elementor/editor/after_enqueue_scripts', array( 'Oak', 'oak_enqueue_styles' ) );
        add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'oak_elementor_editor_enqueue_scripts' ) );
    }

    public static function oak_elementor_editor_enqueue_scripts() {
        wp_enqueue_media();
        wp_enqueue_script( 'oak_front_graphs', get_template_directory_uri() . '/src/js/front/graphs.js', array('jquery'), false, true );
        wp_localize_script( 'oak_front_graphs', 'GRAPHS_DATA', array(
            'graphs' => Oak::$graphs_without_redundancy
        ) );
        wp_enqueue_script( 'oak_front_sidebar', get_template_directory_uri() . '/src/js/front/content-panel.js', array('jquery'), false, true );
    }

    function oak_elementor_initialization() {
        if ( get_option('oak_corn') == 'true' ) :
            if ( !did_action( 'elementor/loaded' ) == 1 ) :
                add_action( 'admin_notices', array( $this, 'oak_admin_notice_missing_elementor_plugin' ) );
            else :
                // This is corn, and elementor is installed. So we do everything related to elementor :)
                $this->oak_add_tags();
                $this->oak_add_widget_categories();
                $this->oak_add_widgets();
            endif;
        endif;
    }

    function oak_admin_notice_missing_elementor_plugin() {

		$message = sprintf(
			esc_html__( 'Pour assurer un bon fonctionnement du "%1$s" , vous devriez avoir "%2$s" installé dans votre environnement.', Oak::$text_domain ),
			'<strong>' . esc_html__( 'Web Publisher', Oak::$text_domain ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', Oak::$text_domain ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

    function oak_add_widget_categories() {
        add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
            $elements_manager->add_category(
                'oak',
                [
                    'title' => __( 'OAK', Oak::$text_domain ),
                    'icon' => 'fa fa-plug',
                ]
            );

            $elements_manager->add_category(
                'oak_charts',
                [
                    'title' => __( 'OAK CHARTS', Oak::$text_domain ),
                    'icon' => 'fa fa-plug',
                ]
            );

            $elements_manager->add_category(
                'oak_images',
                [
                    'title' => __( 'OAK Images', Oak::$text_domain ),
                    'icon' => 'fa fa-plug',
                ]
            );

            $elements_manager->add_category(
                'oak_content_panel',
                [
                    'title' => __( 'OAK Content Panel', Oak::$text_domain ),
                    'icon' => 'fa fa-plug',
                ]
            );
        } );
    }

    function oak_add_tags() {
        add_action( 'elementor/dynamic_tags/register_tags', function( $dynamic_tags ) {
            \Elementor\Plugin::$instance->dynamic_tags->register_group( 'oak', [
                'title' => __( 'Oak', Oak::$text_domain )
            ] );

            \Elementor\Plugin::$instance->dynamic_tags->register_group( 'oak_indexes', [
                'title' => __( 'Oak Indexes', Oak::$text_domain )
            ] );
            
            include_once get_template_directory() . '/functions/elementor/tags/dynamic_tag.php';
            include_once get_template_directory() . '/functions/elementor/tags/dynamic_index_tag.php';
            include_once get_template_directory() . '/functions/elementor/tags/dynamic_csr_side_index_tag.php';

            $tag = new Dynamic_Tag();
            $dynamic_tags->register_tag( 'Dynamic_Tag' );

            $indexes_tag = new Dynamic_Index_Tag();
            $dynamic_tags->register_tag( 'Dynamic_Index_Tag' );

            $csr_side_indexes_tag = new Dynamic_Csr_Side_Index_Tag();
            $dynamic_tags->register_tag( 'Dynamic_Csr_Side_Index_Tag' );;
        } );
    }

    function oak_add_widgets() {
        add_action('elementor/widgets/widgets_registered', function( $widgets_manager ) {
            include_once get_template_directory() . '/functions/elementor/widgets/generic_widget.php';
            include_once get_template_directory() . '/functions/elementor/widgets/sidebar_widget.php';
            include_once get_template_directory() . '/functions/elementor/widgets/content_panel_widget.php';

            global $wpdb;

            $selected_objects = get_post_meta( get_the_ID(), 'objects_selector' ) ? get_post_meta( get_the_ID(), 'objects_selector' ) [0] : [];

            $our_objects = Oak::oak_get_selected_objects_data( $selected_objects, true );
            $the_returned_fields = [];

            Sidebar_Widget::$post_selected_objects[] = $our_objects;
            Oak_Content_Panel_Widget::$post_selected_objects[] = $our_objects;

            // $metas = get_post_meta( get_the_ID() );
            // foreach( $metas as $key => $meta ) :
            //     if ( strpos( $key, 'Oak:' ) !== false ) :
            //         delete_post_meta( get_the_ID(), $key );
            //     endif;
            // endforeach;
            
            $post_images_to_show = array();
            update_option( 'oak_post_images_to_show', array() );
            // For the images
            $images = array();
            $query_images_args = array (
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'post_status'    => 'inherit',
                'posts_per_page' => - 1,
            );
    
            $query_images = new WP_Query( $query_images_args );
            foreach ( $query_images->posts as $image ) {
                $images[] = array ( 'url' => wp_get_attachment_url( $image->ID ), 'id' => $image->ID );
            }

            foreach( $our_objects as $index => $object ) :
                $widget_options = array(
                    'name' => 'object_' . $index . '_designation',
                    'title' => __( 'Designation Objet ' . $index . ' ', Oak::$text_domain ),
                    'icon' => 'eicon-type-tool',
                    'categories' => [ 'oak' ],
                    'value' => $object->object_designation,
                    'field_type' => 'text',
                );

                $object_number = $index + 1;

                // update_post_meta( get_the_ID(), 'Oak: Objet ' . $object_number . ': ' . $object->object_designation . ', Designation', $object->object_designation );
                update_post_meta( get_the_ID(), 'Oak: Designation Objet ' . $object_number, $object->object_designation );
                $generic_widget = new Generic_Widget();
                $generic_widget->set_widgets_options( $widget_options );
                $widgets_manager->register_widget_type( $generic_widget );

                $object_model_field_names_array = explode( '|', $object->object_model_fields_names );
                foreach( $object->object_model_fields as $key => $object_model_field ) :
                    $field_number = $key + 1;
                    $column_name = 'object_' . $key . '_' . $object_model_field->field_identifier;
                    $value = $object->$column_name;
                    $widget_options = array (
                        'name' => preg_replace( '/\s+/', '', count( $the_returned_fields ) . $object_model_field_names_array[ $key ] ),
                        'title' => $object_model_field_names_array[ $key ],
                        'icon' => $object_model_field->field_type == 'Image' ? 'eicon-image' : 'eicon-type-tool',
                        'categories' => [ 'oak' ],
                        'value' => $value,
                        'field_type' => $object_model_field->field_type,
                    );

                    if ( $object_model_field->field_type == 'image' ) :
                        $image_id = attachment_url_to_postid( $value );
                        // foreach( $images as $image ) :
                        //     if ( $image['url'] == $value ) :
                        //         $id = $image['id'];
                        //     endif;
                        // endforeach;
                        $image_widget_options = array ( 'url' => $value, 'id' => $image_id, 'label' => 'Oak: ' . count( $the_returned_fields ) . ' ' . $object_model_field_names_array[ $key ] );
                        $post_images_to_show[] = $image_widget_options;
                    endif;

                    $the_returned_fields [] = array (
                        'field_designation' => count( $the_returned_fields ) . ' ' . $object_model_field_names_array[ $key ],
                        'value' => $value,
                        'field_type' => $object_model_field->field_type
                    );

                    // update_post_meta( get_the_ID(), 'Oak: Objet ' . $object_number . ': ' . $object->object_designation . ', Champ ' . count( $the_returned_fields ) . ': ' . $object_model_field_names_array[ $key ], $value );
                    update_post_meta( get_the_ID(), 'Oak: ' . count( $the_returned_fields ) . ' ' . $object_model_field_names_array[ $key ], $value );
                    $generic_widget = new Generic_Widget();
                    $generic_widget->set_widgets_options( $widget_options );
                    $widgets_manager->register_widget_type( $generic_widget );
                endforeach;
            endforeach;


            $post_images_to_show = $this->add_goodpractices_post_meta( $post_images_to_show );

            $post_images_to_show = $this->add_performances_post_meta( $post_images_to_show );

            $post_images_to_show = $this->add_sources_post_meta( $post_images_to_show );

            $post_images_to_show = $this->add_qualis_post_meta( $post_images_to_show );

            update_option( 'oak_post_images_to_show', $post_images_to_show );

            $this->create_image_widget( $widgets_manager );

            // I pass the data to dynamic tags via the table options (Because there is an error of denied access if I happen to do this in the register controls function)
            update_option( 'oak_post_elementor_fields', $the_returned_fields );
            update_option( 'oak_all_images', $images );

            // For site parameters
            $this->add_social_media_widgets( $widgets_manager );

            $this->add_organization_name_widget( $widgets_manager );

            // To unregister the logo and site title widgets:
            if ( get_option( 'oak_show_logo' ) != 'true' ) :
                $widgets_manager->unregister_widget_type( 'theme-site-logo' );
            endif;

            if ( get_option( 'oak_show_site_title' ) != 'true' ) :
                $widgets_manager->unregister_widget_type( 'theme-site-title' );
            endif;
            // $this->handle_logo_and_title_registration( $widget_options );

            // To create the graph widgets: 
            Graphs::create_widgets( $widgets_manager );

            // To create the content panel widgets: 
            Oak_Content_Panel_Widget::create_widgets( $widgets_manager );

            // To create the sidebar widget: 
            Sidebar_Widget::create_widgets( $widgets_manager );

        }, 14);
    }
    
    function create_image_widget( $widgets_manager ) {
        include_once get_template_directory() . '/functions/elementor/widgets/image_widget.php';

        $image_widget = new Oak_Image();
        $widgets_manager->register_widget_type( $image_widget );
    }

    public static function get_post_sources_data( $post_id, $post_images_to_show, $inside_post ) {
        $sources_to_return = [];
        $selected_sources = get_post_meta( $post_id, 'sources_selector' ) ? get_post_meta( $post_id, 'sources_selector' ) [0] : [];
        // $selected_sources = array_reverse( $selected_sources );
        $source_number = 1;
        $source = __( 'Source', Oak::$text_domain );
        foreach( $selected_sources as $source_key => $selected_identifier ) :
            $incrementer = 0;
            $found_source = false;
            do {
                if ( Oak::$sources_without_redundancy[ $incrementer ]->source_identifier == $selected_identifier) :
                    // For the designation: 
                    $the_source = Oak::$sources_without_redundancy[ $incrementer ];
                    $the_source = Sources::get_source_of_corresponding_language( $the_source );
                    $the_source->source_data = [];
                    $the_source->source_data = array_merge( $the_source->source_data,  array( $the_source->source_designation => __( 'Désignation', Oak::$text_domain ) ) );
                    if ( $inside_post ) :
                        update_post_meta( $post_id, 'Oak: ' . $source . ' ' . $source_number . ': Designation', $the_source->source_designation );
                        if ( $the_source->source_type == 'internal' ) :
                            if ( $the_source->source_internal_type == 'post_or_page' ) :
                                update_post_meta( $post_id, 'Oak: ' . $source . ' ' . $source_number . ': Lien Poste/Page', get_post( $the_source->source_post )->guid );
                            endif;
                        else :
                            update_post_meta( $post_id, 'Oak: ' . $source . ' ' . $source_number . ': Lien', $the_source->source_link );
                            update_post_meta( $post_id, 'Oak: ' . $source . ' ' . $source_number . ': Titre du lien', $the_source->source_link_title );
                        endif;
                    endif;
                        // update_post_meta( $post_id, 'Oak: ' . $source . ' ' . $source_number . ': ' . $the_source->source_designation . ': Designation', $the_source->source_designation );
                    foreach( Sources::$properties as $key => $source_property ) :
                        $property_name = $source_property['property_name'];
                        if ( $source_property['input_type'] != 'image' && $source_property['input_type'] != 'select' && $property_name != 'source_link' && $property_name != 'source_link_title' ) :
                            error_log( $property_name );
                            $the_source->source_data = array_merge( $the_source->source_data,  array( $the_source->$property_name => $source_property['description'] ) );
                            if ( $inside_post ) :
                                update_post_meta( $post_id, 'Oak: ' . $source . ' ' . $source_number . ': ' . $source_property['description'], $the_source->$property_name );
                                // update_post_meta( $post_id, 'Oak: ' . $source . ' ' . $source_number . ': ' . $the_source->source_designation . ': ' . $source_property['description'], $the_source->$property_name );
                                
                            endif;
                        elseif ( $source_property['input_type'] == 'image' ):
                            $image_id = attachment_url_to_postid( $the_source->$property_name );
                            $the_source->source_data = array_merge( $the_source->source_data,  array( $the_source->$property_name => $source_property['description'] ) );
                            $post_images_to_show[] = array ( 'url' => $the_source->$property_name, 'id' => $image_id, 'label' => 'Oak: ' . $source . ' ' . $source_number . ': ' .$source_property['description'] );
                            // Handle the images: We are gonna have to find the id of the image in the database for elementor to be able to handle it: 
                        endif;
                    endforeach;
                    $source_number++;

                    if ( $inside_post ) :
                        Sidebar_Widget::$post_selected_sources[] = $the_source;
                        Oak_Content_Panel_Widget::$post_selected_sources[] = $the_source;
                    endif;
                    $sources_to_return[] = $the_source;

                endif;
                $incrementer++;
            } while( $incrementer < count( Oak::$sources_without_redundancy ) && !$found_source );
        endforeach;

        return array(
            'sources' => $sources_to_return,
            'post_images_to_show' => $post_images_to_show
        );
    }

    function add_sources_post_meta( $post_images_to_show ) {
        // For sources
        $post_images_to_show = Oak_Elementor::get_post_sources_data( get_the_ID(), $post_images_to_show, true )['post_images_to_show'];

        return $post_images_to_show;
    }

    public static function get_post_qualis_data( $post_id, $post_images_to_show, $inside_post ) {
        $selected_qualis = get_post_meta( $post_id, 'qualis_selector' ) ? get_post_meta( $post_id, 'qualis_selector' ) [0] : [];
        //$selected_qualis = array_reverse( $selected_qualis );
        $qualis_to_return = [];
        $quali_number = 1;
        $quali = __( 'Indicateur Qualitatif', Oak::$text_domain );
        foreach( $selected_qualis as $quali_key => $selected_identifier ) :
            $incrementer = 0;
            $found_quali = false;
            do {
                if ( Oak::$qualis_without_redundancy[ $incrementer ]->quali_identifier == $selected_identifier) :
                    // For the designation: 
                    $the_quali = Oak::$qualis_without_redundancy[ $incrementer ];
                    $the_quali->quali_data = [];
                    $the_quali->quali_data = array_merge( $the_quali->quali_data,  array( $the_quali->quali_designation => __( 'Désignation', Oak::$text_domain ) ) );
                    if ( $inside_post ) :
                        update_post_meta( $post_id, 'Oak: ' . $quali . ' ' . $quali_number . ': Designation', $the_quali->quali_designation );
                        // update_post_meta( $post_id, 'Oak: ' . $quali . ' ' . $quali_number . ': ' . $the_quali->quali_designation . ', Designation', $the_quali->quali_designation );
                    endif;
                    foreach( Qualis::$properties as $key => $quali_property ) :
                        $property_name = $quali_property['property_name'];
                        if ( $quali_property['input_type'] != 'image' && $quali_property['input_type'] != 'select' ) :
                            $the_quali->quali_data = array_merge( $the_quali->quali_data, array( $the_quali->$property_name => $quali_property['description'] ) );
                            if ( $inside_post ) :
                                update_post_meta( $post_id, 'Oak: ' . $quali . ' ' . $quali_number . ': ' . $quali_property['description'], $the_quali->$property_name );
                                // update_post_meta( $post_id, 'Oak: ' . $quali . ' ' . $quali_number . ': ' . $the_quali->quali_designation . ', ' . $quali_property['description'], $the_quali->$property_name );
                            endif;
                        elseif ( $quali_property['input_type'] == 'image' ):
                            $image_id = attachment_url_to_postid( $the_quali->$property_name );
                            $post_images_to_show[] = array ( 'url' => $the_quali->$property_name, 'id' => $image_id, 'label' => 'Oak: ' . $quali . ' ' . $quali_number . ': ' .$quali_property['description'] );
                            // Handle the images: We are gonna have to find the id of the image in the database for elementor to be able to handle it: 
                        endif;
                    endforeach;
                    $quali_number++;

                    if ( $inside_post ) :
                        Sidebar_Widget::$post_selected_qualis[] = $the_quali;
                        Oak_Content_Panel_Widget::$post_selected_qualis[] = $the_quali;
                    endif;

                    $qualis_to_return[] = $the_quali;
                endif;
                $incrementer++;
            } while( $incrementer < count( Oak::$qualis_without_redundancy ) && !$found_quali );
        endforeach;


        return array(
            'qualis' => $qualis_to_return, 
            'post_images_to_show' => $post_images_to_show
        );
    }

    function add_qualis_post_meta( $post_images_to_show ) {
        $post_images_to_show = Oak_Elementor::get_post_qualis_data( get_the_ID(), $post_images_to_show, true )['post_images_to_show'];

        return $post_images_to_show;
    }

    public static function get_post_goodpractices_data( $post_id, $post_images_to_show, $inside_post ) {
        // For the good practices: 
        $goodpractices_to_return = [];
        $selected_goodpractices = get_post_meta( $post_id, 'good_practices_selector' ) ? get_post_meta( $post_id, 'good_practices_selector' ) [0] : [];
        $good_practice = __( 'Bonne Pratique', Oak::$text_domain );
        $good_practice_number = 1;
        foreach( $selected_goodpractices as $good_practice_key => $goodpractice_identifier ) :
            $incrementer = 0;
            $found_goodpractice = false;
            do {
                if ( Oak::$goodpractices_without_redundancy[ $incrementer ]->goodpractice_identifier == $goodpractice_identifier) :
                    // For the designation: 
                    $the_goodpractice = Oak::$goodpractices_without_redundancy[ $incrementer ];
                    $the_goodpractice = Good_Practices::get_goodpractice_of_corresponding_language( $the_goodpractice );
                    if ( $inside_post )
                        update_post_meta( $post_id, 'Oak: ' . $good_practice . ' ' . $good_practice_number . ': Designation', $the_goodpractice->goodpractice_designation );
                        // update_post_meta( $post_id, 'Oak: ' . $good_practice .' ' . $good_practice_number . ': ' . $the_goodpractice->goodpractice_designation, $the_goodpractice->goodpractice_designation );
                    foreach( Good_Practices::$properties as $key => $goodpractice_property ) :
                        $property_name = $goodpractice_property['property_name'];
                        if ( $goodpractice_property['input_type'] != 'image' && $goodpractice_property['input_type'] != 'select' ) :
                            if ( $inside_post ) :
                                update_post_meta( $post_id, 'Oak: ' . $good_practice . ' ' . $good_practice_number . ': ' . $goodpractice_property['description'], $the_goodpractice->$property_name );
                                // update_post_meta( $post_id, 'Oak: ' . $good_practice . ' ' . $good_practice_number . ': ' . $the_goodpractice->goodpractice_designation . ': ' . $goodpractice_property['description'], $the_goodpractice->$property_name );
                            endif;
                        elseif ( $goodpractice_property['input_type'] == 'image' ):
                            $image_id = attachment_url_to_postid( $the_goodpractice->$property_name );
                            $post_images_to_show[] = array ( 'url' => $the_goodpractice->$property_name, 'id' => $image_id, 'label' => 'Oak: ' . $good_practice . ' ' . $good_practice_number . ': ' .$goodpractice_property['description'] );
                            // Handle the images: We are gonna have to find the id of the image in the database for elementor to be able to handle it: 
                        endif;
                    endforeach;

                    $goodpractices_to_return[] = $the_goodpractice;
                    $good_practice_number++;
                endif;
                $incrementer++;
            } while( $incrementer < count( Oak::$goodpractices_without_redundancy ) && !$found_goodpractice );
        endforeach;

        return array(
            'post_images_to_show' => $post_images_to_show,
            'goodpractices' => $goodpractices_to_return
        );
    }

    function add_goodpractices_post_meta( $post_images_to_show ) {
        $post_images_to_show = Oak_Elementor::get_post_goodpractices_data( get_the_Id(), $post_images_to_show, true )['post_images_to_show'];
        
        return $post_images_to_show;
    }

    public static function get_post_performances_data( $post_id, $post_images_to_show, $inside_post ) {
        $selected_quantis = get_post_meta( $post_id, 'quantis_selector' ) ? get_post_meta( $post_id, 'quantis_selector' ) [0] : [];
        //$selected_quantis = array_reverse( $selected_quantis );
        $performances_to_return = [];
        $performance_number = 1;
        foreach( $selected_quantis as $quanti_identifier ) :
            $performance_selectors = '';
            $found_quanti = false;
            $counter = 0;
            do {
                if ( Oak::$quantis_without_redundancy[ $counter ]->quanti_identifier == $quanti_identifier ) :
                    $found_quanti = true;
                    $performance_selectors = Oak::$quantis_without_redundancy[ $counter ]->quanti_frame_objects;
                endif;
                $counter++;
            } while( !$found_quanti && $counter < count( Oak::$quantis_without_redundancy ) );

            foreach( Oak::$performances_without_redundancy as $performance_key => $performance ) :
                if ( $performance->performance_quantis == $quanti_identifier ) :
                    $performance = Performances::get_performance_of_corresponding_language( $performance );
                    $performance_text = __( 'Donnée de performance', Oak::$text_domain );
                    $performance->performance_data = [];

                    $performance->performance_data = array_merge( $performance->performance_data, array( $performance->performance_designation => __( 'Désignation', Oak::$text_domain ) ) );
                    if ( $inside_post )
                        update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': Designation', $performance->performance_designation );
                        // update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance->performance_designation . ': Designation', $performance->performance_designation );

                    $unity_type_text = __( 'Type de l’unité', Oak::$text_domain );
                    $performance->performance_data = array_merge ( $performance->performance_data, array( $performance->performance_type => __( 'Type', Oak::$text_domain ) ) );
                    if ( $inside_post )
                    update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $unity_type_text, $performance->performance_type );
                        // update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance->performance_designation . ': ' . $unity_type_text, $performance->performance_type );

                    $performance_results = explode( '|', $performance->performance_results );
                    foreach( $performance_results as $result_key => $result ) :
                        if ( $result != '' ) :
                            $result_values = explode( ':', $result );
                            $year = $result_values[0];
                            $value = $result_values[1];

                            $performance->performance_data = array_merge ( $performance->performance_data, array( $year => __( 'Anné ' . $result_key, Oak::$text_domain ) ) );
                            if ( $inside_post )
                                update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': Année ' . $result_key, $year );
                                // update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': Année ' . $result_key, $year );
                            $performance->performance_data = array_merge( $performance->performance_data, array( $value =>  __( 'Valeur ' . $result_key, Oak::$text_domain ) ) );
                            if ( $inside_post )
                                update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': Résultalt ' . $year, $value );
                                // update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': Résultalt ' . $year, $value );
                        endif;
                    endforeach;

                    foreach( Performances::$properties as $key => $performance_property ) :
                        $property_name = $performance_property['property_name'];

                        if ( $performance_property['name'] == 'country' ) :
                            $performance->performance_data = array_merge( $performance->performance_data, array( $performance->$property_name => $performance_property['description'] ) );
                            if ( $inside_post ) :
                                update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance_property['description'], $performance->$property_name );
                                // update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance_property['description'], $performance->$property_name );
                            endif;
                        elseif ( $performance_property['name'] == 'custom_perimeter' ) :
                            if ( $inside_post ) :
                                update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance_property['description'], $performance->$property_name );
                                // update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance_property['description'], $performance->$property_name );
                        endif;
                        elseif ( $performance_property['input_type'] != 'image' && $performance_property['input_type'] != 'select' ) :
                            if ( $inside_post ) :
                                update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance_property['description'], $performance->$property_name );
                                // update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance_property['description'], $performance->$property_name );
                            endif;
                        elseif ( $performance_property['input_type'] == 'image' ):
                            $performance->performance_data = array_merge( $performance->performance_data, array( $performance->$property_name => $performance_property['description'] ) );
                            $image_id = attachment_url_to_postid( $performance->$property_name );
                            $post_images_to_show[] = array ( 'url' => $performance->$property_name, 'id' => $image_id, 'label' => 'Oak: ' . $performance . ' ' . $performance_number . ': ' .$performance_property['description'] );
                            // Handle the images: We are gonna have to find the id of the image in the database for elementor to be able to handle it: 
                        elseif( $performance_property['input_type'] == 'select' ) :
                            if ( isset( $performance_property['depends'] ) ) :
                                if( $performance_property['depends'][0]['name'] = 'type' ) :
                                    if ( $performance_property['depends'][0]['values'][0] == $performance->performance_type ) :
                                        $value = '';
                                        foreach( $performance_property['choices'] as $choice ) :
                                            if ( $choice['value'] == $performance->$property_name ) :
                                                $value = $choice['innerHTML'];
                                            endif;
                                        endforeach;
                                        if ( $inside_post )
                                            update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance_property['description'], $value );
                                            // update_post_meta( $post_id, 'Oak: ' . $performance_text . ' ' . $performance_number . ': ' . $performance_property['description'], $value );
                                    endif;
                                endif;
                            endif;
                        endif;
                    endforeach;
                    $performance_number++;

                    $performance->performance_selectors = $performance_selectors;

                    if ( $inside_post ) :
                        Sidebar_Widget::$post_selected_performances[] = $performance;
                        Oak_Content_Panel_Widget::$post_selected_performances[] = $performance;
                    endif;
                    $performances_to_return[] = $performance;

                endif;
            endforeach;
        endforeach;

        return array(
            'post_images_to_show' => $post_images_to_show,
            'performances' => $performances_to_return
        );
    }

    function add_performances_post_meta( $post_images_to_show ) {
        $post_images_to_show = Oak_Elementor::get_post_performances_data( get_the_ID(), $post_images_to_show, true )['post_images_to_show'];

        return $post_images_to_show;
    }

    function add_social_media_widgets( $widgets_manager ) {
        // For site parameters
        $social_media_data = get_option( 'oak_social_media_data' );
        if ( $social_media_data != false && is_array( $social_media_data ) ) :
            foreach( $social_media_data as $key => $social_media ) :
                if ( $social_media['checked'] == 'true' ) :
                    $widget_options = array(
                        'name' => preg_replace( '/\s+/', '', Oak::$social_medias[ $key ]['name'] ),
                        'title' => Oak::$social_medias[ $key ]['title'],
                        'icon' => 'eicon-type-tool',
                        'categories' => [ 'theme-elements' ],
                        'value' => $social_media['value'],
                        'field_type' => 'social_media',
                    );
                    $generic_widget = new Generic_Widget();
                    $generic_widget->set_widgets_options( $widget_options );
                    $widgets_manager->register_widget_type( $generic_widget );
                endif;
            endforeach;
        endif;
    }

    function add_organization_name_widget( $widgets_manager ) {
        // For the organization name:
        if ( get_option( 'oak_show_organization_name' ) == 'true' ) :
            $widget_options = array (
                'name' => __( 'organization_name', Oak::$text_domain ),
                'title' => __( 'Nom de l\'organisation', Oak::$text_domain ),
                'icon' => 'eicon-type-tool',
                'categories' => [ 'theme-elements' ],
                'value' => get_option( 'oak_organization_name' ),
                'field_type' => 'organization_name',
            );
            $generic_widget = new Generic_Widget();
            $generic_widget->set_widgets_options( $widget_options );
            $widgets_manager->register_widget_type( $generic_widget );
        endif;
    }

    function oak_add_side_bar_widgets( $widgets_manager ) {
        include_once get_template_directory() . '/functions/elementor/widgets/sidebar_widget.php';

        $sidebar_widget = new Sidebar_Widget();
        $widgets_manager->register_widget_type( $sidebar_widget );
    }
}

$oak_elementor = new Oak_Elementor();