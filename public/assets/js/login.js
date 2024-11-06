document.addEventListener("DOMContentLoaded", ()=>{

    const emailRegEx = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const $form = document.querySelector("form");
    const $emailError = document.querySelector(".email-error");
    const $passwordError = document.querySelector(".password-error");

    const getValidations = ({email, password}) => {
        let emailValid = false;
        let passwordValid = false;

        if(emailRegEx.test(email) && email != "")
            emailValid = true;
        if(password.length >= 5 && password != "")
            passwordValid = true;

        return {
            emailValid,
            passwordValid
        };
    };

    $form.addEventListener("submit", (e)=>{
        e.preventDefault();

        const { email, password} = e.target.elements;
        const values = {
            email: email.value,
            password: password.value
        }

        const validations = getValidations(values);
        if(!validations.emailValid)
            $emailError.classList.remove("d-none");
        else
            $emailError.classList.add("d-none");

        if(!validations.passwordValid)
            $passwordError.classList.remove("d-none");
        else
            $passwordError.classList.add("d-none");

        
        if(validations.emailValid && validations.passwordValid){
            $form.submit();
        }
    }) 
    
    $emailError.classList.add("d-none");
    $passwordError.classList.add("d-none");
})