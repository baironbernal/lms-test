

// Fetch data from the API
fetch('http://localhost:8000/backend/api/public/index_courses')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Parse the JSON response here
    })
    .then(data => {
        // Now, the `data` is already an object, so no need to parse it again
        if (data.status === 'success' && data.courses && Array.isArray(data.courses)) {
            console.log(data); // You can log the parsed data to see the result
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
            console.error('Courses data is not in the expected format:', data);
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });


/*=============== LOGOUT FUNCTIONALITY ===============*/

// Add event listener for the logout link
const logoutLink = document.getElementById('logout');
if (logoutLink) {
    logoutLink.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent the default anchor behavior

        const token = localStorage.getItem('token'); // Get the token from localStorage
        if (token) {
            // Send a fetch request to log out
            fetch('http://localhost:8000/backend/api/public/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ token: token }), // Send the token in the request body
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // If the API returns success, remove the token from localStorage
                    localStorage.removeItem('token');
                    // Redirect to index.html
                    window.location.href = 'index.html';
                } else {
                    console.log('Logout failed:', data.message);
                }
            })
            .catch(error => {
                console.error('There was an error with the logout operation:', error);
            });
        } else {
            console.log('No token found in localStorage');
        }
    });
}
