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


}