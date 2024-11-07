document.addEventListener('DOMContentLoaded', function () {
    var splide = new Splide('#carousel', {
        type       : 'loop',
        perMove    : 1,
        autoplay   : true,
        interval   : 3000,
        pagination : true,
        arrows     : true,

        breakpoints : {
            10000: {
                perPage: 1,
            },
            1200: {
                perPage: 1,
            },
            900: {
                perPage: 1,
            },
            600: {
                perPage: 1,
            },
        },
    });

    splide.mount();
});