function logout() {
    // Retrieve the token from localStorage
    const token = localStorage.getItem('authToken');
    
    if (!token) {
        console.error('No token found in localStorage.');
        return;
    }

    // Prepare the payload with the action and token
    const payload = {
        action: 'logout',
        token: token
    };

    // Perform the fetch request
    fetch('http://localhost:8000/backend/api/public/logout', {
        method: 'POST',  // Assuming POST is the method used for logout
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)  // Send the payload as JSON
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Logout failed');
        }
        return response.json();
    })
    .then(data => {
        console.log('Logged out successfully:', data);
        
        // Remove the token from localStorage
        localStorage.removeItem('authToken');

        // Redirect to login page
        window.location.href = 'http://localhost:8000/frontend/views/login.html';  // Redirect to login page

    })
    .catch(error => {
        console.error('Error during logout:', error);
    });
}
