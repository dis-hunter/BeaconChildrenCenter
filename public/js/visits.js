// public/js/visits.js

document.addEventListener('DOMContentLoaded', () => {
    fetchVisits();
});

async function fetchVisits() {
    try {
        const response = await fetch('/visits'); // Call the Laravel endpoint
        const data = await response.json();

        if (data.status === 'success') {
            populateTable(data.data);
        } else {
            console.error('Failed to fetch visits:', data.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function populateTable(visits) {
    const tableBody = document.querySelector('#visitsTable tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    visits.forEach(visit => {
        const row = `
            <tr>
                <td>${visit.id}</td>
                <td>${visit.visit_date}</td>
                <td>${visit.source_type}</td>
                <td>${visit.child_id}</td>
                <td>${visit.staff_id}</td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
}
