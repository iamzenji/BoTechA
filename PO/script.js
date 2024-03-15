const body = document.querySelector("body"),
    sidebar = body.querySelector(".sidebar"),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    modeSwitch = body.querySelector(".toggle-switch");

    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
        const sidebarState = sidebar.classList.contains("close") ? "closed" : "open";
        localStorage.setItem("sidebarState", sidebarState);
    });
    searchBtn.addEventListener("click", () =>{
        sidebar.classList.remove("close");
    });

    // Check sidebar state from session storage and open it if needed
    const storedSidebarState = sessionStorage.getItem("sidebarState");
    if (storedSidebarState === "open") {
        sidebar.classList.remove("open");
    }
    
    // Intercept clicks on anchor tags within the sidebar
    const sidebarLinks = document.querySelectorAll('.menu-links a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default navigation behavior
            // You can add logic here to dynamically load content or perform other actions
            console.log("Sidebar link clicked:", link.href);
        });
    });