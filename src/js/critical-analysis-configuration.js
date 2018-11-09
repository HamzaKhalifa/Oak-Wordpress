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
    var criteria = DATA.criteria;
    for (var i = 0; i < principles.length; i++) {
        addPrinciple(principles[i]);
        selectedPrinciple = principles[i].replace(/ /g,'').replace(/[^a-zA-Z ]/g, "");
        for (var j = 0; j < criteria[i].length; j++) {
            if (criteria[i][j] != 'Empty')
                addCriterion(criteria[i][j]);
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

function addPrinciple(principleName) {
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

    principleDiv.append(principleContainerDiv);
    principleDiv.append(principleCriteriaDiv);
    principleDiv.append(criteriaAddContainerDiv);

    var principlesContainer = document.querySelector('.dawn_critical_analysis_configuration__principles');
    principlesContainer.append(principleDiv);

    closeModals();

    // What we are creating here: 
    {/* 
    <div class="dawn_critical_analysis_configuration_principles__principle">
        <div class="dawn_critical_analysis_configuration_principles_principle__container"
            <h3 class="dawn_critical_analysis_configuration_principles_principle_container__title">Implication des parties prenantes</h3>
            <i class="fas fa-trash-alt"></i>
        </div>
        <div class="dawn_critical_analysis_configuration_principles_principle__criteria">
            <!-- This is where the criteria are gonna be added dynamically.  -->
        </div>
        <div class="dawn_critical_analysis_configuration_principles_principle__add_container">
            <div class="dawn_critical_analysis_configuration_principles_principle_add_container__add_button">
                <span class="dawn_critical_analysis_configuration_principles_principle_add_container_add_button__text" >
                    Ajouter un critère
                </span>
            </div>
        </div>
    </div> */}
}

function addCriterion(criterion) {
    var criteriaContainerDiv = document.querySelector('#' + selectedPrinciple + '_criteria_container');

    var criterionDiv = document.createElement('div');
    criterionDiv.className = 'dawn_critical_analysis_configuration_principles_principle_criteria__criterion';
    criterionDiv.id = criterion.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_criterion_container';

    var criterionTitleH4 = document.createElement('h4');
    criterionTitleH4.className = 'dawn_critical_analysis_configuration_principles_principle_criteria_criterion__title';
    criterionTitleH4.innerHTML = criterion;

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
    setLoading();
    var data = DATA.baseData.data;
    for (var i = 0; i < data.length; i++) {
        addPrinciple(data[i].principle);
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

    var principleTitles = []
    var principlesCriteriaTitles = [];

    var principles = document.getElementsByClassName('dawn_critical_analysis_configuration_principles__principle');
    for (var i = 0; i < principles.length; i++) {
        var principleTitle = principles[i].querySelector('.dawn_critical_analysis_configuration_principles_principle_container__title').innerHTML;
        principleTitles.push(principleTitle);
        
        var principleCriteria = principles[i].querySelector('.dawn_critical_analysis_configuration_principles_principle__criteria');
        var criteria = principleCriteria.getElementsByClassName('dawn_critical_analysis_configuration_principles_principle_criteria__criterion');
        var criteriaTab = []
        for (var j = 0; j < criteria.length; j++) {
            criteriaTab.push(criteria[j].querySelector('.dawn_critical_analysis_configuration_principles_principle_criteria_criterion__title').innerHTML);
        }
        if (criteriaTab.length == 0) 
            criteriaTab.push('Empty');
        principlesCriteriaTitles.push(criteriaTab);
    }

    jQuery(document).ready(function() {
        jQuery.ajax({
            url: DATA.ajaxUrl,
            data: {
                'action': 'dawn_save_analysis_model',
                'principles': principleTitles,
                'criteria': principlesCriteriaTitles
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
