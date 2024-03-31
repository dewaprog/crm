<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link rel="stylesheet" href="/css/crud.css">
  <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <?php $this->renderSection('headlink'); ?>


  <!-- <script src="js/bootstrap-tagsinput-angular.min.js"></script> -->

</head>

<body>



  <main>
    <h1 class="visually-hidden">Headers examples</h1>


    <header>
      <div class="px-3 py-2 bg-dark text-white">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">

            </a>

            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
              <li>
                <a href="#" class="nav-link text-secondary">
                  Master
                </a>
              </li>
              <li>
                <a href="#" class="nav-link text-white">

                  Dashboard
                </a>
              </li>
              <li>
                <a href="#" class="nav-link text-white">

                  Orders
                </a>
              </li>
              <li>
                <a href="#" class="nav-link text-white">

                  Products
                </a>
              </li>
              <li>
                <a href="#" class="nav-link text-white">

                  Customers
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </header>
    <div class="b-example-divider"></div>
    <br />
    <?php if (session()->getFlashdata('success')) : ?>

      <div class="alert alert-success" role="alert" align="center">
        <b><?= session()->getFlashdata('success'); ?></b>
      </div>

    <?php endif; ?>

    <?php $this->renderSection('content'); ?>
  </main>
</body>