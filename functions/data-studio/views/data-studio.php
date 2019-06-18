<div class="oak_import_page">

    <div class="import_header import_header_screen_title_container">
        <div class="import_header__left_side">
            <i class="import_header_right_side__search_icon fas fa-times"></i>
            <h4 class="import_header_left_side__title screen_title"><?php _e( 'Organisations', Oak::$text_domain ); ?></h4>
        </div>
    </div>

    <div class="import_container">
        <div class="import_container__line">
            <div class="import_container_line__checkbox_container">
                <input type="checkbox" class="import_container__element_checkbox">
                <h4 class="import_container_line_column_value import_container_line__title"><?php _e( 'Nom de l\'organisation', Oak::$text_domain ); ?></h4>
            </div>
            <h4 class="import_container_line_column_value import_container_line__title"><?php _e( 'Pays du siège', Oak::$text_domain ); ?></h4>
            <h4 class="import_container_line_column_value import_container_line__title"><?php _e( 'Type', Oak::$text_domain ); ?></h4>
            <h4 class="import_container_line_column_value import_container_line__title"><?php _e( 'Secteur d\'activité', Oak::$text_domain ); ?></h4>
        </div>
    </div>

    <div class="next_button_container">
        <span class="next_button_container_cancel oak_hidden"><?php _e( 'Revenir', Oak::$text_domain ); ?></span>
        <span class="next_button_container_next oak_hidden"><?php _e( 'Etape suivante', Oak::$text_domain ); ?></span>
    </div>

    <div class="oak_graphs_configuration oak_hidden">

        <div class="oak_graphs_actual_config">
            <div class="oak_graphs_configuration__configuration_element_container">
                <h2><?php _e( 'Labels (Indicateurs de Pérformance:', Oak::$text_domain ); ?></h2>
                <div class="oak_graphs_configuration_configuration_element_container__labels">

                </div>
            </div>

            <div class="oak_graphs_configuration__configuration_element_container">
                <h2><?php _e( 'Données de performances:', Oak::$text_domain ); ?></h2>
                <div class="oak_graphs_configuration_configuration_element_container__performances">

                </div>
            </div>
        </div>

        <div class="oak_graphs_configuration__chart_container">
            <!-- <canvas class="oak_chart_container" width="400" height="400"></canvas> -->
        </div>

        <div class="oak_selected_graph_container oak_hidden">
            <div class="oak_selected_graph_container__configuration">
                <?php/*
                <div class="oak_selected_graph_legend_configuration_container">
                    <h2><?php _e( 'Configuration de la légende', Oak::$text_domain ); ?></h2>
                    <div class="oak_single_parameter">
                        <span class="oak_single_parameter__label"><?php _e( 'Display', Oak::$text_domain ); ?></span>
                        <input type="checkbox" property_nature="dataset" property_type="checkbox" property_name="display" class="oak_single_legend_parameter__input">
                    </div>

                    <div class="oak_single_parameter">
                        <span class="oak_single_parameter__label"><?php _e( 'Position', Oak::$text_domain ); ?></span>
                        <input type="text" value="" property_nature="dataset" property_type="normal" property_name="position" placeholder="top/left/bottom/right" class="oak_single_legend_parameter__input">
                    </div>

                    <div class="oak_single_parameter">
                        <span class="oak_single_parameter__label"><?php _e( 'Largeur maximale', Oak::$text_domain ); ?></span>
                        <input type="checkbox" property_nature="dataset" property_type="checkbox" property_name="fullWidth" class="oak_single_legend_parameter__input">
                    </div>

                    <div class="oak_single_parameter">
                        <span class="oak_single_parameter__label"><?php _e( 'Labels en ordre inversé', Oak::$text_domain ); ?></span>
                        <input type="checkbox" value="" property_nature="dataset" property_type="checkbox" property_name="reverse" class="oak_single_legend_parameter__input">
                    </div>

                    <div class="oak_selected_graph_legend_label_configuration_container">
                        <h3><?php _e( 'Label de la légende', Oak::$text_domain ); ?></h3>
                        
                        <div class="oak_single_parameter">
                            <span class="oak_single_parameter__label"><?php _e( 'Position', Oak::$text_domain ); ?></span>
                            <input type="text" value="" property_nature="dataset" property_type="normal" property_name="position" placeholder="top/left/bottom/right" class="oak_single_legend_parameter__input">
                        </div>
                    </div>
                </div>
                */?>
                
            </div>

            <span class="refresh_graph_button"><?php _e( 'Rafraîchir', Oak::$text_domain ); ?></span>

            <canvas class="oak_selected_graph"></canvas>

            <span class="oak_save_graph_button"><?php _e( 'Sauvegarder le graphe', Oak::$text_domain ); ?></span>
        </div>
        
    </div>

    
</div>


<!-- For the modal -->
<div class="oak_add_element_modal_container">
    <div class="oak_add_element_modal_container__modal">
        <div class="oak_add_element_modal_container_modal__title_container">
            <h3 class="oak_add_element_modal_container_modal_title_container__title"></h3>
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