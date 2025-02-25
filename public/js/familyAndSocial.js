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
    <link rel="stylesheet" href="../css/FamilyAndSocial.css">
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
