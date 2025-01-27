<!DOCTYPE html>
<html>

<head>
    <style>
    :root {
        --navy-blue: #1B2433;
        --gold: #C4A862;
    }

    body {
        background-color: var(--navy-blue);
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .content-section {
        padding: 2rem;
    }

    h2 {
        color: var(--gold);
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }

    h3 {
        color: var(--gold);
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    #expense-tracking button {
        background-color: transparent;
        border: 2px solid var(--gold);
        color: var(--gold);
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #expense-tracking button:hover {
        background-color: var(--gold);
        color: var(--navy-blue);
    }

    #expense-form {
        background-color: rgba(27, 36, 51, 0.9);
        border: 1px solid var(--gold);
        border-radius: 0.5rem;
        padding: 2rem;
        margin-top: 1.5rem;
        backdrop-filter: blur(8px);
        transition: opacity 0.3s ease-in-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #expense-form h4 {
        color: var(--gold);
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        color: var(--gold);
        margin-bottom: 0.5rem;
    }

    select,
    input {
        width: 100%;
        padding: 0.75rem;
        background-color: var(--navy-blue);
        border: 1px solid var(--gold);
        border-radius: 0.375rem;
        color: #fff;
        margin-bottom: 1rem;
    }

    select:focus,
    input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(196, 168, 98, 0.5);
    }

    #full-name-container {
        margin-top: 1rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    th,
    td {
        padding: 0.75rem;
        border: 1px solid var(--gold);
        color: #fff;
    }

    th {
        background-color: rgba(196, 168, 98, 0.2);
        color: var(--gold);
    }
    </style>
</head>

<body>
    <x-filament::page>
        <section id="finances" class="content-section">
            <h2>Finances</h2>

            <h3>Expense Tracking</h3>
            <div id="expense-tracking">
                <button onclick="showExpenseForm()">Add Expense</button>
                <div id="expense-form" style="display: none;">
                    <h4>Add New Expense</h4>
                    <form id="new-expense-form">
                        <div class="form-group">
                            <label for="expense-category">Category:</label>
                            <select id="expense-category" name="expense-category"
                                onchange="updateExpenseDescriptions()">
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
                            <input type="text" id="other-description" name="other-description" style="display: none;"
                                placeholder="Enter other description">
                        </div>

                        <div class="form-group">
                            <label for="expense-amount">Amount:</label>
                            <input type="number" id="expense-amount" name="expense-amount" required>
                        </div>

                        <div class="form-group">
                            <label for="payment-method">Payment Method:</label>
                            <select id="payment-method" name="payment-method">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>

                        <button type="submit">Add Expense</button>
                    </form>
                </div>
            </div>
        </section>
    </x-filament::page>

    <script>
    function showExpenseForm() {
        const expenseForm = document.getElementById("expense-form");
        if (expenseForm.style.display === "none") {
            expenseForm.style.opacity = "0";
            expenseForm.style.display = "block";
            setTimeout(() => {
                expenseForm.style.opacity = "1";
            }, 10);
        } else {
            expenseForm.style.opacity = "0";
            setTimeout(() => {
                expenseForm.style.display = "none";
            }, 300);
        }
    }

    function updateExpenseDescriptions() {
        const category = document.getElementById("expense-category").value;
        const descriptionSelect = document.getElementById("expense-description");
        const otherDescriptionInput = document.getElementById("other-description");
        const fullNameContainer = document.getElementById("full-name-container") || createFullNameContainer();

        descriptionSelect.innerHTML = '<option value="">Select Description</option>';
        otherDescriptionInput.style.display = "none";

        fullNameContainer.style.display = category === "2" ? "block" : "none";

        let descriptions = [];
        switch (category) {
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
                descriptions = ["Software development", "Hardware purchase", "Techincal support",
                    "Database hosting subscription", "Internet Service Providers", "Other"
                ];
                break;
            case "6":
                descriptions = ["Trainings", "Workshops/Seminars", "Journal subscriptions", "E-book subscriptions",
                    "Conferences", "Newspapers/Editorials", "Other"
                ];
                break;
            case "7":
                descriptions = ["Online marketting", "Webinars", "Meeting costs", "Banners", "Marketting tools",
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
            if (descriptionSelect.value === "other") {
                otherDescriptionInput.style.display = "block";
            } else {
                otherDescriptionInput.style.display = "none";
            }
        });
    }

    function createFullNameContainer() {
        const container = document.createElement("div");
        container.id = "full-name-container";
        container.style.display = "none";
        container.className = "form-group";

        const label = document.createElement("label");
        label.htmlFor = "full-name";
        label.textContent = "Full Name:";

        const input = document.createElement("input");
        input.type = "text";
        input.id = "full-name";
        input.name = "full-name";
        input.required = true;

        container.appendChild(label);
        container.appendChild(input);

        const expenseDescription = document.getElementById("expense-description");
        expenseDescription.parentNode.insertBefore(container, expenseDescription.nextSibling);

        return container;
    }

    // Add form submission handler
    document.getElementById("new-expense-form").addEventListener("submit", function(e) {
        e.preventDefault();
        // Add your form submission logic here
    });
    </script>
</body>

</html>