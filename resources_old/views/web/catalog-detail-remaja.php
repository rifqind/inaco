
<?php 
	include "header.php";
?>

	<main id="main">

	<section id="catalog-detail" class="catalog-remaja-detail mt-5 pb-4">
		<div class="container" data-aos="fade-up">
			<div class="row">
				<div class="col-12 mb-4">
					<a href="#" class="backlink"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
				</div>
				<div class="col-md-7">
					<div id="image-detail" class="image-catalog-detail mb-4 mb-sm-0">
						<img src="assets/images/catalog/catalog-detail-remaja.png">
					</div>
				</div>
				<div class="col-md-5">
					<h1 class="title-catalog">Mango</h1>
					<h2 class="subtitle-catalog">Im Coco</h2>
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
					<div class="d-flex align-items-center justify-content-between mb-4 pb-4">
						<h2>Produk Jelly Lainnya</h2>
						<a href="" class="btn btn-primary more d-none d-sm-block">Lihat Lainnya</a>
					</div>
					<div class="catalog-list row">
						<div class="col-12 col-md-3">
							<div class="catalog-thumbnail">
								<a href="#">
									<div class="image-catalog"><img src="assets/images/catalog/minijelly-15s.png"></div>
									<div class="content-catalog">
										<div class="title-catalog"><h4>Mini Jelly 15s</h4></div>
									</div>
								</a>
								<a href="catalog-detail-remaja.php" class="btn btn-primary btn-remaja btn-more">Lihat Produk</a>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="catalog-thumbnail">
								<a href="#">
									<div class="image-catalog"><img src="assets/images/catalog/minijelly-25s.png"></div>
									<div class="content-catalog">
										<div class="title-catalog"><h4>Mini Jelly 25s</h4></div>
									</div>
								</a>
								<a href="catalog-detail-remaja.php" class="btn btn-primary btn-remaja btn-more">Lihat Produk</a>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="catalog-thumbnail">
								<a href="#">
									<div class="image-catalog"><img src="assets/images/catalog/minijelly-40.png"></div>
									<div class="content-catalog">
										<div class="title-catalog"><h4>Mini Jelly 40</h4></div>
									</div>
								</a>
								<a href="catalog-detail-remaja.php" class="btn btn-primary btn-remaja btn-more">Lihat Produk</a>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="catalog-thumbnail">
								<a href="#">
									<div class="image-catalog"><img src="assets/images/catalog/konnyaku-jelly.png"></div>
									<div class="content-catalog">
										<div class="title-catalog"><h4>Konnyaku Jelly</h4></div>
									</div>
								</a>
								<a href="catalog-detail-remaja.php" class="btn btn-primary btn-remaja btn-more">Lihat Produk</a>
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

	<?php echo $cta_footer_remaja; ?>
		
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