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
	<div id="share-section">
		<a href=""><img src="assets/images/news/facebook.svg"></a>
		<a href=""><img src="assets/images/news/twitter.svg"></a>
		<a href=""><img src="assets/images/news/wa.svg"></a>
		<a href=""><img src="assets/images/news/telegram.svg"></a>
		<a href=""><img src="assets/images/news/pinterest.svg"></a>
		<a href=""><img src="assets/images/news/link.svg"></a>
	</div>
	<!-- ======= Detail Article ======= -->
	<section id="detail-article" class="detail-article">
	  <div class="container" data-aos="fade-up">
		  <div class="row justify-content-center" >
			  <div class="col-md-8" >			  
				<!-- ======= Breadcrumbs ======= -->
				<div id="breadcrumbs" class="breadcrumbs">
					<ol>
					  <li><a href="index.php">Home</a></li>
					  <li><a href="article.php">Artikel</a></li>
					  <li>Transformasi Digital Green Industry, INACO dan Schneider Electric Jalin Kerja Sama</li>
					</ol>
				</div><!-- End Breadcrumbs -->	
				<h1 class="title-detail-article">Transformasi Digital Green Industry, INACO dan Schneider Electric Jalin Kerja Sama</h1>
				<div class="info-article">Februari 24, 2023 · 7 mins read · by <a href="#">Fajar Hermawan</a></div>
				<div class="detail-image-article">
				  <img src="assets/images/detail-article.jpg">
				</div>
				<div class="detail-content-article">
					<p>Kementerian Perindustrian (Kemenperin) memiliki target untuk dapat mencapai net zero emission (NZE) di sektor industri 10 tahun lebih cepat dari target nasional. Ada empat strategi yang akan menjadi pondasi transformasi digital tersebut, yaitu transisi ke energi baru terbarukan, manajemen dan efisiensi energi, strategi elektrifikasi dalam proses produksi, serta pemanfaatan teknologi carbon capture, utilization, and storage (CCUS). Industri makanan dan minuman merupakan salah satu industri yang diharapkan berperan aktif dalam mencapai net zero emission. Salah satu perusahaan yang bergerak di industri makanan dan minuman, PT Niramas Utama (INACO) pun mendukung upaya yang dilakukan Kemenperin dengan meresmikan perjalanan tranformasi digital perusahaan menuju green industry.</p>
					<p>Langkah strategis yang dilakukan INACO tersebut sekaligus meresmikan sistem manajemen informasi produksi dan monitoring energi di Pabrik Pusat PT Niramas Utama di Bekasi dengan nama “Go Live”, Rabu (31/1/2024).</p>
					<h3>Meningkatkan produktivitas dan efisiensi</h3>
					<p>Berdiri sejak 1990, INACO merupakan salah satu pionir dalam produksi makanan dan minuman penutup (dessert). Adapun pabrik pusat INACO di Bekasi memproduksi berbagai produk, mulai dari jelly, minuman ready to drink (RTD), nata de coco, dan puding. Pabrik INACO berdiri di atas lahan seluas 2,5 hektare dan dilengkapi berbagai fasilitas, mulai dari fasilitas penelitian dan pengembangan terintegrasi, pergudangan, perkantoran, administrasi, fasilitas kunjungan pabrik, hingga demo aplikasi produk. BOD INACO Adhi Lukman mengatakan, pabrik di Bekasi menjadi proyek pertama digitalisasi sistem manajemen informasi produksi dan monitoring energi.</p>
					<p>"Tujuan utamanya untuk meningkatkan produktivitas dan efisiensi, optimalisasi proses bisnis, pengembangan kompetensi sumber daya manusia (SDM), dan pemenuhan tanggung jawab perusahaan terhadap penghematan energi serta pengurangan emisi karbon,” ujar Adhi. Dirjen Industri Agro Kemenperin Putu Juli Ardika pun menyambut baik upaya yang dilakukan INACO. Putu mengatakan bahwa INACO menjadi contoh bagi industri lainnya dalam implementasi industri 4.0 dan green industry. “Kami berharap akan tumbuh lebih banyak lagi inisiatif-inisiatif seperti ini, agar daya saing sektor industri dalam negeri semakin meningkat di dunia internasional,” kata Putu.</p>
				</div>
			  </div>
		  </div>
	  </div>
	</section>
	
	
	<!-- ======= Article ======= -->
	<section id="article" class="article pt-0 mb-5">
		<div class="container" data-aos="fade-up">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<h2 class="article-title"><span>Artikel Terbaru</span></h2>
					<div class="row">
						<div class="col-md-6">
							<div class="thumbnail-article">
								<div class="image-thumbnail"><img src="assets/images/news/article-image.jpg"></div>
								<div class="content-thumbnail">
									<div class="title-thumbnail"><h4><a href="article-detail.php">Transformasi Digital Green Industry, INACO dan Schneider Electric Jalin Kerja Sama</a></h4></div>
									<div class="caption-thumbnail">
										<p>Kementerian Perindustrian (Kemenperin) memiliki target untuk dapat mencapai net zero emission (NZE) di sektor industri 10 tahun</p>
									</div>
									<div class="update-article">04 Feb 2024</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="thumbnail-article">
								<div class="image-thumbnail"><img src="assets/images/news/article-image.jpg"></div>
								<div class="content-thumbnail">
									<div class="title-thumbnail"><h4><a href="article-detail.php">Transformasi Digital Green Industry, INACO dan Schneider Electric Jalin Kerja Sama</a></h4></div>
									<div class="caption-thumbnail">
										<p>Kementerian Perindustrian (Kemenperin) memiliki target untuk dapat mencapai net zero emission (NZE) di sektor industri 10 tahun</p>
									</div>
									<div class="update-article">04 Feb 2024</div>
								</div>
							</div>
						</div>
						
						<div class="col-12 text-center">
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