<x-filament::page>
<style>
    td,th,button,option,select{
        color:black;
    }
</style>
<section class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-xl font-bold mb-2" style="color: black;">Custom Report</h1>
    <p class="text-gray-600 mb-4" style="color: black;">Select parameters to generate a custom report.</p>

    <div x-data="{ open: true, showReport: false, reportContent: [], isLoading: false }">
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
            <form @submit.prevent="fetchReport" method="POST" class="space-y-4">
                @csrf
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
                <div>
                    <label for="report_type" class="block text-sm font-medium" style="color: black;">Report Type</label>
                    <select
                    style="color: black;" 
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
                <div>
                    <button
                    style="color: black;" 
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

        <!-- Report Modal -->
        <div x-show="showReport" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-md w-2/3">
                <div class="flex justify-between items-center">
                    <h2  style="color: black;" class="text-lg font-semibold" style="color: black;">Generated Report</h2>
                    <button 
                     style="color: black;"
                        @click="showReport = false; reportContent = [];" 
                        class="text-red-500 hover:text-red-700"
                    >
                        Close
                    </button>
                </div>
                <div class="mt-4">
                    <table class="min-w-full bg-white border-collapse border border-gray-300">
                        <thead>
                            <tr class="text-left">
                                <th class="border px-4 py-2" style="color: black;">Date</th>
                                <th class="border px-4 py-2" style="color: black;">Child Name</th>
                                <th class="border px-4 py-2" style="color: black;">Specialist Name</th>
                                <th class="border px-4 py-2" style="color: black;">Invoice ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(row, index) in reportContent" :key="index">
                                <tr>
                                    <td class="border px-4 py-2" x-text="row.date"></td>
                                    <td class="border px-4 py-2" x-text="row.child_name"></td>
                                    <td class="border px-4 py-2" x-text="row.specialist_name"></td>
                                    <td class="border px-4 py-2" x-text="row.invoice_id"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>






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

        function fetchReport() {
        const startDate = document.querySelector('#start_date').value;
        const endDate = document.querySelector('#end_date').value;
        const reportType = document.querySelector('#report_type').value;

        // Check if the selected report type is 'Encounter Summary'
        if (reportType === 'encounter_summary') {
            this.isLoading = true;

            fetch(`/generate-encounter-summary`, {
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
                    // Ensure the fetched data is an array
                    this.reportContent = Array.isArray(data.encounters) ? [...data.encounters] : [];
                    this.showReport = true;
                } else {
                    alert('Failed to generate the report.');
                }
            })
            .catch(error => {
                console.error('Error fetching report:', error);
            })
            .finally(() => {
                this.isLoading = false;
            });
            } else {
                alert('This report type is not supported. Please select "Encounter Summary".');
            }
        }
    </script>

</x-filament::page>
