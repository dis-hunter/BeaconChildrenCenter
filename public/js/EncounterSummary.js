document.addEventListener('DOMContentLoaded', () => {
    // Define the missing fetchAndParseJSON function
    async function fetchAndParseJSON(url) {
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        
        const data = await response.json();
        return data;
    }
    
    // Add this function to handle toggling the details
    window.toggleDetails = function(element) {
        const notesSection = element.querySelector('.notes');
        const button = element.querySelector('button');
        
        if (notesSection.style.display === 'block') {
            notesSection.style.display = 'none';
            button.textContent = 'More Details';
        } else {
            notesSection.style.display = 'block';
            button.textContent = 'Hide Details';
        }
    };

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
            background: linear-gradient(to bottom right, #f8f9fa, #ffffff);
        }

        .spinner {
            border: 3px solid rgba(52, 152, 219, 0.1);
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .saving-button-spinner {
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-top: 2px solid white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 0.8s linear infinite;
            display: inline-block;
            vertical-align: middle;
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            padding: 20px;
            background: #fdf0ef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin: 20px auto;
            max-width: 500px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .patient-info {
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border-left: 4px solid #3498db;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .patient-info:hover {
            transform: translateY(-2px);
        }

        .patient-info h3 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .patient-info p {
            margin: 0.5rem 0;
            color: #34495e;
        }

        .visits-container {
            margin-top: 2rem;
            display: grid;
            gap: 1.5rem;
        }

        .visit-entry {
            border: none;
            padding: 1.5rem;
            border-radius: 12px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .visit-entry:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .visit-entry h3 {
            margin: 0 0 1rem 0;
            color: #2c3e50;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .visit-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            color: #7f8c8d;
            font-size: 0.95rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #ecf0f1;
        }

        .notes {
            white-space: pre-wrap;
            margin-top: 1rem;
            padding: 1.25rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            color: #2c3e50;
            font-size: 0.95rem;
            line-height: 1.6;
            display: none; /* Initially hide the notes */
        }

        .section-title {
            color: #2c3e50;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #3498db;
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
        }
    `;
    document.head.appendChild(style);

    // Show loading spinner
    mainContent.innerHTML = `
        <div class="loading-spinner">
            <div class="spinner"></div>
        </div>
    `;

    try {
        const registrationNumber = window.location.pathname.split('/').pop();
        console.log('Registration number extracted:', registrationNumber);
    
        // Use the fetchAndParseJSON function
        const result = await fetchAndParseJSON(`/getDoctorNotes/${registrationNumber}`);
        console.log('Fetch response:', result);
    
        if (result.status === 'success') {
            mainContent.innerHTML = `
                <div class="container">
                    <h2 class="section-title">Encounter Summary History</h2>
                    
                    <div class="patient-info">
                        <h3>Patient Information</h3>
                        <p><strong>Registration Number:</strong> ${result.data.registration_number}</p>
                        <p><strong>Patient Name:</strong> ${result.data.child_name}</p>
                    </div>

                    <div class="visits-container">
                    
${result.data.visits.map(visit => `
    <div class="visit-entry">
        <h3>Visit Details</h3>
        <div class="visit-meta">
            <span><strong>Date:</strong> ${new Date(visit.visit_date).toLocaleDateString()}</span>
            <span><strong>Doctor:</strong> ${visit.doctor_first_name} ${visit.doctor_last_name} </span>
        </div>
        <div class="notes">
            <strong>Doctor's Notes:</strong><br>
            ${visit.notes || 'No notes recorded'}
        </div>
            <button 
                onclick="toggleDetails(this.parentElement)" 
                class="px-3 py-1.5 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 active:bg-blue-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition-colors duration-200">
                More Details
            </button>    </div>
`).join('')}
                    </div>
                </div>
            `;
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        mainContent.innerHTML = `
            <div class="container">
                <p class="error-message">
                    ${error instanceof TypeError ? 
                        'Server response format error. Please contact support.' : 
                        'Failed to load notes. Please try again later.'}
                </p>
            </div>
        `;
    }
    });
});