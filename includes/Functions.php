<?php
/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-21 19:48:54
 * @LastEditTime: 2023-03-02 04:05:27
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\includes\Functions.php
 */

declare(strict_types=1);

namespace CheckLotteryResults;

// If this file is called directly, abort.
if (!\defined('ABSPATH')) {
    \header('HTTP/1.1 404 Not Found');
    exit;
}

final class Functions
{
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
        \curl_setopt($ch, \CURLOPT_TIMEOUT, 10);
        $output = \curl_exec($ch);
        $status = \curl_getinfo($ch, \CURLINFO_RESPONSE_CODE);
        \curl_close($ch);

        if ($status >= 400) {
            return '';
        }

        return $output;
    }

    /**
     * Flattens a multidimensional array into a single-dimensional array.
     *
     * @param array $array The array to flatten.
     * @return array The flattened array.
     */
    public function arrayFlatten(array $array): array
    {
        $result = [];

        foreach ($array as $element) {
            if (\is_array($element)) {
                $result = \array_merge($result, $this->arrayFlatten($element));
            } else {
                $result[] = $element;
            }
        }

        return $result;
    }

    /**
     * Upload a file to the media library using a URL.
     *
     * @param string $url         URL to be uploaded
     * @param null|string $title  If set, used as the post_title
     *
     * @return int|false
     */
    public function uploadMediaFromUrl(string $url)
    {
        require_once \ABSPATH . '/wp-admin/includes/image.php';
        require_once \ABSPATH . '/wp-admin/includes/file.php';
        require_once \ABSPATH . '/wp-admin/includes/media.php';

        // Download url to a temp file
        $tmp = \download_url($url);
        if (\is_wp_error($tmp)) {
            return \false;
        }

        // Get the filename and extension ("photo.png" => "photo", "png")
        $filename  = \pathinfo($url, \PATHINFO_FILENAME);
        $filename  = \sanitize_title($filename);
        $extension = \pathinfo($url, \PATHINFO_EXTENSION);

        // An extension is required or else WordPress will reject the upload
        if (!$extension) {
            // Look up mime type, example: "/photo.png" -> "image/png"
            $mime = \mime_content_type($tmp);
            $mime = \is_string($mime) ? \sanitize_mime_type($mime) : \false;

            // Only allow certain mime types because mime types do not always end in a valid extension (see the .doc example below)
            $mimeExtensions = [
                // mime_type => extension (no period)
                'image/jpg'  => 'jpg',
                'image/jpeg' => 'jpeg',
                'image/gif'  => 'gif',
                'image/png'  => 'png',
            ];

            if (isset($mimeExtensions[$mime])) {
                // Use the mapped extension
                $extension = $mimeExtensions[$mime];
            } else {
                // Could not identify extension
                @unlink($tmp);
                return \false;
            }
        }

        // Upload by "sideloading": "the same way as an uploaded file is handled by media_handle_upload"
        $args = [
            'name'     => "$filename.$extension",
            'tmp_name' => $tmp,
        ];

        // Do the upload
        $attachmentId = \media_handle_sideload($args, 0, \null);

        // Cleanup temp file
        @unlink($tmp);

        // Error uploading
        if (\is_wp_error($attachmentId)) {
            return \false;
        }

        // Success, return attachment ID (int)
        return (int) $attachmentId;
    }
}
