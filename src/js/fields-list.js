var elementToDelete;
var deleting = false;

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

// For the update buttons: 
manageUpdateButtons();
function manageUpdateButtons() {
    var updateButtons = document.querySelectorAll('.oak_add_field_container_saved_field_container__update_button');
    for (var i = 0; i < updateButtons.length; i++) {
        updateButtons[i].addEventListener('click', function() {
            var whichField;
            for (var j = 0; j < DATA.fields.length; j++) {
                if (DATA.fields[j].designation == this.parentNode.querySelector('span').innerHTML) {
                    whichField = DATA.fields[j];
                }
            }
            
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_add_field&designation=' + whichField.designation 
                + '&identifier=' + whichField.identifier 
                + '&type=' + whichField.type
                + '&functionField=' + whichField.functionField
                + '&defaultValue=' + whichField.defaultValue
                + '&instructions=' + whichField.instructions 
                + '&placeholder=' + whichField.placeholder 
                + '&before=' + whichField.before 
                + '&after=' + whichField.after 
                + '&maxLength=' + whichField.maxLength 
                + '&selector=' + whichField.selector 
            );
        });
    }
}

// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text');
    if (deleting) {
        confirmButtonSpan.innerHTML = 'Supprimer';
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
    deleting = false;
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