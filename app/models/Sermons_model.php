<?php

class Sermons_model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    function get_sermons() {
        $this->db->orderBy("id", "desc");
        return $this->db->get("videos", null, "id, video_title, video_description, video_url, is_live, date_added, status, image");
    }

}