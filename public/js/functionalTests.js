document.addEventListener('DOMContentLoaded', () => {
    // Inject CSS styles directly into the document
    const style = document.createElement('style');
    style.innerHTML = `
      body {
        font-family: sans-serif;
      }
  
      .container {
        width: 80%;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
      }
  
      h2 {
        text-align: center;
        margin-bottom: 20px;
      }
  
      .section-container {
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
      }
  
      h4 {
        margin-top: 0;
      }
  
      label {
        display: block;
        margin-bottom: 5px;
        cursor: pointer;
        color:black;
      }
  
      input[type="checkbox"],
      input[type="radio"] {
        margin-right: 5px;
      }
  
      button[type="submit"] {
        background-color:#007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
      }
  
      button[type="submit"]:hover {
        background-color: #0056b3;
      }
  
      table {
        width: 100%;
        border-collapse: collapse;
      }
  
      th,
      td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
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
  
      /* Sub-options Styles */
      .sub-options {
        display: none;
        margin-left: 20px;
      }
    `;
    document.head.appendChild(style);
  
    const investigations = document.querySelector('.floating-menu a[href="#functionalTests"]');
  
    investigations.addEventListener('click', (event) => {
      event.preventDefault();
  
      const mainContent = document.querySelector('.main');
      const urlParts = window.location.pathname.split('/');
      const registrationNumber = urlParts[urlParts.length - 1];
      console.log('Registration number: ', registrationNumber);
  
      // Inject HTML form into the page
      mainContent.innerHTML = `
        <div class="container">
          <h2>Investigations</h2>
  
          <div class="section-container">
  
          <div class="section-container">
            <h4>Functional Test</h4>
            <table>
              <thead>
                <tr>
                  <th>Test</th>
                  <th>Yes</th>
                  <th>No</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Vanderbilt Forms</td>
                  <td><input type="radio" name="functional_test_vanderbilt" value="yes"></td>
                  <td><input type="radio" name="functional_test_vanderbilt" value="no"></td>
                </tr>

                <tr>
                  <td>MCHAT</td>
                  <td><input type="radio" name="functional_test_mchat" value="yes"></td>
                  <td><input type="radio" name="functional_test_mchat" value="no"></td>
                </tr>

                <tr>
                <td>Conners</td>
                <td><input type="radio" name="functional_test_conners" value="yes"></td>
                <td><input type="radio" name="functional_test_conners" value="no"></td>
                </tr>

                <tr>
                <td>SNAP</td>
                <td><input type="radio" name="functional_test_SNAP" value="yes"></td>
                <td><input type="radio" name="functional_test_SNAP" value="no"></td>
                </tr>

                <tr>
                  <td>ADOS II</td>
                  <td><input type="radio" name="functional_test_ados" value="yes"></td>
                  <td><input type="radio" name="functional_test_ados" value="no"></td>
                </tr>
                <tr>
                  <td>Molteno Assessment Scale</td>
                  <td><input type="radio" name="functional_test_molten" value="yes"></td>
                  <td><input type="radio" name="functional_test_molten" value="no"></td>
                </tr>
                <tr>
                  <td>Griffiths III Scale</td>
                  <td><input type="radio" name="functional_test_grifiths" value="yes"></td>
                  <td><input type="radio" name="functional_test_grifiths" value="no"></td>
                </tr>

                <tr>
                <td>Bayley Scale of Infant Development</td>
                <td><input type="radio" name="functional_test_bayley" value="yes"></td>
                <td><input type="radio" name="functional_test_bayley" value="no"></td>
                </tr>

                 <tr>
                <td>Wechsler Intelligence Scale for Children</td>
                <td><input type="radio" name="functional_test_wechsler_intelligence" value="yes"></td>
                <td><input type="radio" name="functional_test_wechsler_intelligence" value="no"></td>
                </tr>

                 <tr>
                <td>Wechsler Individual Tests</td>
                <td><input type="radio" name="functional_test_wechsler_individual" value="yes"></td>
                <td><input type="radio" name="functional_test_wechsler_individual" value="no"></td>
                </tr>

                 <tr>
                <td>Stanford Binet Intelligence Scale</td>
                <td><input type="radio" name="functional_test_stanford" value="yes"></td>
                <td><input type="radio" name="functional_test_stanford" value="no"></td>
                </tr>

                 <tr>
                <td>Cognitive Assessment System</td>
                <td><input type="radio" name="functional_test_cognitive" value="yes"></td>
                <td><input type="radio" name="functional_test_cognitive" value="no"></td>
                </tr>

                 <tr>
                <td>Differential Ability Scales</td>
                <td><input type="radio" name="functional_test_differential" value="yes"></td>
                <td><input type="radio" name="functional_test_differential" value="no"></td>
                </tr>

                 <tr>
                <td>Universal Nonverbal Intelligence</td>
                <td><input type="radio" name="functional_test_universal" value="yes"></td>
                <td><input type="radio" name="functional_test_universal" value="no"></td>
                </tr>




                <tr>
                  <td>Sensory Profile</td>
                  <td><input type="radio" name="functional_test_senzeny" value="yes"></td>
                  <td><input type="radio" name="functional_test_senzeny" value="no"></td>
                </tr>
                <tr>
                  <td>Learning Disorder Tests</td>
                  <td><input type="radio" name="functional_test_learning" value="yes"></td>
                  <td><input type="radio" name="functional_test_learning" value="no"></td>
                </tr>
                <tr>
                  <td>Sleep Studies (PSG)</td>
                  <td><input type="radio" name="functional_test_sleep" value="yes"></td>
                  <td><input type="radio" name="functional_test_sleep" value="no"></td>
                </tr>

                 <tr>
                <td>Vineland Adaptive Behaviour Skills</td>
                <td><input type="radio" name="functional_test_vineland" value="yes"></td>
                <td><input type="radio" name="functional_test_vineland" value="no"></td>
                </tr>

                 <tr>
                <td>HINE Tests</td>
                <td><input type="radio" name="functional_test_hine" value="yes"></td>
                <td><input type="radio" name="functional_test_hine" value="no"></td>
                </tr>

                 <tr>
                <td>HOME Scales</td>
                <td><input type="radio" name="functional_test_HOME" value="yes"></td>
                <td><input type="radio" name="functional_test_HOME" value="no"></td>
                </tr>

                <tr>
                  <td>Education Assessment</td>
                  <td><input type="radio" name="functional_test_education" value="yes"></td>
                  <td><input type="radio" name="functional_test_education" value="no"></td>
                </tr>

                <tr>
                  <td>Other</td>
                  <td><input type="radio" name="functional_test_other" id="other-functional-checkbox" value="yes"></td>
                  <td><input type="radio" name="functional_test_other" value="no"></td>
                </tr>
              </tbody>
            </table>
            <textarea id="other-functional-tests" rows="4" cols="50"></textarea>
          </div>
  
          <button type="submit">Submit Request</button>
          <div class="loading-indicator"></div>
        </div>
      `;
  

      setupToggleVisibility('other-functional-checkbox', 'other-functional-tests');
  
      // Attach the submit event to save data
      const submitButton = document.querySelector('button[type="submit"]');
      const loadingIndicator = document.querySelector('.loading-indicator');
  
      submitButton.addEventListener('click', (event) => {
        event.preventDefault();
  
        submitButton.disabled = true;
        loadingIndicator.style.display = 'block';
  
        const collectedData = {
         
          functionalTests: getFunctionalTests(),
          otherFunctionalTests: document.getElementById('other-functional-tests').value.trim(),
        };
  
        console.log('Collected Data: ', collectedData); // Debugging log
  
        const postData = {
        
          functional_tests: collectedData.functionalTests,
          other_functional_tests: collectedData.otherFunctionalTests,
        };
  
        // Send data to the server
        sendInvestigationsData(registrationNumber, postData)
          .finally(() => {
            submitButton.disabled = false;
            loadingIndicator.style.display = 'none';
          });
      });
    });
  

    
      // Helper function to get the selected functional tests
      function getFunctionalTests() {
        return {
          vanderbilt: getRadioValue('functional_test_vanderbilt'),
          mchat: getRadioValue('functional_test_mchat'),
          ados: getRadioValue('functional_test_ados'),
          molten: getRadioValue('functional_test_molten'),
          grifiths: getRadioValue('functional_test_grifiths'),
          senzeny: getRadioValue('functional_test_senzeny'),
          learning: getRadioValue('functional_test_learning'),
          sleep: getRadioValue('functional_test_sleep'),
          education: getRadioValue('functional_test_education'),
          other: getRadioValue('functional_test_other'),
          other_tests: document.getElementById('other-functional-tests').value.trim(),
        };
      }
    
      // Helper function to get the selected radio button value
      function getRadioValue(name) {
        const radioButton = document.querySelector(`input[name="${name}"]:checked`);
        return radioButton ? radioButton.value : null;
      }
    
      // Function to send the collected data to the server
      function sendInvestigationsData(registrationNumber, postData) {
        console.log('Sending data to server...'); // Debugging log
        console.log('Post data: ', postData); // Debugging log
    
        return fetch(`/save-investigations/${registrationNumber}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token
          },
          body: JSON.stringify(postData),
        })
          .then(response => response.json())
          .then(data => {
            console.log('Server Response: ', data); // Debugging log
            alert(data.message); // Success message
          })
          .catch(error => {
            console.error('Error during fetch:', error);
            alert('Error: Failed to save investigations'); // Error message
          });
      }
    });
