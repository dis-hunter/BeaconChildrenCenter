<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.page','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <section id="finances" class="content-section">
        <h2>Finances</h2>

        <div class="finances-buttons">
            <button id="generate-revenue-btn">Generate Revenue Report</button>
            <button id="view-expenses-btn">View Expense Breakdown</button>
            <button id="connect-to-quickbooks-btn">Connect to QuickBooks</button>
        </div>

        <div id="finances-content"></div>
        <h1>welcome</h1>

        <h3>Invoice Management</h3>
        <div id="invoice-management">
            <input type="date" id="invoice-date" onchange="showInvoicesForDate()">
            <div id="invoice-list"></div>
        </div>

        <h3>Expense Tracking</h3>
        <div id="expense-tracking">
            <button onclick="showExpenseForm()">Add Expense</button>
            <div id="expense-form" style="display: none;">
                <h4>Add New Expense</h4>
                <form id="new-expense-form">
                    <label for="expense-category">Category:</label>
                    <select id="expense-category" name="expense-category" onchange="updateExpenseDescriptions()">
                        <option value="">Select Category</option>
                        <option value="1">Rent and service charge</option>
                        <option value="2">Salaries/wages</option>
                        <option value="3">Licences and permits</option>
                        <option value="4">Insurance</option>
                        <option value="5">ICT needs</option>
                        <option value="6">Continuous Professional Development</option>
                        <option value="7">Marketing and Advertising</option>
                        <option value="8">Transport and Delivery</option>
                        <option value="9">Therapy Equipment</option>
                        <option value="10">Furniture</option>
                        <option value="11">Office repairs and maintenance</option>
                        <option value="12">Monthly utility bills</option>
                        <option value="13">Consumables</option>
                        <option value="14">Other charges</option>
                    </select><br><br>

                    <label for="expense-description">Description:</label>
                    <select id="expense-description" name="expense-description">
                        <option value="">Select Description</option>
                    </select>
                    <input type="text" id="other-description" name="other-description" style="display: none;" placeholder="Enter other description">
                    <br><br>

                    <label for="expense-amount">Amount:</label>
                    <input type="number" id="expense-amount" name="expense-amount" required><br><br>

                    <label for="payment-method">Payment Method:</label>
                    <select id="payment-method" name="payment-method">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                    </select><br><br>

                    <button type="submit">Add Expense</button>
                </form>
            </div>
        </div>
    </section>

    <script >
      function showInvoicesForDate() {
    const selectedDate = document.getElementById("invoice-date").value;
    const invoiceList = document.getElementById("invoice-list");
    invoiceList.innerHTML = ""; // Clear previous list
  
    const filteredInvoices = invoices.filter(invoice => invoice.date === selectedDate);
  
    if (filteredInvoices.length > 0) {
        const table = document.createElement("table");
        table.innerHTML = `
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Patient Name</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                ${filteredInvoices.map(invoice => `
                    <tr>
                        <td>${invoice.invoiceId}</td>
                        <td>${invoice.patient}</td>
                        <td>$${invoice.amount}</td>
                        <td>${invoice.status}</td>
                        <td>${invoice.paymentMethod}</td>
                        <td><button onclick="showInvoiceDetails('${invoice.invoiceId}')">View</button></td>
                    </tr>
                `).join("")}
            </tbody>
        `;
        invoiceList.appendChild(table);
    } else {
      invoiceList.innerHTML = "<p>No invoices found for this date.</p>";
    }
  }   
  function showExpenseForm() {
    const expenseForm = document.getElementById("expense-form");
    if (expenseForm.style.display === "none") {
      expenseForm.style.display = "block";
    } else {
      expenseForm.style.display = "none";
    }
  }
  function updateExpenseDescriptions() {
    const category = document.getElementById("expense-category").value;
    const descriptionSelect = document.getElementById("expense-description");
    const otherDescriptionInput = document.getElementById("other-description");
    descriptionSelect.innerHTML = '<option value="">Select Description</option>'; // Clear previous options
    otherDescriptionInput.style.display = "none"; // Hide "other" input by default

    let descriptions = [];
    switch (category) {
        case "1":
            // Rent and service charge descriptions
            descriptions = ["Rent", "Service Charge", "Other"];
            break;
        case "2":
            // Salaries/wages descriptions
            descriptions = ["Doctor","Nurse","Nurse Aid","Speech Therapist","Occupational Therapist","Physiotherapist","Psychologist","Nutritionist","Therapy Assistant","Accountant","Administrator","Receptionist", "Errand boy", "Cleaner", "Accountant", "Other"];
            break;
        case "3":
            // Licences and permits descriptions
            descriptions = ["KMPDB Annual retention(Dr Oringe)", "KMPBD clinic annual registration","Association of Speech Therapists","Physiotherapy Counsel of Kenya","Kenya Occupational Therapy Assosciation","Kenya Health Professionals Authority", "Medical Waste disposal","Business Permit","Public Health Lisence", "Single business permit", "Public health Permit", "Solid waste disposal", "Other"];
            break;
        case "4":
            // Insuarance descriptions
            descriptions = ["Beacon facility indemnity", "Fire cover"," Buglary","Professional indemnity(Dr.Oringe)","Other"];
            break;

        case "5":
            //ICT needs descriptions
            descriptions = ["Software development","Hardware purchase", "Techincal support", "Database hosting subscription", "Internet Service Providers","Other"];
            break;
    
        case "6":
            //Continuous Professional development
            descriptions = ["Trainings","Workshops/Seminars", "Journal subscriptions", "E-book subscriptions", "Conferences", "Newspapers/Editorials", "Other"];
            break;
    
        case "7":
            //Marketing and advertising
            descriptions = ["Online marketting","Webinars", "Meeting costs", "Banners", "Marketting tools", "Branding", "Other"];
            break;
    
        case "8":
             // Transportation and delivery
            descriptions = ["Fuel costs", "Car Hire", "Uber/Bolt", "Rider charges", "Other"];
            break;
    
        case "9":
            // Therapy equipment descriptions
            descriptions = ["Treadmill", "Standing bike", "Walking Frame", "Walking Support Bar","Hammock swing","Mini step","Therapy balls","Trampoline","Play pen","Filler balls","Massager","Play toys","Weighted blanket","Floor matts","Gym matts","Beam bag","Therapy foam blocks","Therapy mirrors","Therapy boards","Therapy music system","Other"];
            break;

        case "10":
            //Funiture equipment descriptions
            descriptions = ["Office Tables","Chairs", "Cabinets", "Beds", "Steps", "Other"];
            break;

        
        case "11":
            // Office space maintenance descriptions
            descriptions = ["Construction Work","Plumbing repairs", "Electrical maintenance", "Painting work", "Welders", "Capentery works","Security services", "Other"];
            break;
        case "12":
            // Monthly utility bills descriptions
            descriptions = ["Electricity bills", "Medical waste disposal", "Internet provider", "Online Marketing", "Photocopy/printing","Airtime","Deliveries","Online Marketing","Monthly staff meeting", "Other"];
            break;
        case "13":
            // Consumables descriptions
            descriptions = ["Gloves", "Sanitizers", "Bleach and detergents", "Wooden spatulas", "Sugar and tea/coffee", "Drinking mineral water", "Cleaning materials", "Stationary", "Other"];
            break;
        case "14":
            // Other charges descriptions
            descriptions = ["Conference attendance/CME", "Newspaper", "Journals and e-subscriptions", "Rider charges", "Fuel", "Other"];
            break;
        default:
            break;
    }

    descriptions.forEach(description => {
        const option = document.createElement("option");
        option.value = description.toLowerCase();
        option.text = description;
        descriptionSelect.appendChild(option);
    });

    // Show "other" input if "Other" is selected
    descriptionSelect.addEventListener("change", () => {
        if (descriptionSelect.value === "other") {
            otherDescriptionInput.style.display = "block";
        } else {
            otherDescriptionInput.style.display = "none";
        }
    });
}
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH C:\Users\User\Downloads\Beacon\BeaconChildrenCenter\resources\views/filament/pages/expenses.blade.php ENDPATH**/ ?>