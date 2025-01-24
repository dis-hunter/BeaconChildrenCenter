document.addEventListener('DOMContentLoaded', () => {
    // Inject CSS styles directly into the document
    const style = document.createElement('style');
    style.innerHTML = `
      .test-section {
        margin-bottom: 30px;
      }
  
      .test-section h4 {
        font-size: 1.4em;
        margin-bottom: 10px;
        font-weight: bold;
        color: blue;
      }
  
      .test-fields {
        display: flex;
        flex-direction: column;
        gap: 10px;
      }
  
      .test-fields div {
        display: flex;
        gap: 10px;
      }
  
      .test-fields textarea {
        width: 100%;
        padding: 8px;
        height: 50px;
        min-height: 30px;
        resize: vertical;
        box-sizing: border-box;
      }
  
      .test-name {
        font-weight: bold;
        width: 30%;
      }
  
      .test-input {
        width: 65%;
      }
  
      .overall-impression {
        margin-top: 30px;
      }
  
      .btn-container {
        margin-top: 20px;
      }
  
      .btn-container button {
        padding: 10px 20px;
        margin-right: 10px;
        cursor: pointer;
      }
  
      /* Loading Indicator Styles */
      .loading-indicator {
        border: 4px solid #f3f3f3;
        border-radius: 50%;
        border-top: 4px solid #3498db;
        /* Blue */
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        display: none;
        /* Hidden by default */
        margin: 0 auto;
        /* Center the indicator horizontally within its container */
      }
  
      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }
  
        100% {
          transform: rotate(360deg);
        }
      }
  
      /* Page Loading Indicator Styles */
      .page-loading-indicator {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Semi-transparent background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        /* Ensure it's on top */
        display: none;
        /* Hidden by default */
      }
    `;
    document.head.appendChild(style);
  
    const recordResults = document.querySelector('.floating-menu a[href="#recordResults"]');
    const mainContent = document.querySelector('.main');
    const pageLoadingIndicator = document.createElement('div');
    pageLoadingIndicator.classList.add('page-loading-indicator');
    pageLoadingIndicator.innerHTML = '<div class="loading-indicator"></div>';
    document.body.appendChild(pageLoadingIndicator);
  
    recordResults.addEventListener('click', async () => {
      pageLoadingIndicator.style.display = 'flex';
      mainContent.innerHTML = '';
  
      const urlParts = window.location.pathname.split('/');
      const registrationNumber = urlParts[urlParts.length - 1];
      console.log('Registration number:', registrationNumber);
  
      try {
        const response = await fetch(`/recordResults/${registrationNumber}`);
        const data = await response.json();
        console.log('Fetched data:', data);
  
        pageLoadingIndicator.style.display = 'none';
  
        if (data.message) {
          mainContent.innerHTML = `<p>${data.message}</p>`;
          return;
        }
  
        const fullName = JSON.parse(data.child.fullname);
        const patientName = `${fullName.first_name} ${fullName.middle_name || ''} ${fullName.last_name}`;
        mainContent.innerHTML = `
          <div class="container">
            <h3>Patient: ${patientName}</h3>
          </div>
        `;
  
        if (data.investigationData && data.investigationData.created_at) {
          const investigationDate = new Date(data.investigationData.created_at).toLocaleDateString();
          mainContent.innerHTML += `
            <div class="test-section">
              <h4>Investigation Details</h4>
              <p><strong>Date of Request:</strong> ${investigationDate}</p>
            </div>
          `;
        }
  
        const renderTestSection = (sectionTitle, tests, existingResults) => {
          if (tests && tests.length) {
            mainContent.innerHTML += `
              <div class="test-section">
                <h4>${sectionTitle}</h4>
              </div>
            `;
            tests.forEach(testName => {
              const existingResult = Array.isArray(existingResults)
                ? existingResults.find(result => result.name === testName)
                : undefined;
  
              mainContent.innerHTML += `
                <div class="test-fields">
                  <div class="test-name">${testName}</div>
                  <div class="test-input">
                    <textarea placeholder="Enter result value">${existingResult ? existingResult.value : ''}</textarea>
                    <textarea placeholder="Enter comments">${existingResult ? existingResult.comments : ''}</textarea>
                  </div>
                </div>
              `;
            });
          }
        };
  
        // Updated to match the new JSON format
        renderTestSection('Haematology', data.investigationData.haematology, data.investigationData.results);
        renderTestSection('hormoneTests', data.investigationData.hormoneTests, data.investigationData.results);
        renderTestSection('Biochemistry', data.investigationData.biochemistry, data.investigationData.results);
        renderTestSection('Urine', data.investigationData.urine, data.investigationData.results);
        renderTestSection('Stool', data.investigationData.stool, data.investigationData.results);
        renderTestSection('X-ray', data.investigationData.xray, data.investigationData.results);
        renderTestSection('MRI', data.investigationData.mri, data.investigationData.results);
        renderTestSection('CT', data.investigationData.ct, data.investigationData.results);
        renderTestSection('Electrophysiology', data.investigationData.electrophysiology, data.investigationData.results);
        renderTestSection('Genetic Tests', data.investigationData.genetic_tests, data.investigationData.results);
  
        mainContent.innerHTML += `
          <div class="overall-impression">
            <h3>Overall Impression/Summary</h3>
            <textarea rows="4" cols="50">${data.investigationData.overall_impression || ''}</textarea>
          </div>
          <div class="btn-container">
            <button type="submit">Save</button>
            <div class="loading-indicator"></div> 
            <button type="button">Print</button>
            <button type="button">Back</button>
          </div>
        `;
  
        // Auto-resize textareas
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
          textarea.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = `${this.scrollHeight}px`;
          });
          textarea.addEventListener('blur', function () {
            this.style.height = '50px';
          });
        });
  
        const saveButton = document.querySelector('.btn-container button[type="submit"]');
        const loadingIndicator = document.querySelector('.btn-container .loading-indicator');
  
        saveButton.addEventListener('click', async () => {
          saveButton.disabled = true;
          loadingIndicator.style.display = 'block';
  
          const results = [];
          document.querySelectorAll('.test-fields').forEach(field => {
            const name = field.querySelector('.test-name').innerText.trim();
            const value = field.querySelector('textarea:nth-of-type(1)').value.trim();
            const comments = field.querySelector('textarea:nth-of-type(2)').value.trim();
            results.push({ name, value, comments });
          });
  
          const overallImpressionElement = document.querySelector('.overall-impression textarea');
          const overallImpression = overallImpressionElement ? overallImpressionElement.value.trim() : '';
  
          console.log('Data to be saved:', { results, overall_impression: overallImpression });
  
          try {
            const response = await fetch(`/saveInvestigationResults/${registrationNumber}`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              },
              body: JSON.stringify({ results, overall_impression: overallImpression }),
            });
  
            const result = await response.json();
            console.log('Server response:', result);
            alert(result.message);
          } catch (error) {
            console.error('Error saving data:', error);
            alert('An error occurred while saving.');
          } finally {
            saveButton.disabled = false;
            loadingIndicator.style.display = 'none';
          }
        });
  
      } catch (error) {
        console.error('Error fetching or processing data:', error);
        pageLoadingIndicator.style.display = 'none';
      }
    });
  });