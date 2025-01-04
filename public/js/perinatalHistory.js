document.addEventListener('DOMContentLoaded', () => {
    const perinatalHistoryLink = document.querySelector('.floating-menu a[href="#perinatalHistory"]');
  
    perinatalHistoryLink.addEventListener('click', async (event) => {
        event.preventDefault();
        console.log('Perinatal History link clicked.');
  
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
  
            // Fetch the Perinatal History form structure
            const response = await fetch(`/perinatal-history/${registrationNumber}`);
            const result = await response.json();
  
            console.log('Fetch response:', result);
  
            // Replace content with form once loaded
            mainContent.innerHTML = `
                <div class="container">
                <head>
                <link rel="stylesheet" href="../css/perinatalHistory.css">
                </head>
                    <h2>Perinatal History</h2>
                    <div class="section">
                        <div class="section-title">Pre-conception</div>
                        <textarea id="preConceptionTextarea"></textarea> 
                    </div>
                    <div class="section">
                        <div class="section-title">Antenatal History</div>
                        <textarea id="antenatalHistoryTextarea"></textarea> 
                    </div>
                    <div class="section">
                        <div class="section-title">Birth History</div>
                        <div class="grid-container">
                            <div class="grid-item"><label for="parity">Parity:</label><input type="text" id="parity"></div>
                            <div class="grid-item"><label for="gestation">Gestation:</label><input type="text" id="gestation"></div>
                            <div class="grid-item"><label for="labour">Labour:</label><input type="text" id="labour"></div>
                            <div class="grid-item"><label for="delivery">Delivery:</label><input type="text" id="delivery"></div>
                            <div class="grid-item"><label for="agarScore">Agar Score:</label><input type="text" id="agarScore"></div>
                            <div class="grid-item"><label for="bwt">BWT:</label><input type="text" id="bwt"></div>
                        </div>
                    </div>
                    <div class="section">
                        <div class="section-title highlighted">Postnatal Period</div>
                        <div class="grid-container">
                            <div class="grid-item"><label for="bFeeding">B/Feeding:</label><input type="text" id="bFeeding"></div>
                            <div class="grid-item"><label for="hypoglaecemia">Hypoglaecemia:</label><input type="text" id="hypoglaecemia"></div>
                            <div class="grid-item"><label for="siezures">Siezures:</label><input type="text" id="siezures"></div>
                            <div class="grid-item"><label for="juandice">Juandice:</label><input type="text" id="juandice"></div>
                            <div class="grid-item"><label for="rds">RDS:</label><input type="text" id="rds"></div>
                            <div class="grid-item"><label for="sepsis">Sepsis:</label><input type="text" id="sepsis"></div>
                        </div>
                    </div>
                    <button type="submit" id="savePerinatalHistory">Save</button>
                </div>
            `;
  
            // Pre-fill form data if available
            if (response.ok && result.data) {
                const {
                    preConception,
                    antenatalHistory,
                    parity,
                    gestation,
                    labour,
                    delivery,
                    agarScore,
                    bwt,
                    bFeeding,
                    hypoglaecemia,
                    siezures,
                    juandice,
                    rds,
                    sepsis,
                } = result.data;
  
                document.getElementById('preConceptionTextarea').value = preConception || '';
                document.getElementById('antenatalHistoryTextarea').value = antenatalHistory || '';
                document.getElementById('parity').value = parity || '';
                document.getElementById('gestation').value = gestation || '';
                document.getElementById('labour').value = labour || '';
                document.getElementById('delivery').value = delivery || '';
                document.getElementById('agarScore').value = agarScore || '';
                document.getElementById('bwt').value = bwt || '';
                document.getElementById('bFeeding').value = bFeeding || '';
                document.getElementById('hypoglaecemia').value = hypoglaecemia || '';
                document.getElementById('siezures').value = siezures || '';
                document.getElementById('juandice').value = juandice || '';
                document.getElementById('rds').value = rds || '';
                document.getElementById('sepsis').value = sepsis || '';
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
            const saveButton = document.getElementById('savePerinatalHistory');
            saveButton.addEventListener('click', async () => {
                saveButton.innerHTML = `<span class="saving-button-spinner"></span> Saving...`;
                saveButton.disabled = true;
  
                const data = {
                    preConception: document.getElementById('preConceptionTextarea').value,
                    antenatalHistory: document.getElementById('antenatalHistoryTextarea').value,
                    parity: document.getElementById('parity').value,
                    gestation: document.getElementById('gestation').value,
                    labour: document.getElementById('labour').value,
                    delivery: document.getElementById('delivery').value,
                    agarScore: document.getElementById('agarScore').value,
                    bwt: document.getElementById('bwt').value,
                    bFeeding: document.getElementById('bFeeding').value,
                    hypoglaecemia: document.getElementById('hypoglaecemia').value,
                    siezures: document.getElementById('siezures').value,
                    juandice: document.getElementById('juandice').value,
                    rds: document.getElementById('rds').value,
                    sepsis: document.getElementById('sepsis').value,
                };
  
                try {
                    const saveResponse = await fetch(`/perinatal-history/${registrationNumber}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ data }),
                    });
  
                    const saveResult = await saveResponse.json();
                    alert(saveResult.message || 'Perinatal History saved successfully!');
                } catch (error) {
                    console.error('Error saving Perinatal History:', error);
                    alert('Failed to save Perinatal History. Please try again.');
                } finally {
                    saveButton.innerHTML = 'Save';
                    saveButton.disabled = false;
                }
            });
        } catch (error) {
            console.error('Error fetching Perinatal History:', error);
            mainContent.innerHTML = `<p class="error-message">Failed to load Perinatal History. Please try again later.</p>`;
        }
    });
  });
  