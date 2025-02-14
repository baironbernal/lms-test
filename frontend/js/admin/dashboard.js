
function fetchCourseData() {
    const token = localStorage.getItem('authToken');
    
    if (!token) {
        console.error('No token found in localStorage.');
        return;
    }

    const data = {
        action: 'index_courses',
        token: token
    };

    const url = 'http://localhost:8000/backend/api/public/courses';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data) 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch course data');
            }
            return response.json();  // Parse the response as JSON
        })
        .then(data => {
            console.log('Course data:', data);
            document.getElementById('courseData').textContent = JSON.stringify(data, null, 2);
        })
        .catch(error => {
            console.error('Error fetching course data:', error);

            document.getElementById('courseData').textContent = 'Error fetching course data. Please try again later.';
        });
}
window.onload = function() {
    fetchCourseData();
};
