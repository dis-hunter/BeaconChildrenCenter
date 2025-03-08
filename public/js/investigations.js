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
  
    const investigations = document.querySelector('.floating-menu a[href="#investigations"]');
  
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
            <h4>Lab Tests</h4>
            <label><input type="checkbox" id="haematology-checkbox"> Haematology</label>
            <div id="haematology-options" class="sub-options">
              <label><input type="checkbox" name="haematology" value="Haemogram"> Haemogram</label>
              <label><input type="checkbox" name="haematology" value="PBF"> PBF</label>
              <label><input type="checkbox" name="haematology" value="Blood slide for malaria"> Blood Slide for Malaria</label>
              <label><input type="checkbox" name="haematology" value="BloodCulture"> Blood Culture/Sensitivity</label>
              <label><input type="checkbox" name="haematology" value="Sickling test"> Sickling Test</label>
              <label><input type="checkbox" id="haematology-other-checkbox" value="Other"> Other</label>
              <textarea id="haematology-other-textarea" rows="4" cols="50"></textarea>
            </div>


            <label><input type="checkbox" id="hormone-test-checkbox"> Hormone tests</label>
            <div id="hormone-test-options" class="sub-options">
            <label><input type="checkbox" name="hormone-test" value="Thyroid function tests"> Thyroid Function Tests</label>
            <label><input type="checkbox" name="hormone-test" value="Growth hormone"> Growth Hormone</label>
            <label><input type="checkbox" name="hormone-test" value="Prolactin"> Prolactin</label>
            <label><input type="checkbox" name="hormone-test" value="Cortisol"> Cortisol</label>
            <label><input type="checkbox" name="hormone-test" value="Insulin"> Insulin growth factors</label>
            <label><input type="checkbox" name="hormone-test" value="Testosterone"> Testosterone</label>
            <label><input type="checkbox" name="hormone-test" value="Estrogen"> Estrogen</label>
            <label><input type="checkbox" name="hormone-test" value="Progesterone"> Progesterone</label>
            <label><input type="checkbox" name="hormone-test" value="Follicle-stimulating hormone"> Follicle-stimulating hormone</label>
            <label><input type="checkbox" name="hormone-test" value="Luteinizing hormone"> Luteinizing hormone</label>
            <label><input type="checkbox" name="hormone-test" value="Parathyroid hormone"> Parathyroid hormone</label>
            <label><input type="checkbox" name="hormone-test" value="Adrenocorticotropic hormone"> Adrenocorticotropic hormone</label>
            </div>
        
  
            <label><input type="checkbox" id="biochemistry-checkbox"> Biochemistry</label>
            <div id="biochemistry-options" class="sub-options">
              <label><input type="checkbox" name="biochemistry" value="UEC"> UEC</label>
              <label><input type="checkbox" name="biochemistry" value="Electrolytes"> Electrolytes</label>
              <label><input type="checkbox" name="biochemistry" value="Liver function tests"> Liver Function Tests</label>
              <label><input type="checkbox" name="biochemistry" value="Random blood sugar"> Random Blood Sugar</label>
              <label><input type="checkbox" name="biochemistry" value="Serum magnesium"> Serum Magnesium</label>
              <label><input type="checkbox" name="biochemistry" value="Serum zinc"> Serum Zinc</label>
              <label><input type="checkbox" name="biochemistry" value="Serum mercury"> Serum Mercury</label>
              <label><input type="checkbox" name="biochemistry" value="Serum lead"> Serum Lead</label>
              <label><input type="checkbox" name="biochemistry" value="Serum calcium"> Serum Calcium</label>
              <label><input type="checkbox" name="biochemistry" value="Ferritin"> Ferritin</label>
              <label><input type="checkbox" name="biochemistry" value="Toxicology"> Toxicology</label>
              <label><input type="checkbox" id="biochemistry-other-checkbox" value="Creatinkinase"> Creatinkinase</label>
              <label><input type="checkbox" id="biochemistry-other-checkbox" value="Immunoglobins">Immunoglobins</label>
              <label><input type="checkbox" id="biochemistry-other-checkbox" value="C-reactive protein"> C-reactive protein</label>
              <label><input type="checkbox" id="biochemistry-other-checkbox" value="Other"> Other</label>
              <textarea id="biochemistry-other-textarea" rows="4" cols="50"></textarea>
            </div>
  
            <label><input type="checkbox" id="urine-checkbox"> Urine Tests</label>
            <div id="urine-options" class="sub-options">
              <label><input type="checkbox" name="urine" value="Urinalysis"> Urinalysis</label>
              <label><input type="checkbox" name="urine" value="Urine culture/sensitivity"> Urine Culture/Sensitivity</label>
              <label><input type="checkbox" name="urine" value="Glycosaminoglycan"> Glycosaminoglycan</label>
              <label><input type="checkbox" name="urine" value="Toxicology"> Toxicology</label>
              <label><input type="checkbox" name="urine" value="Urine for reducing substances"> Urine for Reducing Substances</label>
              <label><input type="checkbox" name="urine" value="Urine for amino acids"> Urine for Amino Acids</label>
              <label><input type="checkbox" name="urine" value="Urine for organic acids"> Urine for Organic Acids</label>
              <label><input type="checkbox" name="urine" value="Urine for mucopolysaccharides"> Urine for Mucopolysaccharides</label>
              <label><input type="checkbox" name="urine" value="Urine for porphyrins"> Urine for Porphyrins</label>
              <label><input type="checkbox" name="urine" value="Urine for porphobilinogen"> Urine for Porphobilinogen</label>
              <label><input type="checkbox" name="urine" value="Urine for homocysteine"> Urine for Homocysteine</label>
              <label><input type="checkbox" id="urine-other-checkbox" value="Other"> Other</label>
              <textarea id="urine-other-textarea" rows="4" cols="50"></textarea>
            </div>
  
            <label><input type="checkbox" id="stool-checkbox"> Stool Tests</label>
            <div id="stool-options" class="sub-options">
              <label><input type="checkbox" name="stool" value="Microscopy"> Microscopy</label>
              <label><input type="checkbox" name="stool" value="Culture/sensitivity"> Culture/Sensitivity</label>
              <label><input type="checkbox" name="stool" value="Rotavirus"> Rotavirus</label>
              <label><input type="checkbox" name="stool" value="Adenovirus"> Adenovirus</label>
              <label><input type="checkbox" name="stool" value="Stool for occult blood"> Stool for Occult Blood</label>
              <label><input type="checkbox" name="stool" value="Stool for reducing substances"> Stool for Reducing Substances</label>
              <label><input type="checkbox" name="stool" value="Stool for ova and cysts"> Stool for Ova and Cysts</label>
            
              <label><input type="checkbox" id="stool-other-checkbox" value="Other"> Other</label>
              <textarea id="stool-other-textarea" rows="4" cols="50"></textarea>
            </div>
            <labek><input type="checkbox" id="lab-test-other-checkbox">Other</label>
          <textarea id="lab-test-other-textarea" rows="4" cols="50"></textarea>
          </div>
          
  
          <div class="section-container">
            <h4>Imaging</h4>
            <label><input type="checkbox" id="xray-checkbox"> X-ray</label>
            <div id="xray-options" class="sub-options">
              <label><input type="checkbox" name="xray" value="Wrist"> Wrist</label>
              <label><input type="checkbox" name="xray" value="Humerus"> Humerus</label>
              <label><input type="checkbox" name="xray" value="Radius"> Radius</label>
              <label><input type="checkbox" name="xray" value="Hip"> Hip</label>
              <label><input type="checkbox" name="xray" value="Femur"> Femur</label>
              <label><input type="checkbox" name="xray" value="Tibia"> Tibia</label>
              <label><input type="checkbox" name="xray" value="Fibula"> Fibula</label>
              <label><input type="checkbox" name="xray" value="Knee"> Knee</label>
              <label><input type="checkbox" name="xray" value="Ankle"> Ankle</label>
              <label><input type="checkbox" name="xray" value="Foot"> Foot</label>
              <label><input type="checkbox" name="xray" value="Chest"> Chest</label>
              <label><input type="checkbox" name="xray" value="Abdomen"> Abdomen</label>
              <label><input type="checkbox" name="xray" value="Pelvis"> Pelvis</label>
              <label><input type="checkbox" name="xray" value="Skull"> Skull</label>
              <label><input type="checkbox" name="xray" value="Spine"> Spine</label>
              <label><input type="checkbox" name="xray" value="Shoulder"> Shoulder</label>
              <label><input type="checkbox" name="xray" value="Elbow"> Elbow</label>
              <label><input type="checkbox" name="xray" value="Hand"> Hand</label>
              <label><input type="checkbox" name="xray" value="Cervical spine"> Cervical Spine</label>
              <label><input type="checkbox" name="xray" value="Thoracic spine"> Thoracic Spine</label>
              <label><input type="checkbox" name="xray" value="Lumbar spine"> Lumbar Spine</label>
              <label><input type="checkbox" name="xray" value="Full body xray">Full Body Xray</label>
            </div>
  
            <label><input type="checkbox" id="mri-checkbox"> MRI Scan</label>
            <div id="mri-options" class="sub-options">
              <label><input type="checkbox" name="mri" value="Brain"> Brain</label>
              <label><input type="checkbox" name="mri" value="Spine"> Spine</label>
              <label><input type="checkbox" name="mri" value="Abdomen"> Abdomen</label>
              <label><input type="checkbox" name="mri" value="Chest"> Chest</label>
              <label><input type="checkbox" name="mri" value="Pelvis"> Pelvis</label>
              <label><input type="checkbox" name="mri" value="Sinuses"> Sinuses</label>
              <label><input type="checkbox" name="mri" value="Temporal bone"> Temporal Bone</label>
              <label><input type="checkbox" name="mri" value="Orbits"> Orbits</label>
              <label><input type="checkbox" name="mri" value="Neck"> Neck</label>
              <label><input type="checkbox" name="mri" value="Shoulder"> Shoulder</label>
              <label><input type="checkbox" name="mri" value="Elbow"> Elbow</label>
              <label><input type="checkbox" name="mri" value="Wrist"> Wrist</label>
              <label><input type="checkbox" name="mri" value="Hand"> Hand</label>
              <label><input type="checkbox" name="mri" value="Hip"> Hip</label>
              <label><input type="checkbox" name="mri" value="Knee"> Knee</label>
              <label><input type="checkbox" name="mri" value="Ankle"> Ankle</label>
              <label><input type="checkbox" name="mri" value="Foot"> Foot</label>
              <label><input type="checkbox" name="mri" value="Cervical spine"> Cervical Spine</label>
              <label><input type="checkbox" name="mri" value="Thoracic spine"> Thoracic Spine</label>
              <label><input type="checkbox" name="mri" value="Lumbar spine"> Lumbar Spine</label>
              <label><input type="checkbox" name="mri" value="Full body mri"> Full Body MRI</label>


            </div>
  
            <label><input type="checkbox" id="ct-checkbox"> CT Scan</label>
            <div id="ct-options" class="sub-options">
              <label><input type="checkbox" name="ct" value="Brain"> Brain</label>
              <label><input type="checkbox" name="ct" value="Spine"> Spine</label>
              <label><input type="checkbox" name="ct" value="Abdomen"> Abdomen</label>
              <label><input type="checkbox" name="ct" value="Chest"> Chest</label>
              <label><input type="checkbox" name="ct" value="Pelvis"> Pelvis</label>
              <label><input type="checkbox" name="ct" value="Sinuses"> Sinuses</label>
              <label><input type="checkbox" name="ct" value="Temporal bone"> Temporal Bone</label>
              <label><input type="checkbox" name="ct" value="Orbits"> Orbits</label>
              <label><input type="checkbox" name="ct" value="Neck"> Neck</label>
              <label><input type="checkbox" name="ct" value="Shoulder"> Shoulder</label>
              <label><input type="checkbox" name="ct" value="Elbow"> Elbow</label>
              <label><input type="checkbox" name="ct" value="Wrist"> Wrist</label>
              <label><input type="checkbox" name="ct" value="Hand"> Hand</label>
              <label><input type="checkbox" name="ct" value="Hip"> Hip</label>
              <label><input type="checkbox" name="ct" value="Knee"> Knee</label>
              <label><input type="checkbox" name="ct" value="Ankle"> Ankle</label>
              <label><input type="checkbox" name="ct" value="Foot"> Foot</label>
              <label><input type="checkbox" name="ct" value="Cervical spine"> Cervical Spine</label>
              <label><input type="checkbox" name="ct" value="Thoracic spine"> Thoracic Spine</label>
              <label><input type="checkbox" name="ct" value="Lumbar spine"> Lumbar Spine</label>
              <label><input type="checkbox" name="ct" value="Full body ct"> Full Body CT</label>
            </div>

            <label><input type="checkbox" id="ultrasound-checkbox"> Ultrasound</label>
            <div id="ultrasound-options" class="sub-options">
              <label><input type="checkbox" name="ultrasound" value="Abdomen"> Abdomen</
              <label><input type="checkbox" name="ultrasound" value="Pelvis"> Pelvis</label>
              <label><input type="checkbox" name="ultrasound" value="Kidney"> Kidney</label>
              <label><input type="checkbox" name="ultrasound" value="Liver"> Liver</label>
              <label><input type="checkbox" name="ultrasound" value="Gall bladder"> Gall Bladder</label>
              <label><input type="checkbox" name="ultrasound" value="Pancreas"> Pancreas</label>
              <label><input type="checkbox" name="ultrasound" value="Spleen"> Spleen</label>
              <label><input type="checkbox" name="ultrasound" value="Thyroid"> Thyroid</label>
              <label><input type="checkbox" name="ultrasound" value="Breast"> Breast</label>
              <label><input type="checkbox" name="ultrasound" value="Testis"> Testis</label>
              <label><input type="checkbox" name="ultrasound" value="Scrotum"> Scrotum</label>
              <label><input type="checkbox" name="ultrasound" value="Prostate"> Prostate</label>
              <label><input type="checkbox" name="ultrasound" value="Uterus"> Uterus</label>
              <label><input type="checkbox" name="ultrasound" value="Ovary"> Ovary</label>
              <label><input type="checkbox" name="ultrasound" value="Follicular study"> Follicular Study</label>
              <label><input type="checkbox" name="ultrasound" value="Fetal ultrasound"> Fetal Ultrasound</label>
              <label><input type="checkbox" name="ultrasound" value="Obstetric ultrasound"> Obstetric Ultrasound</label>
              <label><input type="checkbox" name="ultrasound" value="Doppler ultrasound"> Doppler Ultrasound</label>
              <label><input type="checkbox" name="ultrasound" value="Musculoskeletal ultrasound"> Musculoskeletal Ultrasound</label>
              <label><input type="checkbox" name="ultrasound" value="Vascular ultrasound"> Vascular Ultrasound</label>
              <label><input type="checkbox" name="ultrasound" value="Carotid ultrasound"> Carotid Ultrasound</label>
            </div>
          </div>
  
          <div class="section-container">
            <h4>Genetic Tests</h4>
            <label><input type="checkbox" name="genetic_tests" value="Karyotype"> Karyotype</label>
            <label><input type="checkbox" name="genetic_tests" value="Chromosomal microarray"> Chromosomal Microarray</label>
            <label><input type="checkbox" name="genetic_tests" value="Whole exome sequencing"> Whole Exome Sequencing</label>
            <label><input type="checkbox" name="genetic_tests" value="Whole genome sequencing"> Whole Genome Sequencing</label>
            <label><input type="checkbox" name="genetic_tests" value="FISH"> FISH</label>
            <label><input type="checkbox" name="genetic_tests" value="PCR"> PCR</label>
            <label><input type="checkbox" name="genetic_tests" value="MLPA"> MLPA</label>
            <label><input type="checkbox" name="genetic_tests" value="Sanger sequencing"> Sanger Sequencing</label>
            <label><input type="checkbox" name="genetic_tests" value="Epilepsy panel"> Epilepsy Panel</label>
            <label><input type="checkbox" name="genetic_tests" value="Autism panel"> Autism Panel</label>
            <label><input type="checkbox" name="genetic_tests" value="Developmental delay panel"> Developmental Delay Panel</label>
            <label><input type="checkbox" name="genetic_tests" value="Mitochondrial panel"> Mitochondrial Panel</label>
            <label><input type="checkbox" name="genetic_tests" value="Intellectual disablility panel">Intellectual Disability Panel</label>

            <label><input type="checkbox" name="genetic_tests" value="Other"> Other</label>
            <textarea name="genetic_tests_other" rows="4" cols="50"></textarea>
          </div>
  
          <div class="section-container">
            <h4>Electrophysiology Test</h4>
            <label><input type="checkbox" name="electrophysiology" value="BERA"> BERA</label>
            <label><input type="checkbox" name="electrophysiology" value="Visual evoked potentials"> Visual Evoked Potentials</label>
            <label><input type="checkbox" name="electrophysiology" value="EEG"> EEG</label>
            <label><input type="checkbox" name="electrophysiology" value="Nerve conduction studies"> Nerve Conduction Studies</label>
            <label><input type="checkbox" name="electrophysiology" value="PSG"> PSG</label>
            <label><input type="checkbox" name="electrophysiology" value="EMG"> EMG</label>
            <label><input type="checkbox" name="electrophysiology" value="Other"> Other</label>
            <textarea name="electrophysiology_other" rows="4" cols="50"></textarea>
          </div>
  
          <button type="submit">Submit Request</button>
          <div class="loading-indicator"></div>
        </div>
      `;
  
      // Toggle visibility of sub-options for each section
      setupToggleVisibility('haematology-checkbox', 'haematology-options');
      setupToggleVisibility('biochemistry-checkbox', 'biochemistry-options');
      setupToggleVisibility('urine-checkbox', 'urine-options');
      setupToggleVisibility('stool-checkbox', 'stool-options');
      setupToggleVisibility('xray-checkbox', 'xray-options');
      setupToggleVisibility('mri-checkbox', 'mri-options');
      setupToggleVisibility('ct-checkbox', 'ct-options');
      setupToggleVisibility('hormone-test-checkbox', 'hormone-test-options'); // Add this line
  
      // Toggle visibility of "Other" textareas
      setupToggleVisibility('haematology-other-checkbox', 'haematology-other-textarea');
      setupToggleVisibility('biochemistry-other-checkbox', 'biochemistry-other-textarea');
      setupToggleVisibility('urine-other-checkbox', 'urine-other-textarea');
      setupToggleVisibility('stool-other-checkbox', 'stool-other-textarea');
     
  
      // Attach the submit event to save data
      const submitButton = document.querySelector('button[type="submit"]');
      const loadingIndicator = document.querySelector('.loading-indicator');
  
      submitButton.addEventListener('click', (event) => {
        event.preventDefault();
  
        submitButton.disabled = true;
        loadingIndicator.style.display = 'block';
  
        const collectedData = {
          haematology: getCheckedValues('haematology'),
          hormoneTests: getCheckedValues('hormone-test'),
          biochemistry: getCheckedValues('biochemistry'),
          urine: getCheckedValues('urine'),
          stool: getCheckedValues('stool'),
          xray: getCheckedValues('xray'),
          mri: getCheckedValues('mri'),
          ct: getCheckedValues('ct'),
          geneticTests: getCheckedValues('genetic_tests'),
          electrophysiology: getCheckedValues('electrophysiology'),
          
          otherHaematology: document.getElementById('haematology-other-textarea').value.trim(),
          otherBiochemistry: document.getElementById('biochemistry-other-textarea').value.trim(),
          otherUrine: document.getElementById('urine-other-textarea').value.trim(),
          otherStool: document.getElementById('stool-other-textarea').value.trim(),
          
        };
  
        console.log('Collected Data: ', collectedData); // Debugging log
  
        const postData = {
          haematology: collectedData.haematology,
          hormoneTests: collectedData.hormoneTests,
          biochemistry: collectedData.biochemistry,
          urine: collectedData.urine,
          stool: collectedData.stool,
          xray: collectedData.xray,
          mri: collectedData.mri,
          ct: collectedData.ct,
          genetic_tests: collectedData.geneticTests,
          electrophysiology: collectedData.electrophysiology,
          otherHaematology: collectedData.otherHaematology,
          otherBiochemistry: collectedData.otherBiochemistry,
          otherUrine: collectedData.otherUrine,
          otherStool: collectedData.otherStool,
        };
  
        // Send data to the server
        sendInvestigationsData(registrationNumber, postData)
          .finally(() => {
            submitButton.disabled = false;
            loadingIndicator.style.display = 'none';
          });
      });
    });
  
    // Helper function to toggle visibility of sub-options
    function setupToggleVisibility(triggerId, targetId) {
      const trigger = document.getElementById(triggerId); 
      const target = document.getElementById(targetId);
  
      if (trigger && target) {
        trigger.addEventListener('change', function () {
            target.style.display = this.checked ? 'block' : 'none';
          });
        }
      }
    
      // Helper function to get checked values for checkboxes
      function getCheckedValues(name) {
        const checkboxes = document.querySelectorAll(`input[name="${name}"]:checked`);
        const values = [];
        checkboxes.forEach(checkbox => {
          values.push(checkbox.value);
        });
        return values;
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
