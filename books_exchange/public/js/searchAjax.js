class SearchAjax {
    constructor() {
        this.divResultSearch = document.getElementById('resultSearch');
        const searchForm = document.getElementById('searchForm');
        searchForm.addEventListener('input', event => {
            const data = event.target.value;
            console.log(data);

            // Test: retrieves the list of books according to what is typed in the search bar
            const url = 'https://127.0.0.1:8000/search?search=' + data + '?ajax';
            console.log(url);

            fetch(url).then(function (response) {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP ! statut : ${response.status}`);
                } else {
                    console.log('Response');
                    return response.json();
                }
            }).then(function (json) {
                let listOfBooks = json;


            }).then(data => {
                console.log('data divResultSearch : ' + data);
            }).catch(function (err) {
                console.log('Problème de récupération : ' + err.message);
            });

        });

        // Put the ajax parameter ? 
        // to get the list of books according to the data entered 
        // Then in JS, create the elements for displaying the results in the resultSearch div
        // Create the <table> element with the document.createElement() method then think to add the click event management on a search result 
        // Then display next to it the result in detail with the show route and the id of the clicked book

        function showBooks(book) {

            // Creating of the data display table in JS
            let table = document.createElement('table');
            let thead = document.createElement('thead');
            let tbody = document.createElement('tbody');

            table.appendChild(thead);
            table.appendChild(tbody);
            // Adding the entire table to the <div> tag with id resultSearch
            this.divResultSearch.appendChild(table);

            // Creating and adding data to first row of the table
            let row1 = document.createElement('tr');
            let heading1 = document.createElement('th');
            heading1.innerHTML = "";
            let heading2 = document.createElement('th');
            heading2.innerHTML = "";
            let heading3 = document.createElement('th');
            heading3.innerHTML = "";

            row1.appendChild(heading1);
            row1.appendChild(heading2);
            row1.appendChild(heading3);
            thead.appendChild(row1);

            // Creating and adding data to second row of the table
            let row2 = document.createElement('tr');
            let row2data1 = document.createElement('td');
            row2data1.innerHTML = "";
            let row2data2 = document.createElement('td');
            row2data2.innerHTML = "";
            let row2data3 = document.createElement('td');
            row2data3.innerHTML = "";

            row2.appendChild(row2data1);
            row2.appendChild(row2data2);
            row2.appendChild(row2data3);
            tbody.appendChild(row2);

            // Creating and adding data to third row of the table
            let row3 = document.createElement('tr');
            let row3data1 = document.createElement('td');
            row3data1.innerHTML = "";
            let row3data2 = document.createElement('td');
            row3data2.innerHTML = "";
            let row3data3 = document.createElement('td');
            row3data3.innerHTML = "";

            row3.appendChild(row3data1);
            row3.appendChild(row3data2);
            row3.appendChild(row3data3);
            tbody.appendChild(row3);

            console.log(table);
        }
    }
}
const search = new SearchAjax();