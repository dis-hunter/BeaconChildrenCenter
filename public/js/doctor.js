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


 








 






