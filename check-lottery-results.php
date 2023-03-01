<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-21 18:02:42
 * @LastEditTime: 2023-03-01 06:34:48
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\check-lottery-results.php
 */

/**
 * @package   Check Lottery Results
 * @author    Aphagon Phromdesarn <aphagon@gmail.com>
 * @link      https://fb.com/vilet.sz
 *
 * Plugin Name:     ตรวจผลหวย
 * Description:     ดึงข้อมูลตรวจผลหวยอัตโนมัติ.
 * Version:         1.0
 * Author:          Aphagon Phromdesarn
 * Author URI:      https://fb.com/vilet.sz
 * Text Domain:     check-lottery-results
 * Domain Path:     /languages
 * Requires PHP:    7.4
 */

declare(strict_types=1);

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}

define('CHECK_LOTTERY_RESULTS_FILE',           __FILE__);
define('CHECK_LOTTERY_RESULTS_BASE',           plugin_basename(CHECK_LOTTERY_RESULTS_FILE));
define('CHECK_LOTTERY_RESULTS_PATH',           trailingslashit(realpath(plugin_dir_path(CHECK_LOTTERY_RESULTS_FILE))));
define('CHECK_LOTTERY_RESULTS_URL',            plugin_dir_url(CHECK_LOTTERY_RESULTS_FILE));
define('CHECK_LOTTERY_RESULTS_FRONTEND_PATH',  trailingslashit(CHECK_LOTTERY_RESULTS_PATH . 'frontend'));
define('CHECK_LOTTERY_RESULTS_INCLUDE_PATH',   trailingslashit(CHECK_LOTTERY_RESULTS_PATH . 'includes'));

if (version_compare(PHP_VERSION, '7.4', '<=')) {
    add_action(
        'admin_init',
        static function (): void {
            deactivate_plugins(CHECK_LOTTERY_RESULTS_BASE);
        }
    );
    add_action(
        'admin_notices',
        static function (): void {
            echo wp_kses_post(
                sprintf(
                    '<div class="notice notice-error"><p>%s</p></div>',
                    __('"ตรวจผลหวย" requires PHP 7.4 or newer.', 'check-lottery-results')
                )
            );
        }
    );

    // Return early to prevent loading the plugin.
    return;
}

if (!class_exists('CheckLotteryResults')) {
    final class CheckLotteryResults
    {
        private static ?CheckLotteryResults $instance = null;

        public CheckLotteryResults\Functions $functions;
        public CheckLotteryResults\Fetch $fetch;
        public CheckLotteryResults\Controller $controller;
        public CheckLotteryResults\Shortcode $shortcode;

        final public static function instance(): self
        {
            if (null === self::$instance) {
                self::$instance = new self();
                self::$instance->loaded();
            }

            return self::$instance;
        }

        private function loaded(): void
        {
            require_once CHECK_LOTTERY_RESULTS_INCLUDE_PATH . 'Functions.php';
            require_once CHECK_LOTTERY_RESULTS_INCLUDE_PATH . 'Fetch.php';
            require_once CHECK_LOTTERY_RESULTS_INCLUDE_PATH . 'Controller.php';
            require_once CHECK_LOTTERY_RESULTS_INCLUDE_PATH . 'Shortcode.php';

            // Frontend function
            require_once CHECK_LOTTERY_RESULTS_FRONTEND_PATH . 'partials/today-card.php';
            require_once CHECK_LOTTERY_RESULTS_FRONTEND_PATH . 'partials/today-sub-card.php';
            require_once CHECK_LOTTERY_RESULTS_FRONTEND_PATH . 'today.php';
            require_once CHECK_LOTTERY_RESULTS_FRONTEND_PATH . 'single.php';

            $this->functions  = new CheckLotteryResults\Functions();
            $this->fetch      = new CheckLotteryResults\Fetch($this->functions);
            $this->controller = new CheckLotteryResults\Controller($this->functions, $this->fetch);
            $this->shortcode  = new CheckLotteryResults\Shortcode($this->functions, $this->fetch);
        }
    }
}

function get_check_lottery_results(): CheckLotteryResults
{
    return CheckLotteryResults::instance();
}
add_action('plugin_loaded', 'get_check_lottery_results');
