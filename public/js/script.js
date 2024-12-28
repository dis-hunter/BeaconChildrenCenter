document.addEventListener('livewire:load', () => {
    Livewire.hook('message.processed', () => {
        updateMeter(); // Recalculate when Livewire processes updates
    });
});
const passwordInput = document.getElementById('password-input');
const meterSections = document.querySelectorAll('.meter-section');
passwordInput.addEventListener('input', updateMeter);

document.addEventListener('passwordGenerated',(event)=>{
    const passwordInput = document.getElementById('password-input');
    passwordInput.value=event.detail.password;
    updateMeter();
});


function updateMeter() {
    const password = passwordInput.value;
    let strength = calculatePasswordStrength(password);

    // Remove all strength classes
    meterSections.forEach((section) => {
        section.classList.remove('weak', 'medium', 'strong', 'very-strong');
    });

    // Add the appropriate strength class based on the strength value
    if (strength >= 1) {
        meterSections[0].classList.add('weak');
    }
    if (strength >= 2) {
        meterSections[1].classList.add('medium');
    }
    if (strength >= 3) {
        meterSections[2].classList.add('strong');
    }
    if (strength >= 4) {
        meterSections[3].classList.add('very-strong');
    }
}

function calculatePasswordStrength(password) {
    const lengthWeight = 0.2;
    const uppercaseWeight = 0.5;
    const lowercaseWeight = 0.5;
    const numberWeight = 0.7;
    const symbolWeight = 1;

    let strength = 0;

    // Calculate the strength based on the password length
    strength += password.length * lengthWeight;

    // Calculate the strength based on uppercase letters
    if (/[A-Z]/.test(password)) {
        strength += uppercaseWeight;
    }

    // Calculate the strength based on lowercase letters
    if (/[a-z]/.test(password)) {
        strength += lowercaseWeight;
    }

    // Calculate the strength based on numbers
    if (/\d/.test(password)) {
        strength += numberWeight;
    }

    // Calculate the strength based on symbols
    if (/[^A-Za-z0-9]/.test(password)) {
        strength += symbolWeight;
    }

    return strength;
}

const togglePassword= document.querySelector('#togglePassword');
const password=document.querySelector('#password-input');
togglePassword.addEventListener('click',(e)=>{
    const type = password.getAttribute('type')==='password' ? 'text' : 'password';
    password.setAttribute('type',type);
    e.target.classList.toggle('bi-eye');
});

const togglePassword2= document.querySelector('#togglePassword2');
const c_password=document.querySelector('#confirmpassword');
togglePassword2.addEventListener('click',(e)=>{
    const type2 = c_password.getAttribute('type')==='password' ? 'text' : 'password';
    c_password.setAttribute('type',type2);
    e.target.classList.toggle('bi-eye');
});