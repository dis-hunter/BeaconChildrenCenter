
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.page','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <style>
        td, th, button, option, select, input,label {
            color: black;
        }
        .loading-spinner {
    display: none; /* Hidden by default */
    width: 40px;
    height: 40px;
    border: 4px solid rgba(0, 0, 255, 0.3); /* Light blue border */
    border-top: 4px solid blue; /* Darker blue top border */
    border-radius: 50%;
    animation: spin 1s linear infinite; /* Apply rotation animation */
    margin: 10px auto; /* Center horizontally */
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

    </style>
<section class="bg-white p-6 rounded-lg shadow-md">
    <h1 style="color:black;" class="text-xl font-bold mb-2 text-black">Custom Report</h1>
    <p class="text-gray-600 mb-4 text-black">Select parameters to generate a custom report.</p>

    <div x-data="{ open: true, isLoading: false, showReport: false, reportContent: [], reportType: '' }">
        <!-- Toggle Button -->
        <button 
            @click="open = !open" 
            class="flex items-center justify-between w-full bg-gray-100 px-4 py-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none"
        >
            <span class="text-black">Report Parameters</span>
            <svg 
                :class="open ? 'rotate-180' : ''" 
                xmlns="http://www.w3.org/2000/svg" 
                class="h-5 w-5 transform transition-transform duration-300" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Parameters Form -->
        <div x-show="open" x-transition class="mt-4">
            <form id="reportForm" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="start_date" class="block text-sm font-medium text-black">Start Date</label>
                    <input 
                        type="date" 
                        id="start_date" 
                        name="start_date" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black"
                        required
                    >
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-black">End Date</label>
                    <input 
                        type="date" 
                        id="end_date" 
                        name="end_date" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black"
                        required
                    >
                </div>

                <div>
                    <label for="report_type" class="block text-sm font-medium text-black">Report Type</label>
                    <select 
                        id="report_type" 
                        name="report_type" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black"
                        required 
                    >
                        <option value="">Select Report</option>
                        <option value="encounter_summary">Encounter Summary</option>
                        <option value="staff_performance">Staff Performance</option>
                        <option value="expense_breakdown">Expense Breakdown</option>
                    </select>
                </div>

                <div>
                    <button 
                    style="color:black;"
                        id="submitButton"
                        type="submit" 
                        class="flex items-center justify-center w-full bg-blue-600 text-white py-2 px-4 rounded-lg shadow hover:bg-blue-700"
                        :disabled="isLoading"
                    >
                        <template x-if="isLoading">
                            <svg 
                                class="animate-spin h-5 w-5 mr-2 text-white" 
                                xmlns="http://www.w3.org/2000/svg" 
                                fill="none" 
                                viewBox="0 0 24 24"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <span x-text="isLoading ? 'Generating...' : 'Generate Report'"></span>
                    </button>
                </div>
            </form>
        </div>

      <!-- Loading Indicator -->
<div id="loadingIndicator" class="loading-spinner"></div>



        <!-- Report Modal -->
        <div id="reportModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded-lg shadow-md w-2/3">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-black">Generated Report</h2>
                    <button onclick="closeModal()" class="text-red-500 hover:text-red-700">Close</button>
                </div>

                <!-- Report Table -->
                <div id="reportTableContainer" class="mt-4"></div>

                <!-- Pagination Controls -->
                <div id="pagination" class="flex justify-between items-center mt-4"></div>
            </div>
        </div>
    </div>
</section>

   






    <!-- Patient Demographics and Disease Statistics -->
    <section class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between w-full bg-gray-100 px-4 py-2 rounded-md text-gray-700">
        <span class="text-xl font-bold">Patient Demographics</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <!-- Age Distribution Chart -->
        <div>
            <h2 style="color:black;" class="text-lg font-semibold text-black mb-2">Age Distribution</h2>
            <canvas style="max-width: 300px; max-height: 300px; margin: auto;" id="ageDistributionChart"></canvas>
        </div>
        <!-- Gender Distribution Chart -->
        <div>
            <h2 style="color:black;" class="text-lg font-semibold text-black mb-2">Gender Distribution</h2>
            <canvas style="max-width: 300px; max-height: 300px; margin: auto;" id="genderDistributionChart"></canvas>
        </div>
    </div>
</section>

    <!-- Disease Statisctics -->
    <section class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between w-full bg-gray-100 px-4 py-2 rounded-md text-gray-700">
        <span class="text-xl font-bold">Disease Statistics</span>
    </div>

    <div class="mt-4">
        <!-- Disease Statistics Chart -->
        <div>
            <h2 style="color:black;" class="text-lg font-semibold text-black mb-2">Disease Statistics</h2>
            <canvas style="max-width: 300px; max-height: 300px; margin: auto;" id="diseaseStatisticsChart"></canvas>
        </div>
    </div>
</section>





    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>


        // Fetching patient demographics data
        fetch('/patient-demographics')
            .then(response => response.json())
            .then(data => {
                const ageData = Object.values(data.ageGroups);
                const genderData = Object.values(data.genderDistribution);

                // Age Distribution Chart
                const ageCtx = document.getElementById('ageDistributionChart').getContext('2d');
                new Chart(ageCtx, {
                    type: 'pie',
                    data: {
                        labels: ['0-5', '6-12', '13-18', '19+'],
                        datasets: [{
                            label: 'Age Groups',
                            data: ageData,
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                        }]
                    }
                });

                // Gender Distribution Chart
                const genderCtx = document.getElementById('genderDistributionChart').getContext('2d');
                new Chart(genderCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Male', 'Female', 'Other'],
                        datasets: [{
                            label: 'Gender',
                            data: genderData,
                            backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
                        }]
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching demographics data:', error);
            });

         



        // Fetching Disease Statistics

        fetch('/disease-statistics')
        .then(response => response.json())
        .then(data => {
            const diseaseLabels = Object.keys(data);
            const diseaseCounts = Object.values(data);

            const ctx = document.getElementById('diseaseStatisticsChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: diseaseLabels,
                    datasets: [{
                        label: 'Diseases',
                        data: diseaseCounts,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    }]
                }
            });
        })
        .catch(error => {
            console.error('Error fetching disease statistics:', error);
        });





        //Encounter Summary Report
        let currentPage = 1;
const rowsPerPage = 10; // Number of rows per page
let reportData = [];
let reportType = '';
let isLoading = false;

document.addEventListener("DOMContentLoaded", () => {
    const reportForm = document.getElementById('reportForm');

    // Add submit event listener to the form
    reportForm.addEventListener('submit', function(event) {
        event.preventDefault();
        fetchReport();
    });
});

function fetchReport() {
    const startDate = document.querySelector('#start_date').value;
    const endDate = document.querySelector('#end_date').value;
    reportType = document.querySelector('#report_type').value;

    isLoading = true;
    showLoading(true);
    document.getElementById('submitButton').disabled = true; // Disable the submit button

    let endpoint;

    if (reportType === 'encounter_summary') {
        endpoint = '/generate-encounter-summary';
    } else if (reportType === 'staff_performance') {
        endpoint = '/generate-staff-performance';
    } else if (reportType === 'expense_breakdown') {
        endpoint = '/expenses'; // New endpoint for expense breakdown
    } else {
        alert('Invalid report type. Please select a valid option.');
        showLoading(false);
        document.getElementById('submitButton').disabled = false;
        return;
    }

    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ start_date: startDate, end_date: endDate, report_type: reportType }),
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            if (reportType === 'encounter_summary') {
                reportData = data.encounters;
            } else if (reportType === 'staff_performance') {
                reportData = data.performance;
            } else if (reportType === 'expense_breakdown') {
                reportData = data.data; // Use 'data' field from response
            }

            currentPage = 1;
            updateTable();
            document.getElementById("reportModal").style.display = "flex";
        } else {
            alert('Failed to generate the report.');
        }
    })
    .catch((error) => {
        console.error('Error fetching report:', error);
        alert('An error occurred while fetching the report.');
    })
    .finally(() => {
        isLoading = false;
        showLoading(false);
        document.getElementById('submitButton').disabled = false;
    });
}


// Function to show or hide the loading indicator
function showLoading(show) {
    const loadingIndicator = document.getElementById('loadingIndicator');
    if (show) {
        loadingIndicator.style.display = 'block';
    } else {
        loadingIndicator.style.display = 'none';
    }
}


// Function to render the paginated report table
function renderReportTable(page = 1) {
    const tableContainer = document.getElementById("reportTableContainer");
    tableContainer.innerHTML = ""; // Clear previous content

    if (reportData.length === 0) {
        tableContainer.innerHTML = "<p class='text-red-500'>No data available for the selected period.</p>";
        return;
    }

    const table = document.createElement("table");
    table.classList.add("min-w-full", "bg-white", "border-collapse", "border", "border-gray-300");

    // Create table headers
    const thead = document.createElement("thead");
    const trHead = document.createElement("tr");

    let headers = [];
    if (reportType === 'encounter_summary') {
        headers = ["Date", "Child Name", "Specialist Name", "Invoice ID"];
    } else if (reportType === 'staff_performance') {
        headers = ["Date", "Staff Name", "Service", "Sessions"];
    } else if (reportType === 'expense_breakdown') {
        headers = ["Date", "Category", "Description", "Full Name", "Amount", "Payment Method"];
    }

    headers.forEach(header => {
        const th = document.createElement("th");
        th.textContent = header;
        th.classList.add("border", "px-4", "py-2", "text-left");
        trHead.appendChild(th);
    });

    thead.appendChild(trHead);
    table.appendChild(thead);

    // Create table body
    const tbody = document.createElement("tbody");
    const start = (page - 1) * rowsPerPage;
    const paginatedData = reportData.slice(start, start + rowsPerPage);

    paginatedData.forEach(row => {
        const tr = document.createElement("tr");

        if (reportType === 'expense_breakdown') {
            const values = [
                new Date(row.created_at).toLocaleDateString(),
                row.category,
                row.description,
                row.fullname || "N/A",
                row.amount,
                row.payment_method
            ];

            values.forEach(value => {
                const td = document.createElement("td");
                td.textContent = value;
                td.classList.add("border", "px-4", "py-2");
                tr.appendChild(td);
            });

        } else {
            headers.forEach((key, index) => {
                const td = document.createElement("td");
                const dataKey = Object.keys(row)[index];
                td.textContent = row[dataKey];
                td.classList.add("border", "px-4", "py-2");
                tr.appendChild(td);
            });
        }

        tbody.appendChild(tr);
    });

    table.appendChild(tbody);
    tableContainer.appendChild(table);

    updatePaginationControls();
}


// Function to update the table
function updateTable() {
    renderReportTable(currentPage);
}

// Function to update pagination controls
function updatePaginationControls() {
    const totalPages = Math.ceil(reportData.length / rowsPerPage);
    const paginationContainer = document.getElementById('pagination');

    paginationContainer.innerHTML = `
        <button onclick="prevPage()" class="px-4 py-2 bg-gray-200 rounded ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}" ${currentPage === 1 ? 'disabled' : ''}>Previous</button>
        <span class="mx-2">Page ${currentPage} of ${totalPages}</span>
        <button onclick="nextPage()" class="px-4 py-2 bg-gray-200 rounded ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''}" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>
    `;
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        updateTable();
    }
}

function nextPage() {
    const totalPages = Math.ceil(reportData.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        updateTable();
    }
}

function closeModal() {
    document.getElementById("reportModal").style.display = "none";
}

    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/filament/pages/analytics.blade.php ENDPATH**/ ?>