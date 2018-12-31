var addNewAnalysisButton = document.querySelector('.oak_admin_analysis_list_tile_container__add_analysis_button');
var modalContainer = document.querySelector('.oak_admin_analysis__modals_container');
var modalError = document.querySelector('.oak_admin_analysis_modals_container_add_modal__error');
var modalCancelButton = document.querySelector('.oak_admin_analysis_modals_container_add_modal__cancel_button');
var modalAddButton = document.querySelector('.oak_admin_analysis_modals_container_add_modal__add_button');
var modalInputText = document.querySelector('.oak_admin_analysis_modals_container_add_modal__input');
var saveAllButton = document.querySelector('.oak_admin_analysis__save_container');


addNewAnalysisButton.addEventListener('click', function() {
    openModals();
});

modalCancelButton.addEventListener('click', function() {
    closeModals();
})

modalAddButton.addEventListener('click', function() {
    var title = modalInputText.value;
    if (title.trim() == '') {
        modalError.innerHTML = 'Veuillez entrer le titre d\'abord';
        return;
    }
    addCriticalAnalysis(title);
});

saveAllButton.addEventListener('click', function() {
    saveAll();
});

initialize();

function initialize() {
    var analyzes = DATA.analyzes;
    for (var i = 0; i < analyzes.length; i++) {
        addCriticalAnalysis(analyzes[i].title, analyzes[i]);
    }
}

function openModals() {
    modalContainer.classList.add('oak_admin_analysis__modals_container_activated');
}

function closeModals() {
    modalContainer.classList.remove('oak_admin_analysis__modals_container_activated');
    modalError.innerHTML = '';
    modalInputText.value = '';
}

function setLoading() {
    openModals();
    document.querySelector('.oak_loader').classList.remove('oak_hidden');
    document.querySelector('.oak_admin_analysis_modals_container__add_modal').classList.add('oak_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function() {
        document.querySelector('.oak_loader').classList.add('oak_hidden');
        document.querySelector('.oak_admin_analysis_modals_container__add_modal').classList.remove('oak_hidden');
    }, 1000);
}

function addCriticalAnalysis(title, analysis) {
    setLoading();
    var singleAnalysisDiv = document.createElement('div');
    singleAnalysisDiv.className = 'oak_admin_analysis_list__single_analysis';
    singleAnalysisDiv.id = title.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_single_analysis_div';
    
    var deleteButton = document.createElement('i');
    deleteButton.id = title.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_single_analysis_delete_button';
    deleteButton.className = 'fas fa-trash-alt oak_admin_analysis_list_single_analysis__delete_button';
    
    deleteButton.addEventListener('click', function() {
        var analysisTitle = this.getAttribute('id').split('_')[0];
        document.querySelector('.oak_admin_analysis__list').removeChild(document.querySelector('#' + analysisTitle + '_single_analysis_div'));
    });

    singleAnalysisDiv.append(deleteButton);

    var analysisTitleH2 = document.createElement('h2');
    analysisTitleH2.className = 'oak_admin_analysis_list_single_analysis__title';
    analysisTitleH2.innerHTML = title.replace(/\\/g, '');

    singleAnalysisDiv.append(analysisTitleH2);

    var principlesData = analysis ? analysis.principles : DATA.principles;
    for (var i = 0; i < principlesData.length; i++) {
        var singlePrincipleDiv = document.createElement('div');
        singlePrincipleDiv.className = 'oak_admin_analysis_list_single_analysis__single_principle';

        singleAnalysisDiv.append(singlePrincipleDiv);

        var principleTitleH3 = document.createElement('h3');
        principleTitleH3.className = 'oak_admin_analysis_list_single_analysis_single_principle__principle_title';
        var principleDefinition = analysis ? analysis.principles[i].principleDescription : DATA.principles[i].principleDescription;
        var principleContentTitle = analysis ? analysis.principles[i].content.title : DATA.principles[i].content.title;
        var principleImage = analysis ? analysis.principles[i].image : DATA.principles[i].image;
        principleTitleH3.setAttribute('principleDefinition', principleDefinition);
        principleTitleH3.setAttribute('principleContentTitle', principleContentTitle);
        principleTitleH3.setAttribute('principleImage', principleImage);
        principleTitleH3.innerHTML = analysis ? principlesData[i].principle.replace(/\\/g, '') : DATA.principles[i].principle.replace(/\\/g, '');

        var hiddenRolesContainer = document.createElement('div');
        hiddenRolesContainer.className = 'oak_hidden_information_container';
        singlePrincipleDiv.append(hiddenRolesContainer);

        var principleRoles = analysis ? analysis.principles[i].content.roles : DATA.principles[i].content.roles;
        if (principleRoles) {
            for (var j = 0; j < principleRoles.length; j++) {
                var roleDiv = document.createElement('div');
                roleDiv.setAttribute('role', principleRoles[j]);
                roleDiv.className = 'oak_principle_role_hidden_information';
                hiddenRolesContainer.append(roleDiv);
            }
        }
        

        singlePrincipleDiv.append(principleTitleH3);

        var criteriaData = analysis ? principlesData[i].criteria : DATA.principles[i].criteria;
        
        if (criteriaData) {
            for (var j = 0; j < criteriaData.length; j++) {
                var singleCriteriaDiv = document.createElement('div');
                singleCriteriaDiv.className = 'oak_admin_analysis_list_single_analysis_single_principle__single_criteria';
    
                singlePrincipleDiv.append(singleCriteriaDiv);
    
                var singleCriteriaUpperContent = document.createElement('div');
                singleCriteriaUpperContent.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria__upper_content';
    
                singleCriteriaDiv.append(singleCriteriaUpperContent);
    
                var singleCriteriaTitleH4 = document.createElement('h4');
                singleCriteriaTitleH4.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria__criteria_title';
                singleCriteriaTitleH4.innerHTML = analysis ? criteriaData[j].title.replace(/\\/g, '') : DATA.principles[i].criteria[j].replace(/\\/g, '');
    
                singleCriteriaUpperContent.append(singleCriteriaTitleH4);
    
                var singleCriteriaScoreContainer = document.createElement('div');
                singleCriteriaScoreContainer.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content__score_container';
    
                singleCriteriaUpperContent.append(singleCriteriaScoreContainer);
    
                var scoreContainerLabel1 = document.createElement('span');
                scoreContainerLabel1.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__label';
                scoreContainerLabel1.innerHTML = 'SCORE: ';
    
                var scoreContainerInput = document.createElement('input');
                scoreContainerInput.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__score';
                scoreContainerInput.setAttribute('type', 'number');
                scoreContainerInput.value = analysis ? criteriaData[j].score.replace(/\\/g, '') : '';
    
                var scoreContainerLabel2 = document.createElement('span');
                scoreContainerLabel2.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__label';
                scoreContainerLabel2.innerHTML = '%';
    
                singleCriteriaScoreContainer.append(scoreContainerLabel1);
                singleCriteriaScoreContainer.append(scoreContainerInput);
                singleCriteriaScoreContainer.append(scoreContainerLabel2);

                // To sustain and to improve
                var notesContainerDiv = document.createElement('div');
                notesContainerDiv.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria__notes_container';

                var singleNoteContainerDiv = document.createElement('div');
                singleNoteContainerDiv.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria_notes_container__single_note';

                var toSustainTitle = document.createElement('h4');
                toSustainTitle.innerHTML = 'A pérenniser';
                var toSustainTextArea = document.createElement('textarea');
                toSustainTextArea.setAttribute('cols', 30);
                toSustainTextArea.setAttribute('rows', 10);
                toSustainTextArea.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria_notes_container_single_note__to_sustain_textarea';
                toSustainTextArea.value = analysis ? criteriaData[j].toSustain.replace(/\\/g, '') : '';

                singleNoteContainerDiv.append(toSustainTitle);
                singleNoteContainerDiv.append(toSustainTextArea);

                notesContainerDiv.append(singleNoteContainerDiv);

                var secondSingleNoteContainerDiv = document.createElement('div');
                secondSingleNoteContainerDiv.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria_notes_container__single_note';

                var toImproveTitle = document.createElement('h4');
                toImproveTitle.innerHTML = 'A améliorer';
                var toImproveTextArea = document.createElement('textarea');
                toImproveTextArea.setAttribute('cols', 30);
                toImproveTextArea.setAttribute('rows', 10);
                toImproveTextArea.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria_notes_container_single_note__to_improve_textarea';
                toImproveTextArea.value = analysis ? criteriaData[j].toImprove.replace(/\\/g, '') : '';

                secondSingleNoteContainerDiv.append(toImproveTitle);
                secondSingleNoteContainerDiv.append(toImproveTextArea);

                notesContainerDiv.append(secondSingleNoteContainerDiv);

                singleCriteriaDiv.append(notesContainerDiv);

                // Done with to sustain and to improve
    
    
                var remarkLabel = document.createElement('span');
                remarkLabel.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria__remark_label';
                remarkLabel.innerHTML = 'Remarques: ';
    
                singleCriteriaDiv.append(remarkLabel);
    
                var remarkTextarea = document.createElement('textarea');
                remarkTextarea.setAttribute('cols', '30');
                remarkTextarea.setAttribute('rows', '10');
                remarkTextarea.className = 'oak_admin_analysis_list_single_analysis_single_principle_single_criteria__remark';
                remarkTextarea.value = analysis ? criteriaData[j].remark.replace(/\\/g, '') : '';
    
                singleCriteriaDiv.append(remarkTextarea);
            }
        }
    }

    var chartContainer = document.createElement('div');
    chartContainer.className = 'oak_admin_analysis__chart_container';

    singleAnalysisDiv.append(chartContainer);

    var chartCanvas = document.createElement('canvas');
    chartCanvas.className = 'oak_admin_analysis_chart_container__radar_chart';

    chartContainer.append(chartCanvas);

    var chartCreator = chartCanvas.getContext('2d');

    var labels = [];
    var scores = [];
    if (analysis) {
        for (var i = 0; i < analysis.principles.length; i++) {
            labels.push(analysis.principles[i].principle);
            var allScores = 0;
            if (analysis.principles[i].criteria) {
                for (var j = 0; j < analysis.principles[i].criteria.length; j++) {
                    var score = analysis.principles[i].criteria[j].score == '' ? 0 : parseFloat(analysis.principles[i].criteria[j].score);
                    allScores+=score;
                }
            }
            var scoreToPush = 0;
            if (analysis.principles[i].criteria) {
                scoreToPush = allScores / analysis.principles[i].criteria.length
            } 
            scores.push(scoreToPush);
        }
    } else {
        labels = [];
        for (var i = 0; i < DATA.principles.length; i++) {
            labels.push(DATA.principles[i].principle);
            scores.push(0);
        }
    }
    var myChart = new Chart(chartCreator, {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                label: title,
                data: scores,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255,99,132,1)',
                pointStyle: 'star',
                borderWidth: 4,
            }]
        },
        options: {
            scale: {
                ticks: {
                    min: 0, max: 100
                }
            },
        }
    });

    document.querySelector('.oak_admin_analysis__list').append(singleAnalysisDiv);
    doneLoading();



    // <div class="oak_admin_analysis_list__single_analysis">
    //         <i class="fas fa-trash-alt oak_admin_analysis_list_single_analysis__delete_button"></i>
    //         <h2 class="oak_admin_analysis_list_single_analysis__title">Analyse 1</h2>
    //         <div class="oak_admin_analysis_list_single_analysis__single_principle">
    //             <h3 class="oak_admin_analysis_list_single_analysis_single_principle__principle_title">Principe 1</h3>
        
    //             <div class="oak_admin_analysis_list_single_analysis_single_principle__single_criteria">
    //                 <div class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria__upper_content">
    //                     <h4 class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria__criteria_title">Critère 1</h4>
    //                     <div class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content__score_container">
    //                         <span class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__label">SCORE: </span>
    //                         <input type="number" class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__score" name="" id="">
    //                         <span class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__label">    %</span>
    //                     </div>
    //                 </div>

    //                 <div class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria__notes_container">
    //                     <div class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria_notes_container__single_note">
    //                         <h4>A pérenniser</h4>
    //                         <textarea name="" id="" cols="30" rows="10" class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria_notes_container_single_note__to_sustain_textarea"></textarea>
    //                     </div>
    //                     <div class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria_notes_container__single_note">
    //                         <h4>A améliorer</h4>
    //                         <textarea name="" id="" cols="30" rows="10" class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria_notes_container_single_note__to_improve_textarea"></textarea>
    //                     </div>
    //                 </div>
                    

    //                 <span class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria__remark_label">Remarques:</span>
    //                 <br>
    //                 <textarea cols="30" rows="10" name="remark" class="oak_admin_analysis_list_single_analysis_single_principle_single_criteria__remark"></textarea>
    //             </div>
    //         </div>
    //         <div class="oak_admin_analysis__chart_container">
    //             <canvas class="oak_admin_analysis_chart_container__radar_chart"></canvas>
    //         </div>
    //     </div>
}

function saveAll() {
    setLoading();
    var analyzes = [];
    var allAnalyzes = document.getElementsByClassName('oak_admin_analysis_list__single_analysis');
    for (var i = 0; i < allAnalyzes.length; i++) {
        var analysis = {
            title: '',
            principles: []
        };
        analysis.title = allAnalyzes[i].querySelector('.oak_admin_analysis_list_single_analysis__title').innerHTML;
        var principles = allAnalyzes[i].getElementsByClassName('oak_admin_analysis_list_single_analysis__single_principle');
        for (var j = 0; j < principles.length; j++) {
            var principle = {
                principle: '',
                image: '',
                principleDescription: '',
                content: {
                    title: '',
                    roles: []
                },
                criteria: []
            }
            principle.principle = principles[j].querySelector('.oak_admin_analysis_list_single_analysis_single_principle__principle_title').innerHTML;
            principle.principleDescription = principles[j].querySelector('.oak_admin_analysis_list_single_analysis_single_principle__principle_title').getAttribute('principleDefinition');
            principle.content.title = principles[j].querySelector('.oak_admin_analysis_list_single_analysis_single_principle__principle_title').getAttribute('principleContentTitle');
            principle.image = principles[j].querySelector('.oak_admin_analysis_list_single_analysis_single_principle__principle_title').getAttribute('principleImage');
            var rolesDivs = principles[j].querySelector('.oak_hidden_information_container').getElementsByClassName('oak_principle_role_hidden_information');
            for (var m = 0; m < rolesDivs.length; m++) {
                principle.content.roles.push(rolesDivs[m].getAttribute('role'));
            }

            var criteria = principles[j].getElementsByClassName('oak_admin_analysis_list_single_analysis_single_principle__single_criteria');
            for (var m = 0; m < criteria.length; m++) {
                var criterion = {
                    title: '',
                    score: '',
                    remark: '',
                    toSustain: '', 
                    toImprove: '',
                };
                criterion.title = criteria[m].querySelector('.oak_admin_analysis_list_single_analysis_single_principle_single_criteria__upper_content').querySelector('.oak_admin_analysis_list_single_analysis_single_principle_single_criteria__criteria_title').innerHTML;
                criterion.score = criteria[m].querySelector('.oak_admin_analysis_list_single_analysis_single_principle_single_criteria__upper_content').querySelector('.oak_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content__score_container').querySelector('.oak_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__score').value;
                criterion.remark = criteria[m].querySelector('.oak_admin_analysis_list_single_analysis_single_principle_single_criteria__remark').value;
                criterion.toSustain = criteria[m].querySelector('.oak_admin_analysis_list_single_analysis_single_principle_single_criteria_notes_container_single_note__to_sustain_textarea').value;
                criterion.toImprove = criteria[m].querySelector('.oak_admin_analysis_list_single_analysis_single_principle_single_criteria_notes_container_single_note__to_improve_textarea').value;
                principle.criteria.push(criterion);
            }
            analysis.principles.push(principle);
        }
        analyzes.push(analysis);
    }

    jQuery(document).ready(function() {
        jQuery.ajax({
            url: DATA.ajaxUrl,
            type: 'POST',
            data: {
                'action': 'oak_save_analyzes',
                'analyzes': analyzes,
            },
            success: function(data) {
                doneLoading();
            },
            error: function(error) {
                console.log(error);
                doneLoading();
            }
        });
    });
}
