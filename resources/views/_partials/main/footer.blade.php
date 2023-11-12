<!-- Main Footer -->
<footer class="main-footer {{ Route::currentRouteName() !== 'pages.homepage' ? 'alternate5' : '' }}">
    <!--Bottom-->
    <div class="footer-bottom">
		<div class="auto-container">
			<div class="outer-box">
				<div class="copyright-text">© {{ date('Y') }} <a href="#">{{ env('APP_NAME') }}</a>. All Right Reserved.</div>
				<div class="social-links">
					<a href="#"><i class="fab fa-facebook-f"></i></a>
					<a href="#"><i class="fab fa-twitter"></i></a>
					<a href="#"><i class="fab fa-instagram"></i></a>
					<a href="#"><i class="fab fa-linkedin-in"></i></a>
				</div>
			</div>
		</div>
    </div>
    <!-- Scroll To Top -->
    <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
</footer>
<!-- End Main Footer -->