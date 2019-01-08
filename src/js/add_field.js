// Global variables
var adding = false;
var deleting = false;
var fieldData = {};
var elementToDelete;

// For the add button
var addButton = document.querySelector('.oak_add_field_container__add_button');
addButton.addEventListener('click', function() {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = document.querySelector('.oak_add_field_container__identifier').value;
    var type = document.querySelector('.oak_add_field_container__type').value;
    var functionField = document.querySelector('.oak_add_field_container__type').value;
    var defaultValue = document.querySelector('.oak_add_field_container__default_value').value;
    var instructions = document.querySelector('.oak_add_field_container__instructions').value;
    var placeholder = document.querySelector('.oak_add_field_container__placeholder').value;
    var before  = document.querySelector('.oak_add_field_container__before').value;
    var after = document.querySelector('.oak_add_field_container__after').value;
    var maxLength = document.querySelector('.oak_add_field_container__max_length').value;
    var selector = document.querySelector('.oak_add_field_container__selector').value;
    var width = document.querySelector('.oak_add_field_container__width').value;

    if (designation.trim() == '') {
        openModal('Veuillez entrer la désignation d\'abord', false);
    } else { 
        var designationExists = false;
        for(var i = 0; i < DATA.fields.length; i++) {
            if (DATA.fields[i].designation == designation) {
                designationExists = true;
            }
        }
        if (designationExists) {
            openModal('Il existe déjà un champ avec la désignation: ' + designation);
        } else {
            var identifierExists = false;
            for (var j = 0; j < DATA.fields.length; j++) {
                if (DATA.fields[j].identifier == identifier) {
                    identifierExists = true;
                }
            }
            if (identifierExists) {
                openModal('Il existe déjà un champ avec l\'identifiant: ' + identifier);
            } else {
                if (identifier.trim() == '') {
                    openModal('Veuillez entrer l\'identifiant d\'abord', false);
                } else {
                    fieldData = {
                        designation,
                        identifier,
                        type,
                        functionField,
                        defaultValue,
                        instructions,
                        placeholder,
                        before,
                        after,
                        maxLength,
                        selector,
                        width
                    }
                    adding = true;
                    openModal('Êtes vous sur de vouloir ajouter ce champ?', true);
                }
            }
        }
    }
});

// For the delete buttons
manageDeleteButtons();
function manageDeleteButtons() {
    var deleteButtons = document.querySelectorAll('.oak_add_field_container__saved_field_container__delete_button');
    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            deleting = true;
            elementToDelete = this;
            openModal('Êtes vous sûr de vouloir supprimer le champ selectionné ?', true);
        });
    }
}

// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text');
    if (deleting) {
        confirmButtonSpan.innerHTML = 'Supprimer';
    }
    if (adding) {
        confirmButtonSpan.innerHTML = 'Ajouter';
    }

    var confirmButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text');

    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_object_model_add_formula_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    var addButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container');
    if ( twoButtons) {
        addButtonContainer.style.display = 'flex';
        cancelButtonContainer.style.display = 'flex';
        okButtonContainer.style.display = 'none';
    } else {
        addButtonContainer.style.display = 'none';
        cancelButtonContainer.style.display = 'none';
        okButtonContainer.style.display = 'flex';
    }
}

var okButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container');
okButtonContainer.addEventListener('click', function() {
    closeModals();
}); 

function closeModals() {
    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
    adding = deleting = false;
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

handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function() {
        if (adding) {
            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_field',
                        'data': fieldData,
                    },
                    success: function(data) {
                        console.log(data);
                        DATA.fields.push(fieldData);
                        doneLoading();

                        var fieldContainer = document.createElement('div');
                        fieldContainer.className = 'oak_add_field_container__saved_field_container';

                        var span = document.createElement('span');
                        span.innerHTML = fieldData.designation;

                        var i = document.createElement('i');
                        i.setAttribute('field-identifier', fieldData.identifier);
                        i.className = 'oak_add_field_container__saved_field_container__delete_button fa fa-minus';

                        fieldContainer.append(span);
                        fieldContainer.append(i);

                        var fieldsContainer = document.querySelector('.oak_add_field_container__fields_list');
                        fieldsContainer.append(fieldContainer);
                        // We are adding this: 
                        // <div class="oak_add_field_container__saved_field_container">
                        //     <span><?php echo( $field['designation'] ); ?></span>
                        //     <i field-identifier='<?php echo( $field['identifier'] ); ?>' class="oak_add_field_container__saved_field_container__delete_button fas fa-minus"></i>
                        // </div>
                    },
                    error: function(error) {
                        console.log(error);
                        doneLoading();
                    }
                });
            })
        }
        if (deleting) {
            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST', 
                    data: {
                        'action': 'oak_delete_field',
                        'data': elementToDelete.getAttribute('field-identifier')
                    },
                    success: function(data) {
                        console.log(data);
                        elementToDelete.parentNode.remove();
                        doneLoading();
                    },
                    error: function(error) {
                        console.log(error);
                        doneLoading();
                    }
                });
            });
        }
    });

    var cancelButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function() {
        closeModals();
    });
}