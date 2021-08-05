<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Apps Spairum">
    <meta name="author" content="Spairum">

    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="../sendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">


</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-white sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a style="background-color: white;" class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-text mx-3" style="color: black;">
                    <span style="color: blue;">Admin</span> Web
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin'); ?>" style="color: black;">
                    <i class="fas fa-fw fa-home" style="color: black;"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color: black;">
                    <i class="fas fa-fw fa-handshake" style="color: black;"></i>
                    <span>Mitra</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" style="color: black;">
                    <!-- data-parent="#accordionSidebar" -->
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/admdriver">
                            <i class="fas fa-fw fa-user"></i>
                            <span>Driver</span>
                        </a>
                        <a class="collapse-item" href="/ptcv">
                            <i class="fas fa-fw fa-building"></i>
                            <span>PT / CV</span>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/admuser" style="color: black;">
                    <i class="fas fa-fw fa-user-tie" style="color: black;"></i>
                    <span>User</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/admstasiun" style="color: black;">
                    <i class="fas fa-fw fa-landmark" style="color: black;"></i>
                    <span>Stasiun</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse" aria-expanded="false" aria-controls="collapse" style="color: black;">
                    <i class="fas fa-fw fa-plus-circle" style="color: black;"></i>
                    <span>Create</span>
                </a>
                <div id="collapse" class="collapse" aria-labelledby="headingTwo" style="color: black;">
                    <!-- data-parent="#accordionSidebar" -->
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/crtmitra">
                            <i class="fas fa-fw fa-handshake"></i>
                            <span>Mitra/Supplier</span>
                        </a>
                        <a class="collapse-item" href="/crtdriver">
                            <i class="fas fa-fw fa-user"></i>
                            <span>Driver</span>
                        </a>
                        <a class="collapse-item" href="/crtstasiun">
                            <i class="fas fa-fw fa-landmark"></i>
                            <span>Stasiun</span>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('auth/logout'); ?>" style="color: black;">
                    <i class="fas fa-fw fa-sign-out-alt" style="color: black;"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block" style="color: black;">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0 bg-dark" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Messages -->

                        <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

                        <!-- Nav Item - User Information -->
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1 mr-4">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw" style="color: blue;"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <li class="nav-item mr-3 mt-2">
                            <div class="icon">
                                <!-- <i class="fas fa-stethoscope"></i> -->
                                <img src="/img/spairum logo.png" class="logo" style="width: 140px; height:auto" alt="">
                            </div>

                        </li>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fa-stack">
                                    <i class="fa fa-square fa-stack-2x" style="color: aqua;"></i>
                                    <i class="fa fa-user fa-stack-1x" style="color: white;"></i>
                                </span>

                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $akun['nama']; ?></span>
                                <!-- <img class="img-profile rounded-circle" src="< ?= base_url('img/profile/') . $user['image']; ?>"> -->
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    My Profile
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Logout</span>
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <?= $this->renderSection('admcontent'); ?>
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span> <strong>Copyright &copy; <?= date('Y'); ?> SPAIRUM.</strong> All rights reserved. V.1</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="../sendor/jquery/jquery.min.js"></script>
        <script src="../sendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../sendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../sendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../js/demo/chart-area-demo.js"></script>

        <!-- Untuk AJAX UBAH DATA -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- CDN data tabel -->

        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
        <!-- template custom js -->
        <script src="../js/admin.js"></script>

        <script>
            $('.form-check-input').on('click', function() {
                const menuId = $(this).data('menu');
                const roleId = $(this).data('role');

                $.ajax({
                    url: "<?= base_url('admin/changeaccess'); ?>",
                    type: 'post',
                    data: {
                        menuId: menuId,
                        roleId: roleId
                    },
                    success: function() {
                        document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
                    }
                });

            })
        </script>

        <script>
            $(function() {
                $("#tanggalantrian").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1950:2020',
                    dateFormat: 'dd/mm/yy',
                    autoclose: true,
                    todayHighlight: true,
                });
            });
        </script>
        <script>
            $(function() {
                $("#tanggalpembuatan").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1950:2020',
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                });
            });
        </script>
        <script>
            $(function() {
                $("#tanggalkadaluwarsa").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1950:2020',
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                });
            });
        </script>
</body>

</html>