// 📌 Validation rules for triage form
const validationRules = {
  temperature: { min: 32, max: 42, message: 'Temperature must be between 32°C and 42°C' },
  respiratory_rate: { min: 0, max: 100, message: 'Respiratory rate must be between 0 and 100 breaths/min' },
  pulse_rate: { min: 0, max: 200, message: 'Pulse rate must be between 0 and 200 bpm' },
  weight: { min: 0, max: 200, message: 'Weight must be between 0 and 200 kg' },
  height: { min: 0, max: 250, message: 'Height must be between 0 and 250 cm' },
  muac: { min: 0, max: 50, message: 'MUAC must be between 0 and 50 cm' },
  head_circumference: { min: 0, max: 60, message: 'Head circumference must be between 0 and 60 cm' },
  oxygen_saturation: { min: 0, max: 100, message: 'Oxygen saturation must be between 0 and 100%' }
};

// 📌 Helper function to create validation alert
function createValidationAlert(errors) {
  const existingAlert = document.getElementById('validation-alert');
  if (existingAlert) existingAlert.remove();

  const alert = document.createElement('div');
  alert.id = 'validation-alert';
  alert.className = 'validation-alert';
  alert.innerHTML = `
    <div class="alert-content">
      <div class="alert-header">
        <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" y1="8" x2="12" y2="12"></line>
          <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <span class="alert-title">Validation Error</span>
        <button class="alert-close" onclick="this.parentElement.parentElement.parentElement.remove()">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
      </div>
      <ul class="alert-list">
        ${Object.values(errors).map(error => `<li>${error}</li>`).join('')}
      </ul>
    </div>
  `;

  document.querySelector('#triage-form').insertAdjacentElement('beforebegin', alert);

  // Add styles dynamically
  const style = document.createElement('style');
  style.textContent = `
    .validation-alert {
      margin-bottom: 1rem;
      padding: 1rem;
      border-radius: 0.375rem;
      background-color: #fee2e2;
      border: 1px solid #fecaca;
    }
    .alert-content {
      position: relative;
    }
    .alert-header {
      display: flex;
      align-items: center;
      margin-bottom: 0.5rem;
    }
    .alert-icon {
      width: 1.25rem;
      height: 1.25rem;
      color: #dc2626;
      margin-right: 0.5rem;
    }
    .alert-title {
      font-weight: 600;
      color: #dc2626;
    }
    .alert-close {
      position: absolute;
      right: 0;
      top: 0;
      padding: 0.25rem;
      background: none;
      border: none;
      cursor: pointer;
      color: #dc2626;
    }
    .alert-close svg {
      width: 1rem;
      height: 1rem;
    }
    .alert-list {
      margin: 0;
      padding-left: 1.5rem;
      color: #dc2626;
    }
    .input-error {
      border-color: #dc2626 !important;
    }
  `;
  document.head.appendChild(style);
}

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
        onchange="validateField(this)"
      >
    </div>
  `;
}

// 📌 Function to validate a single field
function validateField(input) {
  const name = input.name;
  const value = parseFloat(input.value);
  const rule = validationRules[name];

  // Clear previous error styling
  input.classList.remove('input-error');
  
  if (rule) {
    if (isNaN(value) || value < rule.min || value > rule.max) {
      input.classList.add('input-error');
      return rule.message;
    }
  }
  return null;
}

// 📌 Function to validate all fields
function validateForm(form) {
  const errors = {};
  const inputs = form.querySelectorAll('input[type="number"], input[type="text"]');
  
  inputs.forEach(input => {
    const error = validateField(input);
    if (error) {
      errors[input.name] = error;
    }
  });

  if (Object.keys(errors).length > 0) {
    createValidationAlert(errors);
    return false;
  }
  
  return true;
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
  
  if (!validateForm(e.target)) {
    return;
  }

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
  if (!csrfToken) {
    console.error('CSRF token not found');
    return alert('Security token missing. Please refresh the page.');
  }

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

  // Add input validation listeners
  document.querySelectorAll('input[type="number"], input[type="text"]').forEach(input => {
    input.addEventListener('change', (e) => validateField(e.target));
  });

  document.getElementById('triage-form')?.addEventListener('submit', handleFormSubmission);
});