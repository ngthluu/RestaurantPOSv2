<!-- ======= Footer ======= -->
<footer id="footer" class="footer">

<div class="footer-top">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5 col-md-12 footer-info">
                <a href="index.html" class="logo d-flex align-items-center">
                    <img src="<?= base_url("resources/logo.jpg") ?>" alt="">
                    <span><?= PROJECT_NAME ?></span>
                </a>
                <p>New style restaurant.</p>
                <p>Fast, convenient & delicious.</p>
                <div class="social-links mt-3">
                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram bx bxl-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin bx bxl-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Contact us</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Our Branches</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                <h4>Contact Us</h4>
                <p>
                    Khoi 6, Dak To<br>
                    Dak To, Kon Tum<br>
                    Viet Nam <br><br>
                    <strong>Phone:</strong> <?= PHONE ?><br>
                    <strong>Email:</strong> admin@<?= EMAIL_PATH ?><br>
                </p>

            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="copyright">
        &copy; Copyright <strong><span><?= PROJECT_COPYRIGHT_BY ?></span></strong>. All Rights Reserved
    </div>
</div>
</footer>
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<script src="<?= base_url("assets/homepage/js/jquery.min.js") ?>"></script>
<script src="<?= base_url("assets/homepage/js/popper.min.js") ?>"></script>
<script src="<?= base_url("assets/homepage/js/bootstrap.min.js") ?>"></script>
</body>

</html>