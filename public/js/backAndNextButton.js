function extractRegistrationCode() {
    const pathSegments = window.location.pathname.split('/');
    const RegNo = pathSegments[pathSegments.length - 1];
    console.log("Extracted Registration Code:", RegNo);
    return RegNo;
}

function NavigateBack() {
    const RegNo = extractRegistrationCode();

    if (!RegNo) {
        console.error("Registration code not found!");
        return;
    }

    console.log("Reloading the page with registration code:", RegNo);

    // Reload the specific dashboard page with a cache-busting parameter
    window.location.href = `/occupationaltherapy_dashboard/${RegNo}?nocache=${Date.now()}`;
}

document.getElementById('backButton').addEventListener('click', function() {
    NavigateBack();
});

document.getElementById('nextButton').addEventListener('click', function() {
    window.history.forward();
});