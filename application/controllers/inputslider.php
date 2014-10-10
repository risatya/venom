<?php

class inputslider extends CI_Controller {

    public function index() {

        $head['ajax'] = '<script language="javascript" type="text/javascript" src=". base_url() .ajax/ajaxinputslider.js"></script>';

        $this->load->view("", $head);
    }

    function save() {
        $this->load->model("modelslider");
        $idx = $_POST['idx'];
        $Title = $_POST['Title'];
        $image = $_POST['image'];
        $link = $_POST['link'];
        $sort_order = $_POST['sort_order'];
        $description = $_POST['description'];
        if ($idx == 0) {
            $this->modelslider->insertslider($idx, $Title, $image, $link, $sort_order, $description);
        } else {
            $this->modelslider->updateslider($idx, $Title, $image, $link, $sort_order, $description);
        }
    }

    function detele($idx) {
        $this->load->model("modelslider");
        $idx = $_POST['idx'];

        $this->modelslider->deleteslider($idx);
    }

}

?>