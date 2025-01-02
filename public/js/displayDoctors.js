document.addEventListener('DOMContentLoaded', function() {
    // Function to toggle the sidebar
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleButton = document.getElementById('toggle-button');
        
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
        toggleButton.classList.toggle('collapsed');
    }

    // Function to search doctors
    function searchDoctors(query) {
        query = query.toLowerCase();
        const rows = document.querySelectorAll('.doctor-row');
        let found = false;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(query)) {
                row.style.display = '';
                found = true;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('noResults').style.display = found ? 'none' : 'block';
    }

    // Add event listener to the toggle button
    document.getElementById('toggle-button').addEventListener('click', toggleSidebar);

    // Add event listener to the search input
    document.getElementById('filterSpecialization').addEventListener('input', function() {
        searchDoctors(this.value);
    });
});