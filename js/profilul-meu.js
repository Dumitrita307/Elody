document.addEventListener("DOMContentLoaded", () => {

    const links = document.querySelectorAll(".menu a");

    links.forEach(link => {

        link.addEventListener("mouseenter", () => {
            link.style.transform = "translateX(5px)";
        });

        link.addEventListener("mouseleave", () => {
            link.style.transform = "translateX(0)";
        });

    });

});