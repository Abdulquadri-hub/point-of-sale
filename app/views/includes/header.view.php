<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
   <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?=ROOT?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?=ROOT?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?=ROOT?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?=ROOT?>/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?=ROOT?>/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?=ROOT?>/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?=ROOT?>/assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="<?=ROOT?>/assets/css/all.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?=ROOT?>/assets/css/style.css" rel="stylesheet">
	<title><?=$title?> <?=APP_NAME?></title>

	<style>
		.navbar {
			z-index: 99;
		}

		body {
			padding-top: 8em;
			background: #f6f9ff;
            color: #444444;
		}

		.sliderFade {
			animation: fade 0.5s ease;
		}

		.sliderThumb, .sliderMainImage {
			cursor: pointer;
		}

		@keyframes fade {
			0% {opacity: 0;}
			100% {opacity: 1;}
		}
	</style>
</head>
<body>