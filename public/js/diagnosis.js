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
        <style>
          body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
          }
  
          h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
          }
  
          .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width:600px;
          }
  
          #searchInput {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #007bff;
            border-radius: 25px;
            box-sizing: border-box;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            outline: none;
            margin-bottom: 15px;
          }
  
          #searchInput:focus {
            border-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
          }
  
          #results {
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
          }
  
          .result-item {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
            cursor: pointer;
          }
  
          .result-item:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          }
  
          .result-title {
            font-weight: bold;
            color: #333;
          }
  
          .loading {
            text-align: center;
            font-style: italic;
            color: #777;
          }
  
          .error {
            color: #dc3545;
            text-align: center;
            font-weight: bold;
          }
        </style>
        <h1>ICD-11 Disease Search</h1>
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