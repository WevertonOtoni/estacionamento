<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends CI_Controller
{

	public function index()
	{
		$data = array(
			'titulo' => 'Usuários Cadastrados',
			'sub_titulo' => 'Listando todos os usuários cadastrados',
			'styles' => array('plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css'),
			'scripts' => array(
				'plugins/datatables.net/js/jquery.dataTables.min.js',
				'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'plugins/datatables.net/js/estacionamento.js'
			),
			'usuarios' => $this->ion_auth->users()->result()
		);

		$this->load->view('layout/header', $data);
		$this->load->view('usuarios/index');
		$this->load->view('layout/footer');
	}

	public function core($usuario_id = NULL)
	{
		if (!$usuario_id) {
		} else {
			if (!$this->ion_auth->user($usuario_id)->row()) {
			} else {
				$this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[1]|max_length[20]');
				$this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[1]|max_length[20]');
				$this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[1]|max_length[20]');
				$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
				$this->form_validation->set_rules('password', 'Senha', 'trim|min_length[8]');
				$this->form_validation->set_rules('confirmacao', 'Confirmação', 'trim|matches[password]');

				if ($this->form_validation->run()) {
				} else {
					$data = array(
						'titulo' => 'Editar Usuário',
						'sub_titulo' => 'Editando usuário',
						'icone_view' => 'ik ik-users',
						'usuario' => $this->ion_auth->user($usuario_id)->row(),
						'perfil_usuario' => $this->ion_auth->get_users_groups($usuario_id)->row()
					);


					$this->load->view('layout/header', $data);
					$this->load->view('usuarios/core');
					$this->load->view('layout/footer');
				}
			}
		}
	}
}
