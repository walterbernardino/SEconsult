<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prontuario extends CI_Controller{ 

    public function __construct() {
        Parent::__construct();
        $this->verificarLogin();
    }
    public function index(){
        $this->verificarLogin();
        $this->load->model("pessoa_model");
        $dt['tipo'] = $this->pessoa_model->getTipo();
        $dt2 = $this->pessoa_model->getTipo();
        if ($dt2['tipo'] == 1) {

        

        $this->load->model("Paciente_model");
        $lista = $this->Paciente_model->buscar();
    
        $dados = array('eventos' => $lista);



        $this->load->view('estrutura/cabPage',$dt);
        $this->load->view('corpo/prontuario',$dados);
        $this->load->view('estrutura/rodapePage');
        } else {
            echo "Acesso não permitido";
        }
            
    }

    public function resumoMedico(){
        $this->load->model("pessoa_model");
        $dt['tipo'] = $this->pessoa_model->getTipo();
        $dt2 = $this->pessoa_model->getTipo();
        if ($dt2['tipo'] == 1) {

        

        $this->load->model("Paciente_model");
        $lista = $this->Paciente_model->buscar();
    
        $dados = array('eventos' => $lista);



        $this->load->view('estrutura/cabPage',$dt);
        $this->load->view('corpo/index_corpo',$dados);
        $this->load->view('estrutura/rodapePage');
        } else {
            echo "Acesso não permitido";
        }
            
    }

    public function salvar(){
        
        $this->load->model('Prontuario_model');
        $dados = array (
            'id' => $this->input->post('id'),
            'prontuario' => base64_encode($this->input->post('prontuario'))
        );

        $r = $this->Prontuario_model->insertProtuario($dados['id'],$dados['prontuario']);
        echo json_encode($r);

    }

    public function getProtuario(){
        $id = $this->uri->segment(2);
        $this->load->model('Prontuario_model');
        $this->load->model('Paciente_model');
        $dados['prontuario'] = $this->Prontuario_model->getProntuario($id);
        $dados['paciente']  = $this->Paciente_model->Paciente_model->get($id);
        $dados['relatorio'] = true;
       $this->load->view('corpo/paciente', $dados);
    }

    public function gerarRelatorio(){
        $id = $this->uri->segment(2);
        $this->load->model('Prontuario_model');
        $this->load->model('Paciente_model');
        $dados['relatorio'] = false;
        $dados['prontuario'] = $this->Prontuario_model->getProntuario($id);
        $dados['paciente']  = $this->Paciente_model->get($id);
      
        $mpdf = new \Mpdf\Mpdf();

        
        $mpdf->WriteHTML($this->load->view('corpo/paciente', $dados, TRUE));
        
        
        $mpdf->Output();
    }

    
    private function verificarLogin(){
        if(empty($this->session->admin)){
            redirect('login');
        }
    }

}