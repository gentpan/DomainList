<?php
declare(strict_types=1);

require_once __DIR__ . '/app/helpers.php';

$content = read_json('content.json', []);
$siteSettings = $content['site_settings'] ?? [];
$homeWelcome = $content['home_welcome'] ?? [];
$categories = read_json('categories.json', []);
$suffixes = read_json('suffixes.json', []);
$uiSettings = array_merge([
    'site_max_width' => 1600,
    'columns_per_row' => 4,
    'items_per_page' => 8,
    'card_style' => 'standard',
], read_json('ui_settings.json', []));

$homeWelcomeDefault = [
    'hero' => [
        'mode' => 'text',
        'text' => [
            'main_url' => 'https://prime.ls',
            'label' => '推荐域名',
            'title' => 'PRIME.LS',
            'description' => '高端品牌主域，适合旗舰业务与品牌升级',
            'link_text' => '立即访问 →',
            'side' => [
                ['title' => 'DESIGN.LS', 'description' => '创意与视觉品牌', 'url' => 'https://design.ls'],
                ['title' => 'CLOUD.LS', 'description' => '云服务优选域名', 'url' => 'https://cloud.ls'],
                ['title' => 'AI.LS', 'description' => '双字符 AI 精品', 'url' => 'https://ai.ls'],
            ],
        ],
        'image' => ['url' => '', 'alt' => '推荐域名', 'link' => '#'],
    ],
    'welcome' => [
        'mode' => 'text',
        'text' => [
            'slides' => [
                ['tag' => '品牌主场景', 'title' => 'BRAND.LS', 'description' => '适合企业主站与统一品牌门户', 'url' => 'https://brand.ls'],
                ['tag' => '创业项目', 'title' => 'STARTUP.LS', 'description' => '简洁易记，适合新产品冷启动', 'url' => 'https://startup.ls'],
                ['tag' => '投资并购', 'title' => 'CAPITAL.LS', 'description' => '金融资本类域名组合方案', 'url' => 'https://capital.ls'],
            ],
            'logos' => ['DOMAIN.LS', 'PRIME.LS', 'AI.LS', 'CLOUD.LS', 'DESIGN.LS', 'BRAND.LS'],
        ],
        'image' => ['url' => '', 'alt' => '品牌展示', 'link' => '#'],
    ],
];
$homeWelcome = array_replace_recursive($homeWelcomeDefault, is_array($homeWelcome) ? $homeWelcome : []);

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$filter = [];

if ($path === '' || $path === 'index.php') {
    $view = 'home';
} elseif (preg_match('#^category/([a-z0-9-]+)$#', $path, $matches)) {
    $view = 'home';
    $filter['category'] = $matches[1];
} elseif (preg_match('#^suffix/([a-z0-9.]+)$#', $path, $matches)) {
    $view = 'home';
    $filter['suffix'] = '.' . ltrim($matches[1], '.');
} else {
    $pageFile = __DIR__ . '/pages/' . $path . '.php';
    if (file_exists($pageFile)) {
        require $pageFile;
        exit;
    }

    http_response_code(404);
    $page_title = '页面不存在';
    $page_subtitle = '404';
    $page_content = '<p>您访问的页面不存在，请返回首页。</p>';
    require __DIR__ . '/pages/_layout.php';
    exit;
}

require __DIR__ . '/includes/site_header.php';
?>
    <header class="header-section">
        <div class="logo-container">
            <div class="hero-welcome-row">
                <section class="hero-promo" aria-label="推荐域名推广位">
                    <?php if (($homeWelcome['hero']['mode'] ?? 'text') === 'image' && !empty($homeWelcome['hero']['image']['url'])): ?>
                        <a class="hero-promo-image-link" href="<?php echo h($homeWelcome['hero']['image']['link'] ?? '#'); ?>" target="_blank" rel="noopener">
                            <img class="hero-promo-image" src="<?php echo h($homeWelcome['hero']['image']['url']); ?>" alt="<?php echo h($homeWelcome['hero']['image']['alt'] ?? '推荐域名'); ?>">
                        </a>
                    <?php else: ?>
                        <a class="hero-promo-main" href="<?php echo h($homeWelcome['hero']['text']['main_url'] ?? '#'); ?>" target="_blank" rel="noopener">
                            <div class="hero-promo-label"><?php echo h($homeWelcome['hero']['text']['label'] ?? '推荐域名'); ?></div>
                            <h2><?php echo h($homeWelcome['hero']['text']['title'] ?? ''); ?></h2>
                            <p><?php echo h($homeWelcome['hero']['text']['description'] ?? ''); ?></p>
                            <span class="hero-promo-link"><?php echo h($homeWelcome['hero']['text']['link_text'] ?? '立即访问 →'); ?></span>
                        </a>
                        <div class="hero-promo-side">
                            <?php foreach (($homeWelcome['hero']['text']['side'] ?? []) as $item): ?>
                                <a class="hero-promo-mini" href="<?php echo h($item['url'] ?? '#'); ?>" target="_blank" rel="noopener">
                                    <strong><?php echo h($item['title'] ?? ''); ?></strong>
                                    <span><?php echo h($item['description'] ?? ''); ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>

                <section class="welcome-showcase" aria-label="品牌展示">
                    <?php if (($homeWelcome['welcome']['mode'] ?? 'text') === 'image' && !empty($homeWelcome['welcome']['image']['url'])): ?>
                        <a class="welcome-image-link" href="<?php echo h($homeWelcome['welcome']['image']['link'] ?? '#'); ?>" target="_blank" rel="noopener">
                            <img class="welcome-showcase-image" src="<?php echo h($homeWelcome['welcome']['image']['url']); ?>" alt="<?php echo h($homeWelcome['welcome']['image']['alt'] ?? '品牌展示'); ?>">
                        </a>
                    <?php else: ?>
                        <div class="welcome-slider" id="welcomeSlider">
                            <?php foreach (($homeWelcome['welcome']['text']['slides'] ?? []) as $index => $slide): ?>
                                <a class="welcome-slide <?php echo $index === 0 ? 'active' : ''; ?>" href="<?php echo h($slide['url'] ?? '#'); ?>" target="_blank" rel="noopener">
                                    <span class="welcome-slide-tag"><?php echo h($slide['tag'] ?? ''); ?></span>
                                    <h3><?php echo h($slide['title'] ?? ''); ?></h3>
                                    <p><?php echo h($slide['description'] ?? ''); ?></p>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <div class="welcome-logos" aria-label="合作品牌">
                            <?php foreach (($homeWelcome['welcome']['text']['logos'] ?? []) as $logo): ?>
                                <span class="welcome-logo-item"><?php echo h((string)$logo); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </header>

    <main class="main-content" id="domains">
        <div class="filter-bar">
            <div class="domain-count-badge domain-count-badge-inline">
                <svg class="domain-count-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                <span id="domainCount">共 0 个域名</span>
            </div>
            <div class="filter-group">
                <span class="filter-label">关键词</span>
                <div class="filter-chips">
                    <a class="filter-chip <?php echo empty($filter['category']) ? 'active' : ''; ?>" data-filter-group="category" data-filter-value="" href="/">全部</a>
                    <?php foreach ($categories as $category): ?>
                        <?php $categoryName = (string)($category['name'] ?? ''); ?>
                        <a class="filter-chip <?php echo (($filter['category'] ?? '') === $categoryName) ? 'active' : ''; ?>" data-filter-group="category" data-filter-value="<?php echo h($categoryName); ?>" href="#">
                            <?php echo h($category['name'] ?? ''); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="filter-group">
                <span class="filter-label">后缀</span>
                <div class="filter-chips">
                    <a class="filter-chip <?php echo empty($filter['suffix']) ? 'active' : ''; ?>" data-filter-group="suffix" data-filter-value="" href="#">全部</a>
                    <?php foreach ($suffixes as $suffix): ?>
                        <?php $tld = $suffix['tld'] ?? ''; ?>
                        <a class="filter-chip <?php echo (($filter['suffix'] ?? '') === $tld) ? 'active' : ''; ?>" data-filter-group="suffix" data-filter-value="<?php echo h($tld); ?>" href="#">
                            <?php echo h($tld); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="domain-grid-wrap" id="domainGridWrap">
            <div class="domain-area-loader" id="domainAreaLoader" aria-hidden="true">
                <div class="domain-area-loader-spinner"></div>
            </div>
            <div class="domain-grid" id="domainGrid"></div>
        </div>
    </main>

    <div class="pagination-container" id="paginationContainer">
        <div class="pagination-controls">
            <button class="pagination-btn pagination-prev" id="prevPage">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>上一页</span>
            </button>
            <div class="pagination-pages" id="paginationPages"></div>
            <button class="pagination-btn pagination-next" id="nextPage">
                <span>下一页</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <section class="advantages-section">
        <div class="section-container">
            <h2 class="section-title">为什么选择 ://domain.ls</h2>
            <p class="section-subtitle">聚焦品牌资产、交易效率与合规交付的一站式域名服务</p>
            <div class="advantages-grid"></div>
        </div>
    </section>

    <section class="contact-section">
        <div class="section-container">
            <h2 class="section-title">联系我们</h2>
            <p class="section-subtitle">如果您对域名有需求或合作意向，请与我们取得联系</p>
            <div class="contact-button-wrapper">
                <a class="btn btn-primary btn-large" href="#" onclick="showGeneralContactModal()">立即联系</a>
            </div>
        </div>
    </section>

    <section class="friends-link-section">
        <div class="section-container">
            <div class="friends-link-title">合作伙伴</div>
            <div class="friends-link-wrapper"></div>
        </div>
    </section>

    <div class="modal-overlay" id="detailModal">
        <div class="modal modal-large">
            <div class="modal-header">
                <div class="modal-title" id="detailDomainName">域名详情</div>
                <div class="modal-subtitle">DOMAIN DETAILS</div>
                <button class="modal-close" onclick="closeModal('detailModal')">×</button>
            </div>
            <div class="modal-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">域名类型</div>
                        <div class="detail-value" id="detailType"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">域名后缀</div>
                        <div class="detail-value" id="detailSuffix"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">字符长度</div>
                        <div class="detail-value" id="detailLength"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">构成类型</div>
                        <div class="detail-value" id="detailComposition"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">注册时间</div>
                        <div class="detail-value" id="detailRegDate"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">到期时间</div>
                        <div class="detail-value" id="detailExpDate"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">注册年限</div>
                        <div class="detail-value" id="detailYears"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">价格类型</div>
                        <div class="detail-value" id="detailPriceType"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">在售状态</div>
                        <div class="detail-value" id="detailSaleStatus"></div>
                    </div>
                </div>
                <div class="domain-intro">
                    <div class="domain-intro-title">域名介绍</div>
                    <div class="domain-intro-text" id="detailIntro"></div>
                </div>
                <div class="form-footer">
                    <button class="btn btn-primary" onclick="visitDomain()">访问购买</button>
                    <button class="btn btn-secondary" onclick="showInquiryModal()">进一步咨询</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="inquiryModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title" id="inquiryTitle">联系我们</div>
                <div class="modal-subtitle">CONTACT</div>
                <button class="modal-close" onclick="closeModal('inquiryModal')">×</button>
            </div>
            <div class="modal-body">
                <form onsubmit="submitInquiry(event)">
                    <div class="form-group">
                        <label class="form-label">姓名 <span class="required">*</span></label>
                        <input class="form-input" type="text" name="name" placeholder="请输入您的姓名" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">邮箱 <span class="required">*</span></label>
                        <input class="form-input" type="email" name="email" placeholder="请输入您的邮箱地址" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">主题 <span class="required">*</span></label>
                        <input class="form-input" type="text" name="subject" id="inquirySubject" placeholder="关于域名咨询" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">留言内容 <span class="required">*</span></label>
                        <textarea class="form-textarea" name="message" placeholder="请详细描述您的需求或问题（至少10个字符）" required></textarea>
                    </div>
                    <input type="hidden" name="cf-turnstile-response" value="local">
                    <div class="form-footer">
                        <button class="btn btn-secondary" type="button" onclick="closeModal('inquiryModal')">取消</button>
                        <button class="btn btn-primary" type="submit">发送</button>
                    </div>
                    <div class="form-note">或发送邮件至 <a href="mailto:contact@domain.ls">contact@domain.ls</a></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="docModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">帮助文档</div>
                <div class="modal-subtitle">DOCUMENT</div>
                <button class="modal-close" onclick="closeModal('docModal')">×</button>
            </div>
            <div class="modal-body">
                <p>如需帮助，请通过联系表单发送您的问题，我们会尽快回复。</p>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="termsModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">服务条款</div>
                <div class="modal-subtitle">TERMS</div>
                <button class="modal-close" onclick="closeModal('termsModal')">×</button>
            </div>
            <div class="modal-body">
                <p>所有域名咨询与交易需遵循相关法律法规，具体以沟通确认内容为准。</p>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="privacyModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">隐私政策</div>
                <div class="modal-subtitle">PRIVACY</div>
                <button class="modal-close" onclick="closeModal('privacyModal')">×</button>
            </div>
            <div class="modal-body">
                <p>我们仅用于联系沟通目的收集您的信息，不会向第三方披露。</p>
            </div>
        </div>
    </div>

    <script>
        window.domainFilter = <?php echo json_encode($filter, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
    </script>

    <script>
        window.uiSettings = <?php echo json_encode($uiSettings, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
    </script>

<?php
require __DIR__ . '/includes/site_footer.php';
