create table users (
  id bigserial primary key,
  name text not null,
  email text not null unique,
  password_hash text not null,
  role text not null default 'user' check (role in ('user', 'author', 'admin')),
  profile_pic_path text,
  phone text,
  institution text,
  bio text,
  settings_theme text not null default 'light',
  email_notifications boolean not null default true,
  created_at timestamptz not null default now()
);

create table contents (
  id bigserial primary key,
  author_id bigint not null references users(id) on delete cascade,
  title text not null,
  category text not null,
  summary text not null,
  body text not null,
  file_path text,
  status text not null default 'published' check (status in ('published', 'hidden')),
  created_at timestamptz not null default now(),
  updated_at timestamptz
);

create table content_categories (
  id bigserial primary key,
  name text not null unique,
  description text,
  is_active boolean not null default true,
  sort_order integer not null default 0,
  created_at timestamptz not null default now(),
  updated_at timestamptz
);

create table reports (
  id bigserial primary key,
  content_id bigint not null references contents(id) on delete cascade,
  user_id bigint not null references users(id) on delete cascade,
  reason_category text not null,
  reason_text text not null,
  status text not null default 'open' check (status in ('open', 'actioned', 'dismissed')),
  created_at timestamptz not null default now()
);

create table author_requests (
  id bigserial primary key,
  user_id bigint not null references users(id) on delete cascade,
  reason_text text not null,
  status text not null default 'pending' check (status in ('pending', 'approved', 'rejected')),
  reviewed_by bigint references users(id),
  created_at timestamptz not null default now()
);

create table admin_feeds (
  id bigserial primary key,
  admin_id bigint not null references users(id) on delete cascade,
  title text not null,
  summary text not null,
  body text not null,
  created_at timestamptz not null default now()
);

create table messages (
  id bigserial primary key,
  sender_id bigint not null references users(id) on delete cascade,
  receiver_id bigint references users(id),
  report_id bigint references reports(id) on delete set null,
  content_id bigint references contents(id) on delete set null,
  subject text not null,
  body text not null,
  status text not null default 'new' check (status in ('new', 'read', 'resolved')),
  reply_text text,
  replied_at timestamptz,
  created_at timestamptz not null default now()
);

create index idx_users_role on users(role);
create index idx_content_categories_active_sort on content_categories(is_active, sort_order, name);
create index idx_contents_author_id on contents(author_id);
create index idx_contents_status_created_at on contents(status, created_at desc);
create index idx_reports_status_created_at on reports(status, created_at desc);
create index idx_author_requests_status_created_at on author_requests(status, created_at desc);
create index idx_messages_status_created_at on messages(status, created_at desc);

insert into content_categories (name, sort_order)
values
  ('Historical Archives', 10),
  ('Philosophy', 20),
  ('Logic & Reason', 30),
  ('Scientific Method', 40),
  ('Literature Collections', 50),
  ('Daily Challenges', 60)
on conflict (name) do nothing;
