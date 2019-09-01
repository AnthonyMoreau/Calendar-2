document.addEventListener("DOMContentLoaded", function(){

    let transition = document.querySelector(".is-animate");

    setTimeout(function(){
        transition.classList.add("transition");
    }, 200)

    console.log(transition);
})