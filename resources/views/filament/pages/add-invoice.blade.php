<x-filament::page>
    <section id="finances" class="content-section">
        <h2>Finances</h2>

        <div class="finances-buttons">
            <button id="generate-revenue-btn">Generate Revenue Report</button>
            <button id="view-expenses-btn">View Expense Breakdown</button>
            <button id="connect-to-quickbooks-btn">Connect to QuickBooks</button>
        </div>

        <div id="finances-content"></div>
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

    <script src="{{ asset('js/beaconAdmin.js') }}"></script>
</x-filament::page>
