<?php 

defined('BASEPATH') OR exit('No direct script access allowed');


class Movie_model extends CI_Model 
{
    public function getMovies()
    {
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->limit(24);
        $this->db->where('movie_is_visible', 1);
        $this->db->order_by('movie_release_date', 'DESC');
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
        $this->db->order_by('movie_release_date', 'DESC');
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
        $this->db->order_by('tbl_movies.movie_id', 'DESC');

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


    public function watchListMovieExist($movieId, $mediaType)
    {
        $this->db->select('*');
        $this->db->from('watchlist');
        $this->db->where('watchlist_movieId', $movieId);
        $this->db->where('watchlist_type', $mediaType);
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


    public function removeMovieFromWatchlist($movieId, $movieName)
    {
        if($this->db->delete('watchlist', ['watchlist_movieId' => $movieId, 'watchlist_movieName' => $movieName]))
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
        $query = "SELECT tbl_movies.movie_id,tbl_movies.movie_name,tbl_movies.movie_poster, tbl_movies.movie_poster_large, tbl_movies.movie_imdb_rating, tbl_movies.movie_year, tbl_movies.movie_quality, tbl_movies.movie_runtime, tbl_movies.movie_age_rating,GROUP_CONCAT(tbl_genres.genre_name SEPARATOR ', ') as genres
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
            $query .= " ORDER BY tbl_movies.movie_release_date ASC";
        }
        else
        {
            $query .= " ORDER BY tbl_movies.movie_release_date DESC";

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



    // Get trending movies/series
    public function getTrendingMedias()
    {
        $query = "SELECT tbl_movies.movie_age_rating AS media_age_rating, tbl_movies.movie_runtime AS media_runtime ,tbl_movies.movie_year AS media_year, tbl_movies.movie_id AS media_id, tbl_movies.movie_name AS media_name, tbl_movies.movie_poster AS media_poster ,tbl_movies.movie_poster_large AS media_poster_large, 'movie' as media_type, tbl_movies.movie_views AS media_views, tbl_movies.movie_is_visible
        FROM tbl_movies
        WHERE tbl_movies.movie_views>100  AND tbl_movies.movie_is_visible=1
        UNION
        SELECT tbl_series.serie_age_rating AS media_age_rating, '' AS media_runtime, tbl_series.serie_year AS media_year, tbl_series.serie_id AS media_id, tbl_series.serie_name AS media_name,tbl_series.serie_poster AS media_poster,tbl_series.serie_poster_large AS media_poster_large, 'serie' as media_type ,tbl_series.serie_views AS media_views, tbl_series.serie_is_visible
        FROM tbl_series 
        WHERE tbl_series.serie_views>100 AND tbl_series.serie_is_visible=1
        ORDER BY media_views DESC;";

        if($this->db->query($query)->num_rows() > 4)
       {
        return $this->db->query($query)->result();
       }
       else 
       {
        return false;
       }

    }

    // Get Recommended medias
    public function getRecommendedMedias()
    {
        $query = "SELECT tbl_movies.movie_age_rating AS media_age_rating, tbl_movies.movie_runtime AS media_runtime ,tbl_movies.movie_year AS media_year, tbl_movies.movie_id AS media_id, tbl_movies.movie_name AS media_name, tbl_movies.movie_poster AS media_poster ,tbl_movies.movie_poster_large AS media_poster_large, 'movie' as media_type, tbl_movies.movie_views AS media_views 
        FROM tbl_movies 
        WHERE tbl_movies.movie_is_recommended=1 AND tbl_movies.movie_is_visible=1 
        UNION 
        SELECT tbl_series.serie_age_rating AS media_age_rating, '' AS media_runtime, tbl_series.serie_year AS media_year, tbl_series.serie_id AS media_id, tbl_series.serie_name AS media_name,tbl_series.serie_poster AS media_poster,tbl_series.serie_poster_large AS media_poster_large, 'serie' as media_type ,tbl_series.serie_views AS media_views 
        FROM tbl_series 
        WHERE tbl_series.serie_is_recommended=1 AND tbl_series.serie_is_visible=1 
        ORDER BY media_views DESC;";

        if($this->db->query($query)->num_rows() > 4)
        {
         return $this->db->query($query)->result();
        }
        else 
        {
         return false;
        }
    }

    public function getFeaturedMedias()
    {
        $query = "SELECT tbl_movies.movie_id AS media_id, tbl_movies.movie_name AS media_name, tbl_movies.movie_plot AS media_plot, tbl_movies.movie_year AS media_year, tbl_movies.movie_runtime AS media_runtime,tbl_movies.movie_imdb_rating AS media_imdb_rating,tbl_movies.movie_poster AS media_poster ,tbl_movies.movie_poster_large AS media_poster_large, tbl_movies.movie_backdrop AS media_backdrop, tbl_movies.movie_age_rating AS media_age_rating,'movie' as media_type, tbl_movies.movie_release_date AS media_release_date FROM tbl_movies 
        WHERE tbl_movies.movie_is_featured=1 AND tbl_movies.movie_is_visible=1 
        UNION 
        SELECT tbl_series.serie_id AS media_id, tbl_series.serie_name AS media_name,tbl_series.serie_plot AS media_plot, tbl_series.serie_year AS media_year, '' AS media_runtime ,tbl_series.serie_imdb_rating AS media_imdb_rating,tbl_series.serie_poster AS media_poster,tbl_series.serie_poster_large AS media_poster_large, tbl_series.serie_backdrop AS media_backdrop, tbl_series.serie_age_rating AS media_age_rating ,'serie' as media_type ,tbl_series.serie_release_date AS media_release_date 
        FROM tbl_series 
        WHERE tbl_series.serie_is_featured=1 AND tbl_series.serie_is_visible=1 
        ORDER BY media_release_date DESC;";

        if($this->db->query($query)->num_rows() > 4)
        {
         return $this->db->query($query)->result();
        }
        else 
        {
         return false;
        }
    }

    public function getRecentyAddedMedias()
    {
        $query = "SELECT tbl_movies.movie_age_rating AS media_age_rating, tbl_movies.movie_runtime AS media_runtime ,tbl_movies.movie_year AS media_year, tbl_movies.movie_is_visible, tbl_movies.movie_id AS media_id, tbl_movies.movie_name AS media_name, tbl_movies.movie_poster AS media_poster,tbl_movies.movie_poster_large AS media_poster_large,'movie' AS media_type ,tbl_movies.movie_uploaded_at AS upload_date 
        FROM tbl_movies
        WHERE tbl_movies.movie_is_visible=1 
        UNION 
        SELECT tbl_series.serie_age_rating AS media_age_rating, '' AS media_runtime, tbl_series.serie_year AS media_year, tbl_series.serie_is_visible, tbl_series.serie_id AS media_id, tbl_series.serie_name AS media_name,tbl_series.serie_poster AS media_poster,tbl_series.serie_poster_large AS media_poster_large,'serie' AS media_type ,tbl_series.serie_uploaded_at AS upload_date 
        FROM tbl_series 
        WHERE tbl_series.serie_is_visible=1 
        ORDER BY upload_date DESC;";

        if($this->db->query($query)->num_rows() > 0)
        {
         return $this->db->query($query)->result();
        }
        else 
        {
         return false;
        }
    }

    public function getNewlyReleasedMedias()
    {
        $query = "SELECT tbl_movies.movie_age_rating AS media_age_rating, tbl_movies.movie_runtime AS media_runtime ,tbl_movies.movie_year AS media_year, tbl_movies.movie_is_visible, tbl_movies.movie_id AS media_id, tbl_movies.movie_name AS media_name, tbl_movies.movie_poster AS media_poster ,tbl_movies.movie_poster_large AS media_poster_large,'movie' AS media_type ,tbl_movies.movie_release_date AS release_date 
        FROM tbl_movies
        WHERE tbl_movies.movie_is_visible=1 
        UNION 
        SELECT tbl_series.serie_age_rating AS media_age_rating, '' AS media_runtime, tbl_series.serie_year AS media_year, tbl_series.serie_is_visible, tbl_series.serie_id AS media_id, tbl_series.serie_name AS media_name,tbl_series.serie_poster AS media_poster,tbl_series.serie_poster_large AS media_poster_large,'serie' AS media_type ,tbl_series.serie_release_date AS release_date 
        FROM tbl_series 
        WHERE tbl_series.serie_is_visible=1 
        ORDER BY release_date DESC;";

        if($this->db->query($query)->num_rows() > 4)
        {
         return $this->db->query($query)->result();
        }
        else 
        {
         return false;
        }
    }

    public function getUpcommingMedias()
    {
        $query = "SELECT tbl_movies.movie_age_rating AS media_age_rating, tbl_movies.movie_runtime AS media_runtime ,tbl_movies.movie_year AS media_year, tbl_movies.movie_is_visible, tbl_movies.movie_id AS media_id, tbl_movies.movie_name AS media_name, tbl_movies.movie_poster AS media_poster ,tbl_movies.movie_poster_large AS media_poster_large,'movie' AS media_type ,tbl_movies.movie_release_date AS release_date 
        FROM tbl_movies
        WHERE tbl_movies.movie_is_visible=1 AND tbl_movies.movie_year= YEAR(CURDATE())
        UNION 
        SELECT tbl_series.serie_age_rating AS media_age_rating, '' AS media_runtime, tbl_series.serie_year AS media_year, tbl_series.serie_is_visible, tbl_series.serie_id AS media_id, tbl_series.serie_name AS media_name,tbl_series.serie_poster AS media_poster,tbl_series.serie_poster_large AS media_poster_large,'serie' AS media_type ,tbl_series.serie_release_date AS release_date 
        FROM tbl_series 
        WHERE tbl_series.serie_is_visible=1 AND tbl_series.serie_year= YEAR(CURDATE())
        ORDER BY release_date DESC;";
        
        if($this->db->query($query)->num_rows() > 4)
        {
         return $this->db->query($query)->result();
        }
        else 
        {
         return false;
        }
    }

    public function getMediasByGenre($genre)
    {
        $query = "SELECT tbl_movies.movie_age_rating AS media_age_rating, tbl_movies.movie_runtime AS media_runtime ,tbl_movies.movie_year AS media_year, tbl_movies.movie_is_visible, tbl_movies.movie_id AS media_id, tbl_movies.movie_name AS media_name, tbl_movies.movie_poster AS media_poster,tbl_movies.movie_poster_large AS media_poster_large,'movie' AS media_type,tbl_movies.movie_release_date AS release_date 
        FROM tbl_movies_genres 
        INNER JOIN tbl_movies ON tbl_movies_genres.movie_id=tbl_movies.movie_id 
        INNER JOIN tbl_genres ON tbl_movies_genres.genre_id=tbl_genres.genre_id 
        WHERE tbl_genres.genre_name='$genre' AND tbl_movies.movie_is_visible=1 
        UNION 
        SELECT tbl_series.serie_age_rating AS media_age_rating, '' AS media_runtime, tbl_series.serie_year AS media_year, tbl_series.serie_is_visible, tbl_series.serie_id AS media_id, tbl_series.serie_name AS media_name, tbl_series.serie_poster AS media_poster ,tbl_series.serie_poster_large AS media_poster_large,'serie' AS media_type,tbl_series.serie_release_date AS release_date 
        FROM tbl_series_genres 
        INNER JOIN tbl_series ON tbl_series_genres.serie_id=tbl_series.serie_id 
        INNER JOIN tbl_genres ON tbl_series_genres.genre_id=tbl_genres.genre_id
        WHERE tbl_genres.genre_name='$genre' AND tbl_series.serie_is_visible=1 
        ORDER BY release_date DESC;";

        if($this->db->query($query)->num_rows() > 4)
        {
        return $this->db->query($query)->result();
        }
        else 
        {
        return false;
        }
    }

    public function getMediasByGenreId($genreId)
    {
        $query = "SELECT tbl_movies.movie_age_rating AS media_age_rating, tbl_movies.movie_runtime AS media_runtime ,tbl_movies.movie_year AS media_year, tbl_movies.movie_is_visible, tbl_movies.movie_id AS media_id, tbl_movies.movie_name AS media_name, tbl_movies.movie_poster AS media_poster,tbl_movies.movie_poster_large AS media_poster_large,'movie' AS media_type,tbl_movies.movie_release_date AS release_date 
        FROM tbl_movies_genres 
        INNER JOIN tbl_movies ON tbl_movies_genres.movie_id=tbl_movies.movie_id 
        INNER JOIN tbl_genres ON tbl_movies_genres.genre_id=tbl_genres.genre_id 
        WHERE tbl_genres.genre_id='$genreId' AND tbl_movies.movie_is_visible=1 
        UNION 
        SELECT tbl_series.serie_age_rating AS media_age_rating, '' AS media_runtime, tbl_series.serie_year AS media_year, tbl_series.serie_is_visible, tbl_series.serie_id AS media_id, tbl_series.serie_name AS media_name, tbl_series.serie_poster AS media_poster ,tbl_series.serie_poster_large AS media_poster_large,'serie' AS media_type,tbl_series.serie_release_date AS release_date 
        FROM tbl_series_genres 
        INNER JOIN tbl_series ON tbl_series_genres.serie_id=tbl_series.serie_id 
        INNER JOIN tbl_genres ON tbl_series_genres.genre_id=tbl_genres.genre_id
        WHERE tbl_genres.genre_id='$genreId' AND tbl_series.serie_is_visible=1 
        ORDER BY release_date DESC;";

        if($this->db->query($query)->num_rows() > 0)
        {
        return $this->db->query($query)->result();
        }
        else 
        {
        return false;
        }
    }

}