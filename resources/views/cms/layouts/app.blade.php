<!DOCTYPE html>
<html lang="en">
@include('cms.layouts.head')
{{ $head }}
<body class="vertical-layout">
    <div class="containerbar">
        <!-- Leftbar / Sidebar -->
        @include('cms.layouts.leftbar')

        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            @include('cms.layouts.topbar-mobile')

            <!-- Start Topbar -->
            @include('cms.layouts.topbar')
            <!-- End Topbar -->

            <!-- Start Breadcrumbbar -->
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">{{ $breadcrumb }}</h4>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->
            <div class="contentbar">
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    {{ $slot }}
                </div> <!-- End row -->
            </div>
            <!-- End Contentbar -->
            <!-- Start Footerbar -->
            <div class="footerbar">
                <footer class="footer">
                    <p class="mb-0">© <?php echo date('Y') ?> Inaco - All Rights Reserved.</p>
                </footer>
            </div>
            <!-- End Footerbar -->
        </div>
    </div>
    @include('cms.layouts.script')
    {{ $script }}
    <!-- Start js -->
    <!-- End js -->
</body>
</html>