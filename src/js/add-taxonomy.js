// Global variables
var adding = false;
var taxonomyData = {};
var canceling = false;
var updating = false;
var browsingRevisions = false;
var revision = {};

// For the add button
var addButton = document.querySelector('.oak_add_field_container__add_button');
if (addButton) {
    addButton.addEventListener('click', function () {
        var ok = checkOk();
        if (!ok)
            return;
        taxonomyData = createTaxonomyData(0);
        adding = true;
        openModal('Êtes vous sur de vouloir ajouter cette terminologie?', true);
    });
}

// For the update button 
var updateButton = document.querySelector('.oak_add_field_container__update_button');
if (updateButton) {
    updateButton.addEventListener('click', function () {
        taxonomyData = createTaxonomyData(DATA.revisions[DATA.revisions.length - 1].taxonomy_state);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier cette terminologie?', true);
    });
}

// For the register button
var registerButton = document.querySelector('.oak_add_field_container__register_button');
if (registerButton) {
    registerButton.addEventListener('click', function () {
        taxonomyData = createTaxonomyData(1);
        if (DATA.revisions.length == 0) {
            // adding for the first time
            var ok = checkOk();
            if (!ok)
                return;
            adding = true;
        } else {
            updating = true;
        }
        openModal('Êtes vous sûr de vouloir ajouter cette taxonomy à la liste des champs enregistrés?', true);
    });
}

function checkOk() {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = designation.replace(/[^a-zA-Z ]/g, '');
    identifier = identifier.replace(/\s/g, '');

    ok = true;
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    if (designation.trim() == '') {
        openModal('Veuillez entrer la désignation d\'abord', false);
        ok = false;
    } else {
        for (var i = 0; i < DATA.taxonomies.length; i++) {
            if (DATA.taxonomies[i].designation == designation) {
                openModal('Il existe déjà une organisation avec la désignation: ' + designation);
                ok = false;
            }
        }
        if (ok) {
            var identifierExists = false;
            for (var j = 0; j < DATA.taxonomies.length; j++) {
                if (DATA.taxonomies[j].identifier == identifier) {
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
    broadcastButton.addEventListener('click', function () {
        taxonomyData = createTaxonomyData(2);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
    });
}

// For the back to draft button: 
var draftButton = document.querySelector('.oak_add_field_container__draft_button');
if (draftButton) {
    draftButton.addEventListener('click', function () {
        taxonomyData = createTaxonomyData(0);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et renvoyer ce champ à l\'état de Brouillon ?', true);
    });
}

// For the trash button
var trashButton = document.querySelector('.oak_add_field_container__trash_button');
if (trashButton) {
    trashButton.addEventListener('click', function () {
        setLoading();
        jQuery(document).ready(function () {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'data': DATA.currentField.field_identifier,
                    'action': 'oak_send_field_to_trash',
                },
                success: function (data) {
                    console.log(data);
                    doneLoading();
                    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_add_field');
                },
                error: function (error) {
                    console.log(error);
                    doneLoading();
                }
            });
        });
    });
}

// For the identifier input update
var designationInput = document.querySelector('.oak_add_field_container__designation');
var identifierInput = document.querySelector('.oak_add_field_container__identifier');
designationInput.oninput = function () {
    identifierInput.value = createIdentifier(designationInput.value);
}

// We create while adding the new revision
function createTaxonomyData(state) {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = createIdentifier(designation);
    var description = document.querySelector('.oak_add_taxonomy_description').value;
    var structure = document.querySelector('.oak_add_taxonomy_structure').value;
    var numerotation = document.querySelector('.oak_add_taxonomy_numerotation').checked;
    var title = document.querySelector('.oak_add_taxonomy_title').checked;
    var termDescription = document.querySelector('.oak_add_taxonomy_term_description').checked;
    var color = document.querySelector('.oak_add_taxonomy_color').checked;
    var logo = document.querySelector('.oak_add_taxonomy_logo').checked;
    var publication = document.querySelector('.oak_add_taxonomy_publication').value;
    var trashed = false;

    var taxonomyData = {
        designation,
        identifier,
        description,
        structure,
        numerotation,
        title,
        termDescription,
        color,
        logo,
        publication,
        state,
        trashed
    }

    return taxonomyData;
}

function createIdentifier(designation) {
    var identifier = designation.replace(/[^a-zA-Z ]/g, '');
    identifier = identifier.replace(/\s/g, '');
    return identifier.toLowerCase();
}

function whichChild(elem) {
    var i = 0;
    while ((elem = elem.previousSibling) != null)++i;
    return i;
}

// for the browse revisions button:
browseRevisionsButton = document.querySelector('.oak_add_field_big_container_tabs_single_tab_section_state__browse');
browseRevisionsButton.addEventListener('click', function () {
    if (DATA.revisions.length > 0) {
        browsingRevisions = true;
        openModal('Liste des révisions', true);
        // Changing the modal's width

        taxonomyData = createTaxonomyData(DATA.revisions[DATA.revisions.length - 1].taxonomy_state);

        document.querySelector('.oak_revision_taxonomy_current_description').value = taxonomyData.description;
        document.querySelector('.oak_revision_taxonomy_current_structure').value = taxonomyData.structure;
        document.querySelector('.oak_revision_taxonomy_current_numerotation').value = taxonomyData.numerotation;
        document.querySelector('.oak_revision_taxonomy_current_title').value = taxonomyData.title;
        document.querySelector('.oak_revision_taxonomy_current_term_description').value = taxonomyData.termDescription;
        document.querySelector('.oak_revision_taxonomy_current_color').value = taxonomyData.color;
        document.querySelector('.oak_revision_taxonomy_current_logo').value = taxonomyData.logo;
        document.querySelector('.oak_revision_taxonomy_current_publication').value = taxonomyData.publication;
        var state = taxonomyData.state == 0 ? 'Brouillon' : taxonomyData.state == 1 ? 'Enregsitré' : 'Diffusé';
        document.querySelector('.oak_revision_taxonomy_current_state').value = state;
    }
});

// For the browse revisions select button: 
var revisionsButtons = document.querySelectorAll('.oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision');
for (var i = 0; i < revisionsButtons.length; i++) {
    revisionsButtons[i].addEventListener('click', function () {
        for (var j = 0; j < revisionsButtons.length; j++) {
            revisionsButtons[j].classList.remove('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
        }
        this.classList.add('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
        document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container').classList.remove('oak_hidden');

        // Updating the selected revision fields:
        var selectedRevision = DATA.revisions[this.getAttribute('index')];
        revision = selectedRevision;
        console.log('revision', revision);

        var revisionDescriptionField = document.querySelector('.oak_revision_taxonomy_revision_description');
        var revisionStructureField = document.querySelector('.oak_revision_taxonomy_revision_structure');
        var revisionNumerotationField = document.querySelector('.oak_revision_taxonomy_revision_numerotation');
        var revisionTitleField = document.querySelector('.oak_revision_taxonomy_revision_title');
        var revisionTermDescriptionField = document.querySelector('.oak_revision_taxonomy_revision_term_description');
        var revisionColorField = document.querySelector('.oak_revision_taxonomy_revision_color');
        var revisionLogoField = document.querySelector('.oak_revision_taxonomy_revision_logo');
        var revisionPublicationField = document.querySelector('.oak_revision_taxonomy_revision_publication');
        var revisionStateField = document.querySelector('.oak_revision_taxonomy_revision_state');

        revisionDescriptionField.value = selectedRevision.taxonomy_description;
        revisionStructureField.value = selectedRevision.taxonomy_structure;
        revisionNumerotationField.value = selectedRevision.taxonomy_numerotation;
        revisionTitleField.value = selectedRevision.taxonomy_title;
        revisionTermDescriptionField.value = selectedRevision.taxonomy_term_description;
        revisionColorField.value = selectedRevision.taxonomy_color;
        revisionLogoField.value = selectedRevision.taxonomy_logo;
        revisionPublicationField.value = selectedRevision.taxonomy_publication;

        var state = selectedRevision.taxonomy_state == '0' ? 'Brouillon' : selectedRevision.taxonomy_state == '1' ? 'Enregsitré' : 'Diffusé';
        revisionStateField.value = state;

        // Getting the current revision values;
        var taxonomyData = createTaxonomyData(DATA.revisions[DATA.revisions.length - 1].taxonomy_state);
        
        checkEquals(taxonomyData.description, selectedRevision.taxonomy_description, revisionDescriptionField);
        checkEquals(taxonomyData.structure, selectedRevision.taxonomy_structure, revisionStructureField);
        checkEquals(taxonomyData.numerotation.toString(), selectedRevision.taxonomy_numerotation, revisionNumerotationField);
        checkEquals(taxonomyData.title.toString(), selectedRevision.taxonomy_title, revisionTitleField);
        checkEquals(taxonomyData.termDescription.toString(), selectedRevision.taxonomy_term_description, revisionTermDescriptionField);
        checkEquals(taxonomyData.color.toString(), selectedRevision.taxonomy_color, revisionColorField);
        checkEquals(taxonomyData.logo.toString(), selectedRevision.taxonomy_logo, revisionLogoField);
        checkEquals(taxonomyData.publication == null ? '' : taxonomyData.publication, selectedRevision.taxonomy_publication, revisionPublicationField);
        checkEquals(document.querySelector('.oak_revision_taxonomy_current_state').value, document.querySelector('.oak_revision_taxonomy_revision_state').value, document.querySelector('.oak_revision_taxonomy_revision_state'));
    });
}

function checkEquals(value1, value2, field) {
    if (value1 == value2) {
        field.classList.remove('oak_error');
    } else {
        field.classList.add('oak_error');
    }
}

// designation select listener
handleDesignationSelectsListeners();
function handleDesignationSelectsListeners() {
    var designationsSelects = document.querySelectorAll('.oak_add_taxonomy_forms_list_horizontal__designation_select');
    for (var i = 0; i < designationsSelects.length; i++) {
        designationsSelects[i].setAttribute('index', i);
        var theParentOfTheParent = designationsSelects[i].parentNode.parentNode;
        theParentOfTheParent.querySelector('.oak_add_taxonomy_field_identifier').value = createIdentifier(designationsSelects[i].value);
        designationsSelects[i].addEventListener('change', function () {
            var theParentOfTheParent = this.parentNode.parentNode;
            theParentOfTheParent.querySelector('.oak_add_taxonomy_field_identifier').value = createIdentifier(this.value);
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
    if (twoButtons) {
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
okButtonContainer.addEventListener('click', function () {
    closeModals();
});

function closeModals() {

    setTimeout(function () {
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
    setTimeout(function () {
        document.querySelector('.oak_loader').classList.add('oak_hidden');
        document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.remove('oak_hidden');
    }, 1000);
}

handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function () {
        if (adding || updating) {
            closeModals();
            console.log(taxonomyData);
            setLoading();
            jQuery(document).ready(function () {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_taxonomy',
                        'data': taxonomyData,
                    },
                    success: function (data) {
                        DATA.taxonomies.push(taxonomyData);
                        doneLoading();
                        window.location.reload();
                    },
                    error: function (error) {
                        doneLoading();
                    }
                });
            })
        }
        if (canceling) {
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_taxonomies_list');
        }
        if (browsingRevisions) {
            revision.designation = revision.taxonomy_designation;
            revision.identifier = revision.taxonomy_identifier;
            revision.description = revision.taxonomy_description;
            revision.structure = revision.taxonomy_structure;
            revision.numerotation = revision.taxonomy_numerotation;
            revision.title = revision.taxonomy_title;
            revision.termDescription = revision.taxonomy_term_description;
            revision.color = revision.taxonomy_color;
            revision.logo = revision.taxonomy_logo;
            revision.state = revision.taxonomy_state;
            revision.trashed = revision.taxonomy_trashed;
            closeModals();
            setLoading();
            jQuery(document).ready(function () {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_taxonomy',
                        'data': revision,
                    },
                    success: function (data) {
                        doneLoading();
                        console.log(data);
                        window.location.reload();
                    },
                    error: function (error) {
                        doneLoading();
                    }
                });
            })
        }
    });

    var cancelButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function () {
        closeModals();
    });
}

function backToList() {
    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
}
