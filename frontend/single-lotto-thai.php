<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-03-02 15:36:33
 * @LastEditTime: 2023-03-03 04:05:07
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\frontend\single-lotto-thai.php
 */

declare(strict_types=1);

namespace CheckLotteryResults\Frontend;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}

function frontendSingleLottoThai(array $data, ?array $listYears = \null): string
{
    $months = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

    \ob_start();

?>

    <section class="check-lottery-results-single-lotto-thai">
        <h2 class="check-lottery-results-single-lotto-thai__title">ผลสลากกินแบ่งรัฐบาล</h2>
        <h3 class="check-lottery-results-single-lotto-thai__title-sub">งวดวันที่ <?php echo $data['title']; ?></h3>

        <!-- CheckLotteryResults -->
        <form id="CheckLotteryResults" method="post" class="check-lottery-results-form" style="margin-bottom: 0;" data-lottery-thai="<?php echo \esc_attr(\json_encode($data['result'])); ?>">
            <div class="check-lottery-results-form-column">
                <input type="text" id="CheckLotteryResultsNumber" class="check-lottery-results-form-input" maxlength="6" minlength="6">
            </div>
            <div class="check-lottery-results-form-column">
                <button id="CheckLotteryResultsSubmit" type="submit" class="check-lottery-results-form-button">ตรวจผลรางวัล</button>
            </div>
        </form>
        <div id="CheckLotteryResultsMessage" style="margin-bottom: 30px"></div>

        <?php
        $jsonYears = [];
        foreach ($listYears as $y => $histories) :
            foreach ($histories['result'] as $history) :
                list($year, $month, $day) = \explode('-', $history);

                $day   = \intval($day);
                $month = \intval($month);
                $year  = \intval($year);

                $jsonYears[$y][] = \sprintf('%d %s %d', $day, $months[$month], ($year + 543));
            endforeach;
        endforeach;
        ?>


        <div class="check-lottery-results-single-lotto-thai__resize">
            <div class="check-lottery-results-single-lotto-thai__sec">

                <div class="check-lottery-results-single-lotto-thai__table">
                    <div class="check-lottery-results-single-lotto-thai__column">
                        <p class="title__reward check-lottery-results-single-lotto-thai__box-item--bg">
                            <span class="default-font--reward">รางวัลที่ 1</span>
                            <small>รางวัลละ 6,000,000 บาท</small>
                        </p>
                        <p>
                            <strong class="check-lottery-results-single-lotto-thai__number--first">
                                <?php echo !empty($data['result'][1]['data'][0]) ? $data['result'][1]['data'][0] : 'XXXXXX'; ?>
                            </strong>
                        </p>
                    </div>
                    <div class="check-lottery-results-single-lotto-thai__column">
                        <p class="title__reward check-lottery-results-single-lotto-thai__box-item--bg">
                            <span class="default-font--reward">เลขหน้า 3 ตัว</span>
                            <small>2 รางวัลๆ ละ 4,000 บาท</small>
                        </p>
                        <p>
                            <strong class="check-lottery-results-single-lotto-thai__number">
                                <?php echo !empty($data['result'][10]['data'][0]) ? $data['result'][10]['data'][0] : 'XXXXXX'; ?>
                            </strong>
                            <strong class="check-lottery-results-single-lotto-thai__number">
                                <?php echo !empty($data['result'][10]['data'][1]) ? $data['result'][10]['data'][1] : 'XXXXXX'; ?>
                            </strong>
                        </p>
                    </div>
                    <div class="check-lottery-results-single-lotto-thai__column">
                        <p class="title__reward check-lottery-results-single-lotto-thai__box-item--bg">
                            <span class="default-font--reward">เลขท้าย 3 ตัว</span>
                            <small>2 รางวัลๆ ละ 4,000 บาท</small>
                        </p>
                        <p>
                            <strong class="check-lottery-results-single-lotto-thai__number">
                                <?php echo !empty($data['result'][6]['data'][0]) ? $data['result'][6]['data'][0] : 'XXXXXX'; ?>
                            </strong>
                            <strong class="check-lottery-results-single-lotto-thai__number">
                                <?php echo !empty($data['result'][6]['data'][1]) ? $data['result'][6]['data'][1] : 'XXXXXX'; ?>
                            </strong>
                        </p>
                    </div>
                    <div class="check-lottery-results-single-lotto-thai__column">
                        <p class="title__reward check-lottery-results-single-lotto-thai__box-item--bg">
                            <span class="default-font--reward">เลขท้าย 2 ตัว</span>
                            <small>1 รางวัลๆ ละ 2,000 บาท</small>
                        </p>
                        <p>
                            <strong class="check-lottery-results-single-lotto-thai__number">
                                <?php echo !empty($data['result'][7]['data'][0]) ? $data['result'][7]['data'][0] : 'XXXXXX'; ?>
                            </strong>
                        </p>
                    </div>
                </div>

                <div class="check-lottery-results-single-lotto-thai__sec--nearby">
                    <div class="title__reward">
                        <p>รางวัลข้างเคียงรางวัลที่ 1</p>
                        <p>2 รางวัลๆ ละ 100,000 บาท</p>
                    </div>
                    <div>
                        <strong class="check-lottery-results-single-lotto-thai__number">
                            <?php echo !empty($data['result'][11]['data'][0]) ? $data['result'][11]['data'][0] : 'XXXXXX'; ?>
                        </strong>
                        <strong class="check-lottery-results-single-lotto-thai__number">
                            <?php echo !empty($data['result'][11]['data'][1]) ? $data['result'][11]['data'][1] : 'XXXXXX'; ?>
                        </strong>
                    </div>
                </div>
            </div>

            <?php
            foreach ([
                2 => 'ผลสลากกินแบ่งรัฐบาล รางวัลที่ 2 มี 5 รางวัลๆ ละ 200,000 บาท',
                3 => 'ผลสลากกินแบ่งรัฐบาล รางวัลที่ 3 มี 10 รางวัลๆ ละ 80,000 บาท',
                4 => 'ผลสลากกินแบ่งรัฐบาล รางวัลที่ 4 มี 50 รางวัลๆ ละ 40,000 บาท',
                5 => 'ผลสลากกินแบ่งรัฐบาล รางวัลที่ 5 มี 100 รางวัลๆ ละ 20,000 บาท',
            ] as $k => $t) :
                $font_mini = $k > 2 ? 'check-lottery-results-single-lotto-thai__sec--font-mini' : '';
            ?>
                <div class="check-lottery-results-single-lotto-thai__sec <?php echo $font_mini; ?>">
                    <h3 class="title__reward"><?php echo $t; ?></h3>
                    <div class="check-lottery-results-single-lotto-thai__box-item">
                        <?php foreach ($data['result'][$k]['data'] as $x => $lotto) : ?>
                            <?php if (0 === $x % 5) : ?>
                    </div>
                    <div class="check-lottery-results-single-lotto-thai__box-item">
                    <?php endif; ?>
                    <span class="check-lottery-results-single-lotto-thai__number">
                        <?php echo !empty($lotto) ? $lotto : 'XXXXXX'; ?>
                    </span>
                <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </section>

<?php

    return \ob_get_clean();
}
