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
		<textarea name="notes" rows="4" class="form-control" placeholder="Notes"></textarea>
	</div>
	<div class="col-sm-12 text-right">
		<br class="visible-xs">
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
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
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

<?php Clear::template('_footer') ?>
