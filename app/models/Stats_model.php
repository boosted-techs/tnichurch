<?php

use JetBrains\PhpStorm\ArrayShape;

class Stats_model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    #[ArrayShape(["events" => "array|null|string", "blog" => "array|null|string", "sermons" => "array|null|string"])] function get_stats(): array
    {
        $this->db->where("is_event", 1);
        $events = $this->db->getOne("events", "count(id) as events");
        $this->db->where("is_event", 2);
        $blog = $this->db->getOne("events", "count(id) as blog");
        $sermons = $this->db->getOne("videos", "count(id) as sermons");
        return ["events" => $events['events'], "blog" => $blog['blog'], "sermons" => $sermons['sermons']];
    }
}