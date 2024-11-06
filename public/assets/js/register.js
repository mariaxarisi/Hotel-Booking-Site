document.addEventListener("DOMContentLoaded", ()=>{

    const emailRegEx = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const $form = document.querySelector("form");
    const $emailError = document.querySelector(".email-error");
    const $passwordError = document.querySelector(".password-error");
    const $passRepeatError = document.querySelector(".passRepeat-error");

    const getValidations = ({email, password, password_repeat}) => {
        let emailValid = false;
        let passwordValid = false;
        let passRepeatValid = false;

        if(emailRegEx.test(email) && email != "")
            emailValid = true;
        if(password.length >= 5 && password != "")
            passwordValid = true;
        if(password_repeat == password)
            passRepeatValid = true;

        return {
            emailValid,
            passwordValid, 
            passRepeatValid
        };
    };

    $form.addEventListener("submit", (e)=>{
        e.preventDefault();

        const { email, password, password_repeat} = e.target.elements;
        const values = {
            email: email.value,
            password: password.value,
            password_repeat: password_repeat.value
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

        if(!validations.passRepeatValid)
            $passRepeatError.classList.remove("d-none");
        else
            $passRepeatError.classList.add("d-none");
        
        if(validations.emailValid && validations.passwordValid && validations.passRepeatValid){
            $form.submit();
        }
    }) 
    
    $emailError.classList.add("d-none");
    $passwordError.classList.add("d-none");
    $passRepeatError.classList.add("d-none");
})