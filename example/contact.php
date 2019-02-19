<?
require_once 'clear.php';
require BASEDIR.'/contact.phc';
require BASEDIR.'/header.pht';
require BASEDIR.'/nav.pht';
?>

<div class="container mt-4">
	<h1>Contact Us</h1>

	<div class="row">
		<div class="col-md-6 mt-4">
			<address>
				<strong>Phone</strong><br>
				<a href="tel:1234567890">(123) 456-7890</a>
			</address>
			<address>
				<strong>Email</strong><br>
				<a href="mailto:email@example.com">Web Admin</a>
			</address>
			<address>
				<strong>Address</strong><br>
				123 N 456 S<br>
				Schenectady New York, 12345<br>
				<a href="http://maps.google.com" target="_blank">
					Directions
				</a>
			</address>
			<p>If you would like to set up an appointment or for more information, please send us a simple request and one of our customer service specialists will contact you as soon as possible.</p>
		</div>
		<div class="col-md-6 text-right">
		</div>
	</div>
	<form method="POST" class="mt-4 <?= !empty($missing) ? 'needs-validation' : '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text"
				name="name"
				value="<?= $name ?>"
				id="name"
				class="form-control form-control-lg"
				placeholder="Name"
			>
			<? if (isset($missing['name'])): ?>
				<div class="invalid-feedback">Please add your name</div>
			<? endif ?>
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email"
				name="email"
				value="<?= $email ?>"
				id="email"
				class="form-control form-control-lg"
				placeholder="Email"
			>
			<? if (isset($missing['email'])): ?>
				<div class="invalid-feedback">Please add your email</div>
			<? endif ?>
		</div>
		<div class="form-group">
			<label for="comment">Comment</label>
			<textarea name="comment"
				id="comment"
				class="form-control form-control-lg"
				placeholder="Comment"
				rows="10"
			><?= $comment ?></textarea>
			<? if (isset($missing['comment'])): ?>
				<div class="invalid-feedback">Please add your comment</div>
			<? endif ?>
		</div>
		<button type="submit" class="btn btn-lg btn-outline-primary">
			Submit
		</button>
	</form>
</div>

<? require BASEDIR.'/footer.pht' ?>
<? require BASEDIR.'/close.pht' ?>
