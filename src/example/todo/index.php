<?php require_once '../../clear.php' ?>
<?php Clear::template('example/todo/_header') ?>

<h1>TODO Items</h1>

<form action="<?= RELURL ?>/create.php" method="POST" class="row">
	<div class="col-sm-10">
		<input type="text" name="name" class="form-control"/>
	</div>
	<div class="col-sm-2">
		<button type="submit" class="btn btn-block btn-default">Add</button>
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
		<?php foreach ($todos as $i => $todo): ?>
			<tr>
				<td><?= $todo->due ?></td>
				<td><?= $todo->name ?></td>
				<td><?= $todo->notes ?></td>
				<td><a href="<?= RELURL ?>/done.php?id=<?= $todo->id ?>" title="Mark as Complete">✓</a></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<?php Clear::template('example/todo/_footer') ?>
