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
  
            // Fetch the EncounterSummary History form structure
            const response = await fetch(`/perinatal-history/${registrationNumber}`);
            const result = await response.json();
  
            console.log('Fetch response:', result);
  
            // Replace content with form once loaded
            mainContent.innerHTML = `
                <div class="container">
                <head>
                <link rel="stylesheet" href="../css/EncounterSummaryHistory.css">
                </head>
                <div>
                    <h2>EncounterSummary History</h2>
                    <p>whatup dawg</p>
                    
                    <button type="submit" id="saveEncounterSummaryHistory">Save</button>
                </div>
            `;
  
            // Pre-fill form data if available
          
            // Save functionality
            const saveButton = document.getElementById('saveEncounterSummaryHistory');
            saveButton.addEventListener('click', async () => {
                saveButton.innerHTML = `<span class="saving-button-spinner"></span> Saving...`;
               
                try {
                    const saveResponse = await fetch(`/EncounterSummary-history/${registrationNumber}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ data }),
                    });
  
                    const saveResult = await saveResponse.json();
                    alert(saveResult.message || 'EncounterSummary History saved successfully!');
                } catch (error) {
                    console.error('Error saving EncounterSummary History:', error);
                    alert('Failed to save EncounterSummary History. Please try again.');
                } finally {
                    saveButton.innerHTML = 'Save';
                    saveButton.disabled = false;
                }
            });
        } catch (error) {
            console.error('Error fetching EncounterSummary History:', error);
            mainContent.innerHTML = `<p class="error-message">Failed to load EncounterSummary History. Please try again later.</p>`;
        }
    });
  });
  