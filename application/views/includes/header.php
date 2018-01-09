<!DOCTYPE html>
<html>
    <head>
        <title><?= $title ?></title>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="<?= base_url(); ?>assets/js/materialize.min.js"></script>

        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/materialize.min.css"  media="screen,projection"/>

        <!-- Primary Css -->
        <link rel="stylesheet" type="text/css" href='<?= base_url(); ?>assets/css/primary.css?v=<?= time(); ?>'>

        <!-- Circle Css -->
        <link rel="stylesheet" type="text/css" href='<?= base_url(); ?>assets/css/circle.css?v=<?= time(); ?>'>

        <!-- Data tables CSS-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

        <!-- Data tables JS -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

        <!-- MARK'S CSS!!! -->
        <link rel="stylesheet" type="text/css" href='<?= base_url(); ?>assets/css/mark_css.css?v=<?= time(); ?>'>

        <!-- Global base_url for js files -->
        <script>var base_url = '<?php echo base_url() ?>';</script>

        <!-- SweetAlert2 -->
        <script src="<?= base_url(); ?>assets/js/sweetalert2.all.js"></script>
    </head>
    <body>
