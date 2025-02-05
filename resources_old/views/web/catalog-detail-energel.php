
<?php 
	include "header.php";
?>

	<main id="main">

	<section id="catalog-detail" class="catalog-energel-detail mt-5 pb-4">
		<div class="container" data-aos="fade-up">
			<div class="row">
				<div class="col-12 mb-4">
					<a href="#" class="backlink"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
				</div>
				<div class="col-md-7">
					<div id="image-detail" class="image-catalog-detail mb-4 mb-sm-0">
						<img src="assets/images/catalog/catalog-detail-energel.png">
					</div>
				</div>
				<div class="col-md-5">
					<h1 class="title-catalog">ENER-GEL</h1>
					<div class="detail-catalog">
						<p>Im Coco is a Juice drinks (thick consistency), made with real sugar, Real Fruit Juice and to double the Benefit and Fun, filled with LOTS of small nata de coco cubes. Making INACO IM COCO, not only thirst Quenching but also tummy filling, to Cheer up the day! </p>
						<ul>
							<li>Content : 24 bottle per ctn @ Netto 350 ml</li>
							<li>Carton size : 375 x 244 x 180 mm</li>
							<li>Flavor : Mango</li>
						</ul>
					</div>
					<button type="button" class="btn btn-primary button-catalog more btn-fill" data-bs-toggle="modal" data-bs-target="#buyModal">
						Beli Sekarang
					</button>
				</div>
			</div>
		</div>
	</section>
	<section id="catalog-wrapper" class="catalog-wrapper pb-4">
		<div class="container" data-aos="fade-up">
			<div class="row justify-content-center">
				<div class="col-12">
					
				</div>
				</div>
			</div>
		</div>
	</section>

	<?php echo $cta_footer_energel; ?>
		
	<!-- Modal -->
	<div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Beli Sekarang</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="shop-images row">
					<div class="col-6">
						<a href="https://shopee.co.id"><img src="assets/images/shopee.png"></a>
					</div>
					<div class="col-6">
						<a href="https://tokopedia.com"><img src="assets/images/tokopedia.png"></a>
					</div>
					<div class="col-6">
						<a href="https://lazada.co.id"><img src="assets/images/lazada.png"></a>
					</div>
					<div class="col-6">
						<a href="https://tiktok.com"><img src="assets/images/tiktok.png"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
<?php 
	include "footer.php";
?>