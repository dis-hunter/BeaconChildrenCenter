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

    // const childId = getChildIdFromUrl();

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
   

// Function to extract child ID from URL
// function getChildIdFromUrl() {
//     const pathParts = window.location.pathname.split('/');
//     return pathParts[pathParts.length - 1];
// }

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

document.addEventListener('DOMContentLoaded', async () => {
    // Function to get Child ID from URL
    function getChildIdFromUrl() {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get('patientId'); 
  }

    // Fetch Patient Name by Child ID
    async function fetchPatientName(childId) {
        try {
            const response = await fetch(`/get-patient-name/${childId}`);
            const data = await response.json();

            if (data.status === 'success') {
                document.getElementById('patient-name').textContent = data.patient_name || 'Patient Name';
            } else {
                document.getElementById('patient-name').textContent = 'Patient Not Found';
            }
        } catch (error) {
            console.error('Error fetching patient name:', error);
            document.getElementById('patient-name').textContent = 'Error Loading Patient';
        }
    }

    const childId = getChildIdFromUrl();
    if (childId) {
        fetchPatientName(childId);
    } else {
        document.getElementById('patient-name').textContent = 'No Patient Selected';
    }
});





