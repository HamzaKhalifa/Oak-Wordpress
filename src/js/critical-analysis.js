var addNewAnalysisButton = document.querySelector('.dawn_admin_analysis_list_tile_container__add_analysis_button');
var modalContainer = document.querySelector('.dawn_admin_analysis__modals_container');
var modalError = document.querySelector('.dawn_admin_analysis_modals_container_add_modal__error');
var modalCancelButton = document.querySelector('.dawn_admin_analysis_modals_container_add_modal__cancel_button');
var modalAddButton = document.querySelector('.dawn_admin_analysis_modals_container_add_modal__add_button');
var modalInputText = document.querySelector('.dawn_admin_analysis_modals_container_add_modal__input');
var saveAllButton = document.querySelector('.dawn_admin_analysis__save_container');


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
    modalContainer.classList.add('dawn_admin_analysis__modals_container_activated');
}

function closeModals() {
    modalContainer.classList.remove('dawn_admin_analysis__modals_container_activated');
    modalError.innerHTML = '';
    modalInputText.value = '';
}

function setLoading() {
    openModals();
    document.querySelector('.dawn_loader').classList.remove('dawn_hidden');
    document.querySelector('.dawn_admin_analysis_modals_container__add_modal').classList.add('dawn_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function() {
        document.querySelector('.dawn_loader').classList.add('dawn_hidden');
        document.querySelector('.dawn_admin_analysis_modals_container__add_modal').classList.remove('dawn_hidden');
    }, 1000);
}

function addCriticalAnalysis(title, analysis) {
    setLoading();
    var singleAnalysisDiv = document.createElement('div');
    singleAnalysisDiv.className = 'dawn_admin_analysis_list__single_analysis';
    singleAnalysisDiv.id = title.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_single_analysis_div';
    
    var deleteButton = document.createElement('i');
    deleteButton.id = title.replace(/ /g,'').replace(/[^a-zA-Z ]/g, "") + '_single_analysis_delete_button';
    deleteButton.className = 'fas fa-trash-alt dawn_admin_analysis_list_single_analysis__delete_button';
    
    deleteButton.addEventListener('click', function() {
        var analysisTitle = this.getAttribute('id').split('_')[0];
        document.querySelector('.dawn_admin_analysis__list').removeChild(document.querySelector('#' + analysisTitle + '_single_analysis_div'));
    });

    singleAnalysisDiv.append(deleteButton);

    var analysisTitleH2 = document.createElement('h2');
    analysisTitleH2.className = 'dawn_admin_analysis_list_single_analysis__title';
    analysisTitleH2.innerHTML = title.replace(/\\/g, '');

    singleAnalysisDiv.append(analysisTitleH2);

    var principlesData = analysis ? analysis.principles : DATA.principles;
    for (var i = 0; i < principlesData.length; i++) {
        var singlePrincipleDiv = document.createElement('div');
        singlePrincipleDiv.className = 'dawn_admin_analysis_list_single_analysis__single_principle';

        singleAnalysisDiv.append(singlePrincipleDiv);

        var principleTitleH3 = document.createElement('h3');
        principleTitleH3.className = 'dawn_admin_analysis_list_single_analysis_single_principle__principle_title';

        principleTitleH3.innerHTML = analysis ? principlesData[i].title.replace(/\\/g, '') : DATA.principles[i].replace(/\\/g, '');

        singlePrincipleDiv.append(principleTitleH3);

        var criteriaData = analysis ? principlesData[i].criteria : DATA.criteria[i];
        
        for (var j = 0; j < criteriaData.length; j++) {
            var singleCriteriaDiv = document.createElement('div');
            singleCriteriaDiv.className = 'dawn_admin_analysis_list_single_analysis_single_principle__single_criteria';

            singlePrincipleDiv.append(singleCriteriaDiv);

            var singleCriteriaUpperContent = document.createElement('div');
            singleCriteriaUpperContent.className = 'dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__upper_content';

            singleCriteriaDiv.append(singleCriteriaUpperContent);

            var singleCriteriaTitleH4 = document.createElement('h4');
            singleCriteriaTitleH4.classList = 'dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__criteria_title';
            singleCriteriaTitleH4.innerHTML = analysis ? criteriaData[j].title.replace(/\\/g, '') : DATA.criteria[i][j].replace(/\\/g, '');

            singleCriteriaUpperContent.append(singleCriteriaTitleH4);

            var singleCriteriaScoreContainer = document.createElement('div');
            singleCriteriaScoreContainer.className = 'dawn_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content__score_container';

            singleCriteriaUpperContent.append(singleCriteriaScoreContainer);

            var scoreContainerLabel1 = document.createElement('span');
            scoreContainerLabel1.className = 'dawn_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__label';
            scoreContainerLabel1.innerHTML = 'SCORE: ';

            var scoreContainerInput = document.createElement('input');
            scoreContainerInput.className = 'dawn_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__score';
            scoreContainerInput.setAttribute('type', 'number');
            scoreContainerInput.value = analysis ? criteriaData[j].score.replace(/\\/g, '') : '';

            var scoreContainerLabel2 = document.createElement('span');
            scoreContainerLabel2.className = 'dawn_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__label';
            scoreContainerLabel2.innerHTML = '%';

            singleCriteriaScoreContainer.append(scoreContainerLabel1);
            singleCriteriaScoreContainer.append(scoreContainerInput);
            singleCriteriaScoreContainer.append(scoreContainerLabel2);


            var remarkLabel = document.createElement('span');
            remarkLabel.className = 'dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__remark_label';
            remarkLabel.innerHTML = 'Remarques: ';

            singleCriteriaDiv.append(remarkLabel);

            var remarkTextarea = document.createElement('textarea');
            remarkTextarea.setAttribute('cols', '30');
            remarkTextarea.setAttribute('rows', '10');
            remarkTextarea.className = 'dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__remark';
            remarkTextarea.value = analysis ? criteriaData[j].remark.replace(/\\/g, '') : '';

            singleCriteriaDiv.append(remarkTextarea);
        }
    }

    var chartContainer = document.createElement('div');
    chartContainer.className = 'dawn_admin_analysis__chart_container';

    singleAnalysisDiv.append(chartContainer);

    var chartCanvas = document.createElement('canvas');
    chartCanvas.className = 'dawn_admin_analysis_chart_container__radar_chart';

    chartContainer.append(chartCanvas);

    var chartCreator = chartCanvas.getContext('2d');

    var labels = [];
    var scores = [];
    if (analysis) {
        for (var i = 0; i < analysis.principles.length; i++) {
            labels.push(analysis.principles[i].title);
            var allScores = 0;
            for (var j = 0; j < analysis.principles[i].criteria.length; j++) {
                var score = analysis.principles[i].criteria[j].score == '' ? 0 : parseFloat(analysis.principles[i].criteria[j].score);
                allScores+=score;
            }
            scores.push(allScores / analysis.principles[i].criteria.length);
        }
    } else {
        labels = DATA.principles;
        for (var i = 0; i < DATA.principles.length; i++) {
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
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    document.querySelector('.dawn_admin_analysis__list').append(singleAnalysisDiv);
    doneLoading();



    // <div class="dawn_admin_analysis_list__single_analysis">
    //     <i class="fas fa-trash-alt dawn_admin_analysis_list_single_analysis__delete_button"></i>
    //     <h2 class="dawn_admin_analysis_list_single_analysis__title">Analyse 1</h2>
    //     <div class="dawn_admin_analysis_list_single_analysis__single_principle">
    //         <h3 class="dawn_admin_analysis_list_single_analysis_single_principle__principle_title">Principe 1</h3>
    
    //         <div class="dawn_admin_analysis_list_single_analysis_single_principle__single_criteria">
    //             <div class="dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__upper_content">
    //                 <h4 class="dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__criteria_title">Critère 1</h4>
    //                 <div class="dawn_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content__score_container">
    //                     <span class="dawn_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__label">SCORE: </span>
    //                     <input type="number" class="dawn_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__score" name="" id="">
    //                     <span class="dawn_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__label">    %</span>
    //                 </div>
    //             </div>
    //             <span class="dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__remark_label">Remarques:</span>
    //             <br>
    //             <textarea cols="30" rows="10" name="remark" class="dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__remark"></textarea>
    //         </div>
    //     </div>
    //     <div class="dawn_admin_analysis__chart_container">
    //         <canvas class="dawn_admin_analysis_chart_container__radar_chart"></canvas>
    //     </div>
    // </div>
}

function saveAll() {
    setLoading();
    var analyzes = [];
    var allAnalyzes = document.getElementsByClassName('dawn_admin_analysis_list__single_analysis');
    for (var i = 0; i < allAnalyzes.length; i++) {
        var analysis = {
            title: '',
            principles: []
        };
        analysis.title = allAnalyzes[i].querySelector('.dawn_admin_analysis_list_single_analysis__title').innerHTML;
        var principles = allAnalyzes[i].getElementsByClassName('dawn_admin_analysis_list_single_analysis__single_principle');
        for (var j = 0; j < principles.length; j++) {
            var principle = {
                title: '',
                criteria: []
            }
            principle.title = principles[j].querySelector('.dawn_admin_analysis_list_single_analysis_single_principle__principle_title').innerHTML;
            var criteria = principles[j].getElementsByClassName('dawn_admin_analysis_list_single_analysis_single_principle__single_criteria');
            for (var m = 0; m < criteria.length; m++) {
                var criterion = {
                    title: '',
                    score: '',
                    remark: ''
                };
                criterion.title = criteria[m].querySelector('.dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__upper_content').querySelector('.dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__criteria_title').innerHTML;
                criterion.score = criteria[m].querySelector('.dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__upper_content').querySelector('.dawn_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content__score_container').querySelector('.dawn_admin_analysis_list_single_analysis_single_principle_single_criteria_upper_content_score_container__score').value;
                criterion.remark = criteria[m].querySelector('.dawn_admin_analysis_list_single_analysis_single_principle_single_criteria__remark').value;
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
                'action': 'dawn_save_analyzes',
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


// var radarChart = document.querySelector('.dawn_admin_analysis_chart_container__radar_chart').getContext('2d');
// var myChart = new Chart(radarChart, {
//     type: 'radar',
//     data: {
//         labels: DATA.principles,
//         datasets: [{
//             label: 'ff',
//             data: [100, 50, 75, 50, 90, 10, 80, 66, 30, 45],
//             backgroundColor: 'rgba(255, 99, 132, 0.2)',
//             borderColor: 'rgba(255,99,132,1)',
//             pointStyle: 'star',
//             borderWidth: 4,
//         }]
//     },
//     options: {
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero:true
//                 }
//             }]
//         }
//     }
// });