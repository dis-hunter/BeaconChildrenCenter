document.addEventListener('DOMContentLoaded', (event) => {
    const Examination = document.querySelector('.floating-menu a[href="#Examination"]');
  
    if (Examination) {
      Examination.addEventListener('click', async (event) => {
        event.preventDefault();
  
        const registrationNumber = getRegistrationNumberFromUrl();
        console.log("Registration number:", registrationNumber);
  
        // Show loading indicator for form loading
        const loadingIndicator = document.createElement('div');
        loadingIndicator.id = 'loading-indicator';
        loadingIndicator.style.cssText = `
          position: fixed;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          width: 40px;
          height: 40px;
          border-radius: 50%;
          border: 4px solid #ccc;
          border-color: #007bff transparent #007bff transparent;
          animation: loading-animation 1.2s linear infinite;
        `;
        document.body.appendChild(loadingIndicator);
  
        try {
          // Fetch the CSRF token from the meta tag
          const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
  
          // Create a new form element
          const examinationForm = document.createElement('form');
          examinationForm.id = 'examinationForm';
          examinationForm.innerHTML = `
          <head>
          <link rel="stylesheet" href="../css/Examination.css">
          </head>
            <div class="container">
              <h2>Examination</h2>
              <div class="section">
                <div class="section-title">CNS</div>
                <div class="grid-container">
                  <div class="grid-item">
                    <label for="avpu">AVPU:</label>
                    <select id="avpu">
                      <option value="A">A</option>
                      <option value="V">V</option>
                      <option value="P">P</option>
                      <option value="U">U</option>
                    </select>
                  </div>
                  <div class="grid-item">
                    <label for="vision">Vision:</label>
                    <input type="text" id="vision">
                  </div>
                  <div class="grid-item">
                    <label for="hearing">Hearing:</label>
                    <input type="text" id="hearing">
                  </div>
                  <div class="grid-item">
                    <label for="cranialNerves">Cranial Nerves:</label>
                    <input type="text" id="cranialNerves">
                  </div>
                  <div class="grid-item">
                    <label for="ambulation">Ambulation:</label>
                    <input type="text" id="ambulation">
                  </div>
                </div>
              </div>
              <div class="section">

              <div class="textarea-with-label">
                  <div class="textarea-label">CNS:</div>
                  <textarea id="cnsTextarea"></textarea>
                </div>
                <div class="textarea-with-label">
                  <div class="textarea-label">CardioVascular System:</div>
                  <textarea id="cardiovascularTextarea"></textarea>
                </div>
                <div class="textarea-with-label">
                  <div class="textarea-label">Respiratory System:</div>
                  <textarea id="respiratoryTextarea"></textarea>
                </div>
                <div class="textarea-with-label">
                  <div class="textarea-label">Musculoskeletal System:</div>
                  <textarea id="musculoskeletalTextarea"></textarea>
                </div>
                <div class="textarea-with-label">
                  <div class="textarea-label">Abdomen System:</div>
                  <textarea id="abdomenTextarea"></textarea>
                </div>
                <div class="textarea-with-label">
                  <div class="textarea-label">Other Systems:</div>
                  <textarea id="otherTextarea"></textarea>
                </div>
              </div>
              <button type="submit" id="saveButton">Save</button>
            </div>
          `;
  
          // Append the form to the main content area
          const mainContent = document.querySelector('.main');
          mainContent.innerHTML = ''; // Clear existing content
          mainContent.appendChild(examinationForm);
  
          // Remove form loading indicator
          document.body.removeChild(loadingIndicator);
  
          // Add event listener to the save button
          examinationForm.addEventListener('submit', async (event) => {
            event.preventDefault();
  
            // Show the save button loading indicator
            showSaveButtonLoadingIndicator();
  
            // Gather data from the form inputs
            const examinationData = {
              avpu: document.getElementById('avpu').value,
              vision: document.getElementById('vision').value,
              hearing: document.getElementById('hearing').value,
              cranialNerves: document.getElementById('cranialNerves').value,
              ambulation: document.getElementById('ambulation').value,
              cardiovascular: document.getElementById('cardiovascularTextarea').value,
              cns: document.getElementById('cnsTextarea').value,
              abdomen: document.getElementById('abdomenTextarea').value,
              respiratory: document.getElementById('respiratoryTextarea').value,
              musculoskeletal: document.getElementById('musculoskeletalTextarea').value,
              other: document.getElementById('otherTextarea').value,
            };
  
            console.log('Examination Data:', examinationData);
  
            try {
              const response = await fetch(`/save-cns-data/${registrationNumber}`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(examinationData),
              });
            
              if (!response.ok) {
                const errorText = await response.text(); // Get the response body for more details
                console.error('Server error response:', response.status, errorText);
                throw new Error(`Network response was not ok: ${response.status}`);
              }
            
              console.log('CNS data saved successfully!');
              alert("Examination data saved successfully!");
  
            } catch (error) {
              console.error('Error saving CNS data:', error);
              alert("Error saving CNS data. Please try again.");
            } finally {
              // Remove the save button loading indicator
              removeSaveButtonLoadingIndicator();
            }
          });
  
          // Textarea auto-resize (Optional implementation for auto-resize functionality)
        } catch (error) {
          console.error('Error loading examination form:', error);
          document.body.removeChild(loadingIndicator);
        }
      });
    }
  });
  
  // Helper functions to show/remove the save button loading indicator
  function showSaveButtonLoadingIndicator() {
    const saveButton = document.getElementById('saveButton');
    saveButton.disabled = true;
    saveButton.innerHTML = 'Saving... <span class="loading-spinner"></span>';
  
    const spinner = document.createElement('span');
    spinner.classList.add('loading-spinner');
    spinner.style.cssText = `
      border: 4px solid #f3f3f3;
      border-top: 4px solid #007bff;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      animation: spin 1s linear infinite;
      display: inline-block;
      margin-left: 10px;
    `;
    saveButton.appendChild(spinner);
  }
  
  function removeSaveButtonLoadingIndicator() {
    const saveButton = document.getElementById('saveButton');
    saveButton.disabled = false;
    saveButton.innerHTML = 'Save';
    const spinner = saveButton.querySelector('.loading-spinner');
    if (spinner) {
      spinner.remove();
    }
  }
  
  function getRegistrationNumberFromUrl() {
    const pathParts = window.location.pathname.split('/');
    return pathParts[pathParts.length - 1];
  }
  