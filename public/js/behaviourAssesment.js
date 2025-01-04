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