function search(event) {
  event.preventDefault();
  const searchTerm = document.getElementById('searchInput').value;
  const resultsDiv = document.getElementById('results');
  const searchLoading = document.getElementById('searchLoading'); // New loading indicator
  
  // Show new loading indicator and set "Loading..." in results
  searchLoading.style.display = 'inline-block';
  resultsDiv.innerHTML = '<div class="loading">Loading...</div>';

  fetch('/search', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: new URLSearchParams({ 'search_term': searchTerm })
  })
  .then(response => {
      if (!response.ok) throw new Error('Network response was not ok');
      return response.json();
  })
  .then(data => {
      console.log(data);
      resultsDiv.innerHTML = '';

      if (data.error) {
          resultsDiv.textContent = data.error;
      } else if (data.entities && data.entities.length > 0) {
          data.entities.forEach(disease => {
              const resultItem = document.createElement('div');
              resultItem.classList.add('result-item');
              const title = disease.title.replace(/<[^>]+>/g, '');

              resultItem.addEventListener('click', () => {
                  const selectedDiagnosesDiv = document.getElementById('selectedDiagnoses');
                  const diagnosisItem = document.createElement('div');
                  diagnosisItem.classList.add('diagnosis-item');
                  diagnosisItem.textContent = `${title} (Code: ${disease.code})`;

                  const deleteButton = document.createElement('button');
                  deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
                  deleteButton.addEventListener('click', () => {
                      selectedDiagnosesDiv.removeChild(diagnosisItem);
                  });

                  diagnosisItem.appendChild(deleteButton);
                  selectedDiagnosesDiv.appendChild(diagnosisItem);
                  document.getElementById('searchInput').value = '';
              });

              resultItem.innerHTML = `<span class="result-title">${title}</span> (Code: ${disease.code})`;
              resultsDiv.appendChild(resultItem);
          });
      } else {
          resultsDiv.textContent = "No results found.";
      }
  })
  .catch(error => {
      console.error('Error:', error);
      resultsDiv.innerHTML = '<div class="error">An error occurred.</div>';
  })
  .finally(() => {
      searchLoading.style.display = 'none'; // Hide new loading indicator when request completes
  });
}



  const diagnosis = document.querySelector('.floating-menu a[href="#diagnosis"]');
  
  diagnosis.addEventListener('click', (event) => {
    event.preventDefault();
  
    const mainContent = document.querySelector('.main');
    mainContent.innerHTML = `
      <div class="container">
  
      <head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
      <link rel="stylesheet" href="../css/diagnosis.css" >
      </head>
  <h1>Diagnosis</h1>
  <form id="searchForm">
    <div class="search-container"> 
        <label for="searchInput">Primary Diagnosis:</label>
        <div class="search-input-wrapper">
    <input type="text" id="searchInput" placeholder="Search for a disease...">
    <i class="fas fa-search search-icon" id="searchIcon"></i>
    <span id="searchLoading" class="loading-spinner" style="display: none;">
        <i class="fas fa-spinner fa-spin"></i>
    </span>
</div>

        <div id="resultsContainer">
            <div id="results"></div>
        </div>
    </div>
    <div class="selected-diagnoses-container"> 
        <label for="selectedDiagnoses">Selected Diagnoses:</label>
        <div id="selectedDiagnoses"></div>
    </div>
    <button type="button" id="saveDiagnosis" style="font-size:15px;">Save</button>
</form>

</div>
    `;
  
    const resultsContainer = document.getElementById('resultsContainer');
    const selectedDiagnosesDiv = document.getElementById('selectedDiagnoses');
    const saveButton = document.getElementById('saveDiagnosis');
    const searchInput = document.getElementById('searchInput'); // Get the search input element
  
   
    document.getElementById('searchIcon').addEventListener('click', (event) => {
      event.preventDefault();
      search(event); // No need to manually set loading indicator here
  });
  
  
  
  
  // Allow pressing "Enter" to trigger the search
  document.getElementById('searchInput').addEventListener('keypress', (event) => {
      if (event.key === 'Enter') {
          event.preventDefault();
          search(event);
      }
  });
  
  
    // Add event listener for Enter key press in the search input
    searchInput.addEventListener('keypress', (event) => {
      if (event.key === 'Enter') {
        search(event);
      }
    });
  
    document.addEventListener('click', (event) => {
      const resultsDiv = document.getElementById('results');
      const searchButton = document.querySelector('#searchForm button');
  
      if (resultsDiv && !resultsDiv.contains(event.target) &&
          event.target !== searchInput && event.target !== searchButton &&
          !selectedDiagnosesDiv.contains(event.target)) {
        resultsDiv.innerHTML = '';
      }
    });
  
    saveButton.addEventListener('click', async () => {
      const selectedDiagnoses = Array.from(selectedDiagnosesDiv.querySelectorAll('.diagnosis-item'))
        .map(item => item.textContent.trim());
    
      console.log("Saving diagnoses:", selectedDiagnoses);
      const registrationNumber = getRegistrationNumberFromUrl();
      console.log('Registration number:', registrationNumber);
    
      function getRegistrationNumberFromUrl() {
          const pathParts = window.location.pathname.split('/');
          return pathParts[pathParts.length - 1];
      }
    
      // Add Loading Indicator
      saveButton.disabled = true;
      saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    
      try {
        const response = await fetch(`/save-diagnosis/${registrationNumber}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ diagnoses: selectedDiagnoses })
        });
    
        if (response.ok) {
          alert('Diagnoses saved successfully!');
        } else {
          const errorData = await response.json();
          console.error('Error saving diagnoses:', errorData);
          alert('Error saving diagnoses. Please try again.');
        }
      } catch (error) {
        console.error('Error saving diagnoses:', error);
        alert('An error occurred while saving diagnoses.');
      } finally {
        // Remove Loading Indicator
        saveButton.disabled = false;
        saveButton.innerHTML = 'Save';
      }
    });
    
  });