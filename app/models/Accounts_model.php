<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 12/14/21
 * Time: 5:30 PM
 */

class Accounts_model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function register_personal_account() {
        //print_r($this->inputs->post());
        $salutation = $this->security->xss_clean(trim($this->inputs->post("salutation")));
        $names = $this->security->xss_clean(trim($this->inputs->post->names));
        $dob = $this->security->xss_clean(trim($this->inputs->post->dob));
        $gender = $this->security->xss_clean(trim($this->inputs->post->gender));
        $phone = $this->security->xss_clean(trim($this->inputs->post->phone));
        $email = $this->security->xss_clean(trim($this->inputs->post->email));
        $district = $this->security->xss_clean(trim($this->inputs->post->district));
        $division = $this->security->xss_clean(trim($this->inputs->post->division));
        $parish = $this->security->xss_clean(trim($this->inputs->post->parish));
        $village = $this->security->xss_clean(trim($this->inputs->post->village));
        $street = $this->security->xss_clean(trim($this->inputs->post->street));
        $plot = $this->security->xss_clean(trim($this->inputs->post->plot));

        if (empty($names) or empty($email) or empty($dob) or empty($district) or empty($village) or empty($phone))
            return array("status" => "error", "message" => "Names,%20Date%20of%20birth,%20phone%20number,%20email%20and%20village%20should%20be%20left%20blank");
        if (! $this->security->validate_email($email))
            return array("status" => "error", "Email%20address%20provided%20is%20wrong");

        if ($this->is_value_exists("login", "email", $email))
            return array("status" => "error", "Email%address%20provided%20exists.");

        $username = $this->strings->remove_special_chars($this->check_url_for_duplicates(strtolower($names), "login", "username"));
        //echo $username;
        $password = substr(hash("sha256", time()), 5, 12);
        $new_password = hash("sha256", $password);

        $id = $this->db->insert("login", array("email" => $email, "password" => $new_password, "date_created" => date("Y-m-d"),
            "username" => $username));

        $this->db->insert("users", array("salutation" => $salutation, "names" => $names, "dob" => $dob, "gender" => $gender, "id" => $id, "telephone" => $phone));

        $this->db->insert("addresses", array("user" => $id, "district" => $district, "division" => $division, "parish" => $parish,
        "village" => $village, "street" => $street, "plot" => $plot));

        return array("status" => "success", "password" => $password, "email" => $email, "names" => $names);
    }

    function register_org_account() {
        $names = $this->security->xss_clean(trim($this->inputs->post->company));

        $phone = $this->security->xss_clean(trim($this->inputs->post->telephone));
        $email = $this->security->xss_clean(trim($this->inputs->post->email));


        if (empty($names) or empty($email) or empty($phone))
            return array("status" => "error", "message" => "Names,,%20phone%20number,%20email%20should%20be%20left%20blank");
        if (! $this->security->validate_email($email))
            return array("status" => "error", "message" => "Email%20address%20provided%20is%20wrong");

        if ($this->is_value_exists("login", "email", $email))
            return array("status" => "error", "message" => "Email%20address%20provided%20exists.");

        $username = $this->check_url_for_duplicates(strtolower($this->strings->remove_special_chars($names)), "login", "username");
        $password = substr(hash("sha256", time()), 5, 12);
        $new_password = hash("sha256", $password);

        $id = $this->db->insert("login", array("email" => $email, "password" => $new_password, "date_created" => date("Y-m-d"),
            "username" => $username, "role" => 2));

        $this->db->insert("users", array("names" => $names, "id" => $id, "telephone" => $phone));

        $this->db->insert("addresses", array("user" => $id));

        return array("status" => "success", "password" => $password, "email" => $email, "names" => $names);
    }

    function auth() {
        //print_r($_POST);
        if (! empty($this->inputs->post("email"))) {
            $this->db->where("email", trim($this->inputs->post->email));
            $this->db->where("password", hash("sha256", $this->inputs->post->password));
            return $this->db->getOne("login", "id, email, status, role, username, (select names from users where users.id = login.id) as names,  (select photo from users where users.id = login.id) as photo");
        }
        return array("status" => 2, "error" => "Invalid%20inputs");
    }

    function is_logged_in() {
        //print_r($_SESSION);
        if(empty($this->session->data("user")))
            $this->redirect("//" . $this->server->server_name );

    }

    function get_user_profile($user) {
        $this->db->where("users.id", $user);
        $this->db->join("login", "login.id = users.id");
        return $this->db->getOne("users", "names, email, date_created, role, status, username, 
        salutation, names, dob, gender, telephone, next_of_kin, occupation, nationality, cover_letter, photo");
    }

    function get_user_address($user) {
        $this->db->where("user", $user);
        return $this->db->getOne("addresses", "district, division, parish, village, street, plot");
    }

    function get_user_education($user) {
        $this->db->where("user", $user);
        $this->db->orderBy("id", "desc");
        return $this->db->get("education", "level, institution, a_year");
    }

    function get_user_work_experience($user) {
        $this->db->where("user", $user);
        $this->db->orderBy("id", "desc");
        return $this->db->get("work_experience", null, "company, position, start_date, end_date, description");
    }

    function get_user_referee($user) {
        $this->db->where("user", $user);
        $this->db->orderBy("id", "desc");
        $this->db->get("professional_references", null, "position, address, phone_number, description");
    }

    function update_account_bio() {
        if ($this->session->data->role == 1)
            return $this->update_personal_account();
        elseif ($this->session->data->role == 2)
            return $this->update_org_account();

    }

    function update_personal_account() {
        //print_r($_POST);
        $visibility = $this->security->xss_clean(trim($this->inputs->post->visibility));
        $salutation = $this->security->xss_clean(trim($this->inputs->post->salutation));
        $names = $this->security->xss_clean(trim($this->inputs->post->names));
        $dob = $this->security->xss_clean(trim($this->inputs->post->dob));
        $gender = $this->security->xss_clean(trim($this->inputs->post->gender));
        $next_of_kin = $this->security->xss_clean(trim($this->inputs->post->next_of_kin));
        $phone = $this->security->xss_clean(trim($this->inputs->post->phone));
        $occupation = $this->security->xss_clean(trim($this->inputs->post->occupation));
        $nationality = $this->security->xss_clean(trim($this->inputs->post->nationality));
        $cover_letter = substr($this->security->xss_clean(trim($this->inputs->post->cover_letter)), 0 , 200);
        if(empty($names) or empty($dob) or empty($phone))
            return array("status" => "error", "message" => "Names,%20Phone%20number,%20DOB%20shouldn't%20be%20left%blank.");
        $this->db->where("id", $this->session->data->user);
        $this->db->update("login", array("status" => $visibility));

        $this->db->where("id", $this->session->data->user);
        $this->db->update("users", array("cover_letter" => $cover_letter, "salutation" => $salutation, "names" => $names, "dob" => $dob, "gender" => $gender, "next_of_kin" => $next_of_kin, "occupation" => $occupation, "nationality" => $nationality));
        return array("status" => "success", "message" => "Successfully%20updated%20account%data.");
    }

    function update_org_account() {
        $visibility = $this->security->xss_clean(trim($this->inputs->post->visibility));
        $names = $this->security->xss_clean(trim($this->inputs->post->names));
        $dob = $this->security->xss_clean(trim($this->inputs->post->dob));
        $phone = $this->security->xss_clean(trim($this->inputs->post->phone));
        $occupation = $this->security->xss_clean(trim($this->inputs->post->occupation));
        $nationality = $this->security->xss_clean(trim($this->inputs->post->nationality));
        $cover_letter = substr($this->security->xss_clean(trim($this->inputs->post->cover_letter)), 0 ,200);
        if(empty($names) or empty($dob) or empty($phone))
            return array("status" => "error", "message" => "Names,%20Phone%20number,%20DOB%20shouldn't%20be%20left%blank.");
        $this->db->where("id", $this->session->data->user);
        $this->db->update("login", array("status" => $visibility));

        $this->db->where("id", $this->session->data->user);
        $this->db->update("users", array("cover_letter" => $cover_letter, "names" => $names, "dob" => $dob, "occupation" => $occupation, "nationality" => $nationality));
        return array("status" => "success", "message" => "Successfully%20updated%20account%data.");
    }

    function get_accounts($role = 2) {
        $this->db->where("role", $role);
        $this->db->where("status", 2);
        $this->db->join("users", "users.id = login.id");
        $this->db->orderBy("login.id", "desc");
        return $this->db->get("login", null, "names, username, nationality, photo, dob, salutation, role, status,
        occupation, gender");
    }

}