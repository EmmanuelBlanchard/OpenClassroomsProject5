let validationRegistrationForm = document.getElementById('submitRegistrationFormButton');
let pseudo = document.getElementById('registration_form_pseudo');
let misssingPseudo = document.getElementById('missing_pseudo');
let lastname = document.getElementById('registration_form_lastname');
let misssingLastname = document.getElementById('missing_lastname');
let firstName = document.getElementById('registration_form_firstname');
let misssingFirstName = document.getElementById('missing_firstname');

validationRegistrationForm.addEventListener('click', validation);

function validation(event) {
    // If the field is empty
    if (pseudo.validity.valueMissing) {
        event.preventDefault();
        misssingPseudo.textContent = "Pseudo manquant";
        misssingPseudo.style.color ='red';
    }
}