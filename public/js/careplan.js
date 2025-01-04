const carePlan = document.querySelector('.floating-menu a[href="#carePlan"]');

  carePlan.addEventListener('click', (event) => {
      event.preventDefault();
  
      const mainContent = document.querySelector('.main');
      mainContent.innerHTML = `
      <head>
          <link rel='stylesheet' href='../css/carePlan.css'>
      </head>
      <body>
          <div class="container">
              <h2>Care Plan</h2>
              <div class="section">
                  <div class="section-title">Occupational Therapy</div>
                  <input type="checkbox" id="occupationalTherapy" name="occupationalTherapy">
              </div>
              <div class="section">
                  <div class="section-title">Speech Therapy</div>
                  <input type="checkbox" id="speechTherapy" name="speechTherapy">
              </div>
              <div class="section">
                  <div class="section-title">Sensory Integration</div>
                  <input type="checkbox" id="sensoryIntegration" name="sensoryIntegration">
              </div>
              <div class="section">
                  <div class="section-title">Physio therapy</div>
                  <input type="checkbox" id="physioTherapy" name="physioTherapy">
              </div>
              <div class="section">
                  <div class="section-title">Psychotherapy</div>
                  <input type="checkbox" id="physcoTherapy" name="physcoTherapy">
              </div>
              <div class="section">
                  <div class="section-title">ABA therapy</div>
                  <input type="checkbox" id="abaTherapy" name="abaTherapy">
              </div>
              <div class="section">
                  <div class="section-title">Nutritionist</div>
                  <input type="checkbox" id="nutritionist" name="nutritionist">
              </div>
              <button type="submit">Save</button>
              <div class="loading-indicator"></div>
          </div>
      </body>
      `;
  
      const submitButton = document.querySelector('.container button[type="submit"]');
      const loadingIndicator = document.querySelector('.loading-indicator');
  
      submitButton.addEventListener('click', async (event) => {
          event.preventDefault();
  
          submitButton.disabled = true;
          loadingIndicator.style.display = 'block';
  
          const urlParts = window.location.pathname.split('/');
          const registrationNumber = urlParts[urlParts.length - 1];
          console.log('Registration number: ', registrationNumber);
  
          const carePlanData = {
              occupationalTherapy: document.getElementById('occupationalTherapy').checked,
              speechTherapy: document.getElementById('speechTherapy').checked,
              physioTherapy: document.getElementById('physioTherapy').checked,
              physcoTherapy: document.getElementById('physcoTherapy').checked,
              abaTherapy: document.getElementById('abaTherapy').checked,
              nutritionist: document.getElementById('nutritionist').checked,
          };
  
          console.log('Collected Data: ', carePlanData); // Debugging log
  
          try {
              const response = await fetch(`http://127.0.0.1:8000/save-careplan/${registrationNumber}`, {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token
                  },
                  body: JSON.stringify(carePlanData),
              });
  
              const data = await response.json();
              console.log('Server Response: ', data); // Debugging log
              alert(data.message); // Success message
          } catch (error) {
              console.error('Error during fetch:', error);
              alert('Error: Failed to save care plan'); // Error message
          } finally {
              submitButton.disabled = false;
              loadingIndicator.style.display = 'none';
          }
      });
  });