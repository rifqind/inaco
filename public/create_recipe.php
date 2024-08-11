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

   <!-- Summernote css -->
    <link href="assets/plugins/summernote/summernote-bs4.css" rel="stylesheet">

    <!-- Sweet Alert css -->
    <link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- Datepicker css -->
    <link href="assets/plugins/datepicker/datepicker.min.css" rel="stylesheet" type="text/css">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/flag-icon.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css?v=<?php echo rand(); ?>" rel="stylesheet" type="text/css">
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
                        <h4 class="page-title">Add New Recipe</h4>
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
                            <!-- div class="card-header">
                                <h5 class="card-title">Add New</h5>
                            </div -->
                            <div class="card-body">
                                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                                <form class="form-validate" action="#" method="post">
                
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="val-title">Recipe Title<span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="val-title" name="news_title" placeholder="Enter Title">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="val-desc">Recipe Description <span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <textarea class="summernote" name="content_desc" rows="5" placeholder="Enter Content."></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="val-desc">Ingredient <span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <textarea class="summernote" name="content_desc" rows="5" placeholder="Enter Content."></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="val-language">Language<span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="val-language" name="language" style="width:200px;">
                                                <option value="">Please select</option>
                                                <option value="">Indonesia</option>
                                                <option value="">English</option>
                                                <option value="">Arabic</option>
                                                <option value="">Vietnam</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="val-page">Product<span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <select  class="select2-single form-control" id="val-page" name="news_category" style="width:200px;">   
                                                <option value="">Please select</option>
                                                <option value="">Nata De Coco Bucket</option>
                                                <option value="">Nata De Coco Bag </option>
                                                <option value="">Kolang-Kaling Mix  - Frambozen (Pouch)</option>
                                                <option value="">Nata Dessert  - Guava (Cup)</option>
                                                <option value="">Aloe Vera  - Banana (Pouch)</option>
                                                <option value="">Aloe Vera  - Peach (Pouch)</option>
                                                <option value="">Mini Jelly 5s</option>
                                                <option value="">Mini Jelly & Mini Pudding 40s</option>
                                                <option value="">Konnyaku Jelly</option>
                                                <option value="">Mini Pudding 10s</option>
                                                <option value="">Mini Pudding & Mini Jelly 40s</option>
                                                <option value="">Pudding Cup - Passion Fruit</option>
                                                <option value="">Pudding Nusantara - Mixed 3 flavor</option>
                                                <option value="">Im Coco - Strawberry</option>
                                                <option value="">Im Coco - Lychee</option>
                                                <option value="">Jelly Drink - Strawberry</option>
                                                <option value="">Jelly Drink - Mango</option>
                                                <option value="">Mini Jelly Boi 3s</option>
                                                <option value="">Bubble Boi - Yaghurt</option>
                                                <option value="">Bubble Boi - Blackcurrant</option>
                                                <option value="">Frozen Mix - Gummy Candy</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="val_image">Recipe Image<span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="file" class="form-control-file" id="val_images" name="news_image">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="val-phoneus">Recipe Status<span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="page_status" id="page_status1" value="1" checked>
                                              <label class="form-check-label" for="page_status1">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="page_status" id="ipage_status2" value="0">
                                              <label class="form-check-label" for="page_status2">In Active</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label"></label>
                                        <div class="col-lg-8">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>                                  
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    
                </div> <!-- End row -->
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
    
    <!-- Select2 js -->
    <script src="assets/plugins/select2/select2.min.js"></script>
    <script src="assets/js/custom/custom-form-select.js"></script>  

    <!-- Parsley js -->
    <script src="assets/plugins/validatejs/validate.min.js"></script>
    <!-- Validate js -->
    <script src="assets/js/custom/custom-page.js"></script>
    <script src="assets/js/custom/custom-form-validation.js"></script>
    <!-- Sweet-Alert js -->
    <script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
    <script src="assets/js/custom/custom-sweet-alert.js"></script>

    <!-- Summernote JS -->
    <script src="assets/plugins/summernote/summernote-bs4.min.js"></script>

     <!-- Datepicker JS -->
    <script src="assets/plugins/datepicker/datepicker.min.js"></script>
    <script src="assets/plugins/datepicker/i18n/datepicker.en.js"></script>
    <script src="assets/js/custom/custom-form-datepicker.js"></script>

    <!-- Code Mirror JS -->
    <!--script src="assets/plugins/code-mirror/codemirror.js"></script>
    <script src="assets/plugins/code-mirror/htmlmixed.js"></script>
    <script src="assets/plugins/code-mirror/css.js"></script>
    <script src="assets/plugins/code-mirror/javascript.js"></script>
    <script src="assets/plugins/code-mirror/xml.js"></script-->
    <script src="assets/js/custom/custom-recipe-form.js"></script>    

    <!-- Core js -->
    <script src="assets/js/core.js"></script>
    <!-- End js -->
</body>
</html>