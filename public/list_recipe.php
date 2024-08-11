<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Orbiter is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, responsive, bootstrap 4, ui kits, ecommerce, web app, crm, cms, html, sass support, scss">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>CMS Inaco</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png">
    <!-- Start css -->
    <!-- Select2 css -->
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables css -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive Datatable css -->
    <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/flag-icon.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- End css -->
</head>

<body class="vertical-layout">

    <!-- Start Containerbar -->
    <div id="containerbar">
        <!-- Start Leftbar -->
        <?php include('base/leftbar.php') ?>
        <!-- End Leftbar -->
        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            <?php include('base/topbar-mobile.php') ?>

            <!-- Start Topbar -->
            <div class="topbar">
                <!-- Start row -->
                <div class="row align-items-center">
                    <!-- Start col -->
                    <div class="col-md-12 align-self-center">
                        <div class="togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger" href="javascript:void();">
                                            <img src="assets/images/svg-icon/collapse.svg" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                            <img src="assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End Topbar -->
            <!-- Start Breadcrumbbar -->
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">List Recipe</h4>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->
            <div class="contentbar">
                <!-- Start row -->
                <div class="row">

                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header pt-0">
                                <div class="category-filter d-flex align-items-center" id="filter-wrapper">
                                    <label class="mr-2 mb-0">Filter Produk :</label>
                                    <select id="categoryFilter" class="select2-single form-control form-control-sm" style="width:200px">
                                        <option value="">Show All</option>
                                        <option value="Nata De Coco Bucket">Nata De Coco Bucket</option>
                                        <option value="Nata De Coco">Nata De Coco</option>
                                        <option value="Nata De Coco (Vanila)">Nata De Coco (Vanila)</option>
                                        <option value="Nata De Coco Selasih">Nata De Coco Selasih</option>
                                        <option value="Kolang-Kaling Mix  - Frambozen (Pouch)">Kolang-Kaling Mix - Frambozen (Pouch)</option>
                                        <option value="Nata Dessert  - Guava (Cup)">Nata Dessert - Guava (Cup)</option>
                                        <option value="Aloe Vera  - Banana (Pouch)">Aloe Vera - Banana (Pouch)</option>
                                        <option value="Aloe Vera  - Peach (Pouch)">Aloe Vera - Peach (Pouch)</option>
                                        <option value="Mini Jelly 5s">Mini Jelly 5s</option>
                                        <option value="Mini Jelly & Mini Pudding 40s">Mini Jelly & Mini Pudding 40s</option>
                                        <option value="Konnyaku Jelly">Konnyaku Jelly</option>
                                        <option value="Mini Pudding 10s">Mini Pudding 10s</option>
                                        <option value="Mini Pudding & Mini Jelly 40s">Mini Pudding & Mini Jelly 40s</option>
                                        <option value="Pudding Cokelat INACO">Pudding Cokelat INACO</option>
                                        <option value="Pudding Cup">Pudding Cup</option>
                                        <option value="Pudding Nusantara - Mixed 3 flavor">Pudding Nusantara - Mixed 3 flavor</option>
                                        <option value="Im Coco - Strawberry">Im Coco - Strawberry</option>
                                        <option value="Im Coco - Lychee">Im Coco - Lychee</option>
                                        <option value="Jelly Drink - Strawberry">Jelly Drink - Strawberry</option>
                                        <option value="Jelly Drink - Mango">Jelly Drink - Mango</option>
                                        <option value="Mini Jelly Boi 3s">Mini Jelly Boi 3s</option>
                                        <option value="Bubble Boi - Yaghurt">Bubble Boi - Yaghurt</option>
                                        <option value="Bubble Boi - Blackcurrant">Bubble Boi - Blackcurrant</option>
                                        <option value="Frozen Mix - Gummy Candy">Frozen Mix - Gummy Candy</option>
                                    </select>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <a href="create_recipe.php" class="btn btn-primary-rgba position-absolute" id="addButton"><i class="feather icon-plus mr-2"></i>Add New</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap">Image</th>
                                                <th class="text-nowrap">Title</th>
                                                <th class="text-nowrap">Produk</th>
                                                <th class="text-nowrap">Lang</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><img src="data/pai-pudding.jpg" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                                <td>Pai Pudding Coklat Inaco</td>
                                                <td>Pudding Cokelat INACO</td>
                                                <td>Indonesia</td>
                                                <td class="text-nowrap"><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                    <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="data/Nata-Latte-03.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                                <td>Nata Latte INACO</td>
                                                <td>Nata De Coco (Vanila)</td>
                                                <td>Indonesia</td>
                                                <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                    <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="data/dadar-hijau.jpg" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                                <td>Dadar Hijau Isi Inaco Unti Crispy</td>
                                                <td>Nata De Coco</td>
                                                <td>Indonesia</td>
                                                <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                    <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="data/fruit-mix.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                                <td>Fruit Mix Ala Inaco</td>
                                                <td>Nata De Coco Selasih</td>
                                                <td>Indonesia</td>
                                                <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                    <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="data/es-pudding.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                                <td>Es Pudding Inaco</td>
                                                <td>Pudding Cup</td>
                                                <td>Indonesia</td>
                                                <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                    <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="data/nata-soes.jpg" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                                <td>Inaco Nata Soes</td>
                                                <td>Nata De Coco</td>
                                                <td>Indonesia</td>
                                                <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                    <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
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
        <!-- End Rightbar -->
    </div>
    <!-- End Containerbar -->
    <!-- Start js -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/vertical-menu.js"></script>

    <!-- Select2 js -->
    <script src="assets/plugins/select2/select2.min.js"></script>
    <script src="assets/js/custom/custom-form-select.js"></script>

    <!-- Datatable js -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/jszip.min.js"></script>
    <script src="assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

    <script src="assets/js/custom/custom-recipe.js"></script>
    <!-- Core js -->
    <script src="assets/js/core.js"></script>
    <!-- End js -->
</body>

</html>