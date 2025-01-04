const prescriptionsLink = document.querySelector('.floating-menu a[href="#prescriptions"]');

prescriptionsLink.addEventListener('click', async (event) => {
    event.preventDefault();

    const registrationNumber = getRegistrationNumberFromUrl();
    console.log('Registration number:', registrationNumber);

    function getRegistrationNumberFromUrl() {
        const pathParts = window.location.pathname.split('/');
        return pathParts[pathParts.length - 1];
    }

    const mainContent = document.querySelector('.main');
    mainContent.innerHTML = `
        <div class="loading-overlay">
            <div class="loading-spinner"></div>
        </div>
        <head><link rel="stylesheet" href="../css/prescriptions.css"></head>
        <h1>Drug Prescription Form</h1>
        <form id="prescription-form">
            <div class="container">
                <h2>Drugs</h2>
                <div class="drug-category">
                    <input type="checkbox" id="analgesics">
                    <label for="analgesics">Analgesics</label>
                    <div class="drug-list">
                        <input type="checkbox" id="paracet" name="drugs[analgesics][]" value="paracet"><label for="paracet">Paracet</label><br>
                        <input type="checkbox" id="ibuprofen" name="drugs[analgesics][]" value="ibuprofen"><label for="ibuprofen">Ibuprofen</label><br>
                        <input type="checkbox" id="diclofenac" name="drugs[analgesics][]" value="diclofenac"><label for="diclofenac">Diclofenac</label><br>
                        <input type="checkbox" id="cyclopam" name="drugs[analgesics][]" value="cyclopam"><label for="cyclopam">Cyclopam</label>
                    </div>
                </div>
                <div class="drug-category">
                    <input type="checkbox" id="antibiotics">
                    <label for="antibiotics">Antibiotics</label>
                    <div class="drug-list">
                        <input type="checkbox" id="amoxicillin" name="drugs[antibiotics][]" value="amoxicillin"><label for="amoxicillin">Amoxicillin</label><br>
                        <input type="checkbox" id="amox-clav" name="drugs[antibiotics][]" value="amox-clav"><label for="amox-clav">Amox-clav</label><br>
                        <input type="checkbox" id="cefuroxime" name="drugs[antibiotics][]" value="cefuroxime"><label for="cefuroxime">Cefuroxime</label><br>
                        <input type="checkbox" id="cefixime" name="drugs[antibiotics][]" value="cefixime"><label for="cefixime">Cefixime</label><br>
                        <input type="checkbox" id="azithromycin" name="drugs[antibiotics][]" value="azithromycin"><label for="azithromycin">Azithromycin</label><br>
                        <input type="checkbox" id="clarithromycin" name="drugs[antibiotics][]" value="clarithromycin"><label for="clarithromycin">Clarithromycin</label><br>
                        <input type="checkbox" id="cefuroxime" name="drugs[antibiotics][]" value="cefuroxime"><label for="cefuroxime">Cefuroxime</label><br>
                        <input type="checkbox" id="cefazolin" name="drugs[antibiotics][]" value="cefazolin"><label for="cefazolin">Cefazolin</label>
                    </div>
                </div>
                <div class="drug-category">
                    <input type="checkbox" id="antifungals">
                    <label for="antifungals">Antifungals</label>
                    <div class="drug-list">
                        <input type="checkbox" id="clotrimazole" name="drugs[antifungals][]" value="clotrimazole"><label for="clotrimazole">Clotrimazole</label><br>
                        <input type="checkbox" id="fluconazole" name="drugs[antifungals][]" value="fluconazole"><label for="fluconazole">Fluconazole</label>
                    </div>
                </div>
                <div class="drug-category">
                    <input type="checkbox" id="antihelminthics">
                    <label for="antihelminthics">Antihelminthics</label>
                    <div class="drug-list">
                        <input type="checkbox" id="albendazole" name="drugs[antihelminthics][]" value="albendazole"><label for="albendazole">Albendazole</label><br>
                        <input type="checkbox" id="mebendazole" name="drugs[antihelminthics][]" value="mebendazole"><label for="mebendazole">Mebendazole</label>
                    </div>
                </div>
                <div class="drug-category">
                    <input type="checkbox" id="antihistamines">
                    <label for="antihistamines">Antihistamines</label>
                    <div class="drug-list">
                        <input type="checkbox" id="cetrizine" name="drugs[antihistamines][]" value="cetrizine"><label for="cetrizine">Cetrizine</label><br>
                        <input type="checkbox" id="chlorpheniramine" name="drugs[antihistamines][]" value="chlorpheniramine"><label for="chlorpheniramine">Chlorpheniramine</label><br>
                        <input type="checkbox" id="prednisone" name="drugs[antihistamines][]" value="prednisone"><label for="prednisone">Prednisone</label><br>
                    </div>
                </div>
                <div class="drug-category">
                    <input type="checkbox" id="antipsychotics">
                    <label for="antipsychotics">Antipsychotics</label>
                    <div class="drug-list">
                        <input type="checkbox" id="risperidone" name="drugs[antipsychotics][]" value="risperidone"><label for="risperidone">Risperidone</label><br>
                        <input type="checkbox" id="methylphenidate" name="drugs[antipsychotics][]" value="methylphenidate"><label for="methylphenidate">Methylphenidate</label><br>
                        <input type="checkbox" id="aripiprazole" name="drugs[antipsychotics][]" value="aripiprazole"><label for="aripiprazole">Aripiprazole</label><br>
                        <input type="checkbox" id="fluoxetine" name="drugs[antipsychotics][]" value="fluoxetine"><label for="fluoxetine">Fluoxetine</label><br>
                        <input type="checkbox" id="baclofen" name="drugs[antipsychotics][]" value="baclofen"><label for="baclofen">Baclofen</label><br>
                        <input type="checkbox" id="atomoxetine" name="drugs[antipsychotics][]" value="atomoxetine"><label for="atomoxetine">Atomoxetine</label><br>
                        <input type="checkbox" id="lorazepam" name="drugs[antipsychotics][]" value="lorazepam"><label for="lorazepam">Lorazepam</label><br>
                        <input type="checkbox" id="buspirone" name="drugs[antipsychotics][]" value="buspirone"><label for="buspirone">Buspirone</label><br>
                        <input type="checkbox" id="clonidine" name="drugs[antipsychotics][]" value="clonidine"><label for="clonidine">Clonidine</label><br>
                        <input type="checkbox" id="guanfacine" name="drugs[antipsychotics][]" value="guanfacine"><label for="guanfacine">Guanfacine</label>
                    </div>
                </div>
                <div class="drug-category">
                    <input type="checkbox" id="supplements">
                    <label for="supplements">Supplements</label>
                    <div class="drug-list">
                        <input type="checkbox" id="calcium" name="drugs[supplements][]" value="calcium"><label for="calcium">Calcium</label><br>
                        <input type="checkbox" id="iron" name="drugs[supplements][]" value="iron"><label for="iron">Iron</label><br>
                        <input type="checkbox" id="multivitamins" name="drugs[supplements][]" value="multivitamins"><label for="multivitamins">Multivitamins</label><br>
                        <input type="checkbox" id="omega3" name="drugs[supplements][]" value="omega3"><label for="omega3">Omega 3</label><br>
                        <input type="checkbox" id="abidec" name="drugs[supplements][]" value="abidec"><label for="abidec">Abidec</label><br>
                        <input type="checkbox" id="folate" name="drugs[supplements][]" value="folate"><label for="folate">Folate</label><br>
                        <input type="checkbox" id="zinc" name="drugs[supplements][]" value="zinc"><label for="zinc">Zinc</label><br>
                        <input type="checkbox" id="vitaminA" name="drugs[supplements][]" value="vitaminA"><label for="vitaminA">Vitamin A</label>
                    </div>
                </div>
                <div class="drug-category">
                    <input type="checkbox" id="antiepileptics">
                    <label for="antiepileptics">Antiepileptics</label>
                    <div class="drug-list">
                        <input type="checkbox" id="sodium_valproate" name="drugs[antiepileptics][]" value="sodium_valproate"><label for="sodium_valproate">Sodium Valproate</label><br>
                        <input type="checkbox" id="phenobarbital" name="drugs[antiepileptics][]" value="phenobarbital"><label for="phenobarbital">Phenobarbital</label><br>
                        <input type="checkbox" id="phenytoin" name="drugs[antiepileptics][]" value="phenytoin"><label for="phenytoin">Phenytoin</label><br>
                        <input type="checkbox" id="topiramate" name="drugs[antiepileptics][]" value="topiramate"><label for="topiramate">Topiramate</label><br>
                        <input type="checkbox" id="levetiracetam" name="drugs[antiepileptics][]" value="levetiracetam"><label for="levetiracetam">Levetiracetam</label><br>
                        <input type="checkbox" id="clobazam" name="drugs[antiepileptics][]" value="clobazam"><label for="clobazam">Clobazam</label><br>
                        <input type="checkbox" id="lamotrigine" name="drugs[antiepileptics][]" value="lamotrigine"><label for="lamotrigine">Lamotrigine</label><br>
                        <input type="checkbox" id="clonazepam" name="drugs[antiepileptics][]" value="clonazepam"><label for="clonazepam">Clonazepam</label><br>
                        <input type="checkbox" id="carbamazepine" name="drugs[antiepileptics][]" value="carbamazepine"><label for="carbamazepine">Carbamazepine</label><br>
                        <input type="checkbox" id="gabapentin" name="drugs[antiepileptics][]" value="gabapentin"><label for="gabapentin">Gabapentin</label><br>
                    </div>
                </div>
            </div>
            <div class="container">
                <h2>Formulation</h2>
                <select id="formulation" name="formulation">
                    <option value="">Select Formulation</option>
                    <option value="syrup">Syrup</option>
                    <option value="tablet">Tablet</option>
                    <option value="capsule">Capsule</option>
                    <option value="drops">Drops</option>
                    <option value="sublingual">Sublingual</option>
                    <option value="topical">Topical</option>
                    <option value="intramuscular">Intramuscular</option>
                    <option value="intravenous">Intravenous</option>
                    <option value="subcutaneous">Subcutaneous</option>
                    <option value="nebuliza">Nebuliza</option>
                    <option value="suppository">Suppository</option>
                    <option value="enema">Enema</option>
                    <option value="inhalers">Inhalers</option>
                    <option value="nasal_spray">Nasal Spray</option>
                </select>
                <h2>Dose</h2>
                <input type="number" id="dose" name="dose" min="0">
                <h2>Units</h2>
                <select id="units" name="units">
                    <option value="">Select Units</option>
                    <option value="mg">mg</option>
                    <option value="ml">ml</option>
                    <option value="iu">IU</option>
                    <option value="drops">drops</option>
                    <option value="cm">cm</option>
                </select>
            </div>
            <div class="container">
                <h2>Frequency</h2>
                <select id="frequency" name="frequency">
                    <option value="">Select Frequency</option>
                    <option value="od">OD</option>
                    <option value="bd">BD</option>
                    <option value="tds">TDS</option>
                    <option value="qid">QID</option>
                    <option value="stat">Stat</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
                <h2>Duration</h2>
                <input type="radio" id="stat" name="duration" value="stat"><label for="stat">Stat</label><br>
                <input type="radio" id="days" name="duration" value="days"><label for="days">Days</label><br>
                <input type="radio" id="weeks" name="duration" value="weeks"><label for="weeks">Weeks</label><br>
                <input type="radio" id="months" name="duration" value="months"><label for="months">Months</label><br>
                <textarea id="duration_text" name="duration_text" style="display: block;"></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
    `;

    const loadingOverlay = document.querySelector('.loading-overlay');
    const form = document.getElementById('prescription-form');
    

    async function fetchPrescriptionData() {
        try {
            loadingOverlay.style.display = 'block';
            console.log("Fetching prescriptions for registration number:", registrationNumber);

            const response = await fetch(`/get-prescriptions/${registrationNumber}`);
            console.log('Response status:', response.status);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Prescription data:', data);

            if (data.prescriptionData) {
                populateForm(data.prescriptionData);
            } else {
                console.warn('No prescription data found.');
            }
        } catch (error) {
            console.error('Error fetching prescription:', error);
        } finally {
            loadingOverlay.style.display = 'none';
        }
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const submitButton = event.target.querySelector('button[type="submit"]');
        submitButton.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Saving...
        `;
        submitButton.disabled = true;

        const formData = new FormData(form);

        try {
            const response = await fetch(`/prescriptions/${registrationNumber}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            console.log('Response status:', response.status);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Server response:', data);
            alert('Prescription saved successfully!');
        } catch (error) {
            console.error('Error saving prescription:', error);
            alert('Failed to save prescription. Please try again.');
        } finally {
            submitButton.innerHTML = 'Submit';
            submitButton.disabled = false;
        }
    });

    function populateForm(prescriptionData) {
        // Populate drug categories and individual drugs
        const drugs = prescriptionData.drugs;
    
        // Loop through each drug category (like antibiotics, analgesics, etc.)
        for (const category in drugs) {
            // Get the category checkbox by ID (like "antibiotics", "analgesics", etc.)
            const categoryCheckbox = document.getElementById(category);
            
            // Get the list of drugs for the current category
            const drugList = drugs[category];
            
            // Loop through each drug in the list for the current category
            drugList.forEach(drug => {
                // Check if a checkbox exists with the drug name as the ID
                const drugCheckbox = document.getElementById(drug);
                if (drugCheckbox) {
                    // Check the individual drug checkbox
                    drugCheckbox.checked = true;
                }
            });
            
            // If there are drugs in this category, check the category checkbox
            if (drugList.length > 0 && categoryCheckbox) {
                categoryCheckbox.checked = true;
            }
            // Populate other form elements
            document.getElementById('formulation').value = prescriptionData.formulation;
            document.getElementById('dose').value = prescriptionData.dose;
            document.getElementById('units').value = prescriptionData.units;
            document.getElementById('frequency').value = prescriptionData.frequency;
    
            const durationType = prescriptionData.duration.type;
            const durationRadio = document.getElementById(durationType);
    
            if (durationRadio) {
                durationRadio.checked = true;
                if (durationType !== 'stat') {
                    document.getElementById('duration_text').value = prescriptionData.duration.value;
                    document.getElementById('duration_text').style.display = 'block';
                }
            } else {
                console.error('Invalid duration type:', durationType);
            }
        }
    }

    // Initial fetch on page load
    fetchPrescriptionData();
});