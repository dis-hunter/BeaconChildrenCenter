<x-filament::page>
<section class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-xl font-bold mb-2" style="color: black;">Custom Report</h1>
    <p class="text-gray-600 mb-4" style="color: black;">Select parameters to generate a custom report.</p>

    <!-- Report Parameters -->
    <div x-data="{ open: true, showReport: false, reportContent: '' }">
        <!-- Toggle Button -->
        <button 
            @click="open = !open" 
            class="flex items-center justify-between w-full bg-gray-100 px-4 py-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none"
        >
            <span style="color: black;">Report Parameters</span>
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
            <form @submit.prevent="fetchReport()" method="POST" class="space-y-4">
                @csrf
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium" style="color: black;">Start Date</label>
                    <input 
                    style="color: black;"
                        type="date" 
                        id="start_date" 
                        name="start_date" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black"
                        required
                    >
                </div>
                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium" style="color: black;">End Date</label>
                    <input 
                    style="color: black;"
                        type="date" 
                        id="end_date" 
                        name="end_date" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black"
                        required
                    >
                </div>
                <!-- Report Type -->
                <div>
                    <label for="report_type" class="block text-sm font-medium" style="color: black;">Report Type</label>
                    <select 
                        id="report_type" 
                        name="report_type" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black"
                        required
                    >
                        <option style="color: black;" value="encounter_summary">Encounter Summary</option>
                        <option style="color: black;" value="financial_summary">Financial Summary</option>
                        <option style="color: black;" value="expenses_breakdown">Expenses Breakdown</option>
                        <option style="color: black;" value="revenue_breakdown">Revenue Breakdown</option>
                        <option style="color: black;" value="staff_performance">Staff Performance</option>
                    </select>
                </div>
                <!-- Submit Button -->
                <div>
                    <button 
                    style="color: black;"
                        type="submit" 
                        class="flex items-center justify-center w-full bg-blue-600 text-white py-2 px-4 rounded-lg shadow hover:bg-blue-700"
                    >
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            class="h-5 w-5 mr-2" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Generate Report
                    </button>
                </div>
            </form>
        </div>

        <!-- Report Modal -->
        <div x-show="showReport" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-md w-2/3">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold" style="color: black;">Generated Report</h2>
                    <button 
                        @click="showReport = false; reportContent = '';" 
                        class="text-red-500 hover:text-red-700"
                    >
                        Close
                    </button>
                </div>
                <div class="mt-4">
                    <div x-text="reportContent" style="color: black;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function fetchReport() {
        const startDate = document.querySelector('#start_date').value;
        const endDate = document.querySelector('#end_date').value;
        const reportType = document.querySelector('#report_type').value;

        fetch(`/generate-report`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ start_date: startDate, end_date: endDate, report_type: reportType })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Store the report content in the variable and show the modal
                this.reportContent = data.report;
                this.showReport = true;
            } else {
                alert('Failed to generate the report');
            }
        })
        .catch(error => console.error('Error fetching report:', error));
    }
</script>















































































    <!-- Patient Demographics and Disease Statistics -->

    <section class="bg-white p-6 rounded-lg shadow-md" x-data="{ open: false }">
        <button 
            @click="open = !open" 
            class="flex items-center justify-between w-full bg-gray-100 px-4 py-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none"
        >
            <span class="text-xl font-bold">Patient Demographics</span>
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

        <div x-show="open" x-transition:enter="transition-all duration-1000 ease-in-out" x-transition:leave="transition-all duration-1000 ease-in-out" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 max-h-0 overflow-hidden">
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
    <section class="bg-white p-6 rounded-lg shadow-md" x-data="{ open: false }">
    <button 
        @click="open = !open" 
        class="flex items-center justify-between w-full bg-gray-100 px-4 py-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none"
    >
        <span class="text-xl font-bold">Disease Statistics</span>
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

    <div 
        x-show="open" 
        x-transition:enter="transition-all duration-1000 ease-in-out" 
        x-transition:leave="transition-all duration-1000 ease-in-out" 
        x-bind:style="open ? 'max-height: 500px' : 'max-height: 0'"
        style="overflow: hidden; max-height: 0;"
        class="grid grid-cols-1 gap-6 mt-4"
    >
        <!-- Disease Statistics Chart -->
        <div>
            <h2 style="color:black;" class="text-lg font-semibold text-black mb-2">Disease Statistics</h2>
            <canvas style="max-width: 300px; max-height: 300px; margin: auto;" id="diseaseStatisticsChart"></canvas>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Fetch data from backend and display the Disease Statistics chart
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
</script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fetch data from backend and display charts
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</x-filament::page>
