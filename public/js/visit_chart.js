document.addEventListener('DOMContentLoaded', function () {
    fetch('/visits-last-7-days')
        .then(response => response.json())
        .then(data => {
            // Prepare the labels (dates) and counts (visit counts)
            const labels = data.map(item => item.visit_date);
            const counts = data.map(item => item.visit_count);

            // Create the visit chart
            const ctx = document.getElementById('visitChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels, // Dates
                    datasets: [{
                        label: 'Number of Visits',
                        data: counts, // Visit counts
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Visits'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching visits data:', error));
});