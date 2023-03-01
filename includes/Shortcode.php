<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-24 18:17:00
 * @LastEditTime: 2023-02-28 00:54:58
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\includes\Shortcode.php
 */

declare(strict_types=1);

namespace CheckLotteryResults;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}


final class Shortcode
{
    private Functions $functions;
    private Fetch $fetch;

    public function __construct(Functions $functions, Fetch $fetch)
    {
        $this->functions = $functions;
        $this->fetch     = $fetch;

        $this->hook();
    }

    private function hook(): void
    {
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        \add_shortcode('check-lottery-results', [$this, 'render']);
    }

    public function enqueue(): void
    {
        \wp_enqueue_style(
            'check-lottery-results-style',
            \CHECK_LOTTERY_RESULTS_URL . 'assets/style.css',
            [],
            \fileatime(\CHECK_LOTTERY_RESULTS_PATH . 'assets/style.css'),
            \false
        );

        \wp_enqueue_script(
            'check-lottery-results-script',
            \CHECK_LOTTERY_RESULTS_URL . 'assets/script.js',
            ['jquery'],
            \fileatime(\CHECK_LOTTERY_RESULTS_PATH . 'assets/script.js'),
            \true
        );

        \wp_localize_script('check-lottery-results-script', 'checkLotteryResults', [
            'url'   => \admin_url('admin-ajax.php') . '?action=check-lottery-results',
            'nonce' => \wp_create_nonce('check-lottery-results-nonce')
        ]);
    }

    /**
     * Shortcode example
     *
     * @param array $atts Parameters.
     * @since 1.0
     * @return string
     */
    public function render(array $atts): string
    {
        $atts = \array_change_key_case((array) $atts, \CASE_LOWER);
        $atts = \shortcode_atts(['type' => 'วันนี้'], $atts);

        if (!\in_array($atts['type'], $this->functions->arrayFlatten($this->fetch->types))) {
            return \sprintf('<h2 style="color:red;">%s</h2>', __('ไม่พบ type นี้', 'check-lottery-results'));
        }

        ob_start();

        if ('วันนี้' === $atts['type']) {
            return \CheckLotteryResults\Frontend\frontendToday($this->fetch->getToDay());
        } else {
            return \CheckLotteryResults\Frontend\frontendSingle($this->fetch->getHistory($atts['type']));
        }

        return ob_get_clean();
    }
}
