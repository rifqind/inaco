
<?php 
	include "header.php";
?>

	<main id="main">

	<section id="catalog-detail" class="catalog-dewasa mt-5 pb-4">
		<div class="container" data-aos="fade-up">
			<div class="row">
				<div class="col-12 mb-4">
					<a href="#" class="backlink"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
				</div>
				<div class="col-md-7">
					<div id="image-detail" class="image-catalog-detail mb-4 mb-sm-0">
						<img src="assets/images/catalog/catalog-detail.png">
					</div>
				</div>
				<div class="col-md-5">
					<h1 class="title-catalog">Vanilla</h1>
					<h2 class="subtitle-catalog">Nata De Coco Bag</h2>
					<div class="detail-catalog">
						<p>INACO Nata de Coco is a food made from 100% real coconut milk. Where the textrure is crispier compare to other Nata De Coco which is processed from coconut water</p>
						<ul>
							<li>Content : 12 Bags per ctn @ Netto 1 kg</li>
							<li>Carton size : 433 x 363 x 122 mm</li>
							<li>Flavor : Vanilla</li>
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
					<div class="d-flex align-items-center justify-content-between mb-4 pb-4">
						<h2>Produk Nata De Coco Lainnya</h2>
						<a href="" class="btn btn-primary more d-none d-sm-block">Lihat Lainnya</a>
					</div>
					<div class="catalog-list row">
						<div class="col-12 col-md-3">
							<div class="catalog-thumbnail">
								<a href="#">
									<div class="image-catalog"><img src="assets/images/catalog/nata-stroberi.png"></div>
									<div class="content-catalog">
										<div class="title-catalog"><h4>Nata De Coco Bag Strawberry with Basil Seeds</h4></div>
									</div>
								</a>
								<a href="catalog-detail.php" class="btn btn-primary btn-dewasa btn-more">Lihat Produk</a>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="catalog-thumbnail">
								<a href="#">
									<div class="image-catalog"><img src="assets/images/catalog/nata-selasih.png"></div>
									<div class="content-catalog">
										<div class="title-catalog"><h4>Nata De Coco Bag Orange with Basil Seeds</h4></div>
									</div>
								</a>
								<a href="catalog-detail.php" class="btn btn-primary btn-dewasa btn-more">Lihat Produk</a>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="catalog-thumbnail">
								<a href="#">
									<div class="image-catalog"><img src="assets/images/catalog/nata-bucket.png"></div>
									<div class="content-catalog">
										<div class="title-catalog"><h4>Nata De Coco Bucket Big Cut</h4></div>
									</div>
								</a>
								<a href="catalog-detail.php" class="btn btn-primary btn-dewasa btn-more">Lihat Produk</a>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="catalog-thumbnail">
								<a href="#">
									<div class="image-catalog"><img src="assets/images/catalog/nata-bucket-small.png"></div>
									<div class="content-catalog">
										<div class="title-catalog"><h4>Nata De Coco Bucket Small Cut</h4></div>
									</div>
								</a>
								<a href="catalog-detail.php" class="btn btn-primary btn-dewasa btn-more">Lihat Produk</a>
							</div>
						</div>
					</div>
					<div class="text-center">
					<a href="" class="btn btn-primary more d-sm-none">Lihat Lainnya</a>
				</div>
				</div>
			</div>
		</div>
	</section>

	<?php echo $cta_footer_dewasa; ?>
		
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