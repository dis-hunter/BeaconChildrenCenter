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
const behaviourAssessmentLink = document.querySelector('.floating-menu a[href="#behaviourAssessment"]');

// Add a click event listener to the link
behaviourAssessmentLink.addEventListener('click', (event) => {
event.preventDefault(); // Prevent default link behavior (opening in new tab)

// Replace the content of the .main div with the HTML for the Behaviour assessment form
const mainContent = document.querySelector('.main');
mainContent.innerHTML = `
<head>
<link rel='stylesheet' href='../css/BehaviourAssesment.css'>
</head>
  <h2>Behaviour assessment</h2>

  <div class="section">
    <div class="section-title">Hyperactivity Impulsivity</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Attention</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Social Interactions</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Mood/ Anxiety</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Play/ Interests</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Communication</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">RRB</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Sensory Processing</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Sleep</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Adaptive</div>
    <textarea></textarea>
  </div>

 
  <button type="submit">Update</button>
`;

// Add the same JavaScript code for textarea resizing to the new content
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
DevMilestonesLink.addEventListener('click', (event)=>{
    event.preventDefault();

    const mainContent=document.querySelector('.main');
    mainContent.innerHTML=`
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
        <label for="firstWord">First word:</label>
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
      <div class="grid-item"></div> 
    </div>
  </div>

  <div class="section">
    <div class="section-title">Feeding</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Elimination</div>
    <textarea></textarea>
  </div>

  <div class="section">
    <div class="section-title">Teething</div>
    <textarea></textarea>
  </div>
  <button>Back</button>
  <button type="submit">Save</button>
</div>

</body>
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

 //Get the Family and Social History Link

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
      //Get Examination Link

const Examination = document.querySelector('.floating-menu a[href="#Examination"]');
Examination.addEventListener('click', (event)=>{
    event.preventDefault();

    const mainContent=document.querySelector('.main');
    mainContent.innerHTML=`
    <head>
    <link rel='stylesheet' href='../css/Examination.css'>
</head>
<body>

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
      <textarea></textarea>
    </div>
    <div class="textarea-with-label">
      <div class="textarea-label">Respiratory System:</div>
      <textarea></textarea>
    </div>
    <div class="textarea-with-label">
      <div class="textarea-label">Musculoskeletal System:</div>
      <textarea></textarea>
    </div>
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
     

 //Get  Triage Exam Link

const triageExam = document.querySelector('.floating-menu a[href="#triageExam"]');
triageExam.addEventListener('click', (event)=>{
    event.preventDefault();

    const mainContent=document.querySelector('.main');
    mainContent.innerHTML=`
    <head>
    <link rel='stylesheet' href='../css/triageExam.css'>
</head>
<body>

<div class="container">
  <h2>Triage Examination</h2>

  <div class="section">
    <div class="grid-container">
      <div class="grid-item">
        <label for="temp">Temp:</label>
        <input type="text" id="temp">
      </div>
      <div class="grid-item">
        <label for="rr">RR:</label>
        <input type="text" id="rr">
      </div>
      <div class="grid-item">
        <label for="pulse">Pulse:</label>
        <input type="text" id="pulse">
      </div>
      <div class="grid-item">
        <label for="bp">BP:</label>
        <input type="text" id="bp">
      </div>
    </div>
  </div>

  <div class="section">
    <div class="section-title"></div> <div class="grid-container">
      <div class="grid-item">
        <label for="weight">Weight:</label>
        <input type="text" id="weight">
      </div>
      <div class="grid-item">
        <label for="height">Height:</label>
        <input type="text" id="height">
      </div>
      <div class="grid-item">
        <label for="muac">MUAC:</label>
        <input type="text" id="muac">
      </div>
      <div class="grid-item">
        <label for="hc">HC:</label>
        <input type="text" id="hc">
      </div>
    </div>
  </div>

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
     
      

 








 






