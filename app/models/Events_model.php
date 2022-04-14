<?php

use JetBrains\PhpStorm\ArrayShape;

class Events_model extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->model("Sermons_model");
    }

    /**
     * @throws Exception
     */
    #[ArrayShape(['message' => "string"])] function add_event($blog = false): array
    {
        //print_r($_POST);
        $title = trim($this->inputs->post("title"));
        if (! $blog) {
            $start_date = trim($this->inputs->post("date")[0]);
            $end_date = trim($this->inputs->post("date")[1]);
            $start_time = trim($this->inputs->post("time")[0]);
            $end_time = trim($this->inputs->post("time")[1]);
        }
        if (empty($title))
            return ['message' => "Missing title"];
        $description = trim($this->inputs->post("description"));
        $url = strtolower($this->strings->remove_special_chars($title));
        //echo $url;
        $url = $this->check_url_for_duplicates($url, "events", "url");
        $file_name = $this->model->Sermons_model->upload_profile_pic($url);
        $data = [
            "title" => $title,
            "description" => $description,
            "start_time" => $start_time ?? null,
            "end_time" => $end_time ?? null,
            "start_date"=> $start_date ?? null,
            "end_date" => $end_date ?? null,
            "image" => $file_name,
            "url" => $url,
            "user" => $this->session->data("user"),
            "date_added" => date("Y-m-d")
        ];
        if ($blog)
            $data['is_event'] = 2;
        $this->db->insert("events", $data);
        return ["message" => "Event / Blog ". $title . " successfully created"];
    }

    /**
     * @throws Exception
     */
    function get_all_events($type = 1): MysqliDb|array|string
    {
        $this->db->where("is_event", $type);
        $this->db->orderBy("id", "desc");
        return $this->db->get("events", null, "title, description, start_time, end_time, start_date, end_date, image, url, id, status, date_added");
    }

    /**
     * @throws Exception
     */
    function delete_event($event): array
    {
        $action = $this->inputs->get("i");
        if ($action == "del")
            return ["message" => self::event_del($event)];
        else
            return ['message' => self::event_toggle_visibility($event)];
    }

    /**
     * @throws Exception
     */
    function event_del($sermon): string
    {
        $this->db->where("id", $sermon);
        $result = $this->db->getOne("events", "id, image, title");
        if ($result['image'] != "placeholder.png")
            unlink("media/" . $result['image']);
        $this->db->where("id", $result['id']);
        $this->db->delete("events");
        return "Event / Article " . $result['title'] . " has been successfully deleted";
    }

    /**
     * @throws Exception
     */
    function event_toggle_visibility($event): string
    {
        $this->db->where("id", $event);
        $result = $this->db->getOne("events", "id, image, title, status");
        $this->db->where("id", $result['id']);
        $this->db->update("events", ['status' => $result['status'] == 0 ? 1 : 0]);
        return "Event / Article " . $result['title'] . " has been " . ($result['status'] == 0 ? "Published" : "Unpublished");
    }

}