function checkToken() {

    const token = localStorage.getItem('authToken');
    
    if (!token) {
        console.error('No token found in localStorage.');
        window.location.href = 'http://localhost:8000/frontend/views/login.html';  // Redirect to login page
        return;
    }
}

window.onload = function() {
    checkToken();
};
