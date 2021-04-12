window.onload = () => {
    let activate = document.querySelectorAll("[type=checkbox]");
    for (let button of activate) {
        button.addEventListener("click", function () {
            let xmlhttp = new XMLHttpRequest;

            xmlhttp.open("get", `/admin/book/activate/${this.dataset.id}`);
            xmlhttp.send();
        });
    }
}