<!DOCTYPE html>
<html>
<head>
  <title>Doctor's Interface</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="m-0 font-sans">
  <!-- Sidebar -->
  <div class="h-full w-64 fixed left-0 top-0 bg-sky-200 overflow-x-hidden pt-5 transition-all duration-300 hover:w-72 border-r-4 border-blue-500">
    <h2 class="p-3 text-gray-800 text-center">
      <i class="fas fa-user-md"></i> Active Patient <br> 
      <span class="text-blue-500">John Michael Doe</span>
    </h2>

    </a>
    
    </a>
    <a href="#" class="px-4 py-2 text-lg text-gray-800 block transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-6">
      <i class="fas fa-comments mr-2"></i> Multidisciplinary Communication
    </a>
  <a href="#" class="px-4 py-2 text-lg text-gray-800 block transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-6">
      <i class="fas fa-sign-out-alt mr-2"></i> Logout  
    </a>
  </div>

  <!-- Main Content -->
  <div class="ml-64 p-5">
    <div class="container mx-auto" id="mainContent">
      <!-- Form will be inserted here by JavaScript -->
    </div>
  </div>

  <!-- Floating Menu -->
  <div class="fixed right-5 top-10 bg-sky-200 rounded shadow-md" id="floatingMenu">
    <a href="#triageExam" class="block px-3 py-2 text-gray-800 border-b border-sky-100 transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-5">Triage Exam</a>
    <div id="triageExam"></div>
    <a href="#" class="block px-3 py-2 text-gray-800 border-b border-sky-100 transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-5">Encounters Summary</a>
    <a href="#perinatalHistory" class="block px-3 py-2 text-gray-800 border-b border-sky-100 transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-5">Perinatal History</a>
    <div id="perinatalHistory"></div>
    <a href="#pastMedicalHistory" class="block px-3 py-2 text-gray-800 border-b border-sky-100 transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-5">Past Medical History</a>
    <div id="pastMedicalHistory"></div>
    <a href="#familyAndSocial" class="block px-3 py-2 text-gray-800 border-b border-sky-100 transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-5">Family and Social History</a>
    <div id="familyAndSocial"></div>
    <a href="#generalExam" class="block px-3 py-2 text-gray-800 border-b border-sky-100 transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-5">Psychotherapy Assesment</a>
    <div id="generalExam"></div>
    <a href="#Examination" class="block px-3 py-2 text-gray-800 border-b border-sky-100 transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-5">Psychotherapy Goals</a>
    <div id="Examination"></div>
    <a href="#devAssesment" class="block px-3 py-2 text-gray-800 border-b border-sky-100 transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-5">Psychotherapy Session</a>
    <div id="devAssesment"></div>
    <a href="#diagnosis" class="block px-3 py-2 text-gray-800 border-b border-sky-100 transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-5">Psychotherapy Individualized Therapy Plan </a>
    <div id="diagnosis"></div>
    <a href="#investigations" class="block px-3 py-2 text-gray-800 border-b border-sky-100 transition-all duration-300 hover:bg-sky-100 hover:text-blue-500 hover:pl-5">Feedback</a>
  
  </div>

  <!-- Menu Button -->
  <button id="menuButton" class="fixed right-5 top-1 bg-blue-500 text-white px-3 py-2 cursor-pointer rounded">Menu</button>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      function showHomeForm() {
        const mainContent = document.querySelector('.main');
        mainContent.innerHTML = `
          <div class="container mx-auto p-5">
            <form id="patient-form" class="space-y-4">
              <div class="flex gap-4">
                <div class="flex-1">
                  <label class="block mb-1" for="firstName">First Name:</label>
                  <input type="text" id="firstName" name="firstName" value="John" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
                <div class="flex-1">
                  <label class="block mb-1" for="middleName">Middle Name:</label>
                  <input type="text" id="middleName" name="middleName" value="Michael" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
                <div class="flex-1">
                  <label class="block mb-1" for="lastName">Last Name:</label>
                  <input type="text" id="lastName" name="lastName" value="Doe" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
              </div>
              
              <div class="flex gap-4">
                <div class="flex-1">
                  <label class="block mb-1" for="dob">DOB:</label>
                  <input type="date" id="dob" name="dob" value="28.02.2018" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
                <div class="flex-1">
                  <label class="block mb-1" for="genderAge">Gender/Age:</label>
                  <input type="text" id="genderAge" name="genderAge" value="male/3yrs" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
                <div class="flex-1">
                  <label class="block mb-1" for="hnu">HNU:</label>
                  <input type="text" id="hnu" name="hnu" value="123456" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
              </div>

              <div class="flex gap-4">
                <div class="flex-1">
                  <label class="block mb-1" for="mothersName">Mother's Name:</label>
                  <input type="text" id="mothersName" name="mothersName" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
                <div class="flex-1">
                  <label class="block mb-1" for="motherTel">Tel:</label>
                  <input type="text" id="motherTel" name="motherTel" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
                <div class="flex-1">
                  <label class="block mb-1" for="motherEmail">Email:</label>
                  <input type="text" id="motherEmail" name="motherEmail" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
              </div>

              <div class="flex gap-4">
                <div class="flex-1">
                  <label class="block mb-1" for="fathersName">Father's Name:</label>
                  <input type="text" id="fathersName" name="fathersName" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
                <div class="flex-1">
                  <label class="block mb-1" for="fatherTel">Tel:</label>
                  <input type="text" id="fatherTel" name="fatherTel" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
                <div class="flex-1">
                  <label class="block mb-1" for="fatherEmail">Email:</label>
                  <input type="text" id="fatherEmail" name="fatherEmail" class="w-full px-2 py-1 border border-gray-300 rounded">
                </div>
              </div>

              <div>
                <label class="block mb-1" for="informant">Informant:</label>
                <input type="text" id="informant" name="informant" class="w-full px-2 py-1 border border-gray-300 rounded">
              </div>

              <div class="bg-sky-200 p-4 rounded">
                <label class="block mb-1" for="date">Date:</label>
                <input type="date" id="date" name="date" class="w-full px-2 py-1 border border-gray-300 rounded">
              </div>

              <div class="bg-sky-200 p-4 rounded">
                <label class="block mb-1" for="doctorsNotes">Doctor's Notes:</label>
                <textarea id="doctorsNotes" name="doctorsNotes" class="w-full px-2 py-1 border border-gray-300 rounded resize-y min-h-[30px]"></textarea>
              </div>

              <div class="bg-sky-200 p-4 rounded">
                <label class="block mb-1" for="createdBy">Created By:</label>
                <input type="text" id="createdBy" name="createdBy" class="w-full px-2 py-1 border border-gray-300 rounded">
              </div>

              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">Save</button>
            </form>
          </div>
        `;
      }

      const homeLink = document.getElementById('homeLink');
      if (homeLink) {
        homeLink.addEventListener('click', showHomeForm);
      }

      showHomeForm();
    });
  </script>
  <script src="<?php echo e(asset('js/doctor.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/therapists/therapistsPatientDashboard.blade.php ENDPATH**/ ?>