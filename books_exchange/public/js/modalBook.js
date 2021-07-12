window.onload = () => {
    let modal = new bootstrap.Modal(document.getElementById('modal-delete'));

    let deletion = document.querySelectorAll(".modal-trigger")
    for (let button of deletion) {
        button.addEventListener("click", function () {
            document.querySelector(".modal-footer a").href = `/admin/book/delete/${this.dataset.id}`
            document.querySelector(".modal-body").innerText = `Êtes-vous sûr de vouloir supprimer le livre "${this.dataset.title}" de l'auteur "${this.dataset.author}" avec l'éditeur "${this.dataset.publisher}" en format "${this.dataset.format}" et l'État "${this.dataset.state}"`
        });
    }
}