<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-03-02 15:36:33
 * @LastEditTime: 2023-03-03 04:53:36
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\frontend\single-thai-lotto.php
 */

declare(strict_types=1);

namespace CheckLotteryResults\Frontend;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}

function frontendSingleThaiLotto(array $data, ?array $listYears = \null): string
{
    $months = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

    $monthShorts = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

    \ob_start();

?>

    <section class="check-lottery-results-single-thai-lotto">
        <h2 class="check-lottery-results-single-thai-lotto__title">ผลสลากกินแบ่งรัฐบาล</h2>
        <h3 class="check-lottery-results-single-thai-lotto__title-sub">งวดวันที่ <?php echo $data['title']; ?></h3>

        <!-- CheckLotteryResultsThaiLotto -->
        <form id="CheckLotteryResultsThaiLotto" method="post" class="check-lottery-results-single-thai-lotto__form" style="margin-bottom: 0;" data-lottery-thai="<?php echo \esc_attr(\json_encode($data['result'])); ?>">
            <div class="check-lottery-results-single-thai-lotto__form-column">
                <input type="text" id="CheckLotteryResultsNumber" class="check-lottery-results-single-thai-lotto__form-input" maxlength="6" minlength="6">
            </div>
            <div class="check-lottery-results-single-thai-lotto__form-column">
                <button id="CheckLotteryResultsSubmit" type="submit" class="check-lottery-results-single-thai-lotto__form-button">ตรวจผลรางวัล</button>
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


        <!-- CheckLotteryResultsSearch -->
        <section id="CheckLotteryResultsSearch" class="check-lottery-results-single-thai-lotto__form" data-lottery-thai-years="<?php echo \esc_attr(\json_encode($jsonYears)); ?>">
            <div class="check-lottery-results-single-thai-lotto__form-column">
                <select id="CheckLotteryResultsSearchSelectYear" class="check-lottery-results-single-thai-lotto__form-select">
                    <option value="">ปี</option>
                    <?php
                    $sortDesc = \array_keys($listYears);
                    rsort($sortDesc);

                    foreach ($sortDesc as $year) : ?>
                        <option value="<?php echo $year; ?>"><?php echo (\intval($year) + 543); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="check-lottery-results-single-thai-lotto__form-column">
                <select id="CheckLotteryResultsSearchSelectDay" class="check-lottery-results-single-thai-lotto__form-select">
                    <option value="">งวดประจำวันที่</option>
                </select>
            </div>
            <div class="check-lottery-results-single-thai-lotto__form-column">
                <button id="CheckLotteryResultsSearchSubmit" type="button" class="check-lottery-results-single-thai-lotto__form-button" data-href="<?php echo \esc_attr(\esc_url(\get_permalink())); ?>">GO</button>
            </div>
        </section>


        <div class="check-lottery-results-single-thai-lotto__resize">
            <div class="check-lottery-results-single-thai-lotto__sec">

                <div class="check-lottery-results-single-thai-lotto__table">
                    <div class="check-lottery-results-single-thai-lotto__column">
                        <p class="title__reward check-lottery-results-single-thai-lotto__box-item--bg">
                            <span class="default-font--reward">รางวัลที่ 1</span>
                            <small>รางวัลละ 6,000,000 บาท</small>
                        </p>
                        <p>
                            <strong class="check-lottery-results-single-thai-lotto__number--first">
                                <?php echo !empty($data['result'][1]['data'][0]) ? $data['result'][1]['data'][0] : 'XXXXXX'; ?>
                            </strong>
                        </p>
                    </div>
                    <div class="check-lottery-results-single-thai-lotto__column">
                        <p class="title__reward check-lottery-results-single-thai-lotto__box-item--bg">
                            <span class="default-font--reward">เลขหน้า 3 ตัว</span>
                            <small>2 รางวัลๆ ละ 4,000 บาท</small>
                        </p>
                        <p>
                            <strong class="check-lottery-results-single-thai-lotto__number">
                                <?php echo !empty($data['result'][10]['data'][0]) ? $data['result'][10]['data'][0] : 'XXXXXX'; ?>
                            </strong>
                            <strong class="check-lottery-results-single-thai-lotto__number">
                                <?php echo !empty($data['result'][10]['data'][1]) ? $data['result'][10]['data'][1] : 'XXXXXX'; ?>
                            </strong>
                        </p>
                    </div>
                    <div class="check-lottery-results-single-thai-lotto__column">
                        <p class="title__reward check-lottery-results-single-thai-lotto__box-item--bg">
                            <span class="default-font--reward">เลขท้าย 3 ตัว</span>
                            <small>2 รางวัลๆ ละ 4,000 บาท</small>
                        </p>
                        <p>
                            <strong class="check-lottery-results-single-thai-lotto__number">
                                <?php echo !empty($data['result'][6]['data'][0]) ? $data['result'][6]['data'][0] : 'XXXXXX'; ?>
                            </strong>
                            <strong class="check-lottery-results-single-thai-lotto__number">
                                <?php echo !empty($data['result'][6]['data'][1]) ? $data['result'][6]['data'][1] : 'XXXXXX'; ?>
                            </strong>
                        </p>
                    </div>
                    <div class="check-lottery-results-single-thai-lotto__column">
                        <p class="title__reward check-lottery-results-single-thai-lotto__box-item--bg">
                            <span class="default-font--reward">เลขท้าย 2 ตัว</span>
                            <small>1 รางวัลๆ ละ 2,000 บาท</small>
                        </p>
                        <p>
                            <strong class="check-lottery-results-single-thai-lotto__number">
                                <?php echo !empty($data['result'][7]['data'][0]) ? $data['result'][7]['data'][0] : 'XXXXXX'; ?>
                            </strong>
                        </p>
                    </div>
                </div>

                <div class="check-lottery-results-single-thai-lotto__sec--nearby">
                    <div class="title__reward">
                        <p>รางวัลข้างเคียงรางวัลที่ 1</p>
                        <p>2 รางวัลๆ ละ 100,000 บาท</p>
                    </div>
                    <div>
                        <strong class="check-lottery-results-single-thai-lotto__number">
                            <?php echo !empty($data['result'][11]['data'][0]) ? $data['result'][11]['data'][0] : 'XXXXXX'; ?>
                        </strong>
                        <strong class="check-lottery-results-single-thai-lotto__number">
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
                $font_mini = $k > 2 ? 'check-lottery-results-single-thai-lotto__sec--font-mini' : '';
            ?>
                <div class="check-lottery-results-single-thai-lotto__sec <?php echo $font_mini; ?>">
                    <h3 class="title__reward"><?php echo $t; ?></h3>
                    <div class="check-lottery-results-single-thai-lotto__box-item">
                        <?php foreach ($data['result'][$k]['data'] as $x => $lotto) : ?>
                            <?php if (0 === $x % 5) : ?>
                    </div>
                    <div class="check-lottery-results-single-thai-lotto__box-item">
                    <?php endif; ?>
                    <span class="check-lottery-results-single-thai-lotto__number">
                        <?php echo !empty($lotto) ? $lotto : 'XXXXXX'; ?>
                    </span>
                <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </section>


    <!-- BackDateButton -->
    <section id="BackDateButton" class="check-lottery-results-single-thai-lotto__block-backdate">
        <h4 style="text-align: center; font-weight: normal; width: 100%;">
            <span class="d-inline-block">เลือกดูวันที่ย้อนหลัง</span>
        </h4>

        <?php
        foreach ($listYears as $y => $histories) :
            foreach ($histories['result'] as $history) :
                list($year, $month, $day) = \explode('-', $history);

                $day   = \intval($day);
                $month = \intval($month);
                $year  = \intval($year);
        ?>
                <span class="check-lottery-results-single-thai-lotto__button-backdate">
                    <a href="<?php echo \sprintf('%s?lottery-date=%s', \esc_url(\get_permalink()), $history); ?>" rel="noopener noreferrer">
                        <?php echo \sprintf('%d %s %d', $day, $monthShorts[$month], ($year + 543)); ?>
                    </a>
                </span>
        <?php
            endforeach;
        endforeach;
        ?>
    </section>

<?php

    return \ob_get_clean();
}
