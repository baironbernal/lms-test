function logout() {
    const token = localStorage.getItem('authToken');
    
    if (!token) {
        console.error('No token found in localStorage.');
        return;
    }

    const payload = {
        action: 'logout',
        token: token
    };

    fetch('http://localhost:8000/backend/api/public/logout', {
        method: 'POST',  
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload) 
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Logout failed');
        }
        return response.json();
    })
    .then(data => {
        console.log('Logged out successfully:', data);
        
        localStorage.removeItem('authToken');

        window.location.href = 'http://localhost:8000/frontend/views/login.html'; 

    })
    .catch(error => {
        console.error('Error during logout:', error);
    });
}
