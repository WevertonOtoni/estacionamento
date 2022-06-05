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
									<a title="Home" href="<?php echo base_url('/') ?>"><i class="ik ik-home"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page"><?php echo $titulo; ?></li>
							</ol>
						</nav>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<a href="#" class="btn btn-success">Novo</a>
						</div>
						<div class="card-body">
							<table class="table data-table">
								<thead>
									<tr>
										<th>Id</th>
										<th>Usuário</th>
										<th>E-mail</th>
										<th>Nome</th>
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
											<td><?php echo ($usuario->active == 1 ?
													'<span class="badge badge-pill badge-success mb-1">Sim</span>' :
													'<span class="badge badge-pill badge-danger mb-1">Não</span>'); ?>
											</td>
											<td class="text-right">
												<div class="table-actions">
													<a title="Editar" href="#" class="btn btn-icon btn-primary"><i class="ik ik-edit-2"></i></a>
													<a title="Excluir" href="#" class="btn btn-icon btn-danger"><i class="ik ik-trash-2"></i></a>
												</div>
											</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
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
