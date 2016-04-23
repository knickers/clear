<?php require_once '../../clear.php' ?>
<?php Clear::template('_header') ?>

<h1>TODO Items</h1>

<form action="<?= RELURL ?>/create.php" method="POST" class="row">
	<div class="col-sm-6">
		<input type="text" name="name" class="form-control" placeholder="Name"/>
		<br>
		<input type="text" name="date" class="form-control" placeholder="Due Date" onfocus="this.type = 'datetimeLocal'" onblur="this.type = 'text'"/>
		<br>
	</div>
	<div class="col-sm-6">
		<textarea name="notes" class="form-control" placeholder="Notes" style="height: 88px;"></textarea>
		<br>
	</div>
	<div class="col-sm-12 text-right">
		<button type="submit" class="btn btn-default">Add</button>
	</div>
</form>

<table class="table">
	<thead>
		<tr>
			<th>Due</th>
			<th>Name</th>
			<th>Notes</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php if (!count($todos)): ?>
			<tr>
				<td colspan="4" class="text-center">Everything is done!</td>
			</tr>
		<?php endif ?>
		<?php foreach ($todos as $i => $todo): ?>
			<form action="<?= RELURL ?>/update.php" method="POST">
				<input type="hidden" name="id" value="<?= $todo->id ?>"/>
				<tr>
					<td class="toggle-view" style="width: 20%;">
						<?= $todo->date ?>
					</td>
					<td class="toggle-view" style="width: 30%;">
						<?= $todo->name ?>
					</td>
					<td class="toggle-view" style="width: 40%;">
						<?= $todo->notes ?>
					</td>
					<td class="toggle-view text-right" style="width: 10%;">
						<a href="#" title="Edit" class="toggle-edit-btn">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>
						&nbsp;
						<a href="<?= RELURL ?>/done.php?id=<?= $todo->id ?>" title="Mark as Complete">
							<span class="glyphicon glyphicon-ok"></span>
						</a>
						&nbsp;
						<a href="<?= RELURL ?>/delete.php?id=<?= $todo->id ?>" title="Delete">
							<span class="glyphicon glyphicon-trash"></span>
						</a>
					</td>
					<td class="toggle-edit hide">
						<input type="datetime-local" name="date" value="<?= str_replace(' ', 'T', $todo->date) ?>" class="form-control"/>
					</td>
					<td class="toggle-edit hide">
						<input type="text" name="name" value="<?= $todo->name ?>" class="form-control" placeholder="Name"/>
					</td>
					<td class="toggle-edit hide">
						<textarea name="notes" class="form-control" placeholder="Notes" style="height: 88px;"><?= $todo->notes ?></textarea>
					</td>
					<td class="toggle-edit hide text-right">
						<button type="submit" class="btn btn-block btn-default">
							Update
						</button>
						<div class="btn btn-block btn-default toggle-view-btn">
							Cancel
						</div>
					</td>
				</tr>
			</form>
		<?php endforeach ?>
		<tr><td colspan="4">&nbsp;</td></tr>
	</tbody>
	<thead>
		<tr>
			<th>Done</th>
			<th>Name</th>
			<th>Notes</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php if (!count($done)): ?>
			<tr>
				<td colspan="4" class="text-center">Nothing yet complete</td>
			</tr>
		<?php endif ?>
		<?php foreach ($done as $i => $todo): ?>
			<tr>
				<td><?= $todo->date ?></td>
				<td><?= $todo->name ?></td>
				<td><?= $todo->notes ?></td>
				<td class="text-right">
					<a href="<?= RELURL ?>/undone.php?id=<?= $todo->id ?>" title="Mark as Incomplete">
						<span class="glyphicon glyphicon-arrow-up"></span>
					</a>
					<a href="<?= RELURL ?>/delete.php?id=<?= $todo->id ?>" title="Delete">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<script>
jQuery(function($) {
	$('.toggle-view-btn').on('click', function(e) {
		var parent = $(this).parents('tr');
		parent.find('.toggle-view').removeClass('hide');
		parent.find('.toggle-edit').addClass('hide');
		return false;
	});
	
	$('.toggle-edit-btn').on('click', function(e) {
		var parent = $(this).parents('tr');
		parent.find('.toggle-view').addClass('hide');
		parent.find('.toggle-edit').removeClass('hide');
		return false;
	});
});
</script>

<?php Clear::template('_footer') ?>
