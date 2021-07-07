class SearchAjax {
    constructor() {
        this.divResultSearch = document.getElementById('resultSearch');
        const searchFormInput = document.getElementById('searchFormInput');
        this.ajaxurl = searchFormInput.dataset.ajaxurl;
        searchFormInput.addEventListener('input', event => {
            const data = event.currentTarget.value;
            console.log(data);
        });
    }
}
const search = new SearchAjax();