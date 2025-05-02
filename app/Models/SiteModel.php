<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteModel extends Model
{
    protected $DBGroup = 'site';
    protected $table      = 'wp_posts';
    protected $primaryKey = 'ID';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'ID',
        'post_date',
        'post_content',
        'post_title',
        'post_excerpt',
    ];

    protected $useTimestamps = false;

    /*---------------------------------------------------------------------------*/
    // News Data
    /*---------------------------------------------------------------------------*/
    public function getNews()
    {
        $this->table('wp_posts')->select(
            'wp_posts.ID,
            wp_posts.post_date,
            wp_posts.post_content,
            wp_posts.post_title,
            wp_posts.post_excerpt'
        );
        $this->join('wp_term_relationships', 'wp_posts.ID = wp_term_relationships.object_id');
        $this->where('wp_posts.post_status', 'publish');
        $this->where('wp_posts.post_type', 'post');
        $this->where('wp_term_relationships.term_taxonomy_id', 2); // Category_ID
        $this->orderBy('wp_posts.ID', 'desc');
        return $this;
    }

    public function getNewsById($ID)
    {
        $this->table('wp_posts')->select(
            'wp_posts.ID,
            wp_posts.post_date,
            wp_posts.post_content,
            wp_posts.post_title,
            wp_posts.post_excerpt'
        );
        $this->where('wp_posts.post_status', 'publish');
        $this->where('wp_posts.post_type', 'post');
        $this->where('wp_posts.ID', intval($ID));
        return $this;
    }

    /*---------------------------------------------------------------------------*/
    // Lowongan Kerja Data
    /*---------------------------------------------------------------------------*/
    public function getLowonganKerja()
    {
        $this->table('wp_posts')->select(
            'wp_posts.ID,
            wp_posts.post_date,
            wp_posts.post_content,
            wp_posts.post_title,
            wp_posts.post_excerpt'
        );
        $this->join('wp_term_relationships', 'wp_posts.ID = wp_term_relationships.object_id');
        $this->where('wp_posts.post_status', 'publish');
        $this->where('wp_posts.post_type', 'post');
        $this->where('wp_term_relationships.term_taxonomy_id', 4); // Category_ID
        $this->orderBy('wp_posts.ID', 'desc');
        return $this;
    }

    public function getLowonganKerjaById($ID)
    {
        $this->table('wp_posts')->select(
            'wp_posts.ID,
            wp_posts.post_date,
            wp_posts.post_content,
            wp_posts.post_title,
            wp_posts.post_excerpt'
        );
        $this->where('wp_posts.post_status', 'publish');
        $this->where('wp_posts.post_type', 'post');
        $this->where('wp_posts.ID', intval($ID));
        return $this;
    }


    /*---------------------------------------------------------------------------*/
    // Advertisement Data
    /*---------------------------------------------------------------------------*/
    public function getAdvertisement()
    {
        $this->table('wp_posts')->select(
            'wp_posts.ID,
            wp_posts.post_date,
            wp_posts.post_content,
            wp_posts.post_title,
            wp_posts.post_excerpt'
        );
        $this->join('wp_term_relationships', 'wp_posts.ID = wp_term_relationships.object_id');
        $this->where('wp_posts.post_status', 'publish');
        $this->where('wp_posts.post_type', 'post');
        $this->where('wp_term_relationships.term_taxonomy_id', 5); // Category_ID
        $this->orderBy('wp_posts.ID', 'desc');
        return $this;
    }

    public function getAdvertisementById($ID)
    {
        $this->table('wp_posts')->select(
            'wp_posts.ID,
            wp_posts.post_date,
            wp_posts.post_content,
            wp_posts.post_title,
            wp_posts.post_excerpt'
        );
        $this->where('wp_posts.post_status', 'publish');
        $this->where('wp_posts.post_type', 'post');
        $this->where('wp_posts.ID', intval($ID));
        return $this;
    }

    /*---------------------------------------------------------------------------*/
    // Agenda Data
    /*---------------------------------------------------------------------------*/
    public function getAgenda()
    {
        $this->table('wp_posts')->select(
            'wp_posts.ID,
            wp_posts.post_date,
            wp_posts.post_content,
            wp_posts.post_title,
            wp_posts.post_excerpt'
        );
        $this->join('wp_term_relationships', 'wp_posts.ID = wp_term_relationships.object_id');
        $this->where('wp_posts.post_status', 'publish');
        $this->where('wp_posts.post_type', 'post');
        $this->where('wp_term_relationships.term_taxonomy_id', 6); // Category_ID
        $this->orderBy('wp_posts.ID', 'desc');
        return $this;
    }

    public function getAgendaById($ID)
    {
        $this->table('wp_posts')->select(
            'wp_posts.ID,
            wp_posts.post_date,
            wp_posts.post_content,
            wp_posts.post_title,
            wp_posts.post_excerpt'
        );
        $this->where('wp_posts.post_status', 'publish');
        $this->where('wp_posts.post_type', 'post');
        $this->where('wp_posts.ID', intval($ID));
        return $this;
    }

    /*---------------------------------------------------------------------------*/
    // getPengurus Data
    /*---------------------------------------------------------------------------*/
    public function getPengurus()
    {
        $this->table('wp_posts')->select(
            'wp_posts.ID,
            wp_posts.post_date,
            wp_posts.post_content,
            wp_posts.post_title,
            wp_posts.post_excerpt'
        );
        $this->where('wp_posts.post_status', 'publish');
        $this->where('wp_posts.post_type', 'page');
        $this->where('wp_posts.ID', 29); // Pengurus page ID
        return $this;
    }
}
