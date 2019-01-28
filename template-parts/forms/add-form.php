<?php
include get_template_directory() . '/template-parts/oak-admin-header.php'; 
?>

<div class="oak_add_field_container__header">
    <img class="oak_add_field_container_header_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
    <h3 class="oak_add_field_container__title"><?php _e( 'Ajouter un formulaire', Oak::$text_domain ); ?></h3>
</div>
    
<div class="oak_add_field_big_container">
    <div class="oak_add_field_container">
        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="designation"><?php _e( 'Désignation du formulaire: ', Oak::$text_domain ); ?></label> 
                <input name="designation" <?php if ( count( $revisions ) > 0 ) : echo('disabled'); endif; ?> type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->form_designation ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__designation">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="identifier"><?php _e( 'Identifiant Unique: ', Oak::$text_domain ); ?></label> 
                <input disabled name="identifier" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->form_identifier ); endif; ?>" class="oak_add_field_container__input oak_add_form_container__identifier">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="structure"><?php _e( 'Structure: ', Oak::$text_domain ); ?></label> 
                <select name="structure" class="oak_add_form_container__structure" id="">
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->form_structure == 'fixed') : echo('selected');  endif; endif; ?> value="fixed"><?php _e( 'Fixe', Oak::$text_domain ); ?></option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->form_structure == 'semi-structured') : echo('selected');  endif; endif; ?> value="semi-structured"><?php _e( 'Semi-Structuré/Non Structuré', Oak::$text_domain ); ?></option>
                </select>
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="identifier"><?php _e( 'Attributs: ', Oak::$text_domain ); ?></label> 
                <input name="identifier" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->form_attributes ); endif; ?>" class="oak_add_field_container__input oak_add_form_container__attributs">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__selector_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_selector" for="selector"><?php _e( 'Sélecteur de cadres RSE: ', Oak::$text_domain ); ?></label> 
                <input name="selector" type="checkbox" <?php if ( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->form_selector == 'true' ) : echo( 'checked' ); endif; ?> class="oak_add_field_container__input oak_add_field_container__selector">
            </div>
        </div>

        <div class="oak_add_form_fields_list">

            <!-- Single field data -->
            <?php
            if ( count( $revisions ) > 0 ) :
                $current_form = $revisions[ count( $revisions ) - 1 ];
                
                $fields_and_separators = $current_form->form_fields . $current_form->form_separators;
                $fields_and_separators = explode( '|', $fields_and_separators );
                $indexes = [];
                foreach( $fields_and_separators as $element ) :
                    $element_info = explode( ':', $element );
                    if ( count( $element_info ) > 2 ) :
                        $indexes[] = $element_info[5];
                    elseif ( count( $element_info ) > 1 ) :
                        $indexes[] = $element_info[1];
                    endif;
                endforeach;
                sort( $indexes );
                // var_dump( $indexes );
                // var_dump( $fields_and_separators );
                foreach( $indexes as $index ) :
                    foreach( $fields_and_separators as $fiel_or_separator ) :
                        $info = explode( ':', $fiel_or_separator );
                        if ( count( $info ) > 2 ) :
                            if ( $info[5] == $index ) : 
                                // echo('<pre>');
                                // var_dump( $info );
                                // echo('</pre>');
                            ?>
                                <div class="oak_add_form_fields_list__single_field">

                                    <div class="oak_add_field_container__isert_field_title_container oak_add_form_fields_list__horizontal oak_add_form_fields_list__horizontal_without_margin_top oak_add_form_field_options">
                                        <div class="oak_add_form_fields_list__horizontal">
                                            <img class="oak_add_form_container_header_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
                                            <h4 class="oak_add_field_container__isert_field_title"><?php _e( 'Insérer un champ' ); ?></h4>
                                        </div>

                                        <div class="oak_add_form_fields_list__buttons_container">
                                            <div class="oak_add_form_field_options__button oak_add_form_field_options_button_delete">
                                                <i class="fas fa-times"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="oak_add_form_fields_list__horizontal oak_add_form_fields_list__horizontal_without_margin_top">
                                        <div class="oak_add_form_fields_list__vertical oak_left_field">
                                            <label class="oak_add_field_label" for="type">Nature</label>
                                            <select class="oak_add_form_fields_list_horizontal__type_select" name="type" id="">
                                                <option value=""></option>
                                                <option value="Texte">Texte</option>
                                                <option value="Zone de Texte">Zone De Texte</option>
                                                <option value="Image">Image</option>
                                                <option value="File">Fichier</option>
                                            </select>
                                        </div>

                                        <div class="oak_add_form_fields_list__vertical">
                                            <label class="oak_add_field_label" for="type">Fonction</label>
                                            <select class="oak_add_form_fields_list_horizontal__function_select" name="type" id="">
                                                <option value=""></option>
                                                <option value="Information/Description">Information/Description</option>
                                                <option value="Exemple">Exemple</option>
                                                <option value="Illustration">Illustration</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="oak_add_form_fields_list__horizontal">
                                        <div class="oak_add_form_fields_list__vertical oak_left_field">
                                            <label class="oak_add_field_label" for="field-designation"><?php _e( 'Désignation', Oak::$text_domain ) ?></label>
                                            <select class="oak_add_form_fields_list_horizontal__designation_select" name="field-designation" id="">
                                                <?php 
                                                $added_fields = [];
                                                foreach( Oak::$fields as $field ) : 
                                                    $exists = false;
                                                    foreach( $added_fields as $added_field ) :
                                                        if ( $added_field->field_identifier == $field->field_identifier ) :
                                                            $exists = true;
                                                        endif;
                                                    endforeach;
                                                    if ( !$exists ) : 
                                                        $added_fields[] = $field;
                                                ?>
                                                        <option <?php if( $info[1] == $field->field_identifier ) : echo('selected'); endif; ?> value="<?php echo ( $field->field_identifier ); ?>"><?php echo( $field->field_designation ); ?></option>
                                                <?php 
                                                    endif;
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>

                                        <div class="oak_add_form_fields_list__vertical">
                                            <label class="oak_add_field_label" for="field-identifier">Identifiant Unique</label>
                                            <input value="<?php echo( $info[1] ); ?>" disabled name="field-identifier" type="text" value="" class="oak_add_field_container__input oak_add_form_field_identifier">
                                        </div>
                                    </div>

                                    <div class="oak_add_form_fields_list__horizontal">
                                        <div class="oak_add_form_fields_list__vertical oak_left_field">
                                            <label class="oak_add_field_label" for="field-identifier">Renommer</label>
                                            <input name="field-identifier" type="text" value="<?php echo( $info[2] ); ?>" class="oak_add_field_container__input oak_add_form_field_rename">
                                        </div>
                                        
                                        <div class="oak_add_form_fields_list__horizontal">
                                            <div class="oak_add_form_fields_list__horizontal oak_add_form_fields_list__horizontal_very_small oak_left_field">
                                                <label class="oak_add_field_label without_margin_bottom" for="field-required">Recquis</label>
                                                <input type="checkbox" <?php if ( $info[3] == 'true' ) : echo('checked'); endif; ?> class="oak_field_required_input">
                                            </div>
                                            <div class="oak_add_form_fields_list__horizontal oak_add_form_fields_list__horizontal_small">
                                                <label class="oak_add_field_label oak_add_field_label_width without_margin_bottom" for="">Largeur</label>
                                                <input type="number" value="<?php echo( $info[4] ); ?>" class="oak_field_width_input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Done with single field data -->
                            <?php 
                        endif;
                        elseif ( count( $info ) > 1 ) :
                            if ( $info[1] == $index ) : ?>
                            <div class="oak_add_form_seperator">
                                <span><?php echo( $info[0] ); ?></span>
                                <div class="oak_add_form_field_options__button oak_add_form__delete_separator_button">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                            <?php
                            endif;
                        endif;
                    endforeach;
                endforeach;
            endif;
            ?>

            
        </div>

        <div class="oak_add_form_field_buttons">
            <div class="oak_add_form_add_field_button">
                <img class="oak_add_form_add_field_button__icons" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
            </div>

            <div class="oak_add_form_add_line_button">
                <i class="fas fa-minus" class=""></i>
            </div>

            <div class="oak_add_form_add_space_button">
                <i class="fas fa-ticket-alt"></i>
            </div>
        </div>
        

        <div class="oak_add_field_container__buttons">
            <div class="oak_add_field_container_buttons__right_buttons">
                <?php 
                if ( isset( $_GET['form_identifier'] ) ) : ?>
                    <div class="oak_add_field_container__trash_button">
                        <span><?php _e( 'Envoyer à la corbeille', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>

                <?php 
                if ( isset( $_GET['form_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->form_state == 1 ) : ?>
                    <div class="oak_add_field_container__draft_button">
                        <span><?php _e( 'Retour à l\'état de Brouillon', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>
                

                <?php 
                if ( isset( $_GET['form_identifier'] ) ) : 
                    $add_text = '';
                    if ( $revisions[ count( $revisions ) - 1 ]->form_state == 0 ) :
                        $add_text = 'Sauvegarder le brouillon';
                    elseif ( $revisions[ count( $revisions ) - 1 ]->form_state == 1 ) :
                        $add_text = 'Enregistrer';
                    else :
                        $add_text = 'Mettre à jour';
                    endif;
                    ?>
                    <div class="oak_add_field_container__update_button">
                        <span><?php echo( $add_text ); ?></span>
                    </div>
                <?php
                else : ?>
                    <div class="oak_add_field_container__add_button">
                        <span><?php _e( 'Ajouter au Brouillon', Oak::$text_domain ); ?></span>
                    </div>
                <?php
                endif; 
                ?>
                
                <div class="oak_add_field_container__register_button <?php if ( isset( $_GET['form_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->form_state == 1 ) : echo( 'oak_hidden' ); endif; ?>">
                    <?php 
                    $text = 'Enregistrer';
                    if ( isset( $_GET['form_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->form_state == '2' ) :
                        $text = 'Retour à l\'état enregistré';
                    endif;
                    ?>
                    <span><?php echo( $text ); ?></span>
                </div>

                <?php
                if ( isset( $_GET['form_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->form_state == '1' ) : ?>
                    <div class="oak_add_field_container__broadcast_button">
                        <span><?php _e( 'Diffuser', Oak::$text_domain ); ?></span>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
    
    <div class="oak_add_field_big_container__tabs">
        <div class="oak_add_field_big_container_tabs__titles">
            <h4 class="oak_add_field_big_container_tabs_titles__single_title oak_add_field_big_container_tabs_titles__single_title_selected"><?php _e( 'Champ', Oak::$text_domain ); ?></h4>
        </div>

        <div class="oak_add_field_big_container_tabs__single_tab">
            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Status et Visibilité: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state_label"><?php _e( 'Etat: ', Oak::$text_domain ); ?></span>
                    <?php 
                    $state = 'Brouillon';
                    if ( isset( $_GET['form_identifier'] ) ) :
                        if ( $revisions[ count( $revisions ) - 1 ]->form_state == 0 ) : 
                            $state = 'Brouillon';
                        elseif ( $revisions[ count( $revisions ) - 1 ]->form_state == '1' ) :
                            $state = 'Enregistré';
                        else : 
                            $state = 'Diffusé';
                        endif;
                    endif;
                    ?>
                    <span><?php echo( $state ); ?></span>
                </div>

                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state_label"><?php _e( 'Révisions: ', Oak::$text_domain ); ?></span>
                    <div class="oak_add_field_big_container_tabs_single_tab_section_state__info_container">
                        <span><?php 
                            if ( count( $revisions ) > 0 ) :
                                echo( count( $revisions ) - 1 );
                            else :
                                echo('0');
                            endif; 
                            ?>
                        </span>
                        <span class="oak_add_field_big_container_tabs_single_tab_section_state__browse">
                            <?php _e( 'Parcourir', Oak::$text_domain ); ?>
                        </span>
                    </div>
                </div>
                <?php
                    $registration_date = $broadcast_date = __( 'Pas encore', Oak::$text_domain );

                    if ( count( $revisions ) > 0 ) :
                        $last_revision = $revisions[ count( $revisions ) - 1 ];
                        if ( $last_revision->form_state == 1 ) :
                            $registration_date = $last_revision->form_modification_time;
                        elseif ( $last_revision->form_state == 2 ) :
                            $broadcast_date = $last_revision->form_modification_time;
                            $index = 0;
                            for ( $i = count( $revisions ) - 2; $i >= 0; $i-- ) :
                                if ( $revisions[ $i ]->form_state == 1 ) :
                                    $registration_date = $revisions[ $i ]->form_modification_time;
                                endif;
                            endfor;
                        endif;
                    endif;
                ?>
                
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state_label"><?php _e( 'Enregistré le: ', Oak::$text_domain ); ?></span>
                    <?php 
                    ?>
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state__info"><?php echo( $registration_date ); ?></span>
                </div>

                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state_label"><?php _e( 'Diffusé le: ', Oak::$text_domain ); ?></span>
                    <?php 
                    ?>
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state__info"><?php echo( $broadcast_date ); ?></span>
                </div>
            </div>

            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Formulaires: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>

            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Modèles: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>

            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Publications: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- For the modal -->
<div class="oak_object_model_add_formula_modal_container">
    <div class="oak_object_model_add_formula_modal_container__modal">
        <div class="oak_object_model_add_formula_modal_container_modal__title_container">
            <h3 class="oak_object_model_add_formula_modal_container_modal_title_container__title"></h3>
        </div>

        <div class="oak_object_model_add_formula_modal_container__modal_content">

            <!-- For the browse revisions functionality -->
            <div class="oak_object_model_add_formula_modal_container_modal_content__revisions_content oak_hidden">
                <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content__current">
                    <h3><?php _e( 'Données Actuelle', Oak::$text_domain); ?></h3>
                    <!-- List of fields here -->
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="type"><?php _e( 'Structure:', Oak::$text_domain ); ?></label>
                        <input name="type" type="text" disabled class="oak_revision_form_current_structure" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="function"><?php _e( 'Attributs:', Oak::$text_domain ); ?></label>
                        <input name="function" type="text" disabled class="oak_revision_form_attributs_current" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="function"><?php _e( 'Sélecteur de cadres RSE:', Oak::$text_domain ); ?></label>
                        <input name="function" type="text" disabled class="oak_revision_form_selector_current" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="function"><?php _e( 'Status:', Oak::$text_domain ); ?></label>
                        <input name="function" type="text" disabled class="oak_revision_form_state_current" value="">
                    </div>

                </div>

                <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content__revision_data_container">
                    <h3><?php _e( 'Données de la révision', Oak::$text_domain); ?></h3>
                    <!-- List of fields here -->
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="type"><?php _e( 'Structure:', Oak::$text_domain ); ?></label>
                        <input name="type" type="text" disabled class="oak_revision_form_revision_structure" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="function"><?php _e( 'Attributs:', Oak::$text_domain ); ?></label>
                        <input name="function" type="text" disabled class="oak_revision_form_attributs_revision" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="function"><?php _e( 'Sélecteur de cadres RSE:', Oak::$text_domain ); ?></label>
                        <input name="function" type="text" disabled class="oak_revision_form_selector_revision" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="function"><?php _e( 'Status:', Oak::$text_domain ); ?></label>
                        <input name="function" type="text" disabled class="oak_revision_form_state_revision" value="">
                    </div>
                </div>

                <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content__list_of_revisions">
                    <h3><?php _e( 'Liste des révisions', Oak::$text_domain ); ?></h3>
                    <?php 
                    foreach( $revisions as $key => $revision ) : 
                        if ( $key != count( $revisions ) - 1 ) :
                        ?>
                            <div index="<?php echo( $key ) ?>" class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                <span class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( $revision->form_modification_time ); ?></span>
                            </div>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
            <!-- Done with the browse revisions Functionality -->
        </div>

        <span class="oak_object_model_add_formula_modal_container_modal__error"></span>
        <div class="oak_object_model_add_formula_modal_container_modal_buttons_container">
            <div class="oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container">
                <span class="oak_object_model_add_formula_modal_container_modal_buttons_container_cancel_button_container__text" >
                    Annuler
                </span>
            </div>
            
            <div class="oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container">
                <span class="oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text" >
                    Ajouter
                </span>
            </div>

            <div class="oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container">
                <span class="oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text" >
                    Ok
                </span>
            </div>
        </div>
        
    </div>
    <div class="oak_loader"></div>
</div>