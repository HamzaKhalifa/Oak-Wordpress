<?php
class Good_Practices {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Good_Practices::$filters = array(
            array ( 'title' => __( 'Nom', Oak::$text_domain ), 'property' => 'goodpractice_designation' ),
            array ( 'title' => __( 'Nom Court', Oak::$text_domain ), 'property' => 'goodpractice_short_designation' ),
            array ( 'title' => __( 'Lien', Oak::$text_domain ), 'property' => 'goodpractice_link' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/goodpractices/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/goodpractices/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/goodpractices/functions/data-collector.php';
    }

    public static function add_good_practice_meta_box_view( $post, $args ) {
        $selected_goodpractices = get_post_meta( get_the_ID(), 'good_practices_selector' ) ? get_post_meta( get_the_ID(), 'good_practices_selector' ) [0] : [];
        ?>
        <input type="text" placeholder="<?php _e( 'Rechercher', Oak::$text_domain ); ?>" class="oak_post_search_input oak_post_goodpractices_selector_search_input">
        <br>
        <div>
            <select multiple name="good_practices_selector[]" class="oak_post_selector oak_post_good_practices_selector" size="<?php echo( count( Oak::$goodpractices_without_redundancy ) ); ?>">
                <?php
                foreach( Oak::$goodpractices_without_redundancy as $goodpractice ) :
                    $selected = '';
                    foreach( $selected_goodpractices as $selected_goodpractice_identifier ) :
                        if ( $selected_goodpractice_identifier == $goodpractice->goodpractice_identifier ) :
                            $selected = 'selected';
                        endif;
                    endforeach;
                    ?>
                    <option <?php echo( $selected ); ?> value="<?php echo( $goodpractice->goodpractice_identifier ); ?>"><?php echo( $goodpractice->goodpractice_designation ); ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>
        <?php
    }
}

$goodpractices = new Good_Practices();