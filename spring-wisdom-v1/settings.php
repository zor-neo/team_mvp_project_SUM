<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user = current_user();

if (is_post()) {
    $theme = in_array($_POST['settings_theme'] ?? 'light', ['light', 'comfortable', 'compact'], true) ? $_POST['settings_theme'] : 'light';
    $email = isset($_POST['email_notifications']);
    update_user_settings((int) $user['id'], $theme, $email);
    flash('Settings updated.');
    redirect_to('settings.php');
}

$user = current_user();
$pageTitle = 'Settings';
$active = 'account';
require __DIR__ . '/includes/header.php';
?>
<section class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="sw-panel">
                <h1 class="h3 fw-bold mb-3">Settings</h1>
                <p class="sw-muted">Configure simple account preferences for the V1 demo.</p>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Reading Layout Preference</label>
                        <select class="form-select" name="settings_theme">
                            <?php foreach (['light' => 'Light Default', 'comfortable' => 'Comfortable Spacing', 'compact' => 'Compact Lists'] as $value => $label): ?>
                                <option value="<?= e($value) ?>" <?= ($user['settings_theme'] ?? 'light') === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="emailNotifications" name="email_notifications" <?= !empty($user['email_notifications']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="emailNotifications">Receive account and review notifications</label>
                    </div>
                    <button class="btn btn-sw-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
