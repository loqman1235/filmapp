<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Movies extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('movie_model');
    }

    public function index()
    {   

        $data['allGenres']  = $this->movie_model->getAllGenres(); 
        $data['page_title'] = 'Movies';
        $data['movies'] = $this->movie_model->getMovies();
		$data['genres'] = $this->movie_model->getMovieGenre();
        $data['years'] = $this->movie_model->getMovieYears();

        $this->load->view('frontend/inc/header_view', $data);
        $this->load->view('frontend/inc/navbar_view');
        $this->load->view('frontend/movies_view', $data);
		$this->load->view('frontend/inc/footerElement_view');
        $this->load->view('frontend/inc/footer_view');

    }

    public function getMoviesByGenre()
    {
        if(!empty($this->input->post('genreId')))
        {
            $result = '';
            $genreId = htmlentities($this->input->post('genreId'));
            $movies  = $this->movie_model->getMoviesByGenreId($genreId);
		    $genres  = $this->movie_model->getMovieGenre();

            if($movies)
            {
                foreach($movies as $movie) 
                {
                    $result .= '<div class="section_movie">
                    <a href="'. base_url('home/movie/') . $movie->movie_id .'" class="section_movie_poster">
                        <img src="'. $movie->movie_poster .'" alt="'. $movie->movie_name .'">
                    </a>
                    <a href="'. base_url('home/movie/') . $movie->movie_id .'" class="section_movie_title">'. $movie->movie_name .'</a>';
                    $result .= '<ul class="genre">';
                    foreach($genres as $genre) {
                        if($genre->movie_id === $movie->movie_id)
                        {
                            $result .= '<li><a href="'. base_url('home/genre') . $genre->genre_id .'">'. $genre->genre_name .'</a></li>';
                        }
                    }
                    $result .= '</ul>';
                    $result .= '</div>';
                  
                }
            }
            else
            {
                $result .= 'No Movies found';
            }

            echo json_encode($result);

        }
       
    }

}