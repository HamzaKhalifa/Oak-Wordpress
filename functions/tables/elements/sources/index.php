<?php
class Sources {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Sources::$filters = array(
            array ( 'title' => __( 'Désignation', Oak::$text_domain ), 'property' => 'source_designation' ),
            array ( 'title' => __( 'Titre Court', Oak::$text_domain ), 'property' => 'source_short_title' ),
            array ( 'title' => __( 'Type', Oak::$text_domain ), 'property' => 'source_type' )
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

    public static function add_source_meta_box_view( $post, $args ) {
        $selected_sources = get_post_meta( get_the_ID(), 'sources_selector' ) ? get_post_meta( get_the_ID(), 'sources_selector' ) [0] : [];
        ?>
        <input type="text" placeholder="<?php _e( 'Rechercher', Oak::$text_domain ); ?>" class="oak_post_search_input oak_post_sources_selector_search_input">
        <br>
        <div>
            <select multiple name="sources_selector[]" class="oak_post_selector oak_post_sources_selector" size="<?php echo( count( Oak::$sources_without_redundancy ) ); ?>">
                <?php
                foreach( Oak::$sources_without_redundancy as $source ) :
                    $selected = '';
                    foreach( $selected_sources as $selected_source_identifier ) :
                        if ( $selected_source_identifier == $source->source_identifier ) :
                            $selected = 'selected';
                        endif;
                    endforeach;
                    ?>
                    <option <?php echo( $selected ); ?> value="<?php echo( $source->source_identifier ); ?>"><?php echo( $source->source_designation ); ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>
        <?php
    }
}

$sources = new Sources();