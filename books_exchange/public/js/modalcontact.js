window.onload = () => {
    document.querySelector('#book_contact_form_title').value = `"${this.dataset.title}"`

    document.querySelector('#book_contact_form_title').innerText = `"${this.dataset.title}"`

    let modal = new bootstrap.Modal(document.getElementById('modal-contact'));

    let deletion = document.querySelectorAll(".modal-trigger")
    for (let button of deletion) {
        button.addEventListener("click", function () {
            document.querySelector(".modal-footer a").href = ``
        });
    }
}