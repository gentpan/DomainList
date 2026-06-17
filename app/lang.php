<?php
declare(strict_types=1);

function get_lang_data(): array
{
    return [
        'zh' => [
            'site_title_suffix' => ' - 域名列表',
            'home' => '首页',
            'domains' => '域名',
            'whois' => 'whois',
            'contact' => '联系',
            'recommended_domains' => '推荐域名',
            'brand_showcase' => '品牌展示',
            'visit_now' => '立即访问 →',
            'total_domains_prefix' => '共 ',
            'total_domains_suffix' => ' 个域名',
            'suffix' => '后缀',
            'category' => '分类',
            'filter' => '筛选',
            'all' => '全部',
            'search' => '搜索',
            'domain_detail' => '域名详情',
            'domain_type' => '域名类型',
            'domain_suffix_label' => '域名后缀',
            'domain_intro' => '域名介绍',
            'inquiry' => '咨询',
            'submit' => '提交',
            'cancel' => '取消',
            'close' => '关闭',
            'loading' => '加载中',
            'page_not_found' => '页面不存在',
            'return_home' => '返回首页',
            'admin_panel' => '管理面板',
            'domain_management' => '域名管理',
            'display_settings' => '展示设置',
            'home_welcome' => '首页Welcome',
            'categories' => '关键词分类',
            'suffixes' => '后缀分类',
            'site_settings' => '站点设置',
            'mail_settings' => '邮件设置',
            'login' => '登录',
            'logout' => '退出',
            'password' => '密码',
            'admin_login' => '管理后台登录',
            'save' => '保存',
            'edit' => '编辑',
            'delete' => '删除',
            'add' => '添加',
            'action' => '操作',
            'status' => '状态',
            'name' => '名称',
            'description' => '描述',
            'price' => '价格',
            'yes' => '是',
            'no' => '否',
            'success' => '成功',
            'error' => '错误',
            'confirm_delete' => '确认删除？',
            'no_data' => '暂无数据',
            'prev' => '上一页',
            'next' => '下一页',
            'page' => '页',
            'total_prefix' => '共',
            'records_suffix' => '条记录',
            'zh' => '中',
            'en' => 'EN',
            'language' => '语言',
        ],
        'en' => [
            'site_title_suffix' => ' - Domain List',
            'home' => 'Home',
            'domains' => 'Domains',
            'whois' => 'whois',
            'contact' => 'Contact',
            'recommended_domains' => 'Featured Domains',
            'brand_showcase' => 'Brand Showcase',
            'visit_now' => 'Visit Now →',
            'total_domains_prefix' => '',
            'total_domains_suffix' => ' domains',
            'suffix' => 'Suffix',
            'category' => 'Category',
            'filter' => 'Filter',
            'all' => 'All',
            'search' => 'Search',
            'domain_detail' => 'Domain Details',
            'domain_type' => 'Domain Type',
            'domain_suffix_label' => 'Domain Suffix',
            'domain_intro' => 'Domain Introduction',
            'inquiry' => 'Inquiry',
            'submit' => 'Submit',
            'cancel' => 'Cancel',
            'close' => 'Close',
            'loading' => 'Loading',
            'page_not_found' => 'Page Not Found',
            'return_home' => 'Return to Home',
            'admin_panel' => 'Admin Panel',
            'domain_management' => 'Domain Management',
            'display_settings' => 'Display Settings',
            'home_welcome' => 'Home Welcome',
            'categories' => 'Categories',
            'suffixes' => 'Suffixes',
            'site_settings' => 'Site Settings',
            'mail_settings' => 'Mail Settings',
            'login' => 'Login',
            'logout' => 'Logout',
            'password' => 'Password',
            'admin_login' => 'Admin Login',
            'save' => 'Save',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'add' => 'Add',
            'action' => 'Action',
            'status' => 'Status',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'yes' => 'Yes',
            'no' => 'No',
            'success' => 'Success',
            'error' => 'Error',
            'confirm_delete' => 'Confirm delete?',
            'no_data' => 'No data',
            'prev' => 'Prev',
            'next' => 'Next',
            'page' => 'Page',
            'total_prefix' => 'Total',
            'records_suffix' => ' records',
            'zh' => '中',
            'en' => 'EN',
            'language' => 'Language',
        ],
    ];
}

function detect_lang(): string
{
    if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['zh', 'en'], true)) {
        return $_COOKIE['lang'];
    }
    $acceptLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    if (stripos($acceptLang, 'zh') !== false) {
        return 'zh';
    }
    return 'en';
}

function __(string $key): string
{
    static $langData = null;
    static $lang = null;
    
    if ($langData === null) {
        $langData = get_lang_data();
        $lang = detect_lang();
    }
    
    return $langData[$lang][$key] ?? $key;
}

function current_lang(): string
{
    return detect_lang();
}
