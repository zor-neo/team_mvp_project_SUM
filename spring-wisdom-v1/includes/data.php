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
        ['id' => 1, 'sender_id' => 2, 'receiver_id' => 1, 'sender_name' => 'Maya Reader', 'subject' => 'Question about saved readings', 'body' => 'Can bookmarked readings be exported later?', 'status' => 'new', 'created_at' => '2026-05-09'],
        ['id' => 2, 'sender_id' => 3, 'receiver_id' => 1, 'sender_name' => 'Jon Author', 'subject' => 'File review request', 'body' => 'Please review the attached source file for the Stoic reading.', 'status' => 'read', 'created_at' => '2026-05-10'],
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

function all_users(?string $role = null): array
{
    if (using_database()) {
        $sql = 'select id, name, email, role, profile_pic_path, phone, institution, bio, settings_theme, email_notifications from users' . ($role ? ' where role = :role' : '') . ' order by id';
        $stmt = db()->prepare($sql);
        $stmt->execute($role ? ['role' => $role] : []);
        return $stmt->fetchAll();
    }
    return array_values(array_filter(table_rows('users'), fn($u) => $role === null || $u['role'] === $role));
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
        return $stmt->execute(['name' => $name, 'email' => $email, 'hash' => $hash, 'role' => 'user']);
    }
    $_SESSION['users'][] = ['id' => next_id('users'), 'name' => $name, 'email' => $email, 'password_hash' => $hash, 'role' => 'user', 'profile_pic_path' => null, 'phone' => '', 'institution' => '', 'bio' => '', 'settings_theme' => 'light', 'email_notifications' => true];
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
        return;
    }
    foreach ($_SESSION['users'] as &$user) {
        if ((int) $user['id'] === $id) {
            $user = array_merge($user, $data);
        }
    }
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
        return;
    }
    foreach ($_SESSION['users'] as &$user) {
        if ((int) $user['id'] === $id) {
            $user['role'] = $role;
        }
    }
}

function all_contents(bool $includeHidden = false): array
{
    if (using_database()) {
        $where = $includeHidden ? '' : " where c.status = 'published'";
        $stmt = db()->query("select c.*, u.name as author_name from contents c join users u on u.id = c.author_id{$where} order by c.created_at desc");
        return $stmt->fetchAll();
    }
    return array_values(array_filter(table_rows('contents'), fn($c) => $includeHidden || $c['status'] === 'published'));
}

function content_by_id(int $id): ?array
{
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
        return (int) $stmt->fetchColumn();
    }
    $id = next_id('contents');
    $author = array_values(array_filter(all_users(), fn($u) => (int) $u['id'] === $authorId))[0] ?? ['name' => 'Author'];
    $_SESSION['contents'][] = ['id' => $id, 'author_id' => $authorId, 'author_name' => $author['name'], 'title' => $data['title'], 'category' => $data['category'], 'summary' => $data['summary'], 'body' => $data['body'], 'file_path' => $filePath, 'status' => 'published', 'created_at' => date('Y-m-d')];
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
        return;
    }
    foreach ($_SESSION['contents'] as &$content) {
        if ((int) $content['id'] === $id) {
            $content = array_merge($content, $data);
        }
    }
}

function delete_content(int $id): void
{
    if (using_database()) {
        $stmt = db()->prepare('delete from contents where id = :id');
        $stmt->execute(['id' => $id]);
        return;
    }
    $_SESSION['contents'] = array_values(array_filter($_SESSION['contents'], fn($c) => (int) $c['id'] !== $id));
}

function set_content_status(int $id, string $status): void
{
    if (!in_array($status, ['published', 'hidden'], true)) {
        return;
    }
    if (using_database()) {
        $stmt = db()->prepare('update contents set status = :status where id = :id');
        $stmt->execute(['status' => $status, 'id' => $id]);
        return;
    }
    foreach ($_SESSION['contents'] as &$content) {
        if ((int) $content['id'] === $id) {
            $content['status'] = $status;
        }
    }
}

function all_feeds(): array
{
    if (using_database()) {
        return db()->query('select * from admin_feeds order by created_at desc')->fetchAll();
    }
    return array_reverse(table_rows('admin_feeds'));
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
        return;
    }
    $_SESSION['admin_feeds'][] = ['id' => next_id('admin_feeds'), 'admin_id' => $adminId, 'title' => $data['title'], 'summary' => $data['summary'], 'body' => $data['body'], 'created_at' => date('Y-m-d')];
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
        return;
    }
    $user = current_user();
    $_SESSION['reports'][] = ['id' => next_id('reports'), 'content_id' => $contentId, 'content_title' => $content['title'] ?? 'Content', 'user_id' => $userId, 'reporter_name' => $user['name'] ?? 'Reader', 'reason_category' => $category, 'reason_text' => $text, 'status' => 'open', 'created_at' => date('Y-m-d')];
}

function all_reports(): array
{
    if (using_database()) {
        return db()->query('select r.*, c.title as content_title, u.name as reporter_name from reports r join contents c on c.id = r.content_id join users u on u.id = r.user_id order by r.created_at desc')->fetchAll();
    }
    return table_rows('reports');
}

function set_report_status(int $id, string $status): void
{
    if (!in_array($status, ['open', 'actioned', 'dismissed'], true)) {
        return;
    }
    if (using_database()) {
        $stmt = db()->prepare('update reports set status = :status where id = :id');
        $stmt->execute(['status' => $status, 'id' => $id]);
        return;
    }
    foreach ($_SESSION['reports'] as &$report) {
        if ((int) $report['id'] === $id) {
            $report['status'] = $status;
        }
    }
}

function submit_author_request(int $userId, string $reason): void
{
    $reason = text_limit($reason, 1200);
    if (using_database()) {
        $stmt = db()->prepare('insert into author_requests (user_id, reason_text, status) values (:user_id, :reason, :status)');
        $stmt->execute(['user_id' => $userId, 'reason' => $reason, 'status' => 'pending']);
        return;
    }
    $user = current_user();
    $_SESSION['author_requests'][] = ['id' => next_id('author_requests'), 'user_id' => $userId, 'user_name' => $user['name'] ?? 'User', 'reason_text' => $reason, 'status' => 'pending', 'reviewed_by' => null, 'created_at' => date('Y-m-d')];
}

function all_author_requests(): array
{
    if (using_database()) {
        return db()->query('select ar.*, u.name as user_name from author_requests ar join users u on u.id = ar.user_id order by ar.created_at desc')->fetchAll();
    }
    return table_rows('author_requests');
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
}

function all_messages(): array
{
    if (using_database()) {
        return db()->query('select m.*, u.name as sender_name from messages m join users u on u.id = m.sender_id order by m.created_at desc')->fetchAll();
    }
    return table_rows('messages');
}

function dashboard_counts(): array
{
    return [
        'users' => count(all_users('user')),
        'authors' => count(all_users('author')),
        'contents' => count(all_contents(true)),
        'reports' => count(all_reports()),
        'requests' => count(array_filter(all_author_requests(), fn($r) => $r['status'] === 'pending')),
    ];
}

function contents_for_author(int $authorId, bool $includeHidden = true): array
{
    return array_values(array_filter(all_contents($includeHidden), fn($content) => (int) $content['author_id'] === $authorId));
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
