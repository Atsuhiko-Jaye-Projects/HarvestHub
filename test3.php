<?php
// FitLife Gym - Navigation Structure
// Mobile-first PHP Application

$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
$current_sub = isset($_GET['sub']) ? $_GET['sub'] : '';
$current_detail = isset($_GET['detail']) ? $_GET['detail'] : '';

// Navigation Structure Data
$nav_structure = [
    'home' => [
        'label' => 'Home',
        'icon' => '⚡',
        'children' => [
            'dashboard' => [
                'label' => 'Dashboard',
                'icon' => '📊',
                'children' => [
                    'personal_bests'   => ['label' => 'Personal Bests',   'icon' => '🏆'],
                    'fitness_activity' => ['label' => 'Fitness Activity', 'icon' => '🔥'],
                    'achievements'     => ['label' => 'Achievements',     'icon' => '🎖️'],
                ]
            ],
            'workout_plans' => [
                'label' => 'Workout Plans',
                'icon' => '💪',
                'children' => [
                    'beginner_plans'    => ['label' => 'Beginner Plans',    'icon' => '🌱'],
                    'intermediate_plans'=> ['label' => 'Intermediate Plans','icon' => '⚙️'],
                    'advanced_plans'    => ['label' => 'Advanced Plans',    'icon' => '🚀'],
                    'custom_workouts'   => ['label' => 'Custom Workouts',   'icon' => '✏️'],
                ]
            ],
            'progress_tracker' => [
                'label' => 'Progress Tracker',
                'icon' => '📈',
                'children' => [
                    'workout_history' => ['label' => 'Workout History', 'icon' => '📅'],
                    'weight_bmi'      => ['label' => 'Weight & BMI',    'icon' => '⚖️'],
                ]
            ],
            'settings_profile' => [
                'label' => 'Settings & Profile',
                'icon' => '👤',
                'children' => [
                    'personal_info'    => ['label' => 'Personal Information',     'icon' => '🪪'],
                    'notifications'    => ['label' => 'Notification Preferences', 'icon' => '🔔'],
                    'subscription'     => [
                        'label' => 'Subscription Plan',
                        'icon'  => '💳',
                        'children' => [
                            'plan_details'      => ['label' => 'Plan Details',       'icon' => '📋'],
                            'payment_options'   => ['label' => 'Payment Options',    'icon' => '💰'],
                            'benefits'          => ['label' => 'Benefits & Inclusions','icon' => '🎁'],
                            'terms_conditions'  => ['label' => 'Terms & Conditions', 'icon' => '📜'],
                        ]
                    ],
                    'help_support' => ['label' => 'Help & Support', 'icon' => '🛟'],
                ]
            ],
        ]
    ]
];

function buildURL($page = '', $sub = '', $detail = '') {
    $params = ['page' => $page];
    if ($sub)    $params['sub']    = $sub;
    if ($detail) $params['detail'] = $detail;
    return '?' . http_build_query($params);
}

function getPageTitle($page, $sub, $detail, $nav) {
    if ($detail && $sub) {
        $children = $nav['home']['children'][$page]['children'][$sub]['children'] ?? [];
        return $children[$detail]['label'] ?? 'Detail';
    }
    if ($sub) return $nav['home']['children'][$page]['children'][$sub]['label'] ?? 'Section';
    if ($page && $page !== 'home') return $nav['home']['children'][$page]['label'] ?? 'Page';
    return 'FitLife Gym';
}

$pageTitle = getPageTitle($current_page, $current_sub, $current_detail, $nav_structure);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>FitLife Gym</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&family=Barlow+Condensed:wght@600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --bg-deep:   #0a0c0f;
    --bg-card:   #111418;
    --bg-panel:  #181c22;
    --accent:    #f04e23;
    --accent2:   #ffad00;
    --text:      #eef0f3;
    --muted:     #6a7280;
    --border:    #222830;
    --radius:    14px;
    --nav-h:     64px;
    --header-h:  58px;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; -webkit-tap-highlight-color: transparent; }

  body {
    background: var(--bg-deep);
    color: var(--text);
    font-family: 'Barlow', sans-serif;
    max-width: 430px;
    margin: 0 auto;
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
  }

  /* ── HEADER ── */
  .header {
    position: sticky; top: 0; z-index: 100;
    height: var(--header-h);
    background: rgba(10,12,15,.92);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 12px;
    padding: 0 16px;
  }
  .header .back-btn {
    width: 36px; height: 36px;
    border-radius: 50%; background: var(--bg-panel);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--text); text-decoration: none;
    font-size: 16px; flex-shrink: 0;
    transition: background .2s;
  }
  .header .back-btn:hover { background: var(--border); }
  .header .title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 20px; font-weight: 700;
    letter-spacing: .5px;
    flex: 1; text-align: center;
  }
  .header .logo-mark {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 22px; letter-spacing: 2px;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  }
  .spacer { width: 36px; flex-shrink: 0; }

  /* ── HERO (Home only) ── */
  .hero {
    margin: 16px; border-radius: var(--radius);
    background: linear-gradient(135deg, #1a1010 0%, #1a0d00 40%, #0f1520 100%);
    border: 1px solid #2a1a10;
    padding: 28px 20px 20px;
    position: relative; overflow: hidden;
  }
  .hero::before {
    content: ''; position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(240,78,35,.18) 0%, transparent 70%);
    pointer-events: none;
  }
  .hero-label {
    font-size: 11px; letter-spacing: 3px; text-transform: uppercase;
    color: var(--accent); font-weight: 600; margin-bottom: 8px;
  }
  .hero-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 42px; letter-spacing: 2px;
    line-height: 1; margin-bottom: 6px;
  }
  .hero-sub { font-size: 13px; color: var(--muted); }

  /* ── SECTION LABEL ── */
  .section-label {
    padding: 20px 16px 8px;
    font-size: 10px; letter-spacing: 3px;
    text-transform: uppercase; color: var(--muted); font-weight: 600;
  }

  /* ── NAV CARDS ── */
  .nav-grid {
    padding: 0 16px;
    display: grid; gap: 10px;
    grid-template-columns: 1fr 1fr;
  }
  .nav-grid.single { grid-template-columns: 1fr; }

  .nav-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 16px;
    text-decoration: none; color: var(--text);
    display: flex; align-items: center; gap: 12px;
    transition: all .2s; position: relative; overflow: hidden;
    cursor: pointer;
  }
  .nav-card::after {
    content: ''; position: absolute;
    inset: 0; background: linear-gradient(135deg, rgba(240,78,35,.06), transparent);
    opacity: 0; transition: opacity .2s;
  }
  .nav-card:hover::after, .nav-card:active::after { opacity: 1; }
  .nav-card:hover { border-color: rgba(240,78,35,.4); transform: translateY(-1px); }
  .nav-card:active { transform: scale(.98); }

  .nav-card .icon {
    width: 42px; height: 42px; border-radius: 10px;
    background: var(--bg-panel);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
  }
  .nav-card .info { flex: 1; min-width: 0; }
  .nav-card .info .name {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 15px; font-weight: 600;
    letter-spacing: .3px; line-height: 1.2;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .nav-card .info .sub-count {
    font-size: 11px; color: var(--muted); margin-top: 2px;
  }
  .nav-card .arrow {
    color: var(--muted); font-size: 12px; flex-shrink: 0;
  }

  /* Full-width card */
  .nav-card.full {
    grid-column: 1 / -1;
    flex-direction: row;
  }

  /* Accent card */
  .nav-card.accent {
    background: linear-gradient(135deg, rgba(240,78,35,.15), rgba(240,78,35,.05));
    border-color: rgba(240,78,35,.3);
  }
  .nav-card.accent .icon { background: rgba(240,78,35,.2); }

  /* ── LEAF PAGE ── */
  .leaf-page { padding: 16px; }
  .leaf-card {
    background: var(--bg-card); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 28px 20px; text-align: center;
  }
  .leaf-icon { font-size: 52px; margin-bottom: 12px; }
  .leaf-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 32px; letter-spacing: 2px; margin-bottom: 8px;
    background: linear-gradient(135deg, var(--text), var(--muted));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  }
  .leaf-desc { font-size: 13px; color: var(--muted); line-height: 1.6; }

  .badge-coming {
    display: inline-block; margin-top: 16px;
    font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
    color: var(--accent); background: rgba(240,78,35,.1);
    border: 1px solid rgba(240,78,35,.3);
    padding: 4px 12px; border-radius: 20px;
  }

  /* ── BREADCRUMB ── */
  .breadcrumb {
    padding: 8px 16px;
    display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    font-size: 11px; color: var(--muted);
  }
  .breadcrumb a { color: var(--muted); text-decoration: none; }
  .breadcrumb a:hover { color: var(--accent); }
  .breadcrumb .sep { color: var(--border); }
  .breadcrumb .current { color: var(--accent); font-weight: 600; }

  /* ── BOTTOM NAV ── */
  .bottom-nav {
    position: fixed; bottom: 0; left: 50%; transform: translateX(-50%);
    width: 100%; max-width: 430px;
    height: var(--nav-h);
    background: rgba(10,12,15,.95);
    backdrop-filter: blur(20px);
    border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-around;
    padding: 0 8px;
    z-index: 200;
  }
  .bnav-item {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; gap: 3px;
    text-decoration: none; color: var(--muted);
    padding: 8px 0;
    font-size: 10px; letter-spacing: .5px;
    transition: color .2s;
    font-weight: 600;
  }
  .bnav-item .bnav-icon { font-size: 22px; }
  .bnav-item.active { color: var(--accent); }
  .bnav-item:hover { color: var(--text); }

  /* ── SPACER ── */
  .page-spacer { height: calc(var(--nav-h) + 20px); }

  /* ── ANIMATIONS ── */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .anim { animation: fadeUp .3s ease both; }
  .anim:nth-child(1) { animation-delay: .04s; }
  .anim:nth-child(2) { animation-delay: .08s; }
  .anim:nth-child(3) { animation-delay: .12s; }
  .anim:nth-child(4) { animation-delay: .16s; }
  .anim:nth-child(5) { animation-delay: .20s; }
  .anim:nth-child(6) { animation-delay: .24s; }
</style>
</head>
<body>

<?php
// ── HEADER ──────────────────────────────────────────────
$showBack = ($current_page !== 'home' || $current_sub || $current_detail);

// Determine back URL
if ($current_detail && $current_sub) {
    $backURL = buildURL($current_page, $current_sub);
} elseif ($current_sub) {
    $backURL = buildURL($current_page);
} else {
    $backURL = buildURL('home');
}
?>
<header class="header">
  <?php if ($showBack): ?>
    <a href="<?= htmlspecialchars($backURL) ?>" class="back-btn">←</a>
    <span class="title"><?= htmlspecialchars($pageTitle) ?></span>
    <div class="spacer"></div>
  <?php else: ?>
    <span class="logo-mark">FITLIFE</span>
    <div class="title" style="color:var(--muted);font-size:13px">GYM APP</div>
    <div class="spacer"></div>
  <?php endif; ?>
</header>

<?php
// ── RENDER PAGE CONTENT ──────────────────────────────────

// HOME SCREEN
if ($current_page === 'home' && !$current_sub):
?>

<div class="hero anim">
  <div class="hero-label">Welcome Back</div>
  <div class="hero-title">FITLIFE<br>GYM</div>
  <div class="hero-sub">Your personal fitness hub — track, train &amp; transform.</div>
</div>

<div class="section-label">Main Navigation</div>
<div class="nav-grid">
  <?php
  $sections = $nav_structure['home']['children'];
  $i = 0;
  foreach ($sections as $key => $section):
    $childCount = isset($section['children']) ? count($section['children']) : 0;
    $isAccent = ($i === 0);
    $isFull   = ($i % 3 === 2);
    $class = 'nav-card anim' . ($isAccent ? ' accent' : '') . ($isFull ? ' full' : '');
  ?>
  <a href="<?= buildURL($key) ?>" class="<?= $class ?>">
    <div class="icon"><?= $section['icon'] ?></div>
    <div class="info">
      <div class="name"><?= htmlspecialchars($section['label']) ?></div>
      <div class="sub-count"><?= $childCount ?> sections</div>
    </div>
    <span class="arrow">›</span>
  </a>
  <?php $i++; endforeach; ?>
</div>

<?php
// LEVEL-2 PAGES (e.g. /dashboard, /workout_plans, etc.)
elseif ($current_page !== 'home' && !$current_sub && !$current_detail):
  $section = $nav_structure['home']['children'][$current_page] ?? null;
  if ($section):
    $children = $section['children'] ?? [];
?>

<div class="breadcrumb">
  <a href="<?= buildURL('home') ?>">Home</a>
  <span class="sep">›</span>
  <span class="current"><?= htmlspecialchars($section['label']) ?></span>
</div>

<div class="nav-grid single" style="margin-top:4px">
  <?php foreach ($children as $key => $child):
    $subCount = isset($child['children']) ? count($child['children']) : 0;
  ?>
  <a href="<?= buildURL($current_page, $key) ?>" class="nav-card anim">
    <div class="icon"><?= $child['icon'] ?></div>
    <div class="info">
      <div class="name"><?= htmlspecialchars($child['label']) ?></div>
      <?php if ($subCount): ?>
        <div class="sub-count"><?= $subCount ?> sub-options</div>
      <?php else: ?>
        <div class="sub-count">Tap to open</div>
      <?php endif; ?>
    </div>
    <span class="arrow">›</span>
  </a>
  <?php endforeach; ?>
</div>

  <?php endif; ?>

<?php
// LEVEL-3 PAGES (sub section)
elseif ($current_page && $current_sub && !$current_detail):
  $section = $nav_structure['home']['children'][$current_page] ?? null;
  $sub     = $section['children'][$current_sub] ?? null;
  if ($sub):
    $children = $sub['children'] ?? [];
?>

<div class="breadcrumb">
  <a href="<?= buildURL('home') ?>">Home</a>
  <span class="sep">›</span>
  <a href="<?= buildURL($current_page) ?>"><?= htmlspecialchars($section['label']) ?></a>
  <span class="sep">›</span>
  <span class="current"><?= htmlspecialchars($sub['label']) ?></span>
</div>

<?php if (!empty($children)): ?>
<div class="nav-grid single" style="margin-top:4px">
  <?php foreach ($children as $key => $child): ?>
  <a href="<?= buildURL($current_page, $current_sub, $key) ?>" class="nav-card anim">
    <div class="icon"><?= $child['icon'] ?></div>
    <div class="info">
      <div class="name"><?= htmlspecialchars($child['label']) ?></div>
      <div class="sub-count">Tap to view</div>
    </div>
    <span class="arrow">›</span>
  </a>
  <?php endforeach; ?>
</div>
<?php else: ?>
<div class="leaf-page anim">
  <div class="leaf-card">
    <div class="leaf-icon"><?= $sub['icon'] ?></div>
    <div class="leaf-title"><?= htmlspecialchars($sub['label']) ?></div>
    <div class="leaf-desc">This section lets you manage your <?= strtolower(htmlspecialchars($sub['label'])) ?> details and preferences.</div>
    <span class="badge-coming">Feature Screen</span>
  </div>
</div>
<?php endif; ?>

  <?php endif; ?>

<?php
// LEVEL-4 (deepest leaf)
elseif ($current_page && $current_sub && $current_detail):
  $section = $nav_structure['home']['children'][$current_page] ?? null;
  $sub     = $section['children'][$current_sub] ?? null;
  $detail  = $sub['children'][$current_detail] ?? null;
  if ($detail):
?>

<div class="breadcrumb">
  <a href="<?= buildURL('home') ?>">Home</a>
  <span class="sep">›</span>
  <a href="<?= buildURL($current_page) ?>"><?= htmlspecialchars($section['label']) ?></a>
  <span class="sep">›</span>
  <a href="<?= buildURL($current_page, $current_sub) ?>"><?= htmlspecialchars($sub['label']) ?></a>
  <span class="sep">›</span>
  <span class="current"><?= htmlspecialchars($detail['label']) ?></span>
</div>

<div class="leaf-page anim">
  <div class="leaf-card">
    <div class="leaf-icon"><?= $detail['icon'] ?></div>
    <div class="leaf-title"><?= htmlspecialchars($detail['label']) ?></div>
    <div class="leaf-desc">View and manage your <?= strtolower(htmlspecialchars($detail['label'])) ?> information here.</div>
    <span class="badge-coming">Feature Screen</span>
  </div>
</div>

  <?php endif; ?>

<?php endif; ?>

<div class="page-spacer"></div>

<!-- ── BOTTOM NAVIGATION ── -->
<nav class="bottom-nav">
  <a href="<?= buildURL('home') ?>" class="bnav-item <?= ($current_page==='home'&&!$current_sub)?'active':'' ?>">
    <span class="bnav-icon">🏠</span>HOME
  </a>
  <a href="<?= buildURL('workout_plans') ?>" class="bnav-item <?= ($current_page==='workout_plans')?'active':'' ?>">
    <span class="bnav-icon">💪</span>TRAIN
  </a>
  <a href="<?= buildURL('progress_tracker') ?>" class="bnav-item <?= ($current_page==='progress_tracker')?'active':'' ?>">
    <span class="bnav-icon">📈</span>TRACK
  </a>
  <a href="<?= buildURL('settings_profile') ?>" class="bnav-item <?= ($current_page==='settings_profile')?'active':'' ?>">
    <span class="bnav-icon">👤</span>PROFILE
  </a>
</nav>

</body>
</html>