document.addEventListener('DOMContentLoaded', () => {
    const hpiLink = document.querySelector('.floating-menu a[href="#hpi"]');
    const registrationNumber = getRegistrationNumberFromUrl();
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
        console.error("CSRF token is missing.");
    }

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

        document.getElementById('saveButton').addEventListener('click', async () => {
            if (!registrationNumber) {
                console.error("Error: Registration number not found.");
                alert("Error: Registration number is missing.");
                return;
            }

            showSaveButtonLoadingIndicator();

            const textarea = document.getElementById('currentConcerns');
            const currentConcernsValue = textarea.value;

            const data = {
                Current_concerns: currentConcernsValue,
            };

            console.log("Saving data:", data);

            try {
                const saveResponse = await fetch(`/current-concerns/${registrationNumber}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ data }),
                });

                console.log("Save response status:", saveResponse.status);

                if (!saveResponse.ok) {
                    console.error("Error saving data:", await saveResponse.text());
                    throw new Error('Failed to save data');
                }

                alert("HPI saved successfully!");
            } catch (error) {
                console.error('Error saving HPI:', error);
                alert("Error saving HPI. Please try again.");
            } finally {
                removeSaveButtonLoadingIndicator();
            }
        });
    });

    function getRegistrationNumberFromUrl() {
        const pathParts = window.location.pathname.split('/');
        console.log("Path parts:", pathParts);
        return pathParts[pathParts.length - 1] || null;
    }

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

            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        });
    }

    function showSaveButtonLoadingIndicator() {
        const saveButton = document.getElementById('saveButton');
        saveButton.disabled = true;
        saveButton.innerHTML = 'Saving... <span class="loading-spinner"></span>';

        const spinner = document.createElement('span');
        spinner.classList.add('loading-spinner');
        spinner.style.cssText = `
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-left: 10px;
        `;
        saveButton.appendChild(spinner);
    }

    function removeSaveButtonLoadingIndicator() {
        const saveButton = document.getElementById('saveButton');
        saveButton.disabled = false;
        saveButton.innerHTML = 'Save';
        const spinner = saveButton.querySelector('.loading-spinner');
        if (spinner) {
            spinner.remove();
        }
    }
});
