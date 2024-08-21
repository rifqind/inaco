 <!-- ======= Contact ======= -->
 <section id="contact" class="contact">
 	<div class="container" data-aos="fade-in">
 		<div class="row">
 			<div class="col-lg-12">
 				<div id="cta">
 					@switch($segment)
 					@case(1)
 					<img src="{{ asset('assets/web/images/maskot-dewasa.png') }}" class="maskot d-none d-sm-block">
 					@break
 					@case(2)
 					<img src="{{ asset('assets/web/images/maskot-remaja.png') }}" class="maskot d-none d-sm-block">
 					@break
 					@case(3)
 					<img src="{{ asset('assets/web/images/maskot-anak.png') }}" class="maskot d-none d-sm-block">
 					@break
 					@default
 					<img src="{{ asset('assets/web/images/maskot.png') }}" class="maskot d-none d-sm-block">
 					@endswitch
 					<img src="{{ asset('assets/web/images/maskot-mobile.png') }}" class="maskot-mobile d-sm-none ">
 					@if($arabic)
 					<h3>وسائل التواصل الاجتماعي لدينا</h3>
 					@else
 					<h3>Temukan Kami</h3>
 					@endif
 					<div class="d-flex flex-wrap position-relative">
 						<a href="" class="d-flex me-4 align-items-center mb-2 mb-sm-0">
 							<img src="{{ asset('assets/web/images/yt.png') }}"> @inacoindonesiaofficial
 						</a>
 						<a href="" class="d-flex me-4 align-items-center mb-2 mb-sm-0">
 							<img src="{{ asset('assets/web/images/fb.png') }}"> INACOFOOD
 						</a>
 						<a href="" class="d-flex me-4 align-items-center mb-2 mb-sm-0">
 							<img src="{{ asset('assets/web/images/tw.png') }}"> sahabatinaco
 						</a>
 						<a href="" class="d-flex me-4 align-items-center mb-2 mb-sm-0">
 							<img src="{{ asset('assets/web/images/ig.png') }}"> sahabatinaco
 						</a>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 </section>