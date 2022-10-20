<?
require_once 'clear.php';
require 'header.pht';
require 'nav.pht';
?>

<div class="container my-4">
	<div class="row">
		<div class="col-md-6">
			<div>Page: <code>contact.php</code></div>
			<? $codeFilename = 'contact.php'; require 'code-block.pht' ?>
		</div>
		<div class="col-md-6">
			<div>Controller: <code>contact.phc</code></div>
			<? $codeFilename = 'contact.phc'; require 'code-block.pht' ?>
		</div>
	</div>
	<?// $codeFilename = 'clear.php'; require 'code-block.pht' ?>
</div>

<?
require 'footer.pht';
require 'close.pht';
?>
