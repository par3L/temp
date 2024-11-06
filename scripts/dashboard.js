document.addEventListener('DOMContentLoaded', function () {
    const sidebarLinks = document.querySelectorAll('.sidebar a');
    const actionSections = document.querySelectorAll('.action-section');

    function hideAllSections() {
        actionSections.forEach(section => section.style.display = 'none');
    }

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();  
            hideAllSections();       

            const action = link.getAttribute('data-action');
            const targetSection = document.getElementById(`${action}StickerSection`);
            
            if (targetSection) {
                targetSection.style.display = 'block';  
            }
        });
    });
});
