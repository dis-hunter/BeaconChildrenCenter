<x-filament::page>
    <section id="finances" class="content-section">
        <h2>Finances</h2>

       
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

                </form>
                <button  onclick="showValues() ">Add Expense</button>

            </div>
        </div>
    </section>

    <script >
      
      let selectedCategory = '';
let selectedDescription = '';
let enteredFullName = '';
let Amount;
let PaymentMethod='';

function showExpenseForm() {
    const expenseForm = document.getElementById("expense-form");
    if (expenseForm.style.display === "none") {
        expenseForm.style.display = "block";
    } else {
        expenseForm.style.display = "none";
    }
}

function updateExpenseDescriptions() {
    const categorySelect = document.getElementById("expense-category");
    const descriptionSelect = document.getElementById("expense-description");
    const otherDescriptionInput = document.getElementById("other-description");
    const fullNameContainer = document.getElementById("full-name-container") || createFullNameContainer();
    
    // Store the selected category
    selectedCategory = categorySelect.value;
    
    descriptionSelect.innerHTML = '<option value="">Select Description</option>';
    otherDescriptionInput.style.display = "none";
    
    // Show/hide full name input based on category
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
            descriptions = ["Doctor","Nurse","Nurse Aid","Speech Therapist","Occupational Therapist","Physiotherapist","Psychologist","Nutritionist","Therapy Assistant","Accountant","Administrator","Receptionist", "Errand boy", "Cleaner", "Accountant", "Other"];
            break;
        case "3":
            descriptions = ["KMPDB Annual retention(Dr Oringe)", "KMPBD clinic annual registration","Association of Speech Therapists","Physiotherapy Counsel of Kenya","Kenya Occupational Therapy Assosciation","Kenya Health Professionals Authority", "Medical Waste disposal","Business Permit","Public Health Lisence", "Single business permit", "Public health Permit", "Solid waste disposal", "Other"];
            break;
        case "4":
            descriptions = ["Beacon facility indemnity", "Fire cover"," Buglary","Professional indemnity(Dr.Oringe)","Other"];
            break;
        case "5":
            descriptions = ["Software development","Hardware purchase", "Techincal support", "Database hosting subscription", "Internet Service Providers","Other"];
            break;
        case "6":
            descriptions = ["Trainings","Workshops/Seminars", "Journal subscriptions", "E-book subscriptions", "Conferences", "Newspapers/Editorials", "Other"];
            break;
        case "7":
            descriptions = ["Online marketting","Webinars", "Meeting costs", "Banners", "Marketting tools", "Branding", "Other"];
            break;
        case "8":
            descriptions = ["Fuel costs", "Car Hire", "Uber/Bolt", "Rider charges", "Other"];
            break;
        case "9":
            descriptions = ["Treadmill", "Standing bike", "Walking Frame", "Walking Support Bar","Hammock swing","Mini step","Therapy balls","Trampoline","Play pen","Filler balls","Massager","Play toys","Weighted blanket","Floor matts","Gym matts","Beam bag","Therapy foam blocks","Therapy mirrors","Therapy boards","Therapy music system","Other"];
            break;
        case "10":
            descriptions = ["Office Tables","Chairs", "Cabinets", "Beds", "Steps", "Other"];
            break;
        case "11":
            descriptions = ["Construction Work","Plumbing repairs", "Electrical maintenance", "Painting work", "Welders", "Capentery works","Security services", "Other"];
            break;
        case "12":
            descriptions = ["Electricity bills", "Medical waste disposal", "Internet provider", "Online Marketing", "Photocopy/printing","Airtime","Deliveries","Online Marketing","Monthly staff meeting", "Other"];
            break;
        case "13":
            descriptions = ["Gloves", "Sanitizers", "Bleach and detergents", "Wooden spatulas", "Sugar and tea/coffee", "Drinking mineral water", "Cleaning materials", "Stationary", "Other"];
            break;
        case "14":
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

    // Add event listener for description changes
    descriptionSelect.addEventListener("change", () => {
        selectedDescription = descriptionSelect.value;
        if (selectedDescription === "other") {
            otherDescriptionInput.style.display = "block";
            // Update selectedDescription when "other" description is entered
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
    
    // Add event listener for full name changes
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
    
    // Get the category name from the mapping
    const categoryName = categoryMapping[selectedCategory] || selectedCategory;
    
    // Log the values with category name instead of number
    console.log(
        "Category:", categoryName,
        "Description:", selectedDescription,
        "Full Name:", enteredFullName || "N/A",
        "Amount:", Amount,
        "Payment Method:", PaymentMethod
    );
    try {
       
        // Save the doctor's notes
        const response = await fetch('/AddExpense', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
              category: categoryName,
        description: selectedDescription,
        fullname: enteredFullName ,
        amount: Amount,
        payment_method: PaymentMethod
            })
        });

        const result = await response.json();
        
        if (response.ok && result.status === 'success') {
            alert(result.message);
            // document.getElementById("new-expense-form").reset();
        } else {
            throw new Error(result.message || 'Failed to save notes');
        }

    } catch (error) {
        console.error('Error:', error);
        alert(`Error: ${error.message}`);
    }
    
}

    </script>
</x-filament::page>
