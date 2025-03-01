<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Doctor Notes</title>
</head>
<body>
    <div class="main">
        <!-- Content will be loaded dynamically -->
    </div>
</body>
<script>
    // Toggle function to show/hide details
    function toggleDetails(element) {
        const notesElement = element.querySelector('.notes');
        const button = element.querySelector('.toggle-details-btn');
        
        if (notesElement.style.display === 'block') {
            notesElement.style.display = 'none';
            button.textContent = 'More Details';
        } else {
            notesElement.style.display = 'block';
            button.textContent = 'Hide Details';
        }
    }

    // Function to save doctor notes
    async function saveNotes(button) {
    const visitEntry = button.closest('.visit-entry');
    const visitId = visitEntry.dataset.visitId;
    const childId = visitEntry.dataset.childId;
    const notesTextarea = visitEntry.querySelector('.editable-notes');
    const saveStatus = visitEntry.querySelector('.save-status');
    const updatedNotes = notesTextarea.value;
    
    // Show saving spinner
    const originalButtonText = button.innerHTML;
    button.innerHTML = '<span class="saving-button-spinner"></span> Saving...';
    button.disabled = true;
    
    try {
        const response = await fetch('/saveDoctorNotes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                visit_id: visitId,
                child_id: childId,
                notes: updatedNotes
            })
        });
        
        const result = await response.json();
        
        if (response.ok && result.status === 'success') {
            saveStatus.textContent = 'Saved successfully!';
            saveStatus.style.color = 'green';
            
            // Clear status message after 3 seconds
            setTimeout(() => {
                saveStatus.textContent = '';
            }, 3000);
        } else {
            throw new Error(result.message || 'Failed to save notes');
        }
    } catch (error) {
        console.error('Error saving notes:', error);
        saveStatus.textContent = 'Failed to save. Please try again.';
        saveStatus.style.color = 'red';
    } finally {
        // Restore button state
        button.innerHTML = originalButtonText;
        button.disabled = false;
    }
}

    document.addEventListener('DOMContentLoaded', async () => {
        const mainContent = document.querySelector('.main');
  
        // Add CSS styles
        const style = document.createElement('style');
        style.innerHTML = `
           .loading-spinner {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(to bottom right, #f8f9fa, #ffffff);
        }

        .spinner {
            border: 3px solid rgba(52, 152, 219, 0.1);
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .saving-button-spinner {
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-top: 2px solid white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 0.8s linear infinite;
            display: inline-block;
            vertical-align: middle;
            margin-right: 5px;
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            padding: 20px;
            background: #fdf0ef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin: 20px auto;
            max-width: 500px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .patient-info {
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border-left: 4px solid #3498db;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .patient-info:hover {
            transform: translateY(-2px);
        }

        .patient-info h3 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .patient-info p {
            margin: 0.5rem 0;
            color: #34495e;
        }

        .visits-container {
            margin-top: 2rem;
            display: grid;
            gap: 1.5rem;
        }

        .visit-entry {
            border: none;
            padding: 1.5rem;
            border-radius: 12px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .visit-entry:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .editable-visit {
            border-left: 4px solid #27ae60;
        }

        .visit-entry h3 {
            margin: 0 0 1rem 0;
            color: #2c3e50;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .visit-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            color: #7f8c8d;
            font-size: 0.95rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #ecf0f1;
        }

        .notes {
            margin-top: 1rem;
            padding: 1.25rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            color: #2c3e50;
            font-size: 0.95rem;
            line-height: 1.6;
            display: none; /* Initially hide the notes */
        }

        .section-title {
            color: #2c3e50;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #3498db;
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
        }

        /* Button styles */
        button {
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            color: white;
            background-color: #3498db;
            border: none;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2980b9;
        }

        button:active {
            background-color: #1c6da6;
        }

        button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.5);
        }

        button:disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }

        /* Styles for editable and non-editable notes */
        .editable-notes {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            min-height: 100px;
            resize: vertical;
            margin-bottom: 10px;
            background-color: #fff;
        }

        .editable-container {
            position: relative;
            width: 100%;
        }

        .save-notes-btn {
            background-color: #27ae60;
        }

        .save-notes-btn:hover {
            background-color: #219955;
        }

        .save-status {
            display: inline-block;
            margin-left: 10px;
            font-style: italic;
        }

        .non-editable-notes {
            white-space: pre-wrap;
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 4px;
            border-left: 3px solid #bdc3c7;
        }

        /* Indicator for editable notes */
        .editable-indicator {
            display: inline-block;
            background-color: #27ae60;
            color: white;
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 10px;
            margin-left: 10px;
        }
        `;
        document.head.appendChild(style);

        // Show loading spinner
        mainContent.innerHTML = `
        <div class="loading-spinner">
            <div class="spinner"></div>
        </div> 
        `;

        try {
            const registrationNumber = window.location.pathname.split('/').pop();
            console.log('Registration number extracted:', registrationNumber);

            // Fetch doctor notes with editable flag
            const response = await fetch(`/EditablegetDoctorNotes/${registrationNumber}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const result = await response.json();
            console.log('Fetch response:', result);

            if (result.status === 'success') {
                mainContent.innerHTML = `
                    <div class="container">
                        <h2 class="section-title">Encounter Summary History</h2>
                        
                        <div class="patient-info">
                            <h3>Patient Information</h3>
                            <p><strong>Registration Number:</strong> ${result.data.registration_number}</p>
                            <p><strong>Patient Name:</strong> ${result.data.child_name}</p>
                        </div>

                        <div class="visits-container">
                        ${result.data.visits.map(visit => `
                            <div class="visit-entry ${visit.is_editable ? 'editable-visit' : ''}" 
                                data-visit-id="${visit.visit_id}" 
                                data-child-id="${result.data.child_id}">
                                <h3>Visit Details</h3>
                                <div class="visit-meta">
                                    <span><strong>Date:</strong> ${new Date(visit.visit_date).toLocaleDateString()}</span>
                                    <span>
                                        <strong>Doctor:</strong> ${visit.doctor_first_name} ${visit.doctor_last_name}
                                        ${visit.is_editable ? '<span class="editable-indicator">Your Entry</span>' : ''}
                                    </span>
                                </div>
                                <div class="notes">
                                <h1>${visit.is_editable}, ${visit.doctor_id2},${visit.doctor_id}</h1>
                                    <strong>Doctor's Notes:</strong><br>
                                        `<div class="editable-container">
                                            <textarea class="editable-notes" rows="5">${visit.notes || ''}</textarea>
                                            <button class="save-notes-btn" onclick="saveNotes(this)">Save Notes</button>
                                            <span class="save-status"></span>
                                         </div>` 
                                        
                                        `<div class="non-editable-notes">${visit.notes || 'No notes recorded'}</div>`
                                    }
                                </div>
                                <button class="toggle-details-btn" onclick="toggleDetails(this.parentElement)">More Details</button>
                            </div>
                        `).join('')}
                        </div>
                    </div>
                `;
            } else {
                throw new Error(result.message || 'Failed to load doctor notes');
            }
        } catch (error) {
            console.error('Error:', error);
            mainContent.innerHTML = `
                <div class="container">
                    <p class="error-message">
                        ${error instanceof TypeError ? 
                            'Server response format error. Please contact support.' : 
                            'Failed to load notes. Please try again later.'}
                    </p>
                </div>
            `;
        }
    });
</script>
</html>