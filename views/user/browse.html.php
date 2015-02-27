
<div id="work-panel" class="panel">
	<div class="panel-heading">系统->用户</div>
	<div class="panel-body">

		<table class="table datatable">
			<thead>
				<tr>
					<th>姓名</th>
					<th>邮箱</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($users as $user):?>
				<tr>
					<th><?php echo $user->name?></th>
					<th><?php echo $user->email?></th>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>

	</div>
</div>
<script>
	$('table.datatable').datatable({
		sortable: true
	});
</script>
