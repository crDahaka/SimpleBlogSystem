<?php

class HomeController extends BaseController
{
    function index() {
        $lastPosts = $this->model->getLastPosts(5);
        $this->posts = array_splice($lastPosts, 0, 3);
        $this->sidebarPosts = $lastPosts;
    }
	
	function view($id) {
        $this->post = $this->model->getPostById($id);
    }
}
