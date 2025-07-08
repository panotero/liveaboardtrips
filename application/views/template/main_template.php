<?php 
$this->load->view("/template/header");
$this->load->view("/{$page}", $this->data); 
$this->load->view("/template/footer"); 

?>