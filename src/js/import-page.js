var publications = [];
var data = [];

document.querySelector('.oak_import_page__publications_select').addEventListener('change', function() {
    console.log(jQuery('.oak_import_page__publications_select').val());
});
(function() {
    setLoading();
    console.log('central URL', DATA.centralUrl);
    jQuery(document).ready(function() {
        jQuery.ajax({
            url: DATA.ajaxUrl,
            type: 'POST',
            data: {
                'action': 'oak_get_all_data_for_corn',
                'data': ''
            },
            success: function(data) {
                doneLoading();
                console.log(data);
                var publicationsSelect = document.querySelector('.oak_import_page__publications_select');
                var publications = data.data.publicationsWithoutRedundancy;
                data = data.data;
                for (var i = 0; i < publications.length; i++) {
                    var option = document.createElement('option');
                    option.setAttribute('value', publications[i].publication_identifier);
                    option.innerHTML = publications[i].publication_designation;
                    publicationsSelect.append(option);
                }
            },
            error: function(error) {
                console.log(error);
                doneLoading();
            } 
        });
    });
})();

(function() {
    var importButton = document.querySelector('.oak_import_page_field__import_button');
    importButton.addEventListener('click', function() {
        var selectedPublicationsIdentifiers = jQuery('.oak_import_page_field__import_button').val();
    });
})();

function openModal(title, twoButtons) {
    var confirmButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container');

    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_object_model_add_formula_modal_container_modal_title_container__title');
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
        document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
    }, 500);

    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
}

function setLoading() {
    openModal();
    document.querySelector('.oak_loader').classList.remove('oak_hidden');
    document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.add('oak_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function() {
        document.querySelector('.oak_loader').classList.add('oak_hidden');
        document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.remove('oak_hidden');
    }, 1000);
}