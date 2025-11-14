const swiper = new Swiper('.mySwiper', {
    slidesPerView: 3,
    spaceBetween: 30,
    freeMode: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});

const LangSelect = document.getElementById('lang');
LangSelect.addEventListener("change", function () {
    window.location.href = this.value;
})