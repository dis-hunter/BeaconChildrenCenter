
function startConsultation(registrationNumber) {
  // Redirect to the URL with the registration number
  window.location.href = `/doctor/${registrationNumber}`;
  
}

async function fetchPostTriageQueue() {
  try {
      const response = await fetch(`/post-triage-queue`);
      const data = await response.json();

    

      const patientList = document.getElementById('post-triage-list');
      patientList.innerHTML = '';

      if (!data.data || data.data.length === 0) {
          patientList.innerHTML = `
              <tr>
                  <td colspan="6" style="text-align: center;">No patients in post-triage queue</td>
              </tr>
          `;
          return;
      }

      data.data.forEach((visit, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
              <td style="text-align: left;">
                  <div>
                    <p style="font-size: 20px; color:#007bff; margin-bottom: 10px; display: inline;">${index + 1}. ${visit.patient_name || 'N/A'}</p><br>
                    <small style="color: gray; font-size: 14px; margin-left: 28px;">${visit.visit_type || 'N/A'}</small>


                  </div>
              </td>
              <td>
                  <button 
                      onclick="startConsultation('${visit.registration_number}')" 
                      class="consult-btn"
                      style="background-color: #007bff; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;"
                  >
                      Start Session
                  </button>
              </td>
              <style>
                  .consult-btn {
                      background-color: #007bff;
                      color: white;
                      padding: 10px 20px;
                      border: none;
                      border-radius: 5px;
                      cursor: pointer;
                      font-size: 16px;
                      transition: all 0.3s ease;
                  }

                  .consult-btn:hover {
                      background-color: white;
                      color: black;
                      border: 1px solid black;
                  }

                  td {
                      padding: 10px;
                      border-bottom: 1px solid #ddd;
                      transition: background-color 0.3s ease, transform 0.2s ease;
                  }
              </style>
          `;
          patientList.appendChild(row);
      });
  } catch (error) {
      console.error('Failed to fetch post-triage queue:', error);
  }
}


// Auto-fetch on page load
document.addEventListener('DOMContentLoaded', fetchPostTriageQueue);

const sidebarLinks = document.querySelectorAll('.sidebar a');
const patientList = document.getElementById('patient-list');
const startConsultationButton = document.querySelector('.start-consult');

// Get the links and content sections for dynamic switching
const dashboardLink = document.getElementById('dashboard-link');
const profileLink = document.getElementById('profile-link');
const bookedLink = document.getElementById('booked-link');
const therapistLink = document.getElementById('therapist-link');
const leaveLink = document.getElementById('leave-link');
const dashboardContent = document.getElementById('dashboard-content');
const profileContent = document.getElementById('profile-content');
const bookedContent = document.getElementById('booked-content');
const leaveContent = document.getElementById('leave-content');
const therapistContent = document.getElementById('therapist-content');
const dropdownProfileLink = document.getElementById('dropdown-profile-link');
const calendarLink = document.getElementById('calendar-link');
const calendarContent = document.getElementById('calendar-content');

function updatePatientList() {
  // 1. Get the currently active patient ID (if any)
  const currentActivePatientId = patientList.querySelector('.active')?.dataset.patientId;

  // 2. Clear the list
  patientList.innerHTML = '';

  // 3. Get the first 5 patients from the queue
  const patientsToDisplay = patientQueue.slice(0, 5);

  patientsToDisplay.forEach(patient => {
    const listItem = document.createElement('li');
    listItem.innerHTML = `
                  <div>
                      <h4>${patient.name}</h4> 
                  </div>
              `;
    // Add the data-patient-id attribute
    listItem.dataset.patientId = patient.id;

    listItem.addEventListener('click', () => {
      // Remove 'active' class from all list items
      const activeItems = patientList.querySelectorAll('.active');
      activeItems.forEach(item => item.classList.remove('active'));

      // Add 'active' class to the clicked list item
      listItem.classList.add('active');

      // Store the active patient ID in localStorage
      localStorage.setItem('activePatientId', patient.id);
    });

    // 3. Reapply the 'active' class if this patient was active
    if (patient.id === currentActivePatientId) {
      listItem.classList.add('active');
    }

    patientList.appendChild(listItem);
  });
}

// Retrieve the active patient ID from localStorage when the page loads
const activePatientId = localStorage.getItem('activePatientId');
if (activePatientId) {
  // Find the list item with the matching patient ID and add the 'active' class
  const activeListItem = document.querySelector(`[data-patient-id="${activePatientId}"]`);
  if (activeListItem) {
    activeListItem.classList.add('active');
  }
}

// updatePatientList();
setInterval(updatePatientList, 10 * 60 * 1000); // 10 minutes

// Sidebar link event listeners
sidebarLinks.forEach(link => {
  link.addEventListener('click', () => {
    // Remove 'active' class from all links
    sidebarLinks.forEach(link => link.parentElement.classList.remove('active'));
    // Add 'active' class to the clicked link
    link.parentElement.classList.add('active');

    // Hide all content sections
    dashboardContent.style.display = 'none';
    profileContent.style.display = 'none';
    bookedContent.style.display = 'none';
    therapistContent.style.display = 'none';
    calendarContent.style.display = 'none';

    // Show the corresponding content section based on the clicked link
    if (link === dashboardLink) {
      dashboardContent.style.display = 'block';
    } else if (link === profileLink) {
      profileContent.style.display = 'block';
    } else if (link === bookedLink) {
      bookedContent.style.display = 'block';
    } else if (link === therapistLink) {
      therapistContent.style.display = 'block';
    }else if (link === calendarLink) {
      calendarContent.style.display = 'block';
    }


  });
});



therapistLink.addEventListener('click', async () => {

  therapistContent.innerHTML = '</br> </br><p>Loading...</p>';
  
  try {
      
      const response = await fetch('/appointments/therapists');
      if (!response.ok) throw new Error('Failed to load data');
      const appointments = await response.json();
      
      if (appointments.length > 0) {
          let table = `
              <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Child Name</th>
                          <th>Staff Name</th>
                          <th>Specialization</th>
                          <th>Appointment Date</th>
                          <th>Start Time</th>
                          <th>End Time</th>
                      </tr>
                  </thead>
                  <tbody>`;

          appointments.forEach(appointment => {
             
              table += `
                  <tr>
                      <td>${appointment.id}</td>
                      <td>${appointment.child_name}</td>
                      <td>${JSON.parse(appointment.staff_name).first_name}</td>
                      <td>${appointment.specialization}</td>
                      <td>${appointment.appointment_date}</td>
                      <td>${appointment.start_time}</td>
                      <td>${appointment.end_time}</td>
                  </tr>`;
          });

          table += `</tbody></table>`;
          therapistContent.innerHTML = table;
          therapistContent.style.display = 'block'; // Show the therapist content
          
      } else {
          therapistContent.innerHTML = '</br> </br><p>No appointments found.</p>';
      }
  } catch (error) {
      therapistContent.innerHTML = '</br> </br><p>Failed to load appointments. Please try again later.</p>';
  }
});




// Event listener for "Booked Patients" link
document.getElementById('booked-link').addEventListener('click', async () => {
  const bookedContent = document.getElementById('booked-content');
  bookedContent.innerHTML = '</br> </br><p>Loading...</p>'; // Show loading message

  try {
    const response = await fetch('/appointments/booked-patients'); // Endpoint for fetching appointments
    if (!response.ok) throw new Error('Failed to load data');

    const appointments = await response.json();
    
    // Clear any previous content
    bookedContent.innerHTML = '';

    if (appointments.length === 0) {
      // Show "No appointments for today" message
      bookedContent.innerHTML = '</br> </br><p>No appointments for today.</p>';
      return;
    }

    // Create a table to display the appointments
    const table = document.createElement('table');
    table.classList.add('table', 'table-bordered');

    // Create table header
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    headerRow.innerHTML = `
        <th style="color:black;">Child Name</th>
        <th style="color:black;">Start Time</th>
        <th style="color:black;">End Time</th>
        <th style="color:black;">Parent Email</th>
        <th style="color:black;">Parent Telephone</th>
    `;
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Create table body with appointments data
    const tbody = document.createElement('tbody');
    appointments.forEach(appointment => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${appointment.child_name}</td>
            <td>${appointment.start_time}</td>
            <td>${appointment.end_time}</td>
            <td>${appointment.parent_email || 'N/A'}</td>
            <td>${appointment.parent_telephone || 'N/A'}</td>
        `;
        tbody.appendChild(row);
    });

    table.appendChild(tbody);
    bookedContent.appendChild(table);

    bookedContent.style.display = 'block'; // Show the booked appointments section
  } catch (error) {
    console.error('Error loading booked patients:', error);
    bookedContent.innerHTML = '</br> </br><p>Failed to load appointments. Please try again later.</p>';
  }
});


document.addEventListener('DOMContentLoaded', () => {
  const calendarLink = document.getElementById('calendar-link');
  const bookedLink = document.getElementById('booked-link');
  const therapistLink = document.getElementById('therapist-link');
  const profileLink = document.getElementById('profile-link');
  const dashboardLink = document.getElementById('dashboard-link');
  
  const calendarContent = document.getElementById('calendar-content');
  const bookedContent = document.getElementById('booked-content');
  const therapistContent = document.getElementById('therapist-content');
  const profileContent = document.getElementById('profile-content');
  const dashboardContent = document.getElementById('dashboard-content');

  // Event listener for View Calendar link
  calendarLink.addEventListener('click', () => {
    // Hide other sections
    dashboardContent.style.display = 'none';
    profileContent.style.display = 'none';
    bookedContent.style.display = 'none';
    therapistContent.style.display = 'none';

    // Show the calendar section
    calendarContent.style.display = 'block';
  });

  // Event listener for Booked Patients link
  bookedLink.addEventListener('click', () => {
    // Hide other sections
    dashboardContent.style.display = 'none';
  
    calendarContent.style.display = 'none';
    therapistContent.style.display = 'none';

    // Show the booked patients section
    bookedContent.style.display = 'block';
  });

  // Event listener for Therapist link
  therapistLink.addEventListener('click', () => {
    // Hide other sections
    dashboardContent.style.display = 'none';
    calendarContent.style.display = 'none';
    bookedContent.style.display = 'none';

    // Show the therapist section
    therapistContent.style.display = 'block';
  });

  // Event listener for Profile link

  // Event listener for Dashboard link
  dashboardLink.addEventListener('click', () => {
    // Hide other sections
    therapistContent.style.display = 'none';
    calendarContent.style.display = 'none';
    bookedContent.style.display = 'none';

    // Show the dashboard section
    dashboardContent.style.display = 'block';
  });
});



// Start consultation button event listener
startConsultationButton.addEventListener('click', () => {
  const activePatient = patientList.querySelector('.active');
  if (activePatient) {
    // Show loading indicator
    showLoadingIndicator();

    // Get the patient ID from the data attribute
    const patientId = activePatient.dataset.patientId;

    // Simulate a slight delay to show the loading indicator
    setTimeout(() => {
      // Redirect to the consultation page with the patient ID
      window.location.href = `/doctor/${patientId}`;
    }, 500); // Delay to ensure loading indicator is visible
  } else {
    // Handle case where no patient is selected (e.g., show an alert)
    alert("Please select a patient first.");
  }
});

// Function to show the loading indicator
function showLoadingIndicator() {
  const loadingIndicator = document.createElement('div');
  loadingIndicator.id = 'loading-indicator';
  document.body.appendChild(loadingIndicator);
}

// Function to remove the loading indicator
function removeLoadingIndicator() {
  const loadingIndicator = document.getElementById('loading-indicator');
  if (loadingIndicator) {
    document.body.removeChild(loadingIndicator);
  }
}

// Inject loading animation styles into the document head
const loadingAnimationStyles = document.createElement('style');
loadingAnimationStyles.textContent = `
  @keyframes loading-animation {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
  }
  #loading-indicator {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 4px solid #ccc;
      border-color: #007bff transparent #007bff transparent;
      animation: loading-animation 1.2s linear infinite;
      z-index: 1000;
  }
`;
document.head.appendChild(loadingAnimationStyles);