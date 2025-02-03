// 📌 Helper function to create input fields dynamically
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

// 📌 Function to extract URL query parameters
function getQueryParam(param) {
  return new URLSearchParams(window.location.search).get(param);
}

// 📌 Function to validate essential parameters
function validateParams() {
  const patientId = getQueryParam('patientId');
  const visitId = getQueryParam('visitId');

  if (!patientId || !visitId) {
    console.error('Missing patientId or visitId in URL');
    alert('Missing patient or visit information. Please go back and select a patient again.');
    return { valid: false };
  }
  return { patientId, visitId, valid: true };
}

// 📌 Function to fetch patient name
async function fetchPatientName(childId) {
  try {
    const response = await fetch(`/get-patient-name/${childId}`);
    if (!response.ok) throw new Error('Network response was not ok');
    
    const data = await response.json();
    document.getElementById('patient-name').textContent = data.patient_name || 'Patient Name';
  } catch (error) {
    console.error('Error fetching patient name:', error);
    document.getElementById('patient-name').textContent = 'Error Loading Patient';
  }
}

// 📌 Function to handle form submission
async function handleFormSubmission(e) {
  e.preventDefault();
  
  // Get CSRF token from meta tag
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
  if (!csrfToken) {
    console.error('CSRF token not found');
    return alert('Security token missing. Please refresh the page.');
  }

  // Validate URL parameters
  const params = validateParams();
  if (!params.valid) return;

  try {
    const formData = new FormData(e.target);
    formData.append('child_id', params.patientId);
    formData.append('visit_id', params.visitId);

    const response = await fetch('/triage', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json',
      },
      body: formData
    });

    const data = await response.json();
    
    if (!response.ok) {
      throw new Error(data.message || 'Failed to save triage data');
    }

    if (data.status === 'success') {
      alert('Triage data saved successfully!');
      window.location.href = '/triageDashboard';
    } else {
      throw new Error(data.message || 'Unknown server error');
    }
  } catch (error) {
    console.error('Submission Error:', error);
    alert(`Error: ${error.message}\nPlease check the data and try again.`);
  }
}

// 📌 Function to fetch initial triage data
async function fetchTriageData(patientId) {
  try {
    const response = await fetch(`/triage-data/${patientId}`);
    if (!response.ok) throw new Error('Network response was not ok');
    
    const data = await response.json();
    console.log('Triage Data:', data.data);
  } catch (error) {
    console.error('Error fetching triage data:', error);
  }
}

// 📌 Initialize the page
document.addEventListener('DOMContentLoaded', async () => {
  const params = validateParams();
  if (!params.valid) return;

  try {
    await Promise.all([
      fetchPatientName(params.patientId),
      fetchTriageData(params.patientId)
    ]);
  } catch (error) {
    console.error('Initialization error:', error);
  }

  document.getElementById('triage-form')?.addEventListener('submit', handleFormSubmission);
});