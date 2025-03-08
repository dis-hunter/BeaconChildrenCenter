document.addEventListener('DOMContentLoaded', () => {
    const hpiLink = document.querySelector('.floating-menu a[href="#hpi"]');
  
    hpiLink.addEventListener('click', async (event) => {
        event.preventDefault();
       
  
        const mainContent = document.querySelector('.main');
        mainContent.innerHTML = `
        <div class="container">
        <link rel='stylesheet' href='../css/generalExam.css'>
          <h2>Current Concerns</h2>
          <textarea style="height:80px;" id="currentConcerns"></textarea>
          <button type="button" id="saveButton">Save</button>
        </div>
      `;


      addTextareaAutoResize();
    });
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

});