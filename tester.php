<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-22 01:27:19
 * @LastEditTime: 2023-02-26 23:09:06
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\tester.php
 */

declare(strict_types=1);

define('WP_USE_THEMES', false);

$wploadPath = '';
if (isset($_SERVER['SCRIPT_FILENAME'])) {
    $parseUri = explode('/plugins', str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']));
    if (file_exists(dirname($parseUri[0]) . '/wp-load.php')) {
        $wploadPath = dirname($parseUri[0]) . '/wp-load.php';
    }
}

try {
    if (!file_exists($wploadPath)) {
        throw new Exception('wp-load.php not found');
    }

    // load wp-load.php
    require_once $wploadPath;
    if (!function_exists('is_plugin_active')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    if (!is_plugin_active('check-lottery-results/check-lottery-results.php')) {
        throw new Exception('ปลั๊กอิน \'ตรวจผลหวย\' ไม่ได้เปิดใช้งาน');
    }

    echo '<pre>';
    print_r(get_check_lottery_results()->fetch->getToDay());
    echo '</pre>';
} catch (Exception $e) {
    echo $e->getMessage();
}
