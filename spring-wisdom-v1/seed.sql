insert into users (name, email, password_hash, role, institution, bio)
values
  (
    'Jon Author',
    'jon.author@spring.test',
    '$2y$12$3GVSfzhRK6HL8.3tKpnsguwBxr2cUSl5VBUcnBWkyKhAgIyG8ucEi',
    'author',
    'Archive Faculty',
    'Writes short educational readings on philosophy and research habits.'
  ),
  (
    'Mira Chen',
    'mira.chen@spring.test',
    '$2y$12$3GVSfzhRK6HL8.3tKpnsguwBxr2cUSl5VBUcnBWkyKhAgIyG8ucEi',
    'author',
    'Humanities Reading Circle',
    'Curates readings on history, sources, and student reflection.'
  ),
  (
    'Sam Rivera',
    'sam.rivera@spring.test',
    '$2y$12$3GVSfzhRK6HL8.3tKpnsguwBxr2cUSl5VBUcnBWkyKhAgIyG8ucEi',
    'author',
    'Science Learning Lab',
    'Creates accessible notes on scientific reasoning and study systems.'
  ),
  (
    'Maya Reader',
    'maya.reader@spring.test',
    '$2y$12$3GVSfzhRK6HL8.3tKpnsguwBxr2cUSl5VBUcnBWkyKhAgIyG8ucEi',
    'user',
    'Student',
    'Interested in careful reading and structured knowledge.'
  ),
  (
    'Nora Candidate',
    'nora.candidate@spring.test',
    '$2y$12$3GVSfzhRK6HL8.3tKpnsguwBxr2cUSl5VBUcnBWkyKhAgIyG8ucEi',
    'user',
    'Student Research Club',
    'Preparing to request author access for archive summaries.'
  ),
  (
    'Leo Tan',
    'leo.tan@spring.test',
    '$2y$12$3GVSfzhRK6HL8.3tKpnsguwBxr2cUSl5VBUcnBWkyKhAgIyG8ucEi',
    'user',
    'Independent Learner',
    'Uses Spring Wisdom for daily reading practice.'
  )
on conflict (email) do update set
  name = excluded.name,
  role = excluded.role,
  institution = excluded.institution,
  bio = excluded.bio;

with seed_contents (author_email, title, category, summary, body, created_at) as (
  values
    (
      'jon.author@spring.test',
      'Stoic Resilience in Digital Learning',
      'Philosophy',
      'A focused reading on calm attention and durable learning habits.',
      'Stoic practice asks learners to separate what can be controlled from what cannot. In a digital study space, this becomes a practical method for protecting attention, questioning distractions, and returning to thoughtful work after interruption. The goal is not emotional silence, but steadier judgment.',
      '2026-05-01 09:00:00+00'::timestamptz
    ),
    (
      'jon.author@spring.test',
      'Navigating Fallacies in Public Discourse',
      'Logic & Reason',
      'A practical guide to spotting common reasoning errors in media.',
      'Logical fallacies often appear convincing because they borrow the shape of argument without providing its substance. Readers improve judgment by identifying unsupported conclusions, false dilemmas, and appeals to emotion. A careful reader asks what claim is being made, what evidence supports it, and what alternative explanation might fit.',
      '2026-05-02 09:00:00+00'::timestamptz
    ),
    (
      'sam.rivera@spring.test',
      'The Evolution of the Scientific Method',
      'Scientific Method',
      'A short historical overview of observation, testing, and revision.',
      'The scientific method did not appear fully formed. It developed through centuries of debate about evidence, repeatability, measurement, and the limits of authority. Its strength is not certainty, but disciplined correction: claims are tested, errors are named, and better explanations replace weaker ones.',
      '2026-05-03 09:00:00+00'::timestamptz
    ),
    (
      'mira.chen@spring.test',
      'Reading Primary Sources with Care',
      'Historical Archives',
      'How to approach old documents without losing context or nuance.',
      'Primary sources reward patience. A useful reading practice begins with identifying the creator, intended audience, historical setting, and what the document leaves unsaid. The best archive reading combines curiosity with caution, because every preserved source has a context and a boundary.',
      '2026-05-04 09:00:00+00'::timestamptz
    ),
    (
      'sam.rivera@spring.test',
      'Memory Systems for Students',
      'Daily Challenges',
      'A simple approach to notes, review cycles, and durable recall.',
      'A memory system is most useful when it is small enough to maintain. Short summaries, spaced review, and active recall can turn reading into retained knowledge. Students do not need a complex tool first; they need a repeatable habit that brings important ideas back at the right time.',
      '2026-05-05 09:00:00+00'::timestamptz
    ),
    (
      'jon.author@spring.test',
      'Ethics in the Digital Age',
      'Philosophy',
      'A beginner-friendly reading on privacy, platforms, and responsibility.',
      'Digital ethics asks how old moral questions change when decisions are automated, attention is monetized, and personal information becomes infrastructure. The central habit is to notice who benefits, who is exposed to risk, and what choices remain available to ordinary users.',
      '2026-05-06 09:00:00+00'::timestamptz
    ),
    (
      'sam.rivera@spring.test',
      'Scientific Thinking Beyond the Lab',
      'Scientific Method',
      'Applying hypothesis, evidence, and revision to everyday learning.',
      'Scientific thinking is not limited to laboratories. It is a habit of forming testable expectations, checking evidence, and revising beliefs without embarrassment. Students can use the same pattern when reading claims, comparing sources, or planning a project.',
      '2026-05-07 09:00:00+00'::timestamptz
    ),
    (
      'sam.rivera@spring.test',
      'The Architecture of Habit Formation',
      'Daily Challenges',
      'Understanding cues, routines, rewards, and sustainable systems.',
      'Habits become easier when the environment supports them. Instead of relying only on willpower, learners can design cues and routines that make good actions easier to repeat. A strong study habit often begins as a small visible action placed in the right context.',
      '2026-05-08 09:00:00+00'::timestamptz
    ),
    (
      'jon.author@spring.test',
      'How Arguments Become Clear',
      'Logic & Reason',
      'A practical structure for claims, reasons, evidence, and objections.',
      'Clear arguments separate the claim from the reasons supporting it. Strong readers ask what evidence is offered, what assumptions are hidden, and what reasonable objections might change the conclusion. Clarity is not decoration; it is the condition that allows disagreement to become useful.',
      '2026-05-09 09:00:00+00'::timestamptz
    ),
    (
      'mira.chen@spring.test',
      'Archival Bias and Missing Voices',
      'Historical Archives',
      'Why archives preserve some voices more than others.',
      'Archives are not neutral containers. They reflect choices, resources, power, and accident. Careful readers ask not only what is preserved, but what is absent. Missing voices can be as important as visible records when students interpret the past.',
      '2026-05-10 09:00:00+00'::timestamptz
    ),
    (
      'mira.chen@spring.test',
      'Footnotes as Reading Maps',
      'Historical Archives',
      'How references guide readers through evidence and debate.',
      'Footnotes are more than formal decoration. They show where claims came from, what conversations shaped them, and where a reader can continue investigating. Learning to follow notes turns a single article into a map of evidence, context, and scholarly disagreement.',
      '2026-05-11 09:00:00+00'::timestamptz
    ),
    (
      'jon.author@spring.test',
      'Questions That Improve Discussion',
      'Logic & Reason',
      'A guide to asking better questions during group learning.',
      'Good questions slow the room down in productive ways. Instead of asking only whether an answer is right, students can ask what evidence supports it, what definition is being used, and what example would test the idea. Discussion improves when questions invite precision.',
      '2026-05-12 09:00:00+00'::timestamptz
    ),
    (
      'sam.rivera@spring.test',
      'Observation Before Explanation',
      'Scientific Method',
      'Why careful observation should come before confident conclusions.',
      'Beginners often rush toward explanation before looking closely enough. Scientific practice begins with patient observation: what is happening, what can be measured, and what might be influencing the result. A better explanation usually grows from better noticing.',
      '2026-05-13 09:00:00+00'::timestamptz
    ),
    (
      'mira.chen@spring.test',
      'The Reader as Curator',
      'Daily Challenges',
      'A practical note on choosing, saving, and revisiting useful readings.',
      'Every reader gradually becomes a curator. The challenge is deciding what deserves attention now, what should be saved for later, and what can be released. A healthy reading habit includes selection, reflection, and periodic review instead of endless collection.',
      '2026-05-14 09:00:00+00'::timestamptz
    ),
    (
      'jon.author@spring.test',
      'Wisdom Traditions and Modern Study',
      'Philosophy',
      'Connecting older wisdom practices with present-day learning habits.',
      'Wisdom traditions often treat learning as a way of shaping attention, character, and judgment. Modern students can borrow this view without becoming less practical. Reading becomes stronger when it is connected to reflection, action, and the habits that shape daily life.',
      '2026-05-15 09:00:00+00'::timestamptz
    )
)
insert into contents (author_id, title, category, summary, body, status, created_at)
select u.id, sc.title, sc.category, sc.summary, sc.body, 'published', sc.created_at
from seed_contents sc
join users u on u.email = sc.author_email
where not exists (
  select 1 from contents c where c.title = sc.title
);
