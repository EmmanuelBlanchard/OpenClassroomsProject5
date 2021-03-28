window.onload = () => {
    document.querySelector("#registration_form_plainPassword").addEventListener('input', checkPassword);
}

let form = document.querySelector('#registration_form');
let email = document.querySelector("#registration_form_email");

// Listen to the email modification
email.addEventListener('change', function() {
    validEmail(this);
});

const validEmail = function(inputEmail) {
    let emailRegExp = new RegExp(
        '^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$', 'g'
        );

    let testEmail = emailRegExp.test(inputEmail.value);
    let small = inputEmail.nextElementSibling;
    //let small = document.querySelector("#registration_form_email_small");
    if(testEmail) {
        small.innerHTML = 'L\'adresse e-mail est valide';
    } else {
        small.innerHTML = 'L\'adresse e-mail est non valide';
    }
};

/**
 * This function checks the password
 */
function checkPassword(){
    // We initialize the score 
    let score = 0;
    // We recover what has been entered
    let password = this.value;

    // We get the elements we need
    let tiny = document.querySelector("#tiny");
    let uppercase = document.querySelector("#uppercase");
    let number = document.querySelector("#number");
    let special = document.querySelector("#special");
    let length = document.querySelector("#length");

    // We check that we have a tiny
    if(/[a-z]/.test(password)){
        tiny.classList.replace("invalid", "valid");
        score++;
    } else {
        tiny.classList.replace("valid", "invalid");
    }
    // We check that we have a uppercase
    if(/[A-Z]/.test(password)){
        uppercase.classList.replace("invalid", "valid");
        score++;
    } else {
        uppercase.classList.replace("valid", "invalid");
    }
    // We check that we have a number
    if(/[0-9]/.test(password)){
        number.classList.replace("invalid", "valid");
        score++;
    } else {
        number.classList.replace("valid", "invalid");
    }
    // We check that we have a special character
    /* ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸ àáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰  */
    if(/[-_$@!/\\%*#&£~ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰]/.test(password)){
        special.classList.replace("invalid", "valid");
        score++;
    } else {
        special.classList.replace("valid", "invalid");
    }
    // We check that we have the length of the password
    if(password.length >= 12){
        length.classList.replace("invalid", "valid");
        score++;
    } else {
        length.classList.replace("valid", "invalid");
    }

    if (score === 5){
        document.getElementById('submitRegistrationFormButton').style.display = "initial";
    } else {
        document.getElementById('submitRegistrationFormButton').style.display = "none";
    }
    
}