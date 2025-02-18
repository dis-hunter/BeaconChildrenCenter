<x-filament::page>
    <section 
        class="rounded-lg shadow-md" 
        style="background-color: transparent;"
        x-data="{ 
            open: true,
            reportData: null,
             isLoading: false,
            async generateReport(form) {
            this.isLoading = true;
                const formData = new FormData(form);
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        }
                    });
                    this.reportData = await response.json();
                    this.renderCharts();
                } catch (error) {
                    console.error('Error generating report:', error);
                }finally {
        this.isLoading = false;  // Set loading to false when done
    }
            },
            formatCurrency(amount) {
                return new Intl.NumberFormat('en-KE', {
                    style: 'currency',
                    currency: 'KES'
                }).format(amount);
            },
            renderCharts() {
                if (!this.reportData) return;
                
                // Render the Service Breakdown chart
                const servicesChart = document.getElementById('servicesChart');
                new Chart(servicesChart, {
                    type: 'bar',
                    data: {
                        labels: this.reportData.services.map(item => item.service),
                        datasets: [{
                            label: 'Revenue by Service',
                            data: this.reportData.services.map(item => item.revenue),
                            backgroundColor: '#4F46E5'
                        }]
                    }
                });

                // Render the Daily Revenue Trend chart
                const dailyChart = document.getElementById('dailyRevenueChart');
                new Chart(dailyChart, {
                    type: 'line',
                    data: {
                        labels: this.reportData.daily.map(item => item.date),
                        datasets: [{
                            label: 'Daily Revenue',
                            data: this.reportData.daily.map(item => item.revenue),
                            borderColor: '#4F46E5',
                            tension: 0.1
                        }]
                    }
                });

                // Render the Paid Invoices chart
                const paidInvoicesChart = document.getElementById('paidInvoicesChart');
                new Chart(paidInvoicesChart, {
                    type: 'line',
                    data: {
                        labels: this.reportData.paidInvoices.map(item => item.date),
                        datasets: [{
                            label: 'Paid Invoices',
                            data: this.reportData.paidInvoices.map(item => item.amount),
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'KES ' + value.toLocaleString();
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'KES ' + context.raw.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }">
        <h1 class="text-xl font-bold mb-2">Revenue Report</h1>
        <p class="text-black-600 mb-4">Generate revenue reports by date range and specialization.</p>
        
        <!-- Report Parameters -->
        <form 
            @submit.prevent="generateReport($event.target)"
            action="{{ route('generate.revenue.report') }}" 
            method="POST"
        >
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-white-900">Start Date</label>
                    <input 
                        type="date" 
                        id="start_date" 
                        name="start_date" 
                        class="mt-1 block w-full rounded-md text-gray-900"
                        required
                    >
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-white-900">End Date</label>
                    <input 
                        type="date" 
                        id="end_date" 
                        name="end_date" 
                        class="mt-1 block w-full rounded-md text-gray-900"
                        required
                    >
                </div>
                <div>
                    <label for="specialization" class="block text-sm font-medium text-white-900">Specialization</label>
                    <select 
    id="specialization" 
    name="specialization" 
    class="mt-1 block w-full rounded-md font-medium text-gray-700"
>
    <option value="">All Specializations</option>
    <option value="2">Occupational Therapy</option>
    <option value="3">Speech Therapy</option>
    <option value="4">Physiotherapy</option>
    <option value="5">Nutrition</option>
    <option value="6">ABA</option>
    <option value="8">Medical Officer</option>
    <option value="9">Psychologist</option>
    <option value="10">Well Baby Clinic</option>
    <option value="1">Paediatrician</option>
</select>

                </div>
            </div>
            <button 
    type="submit" 
    class="bg-gray-600 text-white py-2 px-4 rounded-md"
    :disabled="isLoading"
>
    <span x-show="!isLoading">Generate Report</span>
    <span x-show="isLoading" class="flex items-center">
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Generating...
    </span>
</button>
        </form>

        <!-- Report Results -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-gray-50 p-4 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900">Total Expected Revenue</h3>
        <p class="text-2xl text-gray-900" x-text="formatCurrency(reportData.summary.total_revenue)"></p>
    </div>
    <div class="bg-gray-50 p-4 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900">Cash/Insurance Expected Payments</h3>
        <p class="text-2xl text-gray-900" x-text="formatCurrency(reportData.summary.normal_payment)"></p>
    </div>
    <div class="bg-gray-50 p-4 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900">NCPD Expected Payments</h3>
        <p class="text-2xl text-gray-900" x-text="formatCurrency(reportData.summary.sponsored_payment)"></p>
    </div>
    <div class="bg-gray-50 p-4 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900">Paid Invoices</h3>
        <p class="text-2xl text-gray-900" x-text="formatCurrency(reportData.summary.paid_invoices_total)"></p>
    </div>
</div>
<div 
    x-show="isLoading" 
    class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
>
    <div class="bg-white p-4 rounded-lg shadow-lg flex items-center">
        <svg class="animate-spin h-5 w-5 text-gray-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-gray-700">Loading report data...</span>
    </div>
</div>
            <!-- Charts -->
            <div>
                <h2 class="text-lg font-medium">Daily Revenue Trend</h2>
                <canvas id="dailyRevenueChart" class="mt-4"></canvas>
            </div>
            <div>
                <h2 class="text-lg font-medium">Revenue by Service</h2>
                <canvas id="servicesChart" class="mt-4"></canvas>
            </div>
             <!-- New Paid Invoices chart -->
             <div>
                <h2 class="text-lg font-medium">Paid Invoices</h2>
                <canvas id="paidInvoicesChart" class="mt-4"></canvas>
            </div>
        </div>
    </section>
  


    
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</x-filament::page>
