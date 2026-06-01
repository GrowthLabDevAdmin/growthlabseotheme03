<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!function_exists('get_text_domain')) {
    function get_text_domain()
    {
        return $GLOBALS['theme_text_domain'];
    }
}

if (!function_exists('get_field_options')) {
    function get_field_options($field_name, $format_value = true)
    {
        if (empty($field_name) || !is_string($field_name)) return null;

        static $cache = [];
        $key = $field_name . '|' . ($format_value ? '1' : '0');
        if (array_key_exists($key, $cache)) {
            return $cache[$key];
        }

        $value       = get_field($field_name, 'option', $format_value);
        $cache[$key] = $value;
        return $value;
    }
}

if (!function_exists('filterContentByLanguage')) {
    function filterContentByLanguage($lang = 'es')
    {
        if (empty($lang) || !is_string($lang)) return false;

        $uri    = $_SERVER['REQUEST_URI'] ?? '/';
        $path   = parse_url($uri, PHP_URL_PATH) ?: '/';
        $prefix = '/' . ltrim($lang, '/');

        if ($path === $prefix) return true;
        if (strpos($path, $prefix . '/') === 0) return true;

        return false;
    }
}

if (!function_exists('get_languages_map')) {
    function get_languages_map()
    {
        static $map = null;
        if ($map !== null) return $map;

        $lang_options = get_field_options('options_by_language') ?: [];
        if (!is_array($lang_options)) {
            $map = [];
            return $map;
        }

        $map = array_column($lang_options, 'language', 'url_language_slug');
        return $map;
    }
}

if (!function_exists('get_current_language')) {
    function get_current_language()
    {
        static $cached = null;
        if ($cached !== null) return $cached;

        $languages = get_languages_map();

        foreach ($languages as $slug => $language) {
            if (filterContentByLanguage($slug)) {
                $cached = [
                    'slug'     => $slug,
                    'language' => $language
                ];
                return $cached;
            }
        }

        $cached = [
            'slug'     => '',
            'language' => 'English'
        ];

        return $cached;
    }
}

if (!function_exists('get_current_language_suffix')) {
    function get_current_language_suffix()
    {
        if (get_current_language()['slug'] !== '') return '_' . get_current_language()['slug'];
        return '';
    }
}

if (!function_exists('get_current_language_options')) {
    function get_current_language_options()
    {
        $current = get_current_language();
        $slug    = $current['slug'] ?? '';

        if ($slug === '') {
            return get_field_options('options');
        }

        $lang_opts = get_field_options('options_by_language') ?: [];
        if (!is_array($lang_opts)) return get_field_options('options');

        foreach ($lang_opts as $lang_opt) {
            if (!isset($lang_opt['url_language_slug'])) continue;
            if ($lang_opt['url_language_slug'] === $slug && isset($lang_opt['options'])) {
                return $lang_opt['options'];
            }
        }

        return get_field_options('options');
    }
}

if (!function_exists('get_flat_number')) {
    function get_flat_number($phone)
    {
        if (!$phone) return;
        return preg_replace("/[^0-9]/", '', $phone);
    }
}

if (!function_exists('get_wrapped_title')) {
    function get_wrapped_title($title, $tag = 'p', $classes = '', $is_hero = false)
    {
        if (!$title) return;
        $tag = $tag ?? ($is_hero ? 'h1' : 'p');
        return "<$tag class='$classes'>" . $title . "</$tag>";
    }
}

if (!function_exists('print_title')) {
    function print_title($title, $tag = 'p', $classes = '', $is_hero = false)
    {
        if (!$title) return;
        echo get_wrapped_title($title, $tag, $classes, $is_hero);
    }
}

if (!function_exists('dd')) {
    function dd($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }
}

if (!function_exists('format_number_abbreviated')) {
    function format_number_abbreviated($number)
    {
        if ($number >= 1000000000) {
            return round($number / 1000000000, 1) . 'B';
        } elseif ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }
        return $number;
    }
}

if (!function_exists('get_yt_code')) {
    function get_yt_code($url = false)
    {
        if (!$url) return false;
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return $match[1];
    }
}

if (!function_exists('get_youtube_thumbnail')) {
    function get_youtube_thumbnail(string $video_id, string $size = 'hqdefault'): string
    {
        $sizes = ['maxresdefault', 'sddefault', 'hqdefault', 'mqdefault', 'default'];
        $base  = "https://img.youtube.com/vi/{$video_id}";

        // Validar desde el tamaño solicitado hacia abajo
        $start = array_search($size, $sizes, true);
        $sizes = array_slice($sizes, $start !== false ? $start : 2);

        foreach ($sizes as $s) {
            $url      = "{$base}/{$s}.jpg";
            $response = wp_remote_head($url);

            if (! is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
                // YouTube devuelve un placeholder 120×90 para tamaños no disponibles
                $headers = wp_remote_retrieve_headers($response);
                $length  = (int) ($headers['content-length'] ?? 0);
                if ($length > 2000) return $url; // el placeholder pesa ~1.4kb
            }
        }

        return "{$base}/hqdefault.jpg"; // fallback seguro
    }
}
