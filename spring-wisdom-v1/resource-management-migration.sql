create table if not exists content_categories (
  id bigserial primary key,
  name text not null unique,
  description text,
  is_active boolean not null default true,
  sort_order integer not null default 0,
  created_at timestamptz not null default now(),
  updated_at timestamptz
);

create index if not exists idx_content_categories_active_sort
on content_categories(is_active, sort_order, name);

insert into content_categories (name, sort_order)
values
  ('Historical Archives', 10),
  ('Philosophy', 20),
  ('Logic & Reason', 30),
  ('Scientific Method', 40),
  ('Literature Collections', 50),
  ('Daily Challenges', 60)
on conflict (name) do nothing;

insert into content_categories (name, sort_order)
select distinct c.category, 100 + row_number() over (order by c.category) * 10
from contents c
where c.category is not null
  and trim(c.category) <> ''
  and not exists (
    select 1
    from content_categories cc
    where lower(cc.name) = lower(c.category)
  );
