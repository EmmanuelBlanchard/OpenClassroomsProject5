window.onload = () => {
    let modal = new bootstrap.Modal(document.getElementById('modal-delete'));

    let deletion = document.querySelectorAll(".modal-trigger")
    for (let button of deletion) {
        button.addEventListener("click", function () {
            document.querySelector(".modal-footer a").href = `/admin/user/delete/${this.dataset.id}`
            document.querySelector(".modal-body").innerText = `Êtes-vous sûr de vouloir supprimer l'utilisateur ayant pour nom: "${this.dataset.lastname}" prénom: "${this.dataset.firstname}" pseudo: "${this.dataset.pseudo}" e-mail: "${this.dataset.email}" localisé : "${this.dataset.zipcode}" "${this.dataset.city}" `
        });
    }
}