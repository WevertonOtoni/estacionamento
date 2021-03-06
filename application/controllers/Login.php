<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function index()
	{
		$data = array(
			'titulo' => 'Login'
		);

		$this->load->view('layout/header', $data);
		$this->load->view('login/index');
		$this->load->view('layout/footer');
	}

	public function auth()
	{
		$identity = html_escape($this->input->post('email'));
		$password = html_escape($this->input->post('password'));
		$remember = FALSE;

		if ($this->ion_auth->login($identity, $password, $remember)) {
			redirect('/');
		} else {
			$this->session->set_flashdata('erro', 'E-mail ou senha inválido.');
			redirect($this->router->fetch_class());
		}
	}

	public function logout()
	{
		$this->ion_auth->logout();
		redirect($this->router->fetch_class());
	}
}
