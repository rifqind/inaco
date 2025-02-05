<?php
	include "header.php";
?>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var header = document.getElementById('header');
		header.classList.add('header-active');
	});
</script>

	<main id="main">
	<!-- ======= Detail Resep ======= -->
	<section id="detail-recipe" class="detail-recipe">
	  <div class="container" data-aos="fade-up">
		  <div class="row justify-content-center" >
		  
			  <div class="col-12 mt-5 mb-4">
				<a href="#"class="backlink"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
			  </div>
			  <div class="col-md-8" >
				<div id="sync1" class="owl-carousel owl-theme">
					<div class="item">
						<a class="image-event" href="#"><img src="assets/images/recipe/large-view.jpg"></a>
					</div>
					<div class="item">
						<a class="image-event" href="#"><img src="assets/images/recipe/large-view.jpg"></a>
					</div>
					<div class="item">
						<a class="image-event" href="#"><img src="assets/images/recipe/large-view.jpg"></a>
					</div>
				</div>

				<div id="sync2" class="owl-carousel owl-theme">
					<div class="item">
						<a class="image-event"><img src="assets/images/recipe/small-view.jpg"></a>
					</div>
					<div class="item">
						<a class="image-event"><img src="assets/images/recipe/small-view.jpg"></a>
					</div>
					<div class="item">
						<a class="image-event"><img src="assets/images/recipe/small-view.jpg"></a>
					</div>
				</div>			 
				
				<h1 class="title-detail-recipe">Pai Pudding Coklat Inaco</h1>
				<div class="info-recipe">Februari 24, 2023</div>
				<hr/>
				<div class="detail-content-recipe">
					<h4>Ingredients</h4>
					<p class="mb-1">Bahan Kulit:</p>
					<ul>
					<li>450 gr tepung terigu protein sedang</li>
					<li>100 gr gula bubuk</li>
					<li>200 gr margarin</li>
					<li>3 kuning telur</li>
					<li>1 putih telur</li>
					</ul>

					<p class="mb-1">Bahan Isi:</p>
					<ul>
					<li>1 bungkus Pudding Cokelat INACO</li>
					<li>500 ml susu cair</li>
					<li>100 gr gula pasir</li>
					</ul>

					<p class="mb-1">Bahan Hiasan:</p>
					<ul>
					<li>Potongan buah stroberi, kiwi, jeruk mandarin</li>
					<li>Krim kocok</li>
					<li>Kolang Kaling INACO</li>
					</ul>
					
					<hr/>
					
					<h4>Cara Memasak</h4>
					<p class="mb-1">Kulit</p>
					<ol>
						<li>Kocok margarin dan gula hingga lembut, tambahkan tepung terigu dan aduk hingga rata, tambahkan telur sambil aduk rata, lalu simpan di kulkas selama 30 menit.</li>
						<li>Gilas tipis adonan, cetak bentuk bulat berdiameter sekitar 10 cm. Masukkan ke loyang pai berdiameter sekitar 8 cm, tusuk dasarnya dengan garpu. Panggang di suhu 180 derajat celcius selama 20 menit hingga kuning keemasan, angkat & dinginkan.</li>
					</ol>
					
					<p class="mb-1">Isi Pai</p>
					<ol>
						<li>Masak Puding Cokelat INACO sesuai resep, lalu larutkan dengan 500 ml susu cair dan 100 gr gula pasir.</li>
						<li>Masak dengan api kecil hingga mengental, lalu isikan ke tiap kulit pai yang telah matang</li>
						<li>Hiasi dengan buah-buahan, Kolang Kaling INACO, dan krim kocok.</li>
					</ol>
					<a href="" class="btn btn-primary more btn-fill mt-4">Print Resep</a>
				</div>
			  </div>
		  </div>
	  </div>
	</section>
	
	
	<!-- ======= Recipe ======= -->
	<section id="recipe" class="recipe pt-5 mt-3 mb-0">
		<div class="container" data-aos="fade-up">
			<div class="row justify-content-center">
				<div class="col-md-12">
					<div class="d-flex justify-content-between align-items-center mb-4">
						<h2 class="recipe-title mb-0"><span>Resep Lainnya</span></h2>
						<a href="#" class="btn btn-primary more d-none d-md-block">Lihat Lainnya</a>
					</div>
					<div class="recipe-list row">
						<div class="col-12 col-md-3">
							<div class="recipe-thumbnail">
								<div class="recipe-image">
									<img src="assets/images/recipe/resep1.jpg">
								</div>
								<div class="recipe-content">
									<div class="recipe-title"><h4>Pai Pudding Coklat Inaco</h4></div>
									<div class="recipe-summamry"><p>Pai Pudding Coklat Inaco adalah kudapan kekinian yang memadukan tekstur kenyal jelly Inaco dengan sensasi manis dan segar dari berbagai rasa buah. Kue ini hadir dalam berbagai varian rasa, seperti anggur, stroberi, jeruk, dan mangga, yang dikemas dalam kemasan plastik praktis dan menarik.</p></div>
									<a href="recipe-detail.php" class="btn btn-primary w-100 more filled-button">Lihat Resep</a>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="recipe-thumbnail">
								<div class="recipe-image">
									<img src="assets/images/recipe/resep2.jpg">
								</div>
								<div class="recipe-content">
									<div class="recipe-title"><h4>Buko Red Velvet</h4></div>
									<div class="recipe-summamry"><p>Salad Inaco adalah hidangan segar dan praktis yang terbuat dari potongan buah-buahan segar seperti apel, anggur, semangka, melon, kiwi, dan pear yang dicampur dengan nata de coco Inaco dan yogurt</p></div>
									<a href="recipe-detail.php" class="btn btn-primary w-100 more filled-button">Lihat Resep</a>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="recipe-thumbnail">
								<div class="recipe-image">
									<img src="assets/images/recipe/resep3.jpg">
								</div>
								<div class="recipe-content">
									<div class="recipe-title"><h4>Cocktail Mevvah</h4></div>
									<div class="recipe-summamry"><p>Kue Jelly Viral Inaco adalah kudapan kekinian yang memadukan tekstur kenyal jelly Inaco dengan sensasi manis dan segar dari berbagai rasa buah. Kue ini hadir dalam berbagai varian rasa, seperti anggur, stroberi, jeruk, dan mangga, yang dikemas dalam kemasan plastik praktis dan menarik.</p></div>
									<a href="recipe-detail.php" class="btn btn-primary w-100 more filled-button">Lihat Resep</a>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="recipe-thumbnail">
								<div class="recipe-image">
									<img src="assets/images/recipe/resep4.jpg">
								</div>
								<div class="recipe-content">
									<div class="recipe-title"><h4>Dessert Box</h4></div>
									<div class="recipe-summamry"><p>Japanese Custard Inaco adalah hidangan penutup yang menghadirkan sensasi manis dan lembut ala puding Jepang. Dibuat dengan bahan-bahan berkualitas seperti susu segar, telur, dan gula, Japanese Custard Inaco memiliki tekstur yang creamy dan rasa manis yang pas.</p></div>
									<a href="recipe-detail.php" class="btn btn-primary w-100 more filled-button">Lihat Resep</a>
								</div>
							</div>
						</div>
						<div class="col-12 text-center d-md-none">
							<a href="#" class="btn btn-primary more">Lihat Lainnya</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php echo $cta_footer; ?>

	</main><!-- End #main -->

<?php
	include "footer.php";
?>