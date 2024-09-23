
const prevButton = document.querySelector('.carrusel__prev');
const nextButton = document.querySelector('.carrusel__next');
const imagesContainer = document.querySelector('.carrusel__imagenes');
const images = document.querySelectorAll('.carrusel__imagenes img');

let index = 0;
const intervalTime = 7000;

function showImage(index) {
    const offset = -index * 100;
    imagesContainer.style.transform = `translateX(${offset}%)`;
}

function nextImage() {
    index = (index < images.length - 1) ? index + 1 : 0;
    showImage(index);
}

function prevImage() {
    index = (index > 0) ? index - 1 : images.length - 1;
    showImage(index);
}

prevButton.addEventListener('click', prevImage);
nextButton.addEventListener('click', nextImage);

setInterval(nextImage, intervalTime);
