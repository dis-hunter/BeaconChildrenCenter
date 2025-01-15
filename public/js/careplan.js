const carePlan = document.querySelector('.floating-menu a[href="#carePlan"]');

carePlan.addEventListener('click', (event) => {
    event.preventDefault();

    const mainContent = document.querySelector('.main');
    mainContent.innerHTML = `
    <head>
        <style>
  .container {
    width: 100%; 
    margin: 0 auto; 
    font-family: sans-serif;
    background-color: #f9f9f9;
    border-radius: 0; 
    box-shadow: none; 
    padding: 10px; 
    
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 5px; 
}

.row { 
    display: flex;
    justify-content: space-between; /* Distribute columns evenly */
    margin-bottom: 2px;
}

.section {
    display: flex;
    flex-direction: column; /* Stack title and textarea vertically */
    align-items: flex-start;
    width: 48%; /* Each section takes about half the row width */
    padding: 5px;
    border: none;
    background-color: transparent;
}

.section-title {
    font-weight: bold;
    margin-bottom: 2px; /* Add a small margin below title */
    color: #007bff;
}

textarea {
    width: 100%;
    padding: 5px;
    margin-top: 0;
    border: 1px solid #ccc;
    box-sizing: border-box;
    resize: none;
    border-radius: 4px;
    height: 30px; 
}

input[type="checkbox"] {
    margin-right: 5px; 
    accent-color: #007bff;
}

button[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 8px 16px; 
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 10px; 
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

.loading-indicator {
    display: none;
    text-align: center;
    margin-top: 5px; 
}

input[type="date"] {
    height: 30px; 
    padding: 5px;
}
        </style>
    </head>
    <body>
        <div class="container">
    <h2>Management Plan</h2>

    <div class="row">
        <div class="section">
            <div class="section-title">Occupational Therapy</div>
            <input type="checkbox" id="occupationalTherapy" name="occupationalTherapy">
            <textarea id="occupationalTherapyNotes" placeholder="Notes..."></textarea>
        </div>
        <div class="section">
            <div class="section-title">Speech Therapy</div>
            <input type="checkbox" id="speechTherapy" name="speechTherapy">
            <textarea id="speechTherapyNotes" placeholder="Notes..."></textarea>
        </div>
    </div>
    <div class="row">
        <div class="section">
            <div class="section-title">Sensory Integration</div>
            <input type="checkbox" id="sensoryIntegration" name="sensoryIntegration">
            <textarea id="sensoryIntegrationNotes" placeholder="Notes..."></textarea>
        </div>
        <div class="section">
            <div class="section-title">Physiotherapy</div>
            <input type="checkbox" id="physioTherapy" name="physioTherapy">
            <textarea id="physioTherapyNotes" placeholder="Notes..."></textarea>
        </div>
    </div>
    <div class="row">
        <div class="section">
            <div class="section-title">Psychotherapy</div>
            <input type="checkbox" id="psychotherapy" name="psychotherapy">
            <textarea id="psychotherapyNotes" placeholder="Notes..."></textarea>
        </div>
        <div class="section">
            <div class="section-title">ABA Therapy</div>
            <input type="checkbox" id="abaTherapy" name="abaTherapy">
            <textarea id="abaTherapyNotes" placeholder="Notes..."></textarea>
        </div>
    </div>
    <div class="row">
        <div class="section">
            <div class="section-title">Nutritionist</div>
            <input type="checkbox" id="nutritionist" name="nutritionist">
            <textarea id="nutritionistNotes" placeholder="Notes..."></textarea>
        </div>
        <div class="section">
            <div class="section-title">Medical Report</div>
            <input type="checkbox" id="medicalReport" name="medicalReport">
            <textarea id="medicalReportNotes" placeholder="Notes..."></textarea>
        </div>
    </div>
    <div class="row">
        <div class="section">
            <div class="section-title">Education Assessment</div>
            <input type="checkbox" id="educationAssessment" name="educationAssessment">
            <textarea id="educationAssessmentNotes" placeholder="Notes..."></textarea>
        </div>
        <div class="section">
            <div class="section-title">Referral</div>
            <input type="checkbox" id="referral" name="referral">
            <textarea id="referralNotes" placeholder="Notes..."></textarea>
        </div>
    </div>
    <div class="row">
        <div class="section">
            <div class="section-title">Assistive Devices</div>
            <input type="checkbox" id="assistiveDevices" name="assistiveDevices">
            <textarea id="assistiveDevicesNotes" placeholder="Notes..."></textarea>
        </div>
        <div class="section">
            <div class="section-title">Orthotics</div>
            <input type="checkbox" id="orthotics" name="orthotics">
            <textarea id="orthoticsNotes" placeholder="Notes..."></textarea>
        </div>
    </div>
    <div class="row"> 
        <div class="section">
            <div class="section-title">Other</div>
            <textarea id="otherNotes" placeholder="Notes..."></textarea> 
        </div>
        <div class="section">
            <div class="section-title">Return Date</div>
            <input type="date" id="returnDate" name="returnDate">
        </div>
    </div>

    <button type="submit">Save</button>
    <div class="loading-indicator"></div>
</div>
    </body>
    `;

    const submitButton = document.querySelector('.container button[type="submit"]');
    const loadingIndicator = document.querySelector('.loading-indicator');

    submitButton.addEventListener('click', async (event) => {
        event.preventDefault();

        submitButton.disabled = true;
        loadingIndicator.style.display = 'block';

        const urlParts = window.location.pathname.split('/');
        const registrationNumber = urlParts[urlParts.length - 1];
        console.log('Registration number: ', registrationNumber);

        const managementPlanData = {
            occupationalTherapy: document.getElementById('occupationalTherapy').checked,
            occupationalTherapyNotes: document.getElementById('occupationalTherapyNotes').value,
            speechTherapy: document.getElementById('speechTherapy').checked,
            speechTherapyNotes: document.getElementById('speechTherapyNotes').value,
            sensoryIntegration: document.getElementById('sensoryIntegration').checked,
            sensoryIntegrationNotes: document.getElementById('sensoryIntegrationNotes').value,
            physioTherapy: document.getElementById('physioTherapy').checked,
            physioTherapyNotes: document.getElementById('physioTherapyNotes').value,
            psychotherapy: document.getElementById('psychotherapy').checked,
            psychotherapyNotes: document.getElementById('psychotherapyNotes').value,
            abaTherapy: document.getElementById('abaTherapy').checked,
            abaTherapyNotes: document.getElementById('abaTherapyNotes').value,
            nutritionist: document.getElementById('nutritionist').checked,
            nutritionistNotes: document.getElementById('nutritionistNotes').value,
            medicalReport: document.getElementById('medicalReport').checked,
            medicalReportNotes: document.getElementById('medicalReportNotes').value,
            returnDate: document.getElementById('returnDate').value,
            educationAssessment: document.getElementById('educationAssessment').checked,
            educationAssessmentNotes: document.getElementById('educationAssessmentNotes').value,
            referral: document.getElementById('referral').checked,
            referralNotes: document.getElementById('referralNotes').value,
            assistiveDevices: document.getElementById('assistiveDevices').checked,
            assistiveDevicesNotes: document.getElementById('assistiveDevicesNotes').value,
            orthotics: document.getElementById('orthotics').checked,
            orthoticsNotes: document.getElementById('orthoticsNotes').value,
            otherNotes: document.getElementById('otherNotes').value, 
            returnDate: document.getElementById('returnDate').value,
        };

        console.log('Collected Data: ', managementPlanData);

        try {
            const response = await fetch(`/save-careplan/${registrationNumber}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(managementPlanData),
            });

            const data = await response.json();
            console.log('Server Response: ', data);
            alert(data.message);
        } catch (error) {
            console.error('Error during fetch:', error);
            alert('Error: Failed to save management plan');
        } finally {
            submitButton.disabled = false;
            loadingIndicator.style.display = 'none';
        }
    });
});