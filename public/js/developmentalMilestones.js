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
     const registrationNumber = window.location.pathname.split('/').pop();
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