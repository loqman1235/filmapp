<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('movie_model');
		$this->load->model('serie_model');
	}




	public function index()
	{

		// Get movie genre
		$data['genres'] = $this->movie_model->getMovieGenre();

		// Get Serie Genre
		$data['serieGenres'] = $this->serie_model->getSerieGenre();

		// Upcoming 
		$data['upcomingMedias'] = $this->movie_model->getUpcommingMedias();

		// Featured
		$data['featuredMedias'] = $this->movie_model->getFeaturedMedias();

		$data['watchlistMovies'] = $this->movie_model->getWatchlistMoviesByUserId();
		
		// Recommended
		$data['recommendedMedias'] = $this->movie_model->getRecommendedMedias();

		// Trending
		$data['trendingMedias'] = $this->movie_model->getTrendingMedias();
		
		// Recently added
		$data['recentMedias'] = $this->movie_model->getRecentyAddedMedias();
	
		// New Releases
		$data['newlyReleasedMedias'] = $this->movie_model->getNewlyReleasedMedias();

		$allGenres = $this->movie_model->getAllGenres();
		$data['mediasByGenre'] = [];

		foreach($allGenres as $genre)
		{
			$data['mediasByGenre'][$genre->genre_name] = $this->movie_model->getMediasByGenre($genre->genre_name);
		}

		ksort($data['mediasByGenre']);

		
		
		


		$this->load->view('frontend/inc/header_view');
		$this->load->view('frontend/inc/navbar_view');
		$this->load->view('frontend/inc/carousel_view', $data);
		$this->load->view('frontend/home_view', $data);
		$this->load->view('frontend/inc/footerElement_view');
		$this->load->view('frontend/inc/footer_view');

	}


	public function genre($genreId) 
	{
		


		$data['movies'] = $this->movie_model->getMovies();
		$data['genres'] = $this->movie_model->getMovieGenre();
		$data['mediasByGenre'] = $this->movie_model->getMediasByGenreId($genreId);
		$data['genre'] = $this->movie_model->getGenreById($genreId);

		if($data['mediasByGenre'])
		{
			$this->load->view('frontend/inc/header_view');
			$this->load->view('frontend/inc/navbar_view');
			$this->load->view('frontend/genre_view', $data);
			$this->load->view('frontend/inc/footerElement_view');
			$this->load->view('frontend/inc/footer_view');
		}
		else
		{
			redirect(base_url('home'));
		}


	}



}
