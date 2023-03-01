<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-27 01:44:33
 * @LastEditTime: 2023-02-27 04:06:15
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\frontend\single.php
 */

declare(strict_types=1);

namespace CheckLotteryResults\Frontend;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}

function frontendSingle(array $data): string
{
    \ob_start();
?>

    <pre>
        <?php \print_r($data); ?>
    </pre>

<?php
    return \ob_get_clean();
}
