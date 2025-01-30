<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Hospital Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/beaconAdmin.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <header>
    <div class="logo">Beacon Children's Hospital</div>
    <div class="user-profile">
      <span>Welcome, Admin!</span>
      <img src="profile-icon.png" alt="Profile">
    </div>
  </header>

  <nav>
    <ul>
      <li><a href="#dashboard" class="active">Dashboard</a></li>
      <li><a href="#patients">Patients</a></li>
      <li><a href="#staff">Staff</a></li>
      <li><a href="#finances">Finances</a></li>
      <li><a href="#resources">Resources</a></li>
      <li><a href="#analytics">Analytics</a></li>
      <li><a href="#admin">Admin</a></li>
    </ul>
  </nav>

  <main>
  <section id="dashboard" class="content-section">
            <h2>Dashboard</h2>
            <div class="metrics-row">
                <div class="metric">
                    <i class="fas fa-user-injured"></i>
                    <h4>Total Patients</h4>
                    <p>{{ $totalPatients }}</p>
                </div>
                <div class="metric">
                    <i class="fas fa-user-plus"></i>
                    <h4>New Registrations (Today)</h4>
                    <p>{{ $newRegistrations }}</p>
                </div>
                <div class="metric">
                    <i class="fas fa-chart-line"></i>
                    <h4>Occupancy Rate</h4>
                    <p>78%</p>
                </div>
            </div>
        </section>

        <section class="charts">
            <h2>Patient Demographics</h2>
            <div class="chart-row">
                <div class="chart">
              <h2>Gender Distribution</h2>
              <canvas id="genderDistributionChart"></canvas>
                </div>
                  <div class="chart">
                      <i class="fas fa-chart-bar"></i>
                      <h4>Age Distribution</h4>
                      <canvas id="ageDistributionChart" width="400" height="200"></canvas>
                  </div>
              </div>
        </section>
        
        <section class="charts">
            <h2>Visit Highlights</h2>
            <div class="chart-row">
                <div class="chart">
                    <h3>Most Common Visit Types</h3>
                    <canvas id="visitTypesChart"></canvas>
                </div>
                <div class="chart">
                    <h3>Patient Visits</h3>
                    <div class="chart-buttons">
                        <button onclick="updateVisitChart('weekly')">Weekly</button>
                        <button onclick="updateVisitChart('monthly')">Monthly</button>
                        <button onclick="updateVisitChart('annually')">Annually</button>
                    </div>
                    <div id="loadingVisit" class="loading-indicator">Loading...</div>
                    <canvas id="visitChart"></canvas>
                </div>
            </div>
        </section>
        
        <section class="charts">
            <h2>Finances</h2>
            <div class="chart-row">
                <div class="chart">
                    <h3>Financial Summary</h3>
                    <div class="chart-buttons">
                        <button onclick="updateFinanceChart('weekly')">Weekly</button>
                        <button onclick="updateFinanceChart('monthly')">Monthly</button>
                        <button onclick="updateFinanceChart('annually')">Annually</button>
                    </div>
                    <div id="loadingFinance" class="loading-indicator">Loading...</div>
                    <canvas id="financeChart"></canvas>
                </div>
                <div class="chart">
            <h2>Payment Methods Usage</h2>
            <canvas id="paymentMethodsChart" width="400" height="100"></canvas>
        </div>


            </div>

            
</section>


      <section class="todays-revenue">
        <h2>Today's Revenue</h2>
        <p>ksh : {{ number_format($todaysRevenue, 2) }}</p>
      </section>

      <!-- Staff Availability Section -->
      <section class="staff-management">
            <h2>Staff Availability</h2>
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $staffMember)
                    <tr>
                        <td>{{ $staffMember->full_name }}</td>
                        <td>{{ $staffMember->role }}</td>
                        <td>
                            @if($staffMember->status === 'Available')
                                Available
                            @elseif($staffMember->status === 'On Leave')
                                On Leave
                            @else
                                Unknown
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>


    </section>

    <section id="patients" class="content-section">
        <h2>Patients</h2>
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Age</th>
              <th>Sex</th>
              <th>Clinic Number</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>

    
@foreach ($children as $child)
<tr>
    <td>
        {{ $child->fullname->first_name ?? '' }}
        {{ $child->fullname->middle_name ?? '' }}
        {{ $child->fullname->last_name ?? '' }}
    </td>
    <td>{{ \Carbon\Carbon::parse($child->dob)->age }}</td>
    <td>{{ $child->gender->name ?? '' }}</td>
    <td>{{ $child->registration_number }}</td>
    <td><p>Status?</p></td>
    <td>
        <button onclick="showInvoiceDates('{{ $child->id }}')">See Invoices</button>
    </td>
</tr>
@endforeach


            </tr>
          </tbody>
        </table>
        <div id="invoice-output"></div>
      </section>

    <section id="staff" class="content-section">
      <h2>Staff</h2>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Department</th>
            <th>Contact</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Dr. Emily Smith</td>
            <td>Pediatrician</td>
            <td>General Medicine</td>
            <td>555-1234</td>
          </tr>
          <tr>
            <td>Nurse Alice Johnson</td>
            <td>Registered Nurse</td>
            <td>Emergency</td>
            <td>555-5678</td>
          </tr>
        </tbody>
      </table>
    </section>

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
  <div id="invoice-list">
    </div>
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
                <option value="7">Marketting and Advertising</option>
                <option value="8">Transport and Delivery</option>
                <option value="9">Therapy Equipment</option>
                <option value="10">Funiture</option>
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
        <h4>Expense List</h4>
        <table>
          <thead>
            <tr>
              <th>Category</th>
              <th>Description</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Payment Method</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Salaries</td>
              <td>Staff salaries for January</td>
              <td>2024-01-31</td>
              <td>$5,000</td>
              <td>Bank Transfer</td>
            </tr>
            <tr>
              <td>Rent</td>
              <td>Monthly rent for clinic space</td>
              <td>2024-01-15</td>
              <td>$2,000</td>
              <td>Bank Transfer</td>
            </tr>
          </tbody>
        </table>
      </div>

      <h3>Payment Tracking</h3>
      <div id="payment-tracking">
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Patient</th>
              <th>Service</th>
              <th>Amount</th>
              <th>Method</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>2024-01-05</td>
              <td>Jane Doe</td>
              <td>Consultation</td>
              <td>$150</td>
              <td>Cash</td>
            </tr>
            <tr>
              <td>2024-01-05</td>
              <td>Peter Pan</td>
              <td>Therapy</td>
              <td>$100</td>
              <td>Insurance</td>
            </tr>
          </tbody>
        </table>
      </div>

      <h3>Budgeting and Forecasting</h3>
      <div id="budgeting-forecasting">
        <h4>Set Budget</h4>
        <form id="budget-form">
          <label for="budget-category">Category:</label>
          <select id="budget-category" name="budget-category">
            <option value="salaries">Salaries</option>
            <option value="rent">Rent</option>
            <option value="supplies">Supplies</option>
            <option value="utilities">Utilities</option>
          </select><br><br>

          <label for="budget-amount">Amount:</label>
          <input type="number" id="budget-amount" name="budget-amount" required><br><br>

          <label for="budget-period">Period:</label>
          <select id="budget-period" name="budget-period">
            <option value="monthly">Monthly</option>
            <option value="quarterly">Quarterly</option>
            <option value="yearly">Yearly</option>
          </select><br><br>

          <button type="submit">Set Budget</button>
        </form>

        <h4>Forecasting</h4>
        <p>Projected Revenue (Next Month): $120,000</p>
        <p>Projected Expenses (Next Month): $75,000</p>
        <p>Projected Net Profit (Next Month): $45,000</p>
      </div>
    </section>

    <section id="resources" class="content-section">
      <h2>Resources</h2>
      <p>Bed Availability: 12 / 20</p>
      <p>Operating Room 1: Available</p>
      <p>Operating Room 2: In Use</p>
    </section>

    <section id="analytics" class="content-section">
      <h2>Analytics</h2>
      <div class="analytics-buttons">
        <button onclick="showDemographics()">Patient Demographics</button>
        <button onclick="showDiseaseStats()">Disease Statistics</button>
        <button onclick="showCustomReport()">Custom Report</button>
      </div>
      <div id="analytics-content">
      </div>
    </section>

    <section id="admin" class="content-section">
      <h2>Admin</h2>
      <p>
        <button>User Management</button>
        <button>System Settings</button>
        <button>Data Backup</button>
      </p>
    </section>
  </main>

  <footer>
    <p>&copy; 2024 Beacon Children's Hospital</p>
  </footer>

  <script src="{{ asset('js/beaconAdmin.js') }}"></script>
</body>

</html>