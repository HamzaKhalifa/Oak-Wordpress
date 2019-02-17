(function() {
    var saveConfigurationButton = document.querySelector('.oak_configuration_page_save_central_url_button');
    saveConfigurationButton.addEventListener('click', function() {
        var central = document.querySelector('.oak_configuration_page_checkbox').checked;
        var centralUrl = document.querySelector('.oak_configuration_page_field_container__url_input').value;
        setLoading();
        jQuery(document).ready(function() {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'action': 'oak_save_save_configuration',
                    'data': {
                        central,
                        centralUrl: centralUrl
                    },
                },
                success: function(data) {
                    doneLoading();
                    window.location.reload();
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        });
    });
})();

(function() {
    var central = document.querySelector('.oak_configuration_page_checkbox');
    central.addEventListener('change', function() {
        var centralUrlFieldContainer = document.querySelector('.oak_configuration_page_central_url_field_container');
        if (this.checked) 
            centralUrlFieldContainer.classList.remove('oak_hidden');
        else 
            centralUrlFieldContainer.classList.add('oak_hidden');
    });
})();

function openModal(title, twoButtons) {
    var confirmButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_add_element_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    if ( twoButtons) {
        confirmButtonContainer.style.display = 'flex';
        cancelButtonContainer.style.display = 'flex';
        okButtonContainer.style.display = 'none';
    } else {
        confirmButtonContainer.style.display = 'none';
        cancelButtonContainer.style.display = 'none';
        okButtonContainer.style.display = 'flex';
    }
}

function closeModals() {
    setTimeout(function() {
        document.querySelector('.oak_add_element_modal_container__modal').classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
    }, 500);

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
}

function setLoading() {
    openModal();
    document.querySelector('.oak_loader').classList.remove('oak_hidden');
    document.querySelector('.oak_add_element_modal_container__modal').classList.add('oak_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function() {
        document.querySelector('.oak_loader').classList.add('oak_hidden');
        document.querySelector('.oak_add_element_modal_container__modal').classList.remove('oak_hidden');
    }, 1000);
}