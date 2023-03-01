<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-27 05:11:02
 * @LastEditTime: 2023-03-01 03:41:31
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\frontend\partials\today-card.php
 */

declare(strict_types=1);

namespace CheckLotteryResults\Frontend;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}

function frontendPartialTodayCard(string $title, string $str): string
{
    \ob_start();

?>

    <div class="check-lottery-results-today__card">
        <h4 class="check-lottery-results-today__card-header"><?php echo $title; ?></h4>
        <div class="check-lottery-results-today__card-body">
            <div class="check-lottery-results-today__card-text">
                <span><?php echo $str; ?></span>
            </div>
        </div>
    </div>

<?php

    return \ob_get_clean();
}
