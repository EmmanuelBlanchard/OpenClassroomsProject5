window.onload = () => {
    // add JS class to HTML
    document.querySelector("html").classList.add('js');

    // initialization of variables
    let fileInput = document.querySelector(".input-file");
    let button = document.querySelector(".input-file-trigger");
    let the_return = document.querySelector(".file-return");

    // action when the "space bar" or "Enter" is pressed
    button.addEventListener("keydown", function (event) {
        if (event.keyCode == 13 || event.keyCode == 32) {
            fileInput.focus();
        }
    });

    // action when the label is clicked
    button.addEventListener("click", function (event) {
        fileInput.focus();
        return false;
    });

    // displays a visual feedback as soon as input:file changes
    fileInput.addEventListener("change", function (event) {
        the_return.innerHTML = this.value;
    });

}