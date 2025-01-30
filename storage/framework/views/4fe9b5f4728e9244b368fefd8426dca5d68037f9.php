<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.page','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <section 
        class="rounded-lg shadow-md" 
        style="background-color: transparent;"
        x-data="{ 
            open: true,
            reportData: null,
            async generateReport(form) {
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
            }
        }">
        <h1 class="text-xl font-bold mb-2">Revenue Report</h1>
        <p class="text-black-600 mb-4">Generate revenue reports by date range and specialization.</p>
        
        <!-- Report Parameters -->
        <form 
            @submit.prevent="generateReport($event.target)"
            action="<?php echo e(route('generate.revenue.report')); ?>" 
            method="POST"
        >
            <?php echo csrf_field(); ?>
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
            >
                Generate Report
            </button>
        </form>

        <!-- Report Results -->
        <div x-show="reportData" x-transition class="mt-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-900">Total Revenue</h3>
                    <p class="text-2xl text-gray-900" x-text="formatCurrency(reportData.summary.total_revenue)"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-900">Normal Payments</h3>
                    <p class="text-2xl text-gray-900" x-text="formatCurrency(reportData.summary.normal_payment)"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-900">Sponsored Payments</h3>
                    <p class="text-2xl text-gray-900" x-text="formatCurrency(reportData.summary.sponsored_payment)"></p>
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
        </div>
    </section>
  

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/filament/pages/revenue-report.blade.php ENDPATH**/ ?>