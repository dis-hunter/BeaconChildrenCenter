// Helper function to create input fields
function createInputField(label, name, value) {
    return `
      <div class="form-group">
        <label for="${name}">${label}</label>
        <input 
          type="text" 
          id="${name}" 
          name="${name}" 
          value="${value || ''}" 
          class="form-control"
        >
      </div>
    `;
}

// Function to handle form submission
function handleSubmit(event) {
    event.preventDefault();
    
    const formData = {
        temperature: document.querySelector('#temperature').value,
        respiratory_rate: document.querySelector('#respiratory_rate').value,
        pulse_rate: document.querySelector('#pulse_rate').value,
        blood_pressure: document.querySelector('#blood_pressure').value,
        weight: document.querySelector('#weight').value,
        height: document.querySelector('#height').value,
        muac: document.querySelector('#muac').value,
        head_circumference: document.querySelector('#head_circumference').value
    };

    const childId = getChildIdFromUrl();

    fetch(`/triage/${childId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Triage examination saved successfully');
        } else {
            alert('Error saving triage examination: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to save triage examination');
    });
}

// Function to render triage examination form
function renderTriageExamination(triageData = {}) {
    const mainContent = document.querySelector('main');
    mainContent.innerHTML = `
      <div class="container">
        <link rel='stylesheet' href='../css/triageExam.css'>
        <form id="triageForm" class="triage-form">
          <h2>Triage Examination</h2>
          
          <div class="section">
            <h3>Vital Signs</h3>
            <div class="grid-container">
              ${createInputField('Temperature (°C)', 'temperature', triageData.temperature)}
              ${createInputField('Respiratory Rate (breaths/min)', 'respiratory_rate', triageData.respiratory_rate)}
              ${createInputField('Pulse Rate (bpm)', 'pulse_rate', triageData.pulse_rate)}
              ${createInputField('Blood Pressure', 'blood_pressure', triageData.blood_pressure)}
            </div>
          </div>
          
          <div class="section">
            <h3>Measurements</h3>
            <div class="grid-container">
              ${createInputField('Weight (kg)', 'weight', triageData.weight)}
              ${createInputField('Height (m)', 'height', triageData.height)}
              ${createInputField('MUAC (cm)', 'muac', triageData.muac)}
              ${createInputField('Head Circumference (m)', 'head_circumference', triageData.head_circumference)}
            </div>
          </div>
          
          <div class="section">
            <button type="submit" class="save-btn">Save Examination</button>
          </div>
        </form>
      </div>
    `;

    // Add form submit handler
    document.querySelector('#triageForm').addEventListener('submit', handleSubmit);
}

// Function to extract child ID from URL
function getChildIdFromUrl() {
    const pathParts = window.location.pathname.split('/');
    return pathParts[pathParts.length - 1];
}

// Initialize when DOM is loaded


// document.addEventListener('DOMContentLoaded', () => {
//     const childId = getChildIdFromUrl();
//     fetch(`/triage/${childId}`)
//         .then(response => response.json())
//         // .then(data => renderTriageExamination(data.triageData))
//         .catch(error => {
//             console.error('Error:', error);
//             renderTriageExamination({}); // Render with empty data if fetch fails
//         });
// });

function getPatientIdFromUrl() {
  // Get the current URL's query parameters
  const urlParams = new URLSearchParams(window.location.search);

  // Retrieve the 'patientId' parameter
  const patientId = urlParams.get('patientId');

  // Log the patientId to the console
  console.log(`Patient ID: ${patientId}`);

  // Return the patientId (optional, if needed for further use)
  return patientId;
}
// Function to get patientId from the URL


// Function to fetch triage data from the server
async function fetchTriageData(patientId) {
  try {
    console.log("go");
    const response = await fetch(`/triage-data/${patientId}`);
    if (!response.ok) {
      throw new Error('Failed to fetch triage data');
    }

    const data = await response.json();
    console.log('Triage Data:', data.data); // Log the data in the console
  } catch (error) {
    console.error('Error fetching triage data:', error);
  }
}

// DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', () => {
  const patientId = getPatientIdFromUrl(); // Get the patientId from the URL
  if (patientId) {
    fetchTriageData(patientId); // Fetch data if patientId is present
  } else {
    console.log('No patientId found in URL');
  }
});


// Call the function when the page loads



