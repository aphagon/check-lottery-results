<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-27 05:21:13
 * @LastEditTime: 2023-03-01 06:33:14
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\frontend\partials\today-sub-card.php
 */

declare(strict_types=1);

namespace CheckLotteryResults\Frontend;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}

function frontendPartialTodaySubCard(array $data): string
{
    $primaryNumber = 'รอผล';
    if (!empty($data['huayResultModel']['result']['primaryNumber'])) {
        $primaryNumber = $data['huayResultModel']['result']['primaryNumber'];
    }

    $twoNumber = 'รอผล';
    if (!empty($data['huayResultModel']['result']['twoNumber'])) {
        $twoNumber = $data['huayResultModel']['result']['twoNumber'];
    }

    \ob_start();
?>


    <div class="check-lottery-results-today__sub-card">
        <header class="check-lottery-results-today__sub-card-header">
            <img src="<?php echo $data['icon']; ?>" alt="<?php echo $data['name']; ?>" class="check-lottery-results-today__sub-card-header-icon" />

            <h4 class="check-lottery-results-today__sub-card-header-title">
                <?php echo $data['name']; ?>
            </h4>

            <small class="check-lottery-results-today__sub-card-header-badge">
                <?php echo $data['huayResultModel']['name']; ?>
            </small>
        </header>


        <div class="check-lottery-results-today__sub-card-body">
            <div class="check-lottery-results-row">
                <div class="check-lottery-results-col-xs-6">
                    <?php
                    echo frontendPartialTodayCard(
                        '3 ตัวบน',
                        (string) $primaryNumber
                    );
                    ?>
                </div>

                <div class="check-lottery-results-col-xs-6">
                    <?php
                    echo frontendPartialTodayCard(
                        '2 ตัวล่าง',
                        (string) $twoNumber
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
    return \ob_get_clean();
}
