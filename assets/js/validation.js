document.addEventListener('DOMContentLoaded', function () {
    // Login form validation
    var loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            var email = loginForm.email.value.trim();
            var password = loginForm.password.value;
            if (!email || !password) {
                alert('Please enter both email and password.');
                e.preventDefault();
            }
        });
    }

    // Registration form validation
    var registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            var first = registerForm.first_name.value.trim();
            var last = registerForm.last_name.value.trim();
            var email = registerForm.email.value.trim();
            var password = registerForm.password.value;
            var confirm = registerForm.confirm_password.value;
            var terms = registerForm.terms.checked;
            if (!first || !last || !email || !password || !confirm) {
                alert('Please fill in all fields.');
                e.preventDefault();
            } else if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) {
                alert('Please enter a valid email address.');
                e.preventDefault();
            } else if (password !== confirm) {
                alert('Passwords do not match.');
                e.preventDefault();
            } else if (!terms) {
                alert('You must agree to the terms.');
                e.preventDefault();
            }
        });
    }
}); 