<?php $state_property = $table . '_state'; ?>

<div class="oak_element_header">
    <div class="oak_element_header_left">
        <i class="oak_menu_icon oak_menu_icon__cancel_icon fas fa-times"></i>

        <?php 
        $number_of_elements_selected_text = '';
        if ( $table == 'form' ) :
            $number_of_elements_selected_text = 'Champ(s) sélectionné(s)';
        elseif ( $table == 'model' ) :
            $number_of_elements_selected_text = 'Modèle(s) sélectinné(s)';
        endif;
        ?>
        <h3 class="oak_element_header_title"><?php echo( $title ); ?></h3>
        <?php if ( $table == 'form' || $table == 'model' ) : ?> 
        <span class="oak_selected_other_elements_number_indicator">
            <span class="oak_number_of_selected_elements_text">-</span> 
            <span class="oak_number_of_other_selected_elements">0</span>
            <span class="oak_number_of_selected_elements_text"><?php echo( $number_of_elements_selected_text ); ?></span>
        </span>
        <?php endif; ?>
    </div>

    <div class="oak_element_header_right">

        <?php
        if ( isset( $_GET[ $table . '_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->$state_property == 1 ) : ?>
            <div class="oak_add_element_container__draft_button">
                <span><?php _e( 'Retour à l\'état de Brouillon', Oak::$text_domain ); ?></span>
            </div>
        <?php 
        endif;
        if ( isset( $_GET[ $table . '_identifier'] ) ) : 
            $add_text = '';
            if ( $revisions[ count( $revisions ) - 1 ]->$state_property == 0 ) :
                $add_text = 'Sauvegarder le brouillon';
            elseif ( $revisions[ count( $revisions ) - 1 ]->$state_property == 1 ) :
                $add_text = 'Enregistrer';
            else :
                $add_text = 'Mettre à jour';
            endif;
            ?>
            <div class="oak_add_element_container__update_button">
                <span><?php echo( $add_text ); ?></span>
            </div>
        <?php
        else : ?>
            <div class="oak_add_element_container__add_button">
                <span><?php _e( 'Ajouter au Brouillon', Oak::$text_domain ); ?></span>
            </div>
        <?php
        endif; 
        ?>
        
        <div class="oak_add_element_container__register_button <?php if ( isset( $_GET[ $table . '_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->$state_property == 1 ) : echo( 'oak_hidden' ); endif; ?>">
            <?php 
            $text = 'Enregistrer';
            if ( isset( $_GET[ $table . '_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->$state_property == '2' ) :
                $text = 'Retour à l\'état enregistré';
            endif;
            ?>
            <span><?php echo( $text ); ?></span>
        </div>

        <?php
        if ( isset( $_GET[ $table . '_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->$state_property == '1' ) : ?>
            <div class="oak_add_element_container__broadcast_button">
                <span><?php _e( 'Diffuser', Oak::$text_domain ); ?></span>
            </div>
            <?php
        endif;
        ?>
    </div>

    <div class="oak_element_header_right_other_elements_buttons oak_hidden">
        <i class="oak_other_elements_copy_button oak_menu_icon oak_menu_smaller_icon fas fa-copy"></i>
        <i class="oak_other_elements_delete_button oak_menu_icon oak_menu_smaller_icon fas fa-trash"></i>
    </div>
</div>
<!-- Done with the top bars -->

<!-- initializing property names -->
<?php 
$designation_property = $table . '_designation';
$identifier_property = $table . '_identifier';
$selector_property = $table . '_selector';
$locked_property = $table . '_locked';
$trashed_property = $table . '_trashed';
$state_property = $table . '_state';
$modification_time_property = $table . '_modification_time';
?>
<div class="oak_add_element_container__header">
    <img class="oak_add_element_container_header_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
    <h3 class="oak_add_element_container__title"><?php echo( $title ); ?></h3>
</div>
    
<div class="oak_add_element_big_container">
    <div class="oak_add_element_container">
        
        <div class="oak_add_element_container__horizontal_container">
            <!-- For the designation -->
            <div class="oak_text_field_container">
                <input type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $revisions[ count( $revisions ) - 1 ]->$designation_property ) ); endif; ?>" class="oak_text_field <?php echo( $table . '_designation_input' ); ?>">
                <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->$designation_property != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php _e( 'Designation', Oak::$text_domain ); ?></span>
                <div class="text_field_line <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->$designation_property != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                <span class="text_field_description"><?php _e('Nom'); ?></span>
            </div>

            <!-- For the identifier -->
            <div class="oak_text_field_container_identifier">
                <input placeholder="Identifiant Unique  " type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $revisions[ count( $revisions ) - 1 ]->$identifier_property ) ); endif; ?>" disabled class="oak_text_field <?php echo( $table . '_identifier_input' ); ?>">
                <span class="oak_text_field_placeholder"><?php _e( '', Oak::$text_domain ); ?></span>
                <div class="text_field_line"></div>
                <span class="text_field_description"><?php _e('Identifiant technique'); ?></span>
            </div>

            <!-- For the selector -->
            <div class="oak_checkbox_container">
                <div class="oak_checkbox_container__container">
                    <span class="oak_text_field_checkbox_description"><?php _e( 'Sélecteur de cadre RSE', Oak::$text_domain ); ?></span>
                    <input name="selector" type="checkbox" <?php if ( isset( $revisions[ count( $revisions ) - 1 ]->$selector_property ) && $revisions[ count( $revisions ) - 1 ]->$selector_property == 'true' ) : echo( 'checked' ); endif; ?> class="oak_add_element_container__input <?php echo( $table . '_selector_input' ); ?>">
                </div>
                <div class="input_line"></div>
                <span class="text_field_description"><?php _e('Objects de cadres RSE'); ?></span>
            </div>
        </div>

        <?php 
        $selectors_values = [];
        if ( $table == 'object' && count( $revisions ) > 0 ) :
            $properties_and_selectors = explode( '|', $revisions[ count( $revisions ) - 1 ]->object_selectors );
            foreach( $properties_and_selectors as $property_and_selector ) :
                if ( $property_and_selector != '' ) :
                    $selectors_values[] = array(
                        'property' => explode( ':', $property_and_selector )[0],
                        'selector_value' => explode( ':', $property_and_selector )[1]
                    );
                endif;
            endforeach;
        endif; 

        $first = true;
        $form_designation = '';
        foreach( $properties as $key => $property ) :
            if ( isset( $property['model_and_form_instance'] ) ) :
                // For the form new designation: 
                $form_new_designation = $property['form']->form_designation;
                if ( $property['model_and_form_instance']->form_designation != '' ) :
                    
                    $form_new_designation = $property['model_and_form_instance']->form_designation;
                endif;
                if ( $form_designation != $form_new_designation ) :
                    $form_designation = $form_new_designation;
                ?>
                    <div class="oak_add_element_container__horizontal_container">
                        <h2 class="oak_add_element_formula_title"><?php echo( $form_new_designation ); ?></h2>
                    </div>
                    <?php 
                    $property['width'] = '100';
                    ?>
                <?php
                endif;
            endif;
            if ( $property['width'] == '100' || $first ) : ?>
                <div class="oak_add_element_container__horizontal_container"><?php
            endif;
            $property_name = $property['property_name'];
            if ( $property['input_type'] == 'text' || $property['input_type'] == 'number' ) : ?>
                <div class="oak_text_field_container">
                    <?php 
                    $input_class_prefix = '';
                    if ( $_GET['elements'] == 'objects' ) :
                        $input_class_prefix = 'object_';
                    endif;
                    ?>
                    <div class="additional_container">
                        <input type="<?php echo( $property['input_type'] ); ?>" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $revisions[ count( $revisions ) - 1 ]->$property_name ) ); endif; ?>" class="oak_text_field <?php echo( $table . '_' . $property['name'] . '_input' ) ?>">
                    </div>
                    <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->$property_name != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php echo( $property['placeholder'] ); ?></span>
                    <div class="text_field_line <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->property_name != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                    <span class="text_field_description"><?php echo( $property['description'] ); ?></span>
                </div><?php
            elseif ( $property['input_type'] == 'select' ) : ?>
                <div class="oak_select_container">
                    <div class="additional_container">
                        <select type="text" class="oak_add_element_container__input <?php echo( $table . '_' . $property['name'] . '_input' ) ?>">
                            <?php 
                            $selected = array();
                            foreach( $property['choices'] as $key => $choice ) :
                                array_push( $selected, 'notselected' );
                                if ( count( $revisions ) > 0 ) :
                                    if ( $revisions[ count( $revisions ) - 1 ]->$property_name == $choice['value'] ) :
                                        $selected[ $key ] = 'selected';
                                    endif;
                                endif;
                                ?>
                                <option <?php echo( esc_attr( $selected[ $key ] ) ); ?> value="<?php echo( $choice['value'] ); ?>"><?php echo( $choice['innerHTML'] ); ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="input_line"></div>
                    <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                    <span class="text_field_description"><?php echo( $property['description'] ); ?></span>
                </div>
            <?php
            elseif ( $property['input_type'] == 'checkbox' ) : ?>
                <div class="oak_checkbox_container">
                    <div class="oak_checkbox_container__container">
                        <span class="oak_text_field_checkbox_description"><?php echo( $property['placeholder'] ); ?></span>
                        <input name="selector" type="checkbox" <?php if ( isset( $revisions[ count( $revisions ) - 1 ]->$property_name ) && $revisions[ count( $revisions ) - 1 ]->$property_name == 'true' ) : echo( 'checked' ); endif; ?> class="oak_add_element_container__input <?php echo( $table . '_' . $property['name'] . '_input' ); ?>">
                    </div>
                    <div class="input_line"></div>
                    <span class="text_field_description"><?php $property['description'] ?></span>
                </div>
            <?php
            elseif ( $property['input_type'] == 'image' || $property['input_type'] == 'file' ) : ?>
                <div class="oak_checkbox_container oak_add_element_image_container">
                    <div class="oak_checkbox_container__container">
                        <input name="selector" onChange="readUrl(this)" type="file" class="oak_add_element_container__input <?php echo( $table . '_' . $property['name'] . '_input' ); ?>">
                        <img src="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->$property_name ); endif; ?>" class="oak_add_element_image_container" alt="">
                    </div>
                    <div class="input_line"></div>
                    <span class="text_field_description"><?php echo ( $property['description'] ); ?></span>
                </div>
            <?php
            endif;
            if ( $property['width'] == '100' || !$first || $key == count( $properties ) - 1 ) : ?>
                </div>
            <?php 
            endif;

            if ( $property['width'] == '50' )
                $first = !$first;
                
            if ( isset( $property['selector'] ) ) :
                if ( $property['selector'] == 'true' ) :
                    ?>
                    <div class="oak_select_container oak_select_container__selector">
                        <div class="additional_container">
                            <select type="text" class="oak_add_element_container__input <?php echo( $table . '_' . $property['name'] . '_selector' ) ?>">
                                <option value="0"><?php _e( 'Aucun object selectionné', Oak::$text_domain ); ?></option>
                                <?php 
                                foreach( Oak::$all_frame_objects_without_redundancy as $frame_object ) : 
                                    $selected = '';
                                    foreach( $selectors_values as $selector_value ) :
                                        if ( $selector_value['property'] == $property['name'] && $selector_value['selector_value'] == $frame_object->object_identifier ) :
                                            $selected = 'selected';
                                        endif;
                                    endforeach; 
                                ?>
                                    <option <?php echo( $selected ); ?> value="<?php echo( $frame_object->object_identifier ); ?>"><?php echo( $frame_object->object_designation ); ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="input_line"></div>
                        <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                        <span class="text_field_description"><?php _e( 'Selecteur de cadres RSE', Oak::$text_domain ); ?></span>
                    </div>
                    <?php
                endif;
            endif;

            // For the form selector
            if ( isset( $property['model_and_form_instance'] ) ) :
                $form_identifier = $property['form']->form_identifier;
                $at_the_end_of_form = false;
                if ( $key == count( $properties ) - 1 ) :
                    $at_the_end_of_form = true;
                elseif( $properties[ $key + 1 ]['form']->form_identifier != $form_identifier ) :
                    $at_the_end_of_form = true;
                endif;

                // We are gonna set the selector for the previous form:
                if ( $property['form']->form_selector == 'true' ) :
                    ?>
                    <div class="oak_select_container oak_select_container__selector">
                        <div class="additional_container">
                            <select type="text" class="oak_add_element_container__input <?php echo( 'object_form_selector' ) ?>" form-identifier="<?php echo( $property['form']->form_identifier ); ?>">
                                <option value="0"><?php _e( 'Aucun object selectionné', Oak::$text_domain ); ?></option>
                                <?php 
                                $object_form_selectors_attributes = [];
                                if ( count( $revisions ) > 0 ) :
                                    $object_form_selectors = $revisions[ count( $revisions ) - 1 ]->object_form_selectors;
                                    $object_form_selectors = explode( '|', $object_form_selectors );
                                    foreach( $object_form_selectors as $selector ) :
                                        if ( $selector != '' ) :
                                            $attributes = explode( '_', $selector );
                                            
                                            $object_form_selectors_attributes[] = array(
                                                'form' => $attributes[1],
                                                'object' => $attributes[3]
                                            );
                                        endif;
                                    endforeach;
                                endif;
                                
                                foreach( Oak::$all_frame_objects_without_redundancy as $frame_object ) : 
                                    $selected = '';
                                    foreach( $object_form_selectors_attributes as $object_form_attributes ) :
                                        if ( $object_form_attributes['form'] == $property['form']->form_identifier && $object_form_attributes['object'] == $frame_object->object_identifier ) :
                                            $selected = 'selected';
                                        endif;
                                    endforeach; 
                                ?>
                                    <option <?php echo( $selected ); ?> value="<?php echo( $frame_object->object_identifier ); ?>"><?php echo( $frame_object->object_designation ); ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="input_line"></div>
                        <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                        <span class="text_field_description"><?php _e( 'Selecteur de cadres RSE pour le formulaire', Oak::$text_domain ); ?></span>
                    </div>
                    <?php
                endif;
            endif;
                
        endforeach;
        ?>

        <!-- // This is for objects (We are gonna associate them to the terms) -->
        <?php 
        if ( $_GET['elements'] == 'objects' ) : ?>
            <div class="oak_objects_terms">
            <?php
            foreach( Oak::$taxonomies_without_redundancy as $taxonomy ) : ?>
                <div class="oak_add_element_terms_atribution_single_element">
                    <span class="oak_add_element_taxonomy_title"><?php echo( $taxonomy->taxonomy_designation ); ?></span>
                    <div class="autocomplete" style="width:300px;">
                        <div class="oak_admin_autocomplete_selections_container">
                            <?php 
                            if ( isset( $_GET['object_identifier'] ) ) :
                                foreach( Oak::$terms_and_objects as $term_and_object ) :
                                    if ( $term_and_object->object_identifier == $_GET['object_identifier'] ) :
                                        foreach( Oak::$all_terms_without_redundancy as $term ) :
                                            if ( $term->term_taxonomy_identifier == $taxonomy->taxonomy_identifier && $term->term_identifier == $term_and_object->term_identifier ) : ?>
                                                <div class="oak_autocomplete_selected_input_container">
                                                    <input type="text" disabled value="<?php echo ( $term->term_designation ); ?>" identifier="<?php echo( $term->term_identifier ); ?>" class="oak_autocomplete_selected_input">
                                                    <i class="oak_autocomplete_delete_button fas fa-minus"></i>
                                                </div>
                                            <?php
                                            endif;
                                        endforeach;
                                    endif;
                                endforeach;
                            endif;

                            if ( isset( $_GET['term_identifier'] ) ) :
                                foreach( Oak::$all_terms_without_redundancy as $term ) :
                                    if ( $term->term_taxonomy_identifier == $taxonomy->taxonomy_identifier && $term->term_identifier == $_GET['term_identifier'] ) : ?>
                                        <div class="oak_autocomplete_selected_input_container">
                                            <input type="text" disabled value="<?php echo ( $term->term_designation ); ?>" identifier="<?php echo( $term->term_identifier ); ?>" class="oak_autocomplete_selected_input">
                                            <i class="oak_autocomplete_delete_button fas fa-minus"></i>
                                        </div>
                                    <?php
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </div>
                        <input type="text" class="oak_autocomplete_input">
                        <select class="oak_autocomplete_select oak_hidden" id=""> 
                            <?php
                            foreach( Oak::$all_terms_without_redundancy as $term ) :
                                if ( $term->term_taxonomy_identifier == $taxonomy->taxonomy_identifier ) : ?>
                                    <option value="<?php echo( $term->term_identifier ); ?>"><?php echo( $term->term_designation ); ?></option>
                                <?php
                                endif;
                            endforeach;
                        ?>
                        </select>
                    </div>
                </div>
            <?php
            endforeach; ?>
            </div>
            <?php
        endif;
        ?>

        <?php
        if ( $table == 'form' || $table == 'model' ) :
            if ( $table == 'form' ) 
                $other_properties = Oak::$form_other_elements;
            if ( $table == 'model' )
                $other_properties = Oak::$model_other_elements;
        ?>
            <div class="oak_other_elements_container">
                <h2 class="oak_other_elements_container__title"><?php echo( $other_properties['title'] ); ?></h2>
                
                <div class="oak_other_elements_container__add_button">
                    <i class="fas fa-plus"></i>
                </div>

                <div class="oak_other_elements__single_elements_container">
                    <div class="oak_other_elements_single_elements_container__single_element oak_other_elements_single_elements_container__single_element_not_checked">
                        <div class="oak_other_elements_single_elements_container__final_selector_container">
                            <input type="checkbox" class="oak_add_other_elements_list_single_element__chekcbox">
                            <div class="oak_select_container">
                                <select type="text" class="oak_other_elements_select oak_add_element_container__input">
                                    <option value=""><?php echo( $other_properties['first_option'] ); ?></option>
                                    <?php
                                        foreach( $other_properties['elements'] as $element ) :
                                            $identifer_property = $other_properties['table'] . '_identifier';
                                            $designation_property = $other_properties['table'] . '_designation';
                                            ?>
                                            <option value="<?php echo( $element->$identifer_property ); ?>"><?php echo( $element->$designation_property ); ?></option>
                                            <?php
                                        endforeach;
                                    ?>
                                </select>
                                <div class="input_line"></div>
                                <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                                <span class="text_field_description"><?php echo( $other_properties['description'] ); ?></span>
                            </div>

                            <div class="oak_text_field_container">
                                <input type="text" value="" class="oak_text_field designation_input">
                                <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->$designation_property != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php _e( 'Nouvelle désignation', Oak::$text_domain ); ?></span>
                                <div class="text_field_line <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->$designation_property != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                                <span class="text_field_description"><?php echo( $other_properties['new_designation_description'] ); ?></span>
                            </div>

                            <div class="oak_checkbox_container">
                                <div class="oak_checkbox_container__container">
                                    <span class="oak_text_field_checkbox_description"><?php _e( 'Requis', Oak::$text_domain ); ?></span>
                                    <input name="selector" type="checkbox" <?php if ( isset( $revisions[ count( $revisions ) - 1 ]->$selector_property ) && $revisions[ count( $revisions ) - 1 ]->$selector_property == 'true' ) : echo( 'checked' ); endif; ?> class="oak_add_element_container__input selector_input">
                                </div>
                                <div class="input_line"></div>
                                <span class="text_field_description"><?php _e('Requis ou non lors du remplissage'); ?></span>
                            </div>
                        </div>
                        
                        <div class="oak_filters_container">
                            <?php
                                foreach( $other_properties['filters'] as $filter ) : ?>
                                    <div class="oak_select_container">
                                        <select type="text" class="oak_other_elements_select oak_add_element_container__input <?php echo( $filter['filter_name'] ); ?>">
                                            <option value="0"><?php echo( $filter['first_option'] ); ?></option>
                                            <?php
                                                foreach( $filter['choices'] as $choice ) :
                                                    ?>
                                                    <option value="<?php echo( $choice['value'] ); ?>"><?php echo( $choice['innerHTML'] ); ?></option>
                                                    <?php
                                                endforeach;
                                            ?>
                                        </select>
                                        <div class="input_line"></div>
                                        <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                                        <span class="text_field_description"><?php echo( $filter['title'] ); ?></span>
                                    </div>
                                <?php 
                                endforeach;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
        endif; 
        ?>
    </div>
    
    <div class="oak_add_element_big_container__tabs">
        <div class="oak_add_element_big_container_tabs__titles">
            <h4 class="oak_add_element_big_container_tabs_titles__single_title oak_add_element_big_container_tabs_titles__single_title_selected"><?php _e( 'Champ', Oak::$text_domain ); ?></h4>
        </div>

        <div class="oak_add_element_big_container_tabs__single_tab">
            <div class="oak_add_element_big_container_tabs_single_tab__section">
                <h5 class="oak_add_element_big_container_tabs_single_tab_section__title"><?php _e( 'Status et Visibilité: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state_label"><?php _e( 'Etat: ', Oak::$text_domain ); ?></span>
                    <?php 
                    $state = 'Brouillon';
                    if ( isset( $_GET[ $table . '_identifier'] ) ) :
                        if ( $revisions[ count( $revisions ) - 1 ]->$state_property == '0' ) : 
                            $state = 'Brouillon';
                        elseif ( $revisions[ count( $revisions ) - 1 ]->$state_property == '1' ) :
                            $state = 'Enregistré';
                        else : 
                            $state = 'Diffusé';
                        endif;
                    endif;
                    ?>
                    <span><?php echo( $state ); ?></span>
                </div>

                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state_label"><?php _e( 'Révisions: ', Oak::$text_domain ); ?></span>
                    <div class="oak_add_element_big_container_tabs_single_tab_section_state__info_container">
                        <span><?php 
                            if ( count( $revisions ) > 0 ) :
                                echo( count( $revisions ) - 1 );
                            else :
                                echo('0');
                            endif; 
                            ?>
                        </span>
                        <span class="oak_add_element_big_container_tabs_single_tab_section_state__browse">
                            <?php _e( 'Parcourir', Oak::$text_domain ); ?>
                        </span>
                    </div>
                </div>
                <?php
                    $registration_date = $broadcast_date = __( 'Pas encore', Oak::$text_domain );

                    if ( count( $revisions ) > 0 ) :
                        $last_revision = $revisions[ count( $revisions ) - 1 ];

                        $modification_time_property = $table . '_modification_time';

                        if ( $last_revision->$state_property == 1 ) :
                            $registration_date = $last_revision->$modification_time_property;
                        elseif ( $last_revision->$state_property == 2 ) :
                            $broadcast_date = $last_revision->$modification_time_property;
                            $index = 0;
                            for ( $i = count( $revisions ) - 2; $i >= 0; $i-- ) :
                                if ( $revisions[ $i ]->$state_property == 1 ) :
                                    $registration_date = $revisions[ $i ]->$modification_time_property;
                                endif;
                            endfor;
                        endif;
                    endif;
                ?>
                
                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state_label"><?php _e( 'Enregistré le: ', Oak::$text_domain ); ?></span>
                    <?php 
                    ?>
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state__info"><?php echo( $registration_date ); ?></span>
                </div>

                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state_label"><?php _e( 'Diffusé le: ', Oak::$text_domain ); ?></span>
                    <?php 
                    ?>
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state__info"><?php echo( $broadcast_date ); ?></span>
                </div>
            </div>

            <div class="oak_add_element_big_container_tabs_single_tab__section">
                <h5 class="oak_add_element_big_container_tabs_single_tab_section__title"><?php _e( 'Formulaires: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_element_big_container_tabs_single_tab_section__formulas_select" name="" id="">
                        <?php 
                        if ( count( $revisions ) > 0 ) :
                            $found_field = false;
                            $forms_counter = 0;
                            do {
                                $form_fields_array = explode( '|', Oak::$forms_without_redundancy[ $forms_counter ]->form_fields );
                                $form_fields_counter = 0;
                                do {
                                    $field_data = explode( ':', $form_fields_array[ $form_fields_counter ] );
                                    if ( count( $field_data ) > 1 ) :
                                        if ( $field_data[1] == $revisions[ count( $revisions ) - 1 ]->$identifier_property ) : 
                                            $found_field = true;
                                        ?>
                                            <option value="<?php Oak::$forms_without_redundancy[ $forms_counter ]->form_identifier ?>"><?php echo( esc_attr( Oak::$forms_without_redundancy[ $forms_counter ]->form_designation ) ); ?></option>
                                        <?php
                                        endif;
                                    endif;
                                    $form_fields_counter++;
                                } while( !$found_field && $form_fields_counter < count( $form_fields_array ) );
                                $forms_counter++;
                            } while ( $forms_counter < count( Oak::$forms_without_redundancy ) );
                        endif;
                        ?>
                    </select>

                    <span class="oak_select_go_button"><?php _e( 'Accéder', Oak::$text_domain ); ?></span>
                </div>
            </div>

            <div class="oak_add_element_big_container_tabs_single_tab__section">
                <h5 class="oak_add_element_big_container_tabs_single_tab_section__title"><?php _e( 'Modèles: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_element_big_container_tabs_single_tab_section__formulas_select" name="" id="">
                    <?php 
                        if ( count( $revisions ) > 0 ) :
                            foreach( Oak::$models_without_redundancy as $model ) :
                                $model_forms_array = explode( '|', $model->model_forms );
                                $model_forms_counter = 0;
                                $found_field = false;
                                do {
                                    $form_data = explode( ':', $model_forms_array[ $model_forms_counter ] );
                                    if ( count( $form_data ) > 0 ) :
                                        $form_identifier = $form_data[1];
                                        $oak_forms_counter = 0;
                                        do {
                                            if ( Oak::$forms_without_redundancy[ $oak_forms_counter ]->form_identifier == $form_identifier ) :
                                                $form_fields_array = explode( '|', Oak::$forms_without_redundancy[ $oak_forms_counter ]->form_fields );
                                                $form_fields_counter = 0;
                                                do {
                                                    $fields_data = explode( ':', $form_fields_array[ $form_fields_counter ] );
                                                    if ( count( $fields_data ) > 1 ) :
                                                        if ( $fields_data[1] == $revisions[ count( $revisions ) - 1 ]->$identifier_property ) : 
                                                            $found_field = true;
                                                        ?>
                                                            <option value="<?php $model->model_identifier ?>"><?php echo( esc_attr( $model->model_designation ) ); ?></option>
                                                        <?php
                                                        endif;
                                                    endif;
                                                    $form_fields_counter++;
                                                } while ( !$found_field && $form_fields_counter < count( $form_fields_array ) );
                                            endif;
                                            $oak_forms_counter++;
                                        } while ( !$found_field && $oak_forms_counter < count ( Oak::$forms_without_redundancy ) );
                                    endif;
                                    $model_forms_counter++;
                                } while ( !$found_field && $model_forms_counter < count( $model_forms_array ) );
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>

            <div class="oak_add_element_big_container_tabs_single_tab__section">
                <h5 class="oak_add_element_big_container_tabs_single_tab_section__title"><?php _e( 'Publications: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_element_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- For the modal -->
<div class="oak_add_element_modal_container">
    <div class="oak_add_element_modal_container__modal">
        <div class="oak_add_element_modal_container_modal__title_container">
            <h3 class="oak_add_element_modal_container_modal_title_container__title"></h3>
        </div>

        <div class="oak_add_element_modal_container_modal__content">

            <!-- For the browse revisions functionality -->
            <div class="oak_add_element_modal_container_modal_content__revisions_content oak_hidden">
                <div class="oak_add_element_modal_container_modal_content__revisions_content__current">
                    <h3><?php _e( 'Données Actuelle', Oak::$text_domain); ?></h3>
                    <!-- List of fields here -->
                    <?php 
                        $default_properties = array(
                            array( 'name' => 'designation', 'type' => 'text', 'description' => 'Designation' ),
                            array( 'name' => 'identifier', 'type' => 'text', 'description' => 'Identifiant' ),
                            array( 'name' => 'selector', 'type' => 'checkbox', 'description' => 'Selecteur de cadres RSE' ),
                            array( 'name' => 'locked', 'type' => 'checkbox', 'description' => 'Vérouillé' ),
                            array( 'name' => 'trashed', 'type' => 'checkbox', 'description' => 'Corbeille' ),
                            array( 'name' => 'state', 'type' => 'checkbox', 'description' => 'Etat' ),
                        );
                    ?>
                    <?php 
                    $which_properties = $table . '_properties'; 
                    $class = new ReflectionClass('Oak');
                    $properties = array_merge( $default_properties, $class->getStaticPropertyValue( $which_properties ) );
                    foreach( $properties as $property ) : ?>
                        <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                            <label><?php echo( $property['description'] ); ?></label>
                            <input name="type" type="text" disabled class="oak_revision_<?php echo( $property['name'] ); ?>_field_current" value="">
                        </div>
                    <?php
                    endforeach;
                    if ( $table == 'form' || $table == 'model' ) : ?>
                        <?php 
                        $element_inputs = array ( 
                            __( 'Désignation', Oak::$text_domain ), 
                            __( 'Identifiant', Oak::$text_domain ), 
                            __( 'renommage', Oak::$text_domain ), 
                            __( 'Sélecteur cadres RSE', Oak::$text_domain ) 
                        );
                        ?>
                        <div class="oak_other_elements_revision_inputs">
                            <h2 class="oak_other_elements_revision_title"><?php echo( $other_properties['title'] ); ?></h2>
                            <div class="oak_other_elements_revision_inputs__single_element_container">
                                <?php 
                                    foreach( $element_inputs as $element_input ) : ?>
                                        <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                                            <label><?php echo( $element_input ); ?></label>
                                            <input name="type" type="text" disabled value="">
                                        </div>
                                    <?php
                                    endforeach;
                                ?>
                            </div>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>

                <div class="oak_add_element_modal_container_modal_content_revisions_content__revision_data_container">
                    <h3><?php _e( 'Données de la révision', Oak::$text_domain); ?></h3>
                    <!-- Liste of fields here -->
                    <?php
                    foreach( $properties as $property ) : ?>
                        <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                            <label><?php echo( $property['description'] ); ?></label>
                            <input name="type" type="text" disabled class="oak_revision_<?php echo( $property['name'] ); ?>_field" value="">
                        </div>
                    <?php 
                    endforeach;

                    if ( $table == 'form' || $table == 'model' ) : ?>
                        <div class="oak_other_elements_actual_revision_revision_inputs">
                            <h2 class="oak_other_elements_revision_title"><?php echo( $other_properties['title'] ); ?></h2>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>

                <div class="oak_add_element_modal_container_modal_content_revisions_content__list_of_revisions">
                    <h3><?php _e( 'Liste des révisions', Oak::$text_domain ); ?></h3>
                    <?php 
                    foreach( $revisions as $key => $revision ) : 
                        if ( $key != count( $revisions ) - 1 ) :
                        ?>
                            <div index="<?php echo( $key ) ?>" class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                <?php
                                ?>
                                <span class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( esc_attr( $revision->$modification_time_property ) ); ?></span>
                            </div>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
            <!-- Done with the browse revisions Functionality -->
        </div>

        <span class="oak_add_element_modal_container_modal__error"></span>
        <div class="oak_add_element_modal_container_modal__buttons_container">
            <div class="oak_add_element_modal_container_modal_buttons_container__cancel_button_container">
                <span class="oak_add_element_modal_container_modal_buttons_container_cancel_button_container__text" >
                    Annuler
                </span>
            </div>
            
            <div class="oak_add_element_modal_container_modal_buttons_container__add_button_container">
                <span class="oak_add_element_modal_container_modal_buttons_container_add_button_container__text" >
                    Ajouter
                </span>
            </div>

            <div class="oak_add_element_modal_container_modal_buttons_container__ok_button_container">
                <span class="oak_add_element_modal_container_modal_buttons_container_add_button_container__text" >
                    Ok
                </span>
            </div>
        </div>
        
    </div>
    <div class="oak_loader"></div>
</div>