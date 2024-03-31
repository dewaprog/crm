<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<?php

?>
<div class="table-wrapper">
	<div class="table-title">
		<div class="row">
			<div class="col-sm-6">
				<h2><?= $title; ?></h2>
			</div>
			<div class="col-sm-6">
				<a href="#addCompany" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Company</span></a>
				<!-- <a href="#deleteCompany" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a> -->
			</div>
		</div>
	</div>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>
					<span class="custom-checkbox">
						<input type="checkbox" id="selectAll">
						<label for="selectAll"></label>
					</span>
				</th>
				<th>Company Name</th>
				<th>Created Date</th>
				<th>Updated Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (isset($company))
				foreach ($company as $r) { ?>
				<tr>
					<td>
						<span class="custom-checkbox">
							<input type="checkbox" id="checkbox1" name="options[]" value="1">
							<label for="checkbox1"></label>
						</span>
					</td>
					<td><?= $r['company_name'] ?></td>
					<td><?= $r['created_at'] ?></td>
					<td><?= $r['updated_at'] ?></td>
					<td>
						<a href="#editCompany" tag_name="<?= $r['company_name']; ?>" tag_id="<?= $r['company_id']; ?>" class="edit selEdit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
						<a href="#deleteCompany" tag_id="<?= $r['company_id']; ?>" class="delete selDelete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
					</td>
				</tr>

			<?php } ?>

		</tbody>
	</table>
	<div class="clearfix">
		<?= $pager->links(); ?>
	</div>
</div>

<!-- Add Modal HTML -->
<div id="addCompany" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name='company_add' method="post" action='/company/save'>
				<div class="modal-header">
					<h4 class="modal-title">Add <?= $title ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Company Name</label>
						<input name='company_name' type="text" class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Edit Modal HTML -->
<div id="editCompany" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method='post' action="/company/save">
				<div class="modal-header">
					<h4 class="modal-title">Edit <?= $title ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Company Name</label>
						<input type="text" id='company_name' name='company_name' class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type='hidden' id='company_id_edit' name='company_id' value=''>
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteCompany" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method='post' action="/company">
				<?= csrf_field(); ?>
				<div class="modal-header">
					<h4 class="modal-title">Delete <?= $title ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete these Records?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type='hidden' name='_method' value='delete'>
					<input type='hidden' id='company_id_delete' name='company_id' value=''>
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-danger" value="Delete">
				</div>
			</form>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		// Activate tooltip
		$('[data-toggle="tooltip"]').tooltip();

		$(".selDelete").click(function() {
			$("#company_id_delete").val($(this).attr('tag_id'));
		});

		$(".selEdit").click(function() {
			$("#company_id_edit").val($(this).attr('tag_id'));
			$("#company_name").val($(this).attr('tag_name'));
		});

		// Select/Deselect checkboxes
		var checkbox = $('table tbody input[type="checkbox"]');
		$("#selectAll").click(function() {
			if (this.checked) {
				checkbox.each(function() {
					this.checked = true;
				});
			} else {
				checkbox.each(function() {
					this.checked = false;
				});
			}
		});
		checkbox.click(function() {
			if (!this.checked) {
				$("#selectAll").prop("checked", false);
			}
		});
	});
</script>
<?= $this->endsection(); ?>