<?php
include get_template_directory() . '/template-parts/oak-admin-header.php'; 
?>

<div class="oak_add_field_container__header">
    <img class="oak_add_field_container_header_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
    <h3 class="oak_add_field_container__title"><?php _e( 'Ajouter un indicateur qualitatifs', Oak::$text_domain ); ?></h3>
</div>

<div class="oak_add_field_big_container">
    <div class="oak_add_field_container">
        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="designation"><?php _e( 'Désignation de l\'Idicateur: ', Oak::$text_domain ); ?></label> 
                <input name="designation" <?php if ( count( $revisions ) > 0 ) : echo('disabled'); endif; ?> type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->quali_designation ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__designation">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="identifier"><?php _e( 'Identifiant Unique: ', Oak::$text_domain ); ?></label> 
                <input disabled name="identifier" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->quali_identifier ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__identifier">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="publication"><?php _e( 'Publication(s) dont est issue l\'Idicateur: ', Oak::$text_domain ); ?></label> 
                <select multiple class="oak_add_field_container__publication" name="publication" id="">
                    <?php 
                    $shown_publications = [];
                    foreach( Oak::$publications as $publication ) : 
                        $shown = false;
                        foreach( $shown_publications as $shown_publication ) :
                            if ( $shown_publication->publication_identifier == $publication->publication_identifier ) :
                                $shown = true;
                            endif;
                        endforeach;
                        if ( !$shown ) :
                            $shown_publications[] = $publication;

                            $selected = false;
                            if ( count( $revisions ) > 0 ) :
                                $selected_publications = explode ( ',', $revisions[ count( $revisions ) - 1 ]->quali_publication );
                                if ( in_array( $publication->publication_identifier, $selected_publications ) ) :
                                    $selected = true;
                                endif;
                            endif;
                        ?>
                            <option <?php if ( $selected ) : echo( 'selected' ); endif; ?> value="<?php echo ( $publication->publication_identifier ); ?>"><?php echo( $publication->publication_designation ); ?></option>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="object"><?php _e( 'L\'objet auquel appartient l\'indicateur: ', Oak::$text_domain ); ?></label> 
                <select class="oak_add_field_container__object" name="object" id="">
                    <?php 
                    
                    foreach( Oak::$objects as $object ) : ?>
                        <option value="<?php echo ( $object->ID ); ?>"><?php echo( $object->post_title ); ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container oak_left_field">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation"><?php _e( 'Indicateur dépendant d’un autre indicateur: ', Oak::$text_domain ); ?></label>
                <input type="checkbox" <?php if ( count ( $revisions ) > 0 ) : if( $revisions[ count( $revisions ) - 1 ]->quali_depends == 'true' ) : echo('checked'); endif; endif; ?> class="oak_add_field_container__depends">
            </div>
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container oak_hidden">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="sectors"><?php _e( 'Indicateur de niveau supérieur: ', Oak::$text_domain ); ?></label> 
                <select class="oak_add_field_container__parent" id="">
                    <?php 
                    $shown_indicators = [];
                    foreach( Oak::$qualis as $quali ) :
                        $exists = false;
                        foreach( $shown_indicators as $shown_indicator ) :
                            if ( $shown_indicator->quali_identifier == $quali->quali_identifier ) :
                                $exists = true;
                            endif;
                        endforeach; 
                        if ( count( $revisions ) > 0 ) :
                            if ( $quali->quali_identifier == $revisions[ count( $revisions ) - 1 ]->quali_identifier ) :
                                $exists = true;
                            endif;
                        endif;
                        if ( !$exists ) : 
                            $shown_indicators[] = $quali;
                            ?>
                            <option value="<?php echo( $quali->quali_identifier ); ?>"><?php echo( $quali->quali_designation ); ?></option>
                            <?php
                        endif;
                    endforeach; ?>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container oak_left_field">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation"><?php _e( 'Type de numérotation: ', Oak::$text_domain ); ?></label>
                <select class="oak_add_field_container__numerotation_type" id="">
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->quali_numerotation_type == 'I' ) : echo('selected'); endif; endif; ?> value="I">I</option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->quali_numerotation_type == '1' ) : echo('selected'); endif; endif; ?> value="1">1</option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->quali_numerotation_type == 'A' ) : echo('selected'); endif; endif; ?> value="A">A</option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->quali_numerotation_type == 'a' ) : echo('selected'); endif; endif; ?> value="a">a</option>
                </select>
            </div>
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="sectors"><?php _e( 'Numérotation ', Oak::$text_domain ); ?></label>
                <input value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->quali_numerotation ); endif; ?>" type="text" class="oak_add_field_container__numerotation">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="description"><?php _e( 'Définition de l\'Idicateur: ', Oak::$text_domain ); ?></label> 
                <textarea class="oak_add_field_container__input oak_add_field_container__description" name="description" id="" cols="30" rows="10"><?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->quali_description ); endif; ?></textarea>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container oak_left_field">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="close"><?php _e( 'Indicateur proche d’un ou plusieurs indicateur(s): ', Oak::$text_domain ); ?></label> 
                <input <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->quali_close == 'true' ) : echo('checked'); endif; endif; ?> type="checkbox" class="oak_add_field_container__input oak_add_field_container__close" name="close">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container oak_hidden">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="sectors"><?php _e( 'Indicateur(s) proches de l’indicateur en question: ', Oak::$text_domain ); ?></label> 
                <select multiple class="oak_add_field_container__close_indicators" id="">
                    <?php 
                        $shown_qualis = [];
                        foreach( Oak::$qualis as $quali ) : 
                            $shown = false;
                            foreach( $shown_qualis as $shown_quali ) :
                                if ( $quali->quali_identifier == $shown_quali->quali_identifier ) :
                                    $shown = true;
                                endif;
                            endforeach;
                            if ( count( $revisions ) > 0 ) :
                                if ( $quali->quali_identifier == $revisions[ count( $revisions ) - 1 ]->quali_identifier ) :
                                    $shown  = true;
                                endif;
                            endif;
                            if ( !$shown ) :
                                $shown_qualis[] = $quali;

                                $selected = false;
                                if ( count( $revisions ) > 0 ) :
                                    $selected_indicators = explode ( ',', $revisions[ count( $revisions ) - 1 ]->quali_close_indicators );
                                    if ( in_array( $quali->quali_identifier, $selected_indicators ) ) :
                                        $selected = true;
                                    endif;
                                endif;
                                ?>
                                <option <?php if( $selected ) : echo( 'selected' ); endif; ?> value="<?php echo( $quali->quali_identifier ); ?>"><?php echo( $quali->quali_designation ); ?></option>
                            <?php
                            endif;
                        endforeach;
                    ?>
                </select>
            </div>
        </div>
        
        <div class="oak_add_field_container__buttons">
            <div class="oak_add_field_container_buttons__right_buttons">
                <?php 
                if ( isset( $_GET['quali_identifier'] ) ) : ?>
                    <div class="oak_add_field_container__trash_button">
                        <span><?php _e( 'Envoyer à la corbeille', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>

                <?php 
                if ( isset( $_GET['quali_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->quali_state == 1 ) : ?>
                    <div class="oak_add_field_container__draft_button">
                        <span><?php _e( 'Retour à l\'état de Brouillon', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>
                

                <?php 
                if ( isset( $_GET['quali_identifier'] ) ) : 
                    $add_text = '';
                    if ( $revisions[ count( $revisions ) - 1 ]->quali_state == 0 ) :
                        $add_text = 'Sauvegarder le brouillon';
                    elseif ( $revisions[ count( $revisions ) - 1 ]->quali_state == 1 ) :
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
                
                <div class="oak_add_field_container__register_button <?php if ( isset( $_GET['quali_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->quali_state == 1 ) : echo( 'oak_hidden' ); endif; ?>">
                    <?php 
                    $text = 'Enregistrer';
                    if ( isset( $_GET['quali_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->quali_state == '2' ) :
                        $text = 'Retour à l\'état enregistré';
                    endif;
                    ?>
                    <span><?php echo( $text ); ?></span>
                </div>

                <?php
                if ( isset( $_GET['quali_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->quali_state == '1' ) : ?>
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
                    if ( isset( $_GET['quali_identifier'] ) ) :
                        if ( $revisions[ count( $revisions ) - 1 ]->quali_state == 0 ) : 
                            $state = 'Brouillon';
                        elseif ( $revisions[ count( $revisions ) - 1 ]->quali_state == '1' ) :
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
                        if ( $last_revision->quali_state == 1 ) :
                            $registration_date = $last_revision->quali_modification_time;
                        elseif ( $last_revision->quali_state == 2 ) :
                            $broadcast_date = $last_revision->quali_modification_time;
                            $index = 0;
                            for ( $i = count( $revisions ) - 2; $i >= 0; $i-- ) :
                                if ( $revisions[ $i ]->quali_state == 1 ) :
                                    $registration_date = $revisions[ $i ]->quali_modification_time;
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
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Organisations: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>

            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Organisations: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>

            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'qualis: ', Oak::$text_domain ); ?></h5>
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
                        <label for="publication"><?php _e( 'Publication(s) dont est issue l\'Indicateur:', Oak::$text_domain ); ?></label>
                        <input name="publication" type="text" disabled class="oak_revision_quali_current_publication" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="object"><?php _e( 'L\'objet auquel appartient l\'Idicateur:', Oak::$text_domain ); ?></label>
                        <input name="object" type="text" disabled class="oak_revision_quali_current_object" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="depends"><?php _e( 'Indicateur dépendant d’un autre:', Oak::$text_domain ); ?></label>
                        <input name="depends" type="text" disabled class="oak_revision_quali_current_depends" value="">
                    </div>
                    
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="parent"><?php _e( 'Indicateur de niveau supérieur:', Oak::$text_domain ); ?></label>
                        <input name="parent" type="text" disabled class="oak_revision_quali_current_parent" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="numerotation-type"><?php _e( 'Type de numérotation:', Oak::$text_domain ); ?></label>
                        <input name="numerotation-type" type="text" disabled class="oak_revision_quali_current_numerotation_type" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="numerotation"><?php _e( 'Numérotation:', Oak::$text_domain ); ?></label>
                        <input name="numerotation" type="text" disabled class="oak_revision_quali_current_numerotation" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="description"><?php _e( 'Description de l\'Idicateur:', Oak::$text_domain ); ?></label>
                        <input name="description" type="text" disabled class="oak_revision_quali_current_description" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="close"><?php _e( 'Indicateur(s) proche(s) de l\'Idicateur défnie:', Oak::$text_domain ); ?></label>
                        <input name="close" type="text" disabled class="oak_revision_quali_current_close" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="close-indicators"><?php _e( 'Indicateur(s) proche(s) de l\'Idicateur défnie:', Oak::$text_domain ); ?></label>
                        <input name="close-indicators" type="text" disabled class="oak_revision_quali_current_close_indicators" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="state"><?php _e( 'Etat:', Oak::$text_domain ); ?></label>
                        <input name="state" type="text" disabled class="oak_revision_quali_current_state" value="">
                    </div>
                </div>

                <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content__revision_data_container">
                    <h3><?php _e( 'Données de la révision', Oak::$text_domain); ?></h3>
                    <!-- List of forms here -->
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="publication"><?php _e( 'Publication(s) dont est issue l\'Idicateur:', Oak::$text_domain ); ?></label>
                        <input name="publication" type="text" disabled class="oak_revision_quali_revision_publication" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="object"><?php _e( 'L\'objet auquel appartient l\'Idicateur:', Oak::$text_domain ); ?></label>
                        <input name="object" type="text" disabled class="oak_revision_quali_revision_object" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="depends"><?php _e( 'Indicateur dépendante d’une autre:', Oak::$text_domain ); ?></label>
                        <input name="depends" type="text" disabled class="oak_revision_quali_revision_depends" value="">
                    </div>
                    
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="parent"><?php _e( 'Indicateur de niveau supérieur:', Oak::$text_domain ); ?></label>
                        <input name="parent" type="text" disabled class="oak_revision_quali_revision_parent" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="numerotation-type"><?php _e( 'Type de numérotation:', Oak::$text_domain ); ?></label>
                        <input name="numerotation-type" type="text" disabled class="oak_revision_quali_revision_numerotation_type" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="numerotation"><?php _e( 'Numérotation:', Oak::$text_domain ); ?></label>
                        <input value="" name="numerotation" type="text" disabled class="oak_revision_quali_revision_numerotation">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="description"><?php _e( 'Description de l\'Idicateur:', Oak::$text_domain ); ?></label>
                        <input name="description" type="text" disabled class="oak_revision_quali_revision_description" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="close"><?php _e( 'Indicateur(s) proche(s) de l\'Idicateur défnie:', Oak::$text_domain ); ?></label>
                        <input name="close" type="text" disabled class="oak_revision_quali_revision_close" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="close-indicators"><?php _e( 'Indicateur(s) proche(s) de l\'Idicateur défnie:', Oak::$text_domain ); ?></label>
                        <input name="close-indicators" type="text" disabled class="oak_revision_quali_revision_close_indicators" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="state"><?php _e( 'Etat:', Oak::$text_domain ); ?></label>
                        <input name="state" type="text" disabled class="oak_revision_quali_revision_state" value="">
                    </div>
                    
                </div>

                <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content__list_of_revisions">
                    <h3><?php _e( 'Liste des révisions', Oak::$text_domain ); ?></h3>
                    <?php 
                    foreach( $revisions as $key => $revision ) : 
                        if ( $key != count( $revisions ) - 1 ) :
                        ?>
                            <div index="<?php echo( $key ) ?>" class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                <span class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( $revision->quali_modification_time ); ?></span>
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