<?php 
if(!isset($page)) {
    $page = basename($_SERVER['PHP_SELF'], '.php' );
 } 
 ?>
<?php include __DIR__ . '/../functions/footer_switch.php';?>
 <?php include __DIR__ .'/components/footer/images.php'; ?>
 <!-- Informations du footer -->
 <div class="footer text-white py-5 px-3">
    <div class="container-xl">
        <div class="row">
        <?php include __DIR__ .'/components/footer/about.php'; ?>
        <?php include __DIR__ .'/components/footer/corporate.php'; ?>
        <?php include __DIR__ .'/components/footer/fitness.php'; ?>
        </div>
    </div>
</div>
<?php include __DIR__ .'/components/footer/bottom.php'; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>