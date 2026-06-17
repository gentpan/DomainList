<?php
require_once __DIR__ . '/../app/lang.php';

function admin_header(string $title): void
{
    $safeTitle = h($title);
    $current = basename($_SERVER['SCRIPT_NAME'] ?? '');
    $content = read_json('content.json', []);
    $siteSettings = is_array($content['site_settings'] ?? null) ? $content['site_settings'] : [];
    $adminBrandName = trim((string)($siteSettings['site_name'] ?? '')) ?: '://domain.ls';

    $navItems = [
        'domains.php' => __('domain_management'),
        'display_settings.php' => __('display_settings'),
        'home_welcome.php' => __('home_welcome'),
        'categories.php' => __('categories'),
        'suffixes.php' => __('suffixes'),
        'mail_settings.php' => __('mail_settings'),
        'site_settings.php' => __('site_settings'),
    ];
    $navIcons = [
        'domains.php' => 'fa-light fa-grid-2',
        'display_settings.php' => 'fa-light fa-table-cells',
        'home_welcome.php' => 'fa-light fa-panorama',
        'categories.php' => 'fa-light fa-tags',
        'suffixes.php' => 'fa-light fa-globe',
        'mail_settings.php' => 'fa-light fa-envelope-open-text',
        'site_settings.php' => 'fa-light fa-sliders',
    ];
    $pageDescriptions = [
        'domains.php' => current_lang() === 'zh' ? '管理域名库存、WHOIS信息与上架状态，支持筛选与分页。' : 'Manage domain inventory, WHOIS info and listing status with filtering and pagination.',
        'display_settings.php' => current_lang() === 'zh' ? '控制前台布局参数、卡片样式与每页展示数量。' : 'Control frontend layout, card style and items per page.',
        'home_welcome.php' => current_lang() === 'zh' ? '编辑首页推荐区与 Welcome 展示内容，支持图文两种模式。' : 'Edit homepage featured section and Welcome content with text/image modes.',
        'categories.php' => current_lang() === 'zh' ? '维护关键词分类体系，支持新增与删除并同步域名关联。' : 'Maintain keyword category system with add/delete and domain sync.',
        'suffixes.php' => current_lang() === 'zh' ? '维护域名后缀列表与说明信息，统一筛选条件。' : 'Maintain domain suffix list and descriptions for unified filtering.',
        'mail_settings.php' => current_lang() === 'zh' ? '配置留言邮件通道、SMTP参数并进行发送测试。' : 'Configure contact email channel, SMTP settings and send test.',
        'site_settings.php' => current_lang() === 'zh' ? '配置站点名称、标题与元信息，并维护后台安全密码。' : 'Configure site name, title, meta info and admin password security.',
    ];
    $contextIcon = $navIcons[$current] ?? 'fa-light fa-gear';
    $contextDesc = $pageDescriptions[$current] ?? current_lang() === 'zh' ? '后台配置项管理与状态维护。' : 'Backend configuration management and status maintenance.';

    $navHtml = '';
    $idx = 0;
    foreach ($navItems as $file => $label) {
        $idx++;
        $inputId = 'admin-nav-' . $idx;
        $checked = $current === $file ? 'checked' : '';
        $url = '/admin/' . $file;
        $icon = $navIcons[$file] ?? 'fa-light fa-circle';
        $navHtml .= '<input type="radio" name="admin-nav" id="' . $inputId . '" ' . $checked . '>';
        $navHtml .= '<label class="admin-nav-label" for="' . $inputId . '" data-href="' . h($url) . '" role="link" tabindex="0">';
        $navHtml .= '<i class="admin-nav-icon ' . h($icon) . '" aria-hidden="true"></i>';
        $navHtml .= '<span>' . h($label) . '</span>';
        $navHtml .= '</label>';
    }
    $navCount = count($navItems);

    echo <<<HTML
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$safeTitle} - 域名管理</title>
    <link rel="stylesheet" href="https://icons.bluecdn.com/fontawesome-pro/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-brand">
            <div class="admin-brand-row">
                <a class="admin-brand-link" href="/admin/domains.php">{$adminBrandName}</a>
            </div>
        </div>
        <nav class="admin-nav">
            <div class="radio-container" style="--total-radio: {$navCount};">
                {$navHtml}
                <div class="glider-container" aria-hidden="true">
                    <div class="glider"></div>
                </div>
            </div>
        </nav>
        <div class="admin-content-loader" id="adminContentLoader" aria-hidden="true">
            <div class="admin-content-loader-core"></div>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" id="adminMenuToggle"><i class="fa-light fa-bars"></i> <?php echo __('domains'); ?></button>
            <div class="admin-topbar-main">
                <h1 class="admin-title h4 mb-0"><i class="fa-light fa-sparkles"></i> <?php echo __('admin_panel'); ?></h1>
                <div class="admin-title-sub">Management Console</div>
            </div>
            <a class="admin-topbar-logout" href="/admin/logout.php"><i class="fa-light fa-right-from-bracket"></i><span><?php echo __('logout'); ?></span></a>
        </header>
        <main class="admin-content">
            <section class="admin-content-context">
                <div class="admin-context-icon"><i class="{$contextIcon}" aria-hidden="true"></i></div>
                <div class="admin-context-meta">
                    <div class="admin-context-title">{$safeTitle}</div>
                    <div class="admin-context-desc">{$contextDesc}</div>
                </div>
            </section>
            <div class="admin-page-stack">
HTML;
}

function admin_footer(): void
{
    echo <<<HTML
</div>
</main>
        <footer class="admin-footer">
            <small>© 2026 DOMAIN.LS Admin Console</small>
            <small>JSON Storage · Whois Parse · Mail Gateway</small>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        var btn = document.getElementById('adminMenuToggle');
        var sidebar = document.getElementById('adminSidebar');
        var loader = document.getElementById('adminContentLoader');
        var content = document.querySelector('.admin-content');
        var navLabels = Array.prototype.slice.call(document.querySelectorAll('.admin-nav-label[data-href]'));
        var switching = false;
        var currentPath = window.location.pathname + window.location.search;

        if (btn && sidebar) {
            btn.addEventListener('click', function () {
                sidebar.classList.toggle('show');
            });
        }

        function normalizeHref(href) {
            try {
                var url = new URL(href, window.location.origin);
                return url.pathname + url.search;
            } catch (e) {
                return href;
            }
        }

        function setActiveNav(href) {
            var normalized = normalizeHref(href);
            navLabels.forEach(function (label) {
                var labelHref = normalizeHref(label.getAttribute('data-href') || '');
                if (labelHref === normalized) {
                    var id = label.getAttribute('for');
                    var input = id ? document.getElementById(id) : null;
                    if (input) input.checked = true;
                }
            });
        }

        function showLoader() {
            if (loader) loader.classList.add('show');
        }

        function hideLoader() {
            if (loader) loader.classList.remove('show');
        }

        function enterContent() {
            if (!content) return;
            content.classList.remove('is-leaving');
            content.classList.add('is-entering');
            window.setTimeout(function () {
                content.classList.remove('is-entering');
            }, 320);
        }

        function leaveContent() {
            if (!content) return;
            content.classList.remove('is-entering');
            content.classList.add('is-leaving');
        }

        async function switchPage(href, pushHistory) {
            if (!content || switching) return;
            var target = normalizeHref(href);
            if (!target || target === currentPath) return;

            switching = true;
            showLoader();
            leaveContent();

            try {
                await new Promise(function (resolve) { window.setTimeout(resolve, 180); });
                var response = await fetch(target, {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!response.ok) {
                    window.location.assign(target);
                    return;
                }
                var html = await response.text();
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var nextContent = doc.querySelector('.admin-content');

                if (!nextContent) {
                    window.location.assign(target);
                    return;
                }

                content.innerHTML = nextContent.innerHTML;
                if (doc.title) {
                    document.title = doc.title;
                }

                currentPath = target;
                setActiveNav(target);
                if (pushHistory) {
                    history.pushState({ href: target }, '', target);
                }
                if (sidebar && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
                enterContent();
            } catch (error) {
                window.location.assign(target);
            } finally {
                hideLoader();
                switching = false;
            }
        }

        navLabels.forEach(function (label) {
            var go = function () {
                var href = label.getAttribute('data-href');
                if (!href) return;
                switchPage(href, true);
            };

            label.addEventListener('click', function () {
                go();
            });

            label.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    go();
                }
            });
        });

        document.addEventListener('click', function (event) {
            var anchor = event.target.closest('a[href]');
            if (!anchor) return;
            if (anchor.target && anchor.target !== '_self') return;
            if (anchor.hasAttribute('download')) return;
            if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

            var href = anchor.getAttribute('href') || '';
            if (!href.startsWith('/admin/')) return;
            if (href === '/admin/logout.php') return;

            event.preventDefault();
            switchPage(href, true);
        });

        window.addEventListener('popstate', function () {
            switchPage(window.location.pathname + window.location.search, false);
        });
    })();
</script>
</body>
</html>
HTML;
}
