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
    spinnerWrapper.style.position = 'relative'; // Add position relative for close button positioning

    // Add close button
    const closeButton = document.createElement('button');
    closeButton.id = 'loading-close-button';
    closeButton.innerHTML = '&times;'; // × symbol
    closeButton.style.position = 'absolute';
    closeButton.style.top = '10px';
    closeButton.style.right = '10px';
    closeButton.style.background = 'none';
    closeButton.style.border = 'none';
    closeButton.style.fontSize = '20px';
    closeButton.style.fontWeight = 'bold';
    closeButton.style.color = '#333';
    closeButton.style.cursor = 'pointer';
    closeButton.style.padding = '0';
    closeButton.style.width = '24px';
    closeButton.style.height = '24px';
    closeButton.style.borderRadius = '50%';
    closeButton.style.display = 'flex';
    closeButton.style.justifyContent = 'center';
    closeButton.style.alignItems = 'center';
    closeButton.style.transition = 'background-color 0.2s ease';
    closeButton.setAttribute('title', 'Cancel operation');
    
    // Hover effect
    closeButton.addEventListener('mouseover', () => {
        closeButton.style.backgroundColor = '#f0f0f0';
    });
    closeButton.addEventListener('mouseout', () => {
        closeButton.style.backgroundColor = 'transparent';
    });

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
    spinnerWrapper.appendChild(closeButton);
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
    addTextareaAutoResize();

    // Track current AJAX requests
    window.activeAjaxRequests = [];
    // Track any other running functions
    window.runningFunctions = new Set();

    // Add event listener for close button
    closeButton.addEventListener('click', () => {
        cancelAllOperations();
    });
});

// Function to cancel all operations
function cancelAllOperations() {
    // 1. Abort all active AJAX requests
    if (window.activeAjaxRequests && window.activeAjaxRequests.length > 0) {
        window.activeAjaxRequests.forEach(request => {
            if (request && typeof request.abort === 'function') {
                request.abort();
            }
        });
        window.activeAjaxRequests = [];
    }

    // 2. Clear any timers or intervals that might be running
    // This requires you to store the IDs of any setTimeouts or setIntervals
    if (window.operationTimers && window.operationTimers.length > 0) {
        window.operationTimers.forEach(timerId => {
            clearTimeout(timerId);
            clearInterval(timerId);
        });
        window.operationTimers = [];
    }

    // 3. Set flags to stop any running loops or processing
    window.cancelOperationsFlag = true;

    // 4. Call any function-specific cancellation callbacks
    if (window.runningFunctions && window.runningFunctions.size > 0) {
        window.runningFunctions.forEach(functionInfo => {
            if (typeof functionInfo.cancelCallback === 'function') {
                functionInfo.cancelCallback();
            }
        });
        window.runningFunctions.clear();
    }

    // 5. For Laravel-specific operations, trigger a cancelation event
    const cancelEvent = new CustomEvent('laravelOperationCancelled');
    document.dispatchEvent(cancelEvent);

    // 6. Hide the loading indicator
    hideLoadingIndicator();

    // Optional: Show a message that the operation was cancelled
    const message = document.createElement('div');
    message.textContent = 'Operation cancelled';
    message.style.position = 'fixed';
    message.style.top = '20px';
    message.style.right = '20px';
    message.style.padding = '10px 15px';
    message.style.backgroundColor = '#f8d7da';
    message.style.color = '#721c24';
    message.style.borderRadius = '4px';
    message.style.zIndex = '9999';
    document.body.appendChild(message);

    // Remove message after 3 seconds
    setTimeout(() => {
        if (document.body.contains(message)) {
            document.body.removeChild(message);
        }
    }, 3000);
}

// Enhanced show/hide functions with progress support
function showLoadingIndicator(message = 'Loading...', progress = 0) {
    const container = document.getElementById('loading-container');
    const text = document.getElementById('loading-text');
    const progressFill = document.getElementById('progress-fill');
    
    // Reset cancellation flag when showing the indicator
    window.cancelOperationsFlag = false;
    
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

// Helper function to register functions with cancellation
function registerRunningFunction(functionId, cancelCallback) {
    if (!window.runningFunctions) {
        window.runningFunctions = new Set();
    }
    window.runningFunctions.add({ id: functionId, cancelCallback });
}

// Helper function to unregister functions when complete
function unregisterRunningFunction(functionId) {
    if (window.runningFunctions) {
        for (let func of window.runningFunctions) {
            if (func.id === functionId) {
                window.runningFunctions.delete(func);
                break;
            }
        }
    }
}

// Integration with Laravel's AJAX/Axios requests - override to track requests
function setupAjaxTracking() {
    // If using jQuery AJAX
    if (window.jQuery) {
        let originalAjax = jQuery.ajax;
        jQuery.ajax = function() {
            let request = originalAjax.apply(this, arguments);
            window.activeAjaxRequests.push(request);
            
            // Remove from tracking when done
            request.always(function() {
                let index = window.activeAjaxRequests.indexOf(request);
                if (index > -1) {
                    window.activeAjaxRequests.splice(index, 1);
                }
            });
            
            return request;
        };
    }
    
    // If using Axios (common in Laravel)
    if (window.axios) {
        const originalRequest = axios.request;
        axios.request = function(config) {
            const source = axios.CancelToken.source();
            config.cancelToken = source.token;
            
            const request = originalRequest.call(this, config);
            window.activeAjaxRequests.push({ 
                request: request, 
                abort: () => source.cancel('Operation cancelled by user') 
            });
            
            request.finally(() => {
                let index = window.activeAjaxRequests.findIndex(r => r.request === request);
                if (index > -1) {
                    window.activeAjaxRequests.splice(index, 1);
                }
            });
            
            return request;
        };
    }
}

// Call this after DOM is loaded
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

// Initialize AJAX tracking when document is ready
document.addEventListener('DOMContentLoaded', () => {
    setupAjaxTracking();
    
    // Initialize arrays/sets if not already defined
    window.activeAjaxRequests = [];
    window.operationTimers = [];
    window.runningFunctions = new Set();
    window.cancelOperationsFlag = false;
});

// Example of usage with a cancelable function:
/*
function startLongOperation() {
    showLoadingIndicator('Processing data...', 0);
    
    // Register this operation so it can be cancelled
    const operationId = 'long-operation-' + Date.now();
    
    // Define what should happen if cancelled
    const cancelCallback = () => {
        console.log('Long operation was cancelled');
        // Do any cleanup here
    };
    
    registerRunningFunction(operationId, cancelCallback);
    
    // Example of a loop that checks the cancel flag
    let progress = 0;
    const timer = setInterval(() => {
        // Check if operation was cancelled
        if (window.cancelOperationsFlag) {
            clearInterval(timer);
            return;
        }
        
        progress += 10;
        updateLoadingProgress(progress, `Processing: ${progress}%`);
        
        if (progress >= 100) {
            clearInterval(timer);
            hideLoadingIndicator();
            unregisterRunningFunction(operationId);
        }
    }, 500);
    
    // Track this timer
    window.operationTimers.push(timer);
}
*/