<?php

use JetBrains\PhpStorm\ArrayShape;

class Sermons_model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    function get_sermons($video = false): MysqliDb|array|string
    {
        if ($video)
            $this->db->where("url", $video);
        $this->db->orderBy("id", "desc");
        return $this->db->get("videos", null, "url, id, video_title, video_description, video_url, is_live, date_added, status, image");
    }

    /**
     * @throws Exception
     */
    #[ArrayShape(['message' => "string"])] function add_sermon(): array
    {
        print_r($_FILES);
        print_r($_POST);
        $title = trim($this->inputs->post("title"));
        $description = trim($this->inputs->post("description"));
        $link = trim($this->inputs->post("url"));
        if (empty($title) or empty($description) or empty($link))
            return ['message' => "Title or description or URL should not be blank"];
        $url = strtolower($this->strings->remove_special_chars($title));
        //echo $url;
        $url = $this->check_url_for_duplicates($url, "videos", "url");
        $file_name = $this->upload_profile_pic($url);
        if (! $file_name)
            $file_name = "placeholder.png";
        $data = ["video_title" => $title,
            "video_description" => $description,
            "video_url" => $link,
            "date_added" => date("Y-m-d"),
            "user" => $this->session->data("user"),
            "image" => $file_name,
            "url" => $url];
        $this->db->insert("videos", $data);
        return ["message" => "Successfully added summon"];
    }

    /**
     * @throws Exception
     */
    function upload_profile_pic($url): bool|string
    {
        if (! isset($_FILES['file']['name']))
            return false;
        $file_name = $_FILES['file']['name'];
        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = self::password_hash(($url . time() . random_int(300, 5000))) . "." . $extension;
        $tmp_file = $_FILES['file']['tmp_name'];
        $size = filesize($tmp_file);

        if ($size > pow(1024, 2))
            return false;
        $accepted_files = array("jpg", "jpeg", "png", "gif");
        if (in_array($extension, $accepted_files)) {
            move_uploaded_file($tmp_file, "media/" . $new_file_name);
            return $new_file_name;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    #[ArrayShape(["message" => "string"])] function delete_sermon($sermon): array
    {
        $action = $this->inputs->get("i");
        if ($action == "del")
            return ["message" => self::sermon_del($sermon)];
        else
            return ['message' => self::sermon_toggle_visibility($sermon)];

    }

    /**
     * @throws Exception
     */
    function sermon_del($sermon): string
    {
        $this->db->where("id", $sermon);
        $result = $this->db->getOne("videos", "id, image, video_title");
        if ($result['image'] != "placeholder.png")
            unlink("media/" . $result['image']);
        $this->db->where("id", $result['id']);
        $this->db->delete("videos");
        return "Deleting Video " . $result['video_title'] . " has been successful";
    }

    /**
     * @throws Exception
     */
    function sermon_toggle_visibility($sermon): string
    {
        $this->db->where("id", $sermon);
        $result = $this->db->getOne("videos", "id, image, video_title, status");
        $this->db->where("id", $result['id']);
        $this->db->update("videos", ['status' => $result['status'] == 0 ? 1 : 0]);
        return "Video " . $result['video_title'] . " has been " . ($result['status'] == 0 ? "Published" : "Unpublished");
    }

}