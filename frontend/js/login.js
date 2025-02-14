
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();  // Prevent form from submitting normally

            // Clear previous error messages
            document.getElementById('errorMessages').innerHTML = '';

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Validate fields
            if (!username || !password) {
                document.getElementById('errorMessages').innerText = 'Both fields are required!';
                return;
            }

            // Create the payload
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
                    document.getElementById('errorMessages').innerText = data.message;
                } else {
                    // Store token in localStorage (or sessionStorage)
                    localStorage.setItem('authToken', data.token);  // You can use sessionStorage instead if you prefer

                    // Redirect to dashboard.html
                    window.location.href = 'admin/dashboard.html';  // Redirect to your dashboard page
                }
            })
            .catch(error => {
                document.getElementById('errorMessages').innerText = 'An error occurred. Please try again later.';
                console.error('Error:', error);
            });
        });