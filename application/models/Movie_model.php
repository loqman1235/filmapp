<?php 

defined('BASEPATH') OR exit('No direct script access allowed');


class Movie_model extends CI_Model 
{
    public function getMovies()
    {
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->where('movie_is_visible', 1);
        $this->db->order_by('movie_id', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result();
        } 
        else
        {
            return false;
        }

    }

    // Get movies for pagination
    public function getMoviesLimit($start, $end)
    {
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->limit($start, $end);
        $this->db->where('movie_is_visible', 1);
        $this->db->order_by('movie_id', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result();
        } 
        else
        {
            return false;
        }
    }


    public function countMovies()
    {
        return $this->db->count_all("movies");
    }


    public function getMovieGenre() 
    {
        $this->db->select('tbl_movies_genres.movie_id, tbl_movies_genres.genre_id, tbl_genres.genre_name');
        $this->db->from('tbl_movies_genres');
        $this->db->join('tbl_genres', 'tbl_movies_genres.genre_id=tbl_genres.genre_id');
        $query = $this->db->get();

        $genres = [];

        if($query->num_rows() > 0) 
        {
            foreach($query->result() as $row)
            {
                $genres[$row->genre_name] = $row;
            }
        }

        return $query->result();

    }

    public function getMoviesByGenreId($genreId)
    {
        $this->db->select('tbl_movies.*, tbl_genres.genre_name');
        $this->db->from('tbl_movies_genres');
        $this->db->join('tbl_movies', 'tbl_movies_genres.movie_id=tbl_movies.movie_id');
        $this->db->join('tbl_genres', 'tbl_movies_genres.genre_id=tbl_genres.genre_id');
        $this->db->where('tbl_genres.genre_id', $genreId);
        $this->db->where('tbl_movies.movie_is_visible', 1);

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function getGenreById($genreId)
    {
        $this->db->select('genre_name');
        $this->db->from('genres');
        $this->db->where('genre_id', $genreId);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
    }


    public function getMovieById($movieId)
    {
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->where('movie_id', $movieId);
        $this->db->where('movie_is_visible', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
    }

    public function insertWatchlist($data)
    {
        if($this->db->insert('watchlist', $data))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }


    public function watchListMovieExist($movieId)
    {
        $this->db->select('*');
        $this->db->from('watchlist');
        $this->db->where('watchlist_movieId', $movieId);
        $this->db->where('user_id', $this->session->userdata('userId'));
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }


    }


    // Get Watchlists by user id

    public function getWatchlistMoviesByUserId()
    {
        $this->db->select("*");
        $this->db->from('watchlist');
        $this->db->order_by('watchlist_id', 'DESC');
        $this->db->where('user_id', $this->session->userdata('userId'));
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }

    }

    public function countWatchlistMoviesByUserId()
    {
        $this->db->select("*");
        $this->db->from('watchlist');
        $this->db->order_by('watchlist_id', 'DESC');
        $this->db->where('user_id', $this->session->userdata('userId'));
        $query = $this->db->get();

        return $query->num_rows();
    }


    public function removeMovieFromWatchlist($movieId)
    {
        if($this->db->delete('watchlist', ['watchlist_movieId' => $movieId]))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }


    // Get Similar Movies 

    public function getSimilarMovies($similarMoviesQueryKeywords, $movieName,$movieId)
    {
        $this->db->select('*');
        $this->db->from('movies');
        // $this->db->order_by('movie_id', 'desc');
        $this->db->where('MATCH(tbl_movies.movie_keywords) AGAINST("'.$similarMoviesQueryKeywords.'")');
        // $this->db->where('MATCH(tbl_movies.movie_name) AGAINST("'.$movieName.'")');
        $this->db->where('movie_id !=', $movieId);

        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    // Get movie actors

    public function getMovieActorsByMovieId($movieId)
    {
        $this->db->select('tbl_actors.actor_id, tbl_actors.actor_name, tbl_actors.actor_pic,tbl_movies_actors.actor_as');
        $this->db->from('tbl_movies_actors');
        $this->db->join('tbl_movies', 'tbl_movies_actors.movie_id=tbl_movies.movie_id');
        $this->db->join('tbl_actors', 'tbl_movies_actors.actor_id=tbl_actors.actor_id');
        $this->db->where('tbl_movies_actors.movie_id', $movieId);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }


    public function getFeaturedMovies()
    {
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->where('movie_is_visible', 1);
        $this->db->where('movie_is_featured', 1);
        $this->db->order_by('movie_id', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function getRecommendedMovies()
    {
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->where('movie_is_visible', 1);
        $this->db->where('movie_is_recommended', 1);
        $this->db->order_by('movie_id', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }


    // Update Movie Views
    public function updateMovieVisitors($id){

        $ip = $_SERVER['REMOTE_ADDR'];

        if(!empty($ip))
        {
            $this->db->select('movie_views');
            $this->db->from('movies');
            $this->db->where('movie_id', $id);
            $query = $this->db->get();
            $views = $query->row()->movie_views;
            $newViews = ++$views;

            $this->db->set('movie_views', $newViews);
            $this->db->where('movie_id', $id);
            $this->db->update('movies');
          
           
        }
        else
        {
            return false;
        }
    }

    public function getAllGenres() 
    {
        $query = $this->db->get('genres');

        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else 
        {
            return false;
        }

    }

    public function getMovieYears()
    {
        $this->db->distinct();
        $this->db->select('movie_year');
        $this->db->from('movies');
        $this->db->order_by('movie_year', 'DESC');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else 
        {
            return false;
        }
    }

    // Filter Movies
    public function getFilterdMovies($genres, $years, $order, $start, $limit)
    {
        $query = "SELECT tbl_movies.movie_id,tbl_movies.movie_name,tbl_movies.movie_poster,GROUP_CONCAT(tbl_genres.genre_name SEPARATOR ', ') as genres
        FROM tbl_movies_genres
        JOIN tbl_movies ON tbl_movies_genres.movie_id=tbl_movies.movie_id
        JOIN tbl_genres ON tbl_movies_genres.genre_id=tbl_genres.genre_id";

        if(isset($genres) && !empty($genres))
        {
            $query .= " AND tbl_movies_genres.genre_id IN ($genres)";
        }

        if(isset($years) && !empty($years))
        {
            $query .= " AND tbl_movies.movie_year IN ($years)";
        }
        $query .= ' WHERE movie_is_visible=1';

        $query .= ' GROUP BY tbl_movies.movie_id';

        if($order === 'asc')
        {
            $query .= " ORDER BY tbl_movies_genres.movie_id ASC";
        }
        else
        {
            $query .= " ORDER BY tbl_movies_genres.movie_id DESC";

        }

        $query .= ' LIMIT '.$start.', ' . $limit;

       if($this->db->query($query)->num_rows() > 0)
       {
        return $this->db->query($query)->result();
       }
       else 
       {
        return false;
       }

    }

    public function countFilteredMovies($genres, $years, $order)
    {
        $query = "SELECT tbl_movies.movie_id,tbl_movies.movie_name,tbl_movies.movie_poster,GROUP_CONCAT(tbl_genres.genre_name SEPARATOR ', ') as genres
        FROM tbl_movies_genres
        JOIN tbl_movies ON tbl_movies_genres.movie_id=tbl_movies.movie_id
        JOIN tbl_genres ON tbl_movies_genres.genre_id=tbl_genres.genre_id";

        if(isset($genres) && !empty($genres))
        {
            $query .= " AND tbl_movies_genres.genre_id IN ($genres)";
        }

        if(isset($years) && !empty($years))
        {
            $query .= " AND tbl_movies.movie_year IN ($years)";
        }
        $query .= ' WHERE movie_is_visible=1';

        $query .= ' GROUP BY tbl_movies.movie_id';

        if($order === 'asc')
        {
            $query .= " ORDER BY tbl_movies_genres.movie_id ASC";
        }
        else
        {
            $query .= " ORDER BY tbl_movies_genres.movie_id DESC";

        }



       return $this->db->query($query)->num_rows();
    }

}