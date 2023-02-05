<!-- section start -->
<section class="section" id="list_section">
    <div class="section_header">
    <h3><strong>My List</strong> <small id="listCounter">(<?= $countListMovies ?>)</small></h3>
    </div>
    <div id="watchlist_body"></div>
</section>
<!-- section end -->


<script>
    const removeFromMyWatchlistBtn = document.querySelector('.removeFromMyWatchlistBtn');
    const watchlist_body = document.getElementById('watchlist_body');


    // Get watchlist

    let getWatchlist = async () => {
        const response = await fetch('<?= base_url('mylist/getWatchlist') ?>');
        const result = await response.json();

        watchlist_body.innerHTML = result.result;
        document.getElementById('listCounter').innerText = `(${result.listCounter})`;

    }


    getWatchlist()




    let removeMovieFromWatchlist = async (e) => {
    e.preventDefault();

    let formData = new FormData();
    formData.append('movieId', e.target.dataset.id);
    formData.append('movieName', e.target.dataset.name);

    const response = await fetch('<?= base_url('mylist/removeFromWatchList') ?>',{
      method: 'POST',
      body: formData
    });

    const result = await response.json();

    if(result.success)
    {
      alert(result.msg);
      getWatchlist();
    
    }

  }

  // Remove movie from user's watchlist

// document.querySelectorAll('.removeFromMyWatchlistBtn').forEach(removeBtn => {
//     removeBtn.addEventListener('click', removeMovieFromWatchlist)
// })







</script>