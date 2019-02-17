<!-- For the top bars (To replicate) -->
<?php
    include get_template_directory() . '/template-parts/admin-menu.php';
?>
<?php include( get_template_directory() . '/template-parts/system-bar.php' ); ?>
<div class="oak_app_bar">
    <div class="oak_app_bar__right_content">
        <i class="oak_menu_icon oak_menu_burger fas fa-bars"></i>
        <h2 class="oak_app_bar__title"><?php _e( 'Librairie de contenu', Oak::$text_domain ); ?></h2>
    </div>
    <div class="oak_app_bar__left_content">
        <input placeholder="<?php _e( 'Rechercher un champ', Oak::$text_domain ); ?>" class="oak_list_header_right__search_input oak_hidden" type="text">
        <i class="oak_menu_icon oak_menu_search_icon fas fa-search"></i>
        <i class="oak_menu_icon oak_menu_smaller_icon fas fa-th"></i>
        <i class="oak_menu_icon oak_menu_smaller_icon fas fa-ellipsis-v"></i>
    </div>
</div>
<!-- Done with the top bars -->

<div class="oak_add_element_container__header">
    <img class="oak_add_element_container_header_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
    <h3 class="oak_add_element_container__title"><?php _e( 'Ajouter un champ', Oak::$text_domain ); ?></h3>
</div>
    
<div class="oak_add_element_big_container">
    <div class="oak_add_element_container">
        <div class="oak_add_element_container__horizontal_container">
            <div class="oak_text_field_container">
                <input type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $revisions[ count( $revisions ) - 1 ]->field_designation ) ); endif; ?>" class="oak_text_field designation_input">
                <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->field_designation != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php _e( 'Designation', Oak::$text_domain ); ?></span>
                <div class="text_field_line <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->field_designation != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                <span class="text_field_description"><?php _e('Nom du champ'); ?></span>
            </div>

            <div class="oak_text_field_container_identifier">
                <input placeholder="Identifiant Unique" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $revisions[ count( $revisions ) - 1 ]->field_identifier ) ); endif; ?>" disabled value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $revisions[ count( $revisions ) - 1 ]->field_designation ) ); endif; ?>" class="oak_text_field identifier_input">
                <span class="oak_text_field_placeholder"><?php _e( '', Oak::$text_domain ); ?></span>
                <div class="text_field_line"></div>
                <span class="text_field_description"><?php _e('Identifiant technique du champ'); ?></span>
            </div>

            <div class="oak_checkbox_container">
                <div class="oak_checkbox_container__container">
                    <span class="oak_text_field_checkbox_description"><?php _e( 'Sélecteur de cadre RSE', Oak::$text_domain ); ?></span>
                    <input name="selector" type="checkbox" <?php if ( isset( $revisions[ count( $revisions ) - 1 ]->field_selector ) && $revisions[ count( $revisions ) - 1 ]->field_selector == 'true' ) : echo( 'checked' ); endif; ?> class="oak_add_element_container__input selector_input">
                </div>
                <div class="input_line"></div>
                <span class="text_field_description"><?php _e('Identifiant technique du champ'); ?></span>
            </div>
        </div>

        <div class="oak_add_element_container__horizontal_container">
            <div class="oak_select_container">
                <select name="nature" type="text" class="oak_add_element_container__input type_input">
                    <?php 
                    $selected = array('', '', '', '');
                    if ( count( $revisions ) > 0 ) :
                        switch ( $revisions[ count( $revisions ) - 1 ]->field_type ) :
                            case 'Texte': 
                                $selected[0] = 'selected';
                            break;
                            case 'Zone de Texte':
                                $selected[1] = 'selected';
                            break;
                            case 'Image': 
                                $selected[2] = 'selected';
                            break;
                            case 'Fichier':
                                $selected[3] = 'selected';
                            break;
                        endswitch;
                    endif;
                    ?>
                    <option <?php echo( esc_attr( $selected[0] ) ); ?> value="Texte">Texte</option>
                    <option <?php echo( esc_attr( $selected[1] ) ); ?> value="Zone de Texte">Zone De Texte</option>
                    <option <?php echo( esc_attr( $selected[2] ) ); ?> value="Image">Image</option>
                    <option <?php echo( esc_attr( $selected[3] ) ); ?> value="Fichier">Fichier</option>
                </select>
                <div class="input_line"></div>
                <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                <span class="text_field_description"><?php _e('Nature des contenus compris dans le champ'); ?></span>
            </div>


            <div class="oak_select_container">
                <select name="function" type="text" class="oak_add_element_container__input function_input">
                    <?php 
                    $selected = array('', '', '');
                    if ( count( $revisions ) > 0 ) :
                        switch ( $revisions[ count( $revisions ) - 1 ]->field_function ) :
                            case 'Information/Description': 
                                $selected[0] = 'selected';
                            break;
                            case 'Exemple':
                                $selected[1] = 'selected';
                            break;
                            case 'Illustration': 
                                $selected[2] = 'selected';
                            break;
                        endswitch;
                    endif;
                    ?>
                    <option <?php echo( esc_attr( $selected[0] ) ); ?> value="Information/Description">Information/Description</option>
                    <option <?php echo( esc_attr( $selected[1] ) ); ?>  value="Exemple">Exemple</option>
                    <option <?php echo( esc_attr( $selected[2] ) ); ?> value="Illustration">Illustration</option>
                </select>
                <div class="input_line"></div>
                <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                <span class="text_field_description"><?php _e('Fonction du champ en tant que message'); ?></span>
            </div>
        </div>

        <div class="oak_add_element_container__horizontal_container">
            <div class="oak_text_field_container">
                <input type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $revisions[ count( $revisions ) - 1 ]->field_tag ) ); endif; ?>" class="oak_text_field tag_input">
                <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->field_tag != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php _e( 'Etiquette (Optionnel)', Oak::$text_domain ); ?></span>
                <div class="text_field_line <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->field_tag != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                <span class="text_field_description"><?php _e('Contenu qui apparaitra dans le champ lorsqu\'il est inactif et non rempli. A défaut, la designation apparaitra.'); ?></span>
            </div>

            <div class="oak_text_field_container">
                <input type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $revisions[ count( $revisions ) - 1 ]->field_help ) ); endif; ?>" class="oak_text_field help_input">
                <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->field_help != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php _e( 'Aide au remplissage (Optionnel)', Oak::$text_domain ); ?></span>
                <div class="text_field_line <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->field_help != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                <span class="text_field_description"><?php _e('Contenu qui apparaitra sous le champ.'); ?></span>
            </div>
        </div>

        <div class="oak_add_element_container__horizontal_container">
            <div class="oak_text_field_container">
                <input type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $revisions[ count( $revisions ) - 1 ]->field_description ) ); endif; ?>" class="oak_text_field description_input">
                <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->field_description != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php _e( 'Description (Optionnel)', Oak::$text_domain ); ?></span>
                <div class="text_field_line <?php if( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->field_description != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                <span class="text_field_description"><?php _e('Instruction liée à la forme comme au fond à apporter au contenu. Elle apparaîtront dans le volet des composants (à droite)'); ?></span>
            </div>
        </div>

        <div class="oak_add_element_container__buttons">
            <div class="oak_add_element_container_buttons__right_buttons">
                <?php
                if ( isset( $_GET['field_identifier'] ) ) : ?>
                    <div class="oak_add_element_container__trash_button">
                        <span><?php _e( 'Envoyer à la corbeille', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>

                <?php 
                if ( isset( $_GET['field_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->field_state == 1 ) : ?>
                    <div class="oak_add_element_container__draft_button">
                        <span><?php _e( 'Retour à l\'état de Brouillon', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>
                

                <?php 
                if ( isset( $_GET['field_identifier'] ) ) : 
                    $add_text = '';
                    if ( $revisions[ count( $revisions ) - 1 ]->field_state == 0 ) :
                        $add_text = 'Sauvegarder le brouillon';
                    elseif ( $revisions[ count( $revisions ) - 1 ]->field_state == 1 ) :
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
                
                <div class="oak_add_element_container__register_button <?php if ( isset( $_GET['field_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->field_state == 1 ) : echo( 'oak_hidden' ); endif; ?>">
                    <?php 
                    $text = 'Enregistrer';
                    if ( isset( $_GET['field_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->field_state == '2' ) :
                        $text = 'Retour à l\'état enregistré';
                    endif;
                    ?>
                    <span><?php echo( $text ); ?></span>
                </div>

                <?php
                if ( isset( $_GET['field_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->field_state == '1' ) : ?>
                    <div class="oak_add_element_container__broadcast_button">
                        <span><?php _e( 'Diffuser', Oak::$text_domain ); ?></span>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
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
                    if ( isset( $_GET['field_identifier'] ) ) :
                        if ( $revisions[ count( $revisions ) - 1 ]->field_state == 0 ) : 
                            $state = 'Brouillon';
                        elseif ( $revisions[ count( $revisions ) - 1 ]->field_state == '1' ) :
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
                        if ( $last_revision->field_state == 1 ) :
                            $registration_date = $last_revision->field_modification_time;
                        elseif ( $last_revision->field_state == 2 ) :
                            $broadcast_date = $last_revision->field_modification_time;
                            $index = 0;
                            for ( $i = count( $revisions ) - 2; $i >= 0; $i-- ) :
                                if ( $revisions[ $i ]->field_state == 1 ) :
                                    $registration_date = $revisions[ $i ]->field_modification_time;
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
                                        if ( $field_data[1] == $revisions[ count( $revisions ) - 1 ]->field_identifier ) : 
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
                                                        if ( $fields_data[1] == $revisions[ count( $revisions ) - 1 ]->field_identifier ) : 
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
                    <?php $elements = array(
                        array( 'name' => 'Designation', 'class' => 'designation' ),
                        array( 'name' => 'Identifiant', 'class' => 'identifier' ),
                        array( 'name' => 'Selecteur de cadres RSE', 'class' => 'selector' ),
                        array( 'name' => 'Type', 'class' => 'type' ),
                        array( 'name' => 'Fonction ', 'class' => 'function' ),
                        array( 'name' => 'Etiquette', 'class' => 'tag' ),
                        array( 'name' => 'Aide', 'class' => 'help' ),
                        array( 'name' => 'Description', 'class' => 'description' ),
                        array( 'name' => 'Vériouillé', 'class' => 'locked' ),
                        array( 'name' => 'Corbeille', 'class' => 'trashed' ),
                        array( 'name' => 'Etat', 'class' => 'state' ),
                    );
                    foreach( $elements as $element ) : ?>
                        <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                            <label><?php echo( $element['name'] ); ?></label>
                            <input name="type" type="text" disabled class="oak_revision_<?php echo( $element['class'] ); ?>_field_current" value="">
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>

                <div class="oak_add_element_modal_container_modal_content_revisions_content__revision_data_container">
                    <h3><?php _e( 'Données de la révision', Oak::$text_domain); ?></h3>
                    <!-- Liste of fields here -->
                    <?php
                    foreach( $elements as $element ) : ?>
                        <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                            <label><?php echo( $element['name'] ); ?></label>
                            <input name="type" type="text" disabled class="oak_revision_<?php echo( $element['class'] ); ?>_field" value="">
                        </div>
                    <?php 
                    endforeach;
                    ?>
                </div>

                <div class="oak_add_element_modal_container_modal_content_revisions_content__list_of_revisions">
                    <h3><?php _e( 'Liste des révisions', Oak::$text_domain ); ?></h3>
                    <?php 
                    foreach( $revisions as $key => $revision ) : 
                        if ( $key != count( $revisions ) - 1 ) :
                        ?>
                            <div index="<?php echo( $key ) ?>" class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                <span class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( esc_attr( $revision->field_modification_time ) ); ?></span>
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