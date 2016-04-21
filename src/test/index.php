<?php require_once '../clear.php' ?>
<?php Clear::template('_header') ?>

<h1>Choose a test to run:</h1>

<ul>
	<li><a href="/test/cut.php">Cut</a></li>
	<li><a href="/test/template.php">Clear::template</a></li>
</ul>

<h1>MySQL Debuging</h1>

<form action="" method="POST">
	<button <?= $debug ? '' : 'type="submit"' ?> type="submit" name="debug" value="on" class="<?= $debug ? 'active' : '' ?> btn btn-default">
		Enable
	</button>
	<button <?= $debug ? 'type="submit"' : '' ?> type="submit" name="debug" value="off" class="<?= $debug ? '' : 'active' ?> btn btn-default">
		Disable
	</button>
</form>

<?php Clear::template('_footer') ?>
