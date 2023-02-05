<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= (isset($page_title)) ? APPNAME . ' | ' . $page_title : APPNAME ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
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
    
    const sectionBodies = (document.querySelectorAll('.homeSection .section_body').length !== 0) ? document.querySelectorAll('.homeSection .section_body') : document.querySelectorAll('#suggestion .section_body');

    sectionBodies.forEach(section_body => {

      const sectionBodyId = section_body.id;
      const prevBtn = section_body.lastElementChild.previousElementSibling;
      const nextBtn = section_body.lastElementChild;
     
      const slider = new Swiper(`#${sectionBodyId}`, {
        loop: false,
        speed: 400,
        autoplay: false,
        slidesPerView: 5,
        spaceBetween: 10,
        slidesPerGroup: 2,
      
        navigation: {
          nextEl: `.${nextBtn.className}`,
          prevEl: `.${prevBtn.className}`,
        },

        // mousewheel: {
        //   invert: true,
        // },
      });
    });


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


    </script>

    <script type="module" src="<?= base_url() ?>assets/js/app.js" defer></script>
  </head>
  <body>
