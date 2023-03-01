<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-25 19:09:43
 * @LastEditTime: 2023-02-26 22:50:12
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\includes\Controller.php
 */

declare(strict_types=1);

namespace CheckLotteryResults;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}

final class Controller
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
        \add_action('wp_ajax_check-lottery-results', [$this, 'get']);
    }

    public function get(): void
    {
        // Check for nonce security
        if (!\wp_verify_nonce($_GET['nonce'] ?? '', 'check-lottery-results-nonce')) {
            \header('HTTP/1.1 403 Forbidden');
            exit();
        }

        $type  = !empty($_GET['type']) ? \trim($_GET['type']) : '';
        $types = $this->functions->arrayFlatten($this->fetch->types);
        if ('' === $type || !\in_array($type, $types)) {
            \wp_send_json_error('Invalid type', 400);
        }

        $history = $this->fetch->getHistory($type);
        \var_dump($history);
        exit();

        // \wp_send_json_success($this->fetch->getHistory($type), 200);
    }
}
