<!-- Jquery JS-->
<script src="vendor/jquery/jquery.min.js"></script>

<!-- Vendor JS-->
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/datepicker/moment.min.js"></script>
<script src="vendor/datepicker/daterangepicker.js"></script>

<!-- Main JS-->
<script src="js/global.js"></script>
<script src="js/validatorJS.js"></script>
<script src="js/notify.js"></script>

<!-- Check Error -->
<?php if(isset($_SESSION[SESSION_ERR])): ?>
    <script>$.notify('<?php echo $_SESSION[SESSION_ERR] ?>', 'error');</script>
<?php endif; ?>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->