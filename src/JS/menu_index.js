const menu =document.querySelector("#menu");
const abrir=document.querySelector("#abrir");
const cerrar=document.querySelector("#cerrar");
const link =document.querySelectorAll(".link");

abrir.addEventListener("click", ()=>{
    menu.classList.add("visible");
})

cerrar.addEventListener("click", ()=>{
    menu.classList.remove("visible")
})

link.addEventListener("click", ()=>{
    menu.classList.remove("visible");
})






