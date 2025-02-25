document.addEventListener('DOMContentLoaded', () => {
  const triageExam = document.querySelector('.floating-menu a[href="#triageExam"]');
  
  if (!triageExam) return;

  triageExam.addEventListener('click', async (event) => {
      event.preventDefault();

      const registrationNumber = getRegistrationNumberFromUrl();
      console.log("Registration number:", registrationNumber);

      // Show loading indicator
      showLoadingIndicator();

      try {
          // Fetch triage data
          const triageData = await fetchTriageData(registrationNumber);
          console.log('Triage data:', triageData);

          // ✅ Pass data (even if null) to render function
          renderTriageExamination(triageData);
      } catch (error) {
          console.error('Error fetching triage data:', error);
          alert('Failed to fetch triage data. Please try again.');
      } finally {
          // Remove loading indicator
          removeLoadingIndicator();
      }
  });
});

// Function to extract registration number from URL
function getRegistrationNumberFromUrl() {
  const pathParts = window.location.pathname.split('/');
  return pathParts[pathParts.length - 1];
}

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

// ✅ Modified: Function to fetch triage data and handle null response
async function fetchTriageData(registrationNumber) {
  const response = await fetch(`/get-triage-data/${registrationNumber}`);
  if (!response.ok) {
      throw new Error('Network response was not ok');
  }

  const data = await response.json();
  // ✅ Check if server returned null
  return data === null ? null : data;
}

// ✅ Modified: Function to render triage examination UI
function renderTriageExamination(triageData) {
  const mainContent = document.querySelector('.main');

  // ✅ Handle null, undefined, or empty object
  if (!triageData || Object.keys(triageData).length === 0) {
      mainContent.innerHTML = `
          <div class="container">
              
              <h2 style="color: #007bff; text-align: center;">No Triage Data Found</h2>
          </div>
      `;
      return;
  }

  mainContent.innerHTML = `
      <div class="container">
      <link rel='stylesheet' href='../css/triageExam.css'>
          <h2>Triage Examination</h2>
          <div class="section">
              <div class="grid-container">
                  ${createInputField('Temp', 'temp', triageData.temperature)}
                  ${createInputField('RR', 'rr', triageData.respiratory_rate)}
                  ${createInputField('Pulse', 'pulse', triageData.pulse_rate)}
                  ${createInputField('BP', 'bp', triageData.blood_pressure)}
              </div>
          </div>
          <div class="section">
              <div class="grid-container">
                  ${createInputField('Weight', 'weight', triageData.weight)}
                  ${createInputField('Height', 'height', triageData.height)}
                  ${createInputField('MUAC', 'muac', triageData.MUAC)}
                  ${createInputField('HC', 'hc', triageData.head_circumference)}
              </div>
          </div>
      </div>
  `;
}


// Helper function to create an input field
function createInputField(label, id, value) {
  return `
      <div class="grid-item">
          <label style="color:white;" for="${id}">${label}:</label>
          <input type="text" id="${id}" value="${value || ''}">
      </div>
  `;
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

// Auto-resizing textareas
const textareas = document.querySelectorAll('textarea');

textareas.forEach(textarea => {
  textarea.addEventListener('input', () => {
      textarea.style.height = "auto"; 
      textarea.style.height = (textarea.scrollHeight) + "px"; 
  });

  textarea.addEventListener('blur', () => {
      textarea.style.height = '50px'; 
  });

  textarea.style.height = "auto"; 
  textarea.style.height = (textarea.scrollHeight) + "px"; 
});
