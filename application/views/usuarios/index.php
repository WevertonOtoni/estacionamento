<?php $this->load->view("layout/navbar"); ?>

<div class="page-wrap">

	<?php $this->load->view("layout/sidebar"); ?>

	<div class="main-content">
		<div class="container-fluid">
			<div class="page-header">
				<div class="row align-items-end">
					<div class="col-lg-8">
						<div class="page-header-title">
							<i class="ik ik-users bg-blue"></i>
							<div class="d-inline">
								<h5><?php echo $titulo; ?></h5>
								<span><?php echo $sub_titulo; ?></span>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<nav class="breadcrumb-container" aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item">
									<a data-toggle="tooltip" data-placement="bottom" title="Home" href="<?php echo base_url('/') ?>"><i class="ik ik-home"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page"><?php echo $titulo; ?></li>
							</ol>
						</nav>
					</div>
				</div>
			</div>

			<?php if ($message = $this->session->flashdata('sucesso')) : ?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<strong><?php echo $message ?></strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<i class="ik ik-x"></i>
							</button>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($message = $this->session->flashdata('erro')) : ?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong><?php echo $message ?></strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<i class="ik ik-x"></i>
							</button>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<a data-toggle="tooltip" data-placement="bottom" title="Cadastrar <?php echo $this->router->fetch_class() ?>" href="
							    <?php echo base_url($this->router->fetch_class() . '/core/'); ?>" class="btn btn-success">Novo</a>
							</a>
						</div>
						<div class="card-body">
							<table class="table data-table">
								<thead>
									<tr>
										<th>Id</th>
										<th>Usuário</th>
										<th>E-mail</th>
										<th>Nome</th>
										<th>Perfil de acesso</th>
										<th>Ativo</th>
										<th class="nosort text-right">Ações</th>
										<th class="nosort">&nbsp;</th>
										<th class="nosort">&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($usuarios as $usuario) : ?>
										<tr>
											<td><?php echo $usuario->id; ?></td>
											<td><?php echo $usuario->username; ?></td>
											<td><?php echo $usuario->email; ?></td>
											<td><?php echo $usuario->first_name; ?></td>
											<td><?php echo ($this->ion_auth->is_admin($usuario->id)) ?
													'Administrador' : 'Atendente' ?></td>
											<td><?php echo ($usuario->active == 1 ?
													'<span class="badge badge-pill badge-success mb-1"><i class="fa fa-lock-open"></i>&nbsp;Sim</span>' :
													'<span class="badge badge-pill badge-danger mb-1"><i class="fa fa-lock-open"></i>&nbsp;Não</span>'); ?>
											</td>
											<td class="text-right">
												<div class="table-actions">
													<a data-toggle="tooltip" data-placement="bottom" title="Editar 
													<?php echo $this->router->fetch_class() ?>" href="
													<?php echo base_url($this->router->fetch_class() . '/core/' . $usuario->id) ?>" class="btn btn-icon btn-primary">
														<i class="ik ik-edit-2"></i>
													</a>
													<button type="button" class="btn btn-icon btn-danger" data-toggle="modal" title="Excluir <?php echo $this->router->fetch_class() ?>" data-target="#user-<?php echo $usuario->id; ?>">
														<i class="ik ik-trash-2"></i>
													</button>
												</div>
											</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
										<div class="modal fade" id="user-<?php echo $usuario->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalCenterLabel"><i class="fas fa-exclamation-triangle text-warning"></i>&nbsp;Exclusão do registro</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													</div>
													<div class="modal-body">
														<p>Deseja realmente excluir o registro?</p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
														<a class="btn btn-primary" href="<?php echo base_url($this->router->fetch_class() . '/del/' . $usuario->id) ?>">
															Sim
														</a>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<footer class="footer">
		<div class="w-100 clearfix">
			<span class="text-center text-sm-left d-md-inline-block">Copyright © <?php echo date("Y") ?> ThemeKit v2.0. All Rights Reserved.</span>
			<span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Custumizado <i class="fa fa-code text-dark"></i> by <a href="javascript:void" class="text-dark">Weverton</a></span>
		</div>
	</footer>

</div>
