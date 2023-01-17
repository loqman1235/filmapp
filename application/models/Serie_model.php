<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Serie_model extends CI_Model 
{
    // Get All Series
    public function getAllSeries() 
    {
        $this->db->select('*');
        $this->db->from('series');
        $this->db->order_by('serie_id', 'DESC');
        $this->db->where('serie_is_visible', 1);
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

    public function countSeries()
    {
        return $this->db->count_all("series");
    }

     // Get series for pagination
     public function getSeriesLimit($start, $end)
     {
         $this->db->select('*');
         $this->db->from('series');
         $this->db->limit($start, $end);
         $this->db->where('serie_is_visible', 1);
         $this->db->order_by('serie_id', 'DESC');
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

    // Get genres of a serie
    public function getSerieGenre() 
    {
        $this->db->select('tbl_series_genres.serie_id, tbl_series_genres.genre_id, tbl_genres.genre_name');
        $this->db->from('tbl_series_genres');
        $this->db->join('tbl_genres', 'tbl_series_genres.genre_id=tbl_genres.genre_id');
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

    public function getFeaturedSeries()
    {
        $this->db->select('*');
        $this->db->from('series');
        $this->db->where('serie_is_visible', 1);
        $this->db->where('serie_is_featured', 1);
        $this->db->order_by('serie_id', 'DESC');
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

    public function getRecommendedSeries()
    {
        $this->db->select('*');
        $this->db->from('series');
        $this->db->where('serie_is_visible', 1);
        $this->db->where('serie_is_recommended', 1);
        $this->db->order_by('serie_id', 'DESC');
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


    public function getSerieById($serieId)
    {
        $this->db->select('*');
        $this->db->from('series');
        $this->db->where('serie_id', $serieId);
        $this->db->where('serie_is_visible', 1);
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


    // Get Similar Series 

    public function getSimilarSeries($similarSeriesQueryKeywords, $serieId)
    {
        $this->db->select('*');
        $this->db->from('series');
        // $this->db->order_by('movie_id', 'desc');
        $this->db->where('MATCH(tbl_series.serie_keywords) AGAINST("'.$similarSeriesQueryKeywords.'")');
        $this->db->where('serie_id !=', $serieId);

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

    public function getSerieActorsBySerieId($serieId)
    {
        $this->db->select('tbl_actors.actor_id, tbl_actors.actor_name, tbl_actors.actor_pic,tbl_series_actors.actor_as');
        $this->db->from('tbl_series_actors');
        $this->db->join('tbl_series', 'tbl_series_actors.serie_id=tbl_series.serie_id');
        $this->db->join('tbl_actors', 'tbl_series_actors.actor_id=tbl_actors.actor_id');
        $this->db->where('tbl_series_actors.serie_id', $serieId);
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


    public function getSeasonsBySerieId($serieId)
    {
        $this->db->select('tbl_series.serie_id, tbl_seasons.season_id,tbl_seasons.season_name, tbl_seasons.season_poster, tbl_seasons.season_year');
        $this->db->from('tbl_series');
        $this->db->join('tbl_seasons', 'tbl_series.serie_id=tbl_seasons.serie_id');
        $this->db->where('tbl_series.serie_id', $serieId);
        $query = $this->db->get();

        if($query->num_rows() >0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }

    }

    // Get Episodes
    public function getEpisodesBySerieId($seasonId, $serieId)
    {
        $this->db->select('tbl_seasons.serie_id, tbl_seasons.season_id, tbl_episodes.episode_id, tbl_episodes.episode_name, tbl_episodes.episode_embed');
        $this->db->from('tbl_seasons');
        $this->db->join('tbl_episodes', 'tbl_seasons.season_id=tbl_episodes.seasons_id');
        $this->db->where('season_id', $seasonId);
        $this->db->where('serie_id', $serieId);
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

     // Update Serie Views
     public function updateSerieVisitors($id){

        $ip = $_SERVER['REMOTE_ADDR'];

        if(!empty($ip))
        {
            $this->db->select('serie_views');
            $this->db->from('series');
            $this->db->where('serie_id', $id);
            $query = $this->db->get();
            $views = $query->row()->serie_views;
            $newViews = ++$views;

            $this->db->set('serie_views', $newViews);
            $this->db->where('serie_id', $id);
            $this->db->update('series');
          
           
        }
        else
        {
            return false;
        }
    }


    public function getSerieYears() 
    {
        $this->db->distinct();
        $this->db->select('serie_year');
        $this->db->from('series');
        $this->db->order_by('serie_year', 'DESC');
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

    public function getFilterdSeries($genres, $years, $order, $start, $limit)
    {
        $query = "SELECT tbl_series.serie_id,tbl_series.serie_name,tbl_series.serie_poster,GROUP_CONCAT(tbl_genres.genre_name SEPARATOR ', ') as genres
        FROM tbl_series_genres
        JOIN tbl_series ON tbl_series_genres.serie_id=tbl_series.serie_id
        JOIN tbl_genres ON tbl_series_genres.genre_id=tbl_genres.genre_id";

        if(isset($genres) && !empty($genres))
        {
            $query .= " AND tbl_series_genres.genre_id IN ($genres)";
        }

        if(isset($years) && !empty($years))
        {
            $query .= " AND tbl_series.serie_year IN ($years)";
        }

        $query .= ' WHERE serie_is_visible=1';
        $query .= ' GROUP BY tbl_series.serie_id';

        if($order === 'asc')
        {
            $query .= " ORDER BY tbl_series_genres.serie_id ASC";
        }
        else
        {
            $query .= " ORDER BY tbl_series_genres.serie_id DESC";

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

    public function countFilteredSeries($genres, $years, $order)
    {
        $query = "SELECT tbl_series.serie_id,tbl_series.serie_name,tbl_series.serie_poster,GROUP_CONCAT(tbl_genres.genre_name SEPARATOR ', ') as genres
        FROM tbl_series_genres
        JOIN tbl_series ON tbl_series_genres.serie_id=tbl_series.serie_id
        JOIN tbl_genres ON tbl_series_genres.genre_id=tbl_genres.genre_id";

        if(isset($genres) && !empty($genres))
        {
            $query .= " AND tbl_series_genres.genre_id IN ($genres)";
        }

        if(isset($years) && !empty($years))
        {
            $query .= " AND tbl_series.serie_year IN ($years)";
        }

        $query .= ' WHERE serie_is_visible=1';
        $query .= ' GROUP BY tbl_series.serie_id';

        if($order === 'asc')
        {
            $query .= " ORDER BY tbl_series_genres.serie_id ASC";
        }
        else
        {
            $query .= " ORDER BY tbl_series_genres.serie_id DESC";

        }


       return $this->db->query($query)->num_rows();
    }


}