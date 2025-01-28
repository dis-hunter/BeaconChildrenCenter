// Sample data for charts (replace with actual data later)
const patientData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [{
        label: 'Patients',
        data: [50, 60, 75, 65, 80, 90],
        borderColor: 'rgba(75, 192, 192, 1)',
        fill: false
    }]
};

const financeData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [{
        label: 'Revenue',
        data: [1000, 1200, 1500, 1300, 1700, 2000],
        borderColor: 'rgba(54, 162, 235, 1)',
        fill: false
    },
    {
        label: 'Expenses',
        data: [500, 600, 700, 600, 800, 900],
        borderColor: 'rgba(255, 99, 132, 1)',
        fill: false
    }]
};

// Chart initialization
const patientChart = new Chart(document.getElementById('patientChart'), {
    type: 'line',
    data: patientData
});

const financeChart = new Chart(document.getElementById('financeChart'), {
    type: 'line',
    data: financeData
});

// Add this JavaScript code to handle the navigation
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('nav a');
    const contentSections = document.querySelectorAll('.content-section');

    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior

            // Hide all content sections
            contentSections.forEach(section => {
                section.classList.remove('active');
            });

            // Show the clicked section
            const sectionId = this.getAttribute('href');
            const sectionToShow = document.querySelector(sectionId);
            sectionToShow.classList.add('active');

            // Remove active class from all links
            navLinks.forEach(navLink => {
                navLink.classList.remove('active');
            });

            // Add active class to the clicked link
            this.classList.add('active');
        });
    });

    // Show the dashboard section by default
    document.getElementById('dashboard').classList.add('active');
});
// ... (other JavaScript code) ...


document.addEventListener('DOMContentLoaded', function () {
    fetch('/age-distribution')
        .then(response => response.json())
        .then(data => {
            const ages = data.map(item => item.age);
            const counts = data.map(item => item.count);

            const ctx = document.getElementById('ageDistributionChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ages,
                    datasets: [{
                        label: 'Number of Children',
                        data: counts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching age distribution:', error));
});

function showDemographics() {
    const analyticsContent = document.getElementById('analytics-content');
    analyticsContent.innerHTML = `
       <h3>Patient Demographics</h3>
        <div class="demographics-charts"> <div class="demographics-chart">
                <canvas id="ageChart"></canvas>
            </div>
            <div class="demographics-chart">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    `;

    // Sample data for the charts
    const ageData = {
        labels: ['0-5', '6-12', '13-18', '19+'],
        datasets: [{
            data: [30, 45, 20, 5],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
        }]
    };

    const genderData = {
        labels: ['Male', 'Female'],
        datasets: [{
            data: [120, 100],
            backgroundColor: ['#36A2EB', '#FF6384']
        }]
    };

    // Chart initialization
    new Chart(document.getElementById('ageChart'), {
        type: 'pie',
        data: ageData
    });

    new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: genderData
    });
}

function showDiseaseStats() {
    // TODO: Implement disease statistics content
    const analyticsContent = document.getElementById('analytics-content');
    analyticsContent.innerHTML = `
        <h3>Disease Statistics</h3>
        <p>Content for disease statistics will be displayed here.</p>
    `;
}

function showCustomReport() {
    // TODO: Implement custom report content
    const analyticsContent = document.getElementById('analytics-content');
    analyticsContent.innerHTML = `
        <h3>Custom Report</h3>
        <p>Content for custom report will be displayed here.</p>
    `;
}
function showDiseaseStats() {
    const analyticsContent = document.getElementById('analytics-content');
    analyticsContent.innerHTML = `
        <h3>Disease Statistics</h3>
        <div class="demographics-chart">
            <canvas id="diseaseChart"></canvas>
        </div>
        <table id="disease-table">
            <thead>
                <tr>
                    <th>Disease</th>
                    <th>Number of Cases</th>
                    <th>Prevalence (%)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Asthma</td>
                    <td>45</td>
                    <td>12.5%</td>
                </tr>
                <tr>
                    <td>Common Cold</td>
                    <td>120</td>
                    <td>33.5%</td>
                </tr>
                <tr>
                    <td>Flu</td>
                    <td>60</td>
                    <td>16.8%</td>
                </tr>
                </tbody>
        </table>
    `;

    // Sample data for the chart
    const diseaseData = {
        labels: ['Asthma', 'Common Cold', 'Flu', 'Other'],
        datasets: [{
            data: [45, 120, 60, 33],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
        }]
    };

    // Chart initialization
    new Chart(document.getElementById('diseaseChart'), {
        type: 'pie',
        data: diseaseData
    });
}

function showCustomReport() {
    const analyticsContent = document.getElementById('analytics-content');
    analyticsContent.innerHTML = `
        <h3>Custom Report</h3>
        <p>Select parameters to generate a custom report:</p>
        <form id="custom-report-form">
            <label for="date-range">Date Range:</label>
            <input type="date" id="start-date" name="start-date">
            to
            <input type="date" id="end-date" name="end-date">
            <br><br>
            <label for="report-type">Report Type:</label>
            <select id="report-type" name="report-type">
                <option value="patient-summary">Patient Summary</option>
                <option value="financial-breakdown">Financial Breakdown</option>
                <option value="expenses-breakdown">Expenses Breakdown</option> 
                <option value="staff-performance">Staff Performance</option>
            </select>
            <br><br>
            <input type="submit" value="Generate Report">
        </form>
        <div id="report-output"></div>
    `;

    const form = document.getElementById('custom-report-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting normally

        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        const reportType = document.getElementById('report-type').value;

        // Generate the report based on selected parameters
        const reportOutput = document.getElementById('report-output');
        switch (reportType) {
            case 'patient-summary':
                reportOutput.innerHTML = generatePatientSummaryReport(startDate, endDate);
                break;
            case 'financial-breakdown':
                reportOutput.innerHTML = generateFinancialBreakdownReport(startDate, endDate);
                break;
            case 'expenses-breakdown': // Handle Expenses Breakdown report
                reportOutput.innerHTML = generateExpensesBreakdownReport(startDate, endDate);
                break;
            case 'staff-performance':
                reportOutput.innerHTML = generateStaffPerformanceReport(startDate, endDate);
                break;
        }
    });
}
function generateExpensesBreakdownReport(startDate, endDate) {
    // TODO: Replace with actual report generation logic
    return `
        <h4>Expenses Breakdown Report</h4>
        <p>Date Range: ${startDate} to ${endDate}</p>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Salaries</td>
                    <td>Staff salaries for January</td>
                    <td>$5,000</td>
                </tr>
                <tr>
                    <td>Rent</td>
                    <td>Monthly rent for clinic space</td>
                    <td>$2,000</td>
                </tr>
                <tr>
                    <td>Supplies</td>
                    <td>Medical supplies and equipment</td>
                    <td>$1,500</td>
                </tr>
                </tbody>
        </table>
        <p><strong>Total Expenses: $8,500</strong></p>
    `;
}

function generatePatientSummaryReport(startDate, endDate) {
    // TODO: Replace with actual report generation logic
    return `
        <h4>Patient Summary Report</h4>
        <p>Date Range: ${startDate} to ${endDate}</p>
        <table id="patient-summary-table">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Diagnosis</th>
                    <th>Treatment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jane Doe</td>
                    <td>8</td>
                    <td>Asthma</td>
                    <td>Inhaler, Medication</td>
                </tr>
                <tr>
                    <td>Peter Pan</td>
                    <td>10</td>
                    <td>Common Cold</td>
                    <td>Rest, Fluids</td>
                </tr>
                </tbody>
        </table>
    `;
}

function generateFinancialBreakdownReport(startDate, endDate) {
    // TODO: Replace with actual report generation logic
    return `
        <h4>Financial Breakdown Report</h4>
        <p>Date Range: ${startDate} to ${endDate}</p>
        <p>Total Revenue: $10,000</p>
        <p>Total Expenses: $6,000</p>
        <p>Net Income: $4,000</p>
    `;
}

function generateStaffPerformanceReport(startDate, endDate) {
    // TODO: Replace with actual report generation logic
    return `
        <h4>Staff Performance Report</h4>
        <p>Date Range: ${startDate} to ${endDate}</p>
        <p>Dr. Emily Smith: 10 consultations, 5 surgeries</p>
        <p>Nurse Alice Johnson: 20 patient visits, 10 assists</p>
    `;
}
function generateRevenueReport() {
    const financesContent = document.getElementById('finances-content');
    financesContent.innerHTML = `
        <h4>Revenue Report</h4>
        <table id="revenue-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2024-01-05</td>
                    <td>Consultation Fee</td>
                    <td>$150</td>
                </tr>
                <tr>
                    <td>2024-01-05</td>
                    <td>Therapy Session</td>
                    <td>$100</td>
                </tr>
                <tr>
                    <td>2024-01-06</td>
                    <td>Medication</td>
                    <td>$50</td>
                </tr>
                </tbody>
        </table>
    `;
}

function viewExpenseBreakdown() {
    const financesContent = document.getElementById('finances-content');
    financesContent.innerHTML = `
        <h4>Expense Breakdown</h4>
        <table id="expense-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Salaries</td>
                    <td>$5,000</td>
                </tr>
                <tr>
                    <td>Rent</td>
                    <td>$2,000</td>
                </tr>
                <tr>
                    <td>Supplies</td>
                    <td>$1,000</td>
                </tr>
                </tbody>
        </table>
    `;
}

// Add event listeners to the buttons in the Finances section
document.addEventListener('DOMContentLoaded', function() {
    // ... (other event listeners) ...

    const generateRevenueBtn = document.getElementById('generate-revenue-btn');
    generateRevenueBtn.addEventListener('click', generateRevenueReport);

    const viewExpensesBtn = document.getElementById('view-expenses-btn');
    viewExpensesBtn.addEventListener('click', viewExpenseBreakdown);
});



  function generateInvoice(patientName, clinicNumber) {
    const selectedDate = document.getElementById(`invoice-date-${patientName}`).value;
  const invoiceOutput = document.getElementById('invoice-output');

  // Instead of clearing the entire invoiceOutput, just clear the invoice details
  const invoiceDetailsDiv = invoiceOutput.querySelector('div:not([id])'); // Select the div without an ID
  if (invoiceDetailsDiv) {
    invoiceDetailsDiv.remove(); // Remove only the invoice details
  }

  const patientInvoices = invoices.filter(invoice => invoice.patient === patientName);
  const invoice = patientInvoices.find(invoice => invoice.date === selectedDate);

  if (invoice) {
    const invoiceDetails = document.createElement('div'); // Create a div to hold the invoice details
    invoiceDetails.innerHTML = `
            <h3>Invoice for ${patientName} (Clinic No. ${clinicNumber})</h3>
            <p>Date: ${invoice.date}</p>
            <p>Invoice ID: ${invoice.invoiceId}</p>
            <p>Amount: $${invoice.amount}</p>
            <p>Status: ${invoice.status}</p>
            <p>Payment Method: ${invoice.paymentMethod}</p>
            <button onclick="showInvoiceDetails('${invoice.invoiceId}')">View Details</button>
        `;
    invoiceOutput.appendChild(invoiceDetails); // Append the invoice details to the output
  } else {
    const noInvoiceMessage = document.createElement('div'); // Create a div for the message
    noInvoiceMessage.innerHTML = "<p>No invoice found for this date.</p>";
    invoiceOutput.appendChild(noInvoiceMessage); // Append the message to the output
  }
}

  
  

  
  // Function to display invoice details when a date is selected
  function generateInvoice(patientName, clinicNumber) {
    const selectedDate = document.getElementById(`invoice-date-${patientName}`).value;
    const invoiceOutput = document.getElementById('invoice-output');
  
    // Instead of clearing the entire invoiceOutput, just clear the invoice details
    const invoiceDetailsDiv = invoiceOutput.querySelector('div:not([id])'); // Select the div without an ID
    if (invoiceDetailsDiv) {
      invoiceDetailsDiv.remove(); // Remove only the invoice details
    }
  
    const patientInvoices = invoices.filter(invoice => invoice.patient === patientName);
    const invoice = patientInvoices.find(invoice => invoice.date === selectedDate);
  
    if (invoice) {
      const invoiceDetails = document.createElement('div'); // Create a div to hold the invoice details
      invoiceDetails.innerHTML = `
              <h3>Invoice for ${patientName} (Clinic No. ${clinicNumber})</h3>
              <p>Date: ${invoice.date}</p>
              <p>Invoice ID: ${invoice.invoiceId}</p>
              <p>Amount: $${invoice.amount}</p>
              <p>Status: ${invoice.status}</p>
              <p>Payment Method: ${invoice.paymentMethod}</p>
              <button onclick="showInvoiceDetails('${invoice.invoiceId}')">View Details</button>
          `;
      invoiceOutput.appendChild(invoiceDetails); // Append the invoice details to the output
    } else {
      const noInvoiceMessage = document.createElement('div'); // Create a div for the message
      noInvoiceMessage.innerHTML = "<p>No invoice found for this date.</p>";
      invoiceOutput.appendChild(noInvoiceMessage); // Append the message to the output
    }
  }
  
  // Dynamic version for fetching invoice dates from the server
  function showInvoiceDates(childId) {
    console.log('Fetching invoice dates for child:', childId); // Debug log
    
    fetch(`/get-invoice-dates/${childId}`)
        .then(response => {
            console.log('Response status:', response.status); // Debug log
            
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.error || 'Server error');
                });
            }
            return response.json();
        })
        .then(dates => {
            console.log('Received dates:', dates); // Debug log
            const invoiceOutput = document.getElementById('invoice-output');
            
            if (!dates || dates.length === 0) {
                invoiceOutput.innerHTML = '<div class="alert alert-info">No invoices found for this child.</div>';
                return;
            }

            let html = `
                <div id="dates-container-${childId}">
                    <label for="invoice-date-${childId}">Select Invoice Date:</label>
                    <select id="invoice-date-${childId}" class="form-control">
                        ${dates.map(date => 
                            `<option value="${date}">${date}</option>`
                        ).join('')}
                    </select>
                    <button class="btn btn-primary mt-2" onclick="showInvoiceDetails(${childId})">
                        View Invoice Details
                    </button>
                </div>
            `;
            
            invoiceOutput.innerHTML = html;
        })
        .catch(error => {
            console.error('Error details:', error);
            document.getElementById('invoice-output').innerHTML = 
                `<div class="alert alert-danger">Error: ${error.message}</div>`;
        });
}

function showInvoiceDetails(childId) {
    const selectedDate = document.getElementById(`invoice-date-${childId}`).value;
    
    fetch(`/get-invoice-details/${childId}?date=${selectedDate}`)
        .then(response => response.json())
        .then(invoice => {
            const invoiceOutput = document.getElementById('invoice-output');
            const detailsDiv = document.createElement('div');
            
            if (invoice && !invoice.error) {
                detailsDiv.innerHTML = `
                    <div class="invoice-details mt-4">
                        <h3>Invoice Details</h3>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Date:</strong> ${new Date(invoice.invoice_date).toLocaleDateString()}</p>
                                <p><strong>Total Amount:</strong> $${invoice.total_amount.toFixed(2)}</p>
                                <p><strong>Details:</strong> ${invoice.invoice_details}</p>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                detailsDiv.innerHTML = '<div class="alert alert-warning">No invoice details found for this date.</div>';
            }
            
            // Remove any existing invoice details
            const existingDetails = invoiceOutput.querySelector('.invoice-details');
            if (existingDetails) {
                existingDetails.remove();
            }
            
            invoiceOutput.appendChild(detailsDiv);
        })
        .catch(error => {
            console.error('Error:', error);
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger mt-3';
            errorDiv.textContent = 'Error loading invoice details. Please try again.';
            document.getElementById('invoice-output').appendChild(errorDiv);
        });
}
  
  // Helper function to create the invoice date dropdown
  function createInvoiceDropdown(invoices, childId) {
    const dateSelect = document.createElement('select');
    dateSelect.id = `invoice-date-${childId}`;
    dateSelect.onchange = () => generateInvoice(childId);
  
    // Add the "Select a date" option
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = 'Select a date';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    dateSelect.appendChild(defaultOption);
  
    // Populate the dropdown with invoice dates
    invoices.forEach(invoice => {
      const option = document.createElement('option');
      option.value = invoice.invoice_date; // Assuming 'invoice_date' is the key for the date
      option.text = invoice.invoice_date;
      dateSelect.appendChild(option);
    });
  
    return dateSelect;
  }
  
  // Helper function to create the 'Generate Invoice' button
  function createGenerateButton(childId) {
    const generateButton = document.createElement('button');
    generateButton.textContent = 'Generate Invoice';
    generateButton.onclick = () => generateInvoice(childId);
    return generateButton;
  }
  
  // Function to fetch invoice details based on the selected date (also modified for dynamic data)
  function generateInvoice(childId) {
    const selectedDate = document.getElementById(`invoice-date-${childId}`).value;
    const invoiceOutput = document.getElementById('invoice-output');
  
    fetch(`/get-invoice-details/${childId}?date=${selectedDate}`)
      .then(response => response.json())
      .then(invoice => {
        // Clear previous invoice details
        invoiceOutput.innerHTML = '';
  
        if (invoice) {
          const invoiceDetails = document.createElement('div');
          invoiceDetails.innerHTML = `
              <h3>Invoice Details</h3>
              <p>Date: ${invoice.invoice_date}</p>
              <p>Invoice ID: ${invoice.id}</p>
              <p>Amount: $${invoice.total_amount}</p>
              <p>Status: ${invoice.status}</p>
              <p>Payment Method: ${invoice.payment_method}</p>
          `;
          invoiceOutput.appendChild(invoiceDetails);
        } else {
          invoiceOutput.innerHTML = '<p>No invoice found for the selected date.</p>';
        }
      })
      .catch(error => {
        console.error('Error fetching invoice details:', error);
        invoiceOutput.innerHTML = '<p>An error occurred while fetching invoice details.</p>';
      });
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
