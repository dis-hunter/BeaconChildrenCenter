// Get the menu button and the floating menu elements
const menuButton = document.getElementById('menuButton');
const floatingMenu = document.getElementById('floatingMenu');

// Function to hide the menu
function hideMenu() {
  floatingMenu.style.display = 'none';
}

// Add a click event listener to the button to toggle the menu
menuButton.addEventListener('click', (event) => {
  // Prevent the click event from propagating to the document
  event.stopPropagation(); 

  if (floatingMenu.style.display === 'none') {
    floatingMenu.style.display = 'block';
  } else {
    floatingMenu.style.display = 'none';
  }
});

// Add a click event listener to the document to hide the menu
document.addEventListener('click', hideMenu);

// Add a click event listener to the menu itself to prevent hiding when clicking inside
floatingMenu.addEventListener('click', (event) => {
  event.stopPropagation(); 
});

const pastInvestigationsLink = document.getElementById('pastInvestigationsLink');
const pastInvestigationsMenu = document.getElementById('pastInvestigationsMenu');

pastInvestigationsLink.addEventListener('click', (event) => {
  event.preventDefault();
  pastInvestigationsMenu.style.display = pastInvestigationsMenu.style.display === 'block' ? 'none' : 'block';
});

const recordResultsLink = document.getElementById('recordResultsLink');
const recordResultsMenu = document.getElementById('recordResultsMenu');

recordResultsLink.addEventListener('click', (event) => {
  event.preventDefault();
  recordResultsMenu.style.display = recordResultsMenu.style.display === 'block' ? 'none' : 'block';
});

function hideMiniMenus() {
  const miniMenus = document.querySelectorAll('.mini-menu');
  miniMenus.forEach(menu => {
    menu.style.display = 'none';
  });
}

document.addEventListener('click', hideMiniMenus);

pastInvestigationsLink.addEventListener('click', (event) => {
  event.stopPropagation(); 
});

recordResultsLink.addEventListener('click', (event) => {
  event.stopPropagation(); 
});

pastInvestigationsMenu.addEventListener('click', (event) => {
  event.stopPropagation(); 
});

recordResultsMenu.addEventListener('click', (event) => {
  event.stopPropagation(); 
});

// Get the "Behaviour Assesement" link
const BehaviourAssessmentLink = document.querySelector('.floating-menu a[href="#behaviourAssessment"]');
BehaviourAssessmentLink.addEventListener('click', async (event) => {
    event.preventDefault();

    const mainContent = document.querySelector('.main');

    // Show the loading indicator specific to this feature
    showLoadingIndicator(mainContent, "behaviourAssessment-loading");

    try {
        console.log("Loading Behaviour Assessment form...");
        await loadBehaviourAssessmentForm(mainContent);
    } catch (error) {
        console.error("Error loading Behaviour Assessment:", error.message);
        mainContent.innerHTML = `<div class="error">Failed to load the form. Please try again.</div>`;
    } finally {
        console.log("Removing loading indicator...");
        removeLoadingIndicator("behaviourAssessment-loading");
    }
});

function showLoadingIndicator(parentElement, uniqueId) {
    if (!document.getElementById(uniqueId)) {
        const loadingIndicator = document.createElement('div');
        loadingIndicator.id = uniqueId;
        loadingIndicator.style = `
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
            z-index: 1000;
        `;
        parentElement.appendChild(loadingIndicator);

        if (!document.getElementById('loading-animation-styles')) {
            const loadingAnimationStyles = document.createElement('style');
            loadingAnimationStyles.id = 'loading-animation-styles';
            loadingAnimationStyles.textContent = `
                @keyframes loading-animation {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            `;
            document.head.appendChild(loadingAnimationStyles);
        }
    }
}

function removeLoadingIndicator(uniqueId) {
    const loadingIndicator = document.getElementById(uniqueId);
    if (loadingIndicator) {
        loadingIndicator.remove();
    }
}

async function loadBehaviourAssessmentForm(mainContent) {
    console.log("Rendering the form...");
    mainContent.innerHTML = `
    <div id="behaviourAssessment-container">
        
        <body>
            <div class="container">
                <h2>Behaviour Assessment</h2>
                <div class="section">
                    <div class="section-title">Hyperactivity</div>
                    <input type="text" id="hyperactivity">
                </div>
                <div class="section">
                    <div class="section-title">Attention</div>
                    <input type="text" id="attention">
                </div>
                <div class="section">
                    <div class="section-title">Social Interactions</div>
                    <input type="text" id="socialInteractions">
                </div>
                <div class="section">
                    <div class="section-title">Mood/Anxiety</div>
                    <input type="text" id="moodAnxiety">
                </div>
                <div class="section">
                    <div class="section-title">Play Interests</div>
                    <input type="text" id="playInterests">
                </div>
                <div class="section">
                    <div class="section-title">Communication</div>
                    <input type="text" id="communication">
                </div>
                <div class="section">
                    <div class="section-title">RRB</div>
                    <input type="text" id="rrb">
                </div>
                <div class="section">
                    <div class="section-title">Sensory Processing</div>
                    <input type="text" id="sensoryProcessing">
                </div>
                <div class="section">
                    <div class="section-title">Sleep</div>
                    <input type="text" id="sleep">
                </div>
                <div class="section">
                    <div class="section-title">Adaptive</div>
                    <input type="text" id="adaptive">
                </div>

                <button id="saveButton">Save</button>
            </div>
        </body>
    </div>
    `;

    console.log("Fetching Behaviour Assessment data...");
    const registrationNumber = "REG-001"; // You can replace with dynamic registration number
    await loadBehaviourAssessment(registrationNumber);

    // Add event listener to the save button
    const saveButton = document.getElementById("saveButton");
    saveButton.addEventListener("click", async () => {
        // Show spinner while saving
        saveButton.innerHTML = `<span class="saving-spinner"></span> Saving...`;
        saveButton.disabled = true;

        try {
            await saveBehaviourAssessment(registrationNumber);
        } finally {
            // Reset save button to its normal state
            saveButton.innerHTML = "Save";
            saveButton.disabled = false;
        }
    });

    // Add spinner styles
    const spinnerStyles = document.createElement('style');
    spinnerStyles.innerHTML = `
        .saving-spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #ccc;
            border-top: 2px solid #fff;
            border-radius: 50%;
            animation: loading-animation 1s linear infinite;
            margin-right: 8px;
        }
    `;
    document.head.appendChild(spinnerStyles);
}

async function loadBehaviourAssessment(registrationNumber) {
    try {
        const response = await fetch(`/get-behaviour-assessment/${registrationNumber}`);
        if (!response.ok) {
            throw new Error("Failed to fetch data");
        }

        const data = await response.json();
        console.log("Fetched Behaviour Assessment Data:", data); // Debugging: check the fetched data

        if (data && data.data) {
            const assessmentData = data.data; // No need to JSON.parse() here
            console.log("Populating form with data:", assessmentData); // Debugging: check the parsed data

            document.getElementById("hyperactivity").value = assessmentData["HyperActivity"] || "";
            document.getElementById("attention").value = assessmentData["Attention"] || "";
            document.getElementById("socialInteractions").value = assessmentData["SocialInteractions"] || "";
            document.getElementById("moodAnxiety").value = assessmentData["MoodAnxiety"] || "";
            document.getElementById("playInterests").value = assessmentData["PlayInterests"] || "";
            document.getElementById("communication").value = assessmentData["Communication"] || "";
            document.getElementById("rrb").value = assessmentData["RRB"] || "";
            document.getElementById("sensoryProcessing").value = assessmentData["SensoryProcessing"] || "";
            document.getElementById("sleep").value = assessmentData["Sleep"] || "";
            document.getElementById("adaptive").value = assessmentData["Adaptive"] || "";
        }
    } catch (error) {
        console.error("Error fetching Behaviour Assessment data:", error.message);
    }
}

async function saveBehaviourAssessment(registrationNumber) {
    try {
        const data = {
            HyperActivity: document.getElementById("hyperactivity").value,
            Attention: document.getElementById("attention").value,
            SocialInteractions: document.getElementById("socialInteractions").value,
            MoodAnxiety: document.getElementById("moodAnxiety").value,
            PlayInterests: document.getElementById("playInterests").value,
            Communication: document.getElementById("communication").value,
            RRB: document.getElementById("rrb").value,
            SensoryProcessing: document.getElementById("sensoryProcessing").value,
            Sleep: document.getElementById("sleep").value,
            Adaptive: document.getElementById("adaptive").value,
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        const response = await fetch(`/save-behaviour-assessment/${registrationNumber}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ data }),
        });

        if (response.ok) {
            alert("Behaviour Assessment saved successfully!");
        } else {
            throw new Error("Failed to save data");
        }
    } catch (error) {
        console.error("Error saving Behaviour Assessment:", error.message);
        alert("Error saving Behaviour Assessment. Please try again.");
    }
}


//Get the perinatal history Link
document.addEventListener('DOMContentLoaded', () => {
  const perinatalHistoryLink = document.querySelector('.floating-menu a[href="#perinatalHistory"]');

  perinatalHistoryLink.addEventListener('click', async (event) => {
      event.preventDefault();
      console.log('Perinatal History link clicked.');

      const mainContent = document.querySelector('.main');

      // Add CSS for the spinner directly to the document
      const style = document.createElement('style');
      style.innerHTML = `
          .loading-spinner {
              display: flex;
              align-items: center;
              justify-content: center;
              height: 100vh;
          }
          .spinner {
              border: 4px solid #f3f3f3;
              border-top: 4px solid #3498db;
              border-radius: 50%;
              width: 40px;
              height: 40px;
              animation: spin 2s linear infinite;
          }
          @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
          }
          .saving-button-spinner {
              border: 2px solid #f3f3f3;
              border-top: 2px solid white;
              border-radius: 50%;
              width: 14px;
              height: 14px;
              animation: spin 1s linear infinite;
              display: inline-block;
          }
          .error-message {
              color: red;
              text-align: center;
          }
      `;
      document.head.appendChild(style);

      // Add rotating circle loading indicator
      mainContent.innerHTML = `
          <div class="loading-spinner">
              <div class="spinner"></div>
          </div>
      `;

      try {
          const registrationNumber = window.location.pathname.split('/').pop();
          console.log('Registration number extracted:', registrationNumber);

          // Fetch the Perinatal History form structure
          const response = await fetch(`/perinatal-history/${registrationNumber}`);
          const result = await response.json();

          console.log('Fetch response:', result);

          // Replace content with form once loaded
          mainContent.innerHTML = `
              <div class="container">
              <head>
              <link rel="stylesheet" href="../css/perinatalHistory.css">
              </head>
                  <h2>Perinatal History</h2>
                  <div class="section">
                      <div class="section-title">Pre-conception</div>
                      <textarea id="preConceptionTextarea"></textarea> 
                  </div>
                  <div class="section">
                      <div class="section-title">Antenatal History</div>
                      <textarea id="antenatalHistoryTextarea"></textarea> 
                  </div>
                  <div class="section">
                      <div class="section-title">Birth History</div>
                      <div class="grid-container">
                          <div class="grid-item"><label for="parity">Parity:</label><input type="text" id="parity"></div>
                          <div class="grid-item"><label for="gestation">Gestation:</label><input type="text" id="gestation"></div>
                          <div class="grid-item"><label for="labour">Labour:</label><input type="text" id="labour"></div>
                          <div class="grid-item"><label for="delivery">Delivery:</label><input type="text" id="delivery"></div>
                          <div class="grid-item"><label for="agarScore">Agar Score:</label><input type="text" id="agarScore"></div>
                          <div class="grid-item"><label for="bwt">BWT:</label><input type="text" id="bwt"></div>
                      </div>
                  </div>
                  <div class="section">
                      <div class="section-title highlighted">Postnatal Period</div>
                      <div class="grid-container">
                          <div class="grid-item"><label for="bFeeding">B/Feeding:</label><input type="text" id="bFeeding"></div>
                          <div class="grid-item"><label for="hypoglaecemia">Hypoglaecemia:</label><input type="text" id="hypoglaecemia"></div>
                          <div class="grid-item"><label for="siezures">Siezures:</label><input type="text" id="siezures"></div>
                          <div class="grid-item"><label for="juandice">Juandice:</label><input type="text" id="juandice"></div>
                          <div class="grid-item"><label for="rds">RDS:</label><input type="text" id="rds"></div>
                          <div class="grid-item"><label for="sepsis">Sepsis:</label><input type="text" id="sepsis"></div>
                      </div>
                  </div>
                  <button type="submit" id="savePerinatalHistory">Save</button>
              </div>
          `;

          // Pre-fill form data if available
          if (response.ok && result.data) {
              const {
                  preConception,
                  antenatalHistory,
                  parity,
                  gestation,
                  labour,
                  delivery,
                  agarScore,
                  bwt,
                  bFeeding,
                  hypoglaecemia,
                  siezures,
                  juandice,
                  rds,
                  sepsis,
              } = result.data;

              document.getElementById('preConceptionTextarea').value = preConception || '';
              document.getElementById('antenatalHistoryTextarea').value = antenatalHistory || '';
              document.getElementById('parity').value = parity || '';
              document.getElementById('gestation').value = gestation || '';
              document.getElementById('labour').value = labour || '';
              document.getElementById('delivery').value = delivery || '';
              document.getElementById('agarScore').value = agarScore || '';
              document.getElementById('bwt').value = bwt || '';
              document.getElementById('bFeeding').value = bFeeding || '';
              document.getElementById('hypoglaecemia').value = hypoglaecemia || '';
              document.getElementById('siezures').value = siezures || '';
              document.getElementById('juandice').value = juandice || '';
              document.getElementById('rds').value = rds || '';
              document.getElementById('sepsis').value = sepsis || '';
          }

          // Setup textarea resizing logic
          const textareas = document.querySelectorAll('textarea');
          textareas.forEach((textarea) => {
              textarea.addEventListener('input', () => {
                  textarea.style.height = 'auto';
                  textarea.style.height = `${textarea.scrollHeight}px`;
              });
          });

          // Save functionality
          const saveButton = document.getElementById('savePerinatalHistory');
          saveButton.addEventListener('click', async () => {
              saveButton.innerHTML = `<span class="saving-button-spinner"></span> Saving...`;
              saveButton.disabled = true;

              const data = {
                  preConception: document.getElementById('preConceptionTextarea').value,
                  antenatalHistory: document.getElementById('antenatalHistoryTextarea').value,
                  parity: document.getElementById('parity').value,
                  gestation: document.getElementById('gestation').value,
                  labour: document.getElementById('labour').value,
                  delivery: document.getElementById('delivery').value,
                  agarScore: document.getElementById('agarScore').value,
                  bwt: document.getElementById('bwt').value,
                  bFeeding: document.getElementById('bFeeding').value,
                  hypoglaecemia: document.getElementById('hypoglaecemia').value,
                  siezures: document.getElementById('siezures').value,
                  juandice: document.getElementById('juandice').value,
                  rds: document.getElementById('rds').value,
                  sepsis: document.getElementById('sepsis').value,
              };

              try {
                  const saveResponse = await fetch(`/perinatal-history/${registrationNumber}`, {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                      },
                      body: JSON.stringify({ data }),
                  });

                  const saveResult = await saveResponse.json();
                  alert(saveResult.message || 'Perinatal History saved successfully!');
              } catch (error) {
                  console.error('Error saving Perinatal History:', error);
                  alert('Failed to save Perinatal History. Please try again.');
              } finally {
                  saveButton.innerHTML = 'Save';
                  saveButton.disabled = false;
              }
          });
      } catch (error) {
          console.error('Error fetching Perinatal History:', error);
          mainContent.innerHTML = `<p class="error-message">Failed to load Perinatal History. Please try again later.</p>`;
      }
  });
});


 
 //Get the Developmental Milestones Link
 const DevMilestonesLink = document.querySelector('.floating-menu a[href="#devMilestones"]');
 DevMilestonesLink.addEventListener('click', async (event) => {
     event.preventDefault();
 
     const mainContent = document.querySelector('.main');
 
     // Show the loading indicator specific to this feature
     showLoadingIndicator(mainContent, "devMilestones-loading");
 
     try {
         console.log("Loading Developmental Milestones form...");
         await loadDevelopmentalMilestonesForm(mainContent);
     } catch (error) {
         console.error("Error loading developmental milestones:", error.message);
         mainContent.innerHTML = `<div class="error">Failed to load the form. Please try again.</div>`;
     } finally {
         console.log("Removing loading indicator...");
         removeLoadingIndicator("devMilestones-loading");
     }
 });
 
 function showLoadingIndicator(parentElement, uniqueId) {
     if (!document.getElementById(uniqueId)) {
         const loadingIndicator = document.createElement('div');
         loadingIndicator.id = uniqueId;
         loadingIndicator.style = `
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
             z-index: 1000;
         `;
         parentElement.appendChild(loadingIndicator);
 
         if (!document.getElementById('loading-animation-styles')) {
             const loadingAnimationStyles = document.createElement('style');
             loadingAnimationStyles.id = 'loading-animation-styles';
             loadingAnimationStyles.textContent = `
                 @keyframes loading-animation {
                     0% { transform: rotate(0deg); }
                     100% { transform: rotate(360deg); }
                 }
             `;
             document.head.appendChild(loadingAnimationStyles);
         }
     }
 }
 
 function removeLoadingIndicator(uniqueId) {
     const loadingIndicator = document.getElementById(uniqueId);
     if (loadingIndicator) {
         loadingIndicator.remove();
     }
 }
 
 async function loadDevelopmentalMilestonesForm(mainContent) {
     console.log("Rendering the form...");
     mainContent.innerHTML = `
     <div id="devMilestones-container">
         <head>
             <link rel='stylesheet' href='../css/DevMilestones.css'>
         </head>
         <body>
             <div class="container">
                 <h2>Developmental Milestones</h2>
                 <div class="section">
                     <div class="section-title">Motor</div>
                     <div class="grid-container">
                         <div class="grid-item">
                             <label for="neckSupport">Neck Support:</label>
                             <input type="text" id="neckSupport">
                         </div>
                         <div class="grid-item">
                             <label for="sitting">Sitting:</label>
                             <input type="text" id="sitting">
                         </div>
                         <div class="grid-item">
                             <label for="crawling">Crawling:</label>
                             <input type="text" id="crawling">
                         </div>
                         <div class="grid-item">
                             <label for="standing">Standing:</label>
                             <input type="text" id="standing">
                         </div>
                         <div class="grid-item">
                             <label for="walking">Walking:</label>
                             <input type="text" id="walking">
                         </div>
                     </div>
                 </div>
 
                 <div class="section">
                     <div class="section-title">Speech Language</div>
                     <div class="grid-container">
                         <div class="grid-item">
                             <label for="coobing">Cooing/Babbling:</label>
                             <input type="text" id="coobing">
                         </div>
                         <div class="grid-item">
                             <label for="firstWord">First Word:</label>
                             <input type="text" id="firstWord">
                         </div>
                         <div class="grid-item">
                             <label for="vocabulary">Vocabulary:</label>
                             <input type="text" id="vocabulary">
                         </div>
                         <div class="grid-item">
                             <label for="phraseSpeech">Phrase Speech:</label>
                             <input type="text" id="phraseSpeech">
                         </div>
                         <div class="grid-item">
                             <label for="conversational">Conversational:</label>
                             <input type="text" id="conversational">
                         </div>
                     </div>
                 </div>
 
                 <div class="section">
                     <div class="section-title">Social Emotional</div>
                     <div class="grid-container">
                         <div class="grid-item">
                             <label for="smiling">Smiling/Laughing:</label>
                             <input type="text" id="smiling">
                         </div>
                         <div class="grid-item">
                             <label for="attachments">Attachments:</label>
                             <input type="text" id="attachments">
                         </div>
                     </div>
                 </div>
 
                 <div class="section">
                     <div class="section-title">Feeding</div>
                     <textarea id="feeding"></textarea>
                 </div>
 
                 <div class="section">
                     <div class="section-title">Elimination</div>
                     <textarea id="elimination"></textarea>
                 </div>
 
                 <div class="section">
                     <div class="section-title">Teething</div>
                     <textarea id="teething"></textarea>
                 </div>
 
                 <button id="saveButton">Save</button>
             </div>
         </body>
     </div>
     `;
 
     console.log("Fetching developmental milestones...");
     const registrationNumber = "REG-001";
     await loadDevelopmentalMilestones(registrationNumber);
 
     // Add event listener to the save button
     const saveButton = document.getElementById("saveButton");
     saveButton.addEventListener("click", async () => {
         // Add save button spinner
         saveButton.innerHTML = `<span class="saving-spinner"></span> Saving...`;
         saveButton.disabled = true;
 
         try {
             await saveDevelopmentalMilestones(registrationNumber);
         } finally {
             saveButton.innerHTML = "Save";
             saveButton.disabled = false;
         }
     });
 
     // Add spinner styling
     const spinnerStyles = document.createElement('style');
     spinnerStyles.innerHTML = `
         .saving-spinner {
             display: inline-block;
             width: 14px;
             height: 14px;
             border: 2px solid #ccc;
             border-top: 2px solid #fff;
             border-radius: 50%;
             animation: loading-animation 1s linear infinite;
             margin-right: 8px;
         }
     `;
     document.head.appendChild(spinnerStyles);
 }
 
 async function loadDevelopmentalMilestones(registrationNumber) {
     try {
         const response = await fetch(`/get-development-milestones/${registrationNumber}`);
         if (!response.ok) {
             throw new Error("Failed to fetch data");
         }
 
         const data = await response.json();
 
         if (data && data.data) {
             const milestones = JSON.parse(data.data);
             console.log("Populating form with data...");
             document.getElementById("neckSupport").value = milestones["Neck Support"] || "";
             document.getElementById("sitting").value = milestones["Sitting"] || "";
             document.getElementById("crawling").value = milestones["Crawling"] || "";
             document.getElementById("standing").value = milestones["Standing"] || "";
             document.getElementById("walking").value = milestones["Walking"] || "";
             document.getElementById("coobing").value = milestones["Cooing/Babbling"] || "";
             document.getElementById("firstWord").value = milestones["First Word"] || "";
             document.getElementById("vocabulary").value = milestones["Vocabulary"] || "";
             document.getElementById("phraseSpeech").value = milestones["Phrase Speech"] || "";
             document.getElementById("conversational").value = milestones["Conversational"] || "";
             document.getElementById("smiling").value = milestones["Smiling/Laughing"] || "";
             document.getElementById("attachments").value = milestones["Attachments"] || "";
             document.getElementById("feeding").value = milestones["Feeding"] || "";
             document.getElementById("elimination").value = milestones["Elimination"] || "";
             document.getElementById("teething").value = milestones["Teething"] || "";
         }
     } catch (error) {
         console.error("Error fetching developmental milestones:", error.message);
     }
 }
 
 async function saveDevelopmentalMilestones(registrationNumber) {
     try {
         const data = {
             "Neck Support": document.getElementById("neckSupport").value,
             Sitting: document.getElementById("sitting").value,
             Crawling: document.getElementById("crawling").value,
             Standing: document.getElementById("standing").value,
             Walking: document.getElementById("walking").value,
             "Cooing/Babbling": document.getElementById("coobing").value,
             "First Word": document.getElementById("firstWord").value,
             Vocabulary: document.getElementById("vocabulary").value,
             "Phrase Speech": document.getElementById("phraseSpeech").value,
             Conversational: document.getElementById("conversational").value,
             "Smiling/Laughing": document.getElementById("smiling").value,
             Attachments: document.getElementById("attachments").value,
             Feeding: document.getElementById("feeding").value,
             Elimination: document.getElementById("elimination").value,
             Teething: document.getElementById("teething").value,
         };
         const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
         const response = await fetch(`/save-development-milestones/${registrationNumber}`, {
             method: "POST",
             headers: {
                 "Content-Type": "application/json",
                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
             },
             body: JSON.stringify({ data }),
         });
 
         if (response.ok) {
             alert("Developmental Milestones saved successfully!");
         } else {
             throw new Error("Failed to save data");
         }
     } catch (error) {
         console.error("Error saving developmental milestones:", error.message);
         alert("Error saving Developmental Milestones. Please try again.");
     }
 }
 
 

 //Get the Family and Social History Link

 const familyAndSocial = document.querySelector('.floating-menu a[href="#familyAndSocial"]');

familyAndSocial.addEventListener('click', async (event) => {
    event.preventDefault();

    const mainContent = document.querySelector('.main');

    // Show a loading indicator while the form loads
    showLoadingIndicator(mainContent, "family-social-loading");

    try {
        console.log("Loading Family and Social History form...");
        const registrationNumber = getRegistrationNumberFromURL();
        console.log("Registration Number:", registrationNumber);

        await loadFamilyAndSocialHistoryForm(mainContent, registrationNumber);
    } catch (error) {
        console.error("Error loading Family and Social History form:", error.message);
        mainContent.innerHTML = `<div class="error">Failed to load the form. Please try again.</div>`;
    } finally {
        console.log("Removing loading indicator...");
        removeLoadingIndicator("family-social-loading");
    }
});

function getRegistrationNumberFromURL() {
    const urlParts = window.location.pathname.split('/');
    return urlParts[urlParts.length - 1]; // Assuming registration number is the last part of the URL
}

function showLoadingIndicator(parentElement, uniqueId) {
    if (!document.getElementById(uniqueId)) {
        const loadingIndicator = document.createElement('div');
        loadingIndicator.id = uniqueId;
        loadingIndicator.style = `
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
            z-index: 1000;
        `;
        parentElement.appendChild(loadingIndicator);

        if (!document.getElementById('loading-animation-styles')) {
            const loadingAnimationStyles = document.createElement('style');
            loadingAnimationStyles.id = 'loading-animation-styles';
            loadingAnimationStyles.textContent = `
                @keyframes loading-animation {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            `;
            document.head.appendChild(loadingAnimationStyles);
        }
    }
}

function removeLoadingIndicator(uniqueId) {
    const loadingIndicator = document.getElementById(uniqueId);
    if (loadingIndicator) {
        loadingIndicator.remove();
    }
}

async function loadFamilyAndSocialHistoryForm(mainContent, registrationNumber) {
    mainContent.innerHTML = `
        <div id="family-social-container">
            <div class="container">
                <h2>Family and Social History</h2>

                <div class="section">
                    <div class="section-title">Family Composition</div>
                    <textarea id="familyComposition"></textarea>
                </div>

                <div class="section">
                    <div class="section-title">Family Health/Social</div>
                    <textarea id="familyHealthSocial"></textarea>
                </div>

                <div class="section">
                    <div class="section-title">Schooling</div>
                    <textarea id="schooling"></textarea>
                </div>

                <button id="saveButton">Save</button>
            </div>
        </div>
    `;

    console.log("Fetching Family and Social History data...");
    await loadFamilyAndSocialHistory(registrationNumber);

    // Add event listener to the save button with spinner
    const saveButton = document.getElementById("saveButton");
    saveButton.addEventListener("click", async () => {
        // Show spinner while saving
        saveButton.innerHTML = `<span class="saving-spinner"></span> Saving...`;
        saveButton.disabled = true;

        try {
            await saveFamilyAndSocialHistory(registrationNumber);
        } finally {
            // Reset save button to its normal state
            saveButton.innerHTML = "Save";
            saveButton.disabled = false;
        }
    });

    // Initialize the textareas for dynamic resizing
    initializeTextareas();

    // Add spinner styles
    const spinnerStyles = document.createElement('style');
    spinnerStyles.innerHTML = `
        .saving-spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #ccc;
            border-top: 2px solid #fff;
            border-radius: 50%;
            animation: loading-animation 1s linear infinite;
            margin-right: 8px;
        }
    `;
    document.head.appendChild(spinnerStyles);
}

function initializeTextareas() {
    const textareas = document.querySelectorAll('textarea');

    textareas.forEach((textarea) => {
        textarea.addEventListener('input', () => {
            textarea.style.height = "auto"; // Reset height to auto to recalculate
            textarea.style.height = `${textarea.scrollHeight}px`; // Adjust height based on content
        });

        textarea.addEventListener('blur', () => {
            textarea.style.height = '30px'; // Reset to default height on blur
        });

        // Set initial height based on current content
        textarea.style.height = "auto";
        textarea.style.height = `${textarea.scrollHeight}px`;
    });
}

async function loadFamilyAndSocialHistory(registrationNumber) {
    try {
        const response = await fetch(`/get-family-social-history/${registrationNumber}`);
        if (!response.ok) {
            throw new Error("Failed to fetch data");
        }

        const data = await response.json();
        console.log("Fetched Family and Social History Data:", data);

        if (data && data.data) {
            const history = data.data;
            document.getElementById("familyComposition").value = history.FamilyComposition || "";
            document.getElementById("familyHealthSocial").value = history.FamilyHealthSocial || "";
            document.getElementById("schooling").value = history.Schooling || "";
        } else {
            console.log("No existing Family and Social History data found.");
        }
    } catch (error) {
        console.error("Error fetching Family and Social History data:", error.message);
    }
}

async function saveFamilyAndSocialHistory(registrationNumber) {
    try {
        const data = {
            FamilyComposition: document.getElementById("familyComposition").value,
            FamilyHealthSocial: document.getElementById("familyHealthSocial").value,
            Schooling: document.getElementById("schooling").value,
        };

        console.log("Saving Family and Social History data:", data);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch(`/save-family-social-history/${registrationNumber}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken, // Include the CSRF token in the request
            },
            body: JSON.stringify({ data }),
        });

        if (!response.ok) {
            throw new Error("Failed to save data");
        }

        const responseData = await response.json();
        console.log("Save Response:", responseData);
        alert(responseData.message || "Data saved successfully!");
    } catch (error) {
        console.error("Error saving Family and Social History data:", error.message);
        alert("Failed to save data. Please try again.");
    }
}

 

 //Get the Past Medical History Link

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
          <button type="button">Back</button>
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
    console.log("Save button loading indicator shown"); // Debugging save button loading state
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


 //Examination 
 document.addEventListener('DOMContentLoaded', (event) => {
  const Examination = document.querySelector('.floating-menu a[href="#Examination"]');

  if (Examination) {
    Examination.addEventListener('click', async (event) => {
      event.preventDefault();

      const registrationNumber = getRegistrationNumberFromUrl();
      console.log("Registration number:", registrationNumber);

      // Show loading indicator for form loading
      const loadingIndicator = document.createElement('div');
      loadingIndicator.id = 'loading-indicator';
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

      try {
        // Fetch the CSRF token from the meta tag
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        // Create a new form element
        const examinationForm = document.createElement('form');
        examinationForm.id = 'examinationForm';
        examinationForm.innerHTML = `
        <head>
        <link rel="stylesheet" href="../css/Examination.css">
        </head>
          <div class="container">
            <h2>Examination</h2>
            <div class="section">
              <div class="section-title">CNS</div>
              <div class="grid-container">
                <div class="grid-item">
                  <label for="avpu">AVPU:</label>
                  <select id="avpu">
                    <option value="A">A</option>
                    <option value="V">V</option>
                    <option value="P">P</option>
                    <option value="U">U</option>
                  </select>
                </div>
                <div class="grid-item">
                  <label for="vision">Vision:</label>
                  <input type="text" id="vision">
                </div>
                <div class="grid-item">
                  <label for="hearing">Hearing:</label>
                  <input type="text" id="hearing">
                </div>
                <div class="grid-item">
                  <label for="cranialNerves">Cranial Nerves:</label>
                  <input type="text" id="cranialNerves">
                </div>
                <div class="grid-item">
                  <label for="ambulation">Ambulation:</label>
                  <input type="text" id="ambulation">
                </div>
              </div>
            </div>
            <div class="section">
              <div class="section-title">Other Systems</div>
              <div class="textarea-with-label">
                <div class="textarea-label">CardioVascular System:</div>
                <textarea id="cardiovascularTextarea"></textarea>
              </div>
              <div class="textarea-with-label">
                <div class="textarea-label">Respiratory System:</div>
                <textarea id="respiratoryTextarea"></textarea>
              </div>
              <div class="textarea-with-label">
                <div class="textarea-label">Musculoskeletal System:</div>
                <textarea id="musculoskeletalTextarea"></textarea>
              </div>
            </div>
            <button type="submit" id="saveButton">Save</button>
          </div>
        `;

        // Append the form to the main content area
        const mainContent = document.querySelector('.main');
        mainContent.innerHTML = ''; // Clear existing content
        mainContent.appendChild(examinationForm);

        // Remove form loading indicator
        document.body.removeChild(loadingIndicator);

        // Add event listener to the save button
        examinationForm.addEventListener('submit', async (event) => {
          event.preventDefault();

          // Show the save button loading indicator
          showSaveButtonLoadingIndicator();

          // Gather data from the form inputs
          const examinationData = {
            avpu: document.getElementById('avpu').value,
            vision: document.getElementById('vision').value,
            hearing: document.getElementById('hearing').value,
            cranialNerves: document.getElementById('cranialNerves').value,
            ambulation: document.getElementById('ambulation').value,
            cardiovascular: document.getElementById('cardiovascularTextarea').value,
            respiratory: document.getElementById('respiratoryTextarea').value,
            musculoskeletal: document.getElementById('musculoskeletalTextarea').value,
          };

          console.log('Examination Data:', examinationData);

          try {
            const response = await fetch(`/save-cns-data/${registrationNumber}`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
              },
              body: JSON.stringify(examinationData),
            });
          
            if (!response.ok) {
              const errorText = await response.text(); // Get the response body for more details
              console.error('Server error response:', response.status, errorText);
              throw new Error(`Network response was not ok: ${response.status}`);
            }
          
            console.log('CNS data saved successfully!');
            alert("Examination data saved successfully!");

          } catch (error) {
            console.error('Error saving CNS data:', error);
            alert("Error saving CNS data. Please try again.");
          } finally {
            // Remove the save button loading indicator
            removeSaveButtonLoadingIndicator();
          }
        });

        // Textarea auto-resize (Optional implementation for auto-resize functionality)
      } catch (error) {
        console.error('Error loading examination form:', error);
        document.body.removeChild(loadingIndicator);
      }
    });
  }
});

// Helper functions to show/remove the save button loading indicator
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

function getRegistrationNumberFromUrl() {
  const pathParts = window.location.pathname.split('/');
  return pathParts[pathParts.length - 1];
}


  //Get CarePlan Link

const carePlan = document.querySelector('.floating-menu a[href="#carePlan"]');
carePlan.addEventListener('click', (event)=>{
    event.preventDefault();

    const mainContent=document.querySelector('.main');
    mainContent.innerHTML=`
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
    <div class="section-title">Physio therapy</div>
    <input type="checkbox" id="physioTherapy" name="physioTherapy">
  </div>

  <div class="section">
    <div class="section-title">Physco therapy</div>
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
</div>

</body>
    `
 });

 //Get  Developmental Assesment Link
 document.addEventListener('DOMContentLoaded', () => {
  const devAssesmentLink = document.querySelector('.floating-menu a[href="#devAssesment"]');

  devAssesmentLink.addEventListener('click', async (event) => {
      event.preventDefault();
      console.log('Development Assessment link clicked.');

      const mainContent = document.querySelector('.main');

      // Add CSS for the spinner directly to the document
      const style = document.createElement('style');
      style.innerHTML = `
          .loading-spinner {
              display: flex;
              align-items: center;
              justify-content: center;
              height: 100vh;
          }
          .spinner {
              border: 4px solid #f3f3f3;
              border-top: 4px solid #3498db;
              border-radius: 50%;
              width: 40px;
              height: 40px;
              animation: spin 2s linear infinite;
          }
          @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
          }
          .saving-button-spinner {
              border: 2px solid #f3f3f3;
              border-top: 2px solid white;
              border-radius: 50%;
              width: 14px;
              height: 14px;
              animation: spin 1s linear infinite;
              display: inline-block;
          }
          .error-message {
              color: red;
              text-align: center;
          }
      `;
      document.head.appendChild(style);

      // Add rotating circle loading indicator
      mainContent.innerHTML = `
          <div class="loading-spinner">
              <div class="spinner"></div>
          </div>
      `;

      try {
          const registrationNumber = window.location.pathname.split('/').pop();
          console.log('Registration number extracted:', registrationNumber);

          // Fetch the Development Assessment data
          const response = await fetch(`/development-assessment/${registrationNumber}`);
          const result = await response.json();

          console.log('Fetch response:', result);

          // Replace content with form once loaded
          mainContent.innerHTML = `
              <div class="container">
              <head> 
              <link rel="stylesheet" href="../css/devAssesment.css">
              </head>

                  <h2>Developmental Assessment</h2>
                  <div id="chronologicalAge">
                      <strong>Chronological Age: </strong> <span id="ageDisplay"></span> months
                  </div>
                  <div class="sections">
                      <div class="section">
                          <div class="section-title">Gross Motor</div>
                          <textarea id="grossMotor" placeholder="Enter details..."></textarea>
                          <div class="dev-age-container">
                              <div class="dev-age-heading">Dev Age</div>
                              <input id="grossDevAge" type="text" class="dev-age-input" placeholder="Enter developmental age">
                          </div>
                      </div>
                      <div class="section">
                          <div class="section-title">Fine Motor</div>
                          <textarea id="fineMotor" placeholder="Enter details..."></textarea>
                          <div class="dev-age-container">
                              <div class="dev-age-heading">Dev Age</div>
                              <input id="fineDevAge" type="text" class="dev-age-input" placeholder="Enter developmental age">
                          </div>
                      </div>
                      <div class="section">
                          <div class="section-title">Speech/Language</div>
                          <textarea id="speech" placeholder="Enter details..."></textarea>
                          <div class="dev-age-container">
                              <div class="dev-age-heading">Dev Age</div>
                              <input id="speechDevAge" type="text" class="dev-age-input" placeholder="Enter developmental age">
                          </div>
                      </div>
                      <div class="section">
                          <div class="section-title">Self Care</div>
                          <textarea id="selfCare" placeholder="Enter details..."></textarea>
                          <div class="dev-age-container">
                              <div class="dev-age-heading">Dev Age</div>
                              <input id="selfDevAge" type="text" class="dev-age-input" placeholder="Enter developmental age">
                          </div>
                      </div>
                      <div class="section">
                          <div class="section-title">Cognitive</div>
                          <textarea id="cognitive" placeholder="Enter details..."></textarea>
                          <div class="dev-age-container">
                              <div class="dev-age-heading">Dev Age</div>
                              <input id="cognitiveDevAge" type="text" class="dev-age-input" placeholder="Enter developmental age">
                          </div>
                      </div>
                  </div>
                  <button type="submit" class="save-btn">Save</button>
              </div>
          `;

          // Pre-fill form data if available
          if (response.ok && result.data) {
              const {
                  grossMotor,
                  fineMotor,
                  speech,
                  selfCare,
                  cognitive,
                  grossDevAge,
                  fineDevAge,
                  speechDevAge,
                  selfDevAge,
                  cognitiveDevAge,
              } = result.data;

              // Fill Chronological Age
              const chronologicalAge = result.chronologicalAgeMonths || '';
              document.getElementById('ageDisplay').textContent = chronologicalAge;

              // Check if the form fields exist before trying to populate them
              try {
                  if (document.getElementById('grossMotor')) {
                      document.getElementById('grossMotor').value = grossMotor || '';
                  }
                  if (document.getElementById('fineMotor')) {
                      document.getElementById('fineMotor').value = fineMotor || '';
                  }
                  if (document.getElementById('speech')) {
                      document.getElementById('speech').value = speech || '';
                  }
                  if (document.getElementById('selfCare')) {
                      document.getElementById('selfCare').value = selfCare || '';
                  }
                  if (document.getElementById('cognitive')) {
                      document.getElementById('cognitive').value = cognitive || '';
                  }

                  // Fill the Dev Age inputs if available
                  if (document.getElementById('grossDevAge')) {
                      document.getElementById('grossDevAge').value = grossDevAge || '';
                  }
                  if (document.getElementById('fineDevAge')) {
                      document.getElementById('fineDevAge').value = fineDevAge || '';
                  }
                  if (document.getElementById('speechDevAge')) {
                      document.getElementById('speechDevAge').value = speechDevAge || '';
                  }
                  if (document.getElementById('selfDevAge')) {
                      document.getElementById('selfDevAge').value = selfDevAge || '';
                  }
                  if (document.getElementById('cognitiveDevAge')) {
                      document.getElementById('cognitiveDevAge').value = cognitiveDevAge || '';
                  }
              } catch (err) {
                  console.error("Error pre-filling the form:", err);
              }
          }

          // Setup textarea resizing logic
          const textareas = document.querySelectorAll('textarea');
          textareas.forEach((textarea) => {
              textarea.addEventListener('input', () => {
                  textarea.style.height = 'auto';
                  textarea.style.height = `${textarea.scrollHeight}px`;
              });
          });

          // Save functionality
          const saveButton = document.querySelector('.save-btn');
          saveButton.addEventListener('click', async () => {
              saveButton.innerHTML = `<span class="saving-button-spinner"></span> Saving...`;
              saveButton.disabled = true;

              const data = {
                  grossMotor: document.getElementById('grossMotor').value,
                  fineMotor: document.getElementById('fineMotor').value,
                  speech: document.getElementById('speech').value,
                  selfCare: document.getElementById('selfCare').value,
                  cognitive: document.getElementById('cognitive').value,
                  grossDevAge: document.getElementById('grossDevAge').value,
                  fineDevAge: document.getElementById('fineDevAge').value,
                  speechDevAge: document.getElementById('speechDevAge').value,
                  selfDevAge: document.getElementById('selfDevAge').value,
                  cognitiveDevAge: document.getElementById('cognitiveDevAge').value,
              };

              try {
                  const saveResponse = await fetch(`/development-assessment/${registrationNumber}`, {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                      },
                      body: JSON.stringify({ data }),
                  });

                  const saveResult = await saveResponse.json();
                  alert(saveResult.message || 'Developmental Assessment saved successfully!');
              } catch (error) {
                  console.error('Error saving Developmental Assessment:', error);
                  alert('Failed to save Developmental Assessment. Please try again.');
              } finally {
                  saveButton.innerHTML = 'Save';
                  saveButton.disabled = false;
              }
          });
      } catch (error) {
          console.error('Error fetching Developmental Assessment:', error);
          mainContent.innerHTML = `<p class="error-message">Failed to load Developmental Assessment. Please try again later.</p>`;
      }
  });
});


 // Add click event listener to the triageExam element
document.addEventListener('DOMContentLoaded', () => {
  const triageExam = document.querySelector('.floating-menu a[href="#triageExam"]');
  
  if (!triageExam) return;

  triageExam.addEventListener('click', async (event) => {
      event.preventDefault();

      const registrationNumber = getRegistrationNumberFromUrl();
      console.log("Registration number:", registrationNumber);

      // Show loading indicator
      showLoadingIndicator();

      try {
          // Fetch triage data
          const triageData = await fetchTriageData(registrationNumber);
          console.log('Triage data:', triageData);

          // Render triage examination UI
          renderTriageExamination(triageData);
      } catch (error) {
          console.error('Error fetching triage data:', error);
          alert('Failed to fetch triage data. Please try again.');
      } finally {
          // Remove loading indicator
          removeLoadingIndicator();
      }
  });
});

// Function to extract registration number from URL
function getRegistrationNumberFromUrl() {
  const pathParts = window.location.pathname.split('/');
  return pathParts[pathParts.length - 1];
}

// Function to show the loading indicator
function showLoadingIndicator() {
  const loadingIndicator = document.createElement('div');
  loadingIndicator.id = 'loading-indicator';
  document.body.appendChild(loadingIndicator);
}

// Function to remove the loading indicator
function removeLoadingIndicator() {
  const loadingIndicator = document.getElementById('loading-indicator');
  if (loadingIndicator) {
      document.body.removeChild(loadingIndicator);
  }
}

// Function to fetch triage data from the server
async function fetchTriageData(registrationNumber) {
  const response = await fetch(`/get-triage-data/${registrationNumber}`);
  if (!response.ok) {
      throw new Error('Network response was not ok');
  }
  return response.json();
}

// Function to render the triage examination UI
function renderTriageExamination(triageData) {
  const mainContent = document.querySelector('.main');
  mainContent.innerHTML = `
      <div class="container">
      <link rel='stylesheet' href='../css/triageExam.css'>
          <h2>Triage Examination</h2>
          <div class="section">
              <div class="grid-container">
                  ${createInputField('Temp', 'temp', triageData.temperature)}
                  ${createInputField('RR', 'rr', triageData.respiratory_rate)}
                  ${createInputField('Pulse', 'pulse', triageData.pulse_rate)}
                  ${createInputField('BP', 'bp', triageData.blood_pressure)}
              </div>
          </div>
          <div class="section">
              <div class="grid-container">
                  ${createInputField('Weight', 'weight', triageData.weight)}
                  ${createInputField('Height', 'height', triageData.height)}
                  ${createInputField('MUAC', 'muac', triageData.MUAC)}
                  ${createInputField('HC', 'hc', triageData.head_circumference)}
              </div>
          </div>
      </div>
  `;
}

// Helper function to create an input field
function createInputField(label, id, value) {
  return `
      <div class="grid-item">
          <label for="${id}">${label}:</label>
          <input type="text" id="${id}" value="${value || ''}">
      </div>
  `;
}

// Inject loading animation styles into the document head
const loadingAnimationStyles = document.createElement('style');
loadingAnimationStyles.textContent = `
  @keyframes loading-animation {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
  }
  #loading-indicator {
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
      z-index: 1000;
  }
  
`;
document.head.appendChild(loadingAnimationStyles);

    const textareas = document.querySelectorAll('textarea');
  
    textareas.forEach(textarea => {
      textarea.addEventListener('input', () => {
        textarea.style.height = "auto"; 
        textarea.style.height = (textarea.scrollHeight) + "px"; 
      });
  
      textarea.addEventListener('blur', () => {
        textarea.style.height = '50px'; 
      });
  
      textarea.style.height = "auto"; 
      textarea.style.height = (textarea.scrollHeight) + "px"; 
    });


 //Get  Diagnosis Exam Link

 const diagnosis = document.querySelector('.floating-menu a[href="#diagnosis"]');

diagnosis.addEventListener('click', async (event) => {
    event.preventDefault();

    const mainContent = document.querySelector('.main');
    mainContent.innerHTML = `<div class="loading">Loading...</div>`;
    console.log("Fetching diagnosis data...");

    const registrationNumber = window.location.pathname.split('/').pop();
    console.log("Registration Number:", registrationNumber);

    try {
        // Fetch existing diagnosis data
        const response = await fetch(`/diagnosis/${registrationNumber}`);
        const rawData = await response.text(); // Handle unexpected HTML responses gracefully

        try {
            const result = JSON.parse(rawData); // Parse JSON if the response is valid
            if (response.ok) {
                populateDiagnosisForm(mainContent, result.data || {}, registrationNumber);
            } else {
                console.error("Failed to fetch diagnosis data:", result.message);
                mainContent.innerHTML = `<div class="error">Error: ${result.message || "Failed to load diagnosis data."}</div>`;
            }
        } catch (parseError) {
            console.error("Error parsing response:", rawData);
            mainContent.innerHTML = `<div class="error">Unexpected server response. Please try again later.</div>`;
        }
    } catch (fetchError) {
        console.error("Error fetching diagnosis data:", fetchError);
        mainContent.innerHTML = `<div class="error">An unexpected error occurred while fetching diagnosis data.</div>`;
    }
});

function populateDiagnosisForm(container, data, registrationNumber) {
    console.log("Populating diagnosis form with data:", data);

    container.innerHTML = `
        <div class="container">
        <head>
        <link rel="stylesheet" href="../css/diagnosis.css">
        </head>
            <h2>Diagnosis</h2>

            <label for="primaryDiagnosis">Primary Diagnosis</label>
            <select id="primaryDiagnosis">
                <option value="" ${!data.primaryDiagnosis ? 'selected' : ''}>Select</option>
                <option value="Autism" ${data.primaryDiagnosis === 'Autism' ? 'selected' : ''}>Autism Spectrum Disorder</option>
                <option value="ADHD" ${data.primaryDiagnosis === 'ADHD' ? 'selected' : ''}>ADHD</option>
                <option value="Communication disorder" ${data.primaryDiagnosis === 'Communication disorder' ? 'selected' : ''}>Communication disorder</option>
                <option value="Intellectual disability" ${data.primaryDiagnosis === 'Intellectual disability' ? 'selected' : ''}>Intellectual disability</option>
                <option value="Global developmental delays" ${data.primaryDiagnosis === 'Global developmental delays' ? 'selected' : ''}>Global developmental delays</option>
                <option value="Learning disorder" ${data.primaryDiagnosis === 'Learning disorder' ? 'selected' : ''}>Learning disorder</option>
                <option value="Movement disorder" ${data.primaryDiagnosis === 'Movement disorder' ? 'selected' : ''}>Movement disorder</option>
                <option value="Social pragmatic disorder" ${data.primaryDiagnosis === 'Social pragmatic disorder' ? 'selected' : ''}>Social pragmatic disorder</option>
                <option value="Cerebral Palsy" ${data.primaryDiagnosis === 'Cerebral Palsy' ? 'selected' : ''}>Cerebral Palsy</option>
                <option value="Genetic Disorder" ${data.primaryDiagnosis === 'Genetic Disorder' ? 'selected' : ''}>Genetic Disorder</option>
                <option value="Epilepsy" ${data.primaryDiagnosis === 'Epilepsy' ? 'selected' : ''}>Epilepsy</option>
                <option value="Other" ${data.primaryDiagnosis === 'Other' ? 'selected' : ''}>Other</option>
            </select>

            <div id="otherDiagnosisContainer" style="display: ${data.primaryDiagnosis === 'Other' ? 'block' : 'none'};">
                <label for="otherDiagnosis">Other Diagnosis</label>
                <textarea id="otherDiagnosis">${data.otherDiagnosis || ''}</textarea>
            </div>

            <label for="secondaryDiagnosis">Secondary Diagnosis</label>
            <textarea id="secondaryDiagnosis">${data.secondaryDiagnosis || ''}</textarea>

            <button id="saveDiagnosis" type="button">Save</button>
        </div>
    `;

    addFormEventListeners(registrationNumber);
}

function addFormEventListeners(registrationNumber) {
    const primaryDiagnosisSelect = document.getElementById('primaryDiagnosis');
    const otherDiagnosisContainer = document.getElementById('otherDiagnosisContainer');
    const saveButton = document.getElementById('saveDiagnosis');

    primaryDiagnosisSelect.addEventListener('change', () => {
        if (primaryDiagnosisSelect.value === 'Other') {
            console.log('Showing "Other Diagnosis" textarea');
            otherDiagnosisContainer.style.display = 'block';
        } else {
            console.log('Hiding "Other Diagnosis" textarea');
            otherDiagnosisContainer.style.display = 'none';
        }
    });

    saveButton.addEventListener('click', async () => {
        const primaryDiagnosis = document.getElementById('primaryDiagnosis').value;
        const secondaryDiagnosis = document.getElementById('secondaryDiagnosis').value;
        const otherDiagnosis = document.getElementById('otherDiagnosis')?.value || null;

        saveButton.textContent = 'Saving...';
        saveButton.disabled = true;

        console.log("Saving diagnosis data:", {
            primaryDiagnosis,
            secondaryDiagnosis,
            otherDiagnosis,
        });

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log("CSRF Token:", csrfToken);

            const saveResponse = await fetch(`/diagnosis/${registrationNumber}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    primaryDiagnosis,
                    secondaryDiagnosis,
                    otherDiagnosis,
                }),
            });

            const rawSaveData = await saveResponse.text();

            try {
                const saveResult = JSON.parse(rawSaveData);
                if (saveResponse.ok) {
                    console.log("Save successful:", saveResult);
                    alert("Diagnosis saved successfully!");
                } else {
                    console.error("Save error response:", saveResult);
                    alert("Failed to save diagnosis: " + saveResult.message);
                }
            } catch (parseError) {
                console.error("Error parsing save response:", rawSaveData);
                alert("Unexpected response from server. Please try again later.");
            }
        } catch (error) {
            console.error("Error saving diagnosis:", error);
            alert("An unexpected error occurred while saving diagnosis.");
        } finally {
            saveButton.textContent = 'Save';
            saveButton.disabled = false;
            console.log("Save button reset to default state.");
        }
    });
}


 //Get General Exam Link

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

      // Fetch general examination data
      const response = await fetch(`/general-exam/${registrationNumber}`);
      const result = await response.json();

      console.log("Fetched data:", result);

      // Extract the general_exam_notes value or set it to an empty string if not present
      const generalExamNotes = result.data?.general_exam_notes || '';

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

        try {
          const saveResponse = await fetch(`/general-exam/${registrationNumber}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ data }),
          });

          if (!saveResponse.ok) {
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

      

 








 






