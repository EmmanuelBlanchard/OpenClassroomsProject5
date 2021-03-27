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
    let tiny = docmuent.querySelector("#tiny");
    let uppercase = docmuent.querySelector("#uppercase");
    let number = docmuent.querySelector("#number");
    let special = docmuent.querySelector("#special");
    let length = docmuent.querySelector("#length");

    // We check that we have a tiny
    let valid = /[a-z]/.test(password);
    console.log(valid);
}

console.log("Entre dans le fichier js validationregistrationform.js !");
