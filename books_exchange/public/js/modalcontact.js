window.onload = () => {
    let buttonContactBook = document.querySelector('.modal-trigger').getAttribute("data-title");
    let bookContactFormTitle = document.querySelector('#book_contact_form_title').value = buttonContactBook;
    let modal = new bootstrap.Modal(document.getElementById('modal-contact'));
}