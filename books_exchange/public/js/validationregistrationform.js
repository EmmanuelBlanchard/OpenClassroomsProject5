window.onload = () => {
    document.querySelector("#registration_form_plainPassword").addEventListener('input', checkPassword);
}

/**
 * This function checks the password
 */
function checkPassword(){
    // We recover what has been entered
    let password = this.value;

    // We get the elements we need
    let tiny = document.querySelector("#tiny");
    let uppercase = document.querySelector("#uppercase");
    let number = document.querySelector("#number");
    let special = document.querySelector("#special");
    let length = document.querySelector("#length");

    // We check that we have a tiny
    let valid = /[a-z]/.test(password);
    console.log(valid);
}

console.log("Entre dans le fichier js validationregistrationform.js !");
