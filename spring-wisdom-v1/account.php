<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$user = current_user();

function save_profile_picture(array $file, int $userId): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        flash('Profile photo upload failed.', 'danger');
        return null;
    }
    if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
        flash('Profile photo must be 2MB or smaller.', 'danger');
        return null;
    }
    $info = @getimagesize($file['tmp_name']);
    if (!$info || !in_array($info['mime'], ['image/jpeg', 'image/png', 'image/gif', 'image/webp'], true)) {
        flash('Profile photo must be a JPG, PNG, GIF, or WEBP image.', 'danger');
        return null;
    }
    $ext = match ($info['mime']) {
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
        default => 'jpg',
    };
    $dir = __DIR__ . '/uploads/profiles';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    $relative = 'uploads/profiles/user-' . $userId . '.' . $ext;
    move_uploaded_file($file['tmp_name'], __DIR__ . '/' . $relative);
    return $relative;
}

if (is_post()) {
    require_csrf();
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'institution' => trim($_POST['institution'] ?? ''),
        'bio' => trim($_POST['bio'] ?? ''),
    ];
    $photo = save_profile_picture($_FILES['profile_photo'] ?? [], (int) $user['id']);
    if ($photo) {
        $data['profile_pic_path'] = $photo;
    }
    update_user_profile((int) $user['id'], $data);
    flash('Account information updated.');
    redirect_to('account.php');
}

$user = current_user();
$pageTitle = 'Account Information';
$active = 'account';
require __DIR__ . '/includes/header.php';
?>
<section class="container-lg py-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="sw-panel text-center">
                <img id="profilePreview" class="sw-avatar-lg mb-3" src="<?= e(avatar_url($user)) ?>" alt="Profile picture">
                <h1 class="h4 mb-1"><?= e($user['name']) ?></h1>
                <p class="sw-muted mb-0"><?= e(ucfirst($user['role'])) ?> account</p>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="sw-panel">
                <h2 class="h3 fw-bold mb-4">Account Information</h2>
                <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Username / Display Name</label><input class="form-control" name="name" value="<?= e($user['name']) ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" value="<?= e($user['email']) ?>" disabled></div>
                        <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?= e($user['phone'] ?? '') ?>" placeholder="Optional"></div>
                        <div class="col-md-6"><label class="form-label">Institution / Class</label><input class="form-control" name="institution" value="<?= e($user['institution'] ?? '') ?>" placeholder="Optional"></div>
                        <div class="col-12"><label class="form-label">Additional Info / Bio</label><textarea class="form-control" name="bio" rows="4" placeholder="Add information not requested during registration."><?= e($user['bio'] ?? '') ?></textarea></div>
                        <div class="col-12">
                            <label class="form-label">Change Profile Picture</label>
                            <input class="form-control" type="file" name="profile_photo" accept="image/*">
                            <div class="form-text">JPG, PNG, GIF, or WEBP. Max 2MB. The navbar and profile page resize it proportionately.</div>
                        </div>
                    </div>
                    <button class="btn btn-sw-primary mt-4">Update Account</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
