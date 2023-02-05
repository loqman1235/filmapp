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
        <div class="section_movie animate__animated animate__fadeIn" data-media-id="<?= $movie->movie_id ?>" data-media-type="movie">
            <div class="section_movie_poster" data-poster="<?= $movie->movie_poster ?>">
                <img src="<?= $movie->movie_poster ?>" alt="<?= $movie->movie_name ?>">
                <div class="movie_poster_overlay">
                    <a href="<?= base_url('movies/movie/') . $movie->movie_id ?>" class="play_btn"><i class="fas fa-play"></i></a>
                    <?php if($this->session->userdata('is_logged_in')) :?>
                        <button data-add="true" data-id="<?= $movie->movie_id ?>" class="btn btn_outline addToListBtn watchlistBtn">Add to my list</button>
                        <?php endif; ?>
                </div>
            </div>
            <a data-media-name="<?= $movie->movie_name ?>" href="<?= base_url('movies/movie/') . $movie->movie_id ?>" class="section_movie_title"><?= (strlen($movie->movie_name) >= 24) ? strShortner($movie->movie_name, 24) . '...' : $movie->movie_name ?></a>
            <div class="section_movie_data">
                <div class="section_movie_info">
                    <p data-media-year="<?= $movie->movie_year ?>" class="section_movie_year"><?= $movie->movie_year ?></p>
                    <div class="separator"></div>
                    <p data-media-runtime="<?= $movie->movie_runtime ?>" class="section_movie_runtime"><?= $movie->movie_runtime ?></p>
                </div>
                <div data-media-age-rating="<?= $movie->movie_age_rating ?>" class="section_movie_type"><?= (empty($movie->movie_age_rating)) ? 'NA' : $movie->movie_age_rating ?></div>
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
const buttons = document.querySelectorAll(".watchlistBtn");
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


// Add to watchlist
buttons.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    addItemToDB(btn);
  });

  checkItemExist(btn).then((itemExist) => {
    if (itemExist) {
      btn.textContent = "Remove from My List";
      btn.dataset.add = false;
      btn.classList.remove("add-to-watchlist-btn");
      btn.classList.add("remove-from-watchlist-btn");
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        removeItemFromDB(btn);
      });
    }
  });
});


//  Add media to watchlist
async function addItemToDB(btn) {
  // Check if item exist in DB
  checkItemExist(btn).then(async (itemExist) => {
    if (!itemExist) {
      //  Add Item
      let formData = new FormData();

      const itemId = btn.parentElement.parentElement.parentElement.dataset.mediaId;
      const itemPoster = btn.parentElement.parentElement.dataset.poster;
      const itemName = btn.parentElement.parentElement.nextElementSibling.dataset.mediaName;
      const itemYear = btn.parentElement.parentElement.parentElement.lastElementChild.firstElementChild.firstElementChild.dataset.mediaYear;
      const itemRuntime = btn.parentElement.parentElement.parentElement.lastElementChild.firstElementChild.lastElementChild.dataset.mediaRuntime;
      const itemAgeRating = btn.parentElement.parentElement.parentElement.lastElementChild.lastElementChild.dataset.mediaAgeRating;
      const itemType = btn.parentElement.parentElement.parentElement.dataset.mediaType;

      formData.append("mediaId", itemId);
      formData.append("mediaPoster", itemPoster);
      formData.append("mediaName", itemName);
      formData.append("mediaYear", itemYear);
      formData.append("mediaRuntime", itemRuntime);
      formData.append("mediaAgeRating", itemAgeRating);
      formData.append("mediaType", itemType);

     

      const response = await fetch("<?= base_url('mylist/addMediaToWatchlist') ?>", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        // Display a message to msg to inform use that the media is added to watchlist
        document.querySelectorAll(".watchlistBtn").forEach((itemButton) => {
          if (
            itemButton.parentElement.parentElement.parentElement.dataset.mediaId 
            === 
            btn.parentElement.parentElement.parentElement.dataset.mediaId
          ) {
            itemButton.textContent = "Remove from My List";
            itemButton.dataset.add = false;
            itemButton.classList.remove("add-to-watchlist-btn");
            itemButton.classList.add("remove-from-watchlist-btn");
            itemButton.addEventListener('click', (e) => {
                e.preventDefault();
                removeItemFromDB(itemButton);
            });
          }
        });
      } else {
        alert(result.message);
      }
    } 
  });
}

// Remove Media from watchlist
async function removeItemFromDB(btn) {
  checkItemExist(btn).then(async (itemExist) => {
    if (itemExist) {
      let formData = new FormData();
      formData.append("mediaId", btn.parentElement.parentElement.parentElement.dataset.mediaId);
      formData.append("mediaName", btn.parentElement.parentElement.nextElementSibling.dataset.mediaName);

      const response = await fetch("<?= base_url('mylist/removeMediaFromList') ?>", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();
      if (result.success) {
        document.querySelectorAll("button").forEach((itemButton) => {
          if (
            itemButton.parentElement.parentElement.parentElement.dataset.mediaId 
            === 
            btn.parentElement.parentElement.parentElement.dataset.mediaId
          ) {
            itemButton.textContent = "Add to My List";
            itemButton.dataset.add = true;
            itemButton.classList.remove("remove-from-watchlist-btn");
            itemButton.classList.add("add-to-watchlist-btn");
          }
        });
      }
    }
  });
}


// Check media exist
async function checkItemExist(btn) {
  let formData = new FormData();
  formData.append("mediaId", btn.parentElement.parentElement.parentElement.dataset.mediaId);
  formData.append("mediaType", btn.parentElement.parentElement.parentElement.dataset.mediaType);

  const response = await fetch("<?= base_url('mylist/mediaExistInWatchlist') ?>", {
    method: "POST",
    body: formData,
  });

  const result = await response.json();
  if (result) return true;
  else return false;
}




</script>
