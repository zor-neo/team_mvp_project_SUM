<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Privacy Policy';
$active = '';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-section">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="sw-panel">
                    <span class="badge sw-badge mb-3">Policy</span>
                    <h1 class="h2 fw-bold">Privacy Policy</h1>
                    <p class="sw-muted">Spring Wisdom stores only the information needed for the learning portal demo and V1 workflow.</p>
                    <h2 class="h5 mt-4">Information We Store</h2>
                    <p class="sw-muted">Account name, email, password hash, role, optional profile details, uploaded profile image path, content records, reports, author requests, and admin messages.</p>
                    <h2 class="h5 mt-4">How It Is Used</h2>
                    <p class="sw-muted">Information is used for login, authorization, author publishing, report review, admin management, and reading-hub display.</p>
                    <h2 class="h5 mt-4">Security Notes</h2>
                    <p class="sw-muted mb-0">Passwords are stored as hashes. Private service keys are kept server-side and should never be exposed in browser JavaScript or committed to git.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
