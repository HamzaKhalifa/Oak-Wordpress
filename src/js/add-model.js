// Global variables
var adding = false;
var modelData = {};
var canceling = false;
var updating = false;
var browsingRevisions = false;
var revision = {};

// Removing Revisions from DATA fields
removeRevisions();
function removeRevisions() {
    var addedForms = [];
    for (var j = 0; j < DATA.forms.length; j++) {
        var exists = false;
        for (var n = 0; n < addedForms.length; n++) {
            if (addedForms[n].form_identifier == DATA.forms[j].form_identifier) {
                exists = true;
            }
        }
        if (!exists) {
            addedForms.push(DATA.forms[j]);
        }
    }
    DATA.forms = addedForms;
}

// For the add button
var addButton = document.querySelector('.oak_add_field_container__add_button');
if (addButton) {
    addButton.addEventListener('click', function() {
        var ok = checkOk();
        if (!ok)
            return;
        modelData = createModelData(0);
        adding = true;
        openModal('Êtes vous sur de vouloir ajouter ce modèle?', true);
    });
}

// For the update button 
var updateButton = document.querySelector('.oak_add_field_container__update_button');
if (updateButton) {
    updateButton.addEventListener('click', function() {
        modelData = createModelData(DATA.revisions[DATA.revisions.length - 1].model_state);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier ce champ?', true);
    });
}

// For the register button
var registerButton = document.querySelector('.oak_add_field_container__register_button');
if (registerButton) {
    registerButton.addEventListener('click', function() {
        modelData = createModelData(1);
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
        for(var i = 0; i < DATA.models.length; i++) {
            if (DATA.models[i].designation == designation) {
                openModal('Il existe déjà un modèle avec la désignation: ' + designation);
                ok = false;
            }
        }
        if (ok) {
            var identifierExists = false;
            for (var j = 0; j < DATA.models.length; j++) {
                if (DATA.models[j].identifier == identifier) {
                    identifierExists = true;
                    ok = false;
                }
            }
            if (identifierExists) {
                openModal('Il existe déjà un modèle avec l\'identifiant: ' + identifier);
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
        modelData = createModelData(2);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
    });
}

// For the back to draft button: 
var draftButton = document.querySelector('.oak_add_field_container__draft_button');
if (draftButton) {
    draftButton.addEventListener('click', function() {
        modelData = createModelData(0);
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
var identifierInput = document.querySelector('.oak_add_model_container__identifier');
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

    var modelData = { designation, identifier, type, functionField, defaultValue,
        instructions,
        placeholder,
        before,
        after,
        maxLength,
        selector,
        state: DATA.revisions[DATA.revisions.length - 1].field_state,
        trashed: DATA.revisions[DATA.revisions.length - 1].field_trashed
    }

    return modelData;
}

// We create while adding the new revision
function createModelData(state) {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = createIdentifier(designation);
    var types =  jQuery('.oak_add_model_container__types').val();
    var publicationsCategories = document.querySelector('.oak_add_model_container__publications_categories').value;
    var selector = document.querySelector('.oak_add_model_container__selector').checked;
    var trashed = false;

    forms = '';
    var formsContainers = document.querySelectorAll('.oak_add_model_forms_list__single_form');
    for (var i= 0; i < formsContainers.length; i++) {
        var formDesignation = formsContainers[i].querySelector('.oak_add_model_forms_list_horizontal__designation_select').value;
        var name = formsContainers[i].querySelector('.oak_add_model_form_rename').value;
        var gabarit = formsContainers[i].querySelector('.oak_add_model_form_gabarit').value;

        var whichChildIsIt = whichChild(formsContainers[i]);
        forms += formDesignation + ':' + createIdentifier(formDesignation) + ':' + name + ':' + gabarit + ':' + whichChildIsIt + '|';
    }

    var separators = ''
    var separatorsElements = document.querySelectorAll('.oak_add_model_seperator');
    for (var i = 0; i < separatorsElements.length; i++) {
        separators += separatorsElements[i].querySelector('span').innerHTML + ':' + whichChild(separatorsElements[i]) + '|';
    }
    
    var modelData = {
        designation, 
        identifier,
        types,
        publicationsCategories,
        selector,
        trashed,
        forms,
        state,
        separators
    }

    return modelData;
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
    if (DATA.revisions.length > 0) {
        browsingRevisions = true;
        openModal('Liste des révisions', true);
        // Changing the modal's width
        
        modelData = createModelData(DATA.revisions[DATA.revisions.length - 1].model_state);
    
        document.querySelector('.oak_revision_model_current_types').value = modelData.types;
        document.querySelector('.oak_revision_model_current_publications_categories').value = modelData.publicationsCategories;
        document.querySelector('.oak_revision_model_selector_current').value = modelData.selector;
        var state = modelData.state == 0 ? 'Brouillon' : modelData.state == 1 ? 'Enregsitré' : 'Diffusé';
        document.querySelector('.oak_revision_model_state_current').value = state;
    }
});

// For the browse revisions select button: 
var revisionsButtons = document.querySelectorAll('.oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions__single_revision');
for( var i = 0; i < revisionsButtons.length; i++ ) {
    revisionsButtons[i].addEventListener('click', function(){
        for (var j = 0; j < revisionsButtons.length; j++) {
            revisionsButtons[j].classList.remove('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
        }
        this.classList.add('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
        document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container').classList.remove('oak_hidden');

        // Updating the selected revision fields:
        var selectedRevision = DATA.revisions[this.getAttribute('index')];
        revision = selectedRevision;

        var revisionTypesField = document.querySelector('.oak_revision_model_revision_types');
        var revisionPublicationsCategoriesField = document.querySelector('.oak_revision_model_revision_publications_categories');
        var revisionSelectorField = document.querySelector('.oak_revision_model_selector_revision');
        var revisionStateField = document.querySelector('.oak_revision_model_state_revision');

        revisionTypesField.value = selectedRevision.model_types;
        revisionPublicationsCategoriesField.value = selectedRevision.model_publications_categories;
        revisionSelectorField.value = selectedRevision.model_selector;

        var state = selectedRevision.model_state == '0' ? 'Brouillon' : selectedRevision.model_state == '1' ? 'Enregsitré' : 'Diffusé';
        revisionStateField.value = state;

        // Getting the current revision values;
        var modelData = createModelData(DATA.revisions[DATA.revisions.length - 1].model_state);

        checkEquals(modelData.structure, selectedRevision.model_structure, revisionPublicationsCategoriesField);
        checkEquals(modelData.publicationsCategories, selectedRevision.model_publications_categories, revisionPublicationsCategoriesField);
        checkEquals(modelData.selector.toString(), selectedRevision.model_selector.toString(), revisionSelectorField);

        checkEquals(document.querySelector('.oak_revision_model_state_current').value, document.querySelector('.oak_revision_model_state_revision').value, document.querySelector('.oak_revision_model_state_revision'));
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
var addFormButton = document.querySelector('.oak_add_model_add_form_button');
addFormButton.addEventListener('click', function() {
    var formsList = document.querySelector('.oak_add_model_forms_list')

    var singleFieldContainer = document.createElement('div');
    singleFieldContainer.className = 'oak_add_model_forms_list__single_form';
    
    singleFieldContainer.innerHTML = '<div class="oak_add_field_container__isert_field_title_container oak_add_model_forms_list__horizontal oak_add_model_forms_list__horizontal_without_margin_top oak_add_model_field_options">'
    + '<div class="oak_add_model_forms_list__horizontal">'
    + '<img class="oak_add_model_container_header_icon" src="' + DATA.templateDirectoryUri + '/src/assets/icons/fields.png" alt="">' 
    + '<h4 class="oak_add_field_container__isert_field_title">Insérer un formulaire</h4></div>'
    + '<div class="oak_add_model_forms_list__buttons_container"><div class="oak_add_model_field_options__button oak_add_model_field_options_button_delete"><i class="fas fa-times"></i></div></div>'
    + '</div>'
    + '<div class="oak_add_model_forms_list__horizontal oak_add_model_forms_list__horizontal_without_margin_top">'
    + '<div class="oak_add_model_forms_list__vertical oak_left_field">'
    + '<label class="oak_add_field_label" for="type">Structure</label>'
    + '<select class="oak_add_model_form_structure" name="type" id="">'
    + '<option value=""></option> <option value="fixed">Fixe</option> <option value="semi-structured">Semi-Structuré/Non Structuré</option>'
    + '</select>'
    + '</div> <div class="oak_add_model_forms_list__vertical"> <label class="oak_add_field_label" for="type">Attributs</label>'
    + '<select class="oak_add_model_forms_list_horizontal__attributes_select" name="type" id=""><option value=""></option>'
    + '</select></div></div><div class="oak_add_model_forms_list__horizontal"><div class="oak_add_model_forms_list__vertical oak_left_field">'
    + '<label class="oak_add_field_label" for="field-designation">Désignation du formulaire</label><select class="oak_add_model_forms_list_horizontal__designation_select" name="field-designation" id=""></select></div>'
    + '<div class="oak_add_model_forms_list__vertical"><label class="oak_add_field_label" for="form-identifier">Identifiant Unique</label><input disabled name="field-identifier" type="text" value="" class="oak_add_field_container__input oak_add_model_field_identifier"></div></div>'
    + '<div class="oak_add_model_forms_list__horizontal"><div class="oak_add_model_forms_list__horizontal oak_left_field"><label class="oak_add_field_label" for="field-identifier">Renommer</label><input name="field-identifier" type="text" value="" class="oak_add_field_container__input oak_add_model_form_rename"></div>'
    + '<div class="oak_add_model_forms_list__horizontal">'
    + '<label class="oak_add_field_label without_margin_bottom" for="gabarit">Gabarit</label>'
    + '<select class="oak_add_model_form_gabarit" name="gabarit" id="">'
    + '<option value="Gabarit 1">Gabarit 1</option>'
    + '<option value="Gabarit 2">Gabarit 2</option>'
    + '<option value="Gabarit 3">Gabarit 3</option>'
    + '</select>'
    + '</div>'
    + '</div>'

    for (var i = 0; i < DATA.attributes.length; i++) {
        var option = document.createElement('option');
        option.setAttribute('value', DATA.attributes[i]);
        option.innerHTML = DATA.attributes[i];
        singleFieldContainer.querySelector('.oak_add_model_forms_list_horizontal__attributes_select').append(option);
    }

    formsList.append(singleFieldContainer);

    var designationsSelects = formsList.querySelectorAll('.oak_add_model_forms_list_horizontal__designation_select');
    designationsSelects[designationsSelects.length - 1].innerHTML = '';
    for (var j = 0; j < DATA.forms.length; j++) {
        var option = document.createElement('option');
        option.setAttribute('value', DATA.forms[j].form_identifier);
        option.innerHTML = DATA.forms[j].form_designation;
        designationsSelects[designationsSelects.length - 1].append(option);
    }

    updateFiltersListeners();
    handleDesignationSelectsListeners();
    updateDeleteFieldsButtonsListeners();
});

// For the add line button
var addLineButton = document.querySelector('.oak_add_model_add_line_button');
addLineButton.addEventListener('click', function() {
    addSeperator('Ligne');
});

// For the add space button
var addSpaceButton = document.querySelector('.oak_add_model_add_space_button');
addSpaceButton.addEventListener('click', function() {
    addSeperator('Espace');
});

function addSeperator(text) {
    var formsList = document.querySelector('.oak_add_model_forms_list');

    var lineDiv = document.createElement('div');
    lineDiv.className = 'oak_add_model_seperator';

    var span = document.createElement('span');
    span.innerHTML = text;

    lineDiv.append(span);

    var deleteButton = document.createElement('div');
    deleteButton.className = 'oak_add_model_field_options__button oak_add_model__delete_separator_button';
    var i = document.createElement('i');
    i.className = 'fas fa-times';
    deleteButton.append(i);
    deleteButton.addEventListener('click', function() {
        this.parentNode.remove();
    });
    
    lineDiv.append(deleteButton);

    formsList.append(lineDiv);
}

handleSeparatorsDeleteButtons();
function handleSeparatorsDeleteButtons() {
    var deleteButtons = document.querySelectorAll('.oak_add_model__delete_separator_button');
    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            this.parentNode.remove();
        });
    }
}

updateFiltersListeners();
function updateFiltersListeners() {
    var formsList = document.querySelector('.oak_add_model_forms_list');
    var formsContainers = formsList.querySelectorAll('.oak_add_model_forms_list__single_form');
    for (var i = 0; i < formsContainers.length; i++) {
        var structureSelect = formsContainers[i].querySelector('.oak_add_model_form_structure');
        structureSelect.setAttribute('index', i);
        var attributesSelect = formsContainers[i].querySelector('.oak_add_model_forms_list_horizontal__attributes_select');
        attributesSelect.setAttribute('index', i);
        structureSelect.addEventListener('change', function() {
            var designationsSelect = formsContainers[this.getAttribute('index')].querySelector('.oak_add_model_forms_list_horizontal__designation_select');
            var currentattributesSelect = formsContainers[this.getAttribute('index')].querySelector('.oak_add_model_forms_list_horizontal__attributes_select');
            updateDesignationsSelect(this, currentattributesSelect, designationsSelect);
        });
        attributesSelect.addEventListener('change', function() {
            var designationsSelect = formsContainers[this.getAttribute('index')].querySelector('.oak_add_model_forms_list_horizontal__designation_select');
            var currentstructureSelect = formsContainers[this.getAttribute('index')].querySelector('.oak_add_model_form_structure');
            updateDesignationsSelect(currentstructureSelect, this, designationsSelect);
        });
    }
}

function updateDesignationsSelect(structureSelect, attributesSelect, designationsSelect) {
    var considerStructure = false;
    var considerAttributes = false;
    if (structureSelect.value != '') 
        considerStructure = true;
    if (attributesSelect.value != '')
        considerAttributes = true;

    var formsToShow = [];
    for (var i = 0; i < DATA.forms.length; i++) {
        var add = true;
        if (considerStructure && DATA.forms[i].form_structure != structureSelect.value) {
            add = false;
        }
        if (considerAttributes) {
            exists = false;
            var formAttributes = DATA.forms[i].form_attributes.split(',');
            for (var j = 0; j < formAttributes.length; j++) {
                if (attributesSelect.value == formAttributes[j]) {
                    exists = true;
                }
            }
            if (!exists) 
                add = false;
        }

        if (add) {
            formsToShow.push(DATA.forms[i]);
        }
    }

    var options = designationsSelect.querySelectorAll('option');
    for (var i = 0; i < options.length; i++) {
        exists = false;
        for (var j = 0; j < formsToShow.length; j++) {
            if (formsToShow[j].form_identifier == options[i].value) {
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
    var deleteButtons = document.querySelectorAll('.oak_add_model_field_options_button_delete');
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
    var designationsSelects = document.querySelectorAll('.oak_add_model_forms_list_horizontal__designation_select');
    for (var i = 0; i < designationsSelects.length; i++) {
        designationsSelects[i].setAttribute('index', i);
        var theParentOfTheParent = designationsSelects[i].parentNode.parentNode;
        console.log('Designation select value', designationsSelects[i].value);
        theParentOfTheParent.querySelector('.oak_add_model_field_identifier').value = createIdentifier(designationsSelects[i].value);
        designationsSelects[i].addEventListener('change', function() {
            var theParentOfTheParent = this.parentNode.parentNode;
            theParentOfTheParent.querySelector('.oak_add_model_field_identifier').value = createIdentifier(this.value);
        });
    }
}

// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_add_button_container__text');
    var cancelButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_cancel_button_container__text');
    var confirmButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
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
    var modalContainer = document.querySelector('.oak_add_element_modal_container__modal');
    var revisionsContent = document.querySelector('.oak_add_element_modal_container_modal_content__revisions_content');
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

    var confirmButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_add_button_container__text');

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_add_element_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    var addButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');
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

var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');
okButtonContainer.addEventListener('click', function() {
    closeModals();
}); 

function closeModals() {
    
    setTimeout(function() {
        document.querySelector('.oak_add_element_modal_container__modal').classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
        document.querySelector('.oak_add_element_modal_container_modal_content__revisions_content').classList.add('oak_hidden');
    }, 500);

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
    adding = canceling = updating = browsingRevisions = false;
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

handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function() {
        if (adding || updating) {
            console.log(modelData);
            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_model',
                        'data': modelData,
                    },
                    success: function(data) {
                        DATA.models.push(modelData);
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
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_models_list');
        }
        if (browsingRevisions) {
            revision.designation = revision.model_designation;
            revision.identifier = revision.model_identifier;
            revision.types = revision.model_types;
            revision.publicationsCategories = revision.model_publications_categories;
            revision.selector = revision.model_selector;
            revision.trashed = revision.model_trashed;
            revision.forms = revision.model_forms;
            revision.state = revision.model_state;
            revision.separators = revision.model_separators;

            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_model',
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

    var cancelButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function() {
        closeModals();
    });
}

function backToList() {
    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
}
