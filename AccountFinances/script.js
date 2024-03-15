const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
  document.querySelector("#left-window").classList.toggle("expand");
});


const body = document.querySelector("body"),
    sidebar = body.querySelector(".sidebar"),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    modeSwitch = body.querySelector(".toggle-switch"),
    modeText = body.querySelector(".mode-text");

     toggle.addEventListener("click", () =>{
        sidebar.classList.toggle("close");
    });
    searchBtn.addEventListener("click", () =>{
        sidebar.classList.remove("close");
    });

    modeSwitch.addEventListener("click", () =>{
        body.classList.toggle("dark");
    
        if(body.classList.contains("dark")){
            modeText.innerText = "Modo Claro"
        } else{
            modeText.innerText = "Modo Escuro"
        }
    
    });

