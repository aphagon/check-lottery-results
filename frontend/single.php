<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-27 01:44:33
 * @LastEditTime: 2023-03-03 06:18:42
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

function frontendSingle(array $data, ?array $sidebars = \null): string
{
    $item       = $data[0];
    $huayResult = $item['huayResultModel'];

    \ob_start();
?>

    <div class="check-lottery-results-single">
        <div class="check-lottery-results-single__loader"></div>

        <header class="check-lottery-results-single__header">
            <div class="check-lottery-results-row check-lottery-results-center-xs">
                <img src="<?php echo $item['icon']; ?>" alt="<?php echo $item['name']; ?>" class="check-lottery-results-single__header-icon" />

                <div>
                    <h4 class="check-lottery-results-single__header-title"><?php echo $item['name']; ?></h4>
                    <time class="check-lottery-results-single__header-date"><?php echo $huayResult[0]['name']; ?></time>
                </div>
            </div>
        </header>

        <div class="check-lottery-results-row">

            <?php if (!empty($sidebars)) : ?>
                <aside class="check-lottery-results-col-sm-<?php echo !empty($sidebars) ? '3' : '12'; ?> check-lottery-results-col-xs-12 check-lottery-results-single__sidebar">
                    <?php foreach ($sidebars as $i => $sidebar) : ?>
                        <a href="javascript:void(0);" class="<?php echo 0 === $i ? 'check-lottery-results-single__sidebar-link-active' : ''; ?>"><?php echo $sidebar; ?></a>
                    <?php endforeach; ?>
                </aside>
            <?php endif; ?>

            <article id="checkLotteryResultsContent" class="check-lottery-results-col-sm-<?php echo !empty($sidebars) ? '9' : '12'; ?> check-lottery-results-col-xs-12" style="padding: 0px;">
                <section class="check-lottery-results-single__card">
                    <!-- <h4 class="check-lottery-results-single__card-title">ผลหวยย้อนหลัง</h4> -->

                    <table class="check-lottery-results-single__card-table">
                        <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>3 ตัวบน</th>
                                <th>2 ตัวบน</th>
                                <th>2 ตัวล่าง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($huayResult as $value) :
                                $primaryNumber = !empty($value['result']['primaryNumber'])
                                    ? $value['result']['primaryNumber'] : 'รอผล';
                                $threeNumber   = !empty($value['result']['primaryNumber'])
                                    ? \substr($value['result']['primaryNumber'], 1) : 'รอผล';
                                $twoNumber     = !empty($value['result']['twoNumber'])
                                    ? $value['result']['twoNumber'] : 'รอผล';
                            ?>
                                <tr>
                                    <td><?php echo $value['name']; ?></td>
                                    <td><?php echo $primaryNumber; ?></td>
                                    <td><?php echo $threeNumber; ?></td>
                                    <td><?php echo $twoNumber; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
            </article>
        </div>
    </div>

<?php
    return \ob_get_clean();
}
