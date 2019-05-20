console.log('Im here!');

handleGraphsInitialization();
function handleGraphsInitialization() {
    var allGraphContainers = document.querySelectorAll('.oak_front_graph_container');
    console.log(allGraphContainers);
    for (var i = 0; i < allGraphContainers.length; i++) {
        var chartCreator = allGraphContainers[i].getContext('2d');
        var data = JSON.parse(allGraphContainers[i].getAttribute('data'));

        var chart = new Chart(chartCreator, data);
    }
    
}