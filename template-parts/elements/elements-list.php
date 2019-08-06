<div class="oak_elements_list_top_container">
    <div class="oak_element_header">
        <div class="oak_element_header_left">
            <i class="oak_menu_icon oak_menu_icon__cancel_icon fas fa-long-arrow-alt-left"></i>
            <h3 class="oak_element_header_title"><?php echo( $title ); ?></h3>
            <div class="oak_list_add_button">
                <i class="fas fa-plus"></i>
            </div>
        </div>

        <div class="oak_element_header_right">
            <i class="oak_menu_icon oak_menu_smaller_icon oak_elemnt_header_right_edit_button oak_hidden fas fa-pen"></i>
            <i class="oak_menu_icon oak_menu_smaller_icon oak_element_header_right_upload_button fas fa-upload"></i>
            <i class="oak_menu_icon oak_menu_smaller_icon oak_element_header_right_download_button fas fa-download"></i>
            <i class="oak_menu_icon oak_menu_smaller_icon oak_element_header_right_copy_button oak_hidden fas fa-copy"></i>
            <i class="oak_menu_icon oak_menu_smaller_icon oak_element_header_right_delete_button oak_hidden fas fa-trash-alt"></i>
            <i class="oak_menu_icon oak_menu_smaller_icon oak_element_header_right_restore_button oak_hidden far fa-window-restore"></i>
        </div>
    </div>

    <div class="oak_grouped_actions">
        <div>
            <select class="oak_grouped_actions__element oak_grouped_actions__first_property_filter" name="" id="">
                <option <?php if( isset( $_GET['firstproperty'] ) ) : if ( $_GET['firstproperty'] == 'all' ) : echo('selected'); endif; endif; ?> value="all"><?php echo( $filters[0]['title'] ) ?></option>
                <?php 
                if ( count( $filters ) > 0  && isset( $filters[0]['choices'] ) ) :
                    foreach( $filters[0]['choices'] as $choice ) : ?>
                        <option <?php if( isset( $_GET['firstproperty'] ) ) : if ( $_GET['firstproperty'] == $choice['value'] ) : echo('selected'); endif; endif; ?> value="<?php echo( $choice['value'] ); ?>"><?php echo( $choice['innerHTML'] ); ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>

            <select class="oak_grouped_actions__element oak_grouped_actions__second_property_filter" name="" id="">
                <option value="all"><?php echo( $filters[1]['title'] ); ?></option>
                <?php
                if ( count( $filters ) > 1 && isset( $filters[1]['choices'] ) ) :
                    foreach( $filters[1]['choices'] as $choice ) : ?>
                        <option <?php if( isset( $_GET['secondproperty'] ) ) : if ( $_GET['secondproperty'] == $choice['value'] ) : echo('selected'); endif; endif; ?> value="<?php echo( $choice['value'] ); ?>"><?php echo( $choice['innerHTML'] ); ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>

            <select class="oak_grouped_actions__element oak_trash_list_select" name="" id="">
                <option value="not-trashed"><?php _e( 'Non supprimé', Oak::$text_domain ); ?></option>
                <option <?php if( isset( $_GET['trashed'] ) ) : if( $_GET['trashed'] == 'true' ) : echo('selected'); endif; endif; ?> value="trashed"><?php _e( 'Corbeille', Oak::$text_domain ); ?></option>
            </select>
            
            <span class="oak_grouped_actions__element oak_groupd_actions__filter_button"><?php _e( 'Filtrer', Oak::$text_domain ); ?></span>
        </div>

        <div>
            <select class="oak_grouped_actions__element oak_elements_list__sort_select" id="">
                <option value="default"><?php _e( 'Dernière modification', Oak::$text_domain ); ?></option>
                <option <?php if( isset( $_GET['sort'] ) ) : if( $_GET['sort'] == 'designation' ) : echo( 'selected' ); endif; endif; ?> value="designation"><?php _e( 'Désignation', Oak::$text_domain ); ?></option>
                <option <?php if( isset( $_GET['sort'] ) ) : if( $_GET['sort'] == 'first_property' ) : echo( 'selected' ); endif; endif; ?> value="first_property"><?php echo( $filters[0]['title'] ); ?></option>
                <option <?php if( isset( $_GET['sort'] ) ) : if( $_GET['sort'] == 'second_property' ) : echo( 'selected' ); endif; endif; ?> value="second_property"><?php echo( $filters[1]['title'] ); ?></option>
            </select>
        </div>
    </div>
    
    <div class="oak_elements_list">
        <div class="oak_list_row_top oak_list_row__first_row">
            <div class="oak_list_row__container">
                <input class="oak_passiv oak_list_titles_container__checkbox oak_select_all_checkbox" type="checkbox">
                <span class="oak_passiv oak_list_titles_container__title"><?php _e( 'Désignation', Oak::$text_domain ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <span class="oak_passiv oak_list_titles_container__title"><?php echo( $filters[0]['title'] ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <span class="oak_passiv oak_list_titles_container__title"><?php echo( $filters[1]['title'] ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <span class="oak_passiv oak_list_titles_container__title"><?php echo( $filters[2]['title'] ); ?></span>
            </div>

            <?php
            if ( isset( $filters[3] ) ) : ?>
                <div class="oak_list_row__container">
                    <span class="oak_passiv oak_list_titles_container__title"><?php echo( $filters[3]['title'] ); ?></span>
                </div>
                <?php
            endif;
            ?>

            <div class="oak_list_row__container">
                <i class="fas fa-file-invoice"></i>
                <span class="oak_passiv oak_list_titles_container__title"><?php _e( 'Dernière modification', Oak::$text_domain ); ?></span>
            </div>
        </div>

        <?php 
        $elements_to_show = [];
        $trashed_property = $table . '_trashed';
        foreach( $elements as $element ) :
            $show = true;
            
            $which_page = $_GET['whichpage'];
            if ( isset( $_GET['trashed'] ) ) :
                if ( $_GET['trashed'] == 'true' && $element->$trashed_property == 'false' || $_GET['trashed'] == 'false' && $element->$trashed_property == 'true' ) :
                    $show = false;
                endif;
            elseif( $element->$trashed_property == 'true' ) :
                $show = false;
            endif;

            if ( isset( $_GET['firstproperty'] ) && $_GET['firstproperty'] != 'all' ) :
                $first_property_property_name = $filters[0]['property'];
                if ( $element->$first_property_property_name != $_GET['firstproperty'] ) :
                    $show = false;
                endif;
            endif;

            if ( isset( $_GET['secondproperty'] ) && $_GET['secondproperty'] != 'all' ) :
                $second_property_property_name = $filters[1]['property'];
                if ( $element->$second_property_property_name != $_GET['secondproperty'] ) :
                    $show = false;
                endif;
            endif;

            if ( isset( $_GET['search_input'] ) && $_GET['search_input'] != '' ) : 
                $designation_property = $table . '_designation';
                if ( strpos( $element->$designation_property, $_GET['search_input'] ) === false ) :
                    $show = false;
                endif;
            endif;

            if ( $show ) :
                $elements_to_show[] = $element;
            endif;
        endforeach;

        if ( isset( $_GET['sort'] ) ) :
            if ( $_GET['sort'] != 'default' ) :
                if ( $_GET['sort'] == 'designation' ) :
                    $property = $table . '_designation';
                elseif ( $_GET['sort'] == 'first_property' ) :
                    $property = $filters[0]['property'];
                elseif ( $_GET['sort'] == 'second_property' ) :
                    $property = $filters[1]['property'];
                endif;
                update_option( 'oak_sort_property', $property );

                usort( $elements_to_show, function( $a, $b ) {
                    $property = get_option( 'oak_sort_property' );
                    return strcmp( $a->$property, $b->$property );
                } );
            endif;
        endif;
        
        $ELEMENTS_PER_PAGE = 30;
        foreach( $elements_to_show as $key => $element ) :
            // To handle pagination:
            
            $show = false;
            $which_page = $_GET['whichpage'];
            if ( $key >= $which_page * $ELEMENTS_PER_PAGE && $key <= ($which_page * $ELEMENTS_PER_PAGE) + $ELEMENTS_PER_PAGE - 1 ) :
                $show = true;
            endif;

            if ( $show ) :
                $designation_property = $table . '_designation';
                $language_property = $table . '_content_language';
                $identifier_property = $table . '_identifier';
                $modification_time_property = $table . '_modification_time';
                $the_first_property = $filters[0]['property'];
                $the_second_property = $filters[1]['property'];
                $the_third_property = $filters[2]['property'];
                $the_fourth_property = isset( $filters[3] ) ? $filters[3]['property'] : '';

                $designation_to_show = $element->$designation_property;

                if ( $element->$language_property != Oak::$site_language ) :
                    // The current element doesn't have the same language as the site language. So we look for the last element 
                    $index = count( $elements_with_redundancy ) - 1;
                    $found_element_of_same_language = false;
                    do {
                        if ( $element->$identifier_property == $elements_with_redundancy[ $index ]->$identifier_property
                        && $elements_with_redundancy[ $index ]->$language_property == Oak::$site_language ) :
                            $element = $elements_with_redundancy[ $index ];
                            $found_element_of_same_language = true;
                            $designation_to_show = $element->$designation_property;
                        endif;
                        $index--;
                    } while ( $index >= 0 && !$found_element_of_same_language );

                    if ( !$found_element_of_same_language ) :
                        // We are gonna change the designation here: 
                        $designation_to_show .= ' (' . $element->$language_property . ')';
                    endif;
                endif;
            ?>
                <div 
                    table="<?php echo( $table ); ?>" elements-name="<?php if( isset( $_GET['elements'] ) ) : echo( $_GET['elements'] ); else: /* this is for terms objects */ echo('objects'); endif; ?>"
                    <?php if( $table == 'object' ) : ?>
                    model-identifier="<?php echo( $element->object_model_identifier ); ?>"
                    <?php endif; ?> 
                    <?php if( $table == 'term' ) : ?>
                    taxonomy-identifier="<?php echo( $_GET['taxonomy_identifier'] ); ?>"
                    <?php endif; ?> 
                    identifier="<?php echo( $element->$identifier_property ); ?>" 
                    trashed="<?php echo( $element->$trashed_property ); ?>" 
                    class="oak_single_list_row"
                >
                    <div class="oak_list_row">
                        <div class="oak_list_row__container">
                            <i class="fas fa-sort-down oak_list_row__show_hide_children_button"></i>
                            <input class="oak_list_titles_container__checkbox" type="checkbox">
                            <span class="oak_list_titles_container__title oak_list_titles_container__the_title"><?php echo( esc_attr( $designation_to_show ) ); ?></span>
                        </div>

                        <div class="oak_list_row__container">
                            <?php
                            $first_property_value = $element->$the_first_property;
                            if ( $_GET['elements'] == 'publications' ) :
                                foreach( Oak::$organizations_without_redundancy as $organization ) :
                                    if ( $organization->organization_identifier == $first_property_value ) :
                                        $first_property_value = $organization->organization_designation;
                                    endif;
                                endforeach;
                            endif;
                            ?>
                            <span class="oak_list_titles_container__title oak_list_nature"><?php echo( esc_attr( $first_property_value ) ); ?></span>
                        </div>

                        <div class="oak_list_row__container">
                            <span class="oak_list_titles_container__title oak_list_function"><?php echo( esc_attr( $element->$the_second_property ) ); ?></span>
                        </div>

                        <div class="oak_list_row__container">
                            <span class="oak_list_titles_container__title"><?php echo( esc_attr( $element->$the_third_property ) ); ?></span>
                        </div>
                        
                        <?php
                        if ( isset( $filters[3] ) ) : ?>
                            <div class="oak_list_row__container">
                                <span class="oak_list_titles_container__title"><?php echo( esc_attr( $element->$the_fourth_property ) ); ?></span>
                            </div>
                        <?php
                        endif;
                        ?>
                        <div class="oak_list_row__container">
                            <span class="oak_list_titles_container__title"><?php echo( esc_attr( $element->$modification_time_property ) ); ?></span>
                        </div>
                    </div>
                    <div class="oak_list_row_child_elements_container oak_hidden">
                        <?php
                        if ( $table == 'organization' || $table == 'publication' || $table == 'taxonomy' || $table == 'model' || $table == 'form' ) :
                            $child_elements = Oak::oak_get_child_elements( $table, null );
                            if ( $child_elements != null ) :
                                Oak::oak_handle_child_elements_display( $child_elements, $element->$identifier_property, $table );
                            endif;
                        endif;
                        ?>
                    </div>
                </div>
            <?php
            endif;
        endforeach;
        ?>
    </div>

    <div class="oak_list_loader_and_pagination_container">
        <?php 
        $number_of_pages = intval( count( $elements_to_show ) / $ELEMENTS_PER_PAGE );
        $number_of_pages++;
        ?>

        <div class="oak_list_pagination_container">
        <?php 
            
            if ( $number_of_pages > 1 ) :
                for( $i = 0; $i < $number_of_pages; $i++ ) :
                    // if ( $_GET['whichpage'] != $i ) :
                        $current_link = substr( $_SERVER['QUERY_STRING'], 0, strpos( $_SERVER['QUERY_STRING'], 'whichpage' ) - 1 );
                    ?>
                        <a class="<?php if ( $_GET['whichpage'] != $i ) : echo( 'pagination__next' ); endif; ?> pagination_link <?php if( $_GET['whichpage'] == $i ) : echo( 'oak_selected_page_style' ); endif; ?>" href="<?php echo( admin_url() . '?' . $current_link . '&whichpage=' . $i ); ?>"><?php echo( $i + 1 ); ?></a>
                    <?php
                    // endif;
                endfor;
            endif;
            ?>
        </div>
        
        <div class="oak_infinite_scroll_loader oak_hidden"></div>

        <?php
        if ( $number_of_pages > 1 ) : ?>
            <span class="oak_list_loader_and_pagination_container__load_next"><?php _e( 'Next', Oak::$text_domain ); ?></span>
        <?php
        endif; 
        ?>
    </div>
    
</div>


<!-- For the modal -->
<div class="oak_add_element_modal_container">
    <div class="oak_add_element_modal_container__modal">
        <div class="oak_add_element_modal_container_modal__title_container">
            <h3 class="oak_add_element_modal_container_modal_title_container__title"></h3>
        </div>
        <div class="oak_add_element_modal_container_modal__models_list">
            <?php 
                foreach( Oak::$models_without_redundancy as $model ) : ?>
                    <div class="oak_modal_select_model_button" model-identifier="<?php echo( $model->model_identifier ); ?>">
                        <span class="oak_modal_select_model_button__span"><?php echo( $model->model_designation ); ?></span>
                        <i class="oak_admin_menu_element__arrow fas fa-caret-right"></i>
                    </div>
                <?php
                endforeach;
            ?>
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
                    Oui
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