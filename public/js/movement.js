    document.addEventListener('DOMContentLoaded', () => {
        showTabContent('therapyAssessment'); // Default tab to show

        document.addEventListener('keydown', (event) => {
            const activeTab = document.querySelector('.tabs-content.active');
            const tabButtons = document.querySelectorAll('.tab-button');
            const activeButton = document.querySelector('.tab-button.active');
            const activeIndex = Array.from(tabButtons).indexOf(activeButton);

            if (event.key === 'ArrowUp' || event.key === 'ArrowDown') {
                if (activeTab) {
                    const textareas = activeTab.querySelectorAll('textarea');
                    if (textareas.length > 0) {
                        const focusedElement = document.activeElement;
                        const index = Array.from(textareas).indexOf(focusedElement);

                        if (event.key === 'ArrowUp' && index > 0) {
                            textareas[index - 1].focus();
                            event.preventDefault();
                        } else if (event.key === 'ArrowDown' && index < textareas.length - 1) {
                            textareas[index + 1].focus();
                            event.preventDefault();
                        }
                    }
                }
            } else if (event.key === 'ArrowRight' && activeIndex < tabButtons.length - 1) {
                tabButtons[activeIndex + 1].click();
                event.preventDefault();
            } else if (event.key === 'ArrowLeft' && activeIndex > 0) {
                tabButtons[activeIndex - 1].click();
                event.preventDefault();
            }
        });
    });