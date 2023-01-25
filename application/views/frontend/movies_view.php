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
                    <i class="far fa-angle-down"></i>
                </div>
                <ul class="filter_dropdown" id="genresDropdown">
                    <?php if($allGenres) : ?>
                        <?php foreach($allGenres as $genre) : ?>
                    <li class="filter_dropdown_item" data-value="<?= $genre->genre_id ?>">
                    <i class="fal fa-circle"></i> <span class="item_text"><?= $genre->genre_name ?></span>
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
                    <i class="far fa-angle-down"></i>
                </div>
                <ul class="filter_dropdown" id="yearDropdown">
                    <?php if ($years) : ?>
                    <?php foreach($years as $year) : ?>
                    <li class="filter_dropdown_item" data-value="<?= $year->movie_year ?>">
                    <i class="fal fa-circle"></i> <span class="item_text"><?= $year->movie_year ?></span>
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
                    <i class="far fa-angle-down"></i>
                </div>
                <ul class="filter_dropdown" id="orderDropdown">
                    <li class="filter_dropdown_item" data-value="asc">
                    <i class="fal fa-circle"></i> <span class="item_text">Ascending</span>
                    </li>
                    <li class="filter_dropdown_item checked" data-value="desc">
                    <i class="fal fa-circle"></i>
                    <span class="item_text">Descending</span>
                    </li>
                </ul>
                </div>
                <!-- Filter ends -->
                <button id="filterSubmitBtn" class="btn btn_secondary filterSubmitBtn"><span class="material-symbols-rounded">filter_alt</span> Filter</button>
        </div>
    </div>
    <?php if($movies) : ?>
    <div class="section_body genre_section " id="sectionBody">
        <?php foreach($movies as $movie) : ?>
        <div class="section_movie animate__animated animate__fadeIn">
            <a href="<?= base_url('movies/movie/') . $movie->movie_id ?>" class="section_movie_poster">
                <img src="<?= $movie->movie_poster ?>" alt="<?= $movie->movie_name ?>">
            </a>
            <a href="<?= base_url('movies/movie/') . $movie->movie_id ?>" class="section_movie_title"><?= (strlen($movie->movie_name) >= 24) ? strShortner($movie->movie_name, 24) . '...' : $movie->movie_name ?></a>
            <div class="section_movie_data">
                <div class="section_movie_info">
                    <p class="section_movie_rating"><i class="fas fa-star fa-sm"></i> <?= $movie->movie_imdb_rating ?></p>
                    <div class="separator"></div>
                    <p class="section_movie_year"><?= $movie->movie_year ?></p>
                </div>
                <div class="section_movie_type">Movie</div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else : ?>
        <p>No Movies Found</p>
     <?php endif; ?>
</section>
<!-- Section end -->

<div class="spinner_container w-100 text-center"> 
    <div id="spinner" class="lds-facebook"><div></div><div></div><div></div></div>
</div>


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
const spinner = document.getElementById('spinner');
let start = 0;
let limit = 12;
// let page = 1;



const filterData = async (page) => {

    let requestFetch = function() {
            console.log('** beforeSend request fetch **');
            // Display loader
            spinner.classList.add('active');
            return fetch.apply(this, arguments);
        }


    // e.preventDefault();
    const genre = JSON.parse(document.getElementById('genreFilter').firstElementChild.firstElementChild.dataset.value);
    const year = JSON.parse(document.getElementById('yearFilter').firstElementChild.firstElementChild.dataset.value);
    const order = JSON.parse(document.getElementById('orderFilter').firstElementChild.firstElementChild.dataset.value);

    let formData =  new FormData();
    formData.append('genres', genre);
    formData.append('years', year);
    formData.append('order', order);

    const response = await requestFetch('<?= base_url('movies/filterMovies/') ?>' + page, {
        method: 'POST',
        body: formData
    });

    const result = await response.json();

    // Hide spinner after getting data
    spinner.classList.remove('active');
    sectionBody.innerHTML = result.result;
    document.querySelector('.pagination_container').innerHTML = result.pagination;

    document.querySelectorAll('.pagination li a').forEach(pageLink => {
        pageLink.addEventListener('click', (e) => {
            e.preventDefault();
            let page = pageLink.dataset.ciPaginationPage;
            filterData(page);
        })
    })

};


filterSubmitBtn.addEventListener('click', (e) => {
    e.preventDefault();
    filterData(1)
    document.querySelectorAll('.filter_dropdown').forEach(dropdown => dropdown.classList.remove('active'));
    document.querySelectorAll('.filterToggleDropdownBtn').forEach(btn => btn.classList.remove('active'));
})





</script>
