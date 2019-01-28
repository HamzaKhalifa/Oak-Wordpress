<?php
include get_template_directory() . '/template-parts/oak-admin-header.php'; 
?>

<div class="oak_add_field_container__header">
    <img class="oak_add_field_container_header_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
    <h3 class="oak_add_field_container__title"><?php _e( 'Ajouter un champ', Oak::$text_domain ); ?></h3>
</div>
    
<div class="oak_add_field_big_container">
    <div class="oak_add_field_container">
        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="designation"><?php _e( 'Désignation du champ: ', Oak::$text_domain ); ?></label> 
                <input name="designation" <?php if ( count( $revisions ) > 0 ) : echo('disabled'); endif; ?> type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->field_designation ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__designation">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="identifier"><?php _e( 'Identifiant Unique: ', Oak::$text_domain ); ?></label> 
                <input disabled name="identifier" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->field_identifier ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__identifier">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_left_field oak_add_field_container__field_container oak_add_field_container__type_container">
                <label class="oak_add_field_container__label" for="nature"><?php _e( 'Nature du champ: ', Oak::$text_domain ); ?></label> 
                <select name="nature" type="text" class="oak_add_field_container__input oak_add_field_container__type">
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
                    <option <?php echo( $selected[0] ); ?> value="Texte">Texte</option>
                    <option <?php echo( $selected[1] ); ?> value="Zone de Texte">Zone De Texte</option>
                    <option <?php echo( $selected[2] ); ?> value="Image">Image</option>
                    <option <?php echo( $selected[3] ); ?> value="Fichier">Fichier</option>
                </select>
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__function_container">
                <label class="oak_add_field_container__label" for="function"><?php _e( 'Fonction: ', Oak::$text_domain ); ?></label> 
                <select name="function" type="text" class="oak_add_field_container__input oak_add_field_container__function">
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
                    <option <?php echo( $selected[0] ); ?> value="Information/Description">Information/Description</option>
                    <option <?php echo( $selected[1] ); ?>  value="Exemple">Exemple</option>
                    <option <?php echo( $selected[2] ); ?> value="Illustration">Illustration</option>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__field_container oak_add_field_container__default_value_container">
            <label class="oak_add_field_container__label" for="default-value"><?php _e( 'Valeur par défaut: ', Oak::$text_domain ); ?></label> 
            <input name="default-value" value="<?php if ( isset( $revisions[ count( $revisions ) - 1 ]->field_default_value ) ) : echo( $revisions[ count( $revisions ) - 1 ]->field_default_value ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__default_value"></textarea>
        </div>

        <div class="oak_add_field_container__field_container oak_add_field_container__placeholder_container">
            <label class="oak_add_field_container__label" for="placeholder"><?php _e( 'Description du champ: ', Oak::$text_domain ); ?></label> 
            <input name="placeholder" value="<?php if ( isset( $revisions[ count( $revisions ) - 1 ]->field_placeholder ) ) : echo( $revisions[ count( $revisions ) - 1 ]->field_placeholder ); endif; ?>" type="text" class="oak_add_field_container__input oak_add_field_container__placeholder">
        </div>

        <div class="oak_add_field_container__field_container oak_add_field_container__instructions_container">
            <label class="oak_add_field_container__label oak_add_field_container__label_instruction" for="instructions"><?php _e( 'Consignes de remplissage: ', Oak::$text_domain ); ?></label> 
            <textarea cols="30" rows="2" name="instructions" class="oak_add_field_container__input oak_add_field_container__instructions"><?php if ( isset( $revisions[ count( $revisions ) - 1 ]->field_instructions ) ) : echo( $revisions[ count( $revisions ) - 1 ]->field_instructions ); endif; ?></textarea>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__before_container">
                <label class="oak_add_field_container__label" for="before"><?php _e( 'Avant: ', Oak::$text_domain ); ?></label> 
                <input name="before" value="<?php if ( isset( $revisions[ count( $revisions ) - 1 ]->field_before ) ) : echo( $revisions[ count( $revisions ) - 1 ]->field_before ); endif; ?>" type="text" class="oak_add_field_container__input oak_add_field_container__before">
            </div>
            
            <div class="oak_add_field_container__field_container oak_add_field_container__max_length_container">
                <label class="oak_add_field_container__label" for="max-length"><?php _e( 'Nombre maximum de caractères: ', Oak::$text_domain ); ?></label> 
                <input name="max-length" type="number" value="<?php if ( isset( $revisions[ count( $revisions ) - 1 ]->field_max_length ) ) : echo( $revisions[ count( $revisions ) - 1 ]->field_max_length ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__max_length">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__after_container">
                <label class="oak_add_field_container__label" for="after"><?php _e( 'Après: ', Oak::$text_domain ); ?></label> 
                <input name="after" type="text" value="<?php if ( isset( $revisions[ count( $revisions ) - 1 ]->field_after ) ) : echo( $revisions[ count( $revisions ) - 1 ]->field_after ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__after">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__selector_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_selector" for="selector"><?php _e( 'Sélecteur de cadres RSE: ', Oak::$text_domain ); ?></label>
                <input name="selector" type="checkbox" <?php if ( isset( $revisions[ count( $revisions ) - 1 ]->field_selector ) && $revisions[ count( $revisions ) - 1 ]->field_selector == 'true' ) : echo( 'checked' ); endif; ?> class="oak_add_field_container__input oak_add_field_container__selector">
            </div>
        </div>

        <div class="oak_add_field_container__buttons">
            <div class="oak_add_field_container_buttons__right_buttons">
                <?php 
                if ( isset( $_GET['field_identifier'] ) ) : ?>
                    <div class="oak_add_field_container__trash_button">
                        <span><?php _e( 'Envoyer à la corbeille', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>

                <?php 
                if ( isset( $_GET['field_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->field_state == 1 ) : ?>
                    <div class="oak_add_field_container__draft_button">
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
                
                <div class="oak_add_field_container__register_button <?php if ( isset( $_GET['field_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->field_state == 1 ) : echo( 'oak_hidden' ); endif; ?>">
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
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id="">
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
                                            <option value="<?php Oak::$forms_without_redundancy[ $forms_counter ]->form_identifier ?>"><?php echo( Oak::$forms_without_redundancy[ $forms_counter ]->form_designation ); ?></option>
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

            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Modèles: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id="">
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
                                                            <option value="<?php $model->model_identifier ?>"><?php echo( $model->model_designation ); ?></option>
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
                    foreach( $revisions as $key => $revision ) : 
                        if ( $key != count( $revisions ) - 1 ) :
                        ?>
                            <div index="<?php echo( $key ) ?>" class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                <span class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( $revision->field_modification_time ); ?></span>
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