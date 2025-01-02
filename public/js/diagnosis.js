const diagnosis = document.querySelector('.floating-menu a[href="#diagnosis"]');

diagnosis.addEventListener('click', async (event) => {
    event.preventDefault();

    const mainContent = document.querySelector('.main');
    mainContent.innerHTML = `<div class="loading">Loading...</div>`;
    console.log("Fetching diagnosis data...");

    const registrationNumber = window.location.pathname.split('/').pop();
    console.log("Registration Number:", registrationNumber);

    try {
        // Fetch existing diagnosis data
        const response = await fetch(`/diagnosis/${registrationNumber}`);
        const rawData = await response.text(); // Handle unexpected HTML responses gracefully

        try {
            const result = JSON.parse(rawData); // Parse JSON if the response is valid
            if (response.ok) {
                populateDiagnosisForm(mainContent, result.data || {}, registrationNumber);
            } else {
                console.error("Failed to fetch diagnosis data:", result.message);
                mainContent.innerHTML = `<div class="error">Error: ${result.message || "Failed to load diagnosis data."}</div>`;
            }
        } catch (parseError) {
            console.error("Error parsing response:", rawData);
            mainContent.innerHTML = `<div class="error">Unexpected server response. Please try again later.</div>`;
        }
    } catch (fetchError) {
        console.error("Error fetching diagnosis data:", fetchError);
        mainContent.innerHTML = `<div class="error">An unexpected error occurred while fetching diagnosis data.</div>`;
    }
});

function populateDiagnosisForm(container, data, registrationNumber) {
    console.log("Populating diagnosis form with data:", data);

    container.innerHTML = `
        <div class="container">
        <head>
        <link rel="stylesheet" href="../css/diagnosis.css">
        </head>
            <h2>Diagnosis</h2>

            <label for="primaryDiagnosis">Primary Diagnosis</label>
            <select id="primaryDiagnosis">
                <option value="" ${!data.primaryDiagnosis ? 'selected' : ''}>Select</option>
                <option value="Autism" ${data.primaryDiagnosis === 'Autism' ? 'selected' : ''}>Autism Spectrum Disorder</option>
                <option value="ADHD" ${data.primaryDiagnosis === 'ADHD' ? 'selected' : ''}>ADHD</option>
                <option value="Communication disorder" ${data.primaryDiagnosis === 'Communication disorder' ? 'selected' : ''}>Communication disorder</option>
                <option value="Intellectual disability" ${data.primaryDiagnosis === 'Intellectual disability' ? 'selected' : ''}>Intellectual disability</option>
                <option value="Global developmental delays" ${data.primaryDiagnosis === 'Global developmental delays' ? 'selected' : ''}>Global developmental delays</option>
                <option value="Learning disorder" ${data.primaryDiagnosis === 'Learning disorder' ? 'selected' : ''}>Learning disorder</option>
                <option value="Movement disorder" ${data.primaryDiagnosis === 'Movement disorder' ? 'selected' : ''}>Movement disorder</option>
                <option value="Social pragmatic disorder" ${data.primaryDiagnosis === 'Social pragmatic disorder' ? 'selected' : ''}>Social pragmatic disorder</option>
                <option value="Cerebral Palsy" ${data.primaryDiagnosis === 'Cerebral Palsy' ? 'selected' : ''}>Cerebral Palsy</option>
                <option value="Genetic Disorder" ${data.primaryDiagnosis === 'Genetic Disorder' ? 'selected' : ''}>Genetic Disorder</option>
                <option value="Epilepsy" ${data.primaryDiagnosis === 'Epilepsy' ? 'selected' : ''}>Epilepsy</option>
                <option value="Other" ${data.primaryDiagnosis === 'Other' ? 'selected' : ''}>Other</option>
            </select>

            <div id="otherDiagnosisContainer" style="display: ${data.primaryDiagnosis === 'Other' ? 'block' : 'none'};">
                <label for="otherDiagnosis">Other Diagnosis</label>
                <textarea id="otherDiagnosis">${data.otherDiagnosis || ''}</textarea>
            </div>

            <label for="secondaryDiagnosis">Secondary Diagnosis</label>
            <textarea id="secondaryDiagnosis">${data.secondaryDiagnosis || ''}</textarea>

            <button id="saveDiagnosis" type="button">Save</button>
        </div>
    `;

    addFormEventListeners(registrationNumber);
}

function addFormEventListeners(registrationNumber) {
    const primaryDiagnosisSelect = document.getElementById('primaryDiagnosis');
    const otherDiagnosisContainer = document.getElementById('otherDiagnosisContainer');
    const saveButton = document.getElementById('saveDiagnosis');

    primaryDiagnosisSelect.addEventListener('change', () => {
        if (primaryDiagnosisSelect.value === 'Other') {
            console.log('Showing "Other Diagnosis" textarea');
            otherDiagnosisContainer.style.display = 'block';
        } else {
            console.log('Hiding "Other Diagnosis" textarea');
            otherDiagnosisContainer.style.display = 'none';
        }
    });

    saveButton.addEventListener('click', async () => {
        const primaryDiagnosis = document.getElementById('primaryDiagnosis').value;
        const secondaryDiagnosis = document.getElementById('secondaryDiagnosis').value;
        const otherDiagnosis = document.getElementById('otherDiagnosis')?.value || null;

        saveButton.textContent = 'Saving...';
        saveButton.disabled = true;

        console.log("Saving diagnosis data:", {
            primaryDiagnosis,
            secondaryDiagnosis,
            otherDiagnosis,
        });

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log("CSRF Token:", csrfToken);

            const saveResponse = await fetch(`/diagnosis/${registrationNumber}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    primaryDiagnosis,
                    secondaryDiagnosis,
                    otherDiagnosis,
                }),
            });

            const rawSaveData = await saveResponse.text();

            try {
                const saveResult = JSON.parse(rawSaveData);
                if (saveResponse.ok) {
                    console.log("Save successful:", saveResult);
                    alert("Diagnosis saved successfully!");
                } else {
                    console.error("Save error response:", saveResult);
                    alert("Failed to save diagnosis: " + saveResult.message);
                }
            } catch (parseError) {
                console.error("Error parsing save response:", rawSaveData);
                alert("Unexpected response from server. Please try again later.");
            }
        } catch (error) {
            console.error("Error saving diagnosis:", error);
            alert("An unexpected error occurred while saving diagnosis.");
        } finally {
            saveButton.textContent = 'Save';
            saveButton.disabled = false;
            console.log("Save button reset to default state.");
        }
    });
}
