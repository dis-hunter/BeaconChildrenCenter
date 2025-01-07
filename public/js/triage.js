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
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

// 📌 Function to validate essential parameters
function validateParams() {
  const urlParams = new URLSearchParams(window.location.search);
  const patientId = urlParams.get('patientId');
  const visitId = urlParams.get('visitId');

  if (!patientId || !visitId) {
      console.error('Missing patientId or visitId in URL');
      alert('Missing patient or visit information. Please go back and select a patient again.');
      return false;
  }
  return { patientId, visitId };
}


// 📌 Function to fetch patient name
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

// 📌 Function to handle form submission
async function handleFormSubmission(e) {
  e.preventDefault();

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
  const { patientId, visitId } = validateParams();

  if (!csrfToken || !patientId || !visitId) {
      console.error('Missing CSRF token, patientId, or visitId');
      alert('Critical data missing. Please refresh and try again.');
      return;
  }

  const form = e.target;
  const formData = new FormData(form);

  // Add IDs to formData
  formData.append('child_id', patientId);
  formData.append('visit_id', visitId);

  console.log('FormData:', Object.fromEntries(formData));

  // Process selected checkboxes for triage_sorting
  const selectedDepartments = [];
  document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
      selectedDepartments.push(checkbox.value);
  });
  selectedDepartments.forEach((dept) => {
      formData.append('triage_sorting[]', dept);
  });

  try {
      const response = await fetch('/triage', {
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': csrfToken,
          },
          body: formData
      });

      const result = await response.json();
      console.log('Server Response:', result);

      if (response.ok && result.status === 'success') {
          alert('Triage data saved successfully');
          window.location.href = '/triageDashboard';
      } else {
          console.error('Validation Errors:', result.errors || 'No error details provided');
          let errorMessages = result.errors 
              ? Object.values(result.errors).flat().join('\n') 
              : 'Unknown validation error';
          alert('Validation Errors:\n' + errorMessages);
      }
  } catch (error) {
      console.error('Network or Server Error:', error);
      alert('Failed to save triage data. Please try again.');
  }
}

// 📌 Function to fetch initial triage data
async function fetchTriageData(patientId) {
  try {
      const response = await fetch(`/triage-data/${patientId}`);
      if (!response.ok) {
          throw new Error('Failed to fetch triage data');
      }

      const data = await response.json();
      console.log('Triage Data:', data.data); // Debug log
  } catch (error) {
      console.error('Error fetching triage data:', error);
  }
}

// 📌 DOMContentLoaded Event Listener
document.addEventListener('DOMContentLoaded', async () => {
  const { patientId } = validateParams();
  
  if (patientId) {
      fetchPatientName(patientId);
      fetchTriageData(patientId);
  }

  const form = document.getElementById('triage-form');
  if (form) {
      form.addEventListener('submit', handleFormSubmission);
  }
});
