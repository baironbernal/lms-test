
document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault();  // Prevent form from submitting normally

    // Clear previous error messages
    document.getElementById('errorMessages').innerHTML = '';

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const email = document.getElementById('email').value;

    // Validate fields
    if (!username || !password || !email) {
        document.getElementById('errorMessages').innerText = 'All fields are required!';
        return;
    }

    // Create the payload
    const data = {
        action: 'register',
        username: username,
        password: password,
        email: email
    };

    // Send request with fetch
    fetch('http://localhost:8000/backend/api/public/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                document.getElementById('errorMessages').innerText = data.message;
            } else {
                // Handle success (e.g., redirect to login page)
                alert('Registration successful! Redirecting to login page...');
                window.location.href = 'http://localhost:8000/frontend/views/login.html';  // Adjust the URL of your login page
            }
        })
        .catch(error => {
            document.getElementById('errorMessages').innerText = 'An error occurred. Please try again later.';
            console.error('Error:', error);
        });
});
