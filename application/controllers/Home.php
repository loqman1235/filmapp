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
		$data['movies'] = $this->movie_model->getMovies();
		$data['genres'] = $this->movie_model->getMovieGenre();

		// Display Series
		$data['series'] = $this->serie_model->getAllSeries();
		// Get Serie Genre
		$data['serieGenres'] = $this->serie_model->getSerieGenre();

		// Featured Movies
		$data['featuredMovies'] = $this->movie_model->getFeaturedMovies();
		$data['featuredSeries'] = $this->serie_model->getFeaturedSeries();

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
		$data['moviesByGenre'] = $this->movie_model->getMoviesByGenreId($genreId);
		$data['genre'] = $this->movie_model->getGenreById($genreId);

		if($data['moviesByGenre'])
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


	public function movie($movieId)
	{

		$data['movie'] = $this->movie_model->getMovieById($movieId);
		$data['genres'] = $this->movie_model->getMovieGenre();
		$data['watchListMoviesExist'] = $this->movie_model->watchListMovieExist($movieId);
		$data['page_title'] = $data['movie']->movie_name;
		
		$similarMoviesQueryKeywords = $data['movie']->movie_keywords;

		$movieId = $data['movie']->movie_id;
		$movieName = $data['movie']->movie_name;
		$data['similarMovies'] = $this->movie_model->getSimilarMovies($similarMoviesQueryKeywords, $movieName, $movieId);

		// Movie Actors
		$data['movieActors'] = $this->movie_model->getMovieActorsByMovieId($movieId);

		if($data['movie'])
		{
			// Insert views
			$this->movie_model->updateMovieVisitors($movieId);

			$this->load->view('frontend/inc/header_view', $data);
			$this->load->view('frontend/inc/navbar_view');
			$this->load->view('frontend/movie_view', $data);
			$this->load->view('frontend/inc/footer_view');
		}
		else
		{
			redirect(base_url('home'));
		}
		
	}

}
