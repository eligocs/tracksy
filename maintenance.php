<!DOCTYPE html>
<?php
header('HTTP/1.1 503 Service Temporarily Unavailable');
header('Status: 503 Service Temporarily Unavailable');
header('Retry-After: 3600');
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Maintenance</title>
		<link rel="shortcut icon" type="image/x-icon" href="/site/images/favicon.ico" /> 
        <style>
            body {
                width:500px;
                margin:0 auto;
                text-align: center;
                color:#fff;
				background: #333;
            }
			a{color: #f0ff21;}
			.page-footer-inner{margin-top: 50px;}
        </style>
    </head>

    <body>

        <img src="/site/images/trackv2-logo.png">

        <h1><p>Sorry for the inconvenience while we are upgrading. </p>
            <p>Please revisit shortly</p>
        </h1>
        <div></div>
        <img src="/site/images/maintenance.png"   >
		<div class="page-footer-inner"> <?php echo date("Y"); ?> &copy; Track Itinerary Develop By
			<a target="_blank" href="http://eligocs.com">Eligocs</a></div>
		<div class="scroll-to-top">

    </body>
</html>
