<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    :root {
        /* Light mode colors */
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
        /* Dark mode colors */
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

    h2,
    h3,
    h4 {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }

    h2 {
        font-size: 2rem;
    }

    h3 {
        font-size: 1.5rem;
    }

    h4 {
        font-size: 1.25rem;
    }


    


    #expense-tracking button {
        background-color: transparent;
        border: 2px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
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

    label {
        display: block;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    select,
    input {
        width: 100%;
        padding: 0.75rem;
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        border-radius: 0.375rem;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    select:focus,
    input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(196, 168, 98, 0.3);
        border-color: var(--text-secondary);
    }

    #full-name-container {
        margin: 1rem 0;
    }

    /* Ensure Full Name and Amount fields have black text */
    #full-name,
    #expense-amount {
        color: black;
    }

    /* Animation classes */
    .fade-in {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .fade-in.active {
        opacity: 1;
    }

    /* Ensure placeholder text color is black */
    input::placeholder {
        color: var(--text-primary);
    }
    </style>
</head>

<body>
    <x-filament::page>


        <section id="finances" class="content-section">

            <h3>Add Expense Below</h3>
            <div id="expense-tracking">
                <button onclick="showExpenseForm()">Add Expense</button>
                <div id="expense-form" style="display: none;" class="fade-in">
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
    </x-filament::page>

    <script>
    let selectedCategory = '';
    let selectedDescription = '';
    let enteredFullName = '';
    let Amount;
    let PaymentMethod = '';

    function showExpenseForm() {
        const expenseForm = document.getElementById("expense-form");
        if (expenseForm.style.display === "none") {
            expenseForm.style.display = "block";
            // Add small delay to trigger fade in
            setTimeout(() => {
                expenseForm.classList.add('active');
            }, 10);
        } else {
            expenseForm.classList.remove('active');
            // Wait for fade out before hiding
            setTimeout(() => {
                expenseForm.style.display = "none";
            }, 300);
        }
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

        let descriptions = []; // Your existing descriptions array stays the same
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
                alert(result.message);
            } else {
                throw new Error(result.message || 'Failed to save notes');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(`Error: ${error.message}`);
        }
    }

    // Optional: Add theme toggle functionality
    document.getElementById('theme-toggle').addEventListener('click', function() {
        document.documentElement.classList.toggle('dark');
    });
    </script>
</body>

</html>