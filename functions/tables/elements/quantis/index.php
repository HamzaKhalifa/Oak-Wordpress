<?php
class Quantis {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Quantis::$filters = array(
            array ( 'title' => __( 'Publication', Oak::$text_domain ), 'property' => 'quanti_publication' ),
            array ( 'title' => __( 'Parent', Oak::$text_domain ), 'property' => 'quanti_parent' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'quanti_parent' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/quantis/functions/properties-initialization.php';
    }
    
    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/quantis/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/quantis/functions/data-collector.php';
    }

    public static function add_quantis_meta_box_view() {
        $selected_quantis = get_post_meta( get_the_ID(), 'quantis_selector' ) ? get_post_meta( get_the_ID(), 'quantis_selector' ) [0] : [];
        ?>
        <div>
            <input type="text" placeholder="<?php _e( 'Rechercher', Oak::$text_domain ); ?>" class="oak_post_quantis_selector_search_input">
            <br>
            <select multiple name="quantis_selector[]" class="oak_post_quantis_selector" size="<?php echo( count( Oak::$quantis_without_redundancy ) ); ?>">
                <?php
                foreach( Oak::$quantis_without_redundancy as $quanti ) :
                    $selected = '';
                    foreach( $selected_quantis as $selected_quanti_identifier ) :
                        if ( $selected_quanti_identifier == $quanti->quanti_identifier ) :
                            $selected = 'selected';
                        endif;
                    endforeach;
                    ?>
                    <option <?php echo( $selected ); ?> value="<?php echo( $quanti->quanti_identifier ); ?>"><?php echo( $quanti->quanti_designation ); ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>
        <?php
    }
}

$quantis = new Quantis();