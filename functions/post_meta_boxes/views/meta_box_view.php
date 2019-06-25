<?php
$selected_elements = get_post_meta( get_the_ID(), $args['id'] ) ? get_post_meta( get_the_ID(), $args['id'] )[0] : [];
$selected_elements_string = '';
foreach( $selected_elements as $key => $single_selected_element ) :
    $delimiter = ',';
    if ( $key == count( $selected_elements ) - 1 ) 
        $delimiter = '';
    $selected_elements_string .= $single_selected_element . $delimiter;
endforeach;

$elements = $args['args']['elements'];
?>
<div class="oak_post_elements_selector__container">
    <div class="oak_post_elements_selector_container__select_container">
        <input type="text" placeholder="<?php _e( 'Rechercher', Oak::$text_domain ); ?>" class="oak_post_search_input">
        <select multiple class="oak_post_selector oak_post_elements_selector" size="<?php echo( count( $elements ) ); ?>">
            <?php
            $identifier_property = $args['args']['element'] . '_identifier';
            $designation_property = $args['args']['element'] . '_designation';
            foreach( $elements as $element ) :
                $selected = '';
                foreach( $selected_elements as $selected_element_identifier ) :
                    if ( $selected_element_identifier == $element->$identifier_property ) :
                        $selected = 'selected';
                    endif;
                endforeach;
                ?>
                <option <?php echo( $selected ); ?> value="<?php echo( $element->$identifier_property ); ?>"><?php echo( $element->$designation_property ); ?></option>
                <?php
            endforeach;
            ?>
        </select>
    </div>
    <input type="hidden" value="<?php echo( $selected_elements_string ); ?>" name="<?php echo( $args['args']['select_name'] ); ?>" class="oak_post_elements_selector__selected_elements_values_container">
    <div class="oak_post_elements_selector__selected_elements">
        <div class="oak_post_elements_selector_selected_elements__single_element">
            <h3 class="oak_post_elements_selector_selected_elements_single_element__element_name">Element Name</h3>
            <i class="fas fa-times oak_post_elements_selector_selected_elements_single_element_element_remove_button"></i>
        </div>
    </div>
</div>