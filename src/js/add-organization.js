// Global variables
var adding = false;
var organizationData = {};
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
        organizationData = createOrganizationData(0);
        adding = true;
        openModal('Êtes vous sur de vouloir ajouter cette Organisation?', true);
    });
}

// For the update button 
var updateButton = document.querySelector('.oak_add_field_container__update_button');
if (updateButton) {
    updateButton.addEventListener('click', function() {
        organizationData = createOrganizationData(DATA.revisions[DATA.revisions.length - 1].organization_state);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier cette organisation?', true);
    });
}

// For the register button
var registerButton = document.querySelector('.oak_add_field_container__register_button');
if (registerButton) {
    registerButton.addEventListener('click', function() {
        organizationData = createOrganizationData(1);
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
        for(var i = 0; i < DATA.organizations.length; i++) {
            if (DATA.organizations[i].designation == designation) {
                openModal('Il existe déjà une organisation avec la désignation: ' + designation);
                ok = false;
            }
        }
        if (ok) {
            var identifierExists = false;
            for (var j = 0; j < DATA.organizations.length; j++) {
                if (DATA.organizations[j].identifier == identifier) {
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
        organizationData = createOrganizationData(2);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
    });
}

// For the back to draft button: 
var draftButton = document.querySelector('.oak_add_field_container__draft_button');
if (draftButton) {
    draftButton.addEventListener('click', function() {
        organizationData = createOrganizationData(0);
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
var identifierInput = document.querySelector('.oak_add_organization_container__identifier');
designationInput.oninput = function() {
    identifierInput.value = createIdentifier(designationInput.value);
}

// We create while adding the new revision
function createOrganizationData(state) {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = createIdentifier(designation);
    var acronym = document.querySelector('.oak_add_field_container__acronym').value;
    var logo = document.querySelector('.oak_add_organization_container__logo_img').getAttribute('src');
    var description = document.querySelector('.oak_add_organization_container__description').value;
    var url = document.querySelector('.oak_add_organization_container__url').value;
    var address = document.querySelector('.oak_add_field_container__address').value;
    var country = document.querySelector('.oak_add_organization_container__country').value;
    var company = document.querySelector('.oak_add_organization_container__company').checked;
    var type = document.querySelector('.oak_add_organization_container__type').value;
    var side = document.querySelector('.oak_add_organization_container__side').checked;
    var sectors = document.querySelector('.oak_add_organization_container__sectors').value;
    trashed = false;
    
    var organizationData = {
        designation, 
        identifier,
        acronym,
        logo,
        description,
        url,
        address,
        country,
        company,
        type,
        side,
        sectors,
        trashed,
        state,
    }

    return organizationData;
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
        
        organizationData = createOrganizationData(DATA.revisions[DATA.revisions.length - 1].organization_state);

        document.querySelector('.oak_revision_organization_current_acronym').value = organizationData.acronym;
        document.querySelector('.oak_revision_organization_current_logo').value = organizationData.logo;
        document.querySelector('.oak_revision_organization_current_description').value = organizationData.description;
        document.querySelector('.oak_revision_organization_current_url').value = organizationData.url;
        document.querySelector('.oak_revision_organization_current_address').value = organizationData.address;
        document.querySelector('.oak_revision_organization_current_country').value = organizationData.country;
        document.querySelector('.oak_revision_organization_current_company').value = organizationData.company;
        document.querySelector('.oak_revision_organization_current_type').value = organizationData.type;
        document.querySelector('.oak_revision_organization_current_side').value = organizationData.side;
        document.querySelector('.oak_revision_organization_current_sectors').value = organizationData.sectors;
        var state = organizationData.state == 0 ? 'Brouillon' : organizationData.state == 1 ? 'Enregsitré' : 'Diffusé';
        document.querySelector('.oak_revision_organization_current_state').value = state;
    }
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

        var revisionAcronymField = document.querySelector('.oak_revision_organization_revision_acronym');
        var revisionLogoField = document.querySelector('.oak_revision_organization_revision_logo');
        var revisionDescriptionField = document.querySelector('.oak_revision_organization_revision_description');
        var revisionUrlField = document.querySelector('.oak_revision_organization_revision_url');
        var revisionAddressField = document.querySelector('.oak_revision_organization_revision_address');
        var revisionCountriesField = document.querySelector('.oak_revision_organization_revision_country');
        var revisionCompanyField = document.querySelector('.oak_revision_organization_revision_company');
        var revisionTypeField = document.querySelector('.oak_revision_organization_revision_type');
        var revisionSideField = document.querySelector('.oak_revision_organization_revision_side');
        var revisionSectorField = document.querySelector('.oak_revision_organization_revision_sectors');
        var revisionStateField = document.querySelector('.oak_revision_organization_revision_state');


        revisionAcronymField.value = selectedRevision.organization_acronym;
        revisionLogoField.value = selectedRevision.organization_logo;
        revisionDescriptionField.value = selectedRevision.organization_description;
        revisionUrlField.value = selectedRevision.organization_url;
        revisionAddressField.value = selectedRevision.organization_address;
        revisionCountriesField.value = selectedRevision.organization;
        revisionCompanyField.value = selectedRevision.organization_country;
        revisionTypeField.value = selectedRevision.organization_type;
        revisionSideField.value = selectedRevision.organization_side;
        revisionSectorField.value = selectedRevision.organization_sectors;
        

        var state = selectedRevision.organization_state == '0' ? 'Brouillon' : selectedRevision.organization_state == '1' ? 'Enregsitré' : 'Diffusé';
        revisionStateField.value = state;

        // Getting the current revision values;
        var organizationData = createOrganizationData(DATA.revisions[DATA.revisions.length - 1].organization_state);

        checkEquals(organizationData.acronym, selectedRevision.organization_acronym, revisionAcronymField);
        checkEquals(organizationData.logo, selectedRevision.organization_logo, revisionLogoField);
        checkEquals(organizationData.description, selectedRevision.organization_description, revisionDescriptionField);
        checkEquals(organizationData.url, selectedRevision.organization_url, revisionUrlField);
        checkEquals(organizationData.country, selectedRevision.organization_country, revisionCountriesField);
        checkEquals(organizationData.company, selectedRevision.organization_company, revisionCompanyField);
        checkEquals(organizationData.type, selectedRevision.organization_type, revisionTypeField);
        checkEquals(organizationData.side, selectedRevision.organization_side, revisionSideField);
        checkEquals(organizationData.sectors, selectedRevision.organization_sectors, revisionSectorField);
        checkEquals(organizationData.state, selectedRevision.organization_state, revisionStateField);

        checkEquals(document.querySelector('.oak_revision_organization_current_state').value, document.querySelector('.oak_revision_organization_revision_state').value, document.querySelector('.oak_revision_organization_revision_state'));
    });
}

function checkEquals(value1, value2, field) {
    if (value1 == value2) {
        field.classList.remove('oak_error');
    } else {
        field.classList.add('oak_error');
    }
}

function addSeperator(text) {
    var formsList = document.querySelector('.oak_add_organization_forms_list');

    var lineDiv = document.createElement('div');
    lineDiv.className = 'oak_add_organization_seperator';

    var span = document.createElement('span');
    span.innerHTML = text;

    lineDiv.append(span);

    var deleteButton = document.createElement('div');
    deleteButton.className = 'oak_add_organization_field_options__button oak_add_organization__delete_separator_button';
    var i = document.createElement('i');
    i.className = 'fas fa-times';
    deleteButton.append(i);
    deleteButton.addEventListener('click', function() {
        this.parentNode.remove();
    });
    
    lineDiv.append(deleteButton);

    formsList.append(lineDiv);
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
    var deleteButtons = document.querySelectorAll('.oak_add_organization_field_options_button_delete');
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
    var designationsSelects = document.querySelectorAll('.oak_add_organization_forms_list_horizontal__designation_select');
    for (var i = 0; i < designationsSelects.length; i++) {
        designationsSelects[i].setAttribute('index', i);
        var theParentOfTheParent = designationsSelects[i].parentNode.parentNode;
        console.log('Designation select value', designationsSelects[i].value);
        theParentOfTheParent.querySelector('.oak_add_organization_field_identifier').value = createIdentifier(designationsSelects[i].value);
        designationsSelects[i].addEventListener('change', function() {
            var theParentOfTheParent = this.parentNode.parentNode;
            theParentOfTheParent.querySelector('.oak_add_organization_field_identifier').value = createIdentifier(this.value);
        });
    }
}

function readUrl(input) {
    console.log('dklfkldflk');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.querySelector('.oak_add_organization_container__logo_img').setAttribute('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
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
            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_organization',
                        'data': organizationData,
                    },
                    success: function(data) {
                        DATA.organizations.push(organizationData);
                        doneLoading();
                        window.location.reload();
                    },
                    error: function(error) {
                        doneLoading();
                    }
                });
            })
        }
        if (canceling) {
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_organizations_list');
        }
        if (browsingRevisions) {
            revision.designation = revision.organization_designation;
            revision.identifier = revision.organization_identifier;
            revision.acronym = revision.organization_acronym;
            revision.logo = revision.organization_logo;
            revision.description = revision.organization_description;
            revision.url = revision.organization_url;
            revision.address = revision.organization_address;
            revision.country = revision.organization_country;
            revision.company = revision.organization_company;
            revision.type = revision.organization_type;
            revision.side = revision.organization_side;
            revision.sectors = revision.organization_sectors;
            revision.state = revision.organization_state;
            revision.trashed = revision.organization_trashed;

            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_organization',
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
