// Global variables
var adding = false;
var fieldData = {};
var canceling = false;
var updating = false;

// For the add button
var addButton = document.querySelector('.oak_add_field_container__add_button');
if (addButton) {
    addButton.addEventListener('click', function() {
        var ok = checkOk();
        if (!ok)
            return;
        fieldData = createFieldData();
        fieldData.state = 0;
        adding = true;
        openModal('Êtes vous sur de vouloir ajouter ce champ?', true);
    });    
}

// For the update button 
var updateButton = document.querySelector('.oak_add_field_container__update_button');
if (updateButton) {
    updateButton.addEventListener('click', function() {
        fieldData = createFieldData();
        fieldData.state = DATA.currentField.state;
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier ce champ?', true);
    });
}

// For the register button
var registerButton = document.querySelector('.oak_add_field_container__register_button');
if (registerButton) {
    registerButton.addEventListener('click', function() {
        fieldData = createFieldData();
        fieldData.state = 1;
        if (!DATA.currentField.designation) {
            // adding for the first time
            var ok = checkOk();
            if (!ok)
                return;
            adding = true;
        } else {
            updating = true;
        }
        openModal('Êtes vous sûr de vouloir ajouter ce champ à la liste des champs enregistrés?', true);
    });
}

function checkOk() {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = designation.replace(/[^a-zA-Z ]/g, '');
    identifier = identifier.replace(/\s/g,'');

    ok = true;
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    if (designation.trim() == '') {
        openModal('Veuillez entrer la désignation d\'abord', false);
        ok = false;
    } else {
        for(var i = 0; i < DATA.fields.length; i++) {
            if (DATA.fields[i].designation == designation) {
                openModal('Il existe déjà un champ avec la désignation: ' + designation);
                ok = false;
            }
        }
        if (ok) {
            var identifierExists = false;
            for (var j = 0; j < DATA.fields.length; j++) {
                if (DATA.fields[j].identifier == identifier) {
                    identifierExists = true;
                    ok = false;
                }
            }
            if (identifierExists) {
                openModal('Il existe déjà un champ avec l\'identifiant: ' + identifier);
            } else {
                if (identifier.trim() == '') {
                    openModal('Veuillez entrer la désignation d\'abord', false);
                    ok = false;
                }
            }
        }
    }
    return ok;
}

// For the broadcast button
var broadcastButton = document.querySelector('.oak_add_field_container__broadcast_button');
if (broadcastButton) {
    broadcastButton.addEventListener('click', function() {
        fieldData = createFieldData();
        fieldData.state = 2;
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
    });
}

// For the back to draft button: 
var draftButton = document.querySelector('.oak_add_field_container__draft_button');
if (draftButton) {
    draftButton.addEventListener('click', function() {
        fieldData = createFieldData();
        fieldData.state = 0;
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et renvoyer ce champ à l\'état de Brouillon ?', true);
    });
}

function getEnteredData() {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = designation.replace(/[^a-zA-Z ]/g, '');
    identifier = identifier.replace(/\s/g,'');
    var type = document.querySelector('.oak_add_field_container__type').value;
    var functionField = document.querySelector('.oak_add_field_container__type').value;
    var defaultValue = document.querySelector('.oak_add_field_container__default_value').value;
    var instructions = document.querySelector('.oak_add_field_container__instructions').value;
    var placeholder = document.querySelector('.oak_add_field_container__placeholder').value;
    var before  = document.querySelector('.oak_add_field_container__before').value;
    var after = document.querySelector('.oak_add_field_container__after').value;
    var maxLength = document.querySelector('.oak_add_field_container__max_length').value;
    var selector = document.querySelector('.oak_add_field_container__selector').value;

    var fieldData = { designation, identifier, type, functionField, defaultValue,
        instructions,
        placeholder,
        before,
        after,
        maxLength,
        selector,
        modificationDate: new Date(),
        revisions: DATA.currentField.revisions,
        state: DATA.currentField.state
    }

    return fieldData;
}

function createFieldData() {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = designation.replace(/[^a-zA-Z ]/g, '');
    identifier = identifier.replace(/\s/g,'');
    var type = document.querySelector('.oak_add_field_container__type').value;
    var functionField = document.querySelector('.oak_add_field_container__type').value;
    var defaultValue = document.querySelector('.oak_add_field_container__default_value').value;
    var instructions = document.querySelector('.oak_add_field_container__instructions').value;
    var placeholder = document.querySelector('.oak_add_field_container__placeholder').value;
    var before  = document.querySelector('.oak_add_field_container__before').value;
    var after = document.querySelector('.oak_add_field_container__after').value;
    var maxLength = document.querySelector('.oak_add_field_container__max_length').value;
    var selector = document.querySelector('.oak_add_field_container__selector').value;

    var fieldData = { designation, identifier, type, functionField, defaultValue,
        instructions,
        placeholder,
        before,
        after,
        maxLength,
        selector,
        modificationDate: new Date()
    }

    if (DATA.currentField.revisions) {
        var revisions = DATA.currentField.revisions ? DATA.currentField.revisions : [];
        var currentFieldWithoutRevisions = DATA.currentField;
        currentFieldWithoutRevisions.revisions = '';
        revisions.push(currentFieldWithoutRevisions);
        fieldData.revisions = revisions;
    } else {
        fieldData.revisions = [{
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
            modificationDate: new Date()
        }];
    }

    return fieldData;
}

// For the cancel button: 
var cancelButton = document.querySelector('.oak_add_field_container__cancel_button');
cancelButton.addEventListener('click', function() {
    var fieldData = createFieldData();
    if ( fieldData['designation'] != DATA.currentField.designation 
    || fieldData['identifier'] != DATA.currentField.identifier 
    || fieldData['type'] != DATA.currentField.type 
    || fieldData['functionField'] != DATA.currentField.functionField 
    || fieldData['defaultValue'] != DATA.currentField.defaultValue 
    || fieldData['instructions'] != DATA.currentField.instructions 
    || fieldData['placeholder'] != DATA.currentField.placeholder 
    || fieldData['before'] != DATA.currentField.before
    || fieldData['after'] != DATA.currentField.after
    
    || fieldData['maxLength'] != DATA.currentField.maxLength
    || fieldData['selector'] != DATA.currentField.selector
    
    ) {
        canceling = true;
        openModal('Des modifications ont été ajoutées. Êtes vous sûr de vouloir tout annuler ?', true);
    } else {
        backToList();
    }
});

// for the browse revisions button:
browseRevisionsButton = document.querySelector('.oak_add_field_big_container_tabs_single_tab_section_state__browse');
browseRevisionsButton.addEventListener('click', function() {
    openModal('Liste des révisions', false);
    // Changing the modal's width
    document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.add('oak_object_model_add_formula_modal_container_modal__big_modal');
    document.querySelector('.oak_object_model_add_formula_modal_container_modal_content__revisions_content').classList.remove('oak_hidden');

    fieldData = getEnteredData();

    document.querySelector('.oak_revision_type_field_current').value = fieldData.type;
    document.querySelector('.oak_revision_function_field_current').value = fieldData.functionField;
    document.querySelector('.oak_revision_default_value_field_current').value = fieldData.defaultValue;
    document.querySelector('.oak_revision_placeholder_field_current').value = fieldData.placeholder;
    document.querySelector('.oak_revision_instructions_field_current').value = fieldData.instructions;
    document.querySelector('.oak_revision_before_field_current').value = fieldData.before;
    document.querySelector('.oak_revision_after_field_current').value = fieldData.after;
    document.querySelector('.oak_revision_max_length_field_current').value = fieldData.maxLength;
    document.querySelector('.oak_revision_selector_field_current').value = fieldData.selector;
    var state = fieldData.state == 0 ? 'Brouillon_current' : fieldData.state == 1 ? 'Enregsitré' : 'Diffusé';
    document.querySelector('.oak_revision_state_field_current').value = state;
});

// For the browse revisions select button: 
var revisionsButtons = document.querySelectorAll('.oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision');
for( var i = 0; i < revisionsButtons.length; i++ ) {
    revisionsButtons[i].addEventListener('click', function(){
        for (var j = 0; j < revisionsButtons.length; j++) {
            revisionsButtons[j].classList.remove('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
        }
        this.classList.add('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');

        var selectedRevision = DATA.currentField.revisions[this.getAttribute('index')];
        document.querySelector('.oak_revision_type_field').value = selectedRevision.type;
        document.querySelector('.oak_revision_function_field').value = selectedRevision.functionField;
        document.querySelector('.oak_revision_default_value_field').value = selectedRevision.defaultValue;
        document.querySelector('.oak_revision_placeholder_field').value = selectedRevision.placeholder;
        document.querySelector('.oak_revision_instructions_field').value = selectedRevision.instructions;
        document.querySelector('.oak_revision_before_field').value = selectedRevision.before;
        document.querySelector('.oak_revision_after_field').value = selectedRevision.after;
        document.querySelector('.oak_revision_max_length_field').value = selectedRevision.maxLength;
        document.querySelector('.oak_revision_selector_field').value = selectedRevision.selector;
        var state = selectedRevision.state == '0' ? 'Brouillon' : selectedRevision.state == '1' ? 'Enregsitré' : 'Diffusé';
        document.querySelector('.oak_revision_state_field').value = state;
    });
}


// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text');
    var cancelButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_cancel_button_container__text');
    if (adding) {
        confirmButtonSpan.innerHTML = 'Ajouter';
        cancelButtonSpan.innerHTML = 'Annuler';
    }
    if (canceling || updating) {
        confirmButtonSpan.innerHTML = 'Oui';
        cancelButtonSpan.innerHTML = 'Non';
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
    
    setTimeout(function() {
        document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
        document.querySelector('.oak_object_model_add_formula_modal_container_modal_content__revisions_content').classList.add('oak_hidden');
    }, 1000);

    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
    adding = canceling = updating = false;
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
            console.log('Field data', fieldData);
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
                    },
                    error: function(error) {
                        console.log(error);
                        doneLoading();
                    }
                });
            })
        }
        if (canceling) {
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
        }
        if (updating) {
            console.log('Field data', fieldData);
            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST', 
                    data: {
                        'action': 'oak_update_field',
                        'field': fieldData
                    },
                    success: function(data) {
                        console.log(data);
                        doneLoading();
                        DATA.currentField = fieldData;
                        window.location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                        doneLoading();
                    }
                });
            })
        }
    });

    var cancelButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function() {
        closeModals();
    });
}

function backToList() {
    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
}