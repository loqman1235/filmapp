<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= (isset($page_title)) ? APPNAME . ' | ' . $page_title : APPNAME ?></title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link
      href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style2.css" />
    <script
      defer
      src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"
    ></script>
    <script defer type="module">
      import Swiper from "https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.esm.browser.min.js";

      const heroSlider = new Swiper(".heroSlider", {
        // Optional parameters
        direction: "horizontal",
        effect: 'fade',
        speed: 900,
        loop: true,
        autoplay: {
          delay: 5000,
        },
        slidesPerView: 1,


      });

      // Recommended Movies slider
      const recommendedMovieSerie = new Swiper("#recommendedMovieSerie", {
              loop: true,
              speed: 900,
              autoplay: false,
              slidesPerView: 6,
              spaceBetween: 20,
              centeredSlides: true,
              centerInsufficientSlides: true,
              centeredSlidesBounds: true,
              effect: 'card',

              // Navigation arrows
              navigation: {
                nextEl: ".movies_next_btn",
                prevEl: ".movies_prev_btn",
              },

              // mousewheel: {
              //   invert: true,
              // },
            });



      // Latest Movies slider
      const latestMovies = new Swiper("#latestMovies", {
        loop: true,
        speed: 900,
        autoplay: false,
        slidesPerView: 6,
        spaceBetween: 20,
        centeredSlides: true,
        centerInsufficientSlides: true,
        centeredSlidesBounds: true,
        effect: 'card',

        // Navigation arrows
        navigation: {
          nextEl: ".movies_next_btn",
          prevEl: ".movies_prev_btn",
        },

        // mousewheel: {
        //   invert: true,
        // },
      });

      // Latest Series Slider
      const latestSeries = new Swiper("#latestSeries", {
        loop: true,
        speed: 900,
        autoplay: false,
        slidesPerView: 6,
        spaceBetween: 20,
        centeredSlides: true,
        centerInsufficientSlides: true,
        centeredSlidesBounds: true,
        effect: 'card',

        // Navigation arrows
        navigation: {
          nextEl: ".movies_next_btn",
          prevEl: ".movies_prev_btn",
        },
        //  mousewheel: {
        //   invert: true,
        // },
      });


      // Suggested movies slider
      const suggestMovies = new Swiper("#suggestMovies", {
        loop: true,
        speed: 900,
        autoplay: false,
        slidesPerView: 6,
        spaceBetween: 20,
        centeredSlides: true,
        centerInsufficientSlides: true,
        centeredSlidesBounds: true,

        // Navigation arrows
        navigation: {
          nextEl: ".movies_next_btn",
          prevEl: ".movies_prev_btn",
        },
        //  mousewheel: {
        //   invert: true,
        // },
      });
    </script>

    <script type="module" src="<?= base_url() ?>assets/js/app.js" defer></script>
  </head>
  <body>
