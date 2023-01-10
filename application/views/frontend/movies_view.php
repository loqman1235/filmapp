<!-- Section start -->
<section class="section" id="movies_section">
    <div class="section_header">
        <h3><strong>Movies</strong></h3>
        <div class="filters">
              <!-- Filter start -->
                <div class="filter" id="genreFilter">
                <div class="selcted_container">
                    <div class="filter_selected" data-value="">Select Genres</div>
                </div>
                <div class="filterToggleDropdownBtn">
                    <i class="far fa-angle-down"></i>
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
                    <div class="filter_selected" data-value="">Select Years</div>
                </div>
                <div class="filterToggleDropdownBtn">
                    <i class="far fa-angle-down"></i>
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
                <button id="filterSubmitBtn" class="btn btn_secondary filterSubmitBtn"><i class="fas fa-filter"></i> Filter</button>
        </div>
    </div>
    <?php if($movies) : ?>
    <div class="section_body genre_section">
        <?php foreach($movies as $movie) : ?>
        <div class="section_movie">
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
    initFilter(filter.lastElementChild.children, "#genresDropdown", "Genres");
  }

  if (filter.lastElementChild.id === "yearDropdown") {
    initFilter(filter.lastElementChild.children, "#yearDropdown", "Years");
  }
});

const filterSubmitBtn = document.getElementById('filterSubmitBtn');
const genreFilter = document.getElementById('genreFilter');
const yearFilter = document.getElementById('yearFilter');


filterSubmitBtn.addEventListener('click', (e) => {
    e.preventDefault();
    console.log(JSON.parse(genreFilter.firstElementChild.firstElementChild.dataset.value));
})





// async function getMoviesByGenreId(genreId){

//     let formData = new FormData();
//     formData.append('genreId', genreId);

//     const response = await fetch('<?= base_url('movies/getMoviesByGenre') ?>', {
//         method: 'POST', 
//         body: formData
//     });

//     const result = await response.json();
//     return result;
// }




</script>