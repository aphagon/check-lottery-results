<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-27 01:44:22
 * @LastEditTime: 2023-03-01 12:47:33
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\frontend\today.php
 */

declare(strict_types=1);

namespace CheckLotteryResults\Frontend;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}

function frontendToday(array $data): string
{
    \ob_start();

?>

    <section class="check-lottery-results-container">

        <?php
        if (!empty($data['หวยรัฐบาล']['data'][0])) :
            $item   = $data['หวยรัฐบาล']['data'][0];
            $result = $item['huayResultModel'];
        ?>

            <div class="check-lottery-results-row">
                <div class="check-lottery-results-col-xs-12">
                    <div class="check-lottery-results-today__block">
                        <header class="check-lottery-results-today__block-header">

                            <img src="<?php echo $item['icon']; ?>" alt="<?php echo $item['name']; ?>" class="check-lottery-results-today__block-header-icon" />

                            <h4 class="check-lottery-results-today__block-header-title">
                                <?php echo $item['name']; ?>
                            </h4>

                            <small class="check-lottery-results-today__block-header-badge">
                                <?php echo $result['name']; ?>
                            </small>

                        </header>

                        <div class="check-lottery-results-today__block-body">
                            <div class="check-lottery-results-row">
                                <div class="check-lottery-results-col-xs-12">
                                    <?php echo frontendPartialTodayCard('รางวัลที่ 1', (string) $result['result']['primaryNumber']); ?>
                                </div>
                            </div>

                            <div class="check-lottery-results-row">
                                <div class="check-lottery-results-col-sm-4 check-lottery-results-col-xs-12 check-lottery-results-mb-2">
                                    <?php
                                    echo frontendPartialTodayCard(
                                        '3 ตัวหน้า',
                                        (string) \implode(' , ', $result['result']['threeFrontNumber'])
                                    );
                                    ?>
                                </div>

                                <div class="check-lottery-results-col-sm-4 check-lottery-results-col-xs-12 check-lottery-results-mb-2">
                                    <?php
                                    echo frontendPartialTodayCard(
                                        '3 ตัวล่าง',
                                        (string) \implode(' , ', $result['result']['threeBackNumber'])
                                    );
                                    ?>
                                </div>

                                <div class="check-lottery-results-col-sm-4 check-lottery-results-col-xs-12">
                                    <?php
                                    echo frontendPartialTodayCard(
                                        '2 ตัวล่าง',
                                        (string) $result['result']['twoNumber']
                                    );
                                    ?>
                                </div>
                            </div><!-- ./check-lottery-results-row -->
                        </div><!-- ./check-lottery-results-today__block-body -->
                    </div><!-- ./check-lottery-results-today__block -->
                </div><!-- ./check-lottery-results-col-12 -->
            </div><!-- ./check-lottery-results-row -->

        <?php endif; ?>

        <?php if (!empty($data['หวยธนาคารไทย']['data'])) : ?>
            <div class="check-lottery-results-row">
                <?php foreach ($data['หวยธนาคารไทย']['data'] as $values) : ?>
                    <div class="check-lottery-results-col-md-6 check-lottery-results-col-xs-12">
                        <div class="check-lottery-results-today__block">
                            <header class="check-lottery-results-today__block-header">

                                <img src="<?php echo $values['icon']; ?>" alt="<?php echo $values['name']; ?>" class="check-lottery-results-today__block-header-icon" />

                                <h4 class="check-lottery-results-today__block-header-title">
                                    <?php echo $values['name']; ?>
                                </h4>

                                <small class="check-lottery-results-today__block-header-badge">
                                    <?php echo $values['huayResultModel']['name']; ?>
                                </small>

                            </header>

                            <div class="check-lottery-results-today__block-body">
                                <div class="check-lottery-results-row">
                                    <div class="check-lottery-results-col-xs-6">
                                        <?php
                                        echo frontendPartialTodayCard(
                                            '3 ตัวหน้า',
                                            (string) $values['huayResultModel']['result']['primaryNumber']
                                        );
                                        ?>
                                    </div>

                                    <div class="check-lottery-results-col-xs-6">
                                        <?php
                                        echo frontendPartialTodayCard(
                                            '2 ตัวล่าง',
                                            (string) $values['huayResultModel']['result']['twoNumber']
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- ./check-lottery-results-today__block -->
                    </div><!-- ./check-lottery-results-col-xs-6 -->
                <?php endforeach; ?>
            </div><!-- ./check-lottery-results-row -->
        <?php endif; ?>


        <?php foreach (['หวยหุ้น', 'หวยรายวัน', 'หุ้น-VIP', 'หวยต่างประเทศ'] as $key) : ?>
            <?php if (!empty($data[$key]['data'])) : ?>
                <div class="check-lottery-results-today__block">
                    <header class="check-lottery-results-today__block-header">
                        <h4 class="check-lottery-results-today__block-header-title">
                            <?php echo \str_replace('-', ' ', $key); ?>
                        </h4>
                    </header>

                    <div class="check-lottery-results-today__block-body">
                        <div class="check-lottery-results-row">
                            <?php foreach ($data[$key]['data'] as $values) : ?>
                                <div class="check-lottery-results-col-xs-12 check-lottery-results-col-sm-4 check-lottery-results-mb-2">
                                    <?php echo frontendPartialTodaySubCard($values); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div><!-- ./check-lottery-results-today__block -->
            <?php endif; ?>
        <?php endforeach; ?>

    </section><!-- ./check-lottery-results-container -->

<?php
    return \ob_get_clean();
}
