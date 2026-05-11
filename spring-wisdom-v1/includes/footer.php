<?php require_once __DIR__ . '/config.php'; ?>
</main>
<footer class="sw-footer mt-5">
    <div class="container-lg py-5">
        <div class="row g-4">
            <div class="col-lg-5">
                <a class="footer-brand fw-bold" href="<?= e(url_for('home.php')) ?>">Spring Wisdom</a>
                <p class="small sw-muted mt-2 mb-3">Preserving knowledge for focused digital learning through curated readings, author contributions, and responsible moderation.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="footer-icon-link" href="<?= e(url_for('contact.php')) ?>" aria-label="Contact Spring Wisdom"><i class="bi bi-envelope"></i></a>
                    <a class="footer-icon-link" href="<?= e(url_for('help-center.php')) ?>" aria-label="Help Center"><i class="bi bi-chat-left-text"></i></a>
                    <a class="footer-icon-link" href="<?= e(url_for('admin-feed.php')) ?>" aria-label="Platform updates"><i class="bi bi-megaphone"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h2 class="footer-heading">Explore</h2>
                <ul class="footer-links">
                    <li><a href="<?= e(url_for('home.php')) ?>">Home</a></li>
                    <li><a href="<?= e(url_for('browse.php')) ?>">Browse</a></li>
                    <li><a href="<?= e(url_for('archives.php')) ?>">All Archives</a></li>
                    <li><a href="<?= e(url_for('admin-feed.php')) ?>">Updates</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h2 class="footer-heading">Support</h2>
                <ul class="footer-links">
                    <li><a href="<?= e(url_for('contact.php')) ?>">Contact Us</a></li>
                    <li><a href="<?= e(url_for('report-policy.php')) ?>">Report Policy</a></li>
                    <li><a href="<?= e(url_for('author-guidelines.php')) ?>">Author Guidelines</a></li>
                    <li><a href="<?= e(url_for('help-center.php')) ?>">Help Center</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h2 class="footer-heading">Contact</h2>
                <address class="small sw-muted mb-0" id="contact">
                    Spring Wisdom Learning Portal<br>
                    Student Final Project Demo<br>
                    Email: <a href="mailto:contact@springwisdom.test">contact@springwisdom.test</a>
                </address>
            </div>
        </div>
        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between gap-2 mt-4 pt-4">
            <p class="small sw-muted mb-0">&copy; <?= e(date('Y')) ?> Spring Wisdom. All rights reserved.</p>
            <div class="d-flex flex-wrap gap-3 small">
                <a href="<?= e(url_for('privacy-policy.php')) ?>">Privacy Policy</a>
                <a href="<?= e(url_for('terms.php')) ?>">Terms of Use</a>
                <a href="<?= e(url_for('accessibility.php')) ?>">Accessibility</a>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(url_for('assets/js/main.js')) ?>"></script>
</body>
</html>
