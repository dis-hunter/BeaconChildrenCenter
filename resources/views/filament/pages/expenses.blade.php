<x-filament::page>
        <div> <!-- Single Root Element -->
            <div class="loader-overlay">
                <div class="loader"></div>
            </div>

            <section id="finances" class="content-section">
                <h3>Add Expense Below</h3>
                <div id="expense-tracking">
                    <div id="expense-form" class="fade-in">
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
                            </select>

                            <label for="expense-description">Description:</label>
                            <select id="expense-description" name="expense-description">
                                <option value="">Select Description</option>
                            </select>
                            <input type="text" id="other-description" name="other-description" style="display: none;"
                                placeholder="Enter other description">

                            <label for="expense-amount">Amount:</label>
                            <input type="number" id="expense-amount" name="expense-amount" required>

                            <label for="payment-method">Payment Method:</label>
                            <select id="payment-method" name="payment-method">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </form>
                        <button onclick="showValues()">Add Expense</button>
                    </div>
                </div>
            </section>
            
<style>
    /* General Styling */
    :root {
        --navy-blue: #ffffff;
        --text-primary: #1B2433;
        --text-secondary: #C4A862;
        --bg-primary: #ffffff;
        --bg-secondary: rgba(255, 255, 255, 0.9);
        --border-color: #C4A862;
        --input-bg: #ffffff;
        --input-border: #C4A862;
        --button-hover: #C4A862;
        --button-text-hover: #ffffff;
    }

    .dark {
        --navy-blue: #1B2433;
        --text-primary: #ffffff;
        --text-secondary: #C4A862;
        --bg-primary: #1B2433;
        --bg-secondary: rgba(27, 36, 51, 0.9);
        --border-color: #C4A862;
        --input-bg: #1B2433;
        --input-border: #C4A862;
        --button-hover: #C4A862;
        --button-text-hover: #1B2433;
    }

    .loader-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .loader {
        width: 50px;
        height: 50px;
        border: 5px solid var(--bg-primary);
        border-radius: 50%;
        border-top-color: var(--text-secondary);
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    body {
        background-color: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'Arial', sans-serif;
    }

    .content-section {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    h3, h4 {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }

    #expense-tracking button {
        background-color: transparent;
        border: 2px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #expense-tracking button:hover {
        background-color: var(--button-hover);
        color: var(--button-text-hover);
    }

    #expense-form {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 2rem;
        margin-top: 1.5rem;
        backdrop-filter: blur(8px);
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const expenseForm = document.getElementById("expense-form");
        setTimeout(() => {
            expenseForm.classList.add("active");
        }, 10);
    });

    function showValues() {
        const category = document.getElementById("expense-category").value;
        const description = document.getElementById("expense-description").value;
        const amount = document.getElementById("expense-amount").value;
        const paymentMethod = document.getElementById("payment-method").value;

        console.log("Category:", category);
        console.log("Description:", description);
        console.log("Amount:", amount);
        console.log("Payment Method:", paymentMethod);
    }
</script>

        </div> <!-- End Root Element -->
</x-filament::page>

