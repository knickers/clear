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
				<td><?= $todo->date ?></td>
				<td><?= $todo->name ?></td>
				<td><?= $todo->notes ?></td>
				<td class="text-right">
					<a href="<?= RELURL ?>/done.php?id=<?= $todo->id ?>" title="Mark as Complete">
						<span class="glyphicon glyphicon-ok"></span>
					</a>
					&nbsp;
					<a href="<?= RELURL ?>/delete.php?id=<?= $todo->id ?>" title="Delete">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<br>

<table class="table">
	<thead>
		<tr>
			<th>Done</th>
			<th>Name</th>
			<th>Notes</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($done as $i => $todo): ?>
			<tr>
				<td><?= $todo->date ?></td>
				<td><?= $todo->name ?></td>
				<td><?= $todo->notes ?></td>
				<td class="text-right">
					<a href="<?= RELURL ?>/undone.php?id=<?= $todo->id ?>" title="Mark as Incomplete">
						<span class="glyphicon glyphicon-remove"></span>
					</a>
					<a href="<?= RELURL ?>/delete.php?id=<?= $todo->id ?>" title="Delete">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<?php Clear::template('example/todo/_footer') ?>
