<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.page','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
            <div x-show="open" x-transition:enter="transition-all duration-1000 ease-in-out" x-transition:leave="transition-all duration-1000 ease-in-out" x-collapse class="mt-4">
                <form action="<?php echo e(route('generate.report')); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
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
                            <option style="color:black;" value="financial_summary">Financial Summary</option>
                            <option style="color:black;" value="expenses_breakdown">Expenses Breakdown</option>
                            <option style="color:black;" value="revenue_breakdown">Revenue Breakdown</option>
                            <option style="color:black;" value="staff_performance">Staff Performance</option>
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
                            <span style="color:black;">Generate Report</span> 
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

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
                <canvas id="ageDistributionChart"></canvas>
            </div>
            <!-- Gender Distribution Chart -->
            <div>
                <h2 style="color:black;" class="text-lg font-semibold text-black mb-2">Gender Distribution</h2>
                <canvas id="genderDistributionChart"></canvas>
            </div>
        </div>
    </section>

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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH C:\Users\sharo\Downloads\Beacon's\BeaconChildrenCenter-1\resources\views/filament/pages/analytics.blade.php ENDPATH**/ ?>