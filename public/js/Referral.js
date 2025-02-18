const referralButton = document.querySelector('.floating-menu a[href="#referral"]');
const mainContent = document.querySelector('.main');

referralButton.addEventListener('click', async (event) => {
  event.preventDefault();
  console.log("Referral button clicked");

  // Show loading indicator
  const loadingIndicator = document.createElement('div');
  loadingIndicator.classList.add('page-loading-indicator');
  loadingIndicator.innerHTML = '<div class="loading-indicator"></div>';
  document.body.appendChild(loadingIndicator);
  loadingIndicator.style.display = 'flex';

  const urlParts = window.location.pathname.split('/');
  const registrationNumber = urlParts[urlParts.length - 1];
  console.log("Extracted registration number:", registrationNumber);

  mainContent.innerHTML = '';

  try {
    console.log("Fetching child data...");
    const childResponse = await fetch(`/get-child-data/${registrationNumber}`);
    const childData = await childResponse.json();
    console.log("Child data fetched:", childData);

    if (childResponse.status === 404) {
      throw new Error(childData.message);
    }

    console.log("Fetching referral data...");
    const referralResponse = await fetch(`/get-referral-data/${registrationNumber}`);
    const referralData = referralResponse.ok ? await referralResponse.json() : null;
    console.log("Referral data fetched:", referralData);

    loadingIndicator.style.display = 'none';

    const fullName = JSON.parse(childData.fullname);
    const patientName = `${fullName.first_name} ${fullName.middle_name || ''} ${fullName.last_name}`;
    const today = new Date().toLocaleDateString();

    const dob = new Date(childData.dob);
    const age = Math.floor((new Date() - dob) / (365.25 * 24 * 60 * 60 * 1000));

    mainContent.innerHTML = `
      <div class="container">
        <head>
          <link rel="stylesheet" href="../css/referral.css">
        </head>
        <div class="section-container">
          <h4>Specialist</h4>
          <label><input type="checkbox" name="specialist" value="ENT Surgeon" ${referralData?.data?.specialists?.includes('ENT Surgeon') ? 'checked' : ''}> ENT Surgeon</label>
          <label><input type="checkbox" name="specialist" value="Orthopedic Surgeon" ${referralData?.data?.specialists?.includes('Orthopedic Surgeon') ? 'checked' : ''}> Orthopedic Surgeon</label>
          <label><input type="checkbox" name="specialist" value="Neurologist" ${referralData?.data?.specialists?.includes('Neurologist') ? 'checked' : ''}> Neurologist</label>
          <label><input type="checkbox" name="specialist" value="Developmental Pediatrician" ${referralData?.data?.specialists?.includes('Developmental Pediatrician') ? 'checked' : ''}> Developmental Pediatrician</label>
          <label><input type="checkbox" name="specialist" value="Endocrinologist" ${referralData?.data?.specialists?.includes('Endocrinologist') ? 'checked' : ''}> Endocrinologist</label>
          <label><input type="checkbox" name="specialist" value="Cardiologist" ${referralData?.data?.specialists?.includes('Cardiologist') ? 'checked' : ''}> Cardiologist</label>
          <label><input type="checkbox" name="specialist" value="Gastroenterologist" ${referralData?.data?.specialists?.includes('Gastroenterologist') ? 'checked' : ''}> Gastroenterologist</label>
          <label><input type="checkbox" name="specialist" value="Pulmonologist" ${referralData?.data?.specialists?.includes('Pulmonologist') ? 'checked' : ''}> Pulmonologist</label>
          <label><input type="checkbox" name="specialist" value="Dermatologist" ${referralData?.data?.specialists?.includes('Dermatologist') ? 'checked' : ''}> Dermatologist</label> 
          <label><input type="checkbox" name="specialist" value="Infectious Disease" ${referralData?.data?.specialists?.includes('Infectious Disease') ? 'checked' : ''}> Infectious Disease</label> 
          <label><input type="checkbox" name="specialist" value="Opthalmologist" ${referralData?.data?.specialists?.includes('Opthalmologist') ? 'checked' : ''}> Opthalmologist</label> 
          <label><input type="checkbox" name="specialist" value="Neurosurgeon" ${referralData?.data?.specialists?.includes('Neurosurgeon') ? 'checked' : ''}> Neurosurgeon</label> 
      </div>
        </div>

        <div class="referral-letter">
          <h3>Referral Letter</h3>
          <p><strong>Name:</strong> ${patientName}</p>
          <p><strong>Date:</strong> ${today}</p>
          <p><strong>ID:</strong> ${childData.registration_number}</p>
          <p><strong>Age:</strong> ${age}</p>
          <p><strong>Sex:</strong> ${childData.gender_id === 1 ? 'Male' : 'Female'}</p>
          <p><strong>Summary History:</strong></p>
          <textarea id="summaryHistory">${referralData?.data?.summaryHistory || ''}</textarea>
          <p><strong>Differential Diagnosis:</strong></p>
          <textarea id="differentialDiagnosis">${referralData?.data?.differentialDiagnosis || ''}</textarea>
          <p><strong>Reasons for Referral:</strong></p>
          <textarea id="reasonsForReferral">${referralData?.data?.reasonsForReferral || ''}</textarea>
          <p><strong>Referred to:</strong></p>
          <textarea id="referredTo">${referralData?.data?.referredTo || ''}</textarea>
        </div>

        <button id="printButton">Print Referral Letter</button>
        <button id="saveButton">Save Referral</button>
        <div class="loading-indicator"></div>
      </div>
    `;

    // Add event listener for saving the referral
    const saveButton = document.getElementById('saveButton');
    const saveLoadingIndicator = document.querySelector('.loading-indicator');
    saveButton.addEventListener('click', async (e) => {
      e.preventDefault();
      console.log("Save button clicked");
      saveButton.disabled = true;
      saveLoadingIndicator.style.display = 'block';

      const specialistCheckboxes = document.querySelectorAll('input[name="specialist"]:checked');
      const specialists = Array.from(specialistCheckboxes).map(checkbox => checkbox.value);

      const referralLetterData = {
        specialists,
        summaryHistory: document.getElementById('summaryHistory').value,
        differentialDiagnosis: document.getElementById('differentialDiagnosis').value,
        reasonsForReferral: document.getElementById('reasonsForReferral').value,
        referredTo: document.getElementById('referredTo').value,
      };

      try {
        const response = await fetch(`/save-referral/${registrationNumber}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
          body: JSON.stringify(referralLetterData),
        });

        const result = await response.json();
        console.log("Save referral response:", result);
        alert(result.message);
      } catch (error) {
        console.error("Error saving referral:", error);
        alert("Error: Failed to save referral");
      } finally {
        saveButton.disabled = false;
        saveLoadingIndicator.style.display = 'none';
      }
    });

    // Add event listener for printing the referral letter
    const printButton = document.getElementById('printButton');
    printButton.addEventListener('click', () => {
      console.log("Print button clicked");
      const printWindow = window.open('', '_blank');
      const referralLetterContent = document.querySelector('.referral-letter').innerHTML;
      printWindow.document.write(`
        <html>
          <head>
            <title>Referral Letter</title>
            <style>
              /* Add your print-specific CSS here */
               body {
            font-family: sans-serif;
            margin: 0; /* Remove default body margins */
          }
          .referral-letter { 
            width: 100%; /* Make the referral letter take full width */
            box-sizing: border-box; /* Include padding and border in width calculation */
            padding: 20px;
            font-size: 14px;
          } 
          .referral-letter p, .referral-letter textarea {
            width: 100%; /* Make all elements inside take full width */
            box-sizing: border-box;
          }
              /* ... other styles ... */ 
            </style>
          </head>
          <body>
            <div class="referral-letter">
              ${referralLetterContent}
            </div>
          </body>
        </html>
      `);
      printWindow.document.close();
      printWindow.focus();
      printWindow.print();
      printWindow.close();
    });
  } catch (error) {
    console.error("Error fetching data:", error);
    loadingIndicator.style.display = 'none';
    mainContent.innerHTML = `<p>Error: ${error.message}</p>`;
  }
});