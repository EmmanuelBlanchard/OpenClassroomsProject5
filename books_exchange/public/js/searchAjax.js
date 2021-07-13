class SearchAjax {
    constructor() {
        this.divResultSearchAjax = document.getElementById('resultSearchAjax');
        const searchFormInput = document.getElementById('searchFormInput');
        this.ajaxurl = searchFormInput.dataset.ajaxurl;
        searchFormInput.addEventListener('input', event => {
            const data = event.currentTarget.value;
            if (data.length > 3) {
                this.getDatas(data);
                this.divResultSearchAjax.style.display = 'block';
            }
        });
    }

    getDatas(searchParams) {
        const queryString = new URLSearchParams({
            search: searchParams,
            ajax: 1
        });

        const url = `${this.ajaxurl}?${queryString.toString()}`;
        console.log(url);

        fetch(url).then((response) => {
            const result = response.text();
            result.then((item) => {
                console.log(item)
                this.divResultSearchAjax.innerHTML = item;
            });
        }).catch((error) => {
            console.log(error)
        })
    }
}
const search = new SearchAjax();