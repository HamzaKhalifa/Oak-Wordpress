<div class="oak_chat_menu oak_chat_menu_hidden">

    <form class="oak_chat_menu__authentication">
        <h2 class="oak_chat_menu__title"><?php _e( 'Authentification', Oak::$text_domain ); ?></h2>
        <input type="text" placeholder="<?php _e( 'Email', Oak::$text_domain ); ?>" class="oak_chat_input oak_chat_email">
        <input type="password" placeholder="<?php _e( 'Mot de passe', Oak::$text_domain ); ?>" class="oak_chat_input oak_chat_password">
        <input type="text" placeholder="<?php _e( 'Nom d\'utilisateur', Oak::$text_domain ); ?>" class="oak_chat_input oak_chat_username">
        <button class="oak_chat_login_or_register_button"><?php _e( 'Login/Register' ); ?></button>
        <span class="oak_chat_authentication__error_message"></span>
    </form>

    <div class="oak_chat_authenticated">
        <span class="oak_chat_menu__current_connected_user_container">
            <span><?php _e( 'Connecté en tant que: ', Oak::$text_domain ); ?></span>
            <span class="oak_chat_menu__current_connected_user"></span>
        </span>
        <button class="oak_chat_sign_out_button"><?php _e( 'Deconnexion', Oak::$text_domain ); ?></button>

        <h2 class="oak_chat_menu__title"><?php _e( 'Utilisateurs', Oak::$text_domain ); ?></h2>

        <div class="oak_chat_menu__single_user_view oak_hidden">
            <div class="oak_chat_menu_single_user_view__notification">2</div>
            <img class="oak_chat_menu__single_user_profile_image" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/user.png' ); ?>" alt="">
            <span class="oak_chat_menu_single_user__name">Thomas</span>
        </div>
    </div>

    <div class="oak_chat_loader_container">
        <h2 class="oak_chat_loader_container__loading_message"></h2>
        <div class="oak_loader chat_loader"></div>
    </div>
    
</div>

<div class="oak_chat_boxes_container">
    <div class="oak_single_chat_box oak_hidden">
        <div class="oak_single_chat_box__bar">
            <div></div>
            <h2 class="oak_single_chat_box_bar__name">Thomas</h2>
            <div class="oak_single_chat_box_bar__buttons_container">

                <i class="fas fa-square chat_box_make_bigger_or_smaller_button"></i>
                <i class="fas fa-times chat_box_off_button"></i>
            </div>
        </div>

        <div class="oak_single_chat_box__messages_container">
            <div class="oak_single_chat_box__message_container">
                <img class="oak_chat_menu__single_user_profile_image" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/user.png' ); ?>" alt="">
                <p class="oak_message_text_style">This is an example message, hope this will work :) Just trying to make the message bigger here. Hoping for it to look reaaaaaaaaaly big. As big as possible to test if the div is actually functional and takes the height of this long ass text. Apprently, this is gonna take some while. I mean, it's gonna take me some while to write more text.. Should I type in more? I don't know. Let me test this one first. </p>
            </div>

            <div class="oak_single_chat_box__message_container file_message_container">
                <img class="oak_chat_menu__single_user_profile_image" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/user.png' ); ?>" alt="">
                <!-- <input type="file" disabled class="oak_message_container__file_input"> -->
                <span class="oak_message_container__file_name"></span>
                <a class="oak_message_container__file_input" download ><?php _e( 'Télécharger' ); ?></a>
            </div>

            <div class="oak_single_chat_box__message_container image_message_container">
                <img class="oak_chat_menu__single_user_profile_image" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/user.png' ); ?>" alt="">
                <img src="" alt="" class="oak_message_container__image">
            </div>

            <div class="oak_single_chat_box__message_container my_message_style">
                <img class="oak_chat_menu__single_user_profile_image" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/user.png' ); ?>" alt="">
                <p class="oak_message_text_style">This is a message from me... It has got to have a different style from those sent by someone else.</p>
            </div>
        </div>

        <form class="oak_single_chat_box_message_form">
            <div class="oak_single_chat_box_message_form__files_container">

            </div>
            <textarea placeholder="<?php _e( 'Saisissez votre message ici', Oak::$text_domain ); ?>" name="" id="" cols="30" rows="10" class="oak_single_chat_box_message_textarea"></textarea>
            <div class="oak_single_chat_box_message_form__buttons_container">
                <i class="fas fa-file">
                    <input type="file" accept="application/*" class="oak_single_chat_box_message_form__files_button">
                </i>

                <i class="fas fa-images">
                    <input type="file" accept="image/x-png,image/gif,image/jpeg" class="oak_single_chat_box_message_form__images_button">
                </i>
            </div>
        </form>
    </div>
</div>