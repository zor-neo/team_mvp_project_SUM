<?php
require_once __DIR__ . '/includes/auth.php';

if (isset($_GET['demo'])) {
    $role = $_GET['demo'];
    $user = in_array($role, ['user', 'author', 'admin'], true) ? find_user_by_role($role) : null;
    if ($user) {
        login_user($user);
        flash('Signed in as demo ' . $role . '.');
        redirect_to(after_login_path($user));
    }
}

if (is_post()) {
    require_csrf();
    $mode = $_POST['mode'] ?? 'login';
    if ($mode === 'register') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $validPassword = strlen($password) >= 8 && preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/[0-9]/', $password);

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash('Enter a valid name and email address.', 'danger');
        } elseif (!$validPassword) {
            flash('Password must be at least 8 characters and include uppercase, lowercase, and a number.', 'danger');
        } else {
            $created = create_user($name, $email, $password);
            flash($created ? 'Registration complete. Please sign in.' : 'That email is already registered.', $created ? 'success' : 'warning');
        }
    } else {
        if (attempt_login(trim($_POST['email'] ?? ''), $_POST['password'] ?? '')) {
            redirect_to(after_login_path(current_user()));
        }
        flash('Invalid email or password.', 'danger');
    }
}

$pageTitle = 'Access Portal';
$active = 'login';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-hero">
    <div class="container-lg">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 order-2 order-lg-1">
                <span class="badge sw-badge mb-3">Learning Hub</span>
                <h1 class="display-4 fw-bold mb-4">Knowledge is the only way out of this <span class="text-primary">Dark Age</span>.</h1>
                <p class="lead sw-muted mb-4"><span class="mm-text fw-bold">ဤအမှောင်ခေတ်မှ လွတ်မြောက်ရာ တခုတည်းသောလမ်းစမှာ "ဉာဏ်ပညာ" သာဖြစ်သည်။</span>
                    <br><br> Browse curated learning content, preserve thoughtful writing, and manage reports through a calm academic portal.
                </p>
                <div class="row g-3 mt-4">
                    <div class="col-md-6">
                        <div class="sw-panel h-100">
                            <i class="bi bi-book fs-2 text-primary"></i>
                            <h3 class="h5 mt-3">Curated Reading</h3>
                            <p class="small sw-muted mb-0">Students can browse published contents and report issues with clear reasons.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sw-panel h-100">
                            <i class="bi bi-shield-check fs-2 text-primary"></i>
                            <h3 class="h5 mt-3">Admin Moderation</h3>
                            <p class="small sw-muted mb-0">Admins review accounts, author requests, reports, messages, and feed updates.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 order-1 order-lg-2">
                <div class="sw-panel">
                    <ul class="nav nav-tabs mb-4" id="authTabs" role="tablist">
                        <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#loginTab" type="button">Login</button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#registerTab" type="button">Register</button></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="loginTab">
                            <form method="post" class="needs-validation" novalidate>
                                <?= csrf_field() ?>
                                <input type="hidden" name="mode" value="login">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input class="form-control" name="email" type="email" value="user@spring.test" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <input id="loginPassword" class="form-control" name="password" type="password" value="password" required>
                                        <button class="btn btn-outline-sw" type="button" data-toggle-password="#loginPassword"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <button class="btn btn-sw-primary w-100" type="submit">Enter Archive</button>
                            </form>
                            <div class="d-grid gap-2 mt-4">
                                <a class="btn btn-outline-sw" href="<?= e(url_for('index.php?demo=user')) ?>">Demo as User</a>
                                <a class="btn btn-outline-sw" href="<?= e(url_for('index.php?demo=author')) ?>">Demo as Author</a>
                                <a class="btn btn-outline-sw" href="<?= e(url_for('index.php?demo=admin')) ?>">Demo as Admin</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="registerTab">
                            <form method="post" class="needs-validation" novalidate>
                                <?= csrf_field() ?>
                                <input type="hidden" name="mode" value="register">
                                <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
                                <div class="mb-3"><label class="form-label">Email</label><input class="form-control" name="email" type="email" required></div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control" name="password" type="password" minlength="8" required>
                                    <div class="form-text">Minimum 8 characters with uppercase, lowercase, and a number.</div>
                                </div>
                                <button class="btn btn-sw-primary w-100" type="submit">Create User Account</button>
                                <p class="small sw-muted mt-3 mb-0">New accounts start as normal users. Admin approval is required for author status.</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
