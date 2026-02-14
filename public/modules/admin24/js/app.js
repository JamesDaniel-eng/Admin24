document.addEventListener('DOMContentLoaded', (event) => {
    // Select all elements with the attribute data-menu="notifications-menu"
    const elementsToRemove = document.querySelectorAll('[data-menu="notifications-menu"]');

    // Iterate over the selected elements and remove each one
    elementsToRemove.forEach(element => {
        element.remove(); // The element.remove() method is the simplest way
    });
});