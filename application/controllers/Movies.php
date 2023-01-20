<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Movies extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('movie_model');
        $this->load->library('pagination');
    }

    public function index()
    {   

        // Pagination
        $config['base_url'] = base_url('/movies/page/');
        $config['total_rows'] = $this->movie_model->countMovies();
        $config['per_page'] = 24;
        $config ['num_links'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 3;
        $config['first_url'] = base_url('movies/page/1');

        // Customizing the pagination 
        $config['first_link'] = false; 
        $config['last_link']  = false;
        $config ['prev_link'] = '<i class="far fa-angle-left"></i>';
        $config ['next_link'] = '<i class="far fa-angle-right"></i>';
        $config['prev_tag_open'] = '<li class="pagination_item prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="pagination_item next">';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="pagination_item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="pagination_item active">';
        $config['cur_tag_close'] = '</li>';
        $config['full_tag_open']  = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $data['allGenres']  = $this->movie_model->getAllGenres(); 
        $data['page_title'] = 'Movies';
        $data['movies'] = $this->movie_model->getMoviesLimit($config['per_page'], $page);
		$data['genres'] = $this->movie_model->getMovieGenre();
        $data['years'] = $this->movie_model->getMovieYears();
        $data['pagination'] = $this->pagination->create_links();

       
        
        
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

    public function filterMovies() {
       $genres = htmlentities($this->input->post('genres'));
       $years = htmlentities($this->input->post('years'));
       $order = htmlentities($this->input->post('order'));
       

       // Pagination
       $config['base_url'] = base_url('#');
       $config['total_rows'] = $this->movie_model->countFilteredMovies($genres, $years, $order);
       $config['per_page'] = 24; 
       $config ['num_links'] = 2;
       $config['use_page_numbers'] = TRUE;
       $config['uri_segment'] = 3;

       // Customizing the pagination 
       $config['first_link'] = false; 
       $config['last_link']  = false;
       $config ['prev_link'] = '<i class="far fa-angle-left"></i>';
       $config ['next_link'] = '<i class="far fa-angle-right"></i>';
       $config['prev_tag_open'] = '<li class="pagination_item prev">';
       $config['prev_tag_close'] = '</li>';
       $config['next_tag_open'] = '<li class="pagination_item next">';
       $config['next_tag_close'] = '</li>';
       $config['num_tag_open'] = '<li class="pagination_item">';
       $config['num_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="pagination_item active">';
       $config['cur_tag_close'] = '</li>';
       $config['full_tag_open']  = '<ul class="pagination">';
       $config['full_tag_close'] = '</ul>';
       $page = $this->uri->segment(3);
       $start = ($page - 1) * $config['per_page'];
       $this->pagination->initialize($config);
       $filteredMovies = $this->movie_model->getFilterdMovies($genres, $years, $order, $start, $config['per_page']);
	   $filteredMoviesGenres = $this->movie_model->getMovieGenre();


       $result = '';

       if($filteredMovies)
       {
            foreach($filteredMovies as $movie)
            {
                $result .= '
                <div class="section_movie animate__animated animate__fadeIn">
                <a href="'. base_url("home/movie/") . $movie->movie_id .'" class="section_movie_poster">
                    <img src="'. $movie->movie_poster .'" />
                </a>
                <a href="'. base_url("home/movie/") . $movie->movie_id .'" class="section_movie_title">'; 
                if(strlen($movie->movie_name) >= 24) {
                    $result .= strShortner($movie->movie_name, 20) . '...';
                }
                else 
                {
                    $result .= $movie->movie_name;
                }
                $result .= '</a>';
                $result .= '<ul class="genre">';
                foreach($filteredMoviesGenres as $genre)
                {
                    if($genre->movie_id === $movie->movie_id)
                    {
                        $result .= '<li><a href="'. base_url("home/genre/") . $genre->genre_id .'">'. $genre->genre_name .'</a></li>';
                    }
                }
                $result .= '</ul>
                </div>
                ';
            }
       }
       else
       {
            $result .= '<p>Not found!</p>';
       }
        

       $data = ['result' => $result, 'pagination' => $this->pagination->create_links()];

       echo json_encode($data);

    }

}
