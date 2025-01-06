const carePlan = document.querySelector('.floating-menu a[href="#carePlan"]');

carePlan.addEventListener('click', (event) => {
    event.preventDefault();

    const mainContent = document.querySelector('.main');
    mainContent.innerHTML = `
    <head>
        <link rel="stylesheet" href="../css/carePlan.css">
    </head>
    <body>
        <div class="container">
            <h2>Management Plan</h2>
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
            <div class="section">
                <div class="section-title">Return Date</div>
                <input type="date" id="returnDate" name="returnDate">
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