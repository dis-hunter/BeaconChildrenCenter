document.addEventListener('DOMContentLoaded', () => {
    const nutritionHistoryLink = document.querySelector('.floating-menu a[href="#nutrition"]');
  
    nutritionHistoryLink.addEventListener('click', async (event) => {
        event.preventDefault();
        
  
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

  
            // Replace content with form once loaded
            mainContent.innerHTML = `
                <div class="container">
                <head>
                <link rel="stylesheet" href="../css/perinatalHistory.css">
                </head>
                    <h2>Nutrition/Immunization History</h2>
                    <div class="section">
                        <div class="section-title">Nutrition History</div>
                        <textarea id="nutritionTextarea"></textarea> 
                    </div>
                    <div class="section">
                        <div class="section-title">Immunization History</div>
                        <textarea id="immunizationTextarea"></textarea> 
                    </div>
                  
                    <button type="submit" id="saveNutritionHistory">Save</button>
                </div>
            `;
  
  
            // Setup textarea resizing logic
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach((textarea) => {
                textarea.addEventListener('input', () => {
                    textarea.style.height = 'auto';
                    textarea.style.height = `${textarea.scrollHeight}px`;
                });
            });
  
            // Save functionality
            const saveButton = document.getElementById('saveNutritionHistory');
            saveButton.addEventListener('click', async () => {
                saveButton.innerHTML = `<span class="saving-button-spinner"></span> Saving...`;
                saveButton.disabled = true;
  
               
  
                try {
                    const saveResponse = await fetch(`/save-nutrition/${registrationNumber}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ data }),
                    });
  
                    const saveResult = await saveResponse.json();
                    alert(saveResult.message || 'Nutrition/Immunization History saved successfully!');
                } catch (error) {
                    console.error('Error saving Nutrition/Immunization History:', error);
                    alert('Failed to save Nutrition/Immunization History. Please try again.');
                } finally {
                    saveButton.innerHTML = 'Save';
                    saveButton.disabled = false;
                }
            });
        } catch (error) {
            console.error('Error fetching Nutrition/Immunization History:', error);
            mainContent.innerHTML = `<p class="error-message">Failed to load Nutrition/Immunization History. Please try again later.</p>`;
        }
    });
  });
  