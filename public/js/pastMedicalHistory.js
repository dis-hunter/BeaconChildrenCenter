document.addEventListener('DOMContentLoaded', (event) => {
    const pastMedicalHistory = document.querySelector('.floating-menu a[href="#pastMedicalHistory"]');
    
    pastMedicalHistory.addEventListener('click', async (event) => {
      event.preventDefault();
      
      const registrationNumber = getRegistrationNumberFromUrl();
      console.log("Registration number:", registrationNumber); // Debugging line to check registration number
  
      // Show page loading indicator
      const pageLoadingIndicator = showLoadingIndicator();
      
      try {
        // Fetch the CSRF token
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        console.log("CSRF Token:", csrfToken); // Debugging CSRF token
  
        // Fetch past medical history data
        const response = await fetch(`/past-medical-history/${registrationNumber}`);
        const result = await response.json();
        console.log("Past Medical History Response:", result); // Debugging the response from the server
        
        const pastMedicalHistoryData = result.data;
        console.log("Past Medical History Data:", pastMedicalHistoryData); // Debugging the actual data
        
        const mainContent = document.querySelector('.main');
        mainContent.innerHTML = `
          <link rel='stylesheet' href='../css/pastMedicalHistory.css'>
          <div class="container">
            <h2>Past Medical History</h2>
            <div class="section">
              <div class="section-title">Illnesses</div>
              <textarea id="illnesses">${pastMedicalHistoryData ? pastMedicalHistoryData.illnesses : ''}</textarea>
            </div>
            <div class="section">
              <div class="section-title">Investigations</div>
              <textarea id="investigations">${pastMedicalHistoryData ? pastMedicalHistoryData.investigations : ''}</textarea>
            </div>
            <div class="section">
              <div class="section-title">Interventions</div>
              <textarea id="interventions">${pastMedicalHistoryData ? pastMedicalHistoryData.interventions : ''}</textarea>
            </div>
            <button type="submit" id="saveButton">Save</button>
           
          </div>
        `;
        
        // Remove the page loading indicator
        document.body.removeChild(pageLoadingIndicator);
        
        // Add textarea auto-resizing functionality
        addTextareaAutoResize();
  
        // Add save button functionality
        const saveButton = document.getElementById('saveButton');
        saveButton.addEventListener('click', async () => {
          console.log("Save button clicked"); // Debugging when save button is clicked
          
          showSaveButtonLoadingIndicator();
          
          const data = {
            illnesses: document.getElementById('illnesses').value,
            investigations: document.getElementById('investigations').value,
            interventions: document.getElementById('interventions').value,
          };
          
          console.log("Data to save:", data); // Debugging the data to be saved
  
          try {
            const saveResponse = await fetch(`/save-past-medical-history/${registrationNumber}`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
              },
              body: JSON.stringify({ data })
            });
  
            console.log("Save Response Status:", saveResponse.status); // Debugging the response status
  
            if (!saveResponse.ok) {
              throw new Error('Failed to save data');
            }
            
            alert("Past Medical History saved successfully!");
          } catch (error) {
            console.error('Error saving past medical history:', error);
            alert("Error saving past medical history. Please try again.");
          } finally {
            removeSaveButtonLoadingIndicator();
          }
        });
        
      } catch (error) {
        console.error('Error fetching past medical history:', error);
        document.body.removeChild(pageLoadingIndicator);
        alert("Error loading data. Please try again.");
      }
    });
  
    function getRegistrationNumberFromUrl() {
      const pathParts = window.location.pathname.split('/');
      const registrationNumber = pathParts[pathParts.length - 1];
      console.log("Registration Number from URL:", registrationNumber); // Debugging registration number extraction
      return registrationNumber;
    }
  
    function addTextareaAutoResize() {
      const textareas = document.querySelectorAll('textarea');
      textareas.forEach(textarea => {
        textarea.addEventListener('input', () => {
          textarea.style.height = 'auto';
          textarea.style.height = (textarea.scrollHeight) + 'px';
        });
        
        textarea.addEventListener('blur', () => {
          textarea.style.height = '30px';
        });
  
        // Trigger initial resize
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
      });
    }
  
    function showLoadingIndicator() {
      const loadingIndicator = document.createElement('div');
      loadingIndicator.id = 'page-loading-indicator';
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
      console.log("Page loading indicator shown"); // Debugging when the loading indicator is shown
      return loadingIndicator;
    }
  
    function showSaveButtonLoadingIndicator() {
      const saveButton = document.getElementById('saveButton');
      saveButton.disabled = true;
      saveButton.innerHTML = 'Saving...';
  
      const loadingDots = document.createElement('span');
      loadingDots.classList.add('loading-dots');
      loadingDots.style.cssText = `
          display: inline-flex;
          margin-left: 10px;
      `;
  
      for (let i = 0; i < 3; i++) {
          const dot = document.createElement('span');
          dot.style.cssText = `
              width: 6px;
              height: 6px;
              margin: 0 3px;
              background-color: #007bff;
              border-radius: 50%;
              display: inline-block;
              animation: pulse 1.5s infinite ease-in-out;
              animation-delay: ${i * 0.2}s;
          `;
          loadingDots.appendChild(dot);
      }
  
      saveButton.appendChild(loadingDots);
      console.log("Save button loading indicator shown"); // Debugging
  
      // Add animation styles
      const styleSheet = document.createElement('style');
      styleSheet.innerHTML = `
          @keyframes pulse {
              0% { transform: scale(1); opacity: 0.3; }
              50% { transform: scale(1.3); opacity: 1; }
              100% { transform: scale(1); opacity: 0.3; }
          }
      `;
      document.head.appendChild(styleSheet);
  }
  
  
    function removeSaveButtonLoadingIndicator() {
      const saveButton = document.getElementById('saveButton');
      saveButton.disabled = false;
      saveButton.innerHTML = 'Save';
      const spinner = saveButton.querySelector('.loading-spinner');
      if (spinner) {
        spinner.remove();
      }
      console.log("Save button loading indicator removed"); // Debugging when loading indicator is removed
    }
  });