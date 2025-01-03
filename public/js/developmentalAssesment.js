document.addEventListener('DOMContentLoaded', () => {
    const devAssesmentLink = document.querySelector('.floating-menu a[href="#devAssesment"]');
  
    devAssesmentLink.addEventListener('click', async (event) => {
        event.preventDefault();
        console.log('Development Assessment link clicked.');
  
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
  
            // Fetch the Development Assessment data
            const response = await fetch(`/development-assessment/${registrationNumber}`);
            const result = await response.json();
  
            console.log('Fetch response:', result);
  
            // Replace content with form once loaded
            mainContent.innerHTML = `
                <div class="container">
                <head> 
                <link rel="stylesheet" href="../css/devAssesment.css">
                </head>
  
                    <h2>Developmental Assessment</h2>
                    <div id="chronologicalAge">
                        <strong>Chronological Age: </strong> <span id="ageDisplay"></span> months
                    </div>
                    <div class="sections">
                        <div class="section">
                            <div class="section-title">Gross Motor</div>
                            <textarea id="grossMotor" placeholder="Enter details..."></textarea>
                            <div class="dev-age-container">
                                <div class="dev-age-heading">Dev Age</div>
                                <input id="grossDevAge" type="text" class="dev-age-input" placeholder="Enter developmental age">
                            </div>
                        </div>
                        <div class="section">
                            <div class="section-title">Fine Motor</div>
                            <textarea id="fineMotor" placeholder="Enter details..."></textarea>
                            <div class="dev-age-container">
                                <div class="dev-age-heading">Dev Age</div>
                                <input id="fineDevAge" type="text" class="dev-age-input" placeholder="Enter developmental age">
                            </div>
                        </div>
                        <div class="section">
                            <div class="section-title">Speech/Language</div>
                            <textarea id="speech" placeholder="Enter details..."></textarea>
                            <div class="dev-age-container">
                                <div class="dev-age-heading">Dev Age</div>
                                <input id="speechDevAge" type="text" class="dev-age-input" placeholder="Enter developmental age">
                            </div>
                        </div>
                        <div class="section">
                            <div class="section-title">Self Care</div>
                            <textarea id="selfCare" placeholder="Enter details..."></textarea>
                            <div class="dev-age-container">
                                <div class="dev-age-heading">Dev Age</div>
                                <input id="selfDevAge" type="text" class="dev-age-input" placeholder="Enter developmental age">
                            </div>
                        </div>
                        <div class="section">
                            <div class="section-title">Cognitive</div>
                            <textarea id="cognitive" placeholder="Enter details..."></textarea>
                            <div class="dev-age-container">
                                <div class="dev-age-heading">Dev Age</div>
                                <input id="cognitiveDevAge" type="text" class="dev-age-input" placeholder="Enter developmental age">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="save-btn">Save</button>
                </div>
            `;
  
            // Pre-fill form data if available
            if (response.ok && result.data) {
                const {
                    grossMotor,
                    fineMotor,
                    speech,
                    selfCare,
                    cognitive,
                    grossDevAge,
                    fineDevAge,
                    speechDevAge,
                    selfDevAge,
                    cognitiveDevAge,
                } = result.data;
  
                // Fill Chronological Age
                const chronologicalAge = result.chronologicalAgeMonths || '';
                document.getElementById('ageDisplay').textContent = chronologicalAge;
  
                // Check if the form fields exist before trying to populate them
                try {
                    if (document.getElementById('grossMotor')) {
                        document.getElementById('grossMotor').value = grossMotor || '';
                    }
                    if (document.getElementById('fineMotor')) {
                        document.getElementById('fineMotor').value = fineMotor || '';
                    }
                    if (document.getElementById('speech')) {
                        document.getElementById('speech').value = speech || '';
                    }
                    if (document.getElementById('selfCare')) {
                        document.getElementById('selfCare').value = selfCare || '';
                    }
                    if (document.getElementById('cognitive')) {
                        document.getElementById('cognitive').value = cognitive || '';
                    }
  
                    // Fill the Dev Age inputs if available
                    if (document.getElementById('grossDevAge')) {
                        document.getElementById('grossDevAge').value = grossDevAge || '';
                    }
                    if (document.getElementById('fineDevAge')) {
                        document.getElementById('fineDevAge').value = fineDevAge || '';
                    }
                    if (document.getElementById('speechDevAge')) {
                        document.getElementById('speechDevAge').value = speechDevAge || '';
                    }
                    if (document.getElementById('selfDevAge')) {
                        document.getElementById('selfDevAge').value = selfDevAge || '';
                    }
                    if (document.getElementById('cognitiveDevAge')) {
                        document.getElementById('cognitiveDevAge').value = cognitiveDevAge || '';
                    }
                } catch (err) {
                    console.error("Error pre-filling the form:", err);
                }
            }
  
            // Setup textarea resizing logic
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach((textarea) => {
                textarea.addEventListener('input', () => {
                    textarea.style.height = 'auto';
                    textarea.style.height = `${textarea.scrollHeight}px`;
                });
            });
  
            // Save functionality
            const saveButton = document.querySelector('.save-btn');
            saveButton.addEventListener('click', async () => {
                saveButton.innerHTML = `<span class="saving-button-spinner"></span> Saving...`;
                saveButton.disabled = true;
  
                const data = {
                    grossMotor: document.getElementById('grossMotor').value,
                    fineMotor: document.getElementById('fineMotor').value,
                    speech: document.getElementById('speech').value,
                    selfCare: document.getElementById('selfCare').value,
                    cognitive: document.getElementById('cognitive').value,
                    grossDevAge: document.getElementById('grossDevAge').value,
                    fineDevAge: document.getElementById('fineDevAge').value,
                    speechDevAge: document.getElementById('speechDevAge').value,
                    selfDevAge: document.getElementById('selfDevAge').value,
                    cognitiveDevAge: document.getElementById('cognitiveDevAge').value,
                };
  
                try {
                    const saveResponse = await fetch(`/development-assessment/${registrationNumber}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ data }),
                    });
  
                    const saveResult = await saveResponse.json();
                    alert(saveResult.message || 'Developmental Assessment saved successfully!');
                } catch (error) {
                    console.error('Error saving Developmental Assessment:', error);
                    alert('Failed to save Developmental Assessment. Please try again.');
                } finally {
                    saveButton.innerHTML = 'Save';
                    saveButton.disabled = false;
                }
            });
        } catch (error) {
            console.error('Error fetching Developmental Assessment:', error);
            mainContent.innerHTML = `<p class="error-message">Failed to load Developmental Assessment. Please try again later.</p>`;
        }
    });
  });