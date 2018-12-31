if (DATA.analysis.principles) {
    var doughnutChart = document.querySelector('.oak_final_result_doughnut_chart');
    var doughnutChartCreator = doughnutChart.getContext('2d');
    
    var polarAreaChart = document.querySelector('.oak_final_result_polar_area_chart');
    var polarAreaChartCreator = polarAreaChart.getContext('2d');
    
    var radarChart = document.querySelector('.oak_final_result_radar_chart');
    var radarChartCreator = radarChart.getContext('2d');
    
    var barChart = document.querySelector('.oak_final_result_bar_chart');
    var barChartCreator = barChart.getContext('2d');
    
    var colors = ['#389EF0', '#FC394D', '#e67e22', '#f1c40f', '#d35400', '#e74c3c', '#8e44ad', '#34495e',
    '#95a5a6', '#16a085', '#3498db', '#c0392b', '#16a085', '#706fd3', '#40407a', '#ff5252', '#b33939', '#84817a', '#ffb142', '#218c74'];
    
    var principles = DATA.analysis.principles;
    var averages = [];
    var principlesLabels = [];
    var entireResultPercentage; 
    for(var i = 0; i < principles.length; i++) {
        principlesLabels.push(principles[i].principle);
        var sum = 0;
        for (var j = 0; j < principles[i].criteria.length; j++) {
            sum += parseFloat(principles[i].criteria[j].score);
        }
        averages.push(sum / principles[i].criteria.length);
    }
    
    var averagesSum = 0;
    for (var i = 0; i < averages.length; i++) {
        averagesSum+=averages[i];
    }
    entireResultPercentage = averagesSum / averages.length;
    
    
    new Chart(doughnutChartCreator, {
        data: {
            datasets: [{
                data: [entireResultPercentage, 100 - entireResultPercentage],
                backgroundColor: ['#389EF0', '#FC394D']
            }],
            labels: ['A Pérenniser', 'A améliorer']
        },
        type: 'doughnut',
        options: {
        }
    });
    
    new Chart(polarAreaChartCreator, {
        data: {
            datasets: [{
                data: averages,
                backgroundColor: colors,
            }],
            labels: principlesLabels
        },
        type: 'polarArea',
        options: {
        }
    });
    
    new Chart(radarChartCreator, {
        type: 'radar',
        data: {
            labels: principlesLabels,
            datasets: [{
                label: DATA.analysis.title,
                data: averages,
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
    
    new Chart(barChartCreator, {
        type: 'horizontalBar',
        data: {
            labels: principlesLabels,
            datasets: [{
                data: averages,
                backgroundColor: colors
            }]
        },
        options:{
            scales: {
                yAxes : [{
                    ticks: {
                        min: 0,
                        max: 100,
                        stepSize: 20
                    }
                }]
            }
        }
    });
    
    for (var i = 0; i < principles.length; i++) {
        var singlePrincipleChart = document.querySelector('.oak_principle' + i + '_doughnut_chart');
        var singlePrincipleChartCreator = singlePrincipleChart.getContext('2d');
        new Chart(singlePrincipleChartCreator, {
            label: principles[i].principle,
            data: {
                label: principles[i].principle,
                datasets: [{
                    data: [averages[i], 100 - averages[i]],
                    backgroundColor: ['#389EF0', '#FC394D']
                }],
                labels: ['A Pérenniser', 'A améliorer']
            },
            type: 'doughnut',
            options: {
            }
        });
    }
}



