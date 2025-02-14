/*=============== SWIPER HOMES ===============*/

// Fetch data from the API
fetch('http://localhost:8000/backend/api/public/index_courses', {
    method: 'GET', // Assuming it's a POST request
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        action: 'index_courses', // Action
        token: localStorage.getItem('authToken') // Token from localStorage
    })
})
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Parse the response as JSON
    })
    .then(data => {

        // Improved check and debugging
        if (data && data.status === 'success') {
            if (data.courses && Array.isArray(data.courses)) {
                // Process the data, for example, display the courses dynamically:
                const coursesContainer = document.getElementById('courses-container');
                data.courses.forEach(course => {
                    const courseElement = document.createElement('div');
                    courseElement.classList.add('course');
                    courseElement.innerHTML = `
                        <h3>${course.course_name}</h3>
                        <p>${course.course_description}</p>
                    `;
                    coursesContainer.appendChild(courseElement);
                });
            } else {
                console.error('Courses array is missing or not in expected format:', data.courses);
            }
        } else {
            console.error('API response is not successful or missing expected status:', data);
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
