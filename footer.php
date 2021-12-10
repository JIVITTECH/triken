</div>
<footer class="footer appear-animate" data-animation-options="{'name': 'fadeIn'}">
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="widget">
                                <h3 class="widget-title">Useful Links</h3>
                                <ul class="widget-body">
                                    <li><a href="about.php">About</a></li>
                                    <li><a href="recipes.php">Recipes & Tips</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Terms &amp; Conditions</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class='col-lg-2 col-sm-6' id="load_footer_cats_container">
                        </div>

                        <div class="col-lg-4 col-sm-12">
                            <div class="widget">
                                <h4 class="widget-title">For Feedback</h4>
                                <p class="ps-footer__work">Call:  <a href="tel:86867 54754">8686 754 754</a> </p>
                                <p class="ps-footer__work"> Mail:  <a href="mailto:care@todayscut.com">care@todayscut.com</a></p>
                                <h5 class="widget-title address">Office Address</h5>
                               <address> 21, AKG Nagar, PSG Govindasamy Nagar, 
                                    Opp. Kasthuribai Hospital, Kamarajar 
                                    Road, Uppilipalayam(PO), Singnallur,  
                                    Coimbatore - 641015. </address> 
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12 text-center">
                            <div class="widget widget-about">
                                <a href="index.php" class="logo-footer">
                                    <img src="assets/images/footerlogo.png" alt="logo-footer"/>
                                </a>
                                <div class="widget-body follow">
                                
                                        <h5 class="widget-title">Follow Us</h5>
                                        <div class="social-icons social-no-color border-thin">
                                            <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                            <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                            <a href="#" class="social-icon social-youtube fab fa-linkedin-in"></a>
                                        </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="footer-middle">
                    <div class="widget widget-category" id="load_footer_items_for_cats_container">
                    </div>
                </div>-->
                <div class="footer-bottom">
                    <div class="footer-left">
                        <p class="copyright">© 2021. K2Farms. All Rights Reserved.</p>
                    </div>
                    <div class="footer-right">
                        <figure class="payment">
                            <img src="assets/images/payment.png" alt="payment" />
                        </figure>
                    </div>
                </div>
            </div>
        </footer>
</div>
        <!-- Start of Scroll Top -->
        <a id="scroll-top" class="scroll-top" href="#top" title="Top" role="button"> <i class="w-icon-angle-up"></i> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70"> <circle id="progress-indicator" fill="transparent" stroke="#000000" stroke-miterlimit="10" cx="35" cy="35" r="34" style="stroke-dasharray: 16.4198, 400;"></circle> </svg> </a>

<?php include('mobilemenu.php'); ?>


    <!-- Plugin JS File -->
    
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/jquery.plugin/jquery.plugin.min.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/zoom/jquery.zoom.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="assets/vendor/isotope/isotope.pkgd.min.js"></script>
    


    <!-- Main Js -->
    <script src="assets/js/main.min.js"></script>
    <script src="js/loadFooterDetails.js"></script>
    <script>
        $(document).ready(function () {
            loadFooterCategories();
            //loadFooterItemsForCategories();
        });
    </script>

</body>
</html>
