function search(event) {
    event.preventDefault();
  
    const searchTerm = document.getElementById('searchInput').value;
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '<div class="loading">Loading...</div>';
  
    fetch('/search', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: new URLSearchParams({
        'search_term': searchTerm
      })
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
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
  
            // Add click event listener to each result item
            resultItem.addEventListener('click', () => {
              const searchInput = document.getElementById('searchInput');
              searchInput.value = title;
              resultsDiv.innerHTML = '';
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
      });
  }
  
  const diagnosis = document.querySelector('.floating-menu a[href="#diagnosis"]');
  
  diagnosis.addEventListener('click', (event) => {
    event.preventDefault();
  
    const mainContent = document.querySelector('.main');
    mainContent.innerHTML = `
      <div class="container">
       <head><link rel="stylesheet" href="../css/diagnosis.css"></head>
        <h1>Diagnosis</h1>
        <form id="searchForm">
          <div>
            <label for="searchInput">Primary Diagnosis:</label>
            <input type="text" id="searchInput" placeholder="Search for a disease...">
          </div>
          <div id="resultsContainer">
            <div id="results"></div>
          </div>
          <div>
            <label for="secondaryDiagnosis">Secondary Diagnosis:</label>
            <textarea id="secondaryDiagnosis"></textarea>
          </div>
          <button type="submit">Search</button>
        </form>
      </div>
    `;
  
    const resultsContainer = document.getElementById('resultsContainer');
  
    document.getElementById('searchForm').addEventListener('submit', search);
  
    document.addEventListener('click', (event) => {
      const resultsDiv = document.getElementById('results');
      const searchInput = document.getElementById('searchInput');
      const searchButton = document.querySelector('#searchForm button');
      const secondaryDiagnosis = document.getElementById('secondaryDiagnosis');
  
      if (resultsDiv && !resultsDiv.contains(event.target) &&
          event.target !== searchInput && event.target !== searchButton &&
          event.target !== secondaryDiagnosis) {
        resultsDiv.innerHTML = '';
      }
    });
  });