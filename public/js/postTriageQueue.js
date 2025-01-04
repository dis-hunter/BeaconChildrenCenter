function startConsultation(childId) {
    window.location.href = `http://127.0.0.1:8000/doctor?childId=${childId}`;
  }
  
  // Fetch Post-Triage Queue
  async function fetchPostTriageQueue() {
    try {
        const response = await fetch(`/post-triage-queue`);
        const data = await response.json();
  
        console.log('Post-Triage Data:', data);
  
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
  
        data.data.forEach(visit => {
            const row = document.createElement('tr');
            row.innerHTML = `
              
                <td>${visit.patient_name || 'N/A'}</td>
                
                <td>
                    <button 
                        onclick="startConsultation(${visit.child_id})" 
                        class="consult-btn"
                        style="background-color: #38a169; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;"
                    >
                        Start Consultation
                    </button>
                </td>
            `;
            patientList.appendChild(row);
        });
    } catch (error) {
        console.error('Failed to fetch post-triage queue:', error);
    }
  }
  
  // Auto-fetch on page load
  document.addEventListener('DOMContentLoaded', fetchPostTriageQueue);