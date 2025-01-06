

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

// ✅ Fetch Untriaged Visits from Laravel Backend
// Add this at the bottom of your JavaScript file
document.addEventListener('DOMContentLoaded', function() {
  console.log('Page loaded - fetching untriaged visits...');
  fetchUntriagedVisits();
});

// Modify your fetchUntriagedVisits function to use the correct URL path
function populateUntriagedVisits(visits) {
  const patientList = document.getElementById('patient-list');
  patientList.innerHTML = ''; // Clear previous entries
  
  if (!visits || visits.length === 0) {
      patientList.innerHTML = '<tr><td colspan="6" style="text-align: center;">No patients waiting</td></tr>';
      return;
  }
  
  visits.forEach(visit => {
      const row = document.createElement('tr');
      row.innerHTML = `
          // <td>${visit.id || ''}</td>
          <td>${visit.patient_name || 'N/A'}</td>
          // <td>${visit.child_id || ''}</td>
          // <td>${visit.staff_id || ''}</td>
          <td>${visit.triage_pass ? 'Completed' : 'Pending'}</td>
          <td>
              <button 
                  onclick="startTriage(${visit.visit_id})" 
                  class="triage-btn"
                  style="background-color: #4299e1; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;"
              >
                  Start Triage
              </button>
          </td>
      `;
      patientList.appendChild(row);
  });
}

// Update the fetch function to properly pass data to populateUntriagedVisits
async function fetchUntriagedVisits() {
  try {
    const response = await fetch('/untriaged-visits');
    const data = await response.json();
    console.log('Data:', data);

    const tableBody = document.getElementById('patient-list');
    tableBody.innerHTML = '';

    data.data.forEach(visit => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${visit.patient_name || 'N/A'}</td>
        <td>
          <button class="triage-btn" data-patient-id="${visit.child_id}" data-visit-id="${visit.id}">
            Start Triage
          </button>
        </td>
      `;
      tableBody.appendChild(row);

      // Add event listener to the triage button
      const triageButton = row.querySelector('.triage-btn');
      triageButton.addEventListener('click', () => {
        const patientId = triageButton.dataset.patientId;
        const visitId = triageButton.dataset.visitId;

        // Redirect to triage page with patientId and visitId as query parameters
        window.location.href = `/triage?patientId=${patientId}&visitId=${visitId}`;
      });
    });
  } catch (error) {
    console.error('Failed to fetch untriaged visits:', error);
  }
}

// Initialize on DOMContentLoaded
document.addEventListener('DOMContentLoaded', fetchUntriagedVisits);


document.addEventListener('DOMContentLoaded', function() {
  console.log('Page loaded');
  fetchUntriagedVisits();
});

// Make sure this runs when the page loads
document.addEventListener('DOMContentLoaded', fetchUntriagedVisits);


// ✅ Event Listener to Load Untriaged Visits on Sidebar Click
// bookedLink.addEventListener('click', () => {
//     fetchUntriagedVisits();
//     dashboardContent.style.display = 'none';
//     profileContent.style.display = 'none';
//     bookedContent.style.display = 'block';
//     therapistContent.style.display = 'none';
// });  
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
  // dropdownProfileLink.addEventListener('click', () => {
  //   dashboardContent.style.display = 'none';
  //   profileContent.style.display = 'block';
  //   bookedContent.style.display = 'none';
  //   therapistContent.style.display = 'none';
  //   // Update active state in sidebar
  //   sidebarLinks.forEach(link => link.parentElement.classList.remove('active'));
  //   profileLink.parentElement.classList.add('active');
  // });
  


  
  

  
