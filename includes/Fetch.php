<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-21 19:48:54
 * @LastEditTime: 2023-03-03 05:09:37
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\includes\Fetch.php
 */

declare(strict_types=1);

namespace CheckLotteryResults;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}

final class Fetch
{
    public array $types = [
        'วันนี้',
        'หวยมาเลเซีย' => [
            'หวยมาเลเซีย',
        ],
        'หวยรัฐบาล' => [
            'หวยรัฐบาล',
        ],
        'หวยฮานอย' => [
            'หวยฮานอย',
            'หวยฮานอย HD',
            'หวยฮานอยสตาร์',
            'หวยฮานอย TV',
            'หวยฮานอยกาชาด',
            'หวยฮานอยพิเศษ',
            'หวยฮานอยสามัคคี',
            'หวยฮานอยวีไอพี',
            'หวยฮานอยพัฒนา',
            'หวยฮานอย Extra',
        ],
        'หวยลาว' => [
            'หวยลาวพัฒนา',
            'หวยลาว Extra',
            'หวยลาวทีวี',
            'หวยลาว HD',
            'หวยลาวสตาร์',
            'หวยลาวสามัคคี',
            'หวยลาวกาชาด',
        ],
        'หวยหุ้น' => [
            'หวยหุ้นนิเคอิ (เช้า)',
            'หวยหุ้นนิเคอิ (บ่าย)',
            'หวยหุ้นจีน (เช้า)',
            'หวยหุ้นจีน (บ่าย)',
            'หวยหุ้นฮั้งเส็ง (เช้า)',
            'หวยหุ้นฮั้งเส็ง (บ่าย)',
            'หวยหุ้นไต้หวัน',
            'หวยหุ้นเกาหลี',
            'หวยหุ้นสิงคโปร์',
            'หวยหุ้นอินเดีย',
            'หวยหุ้นอียิปต์',
            'หวยหุ้นอังกฤษ',
            'หวยหุ้นเยอรมัน',
            'หวยหุ้นรัสเซีย',
            'หวยหุ้นดาวโจนส์',
            'หวยหุ้นไทย (เย็น)',
        ],
        'หวยหุ้น VIP' => [
            'นิเคอิ VIP (เช้า)',
            'หวยหุ้นนิเคอิ VIP (บ่าย)',
            'หวยหุ้นจีน VIP (เช้า)',
            'หวยหุ้นจีน VIP (บ่าย)',
            'หวยหุ้นฮั้งเส็ง VIP (เช้า)',
            'หวยหุ้นฮั้งเส็ง VIP (บ่าย)',
            'หวยหุ้นไต้หวัน VIP',
            'หวยหุ้นเกาหลี VIP',
            'หวยหุ้นสิงคโปร์ VIP',
            'หวยหุ้นอังกฤษ VIP',
            'หวยหุ้นเยอรมัน VIP',
            'หวยหุ้นรัสเซีย VIP',
            'หวยหุ้นดาวโจนส์ VIP',
        ],
    ];

    private string $url = 'https://center.huayded888.com';

    private Functions $functions;

    public function __construct(Functions $functions)
    {
        $this->functions = $functions;
    }

    /**
     * @return string|bool
     */
    public function curl(string $url)
    {
        $ch = \curl_init();
        \curl_setopt($ch, \CURLOPT_URL, $url);
        \curl_setopt($ch, \CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36');
        \curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, \false);
        \curl_setopt($ch, \CURLOPT_FAILONERROR, \true);
        \curl_setopt($ch, \CURLOPT_FOLLOWLOCATION, \true);
        \curl_setopt($ch, \CURLOPT_AUTOREFERER, \true);
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, \true);
        \curl_setopt($ch, \CURLOPT_TIMEOUT, 15);
        $output = \curl_exec($ch);
        $status = \curl_getinfo($ch, \CURLINFO_RESPONSE_CODE);
        \curl_close($ch);

        if ($status >= 400) {
            return '';
        }

        return $output;
    }

    private function getCache(string $key): ?array
    {
        $cache = \get_option('check_lottery_result_cache', \null);
        if (\null === $cache) {
            return \null;
        }

        $cache = \json_decode($cache, \true);

        return $cache[$key] ?? \null;
    }

    private function saveCache(string $key, array $data): void
    {
        $cache = \get_option('check_lottery_result_cache', \null);
        $cache = $cache ? \json_decode($cache, \true) : [];

        $cache[$key] = [
            'expired' => \strtotime('+2 minute', \current_time('timestamp')),
            'data'    => $data,
        ];

        \update_option('check_lottery_result_cache', (string) \json_encode($cache));
    }

    public function getToDay(): array
    {
        $results = $this->curl($this->url . '/api/v1/results');
        $cache   = $this->getCache('วันนี้');

        if ('' !== $results || \null === $cache) {
            $results = \json_decode($results, \true);
            if (($cache['expired'] ?? 0) <= \current_time('timestamp')) {
                $this->saveCache('วันนี้', $results);
            }
        } else {
            $results = $cache['data'];
        }

        $newData = [];

        $count = \count($results);
        for ($i = 0; $i < $count; $i++) {
            $key           = \str_replace(' ', '-', $results[$i]['category']);
            $newData[$key] = $results[$i];

            $this->findOrUploadIcon($newData[$key]['data']);
        }

        return $newData;
    }

    public function getHistory(string $type): array
    {
        $results = $this->curl($this->url . '/api/v1/history/' . $type);
        $cache   = $this->getCache($type);

        if ('' !== $results || \null === $cache) {
            $results = \json_decode($results, \true);
            if (($cache['expired'] ?? 0) <= \current_time('timestamp')) {
                $this->saveCache($type, $results);
            }
        } else {
            $results = $cache['data'];
        }

        $this->findOrUploadIcon($results);

        return $results;
    }

    public function getLotteryThai(?string $date = \null): ?array
    {
        $date    = $date ?? \current_time('Y-m-d');
        $cache   = $this->getCache('หวยรัฐบาล');
        $expired = $cache['data'][$date]['expired'] ?? 0;

        if ($expired <= \current_time('timestamp')) {
            $response = $this->curl('https://www.thairath.co.th/api-lottery/?date=' . $date);

            if (empty($response)) {
                return \null;
            }

            $response = \json_decode($response, \true);

            $newData = [];
            $newData[$date] = [
                'title'   => $response['data']['lotteryDateTitle'],
                'result'  => $response['data']['prizes'],
                'date'    => $date,
                'expired' => \strtotime('+2 minute', \current_time('timestamp')),
            ];

            $this->saveCache('หวยรัฐบาล', $newData);

            $results = $newData[$date];
        } else {
            $results = $cache['data'][$date] ?? \null;
        }

        return $results;
    }

    public function getLotteryThaiListYears(): array
    {
        $cache       = $this->getCache('หวยรัฐบาลรายการเดือน');
        $updateCache = \false;

        foreach (\range(\gmdate('Y', \current_time('timestamp')), 2016) as $year) {
            $expired = $cache['data'][$year]['expired'] ?? 0;

            if (-1 === (int) $expired) {
                continue;
            }

            if ($expired <= \current_time('timestamp')) {
                $ch = \curl_init();
                \curl_setopt($ch, \CURLOPT_URL, 'https://www.glo.or.th/api/lottery/getPeriodsByYear');
                \curl_setopt($ch, \CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36');
                \curl_setopt($ch, \CURLOPT_REFERER, 'https://www.glo.or.th');
                \curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'POST');
                \curl_setopt($ch, \CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                \curl_setopt($ch, \CURLOPT_POSTFIELDS, \json_encode([
                    'year' => \intval($year),
                    'type' => 'CHECKED',
                ]));
                \curl_setopt($ch, \CURLOPT_FOLLOWLOCATION, \true);
                \curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, \false);
                \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, \true);
                \curl_setopt($ch, \CURLOPT_TIMEOUT, 15);
                $response   = \curl_exec($ch);
                $statusCode = \curl_getinfo($ch, \CURLINFO_RESPONSE_CODE);
                \curl_close($ch);

                if (empty($response) || $statusCode >= 400) {
                    continue;
                }

                $response = \json_decode($response, \true);
                if (empty($response['response']['result'])) {
                    continue;
                }

                $histories = [];
                foreach ($response['response']['result'] as $history) {
                    $histories[] = $history['date'];
                }

                $expired = $year == \date('Y', \current_time('timestamp')) ? 60 * 24 : -1;

                $cache['data'][$year]['expired'] = $expired; // 1 day.
                $cache['data'][$year]['result']  = \array_unique($histories);

                $updateCache = \true;
            }
        }

        if (\true === $updateCache) {
            $this->saveCache('หวยรัฐบาลรายการเดือน', $cache['data']);
        }

        return $cache['data'] ?? [];
    }

    private function findOrUploadIcon(array &$data): void
    {
        if (empty($data)) {
            return;
        }

        foreach ($data as $i => $val) {
            $filename = \pathinfo($data[$i]['icon'], \PATHINFO_FILENAME);
            $filename = \sanitize_title($filename);
            $icon     = \get_page_by_title($filename, \OBJECT, 'attachment');

            if (\null === $icon) {
                $attachmentId = $this->functions->uploadMediaFromUrl($data[$i]['icon']);

                if (\false !== $attachmentId) {
                    $data[$i]['icon'] = \wp_get_attachment_url($attachmentId);
                }
            } else {
                $data[$i]['icon'] = $icon->guid;
            }
        }
    }
}
