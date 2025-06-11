<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat AI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    .navbar-nav .nav-link {
      font-size: 20px;
      transition: color 0.3s ease-in-out;
    }
    .navbar-nav .nav-link:hover {
      color: #ffc107 !important;
    }
    .btn-custom {
      border-radius: 20px;
      transition: background-color 0.3s ease-in-out;
    }
    .btn-custom:hover {
      background-color: #e0a800 !important;
    }
  </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg border-bottom border-5 border-secondary"
        style="background: rgb(255, 105, 180); color: white;">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="#">
                <h1 class="mb-0"><i class="bi bi-fingerprint text-warning"></i>&nbsp;Chat AI</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
        aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
        <ul class="navbar-nav me-3 my-2 my-lg-0 navbar-nav-scroll">
          <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Pricing</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">AI Products Offer</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Documentation</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">API Integrations</a></li>
              <li><a class="dropdown-item" href="#">Embedded AI Chatbots</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Cloud Datasets</a></li>
            </ul>
          </li>
        </ul>
        <?php
        if (isset($_SESSION['user_id'])){
          echo '<a href="?logout=true" class="btn btn-secondary fw-bolder btn-custom">Logout <i class="bi bi-arrow-right"></i></a>';
        }else{
          echo '<a href="?page=login" class="btn btn-secondary fw-bolder btn-custom">Login<i class="bi bi-arrow-right"></i></a>';
        }
        if (isset($_GET['logout'])){
          session_unset();
          session_destroy();
          header("Location: index.php?login");
        }
        ?>
        
      
    </div>
    </div>
  </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-e0mykwuNC2txEzh8A9jYXzcl+b6Ia/f5r9z9ZC9Rr59X5HEm+nXn9BPrW6Z5F5sj" crossorigin="anonymous"></script>
</body>










-

</html>