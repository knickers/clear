<?
require 'header.pht';
require 'nav.pht';
?>

<div id="product-carousel"
	class="carousel slide"
	data-ride="carousel"
>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img class="d-block w-100"
				src="/img/wide/bavarian_alps_mountains_lake_berchtesgaden_germany.jpg"
				alt="First slide"
			>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100"
				src="/img/wide/country_road_hill.jpg"
				alt="First slide"
			>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100"
				src="/img/wide/most_beautiful_waterscapes.jpg"
				alt="First slide"
			>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100"
				src="/img/wide/sun_shining_through_wilderness.jpg"
				alt="First slide"
			>
		</div>
	</div>
	<a class="carousel-control-prev"
		href="#product-carousel"
		role="button"
		data-slide="prev"
	>
		<span class="carousel-control-prev-icon" aria-hidden="true">
		</span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next"
		href="#product-carousel"
		role="button"
		data-slide="next"
	>
		<span class="carousel-control-next-icon" aria-hidden="true">
		</span>
		<span class="sr-only">Next</span>
	</a>
</div>

<div class="container my-4">
	<h1>Hello from index</h1>
</div>

<?
require 'footer.pht';
require 'close.pht';
?>
