//var myModal = new bootstrap.Modal(document.getElementById('modal-delete'), options)

window.onload = () => {
    let modal = new bootstrap.Modal(document.getElementById('modal-delete'), options);

    let deletion = document.querySelectorAll(".modal-trigger")
    for (let button of deletion) {
        button.addEventListener("click", function () {
            document.querySelector(".modal-footer a").href = `/admin/author/delete/${this.dataset.id}`
            document.querySelector(".modal-content").innerText = `Êtes-vous sûr de vouloir supprimer l'auteur "${this.dataset.title.id}"`
        });
    }


}