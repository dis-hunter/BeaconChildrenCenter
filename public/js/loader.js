// Add this to your HTML to create a modern loading indicator with overlay
document.addEventListener('DOMContentLoaded', () => {
    // Create container for loading screen
    const loadingContainer = document.createElement('div');
    loadingContainer.id = 'loading-container';
    loadingContainer.style.display = 'none';
    loadingContainer.style.position = 'fixed';
    loadingContainer.style.top = '0';
    loadingContainer.style.left = '0';
    loadingContainer.style.width = '100%';
    loadingContainer.style.height = '100%';
    loadingContainer.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    loadingContainer.style.zIndex = '9999';
    loadingContainer.style.display = 'none';
    loadingContainer.style.justifyContent = 'center';
    loadingContainer.style.alignItems = 'center';
    loadingContainer.style.flexDirection = 'column';

    // Create spinner wrapper
    const spinnerWrapper = document.createElement('div');
    spinnerWrapper.style.background = 'white';
    spinnerWrapper.style.padding = '30px';
    spinnerWrapper.style.borderRadius = '12px';
    spinnerWrapper.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
    spinnerWrapper.style.display = 'flex';
    spinnerWrapper.style.flexDirection = 'column';
    spinnerWrapper.style.alignItems = 'center';
    spinnerWrapper.style.gap = '15px';

    // Create loading spinner
    const loadingSpinner = document.createElement('div');
    loadingSpinner.id = 'loading-spinner';
    loadingSpinner.style.width = '50px';
    loadingSpinner.style.height = '50px';
    loadingSpinner.style.border = '4px solid #f3f3f3';
    loadingSpinner.style.borderTop = '4px solid #3498db';
    loadingSpinner.style.borderRadius = '50%';
    loadingSpinner.style.animation = 'spin 1s ease-in-out infinite';

    // Create loading text
    const loadingText = document.createElement('div');
    loadingText.id = 'loading-text';
    loadingText.textContent = 'Loading...';
    loadingText.style.color = '#333';
    loadingText.style.fontFamily = 'Arial, sans-serif';
    loadingText.style.fontSize = '16px';
    loadingText.style.animation = 'pulse 1.5s ease-in-out infinite';

    // Add progress bar
    const progressBar = document.createElement('div');
    progressBar.id = 'loading-progress';
    progressBar.style.width = '200px';
    progressBar.style.height = '4px';
    progressBar.style.backgroundColor = '#f3f3f3';
    progressBar.style.borderRadius = '2px';
    progressBar.style.overflow = 'hidden';
    progressBar.innerHTML = '<div id="progress-fill"></div>';

    // Style progress fill
    const progressFill = progressBar.firstChild;
    progressFill.style.width = '0%';
    progressFill.style.height = '100%';
    progressFill.style.backgroundColor = '#3498db';
    progressFill.style.transition = 'width 0.3s ease-in-out';

    // Append elements
    spinnerWrapper.appendChild(loadingSpinner);
    spinnerWrapper.appendChild(loadingText);
    spinnerWrapper.appendChild(progressBar);
    loadingContainer.appendChild(spinnerWrapper);
    document.body.appendChild(loadingContainer);

    // Add styles
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    `;
    document.head.appendChild(style);
});

// Enhanced show/hide functions with progress support
function showLoadingIndicator(message = 'Loading...', progress = 0) {
    const container = document.getElementById('loading-container');
    const text = document.getElementById('loading-text');
    const progressFill = document.getElementById('progress-fill');
    
    if (container && text && progressFill) {
        container.style.display = 'flex';
        text.textContent = message;
        progressFill.style.width = `${progress}%`;
    }
}

function hideLoadingIndicator() {
    const container = document.getElementById('loading-container');
    if (container) {
        container.style.display = 'none';
    }
}

function updateLoadingProgress(progress, message = null) {
    const progressFill = document.getElementById('progress-fill');
    const text = document.getElementById('loading-text');
    
    if (progressFill) {
        progressFill.style.width = `${progress}%`;
    }
    
    if (message && text) {
        text.textContent = message;
    }
}

// Usage example:
// showLoadingIndicator('Loading data...', 0);
// updateLoadingProgress(50, 'Halfway there...');
// hideLoadingIndicator();