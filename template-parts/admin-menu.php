<div class="oak_admin_menu">

    <div class="oak_admin_menu__head">
        <img class="oak_admin_menu_head__icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/isivalue.png' ); ?>" alt="">
        <h3 class="oak_admin_menu__title">ISIValue</h3>
    </div>

    <img class="oak_admin_menu__joro_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/jörö.png' ); ?>" alt="">
    <h3 class="oak_admin_menu__joro">JÖRÖ</h3>
    <h5 class="oak_admin_menu_central_application" style="color: <?php echo( Oak::$secondary_text_color ); ?>"><?php _e( 'Application centrale', Oak::$text_domain ); ?></h5>
    <hr>
    <br>
    
    <?php
        $menu_elements = array(
            array(
                'title' => __( 'Tableau de bord', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Postes', Oak::$text_domain ),
                'url' => 'edit.php',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Pages', Oak::$text_domain ),
                'url' => 'edit.php?post_type=page',
                'icon' => 'fas fa-th-large'
            ),
        );

        // For corn: 
        $terms_orders = [];
        foreach( Oak::$all_terms_without_redundancy as $term ) :
            if ( $term->term_parent == '0' ) :
                $terms_orders[] = $term->term_order;
            endif;
        endforeach;
        sort( $terms_orders );

        if ( get_option('oak_corn') == 'true' ) :
            $incrementer = 0;
            do {
                foreach( Oak::$all_terms_without_redundancy as $term ) : 
                    if ( isset( $terms_orders[ $incrementer ] ) && ( $term->term_order == '' || $term->term_order == $terms_orders[ $incrementer ] ) ) :
                        $incrementer++;
                        $children = array();
                        if ( $term->term_parent == '0' ) :
                            foreach( Oak::$all_terms_without_redundancy as $potential_term_child ) :
                                if ( $potential_term_child->term_identifier != $term->term_identifier && $potential_term_child->term_parent == $term->term_identifier ) :
                                    $children[] = array(
                                        'title' => $potential_term_child->term_designation,
                                        'url' => '?page=oak_elements_list&elements=term_objects&term_identifier=' . $potential_term_child->term_identifier . '&listorformula=list',
                                        'icon' => 'fas fa-th-large',
                                        'submenu' => true
                                    );
                                endif;
                            endforeach;

                            if ( count( $children ) > 0 ) :
                                $menu_elements[] = array(
                                    'title' => $term->term_designation,
                                    'url' => '',
                                    'icon' => 'fas fa-th-large',
                                    'order' => $term->term_order == '' ? 0 : $term->term_order
                                );
                                $menu_elements[] = array(
                                    'title' => $term->term_designation,
                                    'url' => '?page=oak_elements_list&elements=term_objects&term_identifier=' . $term->term_identifier . '&listorformula=list',
                                    'icon' => 'fas fa-th-large',
                                    'submenu' => true
                                );

                                $menu_elements = array_merge( $menu_elements, $children );
                            else :
                                $menu_elements[] = array(
                                    'title' => $term->term_designation,
                                    'url' => '?page=oak_elements_list&elements=term_objects&term_identifier=' . $term->term_identifier . '&listorformula=list',
                                    'icon' => 'fas fa-th-large',
                                    'order' => $term->term_order == '' ? 0 : $term->term_order
                                );
                            endif;
                        endif;
                    endif;
                endforeach;
            }
            while( $incrementer < count( $terms_orders ) );
        endif;

        $after_terms = array(
            array(
                'title' => __( 'Embeded XP', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Organisations', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=organizations&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Publications', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=publications&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Taxonomies', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Taxonomies', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=taxonomies&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenuelement' => true
            )
        );

        $menu_elements = array_merge( $menu_elements, $after_terms );

        // Lets make the pages associated to each taxonomy:
        foreach( Oak::$taxonomies_without_redundancy as $taxonomy ) :
            if ( $taxonomy->taxonomy_trashed != 'true' ) :
                $taxonomy_page_properties = array (
                    'title' => $taxonomy->taxonomy_designation,
                    'url' => '?page=oak_elements_list&elements=terms&listorformula=list&taxonomy_identifier=' . $taxonomy->taxonomy_identifier,
                    'icon' => 'fas fa-th-large',
                    'submenuelement' => true
                );
                $menu_elements[] = $taxonomy_page_properties;
            endif;
        endforeach;

        $menu_elements_after_taxo = array(
            array(
                'title' => __( 'Indicateurs Quantitatifs', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=quantis&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Indicateurs Qualitatifs', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=qualis&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Glossaire', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=glossaries&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Content Library', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large',
            ),
            array(
                'title' => __( 'Objets Spécifiques', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Bonne Pratique', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=goodpractices&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenuelement' => true
            ),
            array(
                'title' => __( 'Données de Performance', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=performances&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenuelement' => true
            ),
            array(
                'title' => __( 'Modèles', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Modèles', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=models&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenuelement' => true
            ),
        );

        $menu_elements = array_merge( $menu_elements, $menu_elements_after_taxo );

        // Lets make the pages associated to each model: 
        foreach( Oak::$models_without_redundancy as $model ) :
            if ( $model->model_trashed != 'true' ) :
                $model_page_properties = array (
                    'title' => $model->model_designation,
                    'url' => '?page=oak_elements_list&elements=objects&listorformula=list&model_identifier=' . $model->model_identifier,
                    'icon' => 'fas fa-th-large',
                    'submenuelement' => true
                );
                $menu_elements[] = $model_page_properties;
            endif;
        endforeach;

        $menu_elements_after_model = array(
            array(
                'title' => __( 'Formes', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=forms&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Champs', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=fields&listorformula=list',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Vizual Library', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large',
            ),
        );

        $menu_elements = array_merge( $menu_elements, $menu_elements_after_model );

        $central = get_option( 'oak_corn' );
        if ( $central == 'true' ) :
            $import_page = array(
                'title' => __( 'WebPublisher', Oak::$text_domain ),
                'url' => '?page=oak_import_page',
                'icon' => 'fas fa-th-large'
            );
            $menu_elements[] = $import_page;
        endif;
        
        $data_studio = array(
            'title' => __( 'Data Studio', Oak::$text_domain ),
            'url' => '?page=oak_data_studio',
            'icon' => 'fas fa-th-large'
        );
        $menu_elements[] = $data_studio;

        $other_menu_elements = array(
            array(
                'title' => __( 'Utilisateurs', Oak::$text_domain ),
                'url' => 'users.php',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Extensions', Oak::$text_domain ),
                'url' => 'plugins.php',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Outils', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Outils disponibles', Oak::$text_domain ),
                'url' => 'tools.php',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Import', Oak::$text_domain ),
                'url' => 'import.php',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Export', Oak::$text_domain ),
                'url' => 'export.php',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Export des données personnelles', Oak::$text_domain ),
                'url' => 'tools.php?page=export_personal_data.php',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Suppression des données personnelles', Oak::$text_domain ),
                'url' => 'tools.php?page=remove_personal_data',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Apparence', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Thèmes', Oak::$text_domain ),
                'url' => 'themes.php',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Customizer', Oak::$text_domain ),
                'url' => 'customize.php?return=%2Fboilerplate%2Fwp-admin%2F',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Menus', Oak::$text_domain ),
                'url' => 'nav-menus.php?action=edit&menu=0',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Editeur', Oak::$text_domain ),
                'url' => 'theme-editor.php',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Configuration de Oak', Oak::$text_domain ),
                'url' => '?page=oak_materiality_reporting',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Réglages', Oak::$text_domain ),
                'url' => 'options-general.php',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Media', Oak::$text_domain ),
                'url' => 'upload.php',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Elementor', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Mes templates', Oak::$text_domain ),
                'url' => 'edit.php?post_type=elementor_library',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Configuration', Oak::$text_domain ),
                'url' => 'admin.php?page=elementor',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Role manager', Oak::$text_domain ),
                'url' => 'admin.php?page=elementor-role-manager',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Outils', Oak::$text_domain ),
                'url' => 'admin.php?page=elementor-tools',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Infos système', Oak::$text_domain ),
                'url' => 'admin.php?page=elementor-system-info',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Aide', Oak::$text_domain ),
                'url' => 'admin.php?page=elementor-getting-started',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Custom Fonts', Oak::$text_domain ),
                'url' => 'admin.php?page=elementor_custom_fonts',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Go Pro', Oak::$text_domain ),
                'url' => 'admin.php?page=go_elementor_pro',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Widgeditor', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Widgets', Oak::$text_domain ),
                'url' => 'admin.php?page=widgeditor',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Ajouter', Oak::$text_domain ),
                'url' => 'admin.php?page=widgeditor_add_widgets',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'VizualEditor', Oak::$text_domain ),
                'url' => '',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Tous les styles', Oak::$text_domain ),
                'url' => 'wp-admin/admin.php?page=vizual-editor',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
            array(
                'title' => __( 'Ajouter', Oak::$text_domain ),
                'url' => 'admin.php?page=vizual-editor-add',
                'icon' => 'fas fa-th-large',
                'submenu' => true
            ),
        );

        $menu_elements = array_merge( $menu_elements, $other_menu_elements );
    ?>

    <?php 
    foreach( $menu_elements as $key => $element ) : 
        if ( ! isset( $element['submenu'] ) && ! isset( $element['submenuelement'] ) ) :
    ?>
            <a class="oak_admin_menu_element" href="<?php if ( $element['url'] != '' || $key == 0 ) : echo( admin_url( $element['url'] ) ); else : echo('#'); endif; ?>">
                <div class="oak_admin_menu_element__side_part">
                    <i class="oak_admin_menu_element__icon <?php echo( $element['icon'] ); ?>"></i>
                    <?php 
                    if ( isset( $element['order'] ) ) : ?>
                        <span class="oak_admin_menu_element__order"><?php echo( $element['order'] ); ?></span>
                    <?php
                    endif;
                    ?>
                    <span class="oak_admin_menu_element__span"><?php echo( $element['title'] ); ?></span>
                </div>
                
                <div class="oak_admin_menu_element__side_part">
                    <i class="oak_admin_menu_element__arrow fas fa-caret-right"></i>
                </div>
            </a>
            <?php 
            $index = $key + 1;
            if ( isset( $menu_elements[ $index ]['submenu'] ) ) : ?>
                <div class="oak_admin_menu_element__sub_menu oak_hidden">
                <?php
                    do {
                        ?>
                            <a class="oak_admin_menu_sub_element" href="<?php if ( $menu_elements[ $index ]['url'] || $key == 0 ) : echo( admin_url( $menu_elements[ $index ]['url'] ) ); else : echo('#'); endif; ?>">
                                <div class="oak_admin_menu_element__side_part">
                                    <i class="oak_admin_menu_element__icon <?php echo( $menu_elements[ $index ]['icon'] ); ?>"></i>
                                    <span class="oak_admin_menu_element__span"><?php echo( $menu_elements[ $index ]['title'] ); ?></span>
                                </div>
                                
                                <div class="oak_admin_menu_element__side_part">
                                    <i class="oak_admin_menu_element__arrow fas fa-caret-right"></i>
                                </div>
                            </a>
                            <?php
                            $submenu_index = $index + 1;
                            if ( isset( $menu_elements[ $submenu_index ]['submenuelement'] ) ) : ?>
                                <div class="oak_admin_menu_element__sub_menu oak_admin_menu_element_sub_menu__sub_menu oak_hidden">
                                <?php
                                    do {
                                        ?>
                                            <a class="oak_admin_menu_sub_element" href="<?php echo( admin_url( $menu_elements[ $submenu_index ]['url'] ) ); ?>">
                                                <div class="oak_admin_menu_element__side_part">
                                                    <i class="oak_admin_menu_element__icon <?php echo( $menu_elements[ $submenu_index ]['icon'] ); ?>"></i>
                                                    <span class="oak_admin_menu_element__span"><?php echo( $menu_elements[ $submenu_index ]['title'] ); ?></span>
                                                </div>
                                                
                                                <div class="oak_admin_menu_element__side_part">
                                                    <i class="oak_admin_menu_element__arrow fas fa-caret-right"></i>
                                                </div>
                                            </a>
                                        <?php
                                        $submenu_index++;
                                    }
                                    while ( isset( $menu_elements[ $submenu_index ] ) && isset( $menu_elements[ $submenu_index ]['submenuelement'] ) && $menu_elements[ $submenu_index ]['submenuelement'] == true );
                                    ?>
                                </div>
                                <?php
                            endif;
                        $index = $submenu_index;
                    }
                    while ( isset( $menu_elements[ $index ] ) && isset( $menu_elements[ $index ]['submenu'] ) && $menu_elements[ $index ]['submenu'] == true );
                    ?>
                </div>
                <?php

            endif;
        endif;
    endforeach; ?>
</div>

<div class="oak_admin_menu_fixed_button">
    <i class="fab fa-wordpress"></i>
</div>

<div class="oak_admin_menu__layer"></div>