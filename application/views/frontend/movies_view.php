<!-- Section start -->
<section class="section" id="movies_section">
    <div class="section_header">
        <h3><strong>Movies</strong></h3>
        <div class="filters">
              <!-- Filter start -->
                <div class="filter" id="genreFilter">
                <div class="selcted_container">
                    <div class="filter_selected" data-value="[]">Select genres</div>
                </div>
                <div class="filterToggleDropdownBtn">
                    <i class="far fa-caret-down"></i>
                </div>
                <ul class="filter_dropdown" id="genresDropdown">
                    <?php if($allGenres) : ?>
                        <?php foreach($allGenres as $genre) : ?>
                    <li class="filter_dropdown_item" data-value="<?= $genre->genre_id ?>">
                    <i class="fal fa-square"></i> <span class="item_text"><?= $genre->genre_name ?></span>
                    </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                </div>
                <!-- Filter ends -->

                <!-- Filter start -->
                <div class="filter" id="yearFilter">
                <div class="selcted_container">
                    <div class="filter_selected" data-value="[]">Select years</div>
                </div>
                <div class="filterToggleDropdownBtn">
                    <i class="far fa-caret-down"></i>
                </div>
                <ul class="filter_dropdown" id="yearDropdown">
                    <?php if ($years) : ?>
                    <?php foreach($years as $year) : ?>
                    <li class="filter_dropdown_item" data-value="<?= $year->movie_year ?>">
                    <i class="fal fa-square"></i> <span class="item_text"><?= $year->movie_year ?></span>
                    </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                </div>
                <!-- Filter ends -->

                <!-- Filter start -->
                <div class="filter" id="orderFilter">
                <div class="selcted_container">
                    <div class="filter_selected" data-value='["desc"]'>Descending</div>
                </div>
                <div class="filterToggleDropdownBtn">
                    <i class="far fa-caret-down"></i>
                </div>
                <ul class="filter_dropdown" id="orderDropdown">
                    <li class="filter_dropdown_item" data-value="asc">
                    <i class="fal fa-square"></i> <span class="item_text">Ascending</span>
                    </li>
                    <li class="filter_dropdown_item checked" data-value="desc">
                    <i class="fal fa-square"></i>
                    <span class="item_text">Descending</span>
                    </li>
                </ul>
                </div>
                <!-- Filter ends -->
                <button id="filterSubmitBtn" class="btn btn_secondary filterSubmitBtn"><i class="fas fa-filter"></i> Filter</button>
        </div>
    </div>
    <?php if($movies) : ?>
        <div class="spinner"><img src="<?= base_url('assets/img/spinner.gif') ?>" alt=""></div>
    <div class="section_body genre_section " id="sectionBody">
        <?php foreach($movies as $movie) : ?>
        <div class="section_movie animate__animated animate__fadeIn">
            <a href="<?= base_url('home/movie/') . $movie->movie_id ?>" class="section_movie_poster">
                <img src="<?= $movie->movie_poster ?>" alt="<?= $movie->movie_name ?>">
            </a>
            <a href="<?= base_url('home/movie/') . $movie->movie_id ?>" class="section_movie_title"><?= $movie->movie_name ?></a>
            <ul class="genre">
                <?php foreach($genres as $genre) : ?>
                <?php if($genre->movie_id === $movie->movie_id) : ?>
                    <li><a href="<?= base_url('home/genre/') . $genre->genre_id ?>"><?= $genre->genre_name ?></a></li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else : ?>
        <p>No Movies Found</p>
     <?php endif; ?>
</section>
<!-- Section end -->

<!-- Pagination start -->
<div class="pagination_container">
    <?= $pagination ?>
</div>
<!-- Pagination end -->



<script type="module">
import { initFilter } from "<?= base_url() ?>assets/js/libs/Functions.js";

const filters = document.querySelectorAll(".filter");

filters.forEach((filter) => {
  // console.log(filter.lastElementChild.children);
  const filterToggleBtn = filter.firstElementChild.nextElementSibling;

  //  Toggle Filter Dropdown Menu
  filterToggleBtn.addEventListener("click", () => {
    filterToggleBtn.classList.toggle("active");
    filterToggleBtn.nextElementSibling.classList.toggle("active");
  });

  if (filter.lastElementChild.id === "genresDropdown") {
    initFilter(filter.lastElementChild.children, "#genresDropdown", "genres");
  }

  if (filter.lastElementChild.id === "yearDropdown") {
    initFilter(filter.lastElementChild.children, "#yearDropdown", "years");
  }

  if (filter.lastElementChild.id === "orderDropdown") {
    initFilter(filter.lastElementChild.children, "#orderDropdown", "order", false);
  }

  
});


// Filter Data
const filterSubmitBtn = document.getElementById('filterSubmitBtn');
const sectionBody = document.getElementById('sectionBody');


const filterData = async (e) => {
    e.preventDefault();
    const genre = JSON.parse(document.getElementById('genreFilter').firstElementChild.firstElementChild.dataset.value);
    const year = JSON.parse(document.getElementById('yearFilter').firstElementChild.firstElementChild.dataset.value);
    const order = JSON.parse(document.getElementById('orderFilter').firstElementChild.firstElementChild.dataset.value);

    let formData =  new FormData();
    formData.append('genres', genre);
    formData.append('years', year);
    formData.append('order', order);
    const spinner = document.querySelector('.spinner');
    // Show spinner
    spinner.classList.add('active');
    const response = await fetch('<?= base_url('movies/filterMovies') ?>', {
        method: 'POST',
        body: formData
    });

    const result = await response.json();
    // Hide spinner
    // spinner.classList.remove('active');



    sectionBody.innerHTML = result;


};


filterSubmitBtn.addEventListener('click', filterData)



</script>