var addPrincipleButton = document.querySelector('.dawn_critical_analysis_configuration_principles_title_container__add_principle_button');
var addPrincipleCancelButton = document.querySelector('.dawn_critical_analysis_configuration_modals_container_add_principle_modal_buttons_container__cancel_button');
var addPrincipleAddButton = document.querySelector('.dawn_critical_analysis_configuration_modals_container_add_principle_modal_buttons_container__add_button');
var addError = document.querySelector('.dawn_critical_analysis_configuration_modals_container_add_principle_modal__error');
var addPrincipleInputField = document.querySelector('.dawn_critical_analysis_configuration_modals_container__add_principle_modal__input');
var loadBasicDataButton = document.querySelector('.dawn_critical_analysis_configuration__load_base_data_button');
var saveButton = document.querySelector('.dawn_critical_analysis_configuration__save_button');

var modalsContainer = document.querySelector('.dawn_critical_analysis_configuration__modals_container');

var addingForPrinciple = true;
// We store the principle name when we are about to add a criterion to it:
var selectedPrinciple = '';

initialize();

function initialize() {
    setLoading();
    var principles = DATA.principles; 
    for (var i = 0; i < principles.length; i++) {
        addPrinciple(principles[i].principle, principles[i]);
        selectedPrinciple = principles[i].principle.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "");
        if (principles[i].criteria) {
            for (var j = 0; j < principles[i].criteria.length; j++) {
                addCriterion(principles[i].criteria[j]);
            }
        }
    }
    doneLoading();
}


addPrincipleButton.addEventListener('click', function(e) {
    openModals(true);
});

addPrincipleCancelButton.addEventListener('click', function() {
    closeModals();
});

addPrincipleAddButton.addEventListener('click', function() {
    var inputFieldValue = addPrincipleInputField.value;
    if (inputFieldValue.trim() == '') {
        addError.innerHTML = 'Veuillez entrer le nom d\'abord';
        return;
    }
    addError.innerHTML = '';
    if (addingForPrinciple)
        addPrinciple(inputFieldValue);
    else 
        addCriterion(inputFieldValue);
});

function openModals(addingPrinciple) {
    addPrincipleInputField.value = '';
    modalsContainer.classList.add('dawn_critical_analysis_configuration__modals_container_activated');
    var modalTitle = document.querySelector('.dawn_critical_analysis_configuration_modals_container_add_principle_modal_title_container__title'); 
    modalTitle.innerHTML = addingPrinciple ? 'Ajouter un Principe de Reporting' : 'Ajouter un Critère de Principe de Reporting';
    addingForPrinciple = addingPrinciple;
}

function closeModals() {
    modalsContainer.classList.remove('dawn_critical_analysis_configuration__modals_container_activated');
    addError.innerHTML = '';
}

function setLoading() {
    openModals();
    document.querySelector('.dawn_loader').classList.remove('dawn_hidden');
    document.querySelector('.dawn_critical_analysis_configuration_modals_container__add_principle_modal').classList.add('dawn_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function() {
        document.querySelector('.dawn_loader').classList.add('dawn_hidden');
        document.querySelector('.dawn_critical_analysis_configuration_modals_container__add_principle_modal').classList.remove('dawn_hidden');
    }, 1000);
}

function addPrinciple(principleName, principleData) {
    var principleDiv = document.createElement('div');
    principleDiv.className = 'dawn_critical_analysis_configuration_principles__principle';
    principleDiv.id = principleName.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_principle_container';

    var principleContainerDiv = document.createElement('div');
    principleContainerDiv.className = 'dawn_critical_analysis_configuration_principles_principle__container';

    var principleTitleH3 = document.createElement('h3');
    principleTitleH3.className = 'dawn_critical_analysis_configuration_principles_principle_container__title';
    principleTitleH3.innerHTML = principleName;

    var deleteButton = document.createElement('i');
    deleteButton.className = 'fas fa-trash-alt';
    deleteButton.id =  principleName.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_principle_delete_button';
    deleteButton.addEventListener('click', function() {
        document.querySelector('.dawn_critical_analysis_configuration__principles').removeChild(document.querySelector('#' + this.getAttribute('id').split('_')[0] + '_principle_container'));
    })

    principleContainerDiv.append(principleTitleH3);
    principleContainerDiv.append(deleteButton);


    // Added data
    var principleDefinitionLabel = document.createElement('span');
    principleDefinitionLabel.className = 'dawn_critical_analysis_configuration_principles_principle__definition_label';
    principleDefinitionLabel.innerHTML = 'Définition du principe';

    var definitionTextArea = document.createElement('textarea');
    definitionTextArea.className = 'dawn_critical_analysis_configuration_principles_principle__textarea'
    definitionTextArea.setAttribute('cols', 30);
    definitionTextArea.setAttribute('rows', 5);
    if (principleData) {
        definitionTextArea.value = principleData.principleDescription;
    }

    // For the image
    var principleImageContainerDiv = document.createElement('div');
    principleImageContainerDiv.className = 'dawn_critical_analysis_configuration_principles_principle_image';

    var principleImageTitleH3 = document.createElement('h3');
    principleImageTitleH3.innerHTML = 'Image: '

    var imageInput = document.createElement('input');
    imageInput.id = principleName.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_image_input';
    imageInput.setAttribute('type', 'file');
    imageInput.setAttribute('onChange', 'readUrl(this);');

    var image = document.createElement('img');
    image.className = 'dawn_critical_analysis_configuration_principles_principle_image__image';
    image.id = principleName.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_image';
    if (principleData) {
        image.setAttribute('src', principleData.image);
    }

    principleImageContainerDiv.append(principleImageTitleH3);
    principleImageContainerDiv.append(imageInput);
    principleImageContainerDiv.append(image);
    // Done with the image

    var rolesTitleContainer = document.createElement('div');
    rolesTitleContainer.className = 'dawn_critical_analysis_configuration_principles_principle__roles_title_container';

    var rolesTitle = document.createElement('span');
    rolesTitle.className = 'dawn_critical_analysis_configuration_principles_principle_roles_title_container__label';
    rolesTitle.innerHTML = 'Roles';

    var addRoleButton = document.createElement('i');
    addRoleButton.className = 'fas fa-plus-square';
    addRoleButton.id = principleName.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_add_role_button';
    addRoleButton.addEventListener('click', function() {
        var roleHeadingContainer = document.querySelector('#' + this.getAttribute('id').split('_')[0] + '_role_heading_container');
        // Creating a role input 
        var singleRole = document.createElement('div');
        singleRole.className = 'dawn_critical_analysis_configuration_principles_principle__single_role';
        var roleId = makeid();
        singleRole.id = roleId + '_single_role';

        var textarea = document.createElement('textarea');
        textarea.className = 'dawn_critical_analysis_configuration_principles_principle__single_role_textarea';
        textarea.setAttribute('cols', 30);
        textarea.setAttribute('rows', 2);
        
        var deleteButton = document.createElement('i');
        deleteButton.className = 'fas fa-trash-alt';
        deleteButton.id = roleId + '_' + principleName.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "");
        deleteButton.addEventListener('click', function() {
            var parent = document.querySelector('#' + this.getAttribute('id').split('_')[1] + '_principle_container');
            var childToRemove = parent.querySelector('#' + this.getAttribute('id').split('_')[0] + '_single_role');
            parent.removeChild(childToRemove);
        })


        singleRole.append(textarea);
        singleRole.append(deleteButton);
        roleHeadingContainer.parentNode.insertBefore(singleRole, roleHeadingContainer.nextSibling);
        // Done creating a role input
    });

    rolesTitleContainer.append(rolesTitle);
    rolesTitleContainer.append(addRoleButton);

    var roleHeadingContainer = document.createElement('div');
    roleHeadingContainer.className = 'dawn_critical_analysis_configuration_principles_principle__role_title_container';
    roleHeadingContainer.id = principleName.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_role_heading_container';

    var heading = document.createElement('span');
    heading.className = 'dawn_critical_analysis_configuration_principles_principle_role_title_container__title';
    heading.innerHTML = 'Entête des roles:';

    var headingTextArea = document.createElement('textarea');
    headingTextArea.className = 'dawn_critical_analysis_configuration_principles_principle_role_title_container__textarea';
    headingTextArea.setAttribute('cols', 30);
    headingTextArea.setAttribute('rows', 2);
    if (principleData) {
        headingTextArea.value = principleData.content.title;
    }

    roleHeadingContainer.append(heading);
    roleHeadingContainer.append(headingTextArea);


    principleDiv.append(principleContainerDiv);
    principleDiv.append(principleDefinitionLabel);
    principleDiv.append(definitionTextArea);
    principleDiv.append(principleImageContainerDiv);
    principleDiv.append(rolesTitleContainer);
    principleDiv.append(roleHeadingContainer);

    if (principleData && principleData.content.roles) {
        for (var i = 0; i < principleData.content.roles.length; i++) {
            var singleRole = document.createElement('div');
            singleRole.className = 'dawn_critical_analysis_configuration_principles_principle__single_role';
            singleRole.id = principleData.content.roles[i].replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_single_role';

            var textarea = document.createElement('textarea');
            textarea.className = 'dawn_critical_analysis_configuration_principles_principle__single_role_textarea';
            textarea.setAttribute('cols', 30);
            textarea.setAttribute('rows', 2);
            textarea.value = principleData.content.roles[i];
            
            var deleteButton = document.createElement('i');
            deleteButton.className = 'fas fa-trash-alt';
            deleteButton.id = principleData.content.roles[i].replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_' + principleName.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "");
            deleteButton.addEventListener('click', function() {
                var parent = document.querySelector('#' + this.getAttribute('id').split('_')[1] + '_principle_container');
                var childToRemove = parent.querySelector('#' + this.getAttribute('id').split('_')[0] + '_single_role');
                parent.removeChild(childToRemove);
            })


            singleRole.append(textarea);
            singleRole.append(deleteButton);

            principleDiv.append(singleRole);
        }
    }

    var principleCriteriaDiv = document.createElement('div');
    principleCriteriaDiv.className = 'dawn_critical_analysis_configuration_principles_principle__criteria';
    principleCriteriaDiv.id = principleName.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_criteria_container';

    var criteriaAddContainerDiv = document.createElement('div');
    criteriaAddContainerDiv.className = 'dawn_critical_analysis_configuration_principles_principle__add_container';

    var criteriaAddButtonDiv = document.createElement('div');
    criteriaAddButtonDiv.className = 'dawn_critical_analysis_configuration_principles_principle_add_container__add_button';
    criteriaAddButtonDiv.id = principleName.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_criteria_button';
    criteriaAddButtonDiv.addEventListener('click', function() {
        openModals(false);
        id = this.getAttribute('id');
        selectedPrinciple = id.split('_')[0];
    })

    var criteriaAddSpan = document.createElement('span');
    criteriaAddSpan.className = 'dawn_critical_analysis_configuration_principles_principle_add_container_add_button__text';
    criteriaAddSpan.innerHTML = 'Ajouter un critère';

    criteriaAddButtonDiv.append(criteriaAddSpan);
    criteriaAddContainerDiv.append(criteriaAddButtonDiv);

    principleDiv.append(principleCriteriaDiv);
    principleDiv.append(criteriaAddContainerDiv);

    var principlesContainer = document.querySelector('.dawn_critical_analysis_configuration__principles');
    principlesContainer.append(principleDiv);

    closeModals();

    // What we are creating here
    // <div class="dawn_critical_analysis_configuration_principles__principle">
    //     <div class="dawn_critical_analysis_configuration_principles_principle__container">
    //         <h3 class="dawn_critical_analysis_configuration_principles_principle_container__title">Implication des parties prenantes</h3>
    //         <i class="fas fa-trash-alt"></i>
    //     </div>

    //     <span class="dawn_critical_analysis_configuration_principles_principle__definition_label">Définition du principe</span>
    //     <textarea class="dawn_critical_analysis_configuration_principles_principle__textarea" cols="30" rows="5"></textarea>

    //     <div class="dawn_critical_analysis_configuration_principles_principle_image">
    //         <h3>Image</h3>
    //         <input type="file" src="" onChange="readUrl(this);" alt="">
    //         <img src="" id="principle_image" class="dawn_critical_analysis_configuration_principles_principle_image__image" alt="">
    //     </div>

    //     <div class="dawn_critical_analysis_configuration_principles_principle__roles_title_container">
    //         <span class="dawn_critical_analysis_configuration_principles_principle_roles_title_container__label">Roles</span>
    //         <i class="fas fa-plus-square"></i>
    //     </div>
    //     <div class="dawn_critical_analysis_configuration_principles_principle__role_title_container">
    //         <span class="dawn_critical_analysis_configuration_principles_principle_role_title_container__title">Entête des roles:</span>
    //         <textarea class="dawn_critical_analysis_configuration_principles_principle_role_title_container__textarea" cols="30" rows="2"></textarea>
    //     </div>
    //     <div class="dawn_critical_analysis_configuration_principles_principle__single_role">
    //         <textarea class="dawn_critical_analysis_configuration_principles_principle__single_role_textarea" cols="30" rows="2"></textarea>
    //         <i class="fas fa-trash-alt"></i>
    //     </div>


    //     <div class="dawn_critical_analysis_configuration_principles_principle__criteria">
    //         <!-- This is where the criteria are gonna be added dynamically.  -->
    //     </div>
    //     <div class="dawn_critical_analysis_configuration_principles_principle__add_container">
    //         <div class="dawn_critical_analysis_configuration_principles_principle_add_container__add_button">
    //             <span class="dawn_critical_analysis_configuration_principles_principle_add_container_add_button__text" >
    //                 Ajouter un critère
    //             </span>
    //         </div>
    //     </div>
    // </div>
}

function addCriterion(criterion) {
    var criteriaContainerDiv = document.querySelector('#' + selectedPrinciple + '_criteria_container');

    var criterionDiv = document.createElement('div');
    criterionDiv.className = 'dawn_critical_analysis_configuration_principles_principle_criteria__criterion';
    criterionDiv.id = criterion.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_criterion_container';

    var criterionTitleH4 = document.createElement('h4');
    criterionTitleH4.className = 'dawn_critical_analysis_configuration_principles_principle_criteria_criterion__title';
    criterionTitleH4.innerHTML = criterion.replace(/\\/g, '');

    var deleteButton = document.createElement('i');
    deleteButton.className = 'fas fa-minus-square';
    deleteButton.id = criterion.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_criterion_delete';
    deleteButton.setAttribute('principle', selectedPrinciple);
    deleteButton.addEventListener('click', function() {
        criterion = this.getAttribute('id').split('_')[0];
        document.querySelector('#' + this.getAttribute('principle') + '_criteria_container').removeChild(document.querySelector('#' + criterion + '_criterion_container'));
    });

    criterionDiv.append(criterionTitleH4);
    criterionDiv.append(deleteButton);

    criteriaContainerDiv.append(criterionDiv);

    closeModals();
    // What we are creating here: 
    // <div class="dawn_critical_analysis_configuration_principles_principle_criteria__criterion">
    //     <h4 class="dawn_critical_analysis_configuration_principles_principle_criteria_criterion__title">Critère 1</h4>
    //     <i class="fas fa-minus-square"></i>
    // </div>
}


// To load basic data
loadBasicDataButton.addEventListener('click', function() {
    var existingPrinciples = document.getElementsByClassName('dawn_critical_analysis_configuration_principles_principle__container');
    if (existingPrinciples.length > 0) {
        document.querySelector('.dawn_critical_analysis_configuration__load_default_data_error').innerHTML = 'Veuillez supprimer tous les composants du modèle présent afin de charger le modèle par defaut';
        return;
    }
    setLoading();
    document.querySelector('.dawn_critical_analysis_configuration__load_default_data_error').innerHTML = '';
    var data = DATA.baseData.data;
    for (var i = 0; i < data.length; i++) {
        addPrinciple(data[i].principle, data[i]);
        selectedPrinciple = data[i].principle.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "");
        for (var j = 0; j < data[i].criteria.length; j++) {
            addCriterion(data[i].criteria[j]);
        }
    }
    doneLoading();
});

// For the save
saveButton.addEventListener('click', function() {
    setLoading();

    var data = [];

    var principles = document.getElementsByClassName('dawn_critical_analysis_configuration_principles__principle');
    for (var i = 0; i < principles.length; i++) {
        var principleData = {
            principle: '',
            image: '',
            principleDescription: '',
            content: {
                title: '',
                roles: []
            },
            criteria: []
        };

        // Principle title
        var principleTitle = principles[i].querySelector('.dawn_critical_analysis_configuration_principles_principle_container__title').innerHTML;
        principleData.principle = principleTitle;

        // Principle Description
        var principleDescription = principles[i].querySelector('.dawn_critical_analysis_configuration_principles_principle__textarea').value;
        principleData.principleDescription = principleDescription;

        // Principle Image 
        var imageSrc = principles[i].querySelector('.dawn_critical_analysis_configuration_principles_principle_image__image').getAttribute('src');
        principleData.image = imageSrc;

        // Content title 
        var contentTitle = principles[i].querySelector('.dawn_critical_analysis_configuration_principles_principle_role_title_container__textarea').value;
        principleData.content.title = contentTitle;

        // Roles 
        var roles = principles[i].getElementsByClassName('dawn_critical_analysis_configuration_principles_principle__single_role');
        for (var j = 0; j < roles.length; j++) {
            principleData.content.roles.push(roles[j].querySelector('.dawn_critical_analysis_configuration_principles_principle__single_role_textarea').value);
        }

        // Principle Criteria
        var principleCriteria = principles[i].querySelector('.dawn_critical_analysis_configuration_principles_principle__criteria');
        var criteria = principleCriteria.getElementsByClassName('dawn_critical_analysis_configuration_principles_principle_criteria__criterion');
        var criteriaTab = []
        for (var j = 0; j < criteria.length; j++) {
            criteriaTab.push(criteria[j].querySelector('.dawn_critical_analysis_configuration_principles_principle_criteria_criterion__title').innerHTML);
        }
        principleData.criteria = criteriaTab;

        data.push(principleData);
    }

    jQuery(document).ready(function() {
        jQuery.ajax({
            url: DATA.ajaxUrl,
            type: 'POST',
            data: {
                'action': 'dawn_save_analysis_model',
                'data': data
            },
            success: function(data) {
                doneLoading();
            },
            error: function(error) {
                console.log(error);
                doneLoading();
            }
        });
    })
});

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  
    for (var i = 0; i < 5; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));
  
    return text;
}

function readUrl(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var imageId = input.id.split('_')[0] + '_image';
        reader.onload = function (e) {
            document.querySelector('#' + imageId).setAttribute('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
