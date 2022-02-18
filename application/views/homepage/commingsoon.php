<!DOCTYPE html>
<html lang="en">

<head>
    <title>Track Itinerary</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.rawgit.com/stevenmonson/googleReviews/master/google-places.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/stevenmonson/googleReviews/6e8f0d79/google-places.js"></script>


    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://googlereviews.cws.net/google-reviews.js"></script>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url()  . 'site/images/' . favicon() ?>" />
    <style>
    body,
    html {
        height: 100%;
        margin: 0;
    }

    .bgimg {
        background-image: url('./site/images/travel_bg.jpg');
        height: 100%;
        background-position: center;
        background-size: cover;
        position: relative;
        color: white;
        font-family: "Courier New", Courier, monospace;
        font-size: 25px;
    }


    .bgimg:before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background: rgba(0, 0, 0, .3);
    }

    /* .topleft {
    top: 0;
	background: #4e4e4e;
    } */

    .bottomleft {
        position: absolute;
        bottom: 0;
        left: 12px;
        width: 60%;
    }

    .middle {
        position: absolute;
        top: 15%;
        left: 1%;
        /* transform: translate(-50%, -50%); */
        text-align: center;
    }

    .middle2 {
        position: absolute;
        top: 44%;
        left: 1%;
        font-size: 23px;
    }

    .topleft>img {
        max-width: 200px;
        padding: 17px;
    }

    hr {
        margin: auto;
        width: 40%;
    }

    .uppercase {
        text-transform: uppercase;
        font-weight: 800;
        color: white;
        font-size: 60px;
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="bgimg">
        <div class="topleft">
        <div class="topleft">
            <!-- <img src="<?php echo site_url() ?>site/images/trackv2logo.png" alt="Track Itineray Software"> -->
            <img src="<?php echo site_url()  . 'site/images/' . getLogo() ?>" alt="Track Itineray Software">
        </div>
        <div class="middle">
            <h1 class="uppercase">It's Time to <br> Adventure </h1>
        </div>
        <div class="middle2">
            <p>once a year, go someplace <br> you've never been before.... <br> -Dalai Lama</p>
        </div>
        <div class="bottomleft">
            <p>Demo Travels Pvt. Ltd. ground Floor Of Demo Office, Demo City -17100445</p>
            <p>+91 8245789632</p>
            <p> info@trackitinerary.com</p>
        </div>
    </div>

</body>

</html>