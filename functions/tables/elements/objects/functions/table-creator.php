<?php
global $wpdb; 
$charset_collate = Oak::$charset_collate;

// Creating all models tables for objects
// Lets get the fields that are gonna be in the table
foreach( Oak::$models_without_redundancy as $key => $model ) :
    $model_fields = [];
    $model_fields_names = explode( '|', $model->model_fields_names );
    foreach( Oak::$all_models_and_forms as $model_and_form_instance ) :
        if ( $model_and_form_instance->model_identifier == $model->model_identifier 
            && $model_and_form_instance->model_revision_number == $model->model_revision_number 
        ) :
            $form_identifier = $model_and_form_instance->form_identifier;
            foreach( Oak::$forms_without_redundancy as $form ) :
                if ( $form->form_identifier == $form_identifier ) :
                    foreach ( Oak::$all_forms_and_fields as $form_and_field_instance ) :
                        if ( $form_and_field_instance->form_identifier == $form->form_identifier 
                            && $form_and_field_instance->form_revision_number == $form->form_revision_number 
                        ) :
                            foreach( Oak::$fields_without_redundancy as $field ) :
                                if ( $field->field_identifier == $form_and_field_instance->field_identifier ) :
                                    $field_copy = clone $field;
                                    $field_copy->form_and_field_properties = $form_and_field_instance;
                                    $field_copy->model_and_form_instance = $model_and_form_instance;
                                    $field_copy->form = $form;

                                    // if ( !isset( $model_fields_names[ count( $model_fields ) ] ) ) :
                                    //     Oak::var_dump( $model->model_designation );
                                    //     Oak::var_dump( $model->model_designation );
                                    //     Oak::var_dump( $model->model_fields_names );
                                    //     Oak::var_dump( $model_fields_names );
                                    // endif;

                                    // $field_copy->field_name_in_model = $model_fields_names[ count( $model_fields ) - 1 ];
                                    if ( isset( $_GET['model_identifier'] ) ) :
                                        if ( $model->model_identifier == $_GET['model_identifier'] ) :
                                            array_push( Oak::$current_model_fields, $field_copy );
                                        endif;
                                    endif;
                                    array_push( $model_fields, $field_copy );
                                endif;
                            endforeach;
                        endif;
                    endforeach;
                endif;
            endforeach;
        endif;
    endforeach;

    $table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
    $models_sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        object_designation varchar(555) DEFAULT '' NOT NULL,
        object_identifier varchar(555) DEFAULT '' NOT NULL,
        object_selector varchar(555),
        object_locked varchar(555),
        object_trashed varchar(555),
        object_state varchar(555),
        object_modification_time datetime,
        object_content_language varchar(10) DEFAULT 'fr',
        object_selectors varchar(999),
        object_form_selectors varchar(999),
        object_model_selector TEXT,
        object_synchronized TEXT,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $models_sql );

    $wpdb->query("ALTER TABLE $table_name ENGINE=InnoDB ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;");

    foreach( $model_fields as $key => $field ) :
        $column_name = 'object_' . $key . '_' . $field->field_identifier;
        $columns = $wpdb->get_results( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'" );
        $exists = false;
        foreach( $columns as $column ) :
            if ( $column->COLUMN_NAME == $column_name ) :
                $exists = true;
            endif;
        endforeach;

        if ( !$exists ) {
            if ( $field->field_type == 'textarea' ) :
                $wpdb->query("ALTER TABLE $table_name ADD $column_name LONGTEXT");
            else :
                $wpdb->query("ALTER TABLE $table_name ADD $column_name TEXT");
            endif;
        }
    endforeach;

endforeach;