const btnLeft = document.querySelector(".btn__left"),
      btnRight = document.querySelector(".btn__right"),
      slider = document.querySelector("#slider"),
      sliderSection = document.querySelectorAll(".slider__section");


btnRight.addEventListener("click", e => moverDerecha());
btnLeft.addEventListener("click", e => moverIzquierda());

setInterval(() => {
    moverDerecha();
},3000);

let operacion = 0,
    counter = 0,
    widthImg = 100 / (sliderSection.length);
function moverDerecha() {
    if (counter >= sliderSection.length-1){
        counter = 0;
        operacion = 0;
        slider.style.transform = `translate(-${operacion}%)`;
        return;
    }
    counter++;
    operacion += widthImg;
    slider.style.transform = `translate(-${operacion}%)`;
    slider.style.transition = "all ease .6s";
    
}

function moverIzquierda() {
    counter --;
    if(counter < 0 ) {
        counter = sliderSection.length-1;
        operacion = widthImg * (sliderSection.length-1);
        slider.style.transform = `translate(-${operacion}%)`;
        return;
    }
    operacion -= widthImg;
        slider.style.transform = `translate(-${operacion}%)`;
        slider.style.transition = "all ease .6s";
    
}







