<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speechtherapy Dashboard</title>
    <style>
        .sidebar {
            width: 200px;
            transition: width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 0px;
        }

        .toggle-button {
            position: fixed;
            left: 200px;
            top: 20px;
            background-color: #111827;
            color: white;
            width: 24px;s
            height: 24px;
            border-radius: 0 6px 6px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: left 0.3s ease;
            z-index: 1000;
        }

        .toggle-button.collapsed {
            left: 60px;
        }

        .toggle-button::before {
            content: "◀";
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        .toggle-button.collapsed::before {
            transform: rotate(180deg);
        }

        .main {
            margin-left: 200px;
            transition: margin-left 0.3s ease;
        }

        .main.expanded {
            margin-left: 60px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="m-0 font-sans bg-gray-50">
    <div class="sidebar h-screen fixed left-0 top-0 bg-gradient-to-b from-sky-100 to-sky-200 overflow-x-hidden pt-5 transition-all duration-300 border-r border-sky-300 shadow-lg" id="sidebar">
        <div class="p-5 mb-6 bg-white/50 backdrop-blur-sm mx-3 rounded-lg shadow-sm">
            <h2 class="text-gray-800 text-center font-semibold">
                <i class="fas fa-user-md text-2xl text-blue-600 mb-2"></i>
                <div class="text-sm text-gray-600">Active Patient</div>
                <div class="text-lg text-blue-600 font-bold mt-1">John Michael Doe</div>
            </h2>
        </div>

        <a href="#" class="px-4 py-3 text-gray-700 block transition-all duration-300 hover:bg-white/50 hover:text-blue-600 hover:pl-6 flex items-center space-x-3">
            <i class="fas fa-comments"></i>
            <span>Multidisciplinary Communication</span>
        </a>
        <a href="#" class="px-4 py-3 text-gray-700 block transition-all duration-300 hover:bg-white/50 hover:text-blue-600 hover:pl-6 flex items-center space-x-3">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>

    <div class="toggle-button" id="toggle-button" onclick="toggleSidebar()"></div>

    <div class="main ml-64 p-8" id="main">
        <div class="container mx-auto" id="mainContent">
            <!-- Form will be inserted here by JavaScript -->
        </div>
    </div>

    <div class="fixed right-5 top-20 bg-white rounded-lg shadow-lg overflow-hidden" id="floatingMenu">
        <div class="bg-gradient-to-r from-blue-500 to-sky-500 text-white py-3 px-4 font-semibold">
            Navigation Menu
        </div>
        <a href="#triageExam" class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">Triage Exam</a>
        <div id="triageExam"></div>
        <a href="#" class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">Encounters Summary</a>
        <a href="#perinatalHistory" class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">Perinatal History</a>
        <div id="perinatalHistory"></div>
        <a href="#pastMedicalHistory" class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">Past Medical History</a>
        <div id="pastMedicalHistory"></div>
        <a href="#familyAndSocial" class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">Family and Social History</a>
        <div id="familyAndSocial"></div>
        <a href="#generalExam" class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">Speech therapy Assessment</a>
        <div id="generalExam"></div>
        <a href="#Examination" class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">Speech therapy Goals</a>
        <div id="Examination"></div>
        <a href="#devAssesment" class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">Speech therapy Session</a>
        <div id="devAssesment"></div>
        <a href="#diagnosis" class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">Speech Individualized Therapy Plan</a>
        <div id="diagnosis"></div>
        <a href="#investigations" class="block px-4 py-3 text-gray-700 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">Feedback</a>
    </div>

    <button id="menuButton" class="fixed right-5 top-5 bg-gradient-to-r from-blue-500 to-sky-500 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center space-x-2">
        <i class="fas fa-bars"></i>
        <span>Menu</span>
    </button>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main');
            const toggleButton = document.getElementById('toggle-button');
            
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
            toggleButton.classList.toggle('collapsed');
        }

        document.addEventListener("DOMContentLoaded", function() {
            function showHomeForm() {
                const mainContent = document.querySelector('#mainContent');
                mainContent.innerHTML = `
                    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-sky-500 px-6 py-4">
                            <h1 class="text-white text-xl font-semibold">Patient Information</h1>
                        </div>
                        <form id="patient-form" class="p-6 space-y-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="firstName">First Name</label>
                                    <input type="text" id="firstName" name="firstName" value="John" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="middleName">Middle Name</label>
                                    <input type="text" id="middleName" name="middleName" value="Michael" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="lastName">Last Name</label>
                                    <input type="text" id="lastName" name="lastName" value="Doe" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="dob">Date of Birth</label>
                                    <input type="date" id="dob" name="dob" value="2018-02-28" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="genderAge">Gender/Age</label>
                                    <input type="text" id="genderAge" name="genderAge" value="male/3yrs" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="hnu">HNU</label>
                                    <input type="text" id="hnu" name="hnu" value="123456" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="mothersName">Mother's Name</label>
                                    <input type="text" id="mothersName" name="mothersName" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="motherTel">Tel</label>
                                    <input type="tel" id="motherTel" name="motherTel" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="motherEmail">Email</label>
                                    <input type="email" id="motherEmail" name="motherEmail" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="fathersName">Father's Name</label>
                                    <input type="text" id="fathersName" name="fathersName" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="fatherTel">Tel</label>
                                    <input type="tel" id="fatherTel" name="fatherTel" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="fatherEmail">Email</label>
                                    <input type="email" id="fatherEmail" name="fatherEmail" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700" for="informant">Informant</label>
                                <input type="text" id="informant" name="informant" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="bg-sky-50 p-6 rounded-lg space-y-2">
                                <label class="block text-sm font-medium text-gray-700" for="date">Date</label>
                                <input type="date" id="date" name="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="bg-sky-50 p-6 rounded-lg space-y-2">
                                <label class="block text-sm font-medium text-gray-700" for="doctorsNotes">Doctor's Notes</label>
                                <textarea id="doctorsNotes" name="doctorsNotes" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-h-[100px] resize-y"></textarea>
                            </div>

                            <div class="bg-sky-50 p-6 rounded-lg space-y-2">
                                <label class="block text-sm font-medium text-gray-700" for="createdBy">Created By</label>
                                <input type="text" id="createdBy" name="createdBy" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-gradient-to-r from-blue-500 to-sky-500 text-white px-6 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">Save</button>
                            </div>
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
    <script src="{{ asset('js/doctor.js') }}"></script>
</body>
</html>