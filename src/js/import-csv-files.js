console.log('I\'m here!');

function readUrl(input) {
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
    if (regex.test(input.value.toLowerCase())) {

        if (typeof (FileReader) != 'undefined') {
            var reader = new FileReader();
            reader.onload = function (e) {
                // console.log(e.target.result);
                var table = document.createElement('table');
                var dvCSV = document.querySelector('.oak-csv-container');
                dvCSV.innerHTML = '';
                dvCSV.appendChild(table);
                var rows = e.target.result.split('\n');
                for (var i = 0; i < rows.length; i++) {
                    var row = table.insertRow(-1);
                    var cells = rows[i].split(',');
                    for (var j = 0; j < cells.length; j++) {
                        var cell = row.insertCell(-1);
                        cell.innerHTML = cells[j];
                        console.log(cells[j]);
                    }
                }
            }
            reader.readAsText(input.files[0]);
        } else {
            alert('This browser does not support HTML5.');
        }
    } else {
        alert('Please upload a valid CSV file.');
    }
}