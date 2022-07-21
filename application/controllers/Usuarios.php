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
			$this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[1]|max_length[20]');
			$this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[1]|max_length[20]');
			$this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[1]|max_length[20]|is_unique[users.username]');
			$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[8]');
			$this->form_validation->set_rules('confirmacao', 'Confirmação', 'trim|required|matches[password]');

			if ($this->form_validation->run()) {
				$username = html_escape($this->input->post('username'));
				$password = html_escape($this->input->post('password'));
				$email = html_escape($this->input->post('email'));
				$additional_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'active' => $this->input->post('active')
				);
				$additional_data = html_escape($additional_data);
				$group = array($this->input->post('perfil'));

				if ($this->ion_auth->register($username, $password, $email, $additional_data, $group)) {
					$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
				} else {
					$this->session->set_flashdata('erro', 'Não foi possível salvar os dados ');
				}
				redirect($this->router->fetch_class());
			} else {
				$data = array(
					'titulo' => 'Cadastrar Usuário',
					'sub_titulo' => 'Cadastrando usuário',
					'icone_view' => 'ik ik-users',
				);


				$this->load->view('layout/header', $data);
				$this->load->view('usuarios/core');
				$this->load->view('layout/footer');
			}
		} else {
			if (!$this->ion_auth->user($usuario_id)->row()) {
			} else {
				$perfil_atual = $this->ion_auth->get_users_groups($usuario_id)->row();

				$this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[1]|max_length[20]');
				$this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[1]|max_length[20]');
				$this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[1]|max_length[20]|callback_username_check');
				$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|callback_email_check');
				$this->form_validation->set_rules('password', 'Senha', 'trim|min_length[8]');
				$this->form_validation->set_rules('confirmacao', 'Confirmação', 'trim|matches[password]');


				if ($this->form_validation->run()) {
					$data = elements(array('first_name', 'last_name', 'user_name', 'email', 'password', 'active'), $this->input->post());
					$password = $this->input->post('password');

					if (!$password) {
						unset($data['password']);
					}

					$data = html_escape($data);

					if ($this->ion_auth->update($usuario_id, $data)) {

						$perfil_post = $this->input->post('perfil');

						if ($perfil_atual != $perfil_post) {
							$this->ion_auth->remove_from_group($perfil_atual->id, $usuario_id);
							$this->ion_auth->add_to_group($perfil_post, $usuario_id);
						}

						$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
					} else {
						$this->session->set_flashdata('erro', 'Não foi possível salvar os dados ');
					}

					redirect($this->router->fetch_class());
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

	public function del($usuario_id = NULL)
	{
		if (!$usuario_id || !$this->core_model->get_by_id('users', array('id' => $usuario_id))) {
			$this->session->set_flashdata('erro', 'Usuário não encontrado');
		} else if ($this->ion_auth->is_admin($usuario_id)) {
			$this->session->set_flashdata('erro', 'Não é permitido excluir usuário administrador');
		} else if ($this->ion_auth->delete_user($usuario_id)) {
			$this->session->set_flashdata('sucesso', 'Registro excluido com sucesso');
		} else {
			$this->session->set_flashdata('erro', 'Erro ao excluir o registro');
		}
		redirect($this->router->fetch_class());
	}

	public function username_check($str)
	{
		$usuario_id = $this->input->post('usuario_id');

		if ($this->core_model->get_by_id('users', array('username' => $str, 'id !=' => $usuario_id))) {
			$this->form_validation->set_message('username_check', 'O {field} já existe');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function email_check($str)
	{
		$usuario_id = $this->input->post('usuario_id');

		if ($this->core_model->get_by_id('users', array('username' => $str, 'id !=' => $usuario_id))) {
			$this->form_validation->set_message('email_check', 'O {field} já existe');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}
