<x-filament::page>
    <section class="bg-white p-6 rounded-lg shadow-md">
        <h1 style="color:black;" class="text-xl font-bold mb-2 text-black">Custom Report</h1> 
        <p class="text-gray-600 mb-4">Select parameters to generate a custom report.</p>
        <div x-data="{ open: true }">
            <button 
                @click="open = !open" 
                class="flex items-center justify-between w-full bg-gray-100 px-4 py-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none"
            >
                <span>Report Parameters</span>
                <svg 
                    x-bind:class="open ? 'rotate-180' : ''" 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5 transform transition-transform duration-300" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-collapse class="mt-4">
                <form action="{{ route('generate.report') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input 
                            type="date" 
                            id="start_date" 
                            name="start_date" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black"
                            style="color:black;" 
                            required
                        >
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input 
                            type="date" 
                            id="end_date" 
                            name="end_date" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black"

                            style="color:black;" 
                            required
                        >
                    </div>

                    <div>
                        <label for="report_type" class="block text-sm font-medium text-gray-700">Report Type</label>
                        <select 
                            id="report_type" 
                            name="report_type" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black"
                            style="color:black;" 
                            required
                        >
                            <option style="color:black;" value="financial_summary">Financial Summary </option>
                            <option style="color:black;"    value="expenses_breakdown">Expenses Breakdown</option>
                            <option style="color:black;"  value="revenue_breakdown">Revenue Breakdown</option>
                            <option style="color:black;"  value="staff_performance">Staff Performance</option>
                        </select>
                    </div>

                    <div>
                        <button 
                            type="submit" 
                            class="flex items-center justify-center w-full bg-blue-600 text-white py-2 px-4 rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
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
                            <span style="color:black;" >Generate Report</span> 
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
  
    <section class="bg-white p-6 rounded-lg shadow-md">
    <!-- Collapsible Button -->
    <button style="color:black;" id="toggleButton" class="bg-blue-500 text-white py-2 px-4 rounded mb-4">
        Toggle Patient Demographics
    </button>
    
    <!-- Demographics Content -->
    <div id="demographicsContent" class="hidden">
        <h1 class="text-xl font-bold mb-2" style="color:black;">Patient Demographics</h1>
        <p class="text-black mb-4" style="color:black;">View the age and gender distribution of registered children.</p>
        
        <!-- Demographics Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Age Distribution Chart -->
            <div>
                <h2 class="text-lg font-semibold text-black mb-2" style="color:black;">Age Distribution</h2>
                <canvas id="ageDistributionChart"></canvas>
            </div>
            
            <!-- Gender Distribution Chart -->
            <div>
                <h2 class="text-lg font-semibold text-black mb-2" style="color:black;">Gender Distribution</h2>
                <canvas id="genderDistributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- ChartJS Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fetch data for demographics from the backend
        fetch('/patient-demographics')
            .then(response => response.json())
            .then(data => {
                // Log the server response to the console
                console.log('Demographics Data:', data);

                // Extract age and gender data from the response
                const ageData = Object.values(data.ageGroups);
                const genderData = Object.values(data.genderDistribution);

                // Age Distribution Pie Chart
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

                // Gender Distribution Pie Chart
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

        // Toggle visibility of the demographics section
        document.getElementById('toggleButton').addEventListener('click', function () {
            const content = document.getElementById('demographicsContent');
            content.classList.toggle('hidden');  // Toggle the "hidden" class to show/hide content
        });
    </script>
</section>



</x-filament::page>