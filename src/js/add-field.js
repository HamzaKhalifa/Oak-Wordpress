// Global variables
var adding = false;
var fieldData = {};
var canceling = false;
var updating = false;
var browsingRevisions = false;
var revision = {};

// For the add button
var addButton = document.querySelector('.oak_add_field_container__add_button');
if (addButton) {
    addButton.addEventListener('click', function() {
        var ok = checkOk();
        if (!ok)
            return;
        fieldData = createFieldData(0);
        adding = true;
        openModal('Êtes vous sur de vouloir ajouter ce champ?', true);
    });    
}

// For the update button 
var updateButton = document.querySelector('.oak_add_field_container__update_button');
if (updateButton) {
    updateButton.addEventListener('click', function() {
        fieldData = createFieldData(DATA.revisions[DATA.revisions.length - 1].field_state);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier ce champ?', true);
    });
}

// For the register button
var registerButton = document.querySelector('.oak_add_field_container__register_button');
if (registerButton) {
    registerButton.addEventListener('click', function() {
        fieldData = createFieldData(1);
        if (DATA.revisions.length == 0) {
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
        fieldData = createFieldData(2);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
    });
}

// For the back to draft button: 
var draftButton = document.querySelector('.oak_add_field_container__draft_button');
if (draftButton) {
    draftButton.addEventListener('click', function() {
        fieldData = createFieldData(0);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et renvoyer ce champ à l\'état de Brouillon ?', true);
    });
}

// For the trash button
var trashButton = document.querySelector('.oak_add_field_container__trash_button');
if (trashButton) {
    trashButton.addEventListener('click', function() {
        setLoading();
        jQuery(document).ready(function() {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST', 
                data: {
                    'data': DATA.currentField.field_identifier,
                    'action': 'oak_send_field_to_trash',
                },
                success: function(data) {
                    console.log(data);
                    doneLoading();
                    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_add_field');
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        });
    });
}

function getEnteredData() {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = designation.replace(/[^a-zA-Z ]/g, '');
    identifier = identifier.replace(/\s/g,'');
    var type = document.querySelector('.oak_add_field_container__type').value;
    var functionField = document.querySelector('.oak_add_field_container__function').value;
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
        state: DATA.revisions[DATA.revisions.length - 1].field_state,
        trashed: DATA.revisions[DATA.revisions.length - 1].field_trashed
    }

    return fieldData;
}

// We create while adding the new revision
function createFieldData(state) {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = designation.replace(/[^a-zA-Z ]/g, '');
    identifier = identifier.replace(/\s/g,'');
    var type = document.querySelector('.oak_add_field_container__type').value;
    var functionField = document.querySelector('.oak_add_field_container__function').value;
    var defaultValue = document.querySelector('.oak_add_field_container__default_value').value;
    var instructions = document.querySelector('.oak_add_field_container__instructions').value;
    var placeholder = document.querySelector('.oak_add_field_container__placeholder').value;
    var before  = document.querySelector('.oak_add_field_container__before').value;
    var after = document.querySelector('.oak_add_field_container__after').value;
    var maxLength = document.querySelector('.oak_add_field_container__max_length').value;
    var selector = document.querySelector('.oak_add_field_container__selector').value;
    var trashed = false;

    var fieldData = { designation, identifier, type, functionField, defaultValue, instructions, placeholder, before, after, maxLength, selector, state, trashed }

    return fieldData;
}

// for the browse revisions button:
browseRevisionsButton = document.querySelector('.oak_add_field_big_container_tabs_single_tab_section_state__browse');
browseRevisionsButton.addEventListener('click', function() {
    browsingRevisions = true;
    openModal('Liste des révisions', true);
    // Changing the modal's width

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
    var state = fieldData.state == 0 ? 'Brouillon' : fieldData.state == 1 ? 'Enregsitré' : 'Diffusé';
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
        document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container').classList.remove('oak_hidden');

        // Updating the selected revision fields:
        var selectedRevision = DATA.revisions[this.getAttribute('index')];
        revision = selectedRevision;
        
        var revisionTypeField = document.querySelector('.oak_revision_type_field');
        var revisionFunctionField = document.querySelector('.oak_revision_function_field');
        var revisionDefaultValueField = document.querySelector('.oak_revision_default_value_field');
        var revisionPlaceholderField = document.querySelector('.oak_revision_placeholder_field');
        var revisionInstructionsField = document.querySelector('.oak_revision_instructions_field');
        var revisionBeforeField = document.querySelector('.oak_revision_before_field');
        var revisionAfterField = document.querySelector('.oak_revision_after_field');
        var revisionMaxLengthField = document.querySelector('.oak_revision_max_length_field');
        var revisionSelectorField = document.querySelector('.oak_revision_selector_field');

        revisionTypeField.value = selectedRevision.field_type;
        revisionFunctionField.value = selectedRevision.field_function;
        revisionDefaultValueField.value = selectedRevision.field_default_value;
        revisionPlaceholderField.value = selectedRevision.field_placeholder;
        revisionInstructionsField.value = selectedRevision.field_instructions;
        revisionBeforeField.value = selectedRevision.field_before;
        revisionAfterField.value = selectedRevision.field_after;
        revisionMaxLengthField.value = selectedRevision.field_max_length;
        revisionSelectorField.value = selectedRevision.field_selector;
        var state = selectedRevision.field_state == '0' ? 'Brouillon' : selectedRevision.field_state == '1' ? 'Enregsitré' : 'Diffusé';
        document.querySelector('.oak_revision_state_field').value = state;

        // Getting the current revision values;
        var fieldData = getEnteredData();

        checkEquals(fieldData.type , selectedRevision.field_type, revisionTypeField);
        checkEquals(fieldData.functionField, selectedRevision.field_function, revisionFunctionField);
        checkEquals(fieldData.defaultValue, selectedRevision.field_default_value, revisionDefaultValueField);
        checkEquals(fieldData.placeholder, selectedRevision.field_placeholder, revisionPlaceholderField);
        checkEquals(fieldData.instructions, selectedRevision.field_instructions, revisionInstructionsField);
        checkEquals(fieldData.before, selectedRevision.field_before, revisionBeforeField);
        checkEquals(fieldData.after, selectedRevision.field_after, revisionAfterField);
        checkEquals(fieldData.maxLength, selectedRevision.field_max_length, revisionMaxLengthField);
        checkEquals(fieldData.selector, selectedRevision.field_selector, revisionSelectorField);
        checkEquals(document.querySelector('.oak_revision_state_field_current').value, document.querySelector('.oak_revision_state_field').value, document.querySelector('.oak_revision_state_field'));
    });
}

function checkEquals(value1, value2, field) {
    if (value1 == value2) {
        field.classList.remove('oak_error');
    } else {
        field.classList.add('oak_error');
    }
}

function importRevisionData() {
    
}

// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text');
    var cancelButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_cancel_button_container__text');
    var confirmButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    if (adding) {
        confirmButtonSpan.innerHTML = 'Ajouter';
        confirmButtonContainer.classList.remove('oak_hidden');
        cancelButtonSpan.innerHTML = 'Annuler';
    }
    if (canceling || updating) {
        confirmButtonSpan.innerHTML = 'Oui';
        cancelButtonSpan.innerHTML = 'Non';
        confirmButtonContainer.classList.remove('oak_hidden');
    }
    var modalContainer = document.querySelector('.oak_object_model_add_formula_modal_container__modal');
    var revisionsContent = document.querySelector('.oak_object_model_add_formula_modal_container_modal_content__revisions_content');
    if (browsingRevisions) {
        confirmButtonSpan.innerHTML = 'Importer';
        cancelButtonSpan.innerHTML = 'Annuler';
        confirmButtonContainer.classList.add('oak_hidden');
        modalContainer.classList.add('oak_object_model_add_formula_modal_container_modal__big_modal');
        revisionsContent.classList.remove('oak_hidden');
    } else {
        modalContainer.classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
        revisionsContent.classList.add('oak_hidden');
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
    }, 500);

    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
    adding = canceling = updating = browsingRevisions = false;
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
        if (adding || updating) {
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
                        DATA.fields.push(fieldData);
                        doneLoading();
                        console.log(data);
                        window.location.reload();
                    },
                    error: function(error) {
                        doneLoading();
                    }
                });
            })
        }
        if (canceling) {
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
        }
        if (browsingRevisions) {
            revision.designation = revision.field_designation;
            revision.identifier = revision.field_identifier;
            revision.type = revision.field_identifier;
            revision.functionField = revision.field_function;
            revision.defaultValue = revision.field_default_value;
            revision.instructions = revision.field_instructions;
            revision.placeholder = revision.field_placeholder;
            revision.before = revision.field_before;
            revision.after = revision.field_after;
            revision.maxLength = revision.field_max_length;
            revision.selector = revision.field_selector;
            revision.state = revision.field_state;
            revision.trashed = revision.field_trashed;

            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_field',
                        'data': revision,
                    },
                    success: function(data) {
                        doneLoading();
                        console.log(data);
                        window.location.reload();
                    },
                    error: function(error) {
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