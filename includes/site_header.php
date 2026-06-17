<?php
require_once __DIR__ . '/../app/lang.php';
$siteTitle = $siteSettings['site_title'] ?? 'DOMAIN.LS';
$siteDescription = $siteSettings['site_description'] ?? '';
$logoSubtitle = $siteSettings['logo_subtitle'] ?? 'PREMIUM DOMAIN COLLECTION';
$siteName = $siteSettings['site_name'] ?? '://domain.ls';
$isHomePage = isset($view) && $view === 'home';
$pageTitle = $siteTitle !== '' ? $siteTitle : 'domain.ls' . __('site_title_suffix');
$lang = current_lang();
?>
<!doctype html>
<html lang="<?php echo $lang === 'zh' ? 'zh-CN' : 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo h($siteDescription); ?>">
    <title><?php echo h($pageTitle); ?></title>
    <link rel="stylesheet" href="https://icons.bluecdn.com/fontawesome-pro/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/site.css">
</head>
<body class="page-loading">
    <div class="initial-page-loader" id="initialPageLoader" aria-live="polite" aria-label="<?php echo __('loading'); ?>">
        <div class="initial-page-loader-modal">
            <div class="initial-page-loader-spinner"></div>
        </div>
    </div>
    <div class="page-corner-loader" id="pageCornerLoader" aria-hidden="true">
        <div class="page-corner-loader-spinner"></div>
    </div>
    <script>
        (function () {
            var body = document.body;
            var isHomePage = <?php echo $isHomePage ? 'true' : 'false'; ?>;
            var useFullscreen = false;

            try {
                var hasVisitedHome = sessionStorage.getItem('domainls_home_visited') === '1';
                var navEntries = (performance && performance.getEntriesByType) ? performance.getEntriesByType('navigation') : [];
                var navType = (navEntries && navEntries[0] && navEntries[0].type) ? navEntries[0].type : '';
                var isHomeReload = isHomePage && navType === 'reload';

                useFullscreen = isHomePage && (!hasVisitedHome || isHomeReload);

                if (isHomePage) {
                    sessionStorage.setItem('domainls_home_visited', '1');
                }
            } catch (e) {
                useFullscreen = isHomePage;
            }

            body.classList.add(useFullscreen ? 'page-loading-mode-fullscreen' : 'page-loading-mode-corner');
        })();
    </script>
    <div class="top-bar">
        <div class="top-bar-container">
            <a class="top-brand" href="/" aria-label="DOMAIN.LS <?php echo __('home'); ?>">
                <span class="top-brand-text">
                    <span class="top-brand-title"><?php echo h($siteName); ?></span>
                </span>
            </a>
            <nav class="top-nav">
                <a href="/"><?php echo __('home'); ?></a>
                <a href="/#domains"><?php echo __('domains'); ?></a>
                <a href="/whois"><?php echo __('whois'); ?></a>
                <a href="/contact"><?php echo __('contact'); ?></a>
            </nav>
            <div class="top-subtitle-right"><?php echo h($logoSubtitle); ?></div>
            <div class="lang-switcher" style="margin-left: auto; display: flex; gap: 8px; align-items: center; font-size: 13px;">
                <a href="javascript:void(0)" onclick="setLang('zh')" style="text-decoration: none; color: <?php echo $lang === 'zh' ? '#000' : '#999'; ?>; font-weight: <?php echo $lang === 'zh' ? 'bold' : 'normal'; ?>;"><?php echo __('zh'); ?></a>
                <span style="color: #ccc;">/</span>
                <a href="javascript:void(0)" onclick="setLang('en')" style="text-decoration: none; color: <?php echo $lang === 'en' ? '#000' : '#999'; ?>; font-weight: <?php echo $lang === 'en' ? 'bold' : 'normal'; ?>;"><?php echo __('en'); ?></a>
            </div>
            <script>
                function setLang(lang) {
                    document.cookie = 'lang=' + lang + ';path=/;max-age=31536000';
                    window.location.reload();
                }
            </script>
        </div>
    </div>
