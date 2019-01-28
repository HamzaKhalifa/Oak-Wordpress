// Global variables
var adding = false;
var formData = {};
var canceling = false;
var updating = false;
var browsingRevisions = false;
var revision = {};

// Removing Revisions from DATA fields
removeRevisions();
function removeRevisions() {
    var addedFields = [];
    for (var j = 0; j < DATA.fields.length; j++) {
        var exists = false;
        for (var n = 0; n < addedFields.length; n++) {
            if (addedFields[n].field_identifier == DATA.fields[j].field_identifier) {
                exists = true;
            }
        }
        if (!exists) {
            addedFields.push(DATA.fields[j]);
        }
    }
    DATA.fields = addedFields;
}

// For the add button
var addButton = document.querySelector('.oak_add_field_container__add_button');
if (addButton) {
    addButton.addEventListener('click', function() {
        var ok = checkOk();
        if (!ok)
            return;
        formData = createFormData(0);
        adding = true;
        openModal('Êtes vous sur de vouloir ajouter ce formulaire?', true);
    });
}

// For the update button 
var updateButton = document.querySelector('.oak_add_field_container__update_button');
if (updateButton) {
    updateButton.addEventListener('click', function() {
        formData = createFormData(DATA.revisions[DATA.revisions.length - 1].form_state);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier ce champ?', true);
    });
}

// For the register button
var registerButton = document.querySelector('.oak_add_field_container__register_button');
if (registerButton) {
    registerButton.addEventListener('click', function() {
        formData = createFormData(1);
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
        for(var i = 0; i < DATA.forms.length; i++) {
            if (DATA.forms[i].designation == designation) {
                openModal('Il existe déjà un formulaire avec la désignation: ' + designation);
                ok = false;
            }
        }
        if (ok) {
            var identifierExists = false;
            for (var j = 0; j < DATA.forms.length; j++) {
                if (DATA.forms[j].identifier == identifier) {
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
        formData = createFormData(2);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
    });
}

// For the back to draft button: 
var draftButton = document.querySelector('.oak_add_field_container__draft_button');
if (draftButton) {
    draftButton.addEventListener('click', function() {
        formData = createFormData(0);
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

// For the identifier input update
var designationInput = document.querySelector('.oak_add_field_container__designation');
var identifierInput = document.querySelector('.oak_add_form_container__identifier');
designationInput.oninput = function() {
    identifierInput.value = createIdentifier(designationInput.value);
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

    var formData = { designation, identifier, type, functionField, defaultValue,
        instructions,
        placeholder,
        before,
        after,
        maxLength,
        selector,
        state: DATA.revisions[DATA.revisions.length - 1].field_state,
        trashed: DATA.revisions[DATA.revisions.length - 1].field_trashed
    }

    return formData;
}

// We create while adding the new revision
function createFormData(state) {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = createIdentifier(designation);
    var structure = document.querySelector('.oak_add_form_container__structure').value;
    var attributs = document.querySelector('.oak_add_form_container__attributs').value;
    var selector = document.querySelector('.oak_add_field_container__selector').checked;
    var trashed = false;

    fields = '';
    var fieldsContainers = document.querySelectorAll('.oak_add_form_fields_list__single_field');
    for (var i= 0; i < fieldsContainers.length; i++) {
        var fieldDesignation = fieldsContainers[i].querySelector('.oak_add_form_fields_list_horizontal__designation_select').value;
        var name = fieldsContainers[i].querySelector('.oak_add_form_field_rename').value;
        var required = fieldsContainers[i].querySelector('.oak_field_required_input').checked;
        var width = fieldsContainers[i].querySelector('.oak_field_width_input').value;
        var whichChildIsIt = whichChild(fieldsContainers[i]);
        fields += fieldDesignation + ':' + createIdentifier(fieldDesignation) + ':' + name + ':' + required + ':' + width + ':' + whichChildIsIt + '|';
    }

    var separators = ''
    var separatorsElements = document.querySelectorAll('.oak_add_form_seperator');
    for (var i = 0; i < separatorsElements.length; i++) {
        separators += separatorsElements[i].querySelector('span').innerHTML + ':' + whichChild(separatorsElements[i]) + '|';
    }
    
    var formData = {
        designation, 
        identifier,
        fields,
        selector, 
        state,
        trashed,
        structure,
        attributs,
        separators
    }

    return formData;
}

function createIdentifier(designation) {
    var identifier = designation.replace(/[^a-zA-Z ]/g, '');
    identifier = identifier.replace(/\s/g,'');
    return identifier.toLowerCase();
}

function whichChild(elem){
    var  i= 0;
    while((elem=elem.previousSibling)!=null) ++i;
    return i;
}

// for the browse revisions button:
browseRevisionsButton = document.querySelector('.oak_add_field_big_container_tabs_single_tab_section_state__browse');
browseRevisionsButton.addEventListener('click', function() {
    browsingRevisions = true;
    openModal('Liste des révisions', true);
    // Changing the modal's width
    
    formData = createFormData(DATA.revisions[DATA.revisions.length - 1].form_state);

    document.querySelector('.oak_revision_form_current_structure').value = formData.structure;
    document.querySelector('.oak_revision_form_attributs_current').value = formData.attributs;
    document.querySelector('.oak_revision_form_selector_current').value = formData.selector;
    console.log('Form data state: ' + formData.state);
    var state = formData.state == 0 ? 'Brouillon' : formData.state == 1 ? 'Enregsitré' : 'Diffusé';
    document.querySelector('.oak_revision_form_state_current').value = state;
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
        console.log('Revision', revision);

        var revisionStructureField = document.querySelector('.oak_revision_form_revision_structure');
        var revisionAttributsField = document.querySelector('.oak_revision_form_attributs_revision');
        var revisionSelectorField = document.querySelector('.oak_revision_form_selector_revision');
        var revisionStateField = document.querySelector('.oak_revision_form_state_revision');

        // console.log('selected revision', selectedRevision);
        revisionStructureField.value = selectedRevision.form_structure;
        revisionAttributsField.value = selectedRevision.form_attributes;
        revisionSelectorField.value = selectedRevision.form_selector;

        var state = selectedRevision.form_state == '0' ? 'Brouillon' : selectedRevision.form_state == '1' ? 'Enregsitré' : 'Diffusé';
        revisionStateField.value = state;

        // Getting the current revision values;
        var formData = createFormData(DATA.revisions[DATA.revisions.length - 1].form_state);

        checkEquals(formData.structure, selectedRevision.form_structure, revisionStructureField);
        checkEquals(formData.attributs, selectedRevision.form_attributes, revisionAttributsField);
        checkEquals(formData.selector.toString(), selectedRevision.form_selector.toString(), revisionSelectorField);

        checkEquals(document.querySelector('.oak_revision_form_state_current').value, document.querySelector('.oak_revision_form_state_revision').value, document.querySelector('.oak_revision_form_state_revision'));
    });
}

function checkEquals(value1, value2, field) {
    if (value1 == value2) {
        field.classList.remove('oak_error');
    } else {
        field.classList.add('oak_error');
    }
}

// For the add field button
var addFieldButton = document.querySelector('.oak_add_form_add_field_button');
addFieldButton.addEventListener('click', function() {
    var fieldsList = document.querySelector('.oak_add_form_fields_list')

    var singleFieldContainer = document.createElement('div');
    singleFieldContainer.className = 'oak_add_form_fields_list__single_field';
    
    singleFieldContainer.innerHTML = '<div class="oak_add_field_container__isert_field_title_container oak_add_form_fields_list__horizontal oak_add_form_fields_list__horizontal_without_margin_top oak_add_form_field_options">'
    + '<div class="oak_add_form_fields_list__horizontal">'
    + '<img class="oak_add_form_container_header_icon" src="' + DATA.templateDirectoryUri + '/src/assets/icons/fields.png" alt="">' 
    + '<h4 class="oak_add_field_container__isert_field_title">Insérer un champ</h4></div>'
    + '<div class="oak_add_form_fields_list__buttons_container"><div class="oak_add_form_field_options__button oak_add_form_field_options_button_delete"><i class="fas fa-times"></i></div></div>'
    + '</div>'
    + '<div class="oak_add_form_fields_list__horizontal oak_add_form_fields_list__horizontal_without_margin_top">'
    + '<div class="oak_add_form_fields_list__vertical oak_left_field">'
    + '<label class="oak_add_field_label" for="type">Nature</label>'
    + '<select class="oak_add_form_fields_list_horizontal__type_select" name="type" id="">'
    + '<option value=""></option> <option value="Texte">Texte</option> <option value="Zone de Texte">Zone De Texte</option> <option value="Image">Image</option><option value="File">Fichier</option>'
    + '</select>'
    + '</div> <div class="oak_add_form_fields_list__vertical"> <label class="oak_add_field_label" for="type">Fonction</label>'
    + '<select class="oak_add_form_fields_list_horizontal__function_select" name="type" id=""><option value=""></option> <option value="Information/Description">Information/Description</option><option value="Exemple">Exemple</option><option value="Illustration">Illustration</option>'
    + '</select></div></div><div class="oak_add_form_fields_list__horizontal"><div class="oak_add_form_fields_list__vertical oak_left_field">'
    + '<label class="oak_add_field_label" for="field-designation">Désignation</label><select class="oak_add_form_fields_list_horizontal__designation_select" name="field-designation" id=""></select></div>'
    + '<div class="oak_add_form_fields_list__vertical"><label class="oak_add_field_label" for="field-identifier">Identifiant Unique</label><input disabled name="field-identifier" type="text" value="" class="oak_add_field_container__input oak_add_form_field_identifier"></div></div>'
    + '<div class="oak_add_form_fields_list__horizontal"><div class="oak_add_form_fields_list__vertical oak_left_field"><label class="oak_add_field_label" for="field-identifier">Renommer</label><input name="field-identifier" type="text" value="" class="oak_add_field_container__input oak_add_form_field_rename"></div>'
    + '<div class="oak_add_form_fields_list__horizontal"><div class="oak_add_form_fields_list__horizontal oak_add_form_fields_list__horizontal_very_small oak_left_field"><label class="oak_add_field_label without_margin_bottom" for="field-required">Recquis</label><input type="checkbox" class="oak_field_required_input"></div><div class="oak_add_form_fields_list__horizontal oak_add_form_fields_list__horizontal_small"><label class="oak_add_field_label oak_add_field_label_width without_margin_bottom" for="field-required">Largeur</label><input type="number" class="oak_field_width_input">'
    + '</div></div></div>'

    fieldsList.append(singleFieldContainer);

    var designationsSelects = fieldsList.querySelectorAll('.oak_add_form_fields_list_horizontal__designation_select');
    for (var i = 0; i < designationsSelects.length; i++) {
        designationsSelects[i].innerHTML = '';
        for (var j = 0; j < DATA.fields.length; j++) {
            var option = document.createElement('option');
            option.setAttribute('value', DATA.fields[j].field_identifier);
            option.innerHTML = DATA.fields[j].field_designation;
            designationsSelects[i].append(option);
        }
    }

    updateFiltersListeners();
    handleDesignationSelectsListeners();
    updateDeleteFieldsButtonsListeners();
});

// For the add line button
var addLineButton = document.querySelector('.oak_add_form_add_line_button');
addLineButton.addEventListener('click', function() {
    addSeperator('Ligne');
});

// For the add space button
var addSpaceButton = document.querySelector('.oak_add_form_add_space_button');
addSpaceButton.addEventListener('click', function() {
    addSeperator('Espace');
});

function addSeperator(text) {
    var fieldsList = document.querySelector('.oak_add_form_fields_list');

    var lineDiv = document.createElement('div');
    lineDiv.className = 'oak_add_form_seperator';

    var span = document.createElement('span');
    span.innerHTML = text;

    lineDiv.append(span);

    var deleteButton = document.createElement('div');
    deleteButton.className = 'oak_add_form_field_options__button oak_add_form__delete_separator_button';
    var i = document.createElement('i');
    i.className = 'fas fa-times';
    deleteButton.append(i);
    deleteButton.addEventListener('click', function() {
        this.parentNode.remove();
    });
    
    lineDiv.append(deleteButton);

    fieldsList.append(lineDiv);
}

handleSeparatorsDeleteButtons();
function handleSeparatorsDeleteButtons() {
    var deleteButtons = document.querySelectorAll('.oak_add_form__delete_separator_button');
    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            this.parentNode.remove();
        });
    }
}

updateFiltersListeners();
function updateFiltersListeners() {
    var fieldsList = document.querySelector('.oak_add_form_fields_list');
    var fieldsContainers = fieldsList.querySelectorAll('.oak_add_form_fields_list__single_field');
    for (var i = 0; i < fieldsContainers.length; i++) {
        var typeSelect = fieldsContainers[i].querySelector('.oak_add_form_fields_list_horizontal__type_select');
        typeSelect.setAttribute('index', i);
        var functionSelect = fieldsContainers[i].querySelector('.oak_add_form_fields_list_horizontal__function_select');
        functionSelect.setAttribute('index', i);
        typeSelect.addEventListener('change', function() {
            var designationsSelect = fieldsContainers[this.getAttribute('index')].querySelector('.oak_add_form_fields_list_horizontal__designation_select');
            var currentFunctionSelect = fieldsContainers[this.getAttribute('index')].querySelector('.oak_add_form_fields_list_horizontal__function_select');
            updateDesignationsSelect(this, currentFunctionSelect, designationsSelect);
        });
        functionSelect.addEventListener('change', function() {
            var designationsSelect = fieldsContainers[this.getAttribute('index')].querySelector('.oak_add_form_fields_list_horizontal__designation_select');
            var currentTypeSelect = fieldsContainers[this.getAttribute('index')].querySelector('.oak_add_form_fields_list_horizontal__type_select');
            updateDesignationsSelect(currentTypeSelect, this, designationsSelect);
        });
    }
}

function updateDesignationsSelect(typeSelect, functionSelect, designationsSelect) {
    var considerType = false;
    var considerFunction = false;
    if (typeSelect.value != '') 
        considerType = true;
    if (functionSelect.value != '')
        considerFunction = true;

    var fieldsToShow = [];
    for (var i = 0; i < DATA.fields.length; i++) {
        var add = true;
        if (considerType && DATA.fields[i].field_type != typeSelect.value) {
            add = false;
        }
        if (considerFunction && DATA.fields[i].field_function != functionSelect.value ) {
            add = false;
        }
        if (add) {
            fieldsToShow.push(DATA.fields[i]);
        }
    }

    var options = designationsSelect.querySelectorAll('option');
    for (var i = 0; i < options.length; i++) {
        exists = false;
        for (var j = 0; j < fieldsToShow.length; j++) {
            if (fieldsToShow[j].field_identifier == options[i].value) {
                exists = true;
            }
        }
        if (exists) {
            options[i].style.display = 'block';
        } else {
            options[i].style.display = 'none';
        }
    }

    // Check if designations select options is empty
    var empty = true;
    for (var i = 0; i < options.length; i++) {
        if (options[i].style.display != 'none') 
            empty = false;

        if (options[i].value == '') 
            options[i].remove();
                
    }
    if (empty) {
        var emptyOption = document.createElement('option');
        emptyOption.innerHTML = '';
        emptyOption.setAttribute('value', '');
        designationsSelect.insertBefore(emptyOption, designationsSelect.firstChild);
        designationsSelect.value = '';
    }
}

updateDeleteFieldsButtonsListeners();
function updateDeleteFieldsButtonsListeners() {
    var deleteButtons = document.querySelectorAll('.oak_add_form_field_options_button_delete');
    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            var fieldContainer = this.parentNode.parentNode.parentNode;
            console.log(fieldContainer);
            fieldContainer.remove();
        });
    }
}

// designation select listener
handleDesignationSelectsListeners();
function handleDesignationSelectsListeners() {
    var designationsSelects = document.querySelectorAll('.oak_add_form_fields_list_horizontal__designation_select');
    for (var i = 0; i < designationsSelects.length; i++) {
        designationsSelects[i].setAttribute('index', i);
        designationsSelects[i].addEventListener('change', function() {
            var theParentOfTheParent = this.parentNode.parentNode;
            theParentOfTheParent.querySelector('.oak_add_form_field_identifier').value = createIdentifier(this.value);
            // console.log(theParentOfTheParent);
        });
    }
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
            console.log(formData);
            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_form',
                        'data': formData,
                    },
                    success: function(data) {
                        DATA.forms.push(formData);
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
            revision.designation = revision.form_designation;
            revision.identifier = revision.form_identifier;
            revision.fields = revision.form_fields;
            revision.selector = revision.form_selector;
            revision.state = revision.form_state;
            revision.trashed = revision.form_trashed;
            revision.structure = revision.form_structure;
            revision.attributs = revision.form_attributes;
            revision.separators = revision.form_separators;

            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_form',
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
