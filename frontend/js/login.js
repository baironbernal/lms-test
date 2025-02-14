document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();  

    // Clear previous error messages
    document.getElementById('errorMessages').innerHTML = '';

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Validate fields
    if (!username || !password) {
        document.getElementById('errorMessages').innerText = 'Both fields are required!';
        return;
    }

    const data = {
        action: 'login',
        username: username,
        password: password
    };

    // Send request with fetch
    fetch('http://localhost:8000/backend/api/public/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error') {
            console.log("Error error ")
            document.getElementById('errorMessages').innerText = data.message;
        } else {
            // Extract token from response (it's inside user object)
            data = JSON.parse(data);
            const token = data.user.token;

            // Check if the token exists
            if (token) {
                localStorage.setItem('authToken', token);  // Store token in localStorage
                window.location.href = 'admin/dashboard.html';  // Redirect to dashboard
            } else {
                document.getElementById('errorMessages').innerText = 'Login successful, but no token found.';
            }
        }
    })
    .catch(error => {
        document.getElementById('errorMessages').innerText = 'An error occurred. Please try again later.';
        console.error('Error:', error);
    });
});
