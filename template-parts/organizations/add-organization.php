<?php
include get_template_directory() . '/template-parts/oak-admin-header.php'; 
?>

<div class="oak_add_field_container__header">
    <img class="oak_add_field_container_header_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
    <h3 class="oak_add_field_container__title"><?php _e( 'Ajouter une Organisation', Oak::$text_domain ); ?></h3>
</div>
    
<div class="oak_add_field_big_container">
    <div class="oak_add_field_container">
        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="designation"><?php _e( 'Désignation de l\'Organisation: ', Oak::$text_domain ); ?></label> 
                <input name="designation" <?php if ( count( $revisions ) > 0 ) : echo('disabled'); endif; ?> type="text" value="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->organization_designation ) ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__designation">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="identifier"><?php _e( 'Identifiant Unique: ', Oak::$text_domain ); ?></label> 
                <input disabled name="identifier" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->organization_identifier ) ); endif; ?>" class="oak_add_field_container__input oak_add_organization_container__identifier">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="acronym"><?php _e( 'Acronyme de l\'Organisation: ', Oak::$text_domain ); ?></label> 
                <input name="acronym" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->organization_acronym ) ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__acronym">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="logo"><?php _e( 'Logo: ', Oak::$text_domain ); ?></label> 
                <input type="file" class="oak_add_logo" onChange="readUrl(this)">
                <img src="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->organization_logo ) ); endif; ?>" class="oak_add_organization_container__logo_img" alt="">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="description"><?php _e( 'Identifiant de l’entreprise: ', Oak::$text_domain ); ?></label> 
                <textarea class="oak_add_field_container__input oak_add_organization_container__description" name="description" id="" cols="30" rows="10"><?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->organization_description ) ); endif; ?></textarea>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="url"><?php _e( 'Site Internet de l\'Organisation: ', Oak::$text_domain ); ?></label> 
                <input name="url" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->organization_url ) ); endif; ?>" class="oak_add_field_container__input oak_add_organization_container__url">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="address"><?php _e( 'Adresse du siège de l\'Organisation: ', Oak::$text_domain ); ?></label>
                <input name="address" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->organization_address ) ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__address">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="country"><?php _e( 'Pays du siège de l\'organisation: ', Oak::$text_domain ); ?></label>
                <?php 
                $countries = Oak::oak_get_countries_names();
                ?>
                <select name="country" type="text" class="oak_add_field_container__input oak_add_organization_container__country">
                    <?php 
                    foreach( $countries as $country ) : ?>
                        <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->organization_country == $country ) : echo('selected'); endif; endif; ?> value="<?php echo( $country ); ?>"><?php echo( $country ); ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="url"><?php _e( 'Une Entreprise: ', Oak::$text_domain ); ?></label> 
                <input name="url" type="checkbox" <?php if ( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->organization_company == 'true' ) : echo('checked'); endif; ?> class="oak_add_field_container__input oak_add_organization_container__company">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="type"><?php _e( 'Type: ', Oak::$text_domain ); ?></label> 
                <select name="type" <?php if ( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->organization_type == 'true' ) : echo('checked'); endif; ?> class="oak_add_field_container__input oak_add_organization_container__type">
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->organization_type == 'private' ) : echo('selected'); endif; endif; ?> value="private"><?php _e( 'Privé', Oak::$text_domain ); ?></option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->organization_type == 'public' ) : echo('selected'); endif; endif; ?> value="public"><?php _e( 'Publique', Oak::$text_domain ); ?></option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->organization_type == 'cooperative' ) : echo('selected'); endif; endif; ?> value="cooperative"><?php _e( 'Coopérative', Oak::$text_domain ); ?></option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->organization_type == 'subsidiary' ) : echo('selected'); endif; endif; ?> value="subsidiary"><?php _e( 'Filiale', Oak::$text_domain ); ?></option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->organization_type == 'public-institution' ) : echo('selected'); endif; endif; ?> value="public-institution"><?php _e( 'Institution publique', Oak::$text_domain ); ?></option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->organization_type == 'lucrative' ) : echo('selected'); endif; endif; ?> value="lucrative"><?php _e( 'Organisation à but no lucratif', Oak::$text_domain ); ?></option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->organization_type == 'partnership' ) : echo('selected'); endif; endif; ?> value="partnership"><?php _e( 'Partenariat', Oak::$text_domain ); ?></option>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="side"><?php _e( 'Entreprise cotée: ', Oak::$text_domain ); ?></label> 
                <input name="side" type="checkbox" <?php if ( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->organization_side == 'true' ) : echo('checked'); endif; ?> class="oak_add_field_container__input oak_add_organization_container__side">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="sectors"><?php _e( 'Secteurs d\'activité: ', Oak::$text_domain ); ?></label> 
                <input name="sectors" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->organization_sectors ); endif; ?>" class="oak_add_field_container__input oak_add_organization_container__sectors">
            </div>
        </div>

        <div class="oak_add_field_container__buttons">
            <div class="oak_add_field_container_buttons__right_buttons">
                <?php 
                if ( isset( $_GET['organization_identifier'] ) ) : ?>
                    <div class="oak_add_field_container__trash_button">
                        <span><?php _e( 'Envoyer à la corbeille', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>

                <?php 
                if ( isset( $_GET['organization_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->organization_state == 1 ) : ?>
                    <div class="oak_add_field_container__draft_button">
                        <span><?php _e( 'Retour à l\'état de Brouillon', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>
                

                <?php 
                if ( isset( $_GET['organization_identifier'] ) ) : 
                    $add_text = '';
                    if ( $revisions[ count( $revisions ) - 1 ]->organization_state == 0 ) :
                        $add_text = 'Sauvegarder le brouillon';
                    elseif ( $revisions[ count( $revisions ) - 1 ]->organization_state == 1 ) :
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
                
                <div class="oak_add_field_container__register_button <?php if ( isset( $_GET['organization_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->organization_state == 1 ) : echo( 'oak_hidden' ); endif; ?>">
                    <?php 
                    $text = 'Enregistrer';
                    if ( isset( $_GET['organization_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->organization_state == '2' ) :
                        $text = 'Retour à l\'état enregistré';
                    endif;
                    ?>
                    <span><?php echo( $text ); ?></span>
                </div>

                <?php
                if ( isset( $_GET['organization_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->organization_state == '1' ) : ?>
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
                    if ( isset( $_GET['organization_identifier'] ) ) :
                        if ( $revisions[ count( $revisions ) - 1 ]->organization_state == 0 ) : 
                            $state = 'Brouillon';
                        elseif ( $revisions[ count( $revisions ) - 1 ]->organization_state == '1' ) :
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
                        if ( $last_revision->organization_state == 1 ) :
                            $registration_date = $last_revision->organization_modification_time;
                        elseif ( $last_revision->organization_state == 2 ) :
                            $broadcast_date = $last_revision->organization_modification_time;
                            $index = 0;
                            for ( $i = count( $revisions ) - 2; $i >= 0; $i-- ) :
                                if ( $revisions[ $i ]->organization_state == 1 ) :
                                    $registration_date = $revisions[ $i ]->organization_modification_time;
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
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Publications: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
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
                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="acronym"><?php _e( 'Acronyme:', Oak::$text_domain ); ?></label>
                        <input name="acronym" type="text" disabled class="oak_revision_organization_current_acronym" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="logo"><?php _e( 'Logo:', Oak::$text_domain ); ?></label>
                        <input name="logo" type="text" disabled class="oak_revision_organization_current_logo" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="description"><?php _e( 'Déscription:', Oak::$text_domain ); ?></label>
                        <input name="description" type="text" disabled class="oak_revision_organization_current_description" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="url"><?php _e( 'url:', Oak::$text_domain ); ?></label>
                        <input name="url" type="text" disabled class="oak_revision_organization_current_url" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="address"><?php _e( 'Adresse:', Oak::$text_domain ); ?></label>
                        <input name="address" type="text" disabled class="oak_revision_organization_current_address" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="country"><?php _e( 'Pays:', Oak::$text_domain ); ?></label>
                        <input name="country" type="text" disabled class="oak_revision_organization_current_country" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="company"><?php _e( 'Entreprise:', Oak::$text_domain ); ?></label>
                        <input name="company" type="text" disabled class="oak_revision_organization_current_company" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="type"><?php _e( 'Type:', Oak::$text_domain ); ?></label>
                        <input name="type" type="text" disabled class="oak_revision_organization_current_type" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="side"><?php _e( 'Entreprise cotée:', Oak::$text_domain ); ?></label>
                        <input name="side" type="text" disabled class="oak_revision_organization_current_side" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="sector"><?php _e( 'Secteur d\'activité:', Oak::$text_domain ); ?></label>
                        <input name="sector" type="text" disabled class="oak_revision_organization_current_sectors" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="state"><?php _e( 'Status', Oak::$text_domain ); ?></label>
                        <input name="state" type="text" disabled class="oak_revision_organization_current_state" value="">
                    </div>
                </div>

                <div class="oak_add_element_modal_container_modal_content_revisions_content__revision_data_container">
                    <h3><?php _e( 'Données de la révision', Oak::$text_domain); ?></h3>
                    <!-- List of forms here -->
                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="acronym"><?php _e( 'Acronyme:', Oak::$text_domain ); ?></label>
                        <input name="acronym" type="text" disabled class="oak_revision_organization_revision_acronym" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="logo"><?php _e( 'Logo:', Oak::$text_domain ); ?></label>
                        <input name="logo" type="text" disabled class="oak_revision_organization_revision_logo" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="description"><?php _e( 'Déscription:', Oak::$text_domain ); ?></label>
                        <input name="description" type="text" disabled class="oak_revision_organization_revision_description" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="url"><?php _e( 'url:', Oak::$text_domain ); ?></label>
                        <input name="url" type="text" disabled class="oak_revision_organization_revision_url" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="address"><?php _e( 'Adresse:', Oak::$text_domain ); ?></label>
                        <input name="address" type="text" disabled class="oak_revision_organization_revision_address" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="country"><?php _e( 'Pays:', Oak::$text_domain ); ?></label>
                        <input name="country" type="text" disabled class="oak_revision_organization_revision_country" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="company"><?php _e( 'Entreprise:', Oak::$text_domain ); ?></label>
                        <input name="company" type="text" disabled class="oak_revision_organization_revision_company" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="type"><?php _e( 'Type:', Oak::$text_domain ); ?></label>
                        <input name="type" type="text" disabled class="oak_revision_organization_revision_type" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="side"><?php _e( 'Entreprise cotée:', Oak::$text_domain ); ?></label>
                        <input name="side" type="text" disabled class="oak_revision_organization_revision_side" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="sector"><?php _e( 'Secteur d\'activité:', Oak::$text_domain ); ?></label>
                        <input name="sector" type="text" disabled class="oak_revision_organization_revision_sectors" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="state"><?php _e( 'Status:', Oak::$text_domain ); ?></label>
                        <input name="state" type="text" disabled class="oak_revision_organization_revision_state" value="">
                    </div>
                </div>

                <div class="oak_add_element_modal_container_modal_content_revisions_content__list_of_revisions">
                    <h3><?php _e( 'Liste des révisions', Oak::$text_domain ); ?></h3>
                    <?php 
                    foreach( $revisions as $key => $revision ) : 
                        if ( $key != count( $revisions ) - 1 ) :
                        ?>
                            <div index="<?php echo( $key ) ?>" class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                <span class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( $revision->organization_modification_time ); ?></span>
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