<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

function seed_demo_data(): void
{
    $seedVersion = 2;
    if (($_SESSION['demo_seed_version'] ?? 0) >= $seedVersion) {
        return;
    }

    $_SESSION['users'] = [
        ['id' => 1, 'name' => 'Admin Scholar', 'email' => 'admin@spring.test', 'password_hash' => password_hash('password', PASSWORD_DEFAULT), 'role' => 'admin', 'profile_pic_path' => null, 'phone' => '', 'institution' => 'Spring Wisdom', 'bio' => 'Platform administrator.', 'settings_theme' => 'light', 'email_notifications' => true],
        ['id' => 2, 'name' => 'Maya Reader', 'email' => 'user@spring.test', 'password_hash' => password_hash('password', PASSWORD_DEFAULT), 'role' => 'user', 'profile_pic_path' => null, 'phone' => '', 'institution' => 'Student', 'bio' => 'Interested in careful reading and structured knowledge.', 'settings_theme' => 'light', 'email_notifications' => true],
        ['id' => 3, 'name' => 'Jon Author', 'email' => 'author@spring.test', 'password_hash' => password_hash('password', PASSWORD_DEFAULT), 'role' => 'author', 'profile_pic_path' => null, 'phone' => '', 'institution' => 'Archive Faculty', 'bio' => 'Writes short educational readings.', 'settings_theme' => 'light', 'email_notifications' => true],
        ['id' => 4, 'name' => 'Nora Candidate', 'email' => 'nora@spring.test', 'password_hash' => password_hash('password', PASSWORD_DEFAULT), 'role' => 'user', 'profile_pic_path' => null, 'phone' => '', 'institution' => '', 'bio' => '', 'settings_theme' => 'light', 'email_notifications' => true],
    ];

    $_SESSION['contents'] = [
        ['id' => 1, 'author_id' => 3, 'author_name' => 'Jon Author', 'title' => 'Stoic Resilience in Digital Learning', 'category' => 'Philosophy', 'summary' => 'A focused reading on calm attention and durable learning habits.', 'body' => 'Stoic practice encourages readers to separate what can be controlled from what cannot. In a digital learning space, this becomes a practical method for protecting attention, questioning sources, and returning to thoughtful study after distraction.', 'file_path' => 'contents/1/stoic-notes.pdf', 'status' => 'published', 'created_at' => '2026-05-01'],
        ['id' => 2, 'author_id' => 3, 'author_name' => 'Jon Author', 'title' => 'Navigating Fallacies in Public Discourse', 'category' => 'Logic & Reason', 'summary' => 'A practical guide to spotting common reasoning errors in media.', 'body' => 'Logical fallacies often appear convincing because they borrow the shape of argument without providing the substance. Readers can improve judgment by identifying unsupported conclusions, false dilemmas, and appeals to emotion.', 'file_path' => null, 'status' => 'published', 'created_at' => '2026-05-03'],
        ['id' => 3, 'author_id' => 3, 'author_name' => 'Jon Author', 'title' => 'The Evolution of the Scientific Method', 'category' => 'Scientific Method', 'summary' => 'A short historical overview of observation, testing, and revision.', 'body' => 'The scientific method did not appear fully formed. It developed through centuries of debate about evidence, repeatability, and the limits of authority. Its strength is not certainty, but disciplined correction.', 'file_path' => null, 'status' => 'published', 'created_at' => '2026-05-05'],
        ['id' => 4, 'author_id' => 3, 'author_name' => 'Jon Author', 'title' => 'Reading Primary Sources with Care', 'category' => 'Historical Archives', 'summary' => 'How to approach old documents without losing context or nuance.', 'body' => 'Primary sources reward patience. A useful reading practice begins with identifying the creator, intended audience, historical setting, and what the document leaves unsaid.', 'file_path' => null, 'status' => 'published', 'created_at' => '2026-05-06'],
        ['id' => 5, 'author_id' => 3, 'author_name' => 'Jon Author', 'title' => 'Memory Systems for Students', 'category' => 'Daily Challenges', 'summary' => 'A simple approach to notes, review cycles, and durable recall.', 'body' => 'A memory system is most useful when it is small enough to maintain. Short summaries, spaced review, and active recall can turn reading into retained knowledge.', 'file_path' => null, 'status' => 'published', 'created_at' => '2026-05-07'],
        ['id' => 6, 'author_id' => 3, 'author_name' => 'Jon Author', 'title' => 'Ethics in the Digital Age', 'category' => 'Philosophy', 'summary' => 'A beginner-friendly reading on privacy, platforms, and responsibility.', 'body' => 'Digital ethics asks how old moral questions change when decisions are automated, attention is monetized, and personal information becomes infrastructure.', 'file_path' => null, 'status' => 'published', 'created_at' => '2026-05-08'],
        ['id' => 7, 'author_id' => 3, 'author_name' => 'Jon Author', 'title' => 'Scientific Thinking Beyond the Lab', 'category' => 'Scientific Method', 'summary' => 'Applying hypothesis, evidence, and revision to everyday learning.', 'body' => 'Scientific thinking is not limited to laboratories. It is a habit of forming testable expectations, checking evidence, and revising beliefs without embarrassment.', 'file_path' => null, 'status' => 'published', 'created_at' => '2026-05-09'],
        ['id' => 8, 'author_id' => 3, 'author_name' => 'Jon Author', 'title' => 'The Architecture of Habit Formation', 'category' => 'Daily Challenges', 'summary' => 'Understanding cues, routines, rewards, and sustainable systems.', 'body' => 'Habits become easier when the environment supports them. Instead of relying only on willpower, learners can design cues and routines that make good actions easier to repeat.', 'file_path' => null, 'status' => 'published', 'created_at' => '2026-05-10'],
        ['id' => 9, 'author_id' => 3, 'author_name' => 'Jon Author', 'title' => 'How Arguments Become Clear', 'category' => 'Logic & Reason', 'summary' => 'A practical structure for claims, reasons, evidence, and objections.', 'body' => 'Clear arguments separate the claim from the reasons supporting it. Strong readers ask what evidence is offered and what reasonable objections might change the conclusion.', 'file_path' => null, 'status' => 'published', 'created_at' => '2026-05-11'],
        ['id' => 10, 'author_id' => 3, 'author_name' => 'Jon Author', 'title' => 'Archival Bias and Missing Voices', 'category' => 'Historical Archives', 'summary' => 'A short reading on why archives preserve some voices more than others.', 'body' => 'Archives are not neutral containers. They reflect choices, resources, power, and accident. Careful readers ask not only what is preserved, but what is absent.', 'file_path' => null, 'status' => 'published', 'created_at' => '2026-05-12'],
    ];

    $_SESSION['reports'] = [
        ['id' => 1, 'content_id' => 2, 'content_title' => 'Navigating Fallacies in Public Discourse', 'user_id' => 2, 'reporter_name' => 'Maya Reader', 'reason_category' => 'Misleading information', 'reason_text' => 'The example about public debate needs a clearer source reference.', 'status' => 'open', 'created_at' => '2026-05-08'],
    ];

    $_SESSION['author_requests'] = [
        ['id' => 1, 'user_id' => 4, 'user_name' => 'Nora Candidate', 'reason_text' => 'I want to contribute summaries from my study notes on archival methods.', 'status' => 'pending', 'reviewed_by' => null, 'created_at' => '2026-05-09'],
    ];

    $_SESSION['admin_feeds'] = [
        ['id' => 1, 'admin_id' => 1, 'title' => 'System Archival Process Enhanced', 'summary' => 'New review steps improve how curated content is organized and checked.', 'body' => 'The archive review flow now highlights pending reports and author submissions more clearly for administrators.', 'created_at' => '2026-05-06'],
        ['id' => 2, 'admin_id' => 1, 'title' => 'New Learning Footprint Metrics', 'summary' => 'Dashboard counts now summarize readers, authors, reports, and contents.', 'body' => 'The admin overview has been tuned for quick final-project demonstration and classroom review.', 'created_at' => '2026-05-07'],
        ['id' => 3, 'admin_id' => 1, 'title' => 'Scheduled Maintenance Window', 'summary' => 'A sample feed item for announcements and operational notices.', 'body' => 'Spring Wisdom can publish admin notices to both the home page and the dedicated updates page.', 'created_at' => '2026-05-10'],
    ];

    $_SESSION['messages'] = [
        ['id' => 1, 'sender_id' => 2, 'receiver_id' => 1, 'report_id' => null, 'content_id' => null, 'sender_name' => 'Maya Reader', 'receiver_name' => 'Admin Scholar', 'subject' => 'Question about saved readings', 'body' => 'Can bookmarked readings be exported later?', 'status' => 'new', 'reply_text' => '', 'replied_at' => null, 'created_at' => '2026-05-09'],
        ['id' => 2, 'sender_id' => 3, 'receiver_id' => 1, 'report_id' => 1, 'content_id' => 2, 'sender_name' => 'Jon Author', 'receiver_name' => 'Admin Scholar', 'subject' => 'File review request', 'body' => 'Please review the attached source file for the Stoic reading.', 'status' => 'read', 'reply_text' => '', 'replied_at' => null, 'created_at' => '2026-05-10'],
    ];

    $_SESSION['demo_seeded'] = true;
    $_SESSION['demo_seed_version'] = $seedVersion;
}

function table_rows(string $table): array
{
    seed_demo_data();
    return $_SESSION[$table] ?? [];
}

function next_id(string $table): int
{
    $rows = table_rows($table);
    return count($rows) === 0 ? 1 : max(array_column($rows, 'id')) + 1;
}

function cache_remember(string $key, int $ttlSeconds, callable $producer)
{
    $cache = $_SESSION['app_cache'][$key] ?? null;
    if (is_array($cache) && ($cache['expires_at'] ?? 0) >= time()) {
        return $cache['value'];
    }

    $value = $producer();
    $_SESSION['app_cache'][$key] = [
        'expires_at' => time() + $ttlSeconds,
        'value' => $value,
    ];
    return $value;
}

function clear_app_cache(): void
{
    unset($_SESSION['app_cache']);
}

function limited_sql(?int $limit, int $offset = 0): string
{
    if ($limit === null || $limit <= 0) {
        return '';
    }
    return ' limit ' . (int) $limit . ' offset ' . max(0, $offset);
}

function all_users(?string $role = null, ?int $limit = null, int $offset = 0): array
{
    if (using_database()) {
        $sql = 'select id, name, email, role, profile_pic_path, phone, institution, bio, settings_theme, email_notifications from users' . ($role ? ' where role = :role' : '') . ' order by id' . limited_sql($limit, $offset);
        $stmt = db()->prepare($sql);
        $stmt->execute($role ? ['role' => $role] : []);
        return $stmt->fetchAll();
    }
    $rows = array_values(array_filter(table_rows('users'), fn($u) => $role === null || $u['role'] === $role));
    return $limit ? array_slice($rows, $offset, $limit) : $rows;
}

function count_users(?string $role = null): int
{
    if (using_database()) {
        $sql = 'select count(*) from users' . ($role ? ' where role = :role' : '');
        $stmt = db()->prepare($sql);
        $stmt->execute($role ? ['role' => $role] : []);
        return (int) $stmt->fetchColumn();
    }
    return count(array_filter(table_rows('users'), fn($u) => $role === null || $u['role'] === $role));
}

function find_user_by_id(int $id): ?array
{
    if (using_database()) {
        $stmt = db()->prepare('select * from users where id = :id limit 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
    foreach (table_rows('users') as $user) {
        if ((int) $user['id'] === $id) {
            return $user;
        }
    }
    return null;
}

function find_user_by_email(string $email): ?array
{
    if (using_database()) {
        $stmt = db()->prepare('select * from users where email = :email limit 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }
    foreach (table_rows('users') as $user) {
        if (strcasecmp($user['email'], $email) === 0) {
            return $user;
        }
    }
    return null;
}

function find_user_by_role(string $role): ?array
{
    $users = all_users($role);
    return $users[0] ?? null;
}

function create_user(string $name, string $email, string $password): bool
{
    if (find_user_by_email($email)) {
        return false;
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    if (using_database()) {
        $stmt = db()->prepare('insert into users (name, email, password_hash, role) values (:name, :email, :hash, :role)');
        $created = $stmt->execute(['name' => $name, 'email' => $email, 'hash' => $hash, 'role' => 'user']);
        clear_app_cache();
        return $created;
    }
    $_SESSION['users'][] = ['id' => next_id('users'), 'name' => $name, 'email' => $email, 'password_hash' => $hash, 'role' => 'user', 'profile_pic_path' => null, 'phone' => '', 'institution' => '', 'bio' => '', 'settings_theme' => 'light', 'email_notifications' => true];
    clear_app_cache();
    return true;
}

function update_user_profile(int $id, array $data): void
{
    if (using_database()) {
        $picSql = array_key_exists('profile_pic_path', $data) ? ', profile_pic_path = :profile_pic_path' : '';
        $stmt = db()->prepare("update users set name = :name, phone = :phone, institution = :institution, bio = :bio{$picSql} where id = :id");
        $params = ['id' => $id, 'name' => $data['name'], 'phone' => $data['phone'], 'institution' => $data['institution'], 'bio' => $data['bio']];
        if (array_key_exists('profile_pic_path', $data)) {
            $params['profile_pic_path'] = $data['profile_pic_path'];
        }
        $stmt->execute($params);
        clear_app_cache();
        return;
    }
    foreach ($_SESSION['users'] as &$user) {
        if ((int) $user['id'] === $id) {
            $user = array_merge($user, $data);
        }
    }
    clear_app_cache();
}

function change_user_password(int $id, string $newPassword): void
{
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    if (using_database()) {
        $stmt = db()->prepare('update users set password_hash = :hash where id = :id');
        $stmt->execute(['hash' => $hash, 'id' => $id]);
        return;
    }
    foreach ($_SESSION['users'] as &$user) {
        if ((int) $user['id'] === $id) {
            $user['password_hash'] = $hash;
        }
    }
}

function update_user_settings(int $id, string $theme, bool $emailNotifications): void
{
    if (using_database()) {
        $stmt = db()->prepare('update users set settings_theme = :theme, email_notifications = :email where id = :id');
        $stmt->execute(['theme' => $theme, 'email' => $emailNotifications, 'id' => $id]);
        return;
    }
    foreach ($_SESSION['users'] as &$user) {
        if ((int) $user['id'] === $id) {
            $user['settings_theme'] = $theme;
            $user['email_notifications'] = $emailNotifications;
        }
    }
}

function set_user_role(int $id, string $role): void
{
    if (!in_array($role, ['user', 'author', 'admin'], true)) {
        return;
    }
    if (using_database()) {
        $stmt = db()->prepare('update users set role = :role where id = :id');
        $stmt->execute(['role' => $role, 'id' => $id]);
        clear_app_cache();
        return;
    }
    foreach ($_SESSION['users'] as &$user) {
        if ((int) $user['id'] === $id) {
            $user['role'] = $role;
        }
    }
    clear_app_cache();
}

function all_contents(bool $includeHidden = false, ?int $limit = null, int $offset = 0): array
{
    if (using_database()) {
        $where = $includeHidden ? '' : " where c.status = 'published'";
        $stmt = db()->query("select c.*, u.name as author_name from contents c join users u on u.id = c.author_id{$where} order by c.created_at desc" . limited_sql($limit, $offset));
        return $stmt->fetchAll();
    }
    $rows = array_values(array_filter(table_rows('contents'), fn($c) => $includeHidden || $c['status'] === 'published'));
    return $limit ? array_slice($rows, $offset, $limit) : $rows;
}

function content_by_id(int $id): ?array
{
    if (using_database()) {
        $stmt = db()->prepare('select c.*, u.name as author_name from contents c join users u on u.id = c.author_id where c.id = :id limit 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
    foreach (all_contents(true) as $content) {
        if ((int) $content['id'] === $id) {
            return $content;
        }
    }
    return null;
}

function create_content(int $authorId, array $data, ?string $filePath = null): int
{
    $data = normalize_content_data($data);
    if (using_database()) {
        $stmt = db()->prepare('insert into contents (author_id, title, category, summary, body, file_path, status) values (:author_id, :title, :category, :summary, :body, :file_path, :status) returning id');
        $stmt->execute(['author_id' => $authorId, 'title' => $data['title'], 'category' => $data['category'], 'summary' => $data['summary'], 'body' => $data['body'], 'file_path' => $filePath, 'status' => 'published']);
        clear_app_cache();
        return (int) $stmt->fetchColumn();
    }
    $id = next_id('contents');
    $author = array_values(array_filter(all_users(), fn($u) => (int) $u['id'] === $authorId))[0] ?? ['name' => 'Author'];
    $_SESSION['contents'][] = ['id' => $id, 'author_id' => $authorId, 'author_name' => $author['name'], 'title' => $data['title'], 'category' => $data['category'], 'summary' => $data['summary'], 'body' => $data['body'], 'file_path' => $filePath, 'status' => 'published', 'created_at' => date('Y-m-d')];
    clear_app_cache();
    return $id;
}

function update_content(int $id, array $data): void
{
    if (isset($data['title'], $data['category'], $data['summary'], $data['body'])) {
        $data = array_merge($data, normalize_content_data($data));
    }
    if (using_database()) {
        $fileSql = array_key_exists('file_path', $data) ? ', file_path = :file_path' : '';
        $stmt = db()->prepare("update contents set title = :title, category = :category, summary = :summary, body = :body{$fileSql}, updated_at = now() where id = :id");
        $params = ['id' => $id, 'title' => $data['title'], 'category' => $data['category'], 'summary' => $data['summary'], 'body' => $data['body']];
        if (array_key_exists('file_path', $data)) {
            $params['file_path'] = $data['file_path'];
        }
        $stmt->execute($params);
        clear_app_cache();
        return;
    }
    foreach ($_SESSION['contents'] as &$content) {
        if ((int) $content['id'] === $id) {
            $content = array_merge($content, $data);
        }
    }
    clear_app_cache();
}

function delete_content(int $id): void
{
    if (using_database()) {
        $stmt = db()->prepare('delete from contents where id = :id');
        $stmt->execute(['id' => $id]);
        clear_app_cache();
        return;
    }
    $_SESSION['contents'] = array_values(array_filter($_SESSION['contents'], fn($c) => (int) $c['id'] !== $id));
    clear_app_cache();
}

function set_content_status(int $id, string $status): void
{
    if (!in_array($status, ['published', 'hidden'], true)) {
        return;
    }
    if (using_database()) {
        $stmt = db()->prepare('update contents set status = :status where id = :id');
        $stmt->execute(['status' => $status, 'id' => $id]);
        clear_app_cache();
        return;
    }
    foreach ($_SESSION['contents'] as &$content) {
        if ((int) $content['id'] === $id) {
            $content['status'] = $status;
        }
    }
    clear_app_cache();
}

function all_feeds(?int $limit = null, int $offset = 0): array
{
    if (using_database()) {
        return db()->query('select * from admin_feeds order by created_at desc' . limited_sql($limit, $offset))->fetchAll();
    }
    $rows = array_reverse(table_rows('admin_feeds'));
    return $limit ? array_slice($rows, $offset, $limit) : $rows;
}

function count_feeds(): int
{
    if (using_database()) {
        return (int) db()->query('select count(*) from admin_feeds')->fetchColumn();
    }
    return count(table_rows('admin_feeds'));
}

function create_feed(int $adminId, array $data): void
{
    $data = [
        'title' => text_limit($data['title'] ?? '', 140),
        'summary' => text_limit($data['summary'] ?? '', 260),
        'body' => text_limit($data['body'] ?? '', 5000),
    ];
    if (using_database()) {
        $stmt = db()->prepare('insert into admin_feeds (admin_id, title, summary, body) values (:admin_id, :title, :summary, :body)');
        $stmt->execute(['admin_id' => $adminId, 'title' => $data['title'], 'summary' => $data['summary'], 'body' => $data['body']]);
        clear_app_cache();
        return;
    }
    $_SESSION['admin_feeds'][] = ['id' => next_id('admin_feeds'), 'admin_id' => $adminId, 'title' => $data['title'], 'summary' => $data['summary'], 'body' => $data['body'], 'created_at' => date('Y-m-d')];
    clear_app_cache();
}

function submit_report(int $contentId, int $userId, string $category, string $text): void
{
    if (!in_array($category, ['Misleading information', 'Plagiarism', 'Inappropriate content', 'Broken or incomplete content'], true)) {
        return;
    }
    $text = text_limit($text, 1200);
    $content = content_by_id($contentId);
    if (using_database()) {
        $stmt = db()->prepare('insert into reports (content_id, user_id, reason_category, reason_text, status) values (:content_id, :user_id, :category, :text, :status)');
        $stmt->execute(['content_id' => $contentId, 'user_id' => $userId, 'category' => $category, 'text' => $text, 'status' => 'open']);
        clear_app_cache();
        return;
    }
    $user = current_user();
    $_SESSION['reports'][] = ['id' => next_id('reports'), 'content_id' => $contentId, 'content_title' => $content['title'] ?? 'Content', 'user_id' => $userId, 'reporter_name' => $user['name'] ?? 'Reader', 'reason_category' => $category, 'reason_text' => $text, 'status' => 'open', 'created_at' => date('Y-m-d')];
    clear_app_cache();
}

function all_reports(?int $limit = null, int $offset = 0): array
{
    if (using_database()) {
        return db()->query('select r.*, c.title as content_title, c.author_id, au.name as author_name, u.name as reporter_name from reports r join contents c on c.id = r.content_id join users au on au.id = c.author_id join users u on u.id = r.user_id order by r.created_at desc' . limited_sql($limit, $offset))->fetchAll();
    }
    $rows = array_map(function ($report) {
        $content = content_by_id((int) $report['content_id']);
        $author = $content ? find_user_by_id((int) $content['author_id']) : null;
        $report['author_id'] = $content['author_id'] ?? null;
        $report['author_name'] = $author['name'] ?? 'Author';
        return $report;
    }, table_rows('reports'));
    return $limit ? array_slice($rows, $offset, $limit) : $rows;
}

function count_reports(): int
{
    if (using_database()) {
        return (int) db()->query('select count(*) from reports')->fetchColumn();
    }
    return count(table_rows('reports'));
}

function set_report_status(int $id, string $status): void
{
    if (!in_array($status, ['open', 'actioned', 'dismissed'], true)) {
        return;
    }
    if (using_database()) {
        $stmt = db()->prepare('update reports set status = :status where id = :id');
        $stmt->execute(['status' => $status, 'id' => $id]);
        clear_app_cache();
        return;
    }
    foreach ($_SESSION['reports'] as &$report) {
        if ((int) $report['id'] === $id) {
            $report['status'] = $status;
        }
    }
    clear_app_cache();
}

function submit_author_request(int $userId, string $reason): void
{
    $reason = text_limit($reason, 1200);
    if (using_database()) {
        $stmt = db()->prepare('insert into author_requests (user_id, reason_text, status) values (:user_id, :reason, :status)');
        $stmt->execute(['user_id' => $userId, 'reason' => $reason, 'status' => 'pending']);
        clear_app_cache();
        return;
    }
    $user = current_user();
    $_SESSION['author_requests'][] = ['id' => next_id('author_requests'), 'user_id' => $userId, 'user_name' => $user['name'] ?? 'User', 'reason_text' => $reason, 'status' => 'pending', 'reviewed_by' => null, 'created_at' => date('Y-m-d')];
    clear_app_cache();
}

function all_author_requests(?string $status = null, ?int $limit = null, int $offset = 0): array
{
    if (using_database()) {
        $sql = 'select ar.*, u.name as user_name from author_requests ar join users u on u.id = ar.user_id' . ($status ? ' where ar.status = :status' : '') . ' order by ar.created_at desc' . limited_sql($limit, $offset);
        $stmt = db()->prepare($sql);
        $stmt->execute($status ? ['status' => $status] : []);
        return $stmt->fetchAll();
    }
    $rows = array_values(array_filter(table_rows('author_requests'), fn($r) => $status === null || $r['status'] === $status));
    return $limit ? array_slice($rows, $offset, $limit) : $rows;
}

function count_author_requests(?string $status = null): int
{
    if (using_database()) {
        $sql = 'select count(*) from author_requests' . ($status ? ' where status = :status' : '');
        $stmt = db()->prepare($sql);
        $stmt->execute($status ? ['status' => $status] : []);
        return (int) $stmt->fetchColumn();
    }
    return count(array_filter(table_rows('author_requests'), fn($r) => $status === null || $r['status'] === $status));
}

function review_author_request(int $id, string $status, int $adminId): void
{
    if (!in_array($status, ['approved', 'rejected'], true)) {
        return;
    }
    if (using_database()) {
        $request = db()->prepare('select * from author_requests where id = :id');
        $request->execute(['id' => $id]);
        $row = $request->fetch();
        $stmt = db()->prepare('update author_requests set status = :status, reviewed_by = :admin where id = :id');
        $stmt->execute(['status' => $status, 'admin' => $adminId, 'id' => $id]);
        if ($status === 'approved' && $row) {
            set_user_role((int) $row['user_id'], 'author');
        }
        clear_app_cache();
        return;
    }
    foreach ($_SESSION['author_requests'] as &$request) {
        if ((int) $request['id'] === $id) {
            $request['status'] = $status;
            $request['reviewed_by'] = $adminId;
            if ($status === 'approved') {
                set_user_role((int) $request['user_id'], 'author');
            }
        }
    }
    clear_app_cache();
}

function all_messages(?int $limit = null, int $offset = 0): array
{
    if (using_database()) {
        return db()->query('select m.*, s.name as sender_name, r.name as receiver_name, c.title as content_title from messages m join users s on s.id = m.sender_id left join users r on r.id = m.receiver_id left join contents c on c.id = m.content_id order by m.created_at desc' . limited_sql($limit, $offset))->fetchAll();
    }
    $rows = table_rows('messages');
    return $limit ? array_slice($rows, $offset, $limit) : $rows;
}

function count_messages(): int
{
    if (using_database()) {
        return (int) db()->query('select count(*) from messages')->fetchColumn();
    }
    return count(table_rows('messages'));
}

function messages_for_user(int $userId, ?int $limit = null, int $offset = 0): array
{
    if (using_database()) {
        $stmt = db()->prepare('select m.*, s.name as sender_name, r.name as receiver_name, c.title as content_title from messages m join users s on s.id = m.sender_id left join users r on r.id = m.receiver_id left join contents c on c.id = m.content_id where m.sender_id = :id or m.receiver_id = :id order by m.created_at desc' . limited_sql($limit, $offset));
        $stmt->execute(['id' => $userId]);
        return $stmt->fetchAll();
    }
    $rows = array_values(array_filter(table_rows('messages'), fn($message) => (int) $message['sender_id'] === $userId || (int) ($message['receiver_id'] ?? 0) === $userId));
    return $limit ? array_slice($rows, $offset, $limit) : $rows;
}

function count_messages_for_user(int $userId): int
{
    if (using_database()) {
        $stmt = db()->prepare('select count(*) from messages where sender_id = :id or receiver_id = :id');
        $stmt->execute(['id' => $userId]);
        return (int) $stmt->fetchColumn();
    }
    return count(array_filter(table_rows('messages'), fn($message) => (int) $message['sender_id'] === $userId || (int) ($message['receiver_id'] ?? 0) === $userId));
}

function first_admin_user(): ?array
{
    return find_user_by_role('admin');
}

function create_message(int $senderId, ?int $receiverId, string $subject, string $body, ?int $reportId = null, ?int $contentId = null): void
{
    $subject = text_limit($subject, 160);
    $body = text_limit($body, 2400);
    if ($subject === '' || $body === '') {
        return;
    }
    if (using_database()) {
        $stmt = db()->prepare('insert into messages (sender_id, receiver_id, report_id, content_id, subject, body, status) values (:sender_id, :receiver_id, :report_id, :content_id, :subject, :body, :status)');
        $stmt->execute(['sender_id' => $senderId, 'receiver_id' => $receiverId, 'report_id' => $reportId, 'content_id' => $contentId, 'subject' => $subject, 'body' => $body, 'status' => 'new']);
        clear_app_cache();
        return;
    }
    $sender = find_user_by_id($senderId);
    $receiver = $receiverId ? find_user_by_id($receiverId) : null;
    $_SESSION['messages'][] = ['id' => next_id('messages'), 'sender_id' => $senderId, 'receiver_id' => $receiverId, 'report_id' => $reportId, 'content_id' => $contentId, 'sender_name' => $sender['name'] ?? 'User', 'receiver_name' => $receiver['name'] ?? 'Admin', 'subject' => $subject, 'body' => $body, 'status' => 'new', 'reply_text' => '', 'replied_at' => null, 'created_at' => date('Y-m-d')];
    clear_app_cache();
}

function update_message_status(int $id, string $status): void
{
    if (!in_array($status, ['new', 'read', 'resolved'], true)) {
        return;
    }
    if (using_database()) {
        $stmt = db()->prepare('update messages set status = :status where id = :id');
        $stmt->execute(['status' => $status, 'id' => $id]);
        clear_app_cache();
        return;
    }
    foreach ($_SESSION['messages'] as &$message) {
        if ((int) $message['id'] === $id) {
            $message['status'] = $status;
        }
    }
    clear_app_cache();
}

function reply_to_message(int $id, string $reply): void
{
    $reply = text_limit($reply, 2400);
    if ($reply === '') {
        return;
    }
    if (using_database()) {
        $stmt = db()->prepare("update messages set reply_text = :reply, replied_at = now(), status = 'resolved' where id = :id");
        $stmt->execute(['reply' => $reply, 'id' => $id]);
        clear_app_cache();
        return;
    }
    foreach ($_SESSION['messages'] as &$message) {
        if ((int) $message['id'] === $id) {
            $message['reply_text'] = $reply;
            $message['replied_at'] = date('Y-m-d');
            $message['status'] = 'resolved';
        }
    }
    clear_app_cache();
}

function dashboard_counts(): array
{
    return cache_remember('dashboard_counts', 30, function () {
        if (using_database()) {
            return [
                'users' => count_users('user'),
                'authors' => count_users('author'),
                'contents' => (int) db()->query('select count(*) from contents')->fetchColumn(),
                'reports' => count_reports(),
                'requests' => count_author_requests('pending'),
            ];
        }
        return [
            'users' => count(all_users('user')),
            'authors' => count(all_users('author')),
            'contents' => count(all_contents(true)),
            'reports' => count(all_reports()),
            'requests' => count(all_author_requests('pending')),
        ];
    });
}

function contents_for_author(int $authorId, bool $includeHidden = true): array
{
    if (using_database()) {
        $where = $includeHidden ? '' : " and c.status = 'published'";
        $stmt = db()->prepare("select c.*, u.name as author_name from contents c join users u on u.id = c.author_id where c.author_id = :author_id{$where} order by c.created_at desc");
        $stmt->execute(['author_id' => $authorId]);
        return $stmt->fetchAll();
    }
    return array_values(array_filter(all_contents($includeHidden), fn($content) => (int) $content['author_id'] === $authorId));
}

function content_categories(bool $includeHidden = false): array
{
    if (using_database()) {
        $where = $includeHidden ? '' : " where status = 'published'";
        return db()->query("select distinct category from contents{$where} order by category")->fetchAll(PDO::FETCH_COLUMN);
    }
    $categories = array_values(array_unique(array_map(fn($content) => $content['category'], all_contents($includeHidden))));
    sort($categories);
    return $categories;
}

function filtered_contents(string $category = '', int $authorId = 0, string $sort = 'newest', ?int $limit = null, int $offset = 0, bool $includeHidden = false): array
{
    if (using_database()) {
        $where = [];
        $params = [];
        if (!$includeHidden) {
            $where[] = "c.status = 'published'";
        }
        if ($category !== '') {
            $where[] = 'lower(c.category) = lower(:category)';
            $params['category'] = $category;
        }
        if ($authorId > 0) {
            $where[] = 'c.author_id = :author_id';
            $params['author_id'] = $authorId;
        }
        $whereSql = $where ? ' where ' . implode(' and ', $where) : '';
        $direction = $sort === 'oldest' ? 'asc' : 'desc';
        $stmt = db()->prepare("select c.*, u.name as author_name from contents c join users u on u.id = c.author_id{$whereSql} order by c.created_at {$direction}" . limited_sql($limit, $offset));
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    $rows = array_values(array_filter(all_contents($includeHidden), function ($content) use ($category, $authorId) {
        if ($category !== '' && strcasecmp((string) $content['category'], $category) !== 0) {
            return false;
        }
        return $authorId <= 0 || (int) $content['author_id'] === $authorId;
    }));
    usort($rows, function ($a, $b) use ($sort) {
        $aDate = strtotime((string) ($a['created_at'] ?? '')) ?: 0;
        $bDate = strtotime((string) ($b['created_at'] ?? '')) ?: 0;
        return $sort === 'oldest' ? $aDate <=> $bDate : $bDate <=> $aDate;
    });
    return $limit ? array_slice($rows, $offset, $limit) : $rows;
}

function count_filtered_contents(string $category = '', int $authorId = 0, bool $includeHidden = false): int
{
    if (using_database()) {
        $where = [];
        $params = [];
        if (!$includeHidden) {
            $where[] = "status = 'published'";
        }
        if ($category !== '') {
            $where[] = 'lower(category) = lower(:category)';
            $params['category'] = $category;
        }
        if ($authorId > 0) {
            $where[] = 'author_id = :author_id';
            $params['author_id'] = $authorId;
        }
        $whereSql = $where ? ' where ' . implode(' and ', $where) : '';
        $stmt = db()->prepare("select count(*) from contents{$whereSql}");
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }
    return count(filtered_contents($category, $authorId, 'newest', null, 0, $includeHidden));
}

function author_content_counts(): array
{
    if (using_database()) {
        $rows = db()->query('select author_id, count(*) as total from contents group by author_id')->fetchAll();
        $counts = [];
        foreach ($rows as $row) {
            $counts[(int) $row['author_id']] = (int) $row['total'];
        }
        return $counts;
    }
    $counts = [];
    foreach (all_contents(true) as $content) {
        $authorId = (int) $content['author_id'];
        $counts[$authorId] = ($counts[$authorId] ?? 0) + 1;
    }
    return $counts;
}

function content_analytics(): array
{
    return cache_remember('content_analytics', 30, function () {
        if (!using_database()) {
            $contents = all_contents(true);
            $published = array_values(array_filter($contents, fn($content) => ($content['status'] ?? '') === 'published'));
            $hidden = array_values(array_filter($contents, fn($content) => ($content['status'] ?? '') === 'hidden'));
            $categoryCounts = content_count_by_category($contents);
            return [
                'total' => count($contents),
                'published' => count($published),
                'hidden' => count($hidden),
                'categories_count' => count($categoryCounts),
                'authors_with_content' => count(array_unique(array_map(fn($content) => (int) $content['author_id'], $contents))),
                'latest_date' => latest_content_date($contents),
                'category_counts' => $categoryCounts,
                'date_counts' => content_count_by_date($contents),
            ];
        }

        $summary = db()->query("select count(*) as total, count(*) filter (where status = 'published') as published, count(*) filter (where status = 'hidden') as hidden, count(distinct category) as categories_count, count(distinct author_id) as authors_with_content, max(created_at)::date as latest_date from contents")->fetch();
        $categoryRows = db()->query('select category, count(*) as total from contents group by category order by category')->fetchAll();
        $dateRows = db()->query("select created_at::date as date, count(*) as total from contents group by created_at::date order by date")->fetchAll();
        $categoryCounts = [];
        foreach ($categoryRows as $row) {
            $categoryCounts[(string) $row['category']] = (int) $row['total'];
        }
        $dateCounts = [];
        foreach ($dateRows as $row) {
            $dateCounts[(string) $row['date']] = (int) $row['total'];
        }
        return [
            'total' => (int) ($summary['total'] ?? 0),
            'published' => (int) ($summary['published'] ?? 0),
            'hidden' => (int) ($summary['hidden'] ?? 0),
            'categories_count' => (int) ($summary['categories_count'] ?? 0),
            'authors_with_content' => (int) ($summary['authors_with_content'] ?? 0),
            'latest_date' => $summary['latest_date'] ?: 'No posts yet',
            'category_counts' => $categoryCounts,
            'date_counts' => $dateCounts,
        ];
    });
}

function content_count_by_category(array $contents): array
{
    $counts = [];
    foreach ($contents as $content) {
        $category = $content['category'] ?: 'Uncategorized';
        $counts[$category] = ($counts[$category] ?? 0) + 1;
    }
    ksort($counts);
    return $counts;
}

function content_count_by_date(array $contents): array
{
    $counts = [];
    foreach ($contents as $content) {
        $date = substr((string) ($content['created_at'] ?? date('Y-m-d')), 0, 10);
        $counts[$date] = ($counts[$date] ?? 0) + 1;
    }
    ksort($counts);
    return $counts;
}

function latest_content_date(array $contents): string
{
    $dates = array_filter(array_map(fn($content) => substr((string) ($content['created_at'] ?? ''), 0, 10), $contents));
    rsort($dates);
    return $dates[0] ?? 'No posts yet';
}

function text_limit(string $value, int $maxLength): string
{
    $value = trim($value);
    if (strlen($value) <= $maxLength) {
        return $value;
    }
    return trim(substr($value, 0, $maxLength));
}

function allowed_content_categories(): array
{
    return ['Historical Archives', 'Philosophy', 'Logic & Reason', 'Scientific Method', 'Literature Collections', 'Daily Challenges'];
}

function normalize_content_data(array $data): array
{
    $category = trim((string) ($data['category'] ?? ''));
    if (!in_array($category, allowed_content_categories(), true)) {
        $category = 'Historical Archives';
    }
    return [
        'title' => text_limit((string) ($data['title'] ?? ''), 140),
        'category' => $category,
        'summary' => text_limit((string) ($data['summary'] ?? ''), 260),
        'body' => text_limit((string) ($data['body'] ?? ''), 8000),
    ];
}
