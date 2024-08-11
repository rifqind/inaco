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
        <?php include('base/leftbar.php')?>
        <!-- End Leftbar -->
        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            <?php include('base/topbar-mobile.php')?>

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
                        <h4 class="page-title">List Product</h4>
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
                                    <label class="mr-2 mb-0">Filter Category :</label>
                                    <select id="categoryFilter" class="form-control form-control-sm" style="width:200px">
                                        <option value="">Show All</option>
                                        <option value="NATA DE COCO">NATA DE COCO</option>
                                        <option value="ALOE VERA">ALOE VERA</option>
                                        <option value="MINI JELLY">MINI JELLY</option>
                                        <option value="MINI PUDDING">MINI PUDDING</option>
                                        <option value="PUDDING">PUDDING</option>
                                        <option value="RTD">RTD</option>
                                        <option value="RTD POUCH">RTD POUCH</option>
                                        <option value="CONFECTIONERY">CONFECTIONERY</option>
                                        <option value="GT PRODUCTS">GT PRODUCTS</option>
                                    </select>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <a href="create_product.php" class="btn btn-primary-rgba position-absolute"><i class="feather icon-plus mr-2"></i>Add New</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Segment</th>
                                            <th>Lang</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><img src="data/Nata-cup-mango-700x527.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco Nata De Coco Cup – 200gr (Mangga)</td>
                                            <td>NATA DE COCO</td>
                                            <td>Dewasa</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/Nata-Bag-1kg-Orange-Selasih-700x527.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco Nata De Coco – 1 kg (Jeruk dengan Selasih)</td>
                                            <td>NATA DE COCO</td>
                                            <td>Dewasa</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/Pudding-Nusantara-Papua.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco Pudding NUSANTARA 3’s (Aneka Rasa)</td>
                                            <td>PUDDING</td>
                                            <td>Dewasa</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/Pudding-120g-Markisa.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco Pudding Puree – 120gr (Markisa)</td>
                                            <td>PUDDING</td>
                                            <td>Dewasa</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/aloe-leci-sp-700x527.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco Lidah Buaya Pouch – 280gr (Leci)</td>
                                            <td>ALOE VERA</td>
                                            <td>Dewasa</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/Aloevera-Cup-Banana-700x527.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco Lidah Buaya Cup – 200gr (Pisang)</td>
                                            <td>ALOE VERA</td>
                                            <td>Dewasa</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/Imcoco-cocomelon-700x527.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco I’m Coco – 350ml KELAPA MELON BARU!</td>
                                            <td>RTD</td>
                                            <td>Remaja</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/New-Mock-Up-Strawberry-1.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Jelly Drink – Stroberi</td>
                                            <td>RTD POUCH</td>
                                            <td>Remaja</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/Frozen-mix-700x527.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco Frozen Mix – Permen Lunak Gummy – Aneka Rasa</td>
                                            <td>CONFECTIONERY</td>
                                            <td>Anak</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/new-BB-yaghurt-700x527.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco BubbleBoi Sachet – 30 gr – Yaghurt</td>
                                            <td>GT PRODUCTS</td>
                                            <td>Anak</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/BB-30gr-Anggur-700x1031.jpg" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco BubbleBoi Sachet – 30 gr – Anggur</td>
                                            <td>GT PRODUCTS</td>
                                            <td>Anak</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/MJ-25-reg-700x527.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco Mini Jelly 25’s</td>
                                            <td>MINI JELLY</td>
                                            <td>Anak</td>
                                            <td>Indonesia</td>
                                            <td><a href="#" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                                <a href="#" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="data/MJ-Bucket-50.png" alt="Rounded Image" class="rounded mx-auto d-block image-list"></td>
                                            <td>Inaco Mini Jelly 50’s</td>
                                            <td>MINI JELLY</td>
                                            <td>Anak</td>
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
                    <p class="mb-0">© <?php echo date('Y')?> Inaco - All Rights Reserved.</p>
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
    
    <script src="assets/js/custom/custom-product.js"></script>
    <!-- Core js -->
    <script src="assets/js/core.js"></script>
    <!-- End js -->
</body>
</html>