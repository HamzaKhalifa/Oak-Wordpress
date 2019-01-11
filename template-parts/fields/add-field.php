<?php
include get_template_directory() . '/template-parts/oak-admin-header.php'; 
?>

<h3 class="oak_add_field_container__title"><?php _e( 'Ajouter un champ', Oak::$text_domain ); ?></h3>
<div class="oak_add_field_big_container">
    <div class="oak_add_field_container">

        <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
            <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="designation"><?php _e( 'Désignation: ', Oak::$text_domain ); ?></label> 
            <input name="designation" <?php if ( isset( $current_field['designation'] ) ) : echo('disabled'); endif; ?> type="text" value="<?php if ( isset( $current_field['designation'] ) ) : echo( $current_field['designation'] ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__designation">
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__type_container">
                <label class="oak_add_field_container__label" for="nature"><?php _e( 'Nature du champ: ', Oak::$text_domain ); ?></label> 
                <select name="nature" type="text" class="oak_add_field_container__input oak_add_field_container__type">
                    <?php 
                    $selected = array('', '', '', '');
                    if ( isset( $current_field ) ) :
                        switch ( $current_field['type'] ) :
                            case 'Text': 
                                $selected[0] = 'selected';
                            break;
                            case 'Zone de Texte':
                                $selected[1] = 'selected';
                            break;
                            case 'Image': 
                                $selected[2] = 'selected';
                            break;
                            case 'File':
                                $selected[3] = 'selected';
                            break;
                        endswitch;
                    endif;
                    ?>
                    <option <?php echo( $selected[0] ); ?> value="Text">Text</option>
                    <option <?php echo( $selected[1] ); ?> value="Zone de Texte">Zone De Texte</option>
                    <option <?php echo( $selected[2] ); ?> value="Image">Image</option>
                    <option <?php echo( $selected[3] ); ?> value="File">Fichier</option>
                </select>
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__function_container">
                <label class="oak_add_field_container__label" for="function"><?php _e( 'Fonction: ', Oak::$text_domain ); ?></label> 
                <select name="function" type="text" class="oak_add_field_container__input oak_add_field_container__function">
                <?php 
                    $selected = array('', '', '');
                    if ( isset( $current_field ) ) :
                        switch ( $current_field['functionField'] ) :
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
                    <option <?php echo( $selected[0] ); ?> value="Information/Description">Information/Description</option>
                    <option <?php echo( $selected[1] ); ?>  value="Exemple">Exempel</option>
                    <option <?php echo( $selected[2] ); ?> value="Illustration">Illustration</option>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__field_container oak_add_field_container__default_value_container">
            <label class="oak_add_field_container__label" for="default-value"><?php _e( 'Valeur par défaut: ', Oak::$text_domain ); ?></label> 
            <input name="default-value" value="<?php if ( isset( $current_field['defaultValue'] ) ) : echo( $current_field['defaultValue'] ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__default_value"></textarea>
        </div>

        <div class="oak_add_field_container__field_container oak_add_field_container__placeholder_container">
            <label class="oak_add_field_container__label" for="placeholder"><?php _e( 'Description du champ: ', Oak::$text_domain ); ?></label> 
            <input name="placeholder" value="<?php if ( isset( $current_field['placeholder'] ) ) : echo( $current_field['placeholder'] ); endif; ?>"" type="text" class="oak_add_field_container__input oak_add_field_container__placeholder">
        </div>

        <div class="oak_add_field_container__field_container oak_add_field_container__instructions_container">
            <label class="oak_add_field_container__label oak_add_field_container__label_instruction" for="instructions"><?php _e( 'Consignes de remplissage: ', Oak::$text_domain ); ?></label> 
            <textarea cols="30" rows="2" name="instructions" class="oak_add_field_container__input oak_add_field_container__instructions"><?php if ( isset( $current_field['instructions'] ) ) : echo( $current_field['instructions'] ); endif; ?></textarea>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__before_container">
                <label class="oak_add_field_container__label" for="before"><?php _e( 'Avant: ', Oak::$text_domain ); ?></label> 
                <input name="before" value="<?php if ( isset( $current_field['before'] ) ) : echo( $current_field['before'] ); endif; ?>"" type="text" class="oak_add_field_container__input oak_add_field_container__before">
            </div>
            <div class="oak_add_field_container__field_container oak_add_field_container__after_container">
                <label class="oak_add_field_container__label" for="after"><?php _e( 'Après: ', Oak::$text_domain ); ?></label> 
                <input name="after" type="text" value="<?php if ( isset( $current_field['after'] ) ) : echo( $current_field['after'] ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__after">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__max_length_container">
                <label class="oak_add_field_container__label" for="max-length"><?php _e( 'Nombre de caractères maximum: ', Oak::$text_domain ); ?></label> 
                <input name="max-length" type="number" value="<?php if ( isset( $current_field['maxLength'] ) ) : echo( $current_field['maxLength'] ); endif; ?>"" class="oak_add_field_container__input oak_add_field_container__max_length">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__selector_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_selector" for="selector"><?php _e( 'Sélecteur de cadres RSE: ', Oak::$text_domain ); ?></label> 
                <input name="selector" type="checkbox" <?php if ( isset( $current_field['selector'] ) && $current_field['selector'] == 'on' ) : echo( 'checked' ); endif; ?> class="oak_add_field_container__input oak_add_field_container__selector">
            </div>
        </div>

        <div class="oak_add_field_container__buttons">
            <div class="oak_add_field_container__cancel_button">
                <span><?php _e( 'Annuler', Oak::$text_domain ); ?></span>
            </div>

            <div class="oak_add_field_container_buttons__right_buttons">
                <?php 
                if ( isset( $_GET['designation'] ) ) : ?>
                    <div class="oak_add_field_container__trash_button">
                        <span><?php _e( 'Envoyer à la corbeille', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>

                <?php 
                if ( isset( $_GET['designation'] ) && $current_field['state'] == 1 ) : ?>
                    <div class="oak_add_field_container__draft_button">
                        <span><?php _e( 'Retour à l\'état de Brouillon', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>
                

                <?php 
                if ( isset( $_GET['designation'] ) ) : 
                    $add_text = '';
                    if ( $current_field['state'] == 0 ) :
                        $add_text = 'Sauvegarder le brouillon';
                    elseif ( $current_field['state'] == 1 ) :
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
                
                <div class="oak_add_field_container__register_button <?php if ( isset( $_GET['designation'] ) && $current_field['state'] == 1 ) : echo( 'oak_hidden' ); endif; ?>">
                    <?php 
                    $text = 'Enregistrer';
                    if ( isset( $_GET['designation'] ) && $current_field['state'] == '2' ) :
                        $text = 'Retour à l\'état enregistré';
                    endif;
                    ?>
                    <span><?php echo( $text ); ?></span>
                </div>

                <?php
                if ( isset( $_GET['designation'] ) && $current_field['state'] == '1' ) : ?>
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
                    if ( isset( $_GET['designation'] ) ) :
                        if ( $current_field['state'] == 0 ) : 
                            $state = 'Brouillon';
                        elseif ( $current_field['state'] == '1' ) :
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
                        <span>
                            <?php
                            if ( isset( $_GET['designation'] ) ) :
                                echo( count( $current_field['revisions'] ) );
                            else :
                                echo( '0' );
                            endif;
                            ?>
                        </span>
                        <span class="oak_add_field_big_container_tabs_single_tab_section_state__browse">
                            <?php _e( 'Parcrourir', Oak::$text_domain ); ?>
                        </span>
                    </div>
                </div>
                <?php
                    $registration_date = $broadcast_date = $actual_registration_date = $actual_broadcast_date = __( 'Pas encore', Oak::$text_domain ); 
                    if ( isset( $_GET['designation'] ) ) :
                        if ( $current_field['state'] >= 1 ) :
                            if ( $current_field['state'] == 1 ) :
                                $registration_date = $current_field['modificationDate'];
                            else :
                                $broadcast_date = $current_field['modificationDate'];
                                $found_the_registered_revision = false;
                                $index = count( $current_field['revisions'] ) - 1;
                                do {
                                    if ( $current_field['revisions'][ $index ]['state'] == 1 ) :
                                        $registration_date = $current_field['revisions'][ $index ]['modificationDate'];
                                        $found_the_registered_revision = true;
                                    endif;

                                    $index--;
                                }
                                while( $found_the_registered_revision == false && $index > -1 );
                            endif;
                        endif;
                    endif;

                    if ( !strpos( $registration_date, 'encore' ) ) :
                        $formatted_registration_date = explode( ' ', $registration_date );
                        $actual_registration_date = '';
                        for ( $i = 0; $i < 5; $i++) {
                            $actual_registration_date = $actual_registration_date . $formatted_registration_date[ $i ] . ' ';
                        }
                    endif;

                    if ( !strpos( $broadcast_date, 'encore' ) ) :
                        $formatted_broadcast_date = explode( ' ', $broadcast_date );
                        $actual_broadcast_date = '';
                        for ( $i = 0; $i < 5; $i++) {
                            $actual_broadcast_date = $actual_broadcast_date . $formatted_broadcast_date[ $i ] . ' ';
                        }
                    endif;
                ?>
                
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state_label"><?php _e( 'Enregsitré le: ', Oak::$text_domain ); ?></span>
                    <?php 
                    ?>
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state__info"><?php echo( $actual_registration_date ); ?></span>
                </div>

                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state_label"><?php _e( 'Diffusé le: ', Oak::$text_domain ); ?></span>
                    <?php 
                    ?>
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state__info"><?php echo( $actual_broadcast_date ); ?></span>
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
                        <label for="type"><?php _e( 'Type:', Oak::$text_domain ); ?></label>

                        <input name="type" type="text" disabled class="oak_revision_type_field_current" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="function"><?php _e( 'Fonction:', Oak::$text_domain ); ?></label>
                        <input name="function" type="text" disabled class="oak_revision_function_field_current" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="default-value"><?php _e( 'Valeur par défaut:', Oak::$text_domain ); ?></label>
                        <input name="default-value" type="text" disabled class="oak_revision_default_value_field_current" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="placeholder"><?php _e( 'Description:', Oak::$text_domain ); ?></label>
                        <input name="placeholder" type="text" disabled class="oak_revision_placeholder_field_current" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="instructions"><?php _e( 'Instructions:', Oak::$text_domain ); ?></label>
                        <input name="instructions" type="text" disabled class="oak_revision_instructions_field_current" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="before"><?php _e( 'Avant:', Oak::$text_domain ); ?></label>
                        <input name="before" type="text" disabled class="oak_revision_before_field_current" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="after"><?php _e( 'Après:', Oak::$text_domain ); ?></label>
                        <input name="after" type="text" disabled class="oak_revision_after_field_current" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="max-length"><?php _e( 'Nombre de caractères maximum:', Oak::$text_domain ); ?></label>
                        <input name="max-length" type="text" disabled class="oak_revision_max_length_field_current" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="selector"><?php _e( 'Selecteur cadres RSE:', Oak::$text_domain ); ?></label>
                        <input name="selector" type="text" disabled class="oak_revision_selector_field_current" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="state"><?php _e( 'Etat:', Oak::$text_domain ); ?></label>
                        <input name="state" type="text" disabled class="oak_revision_state_field_current" value="">
                    </div>
                </div>

                <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content__revision_data_container">
                    <h3><?php _e( 'Données de la révision', Oak::$text_domain); ?></h3>
                    <!-- Liste of fields here -->
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="type"><?php _e( 'Type:', Oak::$text_domain ); ?></label>
                        <input name="type" type="text" disabled class="oak_revision_type_field" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="function"><?php _e( 'Fonction:', Oak::$text_domain ); ?></label>
                        <input name="function" type="text" disabled class="oak_revision_function_field" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="default-value"><?php _e( 'Valeur par défaut:', Oak::$text_domain ); ?></label>
                        <input name="default-value" type="text" disabled class="oak_revision_default_value_field" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="placeholder"><?php _e( 'Description:', Oak::$text_domain ); ?></label>
                        <input name="placeholder" type="text" disabled class="oak_revision_placeholder_field" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="instructions"><?php _e( 'Instructions:', Oak::$text_domain ); ?></label>
                        <input name="instructions" type="text" disabled class="oak_revision_instructions_field" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="before"><?php _e( 'Avant:', Oak::$text_domain ); ?></label>
                        <input name="before" type="text" disabled class="oak_revision_before_field" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="after"><?php _e( 'Après:', Oak::$text_domain ); ?></label>
                        <input name="after" type="text" disabled class="oak_revision_after_field" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="max-length"><?php _e( 'Nombre de caractères maximum:', Oak::$text_domain ); ?></label>
                        <input name="max-length" type="text" disabled class="oak_revision_max_length_field" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="selector"><?php _e( 'Selecteur cadres RSE:', Oak::$text_domain ); ?></label>
                        <input name="selector" type="text" disabled class="oak_revision_selector_field" value="">
                    </div>
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="state"><?php _e( 'Etat:', Oak::$text_domain ); ?></label>
                        <input name="state" type="text" disabled class="oak_revision_state_field" value="">
                    </div>
                </div>

                <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content__list_of_revisions">
                    <h3><?php _e( 'Liste des révisions', Oak::$text_domain ); ?></h3>
                    <?php 
                    if ( isset( $_GET['designation'] ) ) :
                        foreach( $current_field['revisions'] as $key => $revision ) : ?>
                            <div index="<?php echo( $key ) ?>" class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                <span class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( $revision['modificationDate'] ); ?></span>
                            </div>
                        <?php 
                        endforeach;
                        // var_dump( $current_field['revisions'] );
                    endif;
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