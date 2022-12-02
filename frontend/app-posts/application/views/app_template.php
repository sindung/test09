<?= doctype() ?>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--<link rel="shortcut icon" type="image/png" href=""/>-->

        <!-- Bootstrap CSS -->
        <?= link_tag(base_url('assets/bootstrap/css/bootstrap.min.css'), 'stylesheet', 'text/css') ?>

        <!--FontAwesome-->
        <?= link_tag(base_url('assets/fontawesome/css/all.css'), 'stylesheet', 'text/css') ?>

        <title>{app_title}</title>

        <style type="text/css">
            .app-content {
                margin-top: 70px;
            }

            input[disabled="disabled"] {
                cursor: not-allowed;
            }

            .content-responsive {
                width: 200%;
            }

            @media only screen and (min-width: 768px) {
                .dropdown:hover .dropdown-menu {
                    display: block;
                }
            }

            @media (min-width: 500px) {
                .content-responsive {
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url() ?>"><i class="fas fa-fw fa-parking"></i> ParkirApp</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= base_url() ?>"><i class="fas fa-fw fa-home"></i> Beranda <span class="sr-only">(current)</span></a>
                        </li>
                        <!--
                        <li class="nav-item">
                            <a class="nav-link" href="<!?= site_url('produk') ?>">Produk</a>
                        </li>
                        -->
                        <!--
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Transaksi
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<!?= site_url('transaksi/penjualan') ?>">Penjualan</a>
                            </div>
                        </li>
                        -->
                        <!--
                        <li class="nav-item">
                            <a class="nav-link" href="<!?= site_url('FormCheckIn') ?>">Form Check In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<!?= site_url('FormCheckOut') ?>">Form Check Out</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<!?= site_url('Report') ?>">Page report</a>
                        </li>
                        -->

                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('AllPosts') ?>">All Posts</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="app-content container">
            <h1>{app_heading}</h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
            </nav>

            {app_content}
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; <?= date('Y') ?> H-Soft</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="mailto:g9.hofar.ismail@gmail.com"><i class="far fa-fw fa-envelope"></i> Email</a></li>
                <li class="list-inline-item"><a href="https://api.whatsapp.com/send?phone=6281226490344" target="_wa"><i class="fab fa-fw fa-whatsapp"></i> WhatsApp</a></li>
            </ul>
        </footer>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script>window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');</script>
        <script src="<?= base_url('assets/vendor/js/popper.min.js') ?>"></script>
        <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>

        <script>
            $(document).ready(function () {
                $('.dropdown-toggle').click(function (e) {
                    if ($(document).width() > 768) {
                        e.preventDefault();

                        var url = $(this).attr('href');

                        if (url !== '#') {
                            window.location.href = url;
                        }
                    }
                });
            });
        </script>
    </body>
</html>