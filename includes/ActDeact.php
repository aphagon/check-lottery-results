<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-03-03 05:02:22
 * @LastEditTime: 2023-03-03 05:10:03
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\includes\ActDeact.php
 */

declare(strict_types=1);

namespace CheckLotteryResults;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}

final class ActDeact
{
    public static function activate(): void
    {
        foreach ([
            [
                'post_title' => 'หวยสด',
                'post_name' => 'หวยสด',
                'post_content' => '[check-lottery-results type="วันนี้"]',
            ],
            [
                'post_title' => 'หวยรัฐบาล',
                'post_name' => 'หวยรัฐบาล',
                'post_content' => '[check-lottery-results type="หวยรัฐบาล"]',
            ],
            [
                'post_title' => 'หวยฮานอย',
                'post_name' => 'หวยฮานอย',
                'post_content' => '[check-lottery-results type="หวยฮานอย"]',
            ],
            [
                'post_title' => 'หวยลาว',
                'post_name' => 'หวยลาว',
                'post_content' => '[check-lottery-results type="หวยลาว"]',
            ],
            [
                'post_title' => 'หวยหุ้น',
                'post_name' => 'หวยหุ้น',
                'post_content' => '[check-lottery-results type="หวยหุ้น"]',
            ],
            [
                'post_title' => 'หวยมาเลเซีย',
                'post_name' => 'หวยมาเลเซีย',
                'post_content' => '[check-lottery-results type="หวยมาเลเซีย"]',
            ],
            [
                'post_title' => 'หวยหุ้นวีไอพี',
                'post_name' => 'หวยหุ้นวีไอพี',
                'post_content' => '[check-lottery-results type="หวยหุ้น VIP"]',
            ],
        ] as $value) {
            $page_obj = \get_page_by_path($value['post_name']);
            if (!$page_obj) {
                $value['comment_status'] = 'closed';
                $value['post_status'] = 'publish';
                $value['post_type'] = 'page';

                \wp_insert_post($value);
            } else {
                //For cases where page may be in trash, bring it out of trash
                if ('trash' === $page_obj->post_status) {
                    \wp_update_post([
                        'ID' => $page_obj->ID,
                        'post_status' => 'publish',
                    ]);
                }
            }
        }

        // Rewrite lotto date
        global $wp;
        $wp->add_query_var('lottery-date');

        \add_rewrite_rule(
            '(.?.+?)/lottery-date-([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})/?$',
            'index.php?pagename=$matches[1]&lottery-date=$matches[2]',
            'top'
        );

        // Clear the permalinks
        \flush_rewrite_rules();
    }

    public static function deactivate(): void
    {
        \delete_option('check_lottery_result_cache');

        // Clear the permalinks
        \flush_rewrite_rules();
    }
}
