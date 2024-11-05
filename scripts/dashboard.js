document.addEventListener('DOMContentLoaded', function () {
    const sidebarLinks = document.querySelectorAll('.sidebar a');
    const actionSections = document.querySelectorAll('.action-section');

    // Hide all sections
    function hideAllSections() {
        actionSections.forEach(section => section.style.display = 'none');
    }

    // Show specific section based on the data-action attribute
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();  // Prevent default link behavior
            hideAllSections();       // Hide all sections
            
            // Get the target action and show the relevant section
            const action = link.getAttribute('data-action');
            const targetSection = document.getElementById(`${action}StickerSection`);
            
            if (targetSection) {
                targetSection.style.display = 'block';  // Display the selected section
            }
        });
    });
});
