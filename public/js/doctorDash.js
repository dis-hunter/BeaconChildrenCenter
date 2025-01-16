// Define patient queue
const patientQueue = [
  { name: "John Doe", id: "REG-001" },
  { name: "Alice Willson", id: "REG-002" },
  { name: "Bob Williams", id: "REG-003" },
  { name: "Eva Green", id: "REG-004" },
  { name: "Chris Evans", id: "REG-005" },
];

// DOM Elements
const sidebarLinks = document.querySelectorAll(".sidebar a");
const patientList = document.getElementById("patient-list");
const startConsultationButton = document.querySelector(".start-consult");
const dashboardContent = document.getElementById("dashboard-content");
const profileContent = document.getElementById("profile-content");
const bookedContent = document.getElementById("booked-content");
const therapistContent = document.getElementById("therapist-content");
const dropdownProfileLink = document.getElementById("dropdown-profile-link");

// Utility Functions
function showLoadingIndicator() {
  const loadingIndicator = document.createElement("div");
  loadingIndicator.id = "loading-indicator";
  document.body.appendChild(loadingIndicator);
}

function removeLoadingIndicator() {
  const loadingIndicator = document.getElementById("loading-indicator");
  if (loadingIndicator) {
    document.body.removeChild(loadingIndicator);
  }
}

function injectLoadingStyles() {
  const loadingStyles = document.createElement("style");
  loadingStyles.textContent = `
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
  document.head.appendChild(loadingStyles);
}

function updatePatientList() {
  const currentActivePatientId = patientList.querySelector(".active")?.dataset.patientId;
  patientList.innerHTML = "";

  patientQueue.slice(0, 5).forEach((patient) => {
    const listItem = document.createElement("li");
    listItem.dataset.patientId = patient.id;
    listItem.innerHTML = `<div><h4>${patient.name}</h4></div>`;

    listItem.addEventListener("click", () => {
      patientList.querySelectorAll(".active").forEach((item) => item.classList.remove("active"));
      listItem.classList.add("active");
      localStorage.setItem("activePatientId", patient.id);
    });

    if (patient.id === currentActivePatientId) {
      listItem.classList.add("active");
    }

    patientList.appendChild(listItem);
  });
}

function handleSidebarLinkClick(event, link) {
  event.preventDefault();

  sidebarLinks.forEach((link) => link.parentElement.classList.remove("active"));
  link.parentElement.classList.add("active");

  dashboardContent.style.display = "none";
  profileContent.style.display = "none";
  bookedContent.style.display = "none";
  therapistContent.style.display = "none";

  if (link.id === "dashboard-link") dashboardContent.style.display = "block";
  if (link.id === "profile-link") profileContent.style.display = "block";
  if (link.id === "booked-link") bookedContent.style.display = "block";
  if (link.id === "therapist-link") therapistContent.style.display = "block";
}

function handleDropdownProfileClick() {
  dashboardContent.style.display = "none";
  profileContent.style.display = "block";
  bookedContent.style.display = "none";
  therapistContent.style.display = "none";

  sidebarLinks.forEach((link) => link.parentElement.classList.remove("active"));
  document.getElementById("profile-link").parentElement.classList.add("active");
}

function handleStartConsultation() {
  const activePatient = patientList.querySelector(".active");
  if (activePatient) {
    showLoadingIndicator();
    const patientId = activePatient.dataset.patientId;

    setTimeout(() => {
      window.location.href = `/doctor/${patientId}`;
    }, 500);
  } else {
    alert("Please select a patient first.");
  }
}

// Initialize Application
function init() {
  injectLoadingStyles();

  updatePatientList();
  setInterval(updatePatientList, 10 * 60 * 1000);

  const activePatientId = localStorage.getItem("activePatientId");
  if (activePatientId) {
    const activeListItem = document.querySelector(`[data-patient-id="${activePatientId}"]`);
    if (activeListItem) activeListItem.classList.add("active");
  }

  sidebarLinks.forEach((link) => {
    link.addEventListener("click", (event) => handleSidebarLinkClick(event, link));
  });

  if (dropdownProfileLink) {
    dropdownProfileLink.addEventListener("click", handleDropdownProfileClick);
  }

  if (startConsultationButton) {
    startConsultationButton.addEventListener("click", handleStartConsultation);
  }
}

document.addEventListener("DOMContentLoaded", init);
