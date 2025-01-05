     // Add this to your HTML to create a loading indicator element
     document.addEventListener('DOMContentLoaded', () => {
        const loadingIndicator = document.createElement('div');
        loadingIndicator.id = 'loading-indicator';
        loadingIndicator.style.display = 'none'; // Hidden by default
        loadingIndicator.style.position = 'fixed';
        loadingIndicator.style.top = '50%';
        loadingIndicator.style.left = '50%';
        loadingIndicator.style.transform = 'translate(-50%, -50%)';
        loadingIndicator.style.width = '40px';
        loadingIndicator.style.height = '40px';
        loadingIndicator.style.border = '4px solid #ccc';
        loadingIndicator.style.borderTop = '4px solid #007bff';
        loadingIndicator.style.borderRadius = '50%';
        loadingIndicator.style.animation = 'spin 1s linear infinite';
        document.body.appendChild(loadingIndicator);

        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    });

    function showLoadingIndicator() {
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'block';
        }
    }

    function hideLoadingIndicator() {
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
    }