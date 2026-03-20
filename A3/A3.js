//Error checking for form and prevents the CGI call if required fields missing
const form = document.getElementById('form');

form.addEventListener('submit', validateForm);

function validateForm(event){
     if (form.checkValidity()){
          form.classList.remove('was-validated');
     } else {
          event.preventDefault();
          form.classList.add('was-validated');
          alert('Please fill in all the required fields');
     }
}