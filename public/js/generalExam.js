document.addEventListener('DOMContentLoaded', (event) => {
    const generalExam = document.querySelector('.floating-menu a[href="#generalExam"]');
  
    generalExam.addEventListener('click', async (event) => {
      event.preventDefault();
  
      const registrationNumber = getRegistrationNumberFromUrl();
      console.log("Registration number:", registrationNumber);
  
      // Show page loading indicator
      const pageLoadingIndicator = showLoadingIndicator();
  
      try {
        // Fetch the CSRF token
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        console.log("CSRF token:", csrfToken);
  
        // Fetch general examination data
        console.log(`Fetching data from /general-exam/${registrationNumber}`);
        const response = await fetch(`/general-exam/${registrationNumber}`);
        console.log("Response status:", response.status);
  
        if (!response.ok) {
          console.error("Error response received:", await response.text());
          throw new Error(`Failed to fetch data. Status: ${response.status}`);
        }
  
        const result = await response.json();
        console.log("Fetched data:", result);
  
        // Extract the general_exam_notes value or set it to an empty string if not present
        const generalExamNotes = result.data?.general_exam_notes || '';
        console.log("General Exam Notes:", generalExamNotes);
  
        const mainContent = document.querySelector('.main');
        mainContent.innerHTML = `
          <div class="container">
          <link rel='stylesheet' href='../css/generalExam.css'>
            <h2>General Examination</h2>
            <textarea id="generalExamTextarea">${generalExamNotes}</textarea>
            <button type="button" id="saveButton">Save</button>
          </div>
        `;
  
        // Remove the page loading indicator
        document.body.removeChild(pageLoadingIndicator);
  
        // Add textarea auto-resizing functionality
        addTextareaAutoResize();
  
        // Add save button functionality
        const saveButton = document.getElementById('saveButton');
        saveButton.addEventListener('click', async () => {
          showSaveButtonLoadingIndicator();
  
          const textarea = document.getElementById('generalExamTextarea');
          const generalExamNotesValue = textarea.value;
  
          const data = {
            general_exam_notes: generalExamNotesValue, // Save only the value from the textarea
          };
  
          console.log("Saving data:", data);
  
          try {
            const saveResponse = await fetch(`/general-exam/${registrationNumber}`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
              },
              body: JSON.stringify({ data }),
            });
  
            console.log("Save response status:", saveResponse.status);
  
            if (!saveResponse.ok) {
              console.error("Error saving data:", await saveResponse.text());
              throw new Error('Failed to save data');
            }
  
            alert("General Examination saved successfully!");
          } catch (error) {
            console.error('Error saving general examination:', error);
            alert("Error saving general examination. Please try again.");
          } finally {
            removeSaveButtonLoadingIndicator();
          }
        });
      } catch (error) {
        console.error('Error fetching general examination:', error);
        document.body.removeChild(pageLoadingIndicator);
        alert("Error loading data. Please try again.");
      }
    });
  
    function getRegistrationNumberFromUrl() {
      const pathParts = window.location.pathname.split('/');
      console.log("Path parts:", pathParts);
      return pathParts[pathParts.length - 1];
    }
  
    function addTextareaAutoResize() {
      const textareas = document.querySelectorAll('textarea');
      textareas.forEach(textarea => {
        textarea.addEventListener('input', () => {
          textarea.style.height = 'auto';
          textarea.style.height = (textarea.scrollHeight) + 'px';
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
      return loadingIndicator;
    }
  
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
  });