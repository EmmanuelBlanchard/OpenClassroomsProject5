class SearchAjax {
    constructor() {
        this.divResultSearch = document.getElementById('resultSearch');
        const searchForm = document.getElementById('searchForm');
        searchForm.addEventListener('input', event => {
            const data = event.currentTarget.value;
            console.log(data);
        });
    }
}
const search = new SearchAjax();