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
// Event listener for the "Behaviour Assessment" link
document.querySelector('.floating-menu a[href="#behaviourAssessment"]').addEventListener('click', async (event) => {
    event.preventDefault();

    const mainContent = document.querySelector('.main');
    mainContent.innerHTML = ''; // Clear the main content
    showLoadingIndicator(mainContent); // Display the loading indicator

    try {
        await loadBehaviourAssessmentForm(mainContent); // Load the form
    } catch (error) {
        console.error("Error loading Behaviour Assessment form:", error.message);
        mainContent.innerHTML = `<div class="error">Failed to load the form. Please try again.</div>`;
    } finally {
        removeLoadingIndicator(); // Remove the loading indicator
    }
});

// Function to load the Behaviour Assessment form
async function loadBehaviourAssessmentForm(mainContent) {
    const registrationNumber = "REG-001"; // Example registration number
    let behaviourData = {};

    // Fetch existing Behaviour Assessment data
    try {
        const response = await fetch(`/get-behaviour-assessment/${registrationNumber}`);
        if (response.ok) {
            const data = await response.json();
            behaviourData = data?.data || {}; // Parse the JSON data or use an empty object
        } else {
            console.warn("No existing data found for this child.");
        }
    } catch (error) {
        console.error("Error fetching Behaviour Assessment data:", error.message);
    }

    // Generate the form HTML
    const formHTML = `
        <div id="behaviour-assessment-container">
            <head>
               <link rel="stylesheet" href="../css/BehaviourAssesment.css">
            </head>
            <h2>Behaviour Assessment</h2>
            <form id="behaviourAssessmentForm">
                <div class="section">
                    <div class="section-title">Hyperactivity Impulsivity</div>
                    <textarea id="hyperactivity">${behaviourData?.HyperActivity || ''}</textarea>
                </div>
                <div class="section">
                    <div class="section-title">Attention</div>
                    <textarea id="attention">${behaviourData?.Attention || ''}</textarea>
                </div>
                <div class="section">
                    <div class="section-title">Social Interactions</div>
                    <textarea id="socialInteractions">${behaviourData?.SocialInteractions || ''}</textarea>
                </div>
                <div class="section">
                    <div class="section-title">Mood/Anxiety</div>
                    <textarea id="moodAnxiety">${behaviourData?.MoodAnxiety || ''}</textarea>
                </div>
                <div class="section">
                    <div class="section-title">Play/Interests</div>
                    <textarea id="playInterests">${behaviourData?.PlayInterests || ''}</textarea>
                </div>
                <div class="section">
                    <div class="section-title">Communication</div>
                    <textarea id="communication">${behaviourData?.Communication || ''}</textarea>
                </div>
                <div class="section">
                    <div class="section-title">RRB</div>
                    <textarea id="rrb">${behaviourData?.RRB || ''}</textarea>
                </div>
                <div class="section">
                    <div class="section-title">Sensory Processing</div>
                    <textarea id="sensoryProcessing">${behaviourData?.SensoryProcessing || ''}</textarea>
                </div>
                <div class="section">
                    <div class="section-title">Sleep</div>
                    <textarea id="sleep">${behaviourData?.Sleep || ''}</textarea>
                </div>
                <div class="section">
                    <div class="section-title">Adaptive</div>
                    <textarea id="adaptive">${behaviourData?.Adaptive || ''}</textarea>
                </div>
                <button type="submit">Save</button>
            </form>
        </div>
    `;

    mainContent.innerHTML = formHTML; // Insert the form into the main content

    // Attach form submission handler
    const form = document.getElementById('behaviourAssessmentForm');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // Gather the data from the form
        const formData = {
            HyperActivity: document.getElementById('hyperactivity').value,
            Attention: document.getElementById('attention').value,
            SocialInteractions: document.getElementById('socialInteractions').value,
            MoodAnxiety: document.getElementById('moodAnxiety').value,
            PlayInterests: document.getElementById('playInterests').value,
            Communication: document.getElementById('communication').value,
            RRB: document.getElementById('rrb').value,
            SensoryProcessing: document.getElementById('sensoryProcessing').value,
            Sleep: document.getElementById('sleep').value,
            Adaptive: document.getElementById('adaptive').value,
        };

        // Save the updated data
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const registrationNumber = "REG-001"; // Use the actual registration number
            const saveResponse = await fetch(`/save-behaviour-assessment/${registrationNumber}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken, // Include CSRF token for security
                },
                body: JSON.stringify({ data: formData }), // Send the form data as JSON
            });

            if (saveResponse.ok) {
                alert('Behaviour Assessment saved successfully!');
            } else {
                throw new Error('Failed to save Behaviour Assessment');
            }
        } catch (error) {
            console.error("Error saving Behaviour Assessment:", error.message);
            alert("Error saving Behaviour Assessment: " + error.message);
        }
    });
}

// Helper function to show loading indicator
function showLoadingIndicator(container) {
    container.innerHTML = `<div class="loading">Loading...</div>`;
}

// Helper function to remove loading indicator
function removeLoadingIndicator() {
    const loadingIndicator = document.querySelector('.loading');
    if (loadingIndicator) {
        loadingIndicator.remove();
    }
}
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
        <head>
            <link rel='stylesheet' href='../css/BehaviourAssesment.css'>
        </head>
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
    const registrationNumber = "REG-001";
    await loadBehaviourAssessment(registrationNumber);

    // Add event listener to the save button
    document.getElementById("saveButton").addEventListener("click", async () => {
        await saveBehaviourAssessment(registrationNumber);
    });
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

const perinatalHistoryLink = document.querySelector('.floating-menu a[href="#perinatalHistory"]');
perinatalHistoryLink.addEventListener('click', (event)=>{
    event.preventDefault();

    const mainContent=document.querySelector('.main');
    mainContent.innerHTML=`
    <head>
    <link rel='stylesheet' href='../css/perinatalHistory.css'>
</head>
<body>

<div class="container">
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
      <div class="grid-item">
        <label for="parity">Parity:</label>
        <input type="text" id="parity">
      </div>
      <div class="grid-item">
        <label for="gestation">Gestation:</label>
        <input type="text" id="gestation">
      </div>
      <div class="grid-item">
        <label for="labour">Labour:</label>
        <input type="text" id="labour">
      </div>
      <div class="grid-item">
        <label for="delivery">Delivery:</label>
        <input type="text" id="delivery">
      </div>
      <div class="grid-item">
        <label for="agarScore">Agar Score:</label>
        <input type="text" id="agarScore">
      </div>
      <div class="grid-item">
        <label for="bwt">BWT:</label>
        <input type="text" id="bwt">
      </div>
    </div>
  </div>

  <div class="section">
    <div class="section-title highlighted">Postnatal Period</div>
    <div class="grid-container">
      <div class="grid-item">
        <label for="bFeeding">B/Feeding:</label>
        <input type="text" id="bFeeding">
      </div>
      <div class="grid-item">
        <label for="hypoglaecemia">Hypoglaecemia:</label>
        <input type="text" id="hypoglaecemia">
      </div>
      <div class="grid-item">
        <label for="siezures">Siezures:</label>
        <input type="text" id="siezures">
      </div>
      <div class="grid-item">
        <label for="juandice">Juandice:</label>
        <input type="text" id="juandice">
      </div>
      <div class="grid-item">
        <label for="rds">RDS:</label>
        <input type="text" id="rds">
      </div>
      <div class="grid-item">
        <label for="sepsis">Sepsis:</label>
        <input type="text" id="sepsis">
      </div>
    </div>
  </div>

  <button type="submit">Save</button>
   

</div>
    `
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
    document.getElementById("saveButton").addEventListener("click", async () => {
        await saveDevelopmentalMilestones(registrationNumber);
    });
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
familyAndSocial.addEventListener('click', (event)=>{
    event.preventDefault();

    const mainContent=document.querySelector('.main');
    mainContent.innerHTML=`
    <head>
    <link rel='stylesheet' href='../css/FamilyAndSocial.css'>
</head>
<body>

<div class="container">
  <h2>Family and Social History</h2>

  <div class="section">
    <div class="section-title">Family Composition</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Family Health/Social</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Schooling</div>
    <textarea></textarea>
  </div>

  <button>Back</button>
  <button type="submit">Update</button>
</div>
    `
    const textareas = document.querySelectorAll('textarea');
  
    textareas.forEach(textarea => {
      textarea.addEventListener('input', () => {
        textarea.style.height = "auto"; 
        textarea.style.height = (textarea.scrollHeight) + "px"; 
      });
  
      textarea.addEventListener('blur', () => {
        textarea.style.height = '30px'; 
      });
  
      textarea.style.height = "auto"; 
      textarea.style.height = (textarea.scrollHeight) + "px"; 
    });
 });

 //Get the Past Medical History Link

const pastMedicalHistory = document.querySelector('.floating-menu a[href="#pastMedicalHistory"]');
pastMedicalHistory.addEventListener('click', (event)=>{
    event.preventDefault();

    const mainContent=document.querySelector('.main');
    mainContent.innerHTML=`
    <head>
    <link rel='stylesheet' href='../css/pastMedicalHistory.css'>
</head>
<body>

<div class="container">
  <h2>Past Medical History</h2>

  <div class="section">
    <div class="section-title">Illnesses</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Investigations</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Interventions</div>
    <textarea></textarea>
  </div>

  <button type="submit">Save</button>
  <button type="button">Back</button>
</div>
</body>
    `
    const textareas = document.querySelectorAll('textarea');
  
    textareas.forEach(textarea => {
      textarea.addEventListener('input', () => {
        textarea.style.height = "auto"; 
        textarea.style.height = (textarea.scrollHeight) + "px"; 
      });
  
      textarea.addEventListener('blur', () => {
        textarea.style.height = '30px'; 
      });
  
      textarea.style.height = "auto"; 
      textarea.style.height = (textarea.scrollHeight) + "px"; 
    });
 });

 //Examination 

 document.addEventListener('DOMContentLoaded', (event) => {
  const Examination = document.querySelector('.floating-menu a[href="#Examination"]');

  if (Examination) {
    Examination.addEventListener('click', async (event) => {
      event.preventDefault();

      const registrationNumber = getRegistrationNumberFromUrl();
      console.log("Registration number:", registrationNumber);

      // Show loading indicator
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
            <button type="submit">Save</button>
          </div>
        `;

        // Append the form to the main content area
        const mainContent = document.querySelector('.main');
        mainContent.innerHTML = ''; // Clear existing content
        mainContent.appendChild(examinationForm);

        // Remove loading indicator
        document.body.removeChild(loadingIndicator);

        // Add event listener to the save button
        examinationForm.addEventListener('submit', async (event) => {
          event.preventDefault();

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
          } catch (error) {
            console.error('Error saving CNS data:', error);
          }
          
        });

        // Textarea auto-resize
        // (Optional implementation for auto-resize functionality)
      } catch (error) {
        console.error('Error loading examination form:', error);
        document.body.removeChild(loadingIndicator);
      }
    });
  }
});

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

const devAssesment = document.querySelector('.floating-menu a[href="#devAssesment"]');
devAssesment.addEventListener('click', (event)=>{
    event.preventDefault();

    const mainContent=document.querySelector('.main');
    mainContent.innerHTML=`
    <head>
    <link rel='stylesheet' href='../css/devAssesment.css'>
</head>
<body>

<div class="container">
  <h2>Developmental Assessment</h2>

  <div class="section">
    <div class="section-title">Gross Motor</div>
    <textarea></textarea>
    <div class="dev-age-heading">Dev Age</div> <input type="text" class="dev-age-input"> 
  </div>

  <div class="section">
    <div class="section-title">Fine Motor</div>
    <textarea></textarea>
    <div class="dev-age-heading">Dev Age</div> <input type="text" class="dev-age-input">
  </div>

  <div class="section">
    <div class="section-title">Speech/Language</div>
    <textarea></textarea>
    <div class="dev-age-heading">Dev Age</div> <input type="text" class="dev-age-input">
  </div>

  <div class="section">
    <div class="section-title">Fine Motor</div>
    <textarea></textarea>
    <div class="dev-age-heading">Dev Age</div> <input type="text" class="dev-age-input">
  </div>

  <div class="section">
    <div class="section-title">Self Care</div>
   <textarea></textarea>
    <div class="dev-age-heading">Dev Age</div> <input type="text" class="dev-age-input">
  </div>

  <div class="section">
    <div class="section-title">Cognitive</div>
    <textarea></textarea>
    <div class="dev-age-heading">Dev Age</div> <input type="text" class="dev-age-input">
  </div>

  <button type="submit">Save</button>
</div>
</body>
    `

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
diagnosis.addEventListener('click', (event)=>{
    event.preventDefault();

    const mainContent=document.querySelector('.main');
    mainContent.innerHTML=`
    <head>
    <link rel='stylesheet' href='../css/diagnosis.css'>
</head>
<body>

<div class="container">
  <h2>Diagnosis</h2>

  <label for="primaryDiagnosis">Primary Diagnosis</label>
  <select id="primaryDiagnosis">
    <option value="">Select</option>
    <option value="Autism">Autism</option>
    <option value="ADHD">ADHD</option>
    <option value="Communication disorder">Communication disorder</option>
    <option value="Intellectual disability">Intellectual disability</option>
    <option value="Global developmental delay">Global developmental delay</option>
    <option value="Learning disorder">Learning disorder</option>
    <option value="Movement disorder">Movement disorder</option>
    <option value="Social pragmatic disorder">Social pragmatic disorder</option>
  </select>

  <label for="secondaryDiagnosis">Secondary Diagnosis</label>
  <textarea id="secondaryDiagnosis"></textarea>

  <button type="button">Save</button>
</div>
</body>
    `

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
 });
     

 //Get General Exam Link

const generalExam = document.querySelector('.floating-menu a[href="#generalExam"]');
generalExam.addEventListener('click', (event)=>{
    event.preventDefault();

    const mainContent=document.querySelector('.main');
    mainContent.innerHTML=`
    <head>
    <link rel='stylesheet' href='../css/generalExam.css'>
</head>
<body>

<div class="container">
  <h2>General Examination</h2>
  <textarea></textarea>
  <button type="button">Save</button>
</div>

</body>
    `

    const textareas = document.querySelectorAll('textarea');
  
    textareas.forEach(textarea => {
      textarea.addEventListener('input', () => {
        textarea.style.height = "auto"; 
        textarea.style.height = (textarea.scrollHeight) + "px"; 
      });
  
      textarea.addEventListener('blur', () => {
        textarea.style.height = '100px'; 
      });
  
      textarea.style.height = "auto"; 
      textarea.style.height = (textarea.scrollHeight) + "px"; 
    });
 });
     
      

 








 






