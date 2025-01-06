document.addEventListener('DOMContentLoaded', () => {
    const EncounterSummaryHistoryLink = document.querySelector('.floating-menu a[href="#EncounterSummary"]');
  
    EncounterSummaryHistoryLink.addEventListener('click', async (event) => {
        event.preventDefault();
        console.log('EncounterSummary History link clicked.');
  
        const mainContent = document.querySelector('.main');
  
        // Add CSS for the spinner directly to the document
        const style = document.createElement('style');
        style.innerHTML = `
            .loading-spinner {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }
            .spinner {
                border: 4px solid #f3f3f3;
                border-top: 4px solid #3498db;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                animation: spin 2s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .saving-button-spinner {
                border: 2px solid #f3f3f3;
                border-top: 2px solid white;
                border-radius: 50%;
                width: 14px;
                height: 14px;
                animation: spin 1s linear infinite;
                display: inline-block;
            }
            .error-message {
                color: red;
                text-align: center;
            }
        `;
        document.head.appendChild(style);
  
        // Add rotating circle loading indicator
        mainContent.innerHTML = `
            <div class="loading-spinner">
                <div class="spinner"></div>
            </div>
        `;
  
        try {
            const registrationNumber = window.location.pathname.split('/').pop();
            console.log('Registration number extracted:', registrationNumber);
        
            const response = await fetch(`/getDoctorNotes/${registrationNumber}`);
            const result = await response.json();
        
            console.log('Fetch response:', result);
        
            if (result.status === 'success') {
                mainContent.innerHTML = `
                <div class="container">
                    <div id="encounter-summary">
                        <h2>Encounter Summary History</h2>
                        <p>Registration Number: ${result.data.registration_number}</p>
                        <div class="visits-container">
                            ${result.data.visits.map(visit => `
                                <div class="visit-entry">
                                    <h3>Visit Date: ${new Date(visit.visit_date).toLocaleDateString()}</h3>
                                    <p>Doctor: ${visit.doctor_name}</p>
                                    <p class="notes">${visit.notes || 'No notes recorded'}</p>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            
                    <style>
                    .visits-container {
    margin-top: 20px;
}

.visit-entry {
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 5px;
}

.visit-entry h3 {
    margin-top: 0;
    color: #333;
}

.notes {
    white-space: pre-wrap;
    margin-top: 10px;
}
                    </style>
                `;
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            mainContent.innerHTML = `<p class="error-message">Failed to load notes. Please try again later.</p>`;
        }
    });
  });
  