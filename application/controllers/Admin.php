<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function index(){
        
        $this->load->model("pessoa_model");

        $dt['tipo'] = $this->pessoa_model->getTipo();

        $dt2 = $this->pessoa_model->getTipo();
        if ($dt2['tipo'] == 0) {

        $this->load->view('estrutura/cabPage',$dt);
        $this->load->view('corpo/index_corpo');
        $this->load->view('estrutura/rodapePage');
        } else {
           redirect('./Prontuario/resumoMedico');
        }

    }


}