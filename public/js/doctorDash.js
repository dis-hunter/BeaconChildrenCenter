const patientQueue = [
  { name: "John Doe", id: "REG-001" },
  { name: "Alice Willson", id: "REG-002" },
  { name: "Bob Williams", id: 3 },
  { name: "Eva Green", id: 4 },
  { name: "Chris Evans", id: 5 },
];

const sidebarLinks = document.querySelectorAll('.sidebar a');
const patientList = document.getElementById('patient-list');
const startConsultationButton = document.querySelector('.start-consult');

// Get the links and content sections for dynamic switching
const dashboardLink = document.getElementById('dashboard-link');
const profileLink = document.getElementById('profile-link');
const bookedLink = document.getElementById('booked-link');
const therapistLink = document.getElementById('therapist-link');
const dashboardContent = document.getElementById('dashboard-content');
const profileContent = document.getElementById('profile-content');
const bookedContent = document.getElementById('booked-content');
const therapistContent = document.getElementById('therapist-content');
const dropdownProfileLink = document.getElementById('dropdown-profile-link');

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

updatePatientList();
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

    // Show the corresponding content section based on the clicked link
    if (link === dashboardLink) {
      dashboardContent.style.display = 'block';
    } else if (link === profileLink) {
      profileContent.style.display = 'block';
    } else if (link === bookedLink) {
      bookedContent.style.display = 'block';
    } else if (link === therapistLink) {
      therapistContent.style.display = 'block';
    }
  });
});

// Dropdown profile link event listener
dropdownProfileLink.addEventListener('click', () => {
  dashboardContent.style.display = 'none';
  profileContent.style.display = 'block';
  bookedContent.style.display = 'none';
  therapistContent.style.display = 'none';
  // Update active state in sidebar
  sidebarLinks.forEach(link => link.parentElement.classList.remove('active'));
  profileLink.parentElement.classList.add('active');
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
