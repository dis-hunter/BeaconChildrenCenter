<x-filament::page>
    <div> <!-- Single Root Element -->
        <div class="loader-overlay">
            <div class="loader"></div>
        </div>

        <section id="finances" class="content-section">
            

            <div id="expense-tracking">
                <div id="expense-form" class="fade-in">
                    <h4 class="form-title">Add Expense Below</h4>
                    <form id="new-expense-form" class="expense-form-grid">
                        <div class="form-group">
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
                        </div>

                        <div class="form-group">
                            <label for="expense-description">Description:</label>
                            <select id="expense-description" name="expense-description">
                                <option value="">Select Description</option>
                            </select>
                            <input type="text" id="other-description" name="other-description" 
                                   class="hidden-input" placeholder="Enter other description">
                        </div>

                        <div class="form-group">
                            <label for="expense-amount">Amount:</label>
                            <div class="amount-input-wrapper">
                                <span class="currency-symbol">Ksh   </span>
                                <input type="number" id="expense-amount" name="expense-amount" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="payment-method">Payment Method:</label>
                            <select id="payment-method" name="payment-method">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="button" onclick="showValues()" class="submit-btn">Add Expense</button>
                        </div>
                    </form>
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
        --card-bg: #ffffff;
        --shadow-color: rgba(0, 0, 0, 0.1);
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
        --card-bg: #2D3748;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    /* Layout and Spacing */
    .content-section {
        padding: 2rem;
        max-width: 800px;
        margin: 0 auto;
        min-height: 100vh;
    }

    /* Balance Card Styling */
    .balance-card {
        background-color: var(--card-bg);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px var(--shadow-color);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .balance-content {
        flex-grow: 1;
    }

    .balance-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .balance-amount {
        color: var(--text-primary);
        font-size: 2rem;
        font-weight: bold;
    }

    /* Theme Toggle Button */
    .theme-toggle-btn {
        background: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }

    .theme-toggle-btn:hover {
        transform: scale(1.1);
    }

    /* Form Styling */
    .expense-form-grid {
        display: grid;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-title {
        color: var(--text-secondary);
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
    }

    label {
        color: var(--text-primary);
        font-size: 0.875rem;
        font-weight: 500;
    }

    select, input {
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--text-primary);
        padding: 0.75rem;
        border-radius: 0.5rem;
        width: 100%;
        transition: border-color 0.3s ease;
    }

    select:focus, input:focus {
        outline: none;
        border-color: var(--text-secondary);
    }

    .amount-input-wrapper {
        position: relative;
    }

    .currency-symbol {
        position: absolute;
        left: 0rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-primary);
    }

    input[type="number"] {
        padding-left: 2rem;
    }

    .hidden-input {
        display: none;
    }

    /* Button Styling */
    .submit-btn {
        background-color: var(--text-secondary);
        color: var(--bg-primary);
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        font-weight: 500;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        background-color: var(--button-hover);
        transform: translateY(-1px);
    }

    .submit-btn:disabled {
        background-color: #888888;
        cursor: not-allowed;
    }

    /* Loader Styling */
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

    .loader-overlay.loader-active {
        display: flex;
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

    /* Animations */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeIn 0.5s ease forwards;
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 640px) {
        .content-section {
            padding: 1rem;
        }

        .balance-amount {
            font-size: 1.5rem;
        }
    }
</style>

<script>
    let selectedCategory = '';
    let selectedDescription = '';
    let enteredFullName = '';
    let Amount;
    let PaymentMethod = '';

    window.onload = function() {
        const expenseForm = document.getElementById("expense-form");
        setTimeout(() => {
            expenseForm.classList.add('active');
        }, 10);
    }

    function updateExpenseDescriptions() {
        const categorySelect = document.getElementById("expense-category");
        const descriptionSelect = document.getElementById("expense-description");
        const otherDescriptionInput = document.getElementById("other-description");
        const fullNameContainer = document.getElementById("full-name-container") || createFullNameContainer();

        selectedCategory = categorySelect.value;

        descriptionSelect.innerHTML = '<option value="">Select Description</option>';
        otherDescriptionInput.style.display = "none";

        if (selectedCategory === "2") {
            fullNameContainer.style.display = "block";
            const fullNameInput = document.getElementById("full-name");
            fullNameInput.required = true;
        } else {
            fullNameContainer.style.display = "none";
            const fullNameInput = document.getElementById("full-name");
            if (fullNameInput) {
                fullNameInput.required = false;
            }
        }

        let descriptions = [];
        switch (selectedCategory) {
            case "1":
                descriptions = ["Rent", "Service Charge", "Other"];
                break;
            case "2":
                descriptions = ["Doctor", "Nurse", "Nurse Aid", "Speech Therapist", "Occupational Therapist",
                    "Physiotherapist", "Psychologist", "Nutritionist", "Therapy Assistant", "Accountant",
                    "Administrator", "Receptionist", "Errand boy", "Cleaner", "Accountant", "Other"
                ];
                break;
            case "3":
                descriptions = ["KMPDB Annual retention(Dr Oringe)", "KMPBD clinic annual registration",
                    "Association of Speech Therapists", "Physiotherapy Counsel of Kenya",
                    "Kenya Occupational Therapy Assosciation", "Kenya Health Professionals Authority",
                    "Medical Waste disposal", "Business Permit", "Public Health Lisence", "Single business permit",
                    "Public health Permit", "Solid waste disposal", "Other"
                ];
                break;
            case "4":
                descriptions = ["Beacon facility indemnity", "Fire cover", " Buglary",
                    "Professional indemnity(Dr.Oringe)", "Other"
                ];
                break;
            case "5":
                descriptions = ["Software development", "Hardware purchase", "Technical support",
                    "Database hosting subscription", "Internet Service Providers", "Other"
                ];
                break;
            case "6":
                descriptions = ["Trainings", "Workshops/Seminars", "Journal subscriptions", "E-book subscriptions",
                    "Conferences", "Newspapers/Editorials", "Other"
                ];
                break;
            case "7":
                descriptions = ["Online marketing", "Webinars", "Meeting costs", "Banners", "Marketing tools",
                    "Branding", "Other"
                ];
                break;
            case "8":
                descriptions = ["Fuel costs", "Car Hire", "Uber/Bolt", "Rider charges", "Other"];
                break;
            case "9":
                descriptions = ["Treadmill", "Standing bike", "Walking Frame", "Walking Support Bar", "Hammock swing",
                    "Mini step", "Therapy balls", "Trampoline", "Play pen", "Filler balls", "Massager", "Play toys",
                    "Weighted blanket", "Floor matts", "Gym matts", "Beam bag", "Therapy foam blocks",
                    "Therapy mirrors", "Therapy boards", "Therapy music system", "Other"
                ];
                break;
            case "10":
                descriptions = ["Office Tables", "Chairs", "Cabinets", "Beds", "Steps", "Other"];
                break;
            case "11":
                descriptions = ["Construction Work", "Plumbing repairs", "Electrical maintenance", "Painting work",
                    "Welders", "Capentery works", "Security services", "Other"
                ];
                break;
            case "12":
                descriptions = ["Electricity bills", "Medical waste disposal", "Internet provider", "Online Marketing",
                    "Photocopy/printing", "Airtime", "Deliveries", "Online Marketing", "Monthly staff meeting",
                    "Other"
                ];
                break;
            case "13":
                descriptions = ["Gloves", "Sanitizers", "Bleach and detergents", "Wooden spatulas",
                    "Sugar and tea/coffee", "Drinking mineral water", "Cleaning materials", "Stationary", "Other"
                ];
                break;
            case "14":
                descriptions = ["Conference attendance/CME", "Newspaper", "Journals and e-subscriptions",
                    "Rider charges", "Fuel", "Other"
                ];
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

        descriptionSelect.addEventListener("change", () => {
            selectedDescription = descriptionSelect.value;
            if (selectedDescription === "other") {
                otherDescriptionInput.style.display = "block";
                otherDescriptionInput.addEventListener("input", () => {
                    selectedDescription = otherDescriptionInput.value;
                });
            } else {
                otherDescriptionInput.style.display = "none";
            }
        });
    }

    function createFullNameContainer() {
        const container = document.createElement("div");
        container.id = "full-name-container";
        container.style.display = "none";

        const label = document.createElement("label");
        label.htmlFor = "full-name";
        label.textContent = "Full Name:";

        const input = document.createElement("input");
        input.type = "text";
        input.id = "full-name";
        input.name = "full-name";
        input.required = true;

        input.addEventListener("input", () => {
            enteredFullName = input.value;
        });

        container.appendChild(label);
        container.appendChild(input);

        const expenseDescription = document.getElementById("expense-description");
        expenseDescription.parentNode.insertBefore(container, expenseDescription.nextSibling);

        return container;
    }

    const categoryMapping = {
        "1": "Rent and service charge",
        "2": "Salaries/wages",
        "3": "Licences and permits",
        "4": "Insurance",
        "5": "ICT needs",
        "6": "Continuous Professional Development",
        "7": "Marketing and Advertising",
        "8": "Transport and Delivery",
        "9": "Therapy Equipment",
        "10": "Furniture",
        "11": "Office repairs and maintenance",
        "12": "Monthly utility bills",
        "13": "Consumables",
        "14": "Other charges"
    };

    async function showValues() {
    // Get the submit button
    const submitButton = document.querySelector('button[onclick*="showValues"]');
    
    // Disable the button and change appearance
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.style.backgroundColor = '#888888'; // Change to gray color
        submitButton.style.cursor = 'not-allowed';
        submitButton.textContent = 'Processing...'; // Optional: change text to show it's processing
    }
    
    // Show loader
    const loaderOverlay = document.querySelector('.loader-overlay');
    loaderOverlay.classList.add('loader-active');
    const Amount = document.getElementById("expense-amount").value;
    const PaymentMethod = document.getElementById("payment-method").value;
    const categoryName = categoryMapping[selectedCategory] || selectedCategory;
    try {
        const response = await fetch('/AddExpense', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                category: categoryName,
                description: selectedDescription,
                fullname: enteredFullName,
                amount: Amount,
                payment_method: PaymentMethod
            })
        });
        const result = await response.json();
        if (response.ok && result.status === 'success') {
            // Optional: Show success state before redirect
            if (submitButton) {
                submitButton.style.backgroundColor = '#4CAF50'; // Green for success
                submitButton.textContent = 'Success!';
            }
            
            alert(result.message);
            // Hide loader
            loaderOverlay.classList.remove('loader-active');
            // Refresh the page
            window.location.reload();
        } else {
            throw new Error(result.message || 'Failed to save notes');
        }
    } catch (error) {
        console.error('Error:', error);
        alert(`Error: ${error.message}`);
        // Hide loader in case of error
        loaderOverlay.classList.remove('loader-active');
        
        // Reset button style and re-enable it in case of error
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.style.backgroundColor = ''; // Reset to default color
            submitButton.style.cursor = 'pointer';
            submitButton.textContent = 'Add Expense'; // Reset text
        }
    }
}

    // Optional: Add theme toggle functionality
    document.getElementById('theme-toggle')?.addEventListener('click', function() {
        document.documentElement.classList.toggle('dark');
    });
    </script>

        </div> <!-- End Root Element -->
</x-filament::page>

