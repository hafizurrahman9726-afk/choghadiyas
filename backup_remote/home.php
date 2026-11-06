<?php
/**
 * Premium Homepage Template
 * Choghadiya Muhurat Website - Authority Platform
 */

require_once __DIR__ . '/../config/config.php';

// The homepage and selected API locations use Indian local time.
if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('Asia/Kolkata');
}


/** Homepage display helpers. These read only columns returned by the existing queries. */
if (!function_exists('choghadiyas_home_field')) {
    function choghadiyas_home_field($row, $keys) {
        if (!is_array($row)) {
            return '';
        }
        foreach ($keys as $key) {
            if (array_key_exists($key, $row) && is_scalar($row[$key])) {
                $value = trim((string) $row[$key]);
                if ($value !== '') {
                    return $value;
                }
            }
        }
        return '';
    }
}

if (!function_exists('choghadiyas_home_time')) {
    function choghadiyas_home_time($value) {
        if (!is_scalar($value)) {
            return '';
        }
        $value = trim((string) $value);
        if ($value === '') {
            return '';
        }
        if (preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $value)) {
            $timestamp = strtotime($value);
            if ($timestamp !== false) {
                return date('h:i A', $timestamp);
            }
        }
        // ISO timestamps can be returned by the API; render them in India time.
        if (preg_match('/^\d{4}-\d{2}-\d{2}[T ]\d{2}:\d{2}/', $value)) {
            try {
                $date = new DateTime($value);
                $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
                return $date->format('h:i A');
            } catch (Exception $e) {
                return $value;
            }
        }
        return $value;
    }
}

if (!function_exists('choghadiyas_home_time_range')) {
    function choghadiyas_home_time_range($row) {
        $direct = choghadiyas_home_field($row, array('time_range', 'timing', 'period_timing', 'choghadiya_time', 'duration_text'));
        if ($direct !== '') {
            return $direct;
        }
        $start = choghadiyas_home_field($row, array('start_time', 'time_from', 'period_start', 'start_at', 'from_time', 'start'));
        $end = choghadiyas_home_field($row, array('end_time', 'time_to', 'period_end', 'end_at', 'to_time', 'end'));
        $start = choghadiyas_home_time($start);
        $end = choghadiyas_home_time($end);
        if ($start !== '' && $end !== '') {
            return $start . ' – ' . $end;
        }
        return $start !== '' ? $start : $end;
    }
}

if (!function_exists('choghadiyas_home_period_name')) {
    function choghadiyas_home_period_name($row) {
        return choghadiyas_home_field($row, array('choghadiya_name', 'period_name', 'name', 'choghadiya', 'muhurat_name'));
    }
}

if (!function_exists('choghadiyas_home_period_is_day')) {
    function choghadiyas_home_period_is_day($row) {
        $type = strtolower(choghadiyas_home_field($row, array('period_type', 'type', 'period')));
        if ($type === '') {
            return true;
        }
        if (strpos($type, 'day') !== false || strpos($type, 'दिन') !== false || strpos($type, 'दिवस') !== false) {
            return true;
        }
        if (strpos($type, 'night') !== false || strpos($type, 'रात') !== false || strpos($type, 'रात्रि') !== false) {
            return false;
        }
        return false;
    }
}

if (!function_exists('choghadiyas_home_nature_class')) {
    function choghadiyas_home_nature_class($name) {
        $name = strtolower((string) $name);
        if (strpos($name, 'amrit') !== false || strpos($name, 'shubh') !== false || strpos($name, 'labh') !== false || strpos($name, 'अमृत') !== false || strpos($name, 'शुभ') !== false || strpos($name, 'लाभ') !== false) {
            return 'good';
        }
        if (strpos($name, 'rog') !== false || strpos($name, 'kaal') !== false || strpos($name, 'काल') !== false || strpos($name, 'रोग') !== false) {
            return 'bad';
        }
        return 'neutral';
    }
}

if (!function_exists('choghadiyas_home_nature_label')) {
    function choghadiyas_home_nature_label($name) {
        $class = choghadiyas_home_nature_class($name);
        if ($class === 'good') {
            return 'परंपरा में शुभ माना जाता है';
        }
        if ($class === 'bad') {
            return 'परंपरा में अशुभ माना जाता है';
        }
        return 'पारंपरिक श्रेणी';
    }
}

if (!function_exists('choghadiyas_home_rahukaal')) {
    function choghadiyas_home_rahukaal($row) {
        $direct = choghadiyas_home_field($row, array('rahu_kaal', 'rahukaal', 'rahu_kaal_time', 'rahukaal_time', 'rahu_kala', 'rahu_kala_time'));
        if ($direct !== '') {
            return $direct;
        }
        $start = choghadiyas_home_field($row, array('rahu_kaal_start', 'rahukaal_start', 'rahu_start_time', 'rahu_kala_start'));
        $end = choghadiyas_home_field($row, array('rahu_kaal_end', 'rahukaal_end', 'rahu_end_time', 'rahu_kala_end'));
        $start = choghadiyas_home_time($start);
        $end = choghadiyas_home_time($end);
        return ($start !== '' && $end !== '') ? $start . ' – ' . $end : '';
    }
}



/** Navamsha API integration helpers. API secrets are read only from server config/env. */
if (!function_exists('choghadiyas_home_api_key')) {
    function choghadiyas_home_api_key() {
        if (defined('NAVAMSHA_API_KEY')) {
            $key = trim((string) NAVAMSHA_API_KEY);
            if ($key !== '' && stripos($key, 'PASTE_NEW_') !== 0 && stripos($key, 'YOUR_') !== 0) {
                return $key;
            }
        }
        $envKey = getenv('NAVAMSHA_API_KEY');
        if (is_string($envKey)) {
            $envKey = trim($envKey);
            if ($envKey !== '' && stripos($envKey, 'PASTE_NEW_') !== 0 && stripos($envKey, 'YOUR_') !== 0) {
                return $envKey;
            }
        }
        return '';
    }
}

if (!function_exists('choghadiyas_home_api_normalize_key')) {
    function choghadiyas_home_api_normalize_key($key) {
        return strtolower(preg_replace('/[^a-z0-9]/i', '', (string) $key));
    }
}

if (!function_exists('choghadiyas_home_api_find')) {
    function choghadiyas_home_api_find($data, $keys, $depth = 0) {
        if (!is_array($data) || $depth > 6) {
            return null;
        }
        $wanted = array();
        foreach ((array) $keys as $key) {
            $wanted[] = choghadiyas_home_api_normalize_key($key);
        }
        foreach ($data as $key => $value) {
            if (is_string($key) && in_array(choghadiyas_home_api_normalize_key($key), $wanted, true)) {
                return $value;
            }
        }
        foreach ($data as $value) {
            if (is_array($value)) {
                $found = choghadiyas_home_api_find($value, $keys, $depth + 1);
                if ($found !== null && $found !== '') {
                    return $found;
                }
            }
        }
        return null;
    }
}

if (!function_exists('choghadiyas_home_api_scalar')) {
    function choghadiyas_home_api_scalar($value) {
        if (is_scalar($value)) {
            return trim((string) $value);
        }
        if (!is_array($value)) {
            return '';
        }
        $direct = choghadiyas_home_api_find($value, array('local_time', 'localTime', 'formatted_time', 'formatted', 'display', 'time_text', 'value', 'name', 'label', 'time'));
        if (is_scalar($direct) && trim((string) $direct) !== '') {
            return trim((string) $direct);
        }
        $start = choghadiyas_home_api_find($value, array('start_time', 'startTime', 'start', 'from', 'begin_time', 'begin'));
        $end = choghadiyas_home_api_find($value, array('end_time', 'endTime', 'end', 'to', 'finish_time', 'finish'));
        $start = choghadiyas_home_time($start);
        $end = choghadiyas_home_time($end);
        if ($start !== '' && $end !== '') {
            return $start . ' – ' . $end;
        }
        return '';
    }
}

if (!function_exists('choghadiyas_home_api_request')) {
    function choghadiyas_home_api_request($endpoint, $payload, $cacheSeconds = 86400) {
        $apiKey = choghadiyas_home_api_key();
        if ($apiKey === '' || !is_array($payload)) {
            return null;
        }

        $cacheDirectory = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'choghadiyas_navamsha_cache';
        if (!is_dir($cacheDirectory)) {
            @mkdir($cacheDirectory, 0700, true);
        }
        $cacheFile = $cacheDirectory . DIRECTORY_SEPARATOR . sha1($endpoint . '|' . json_encode($payload)) . '.json';
        $failureFile = $cacheFile . '.fail';
        if (is_file($cacheFile) && (time() - (int) @filemtime($cacheFile)) < max(60, (int) $cacheSeconds)) {
            $cached = json_decode((string) @file_get_contents($cacheFile), true);
            if (is_array($cached) && isset($cached['statusCode']) && (int) $cached['statusCode'] >= 200 && (int) $cached['statusCode'] < 300 && isset($cached['output']) && is_array($cached['output'])) {
                return $cached;
            }
        }
        // Temporarily cache errors too, so a bad key or outage does not trigger six calls per page view.
        if (is_file($failureFile) && (time() - (int) @filemtime($failureFile)) < 300) {
            return null;
        }

        $url = 'https://api.navamsha.in/api/v1/panchang/' . rawurlencode((string) $endpoint);
        $body = json_encode($payload);
        if (!is_string($body)) {
            return null;
        }
        $responseBody = false;
        $httpCode = 0;
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => array('X-API-Key: ' . $apiKey, 'Content-Type: application/json', 'Accept: application/json'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 2,
                CURLOPT_TIMEOUT => 4,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_FOLLOWLOCATION => false,
            ));
            $responseBody = curl_exec($ch);
            $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $context = stream_context_create(array('http' => array(
                'method' => 'POST',
                'header' => "X-API-Key: " . $apiKey . "\r\nContent-Type: application/json\r\nAccept: application/json\r\n",
                'content' => $body,
                'timeout' => 4,
                'ignore_errors' => true,
            ), 'ssl' => array('verify_peer' => true, 'verify_peer_name' => true)));
            $responseBody = @file_get_contents($url, false, $context);
            if (isset($http_response_header) && is_array($http_response_header)) {
                foreach ($http_response_header as $headerLine) {
                    if (preg_match('/^HTTP\\/\\d(?:\\.\\d)?\\s+(\\d+)/i', $headerLine, $matches)) {
                        $httpCode = (int) $matches[1];
                    }
                }
            }
        }

        if (!is_string($responseBody) || $responseBody === '' || $httpCode < 200 || $httpCode >= 300) {
            // Never echo API errors or secrets into the public HTML.
            if (is_dir($cacheDirectory) && is_writable($cacheDirectory)) {
                @file_put_contents($failureFile, (string) time(), LOCK_EX);
                @chmod($failureFile, 0600);
            }
            return null;
        }
        $decoded = json_decode($responseBody, true);
        if (!is_array($decoded) || !isset($decoded['output']) || !is_array($decoded['output'])) {
            if (is_dir($cacheDirectory) && is_writable($cacheDirectory)) {
                @file_put_contents($failureFile, (string) time(), LOCK_EX);
                @chmod($failureFile, 0600);
            }
            return null;
        }
        $statusCode = isset($decoded['statusCode']) ? (int) $decoded['statusCode'] : $httpCode;
        if ($statusCode < 200 || $statusCode >= 300) {
            if (is_dir($cacheDirectory) && is_writable($cacheDirectory)) {
                @file_put_contents($failureFile, (string) time(), LOCK_EX);
                @chmod($failureFile, 0600);
            }
            return null;
        }
        if (is_dir($cacheDirectory) && is_writable($cacheDirectory)) {
            @file_put_contents($cacheFile, json_encode($decoded), LOCK_EX);
            @chmod($cacheFile, 0600);
            @unlink($failureFile);
        }
        return $decoded;
    }
}

if (!function_exists('choghadiyas_home_api_output')) {
    function choghadiyas_home_api_output($response) {
        return (is_array($response) && isset($response['output']) && is_array($response['output'])) ? $response['output'] : array();
    }
}

if (!function_exists('choghadiyas_home_api_format_component')) {
    function choghadiyas_home_api_format_component($component, $kind = '') {
        if (is_scalar($component)) {
            return trim((string) $component);
        }
        if (!is_array($component)) {
            return '';
        }
        $name = choghadiyas_home_api_find($component, array('name', 'label', 'display_name', 'displayName', 'value'));
        if (!is_scalar($name) || trim((string) $name) === '') {
            return choghadiyas_home_api_scalar($component);
        }
        $name = trim((string) $name);
        $normalized = choghadiyas_home_api_normalize_key($name);
        $translations = array(
            'tithi' => array(
                'pratipada' => 'प्रतिपदा', 'prathama' => 'प्रतिपदा', 'dwitiya' => 'द्वितीया', 'tritiya' => 'तृतीया',
                'chaturthi' => 'चतुर्थी', 'panchami' => 'पंचमी', 'shashthi' => 'षष्ठी', 'sashti' => 'षष्ठी',
                'saptami' => 'सप्तमी', 'ashtami' => 'अष्टमी', 'navami' => 'नवमी', 'dashami' => 'दशमी',
                'ekadashi' => 'एकादशी', 'dwadashi' => 'द्वादशी', 'trayodashi' => 'त्रयोदशी', 'chaturdashi' => 'चतुर्दशी',
                'purnima' => 'पूर्णिमा', 'purnamasi' => 'पूर्णिमा', 'amavasya' => 'अमावस्या'
            ),
            'nakshatra' => array(
                'ashwini' => 'अश्विनी', 'bharani' => 'भरणी', 'krittika' => 'कृत्तिका', 'rohini' => 'रोहिणी',
                'mrigashira' => 'मृगशिरा', 'ardra' => 'आर्द्रा', 'punarvasu' => 'पुनर्वसु', 'pushya' => 'पुष्य',
                'ashlesha' => 'आश्लेषा', 'magha' => 'मघा', 'purvaphalguni' => 'पूर्वा फाल्गुनी', 'uttaraphalguni' => 'उत्तरा फाल्गुनी',
                'hasta' => 'हस्त', 'chitra' => 'चित्रा', 'swati' => 'स्वाति', 'vishakha' => 'विशाखा',
                'anuradha' => 'अनुराधा', 'jyeshtha' => 'ज्येष्ठा', 'mula' => 'मूल', 'purvashadha' => 'पूर्वाषाढ़ा',
                'uttarashadha' => 'उत्तराषाढ़ा', 'shravana' => 'श्रवण', 'dhanishta' => 'धनिष्ठा', 'shatabhisha' => 'शतभिषा',
                'purvabhadrapada' => 'पूर्वा भाद्रपद', 'uttarabhadrapada' => 'उत्तरा भाद्रपद', 'revati' => 'रेवती'
            ),
            'yoga' => array(
                'vishkambha' => 'विष्कम्भ', 'priti' => 'प्रीति', 'ayushman' => 'आयुष्मान', 'saubhagya' => 'सौभाग्य',
                'shobhana' => 'शोभन', 'atiganda' => 'अतिगण्ड', 'sukarma' => 'सुकर्मा', 'dhriti' => 'धृति',
                'shula' => 'शूल', 'ganda' => 'गण्ड', 'vriddhi' => 'वृद्धि', 'dhruva' => 'ध्रुव', 'vyaghata' => 'व्याघात',
                'harshana' => 'हर्षण', 'vajra' => 'वज्र', 'siddhi' => 'सिद्धि', 'vyatipata' => 'व्यतीपात',
                'variyan' => 'वरीयान', 'parigha' => 'परिघ', 'shiva' => 'शिव', 'siddha' => 'सिद्ध',
                'sadhya' => 'साध्य', 'shubha' => 'शुभ', 'shukla' => 'शुक्ल', 'brahma' => 'ब्रह्म', 'indra' => 'इन्द्र', 'vaidhriti' => 'वैधृति'
            ),
            'karana' => array(
                'bava' => 'बव', 'balava' => 'बालव', 'kaulava' => 'कौलव', 'taitila' => 'तैतिल', 'garaja' => 'गरज',
                'vanija' => 'वणिज', 'vishti' => 'विष्टि', 'bhadra' => 'भद्रा', 'shakuni' => 'शकुनि',
                'chatushpada' => 'चतुष्पद', 'naga' => 'नाग', 'kimstughna' => 'किंस्तुघ्न'
            ),
            'weekday' => array(
                'sunday' => 'रविवार', 'monday' => 'सोमवार', 'tuesday' => 'मंगलवार', 'wednesday' => 'बुधवार',
                'thursday' => 'गुरुवार', 'friday' => 'शुक्रवार', 'saturday' => 'शनिवार'
            )
        );
        if (isset($translations[$kind][$normalized])) {
            $name = $translations[$kind][$normalized];
        }
        if ($kind === 'tithi') {
            $paksha = choghadiyas_home_api_find($component, array('paksha', 'fortnight'));
            if (is_scalar($paksha) && trim((string) $paksha) !== '') {
                $pakshaNorm = choghadiyas_home_api_normalize_key($paksha);
                $pakshaHindi = ($pakshaNorm === 'shukla' || $pakshaNorm === 'sukla') ? 'शुक्ल पक्ष' : (($pakshaNorm === 'krishna' || $pakshaNorm === 'dark') ? 'कृष्ण पक्ष' : trim((string) $paksha));
                $name = $pakshaHindi . ' ' . $name;
            }
        }
        if ($kind === 'nakshatra') {
            $pada = choghadiyas_home_api_find($component, array('pada', 'charana', 'quarter'));
            if (is_scalar($pada) && trim((string) $pada) !== '') {
                $name .= ' (पाद ' . trim((string) $pada) . ')';
            }
        }
        return $name;
    }
}

if (!function_exists('choghadiyas_home_api_extract_periods')) {
    function choghadiyas_home_api_extract_periods($output, $type) {
        if (!is_array($output)) {
            return array();
        }
        $keys = ($type === 'night')
            ? array('night', 'night_periods', 'night_choghadiya', 'night_choghadiyas', 'night_slots', 'night_period')
            : array('day', 'day_periods', 'day_choghadiya', 'day_choghadiyas', 'day_slots', 'day_period');
        $bucket = choghadiyas_home_api_find($output, $keys);
        if (is_array($bucket)) {
            foreach (array('periods', 'slots', 'choghadiya', 'windows', 'items', 'timings') as $nestedKey) {
                if (isset($bucket[$nestedKey]) && is_array($bucket[$nestedKey])) {
                    $bucket = $bucket[$nestedKey];
                    break;
                }
            }
        }
        if (!is_array($bucket) || empty($bucket)) {
            $allPeriods = choghadiyas_home_api_find($output, array('periods', 'slots', 'choghadiya_periods', 'windows', 'items'));
            if (is_array($allPeriods)) {
                $bucket = array();
                foreach ($allPeriods as $row) {
                    if (!is_array($row)) {
                        continue;
                    }
                    $periodType = strtolower((string) choghadiyas_home_api_find($row, array('period_type', 'time_of_day', 'part_of_day', 'day_night')));
                    $isNight = (strpos($periodType, 'night') !== false || strpos($periodType, 'रात') !== false);
                    if (($type === 'night' && $isNight) || ($type === 'day' && !$isNight)) {
                        $bucket[] = $row;
                    }
                }
            }
        }
        if (!is_array($bucket) || empty($bucket)) {
            return array();
        }
        // Some responses wrap each period in a second container.
        if (isset($bucket['periods']) && is_array($bucket['periods'])) {
            $bucket = $bucket['periods'];
        }
        $rows = array();
        foreach ($bucket as $index => $item) {
            if (!is_array($item)) {
                continue;
            }
            $name = choghadiyas_home_api_find($item, array('choghadiya_name', 'choghadiya', 'period_name', 'name', 'label', 'muhurat_name', 'slot_name', 'quality'));
            $start = choghadiyas_home_api_find($item, array('start_time', 'startTime', 'start', 'from_time', 'from', 'begin_time', 'begin', 'starts_at', 'start_at'));
            $end = choghadiyas_home_api_find($item, array('end_time', 'endTime', 'end', 'to_time', 'to', 'finish_time', 'finish', 'ends_at', 'end_at'));
            $range = choghadiyas_home_api_find($item, array('time_range', 'timing', 'period_timing', 'duration_text', 'time_text'));
            $name = choghadiyas_home_api_scalar($name);
            $start = choghadiyas_home_api_scalar($start);
            $end = choghadiyas_home_api_scalar($end);
            $range = choghadiyas_home_api_scalar($range);
            if ($range === '' && $start !== '' && $end !== '') {
                $range = choghadiyas_home_time($start) . ' – ' . choghadiyas_home_time($end);
            }
            if ($name === '' && $range === '' && $start === '' && $end === '') {
                continue;
            }
            $rows[] = array(
                'period_type' => $type,
                'period_number' => is_numeric($index) ? ((int) $index + 1) : (count($rows) + 1),
                'period_name' => $name,
                'choghadiya_name' => $name,
                'start_time' => $start,
                'end_time' => $end,
                'time_range' => $range,
                'api_quality' => choghadiyas_home_api_scalar(choghadiyas_home_api_find($item, array('nature', 'classification', 'quality', 'category'))),
            );
        }
        return $rows;
    }
}

if (!function_exists('choghadiyas_home_api_range')) {
    function choghadiyas_home_api_range($value) {
        if (is_scalar($value)) {
            return trim((string) $value);
        }
        if (!is_array($value)) {
            return '';
        }
        $range = choghadiyas_home_api_find($value, array('time_range', 'timing', 'duration_text', 'formatted', 'display'));
        if (is_scalar($range) && trim((string) $range) !== '') {
            return trim((string) $range);
        }
        $start = choghadiyas_home_api_find($value, array('start_time', 'startTime', 'start', 'from_time', 'from', 'begin_time'));
        $end = choghadiyas_home_api_find($value, array('end_time', 'endTime', 'end', 'to_time', 'to', 'finish_time'));
        $start = choghadiyas_home_api_scalar($start);
        $end = choghadiyas_home_api_scalar($end);
        if ($start !== '' && $end !== '') {
            return choghadiyas_home_time($start) . ' – ' . choghadiyas_home_time($end);
        }
        return choghadiyas_home_api_scalar($value);
    }
}

// Performance optimizations
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

// Set page meta
$page_title = $site_settings['name'] . ' - ' . $site_settings['tagline'];
$page_description = 'आज का चौघड़िया, शुभ मुहूर्त, दैनिक पंचांग और हिंदू त्योहारों की तिथियों की जानकारी। स्थानीय समय के अनुसार धार्मिक और शुभ अवसरों से जुड़ी उपयोगी जानकारी प्राप्त करें।';
$page_keywords = 'चौघड़िया, choghadiya, शुभ मुहूर्त, muhurat, पंचांग, panchang, हिंदू त्योहार, hindu calendar, तिथि, nakshatra';
$canonical_url = SITE_URL . '/';

// Default location can be changed by visitors; only approved city IDs are accepted.
$navamsha_cities = array(
    'delhi' => array('name' => 'नई दिल्ली', 'latitude' => 28.6139, 'longitude' => 77.2090),
    'mumbai' => array('name' => 'मुंबई', 'latitude' => 19.0760, 'longitude' => 72.8777),
    'chennai' => array('name' => 'चेन्नई', 'latitude' => 13.0827, 'longitude' => 80.2707),
    'kolkata' => array('name' => 'कोलकाता', 'latitude' => 22.5726, 'longitude' => 88.3639),
    'bengaluru' => array('name' => 'बेंगलुरु', 'latitude' => 12.9716, 'longitude' => 77.5946),
    'hyderabad' => array('name' => 'हैदराबाद', 'latitude' => 17.3850, 'longitude' => 78.4867),
    'ujjain' => array('name' => 'उज्जैन', 'latitude' => 23.1765, 'longitude' => 75.7885),
    'jaipur' => array('name' => 'जयपुर', 'latitude' => 26.9124, 'longitude' => 75.7873),
    'lucknow' => array('name' => 'लखनऊ', 'latitude' => 26.8467, 'longitude' => 80.9462),
    'patna' => array('name' => 'पटना', 'latitude' => 25.5941, 'longitude' => 85.1376)
);
$navamsha_requested_city = isset($_GET['city']) && is_string($_GET['city']) ? strtolower(trim($_GET['city'])) : 'delhi';
$navamsha_selected_city_id = isset($navamsha_cities[$navamsha_requested_city]) ? $navamsha_requested_city : 'delhi';
$navamsha_selected_city = $navamsha_cities[$navamsha_selected_city_id];
$navamsha_city_name = $navamsha_selected_city['name'];
$navamsha_timezone_offset = 5.5;
$navamsha_api_connected = false;
$navamsha_api_status = array();

// Fetch all content from database
$featured_articles = db_fetch_all("
    SELECT p.*, c.name as category_name, c.slug as category_slug, u.full_name as author_name, u.profile_image as author_image
    FROM posts p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN users u ON p.author_id = u.id
    WHERE p.status = 'published' AND p.is_featured = 1
    ORDER BY p.publish_date DESC
    LIMIT 6
");

$latest_articles = db_fetch_all("
    SELECT p.*, c.name as category_name, c.slug as category_slug, u.full_name as author_name
    FROM posts p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN users u ON p.author_id = u.id
    WHERE p.status = 'published'
    ORDER BY p.publish_date DESC
    LIMIT 8
");

// Use real published posts as a fallback when no posts are marked as featured.
if (empty($featured_articles) && !empty($latest_articles)) {
    $featured_articles = $latest_articles;
}

$trending_posts = db_fetch_all("
    SELECT p.*, c.name as category_name, c.slug as category_slug
    FROM posts p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 'published' AND p.is_trending = 1
    ORDER BY p.views DESC
    LIMIT 5
");

$popular_posts = db_fetch_all("
    SELECT p.*, c.name as category_name, c.slug as category_slug
    FROM posts p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 'published'
    ORDER BY p.views DESC
    LIMIT 5
");

$categories = db_fetch_all("
    SELECT * FROM categories
    WHERE status = 'active'
    ORDER BY sort_order ASC
");

$faqs = db_fetch_all("
    SELECT * FROM faqs
    WHERE status = 'active'
    ORDER BY sort_order ASC
    LIMIT 12
");

$festivals = db_fetch_all("
    SELECT * FROM festivals
    WHERE status = 'active' AND festival_date >= CURDATE()
    ORDER BY festival_date ASC
    LIMIT 6
");

// Get today's choghadiya from daily_choghadiya table
$today_choghadiya = db_fetch_one("
    SELECT * FROM daily_choghadiya
    WHERE choghadiya_date = CURDATE() AND status = 'active'
    ORDER BY id DESC LIMIT 1
");

// Get choghadiya periods if main entry exists
$today_choghadiya_periods = [];
if ($today_choghadiya) {
    $today_choghadiya_periods = db_fetch_all("
        SELECT * FROM choghadiya_periods
        WHERE daily_choghadiya_id = ?
        ORDER BY period_type, period_number
    ", [$today_choghadiya['id']]);
}

// Keep day periods separate from night periods for display.
$home_day_periods = [];
if (is_array($today_choghadiya_periods)) {
    foreach ($today_choghadiya_periods as $home_period_row) {
        if (choghadiyas_home_period_is_day($home_period_row)) {
            $home_day_periods[] = $home_period_row;
        }
    }
}

// Get today's panchang from daily_panchang table
$today_panchang = db_fetch_one("
    SELECT * FROM daily_panchang
    WHERE panchang_date = CURDATE() AND status = 'active'
    ORDER BY id DESC LIMIT 1
");

// Pull live Panchang data from Navamsha when a server-side API key is configured.
// Day-level windows are cached by date/location; current Panchang data refreshes in 30-minute slots.
$navamsha_today = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
$navamsha_base_payload = array(
    'year' => (int) $navamsha_today->format('Y'),
    'month' => (int) $navamsha_today->format('n'),
    'date' => (int) $navamsha_today->format('j'),
    'hours' => 12,
    'minutes' => 0,
    'latitude' => (float) $navamsha_selected_city['latitude'],
    'longitude' => (float) $navamsha_selected_city['longitude'],
    'timezone' => (float) $navamsha_timezone_offset
);
$navamsha_current_payload = $navamsha_base_payload;
$navamsha_current_payload['hours'] = (int) $navamsha_today->format('G');
$navamsha_current_payload['minutes'] = (int) (floor(((int) $navamsha_today->format('i')) / 30) * 30);

$navamsha_full_response = choghadiyas_home_api_request('full', $navamsha_current_payload, 1800);
$navamsha_choghadiya_response = choghadiyas_home_api_request('choghadiya', $navamsha_base_payload, 86400);
$navamsha_inauspicious_response = choghadiyas_home_api_request('inauspicious-periods', $navamsha_base_payload, 86400);
$navamsha_sun_response = choghadiyas_home_api_request('sun-times', $navamsha_base_payload, 86400);
$navamsha_moon_response = choghadiyas_home_api_request('moon-times', $navamsha_base_payload, 86400);
$navamsha_abhijit_response = choghadiyas_home_api_request('abhijit-muhurat', $navamsha_base_payload, 86400);

$navamsha_full = choghadiyas_home_api_output($navamsha_full_response);
$navamsha_choghadiya = choghadiyas_home_api_output($navamsha_choghadiya_response);
$navamsha_inauspicious = choghadiyas_home_api_output($navamsha_inauspicious_response);
$navamsha_sun = choghadiyas_home_api_output($navamsha_sun_response);
$navamsha_moon = choghadiyas_home_api_output($navamsha_moon_response);
$navamsha_abhijit = choghadiyas_home_api_output($navamsha_abhijit_response);

$navamsha_day_periods = choghadiyas_home_api_extract_periods($navamsha_choghadiya, 'day');
$navamsha_night_periods = choghadiyas_home_api_extract_periods($navamsha_choghadiya, 'night');
if (!empty($navamsha_day_periods) || !empty($navamsha_night_periods)) {
    $today_choghadiya_periods = array_merge($navamsha_day_periods, $navamsha_night_periods);
    $today_choghadiya = array('choghadiya_date' => $navamsha_today->format('Y-m-d'), 'status' => 'active', 'api_source' => 'Navamsha');
    $navamsha_api_connected = true;
    $navamsha_api_status['choghadiya'] = true;
}

// Start with the database row as a fallback, then let successful API fields take priority.
$today_panchang = is_array($today_panchang) ? $today_panchang : array();
$navamsha_components = array(
    'tithi' => array('kind' => 'tithi', 'end' => array('end_time', 'endTime', 'ends_at', 'end_datetime', 'end')),
    'nakshatra' => array('kind' => 'nakshatra', 'end' => array('end_time', 'endTime', 'ends_at', 'end_datetime', 'end')),
    'yoga' => array('kind' => 'yoga', 'end' => array('end_time', 'endTime', 'ends_at', 'end_datetime', 'end')),
    'karana' => array('kind' => 'karana', 'end' => array('end_time', 'endTime', 'ends_at', 'end_datetime', 'end')),
    'weekday' => array('kind' => 'weekday', 'end' => array())
);
foreach ($navamsha_components as $componentKey => $componentMeta) {
    if (!isset($navamsha_full[$componentKey])) {
        continue;
    }
    $componentValue = choghadiyas_home_api_format_component($navamsha_full[$componentKey], $componentMeta['kind']);
    if ($componentValue !== '') {
        $today_panchang[$componentKey] = $componentValue;
        $today_panchang[$componentKey . '_name'] = $componentValue;
        $navamsha_api_connected = true;
        $navamsha_api_status[$componentKey] = true;
    }
    if (!empty($componentMeta['end'])) {
        $endValue = choghadiyas_home_api_find($navamsha_full[$componentKey], $componentMeta['end']);
        $endText = choghadiyas_home_api_scalar($endValue);
        if ($endText !== '') {
            $today_panchang[$componentKey . '_end_time'] = choghadiyas_home_time($endText);
        }
    }
}

// Map sun/moon data using documented routes; tolerate nested response shapes.
$solarTargets = array(
    'sunrise' => array('sunrise', 'sunrise_time', 'sun_rise', 'sunrise_at'),
    'sunset' => array('sunset', 'sunset_time', 'sun_set', 'sunset_at'),
    'moonrise' => array('moonrise', 'moonrise_time', 'moon_rise', 'moonrise_at'),
    'moonset' => array('moonset', 'moonset_time', 'moon_set', 'moonset_at')
);
foreach ($solarTargets as $target => $aliases) {
    $source = (strpos($target, 'moon') === 0) ? $navamsha_moon : $navamsha_sun;
    $rawValue = choghadiyas_home_api_find($source, $aliases);
    $displayValue = choghadiyas_home_api_scalar($rawValue);
    if ($displayValue !== '') {
        $today_panchang[$target] = choghadiyas_home_time($displayValue);
        $navamsha_api_connected = true;
        $navamsha_api_status[$target] = true;
    }
}

// Map Rahu Kaal, Gulika and Yamaganda if returned by the inauspicious-periods route.
$inauspiciousTargets = array(
    'rahu_kaal' => array('rahu_kaal', 'rahukaal', 'rahu_kala', 'rahu'),
    'gulika_kaal' => array('gulika_kaal', 'gulikakaal', 'gulika_kala', 'gulika'),
    'yamaganda' => array('yamaganda', 'yama_ganda', 'yamagandam')
);
foreach ($inauspiciousTargets as $target => $aliases) {
    $rawValue = choghadiyas_home_api_find($navamsha_inauspicious, $aliases);
    $displayValue = choghadiyas_home_api_range($rawValue);
    if ($displayValue !== '') {
        $today_panchang[$target] = $displayValue;
        $navamsha_api_connected = true;
        $navamsha_api_status[$target] = true;
    }
}

// Abhijit Muhurat can be an object with start/end or a preformatted range.
$abhijitValue = choghadiyas_home_api_find($navamsha_abhijit, array('abhijit_muhurat', 'abhijit', 'muhurat', 'window', 'timing'));
if ($abhijitValue === null && !empty($navamsha_abhijit)) {
    $abhijitValue = $navamsha_abhijit;
}
$abhijitRange = choghadiyas_home_api_range($abhijitValue);
if ($abhijitRange !== '') {
    $today_panchang['abhijit_muhurat'] = $abhijitRange;
    $navamsha_api_connected = true;
    $navamsha_api_status['abhijit'] = true;
}
$abhijitStart = choghadiyas_home_api_find($navamsha_abhijit, array('start_time', 'startTime', 'start', 'from_time'));
$abhijitEnd = choghadiyas_home_api_find($navamsha_abhijit, array('end_time', 'endTime', 'end', 'to_time'));
if ($abhijitStart !== null && $abhijitEnd !== null) {
    $today_panchang['abhijit_muhurat_start'] = choghadiyas_home_time(choghadiyas_home_api_scalar($abhijitStart));
    $today_panchang['abhijit_muhurat_end'] = choghadiyas_home_time(choghadiyas_home_api_scalar($abhijitEnd));
}

// Rebuild the day/night arrays from API data or the existing database fallback.
$home_day_periods = array();
$home_night_periods = array();
if (is_array($today_choghadiya_periods)) {
    foreach ($today_choghadiya_periods as $home_period_row) {
        if (choghadiyas_home_period_is_day($home_period_row)) {
            $home_day_periods[] = $home_period_row;
        } else {
            $home_night_periods[] = $home_period_row;
        }
    }
}

// Get first author for expert section
$expert_author = db_fetch_one("
    SELECT * FROM users WHERE status = 'active' AND role IN ('admin', 'author') 
    ORDER BY created_at ASC LIMIT 1
");

$total_posts = db_fetch_one("SELECT COUNT(*) as count FROM posts WHERE status = 'published'")['count'];
$total_categories = db_fetch_one("SELECT COUNT(*) as count FROM categories WHERE status = 'active'")['count'];
$total_festivals = db_fetch_one("SELECT COUNT(*) as count FROM festivals WHERE status = 'active'")['count'];

require_once __DIR__ . '/../includes/header_responsive.php';
?>

<!-- Critical CSS for Above-the-Fold Content -->
<style>
/* Critical CSS - Load immediately for better LCP */
.hero-content-premium {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    min-height: 600px;
}

.hero-text-premium {
    max-width: 600px;
}

.hero-badge {
    display: inline-block;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
}

.hero-text-premium h1 {
    font-size: 48px;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 20px;
    color: #2c3e50;
}

.hero-description {
    font-size: 18px;
    line-height: 1.6;
    color: #6c757d;
    margin-bottom: 30px;
}

.hero-buttons-premium {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
}

.btn-premium-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 15px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-premium-secondary {
    background: transparent;
    color: #667eea;
    border: 2px solid #667eea;
    padding: 13px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

/* Prevent layout shift */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section {
    padding: 80px 0;
}

/* Image optimization */
img {
    max-width: 100%;
    height: auto;
    object-fit: cover;
}

/* Font loading optimization */
@font-face {
    font-family: 'Inter';
    font-display: swap;
    src: url('/assets/fonts/inter-regular.woff2') format('woff2');
}
</style>

<!-- Premium Hero Section -->
<section class="hero-premium">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="container">

        <div class="hero-content-premium">

            <div class="hero-text-premium">

                <span class="hero-badge">आज का चौघड़िया, पंचांग और शुभ मुहूर्त</span>

                <h1>चौघड़िया, पंचांग और शुभ मुहूर्त की जानकारी</h1>

                <p class="hero-description">
                    आज का चौघड़िया, तिथि, नक्षत्र, राहु काल और शुभ मुहूर्त की जानकारी एक ही स्थान पर देखें।
                    साथ ही व्रत, त्योहार, पूजा विधि और महत्वपूर्ण हिंदू तिथियों से जुड़ी उपयोगी जानकारी सरल हिंदी में पढ़ें।
                </p>

                <div class="hero-buttons-premium">

                    <a href="#today-choghadiya" class="btn btn-premium-primary">
                        <i class="icon-clock"></i>
                        आज का चौघड़िया देखें
                    </a>

                    <a href="https://choghadiyas.in/abhijit-muhurat-ka-mahatva-aur-sahi-samay" class="btn btn-premium-secondary">
                        <i class="icon-calendar"></i>
                        शुभ मुहूर्त खोजें
                    </a>

                </div>

            </div>

            <div class="hero-visual">

                <div class="choghadiya-widget-preview">
                    <div class="widget-header">
                        <i class="icon-sun"></i>
                        <span>आज का चौघड़िया</span>
                    </div>
                    <div class="widget-date">
                        <?php echo htmlspecialchars(date('l, F j, Y'), ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <?php if (!empty($today_choghadiya_periods) && !empty($home_day_periods)): ?>
                        <?php foreach (array_slice($home_day_periods, 0, 3) as $home_period): ?>
                            <?php
                            $home_period_name = choghadiyas_home_period_name($home_period);
                            $home_period_class = choghadiyas_home_nature_class($home_period_name);
                            $home_period_time = choghadiyas_home_time_range($home_period);
                            ?>
                            <div class="widget-muhurat <?php echo htmlspecialchars($home_period_class, ENT_QUOTES, 'UTF-8'); ?>">
                                <span class="label"><?php echo htmlspecialchars($home_period_name !== '' ? $home_period_name : 'चौघड़िया अवधि', ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="time"><?php echo htmlspecialchars($home_period_time !== '' ? $home_period_time : 'समय उपलब्ध नहीं', ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="status"><?php echo htmlspecialchars(choghadiyas_home_nature_label($home_period_name), ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="widget-muhurat neutral">
                            <span class="label">आज की तालिका</span>
                            <span class="time">चौघड़िया का डेटा अभी उपलब्ध नहीं है</span>
                            <span class="status"><a href="#today-choghadiya">दैनिक जानकारी देखें</a></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Author identity is shown only when an active author exists. -->
                <?php if ($expert_author && !empty($expert_author['full_name'])): ?>
                <div class="premium-scholar-identity">
                    <div class="scholar-glassmorphism">
                        <div class="scholar-avatar-section">
                            <div class="scholar-avatar-container">
                                <?php if ($expert_author && $expert_author['profile_image']): ?>
                                <img src="<?php echo $expert_author['profile_image']; ?>" alt="Vedic Scholar" class="scholar-avatar">
                                <?php else: ?>
                                <div class="scholar-avatar-placeholder">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="scholar-info">
                                <h4 class="Co-Founder"><?php echo htmlspecialchars($expert_author['full_name'], ENT_QUOTES, 'UTF-8'); ?></h4>
                                <p class="scholar-verification">लेखक</p>
                                <nav class="scholar-profile-links" aria-label="लेखक और संपर्क जानकारी">
                                    <a href="<?php echo SITE_URL; ?>/about">हमारे बारे में</a>
                                    <a href="<?php echo SITE_URL; ?>/contact">संपर्क करें</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
<style>
/* Author Profile Card */
.premium-scholar-identity {
    position: relative;
    margin-top: 20px;
    animation: none;
}

.scholar-glassmorphism {
    background: rgba(102, 126, 234, 0.06);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(102, 126, 234, 0.12);
    border-radius: 16px;
    padding: 16px;
    transition: background-color 0.2s ease, border-color 0.2s ease;
}

.scholar-glassmorphism:hover {
    background: rgba(102, 126, 234, 0.08);
    border-color: rgba(102, 126, 234, 0.2);
}

.scholar-avatar-section {
    display: flex;
    align-items: center;
    gap: 14px;
}

.scholar-avatar-container {
    position: relative;
    flex-shrink: 0;
}

.scholar-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid rgba(102, 126, 234, 0.3);
    object-fit: cover;
}

.scholar-avatar-placeholder {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    border: 2px solid rgba(102, 126, 234, 0.3);
}

.scholar-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.scholar-name {
    color: #1a1a2e;
    font-size: 14px;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    line-height: 1.2;
}

.scholar-verification {
    color: #6c757d;
    font-size: 11px;
    font-weight: 500;
    margin: 0;
}

.scholar-profile-links {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px 14px;
    margin-top: 8px;
}

.scholar-profile-links a {
    display: inline-flex;
    align-items: center;
    min-height: 28px;
    color: #5145b5;
    font-size: 12px;
    font-weight: 600;
    line-height: 1.4;
    text-decoration: underline;
    text-decoration-thickness: 1px;
    text-underline-offset: 3px;
}

.scholar-profile-links a:hover,
.scholar-profile-links a:focus-visible {
    color: #372c8d;
}

.scholar-profile-links a:focus-visible {
    outline: 2px solid #667eea;
    outline-offset: 3px;
    border-radius: 3px;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .scholar-avatar-section {
        flex-direction: row;
        align-items: center;
        text-align: left;
        gap: 12px;
    }

    .scholar-info {
        min-width: 0;
    }

    .scholar-info .Co-Founder {
        overflow-wrap: anywhere;
    }

    .scholar-profile-links {
        gap: 8px 12px;
    }

}
</style>
            </div>
        </div>
    </div>
</section>

<style>
.home-city-selector { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 10px; margin: 14px auto 8px; }
.home-city-selector label { color: #344054; font-size: 14px; font-weight: 600; }
.home-city-selector select { min-width: 160px; max-width: 100%; border: 1px solid #d7dcef; background: #fff; color: #263445; border-radius: 8px; padding: 9px 12px; font: inherit; }
.home-city-selector button { border: 0; border-radius: 8px; padding: 10px 16px; background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; font: inherit; font-weight: 600; cursor: pointer; }
.home-period-subheading { margin: 16px 0 8px; color: #334155; font-size: 16px; font-weight: 700; }

/* Homepage hero Choghadiya preview: clear columns, wrapping and accessible spacing */
.hero-visual { min-width: 0; }
.hero-visual .choghadiya-widget-preview {
    width: 100% !important;
    max-width: 440px;
    min-width: 0;
    box-sizing: border-box;
    margin: 0 auto 18px;
    padding: 20px 22px;
    border-radius: 16px;
    background: #fff;
    border: 1px solid #e8eaf2;
    box-shadow: 0 12px 32px rgba(31, 41, 55, 0.12);
    overflow: hidden;
}
.hero-visual .choghadiya-widget-preview .widget-header {
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 0 0 12px;
    color: #20283a;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.4;
}
.hero-visual .choghadiya-widget-preview .widget-date {
    margin: 0 0 4px;
    padding: 0 0 12px;
    border-bottom: 1px solid #e5e7eb;
    color: #687386;
    text-align: center;
    font-size: 12px;
    line-height: 1.5;
}
.hero-visual .choghadiya-widget-preview .widget-muhurat {
    display: grid !important;
    grid-template-columns: minmax(56px, 0.62fr) minmax(105px, 1fr) minmax(118px, 1.15fr);
    align-items: center;
    gap: 8px 10px;
    width: 100%;
    min-width: 0;
    padding: 10px 0;
    border-bottom: 1px solid #edf0f5;
    box-sizing: border-box;
}
.hero-visual .choghadiya-widget-preview .widget-muhurat:last-child { border-bottom: 0; }
.hero-visual .choghadiya-widget-preview .widget-muhurat > span {
    display: block;
    min-width: 0;
    max-width: 100%;
    white-space: normal;
    overflow-wrap: anywhere;
    word-break: normal;
    line-height: 1.4;
}
.hero-visual .choghadiya-widget-preview .widget-muhurat .label {
    color: #252c3e;
    font-size: 12px;
    font-weight: 700;
}
.hero-visual .choghadiya-widget-preview .widget-muhurat .time {
    color: #5b6474;
    font-size: 11px;
    font-variant-numeric: tabular-nums;
}
.hero-visual .choghadiya-widget-preview .widget-muhurat .status {
    box-sizing: border-box;
    max-width: 100%;
    padding: 8px 10px;
    border-radius: 12px;
    background: #f3f4f6;
    color: #4b5563;
    font-size: 11px;
    line-height: 1.4;
}
.hero-visual .choghadiya-widget-preview .widget-muhurat.good .status { background: #d1fae5; color: #065f46; }
.hero-visual .choghadiya-widget-preview .widget-muhurat.bad .status { background: #fee2e2; color: #991b1b; }
.hero-visual .choghadiya-widget-preview .widget-muhurat.neutral .status { background: #f3f4f6; color: #4b5563; }
.hero-visual .choghadiya-widget-preview .widget-muhurat .status a { color: inherit; text-decoration: underline; text-underline-offset: 2px; }

@media (max-width: 768px) {
    .hero-visual .choghadiya-widget-preview {
        max-width: 100%;
        padding: 18px 16px;
        margin-bottom: 16px;
    }
    .hero-visual .choghadiya-widget-preview .widget-muhurat {
        grid-template-columns: 66px minmax(0, 1fr);
        gap: 5px 10px;
        padding: 12px 0;
    }
    .hero-visual .choghadiya-widget-preview .widget-muhurat .label { grid-column: 1; grid-row: 1; }
    .hero-visual .choghadiya-widget-preview .widget-muhurat .time { grid-column: 2; grid-row: 1; }
    .hero-visual .choghadiya-widget-preview .widget-muhurat .status {
        grid-column: 2;
        grid-row: 2;
        justify-self: start;
        width: fit-content;
        max-width: 100%;
        padding: 7px 10px;
    }
}
@media (max-width: 380px) {
    .hero-visual .choghadiya-widget-preview { padding: 16px 12px; }
    .hero-visual .choghadiya-widget-preview .widget-muhurat { grid-template-columns: 58px minmax(0, 1fr); gap: 5px 8px; }
    .hero-visual .choghadiya-widget-preview .widget-muhurat .label { font-size: 11px; }
    .hero-visual .choghadiya-widget-preview .widget-muhurat .time,
    .hero-visual .choghadiya-widget-preview .widget-muhurat .status { font-size: 10px; }
}

.home-inauspicious-extra { display: flex; flex-wrap: wrap; gap: 8px 18px; margin-top: 8px; font-size: 13px; }
.home-inauspicious-extra span { display: inline-block; }
@media (max-width: 560px) { .home-city-selector { align-items: stretch; } .home-city-selector label { width: 100%; text-align: center; } .home-city-selector select, .home-city-selector button { width: 100%; } }
</style>

<!-- Today's Choghadiya & Panchang Section -->
<section id="today-choghadiya" class="section section-gradient">
    <div class="container">
        <div class="section-header-center">
            <span class="section-badge">दैनिक जानकारी</span>
            <h2>आज का चौघड़िया और पंचांग</h2>
            <p><?php echo htmlspecialchars(date('d F Y (l)'), ENT_QUOTES, 'UTF-8'); ?> की उपलब्ध जानकारी · स्थान: <?php echo htmlspecialchars($navamsha_city_name, ENT_QUOTES, 'UTF-8'); ?></p>
            <form class="home-city-selector" method="get" action="/" aria-label="पंचांग के लिए शहर चुनें">
                <label for="home-panchang-city">शहर चुनें</label>
                <select id="home-panchang-city" name="city">
                    <?php foreach ($navamsha_cities as $cityId => $cityData): ?>
                        <option value="<?php echo htmlspecialchars($cityId, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $cityId === $navamsha_selected_city_id ? 'selected' : ''; ?>><?php echo htmlspecialchars($cityData['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">समय देखें</button>
            </form>
</div>

        <div class="today-grid">
            <div class="today-card choghadiya-card-large">
                <div class="today-card-header">
                    <div class="header-icon"><i class="icon-clock"></i></div>
                    <div class="header-text">
                        <h3>दिन का चौघड़िया</h3>
                        <span><?php echo htmlspecialchars(date('l, d F Y'), ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                </div>
                <div class="choghadiya-table">
                    <?php if (!empty($home_day_periods)): ?>
                        <div class="choghadiya-row header-row">
                            <span>अवधि</span>
                            <span>समय</span>
                            <span>चौघड़िया</span>
                            <span>पारंपरिक श्रेणी</span>
                        </div>
                        <?php foreach ($home_day_periods as $home_index => $home_period): ?>
                            <?php
                            $home_period_name = choghadiyas_home_period_name($home_period);
                            $home_period_class = choghadiyas_home_nature_class($home_period_name);
                            $home_period_time = choghadiyas_home_time_range($home_period);
                            $home_period_number = choghadiyas_home_field($home_period, array('period_number', 'sequence', 'sort_order', 'number'));
                            ?>
                            <div class="choghadiya-row <?php echo htmlspecialchars($home_period_class, ENT_QUOTES, 'UTF-8'); ?>">
                                <span><?php echo htmlspecialchars($home_period_number !== '' ? 'अवधि ' . $home_period_number : 'अवधि ' . ($home_index + 1), ENT_QUOTES, 'UTF-8'); ?></span>
                                <span><?php echo htmlspecialchars($home_period_time !== '' ? $home_period_time : 'समय उपलब्ध नहीं', ENT_QUOTES, 'UTF-8'); ?></span>
                                <span><?php echo htmlspecialchars($home_period_name !== '' ? $home_period_name : 'उपलब्ध नहीं', ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="badge-<?php echo htmlspecialchars($home_period_class, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars(choghadiyas_home_nature_label($home_period_name), ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="choghadiya-row neutral">
                            <span style="grid-column: 1 / -1; display: block; padding: 22px 14px; text-align: center; line-height: 1.7;">
                                आज के चौघड़िया का डेटा अभी प्रकाशित नहीं है। गलत समय दिखाने के बजाय यहाँ सही डेटा उपलब्ध होने पर ही समय दिखाया जाएगा।
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($home_night_periods)): ?>
                    <h4 class="home-period-subheading">रात का चौघड़िया</h4>
                    <div class="choghadiya-table">
                        <div class="choghadiya-row header-row">
                            <span>अवधि</span><span>समय</span><span>चौघड़िया</span><span>पारंपरिक श्रेणी</span>
                        </div>
                        <?php foreach ($home_night_periods as $home_night_index => $home_night_period): ?>
                            <?php
                            $home_night_name = choghadiyas_home_period_name($home_night_period);
                            $home_night_class = choghadiyas_home_nature_class($home_night_name);
                            $home_night_time = choghadiyas_home_time_range($home_night_period);
                            $home_night_number = choghadiyas_home_field($home_night_period, array('period_number', 'sequence', 'sort_order', 'number'));
                            ?>
                            <div class="choghadiya-row <?php echo htmlspecialchars($home_night_class, ENT_QUOTES, 'UTF-8'); ?>">
                                <span><?php echo htmlspecialchars($home_night_number !== '' ? 'अवधि ' . $home_night_number : 'अवधि ' . ($home_night_index + 1), ENT_QUOTES, 'UTF-8'); ?></span>
                                <span><?php echo htmlspecialchars($home_night_time !== '' ? $home_night_time : 'समय उपलब्ध नहीं', ENT_QUOTES, 'UTF-8'); ?></span>
                                <span><?php echo htmlspecialchars($home_night_name !== '' ? $home_night_name : 'उपलब्ध नहीं', ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="badge-<?php echo htmlspecialchars($home_night_class, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars(choghadiyas_home_nature_label($home_night_name), ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="rahukaal-box">
                    <div class="rahukaal-icon" aria-hidden="true">ⓘ</div>
                    <div class="rahukaal-info">
                        <strong>आज का राहुकाल</strong>
                        <?php $home_rahukaal = choghadiyas_home_rahukaal($today_panchang); ?>
                        <span><?php echo htmlspecialchars($home_rahukaal !== '' ? $home_rahukaal : 'राहुकाल का समय अभी प्रकाशित नहीं है। स्थान और स्थानीय सूर्योदय-सूर्यास्त के अनुसार समय बदल सकता है।', ENT_QUOTES, 'UTF-8'); ?></span>
                        <?php
                        $home_gulika = choghadiyas_home_field($today_panchang, array('gulika_kaal', 'gulika', 'gulika_time'));
                        $home_yamaganda = choghadiyas_home_field($today_panchang, array('yamaganda', 'yamaganda_time', 'yama_ganda'));
                        ?>
                        <?php if ($home_gulika !== '' || $home_yamaganda !== ''): ?>
                            <div class="home-inauspicious-extra">
                                <?php if ($home_gulika !== ''): ?><span><strong>गुलिक काल:</strong> <?php echo htmlspecialchars($home_gulika, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?>
                                <?php if ($home_yamaganda !== ''): ?><span><strong>यमगण्ड:</strong> <?php echo htmlspecialchars($home_yamaganda, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="today-card panchang-card">
                <div class="today-card-header">
                    <div class="header-icon"><i class="icon-calendar"></i></div>
                    <div class="header-text"><h3>आज का पंचांग</h3></div>
                </div>
                <?php if (is_array($today_panchang) && !empty($today_panchang)): ?>
                    <div class="panchang-list">
                        <?php
                        $home_panchang_items = array(
                            array('label' => 'तिथि', 'keys' => array('tithi', 'tithi_name'), 'end_keys' => array('tithi_end_time', 'tithi_end', 'tithi_ends_at')),
                            array('label' => 'नक्षत्र', 'keys' => array('nakshatra', 'nakshatra_name'), 'end_keys' => array('nakshatra_end_time', 'nakshatra_end', 'nakshatra_ends_at')),
                            array('label' => 'योग', 'keys' => array('yoga', 'yoga_name'), 'end_keys' => array('yoga_end_time', 'yoga_end', 'yoga_ends_at')),
                            array('label' => 'करण', 'keys' => array('karana', 'karana_name', 'karan'), 'end_keys' => array('karana_end_time', 'karana_end', 'karana_ends_at'))
                        );
                        foreach ($home_panchang_items as $home_panchang_item):
                            $home_panchang_value = choghadiyas_home_field($today_panchang, $home_panchang_item['keys']);
                            $home_panchang_end = choghadiyas_home_field($today_panchang, $home_panchang_item['end_keys']);
                        ?>
                            <div class="panchang-item">
                                <span class="label"><?php echo htmlspecialchars($home_panchang_item['label'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="value"><?php echo htmlspecialchars($home_panchang_value !== '' ? $home_panchang_value : 'डेटा उपलब्ध नहीं', ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="time"><?php echo htmlspecialchars($home_panchang_end !== '' ? 'समाप्ति: ' . choghadiyas_home_time($home_panchang_end) : '', ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        <?php endforeach; ?>

                        <?php
                        $home_abhijit_start = choghadiyas_home_field($today_panchang, array('abhijit_muhurat_start', 'abhijit_start', 'abhijit_start_time'));
                        $home_abhijit_end = choghadiyas_home_field($today_panchang, array('abhijit_muhurat_end', 'abhijit_end', 'abhijit_end_time'));
                        $home_abhijit = choghadiyas_home_field($today_panchang, array('abhijit_muhurat', 'abhijit_time'));
                        if ($home_abhijit_start !== '' && $home_abhijit_end !== '') {
                            $home_abhijit = choghadiyas_home_time($home_abhijit_start) . ' – ' . choghadiyas_home_time($home_abhijit_end);
                        }
                        ?>
                        <div class="panchang-item highlight">
                            <span class="label">अभिजीत मुहूर्त</span>
                            <span class="value"><?php echo htmlspecialchars($home_abhijit !== '' ? $home_abhijit : 'डेटा उपलब्ध नहीं', ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="time"></span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="panchang-list">
                        <p style="padding: 18px; line-height: 1.7; margin: 0;">आज का पंचांग डेटा अभी प्रकाशित नहीं है। डेटा उपलब्ध होने पर तिथि, नक्षत्र, योग, करण और स्थानीय समय यहाँ दिखाई देंगे।</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Homepage Sacred Categories Section -->
<section class="homepage-sacred-categories" aria-labelledby="homepage-sacred-categories-title">
    <div class="container">
        <div class="homepage-sacred-categories__header">
            <span class="homepage-sacred-categories__eyebrow">विषय के अनुसार जानकारी</span>
            <h2 id="homepage-sacred-categories-title">धार्मिक जानकारी की प्रमुख श्रेणियाँ</h2>
            <p>व्रत-त्योहार, शुभ मुहूर्त, पूजा विधि और पंचांग से जुड़ी उपयोगी जानकारी अपनी जरूरत के अनुसार पढ़ें।</p>
        </div>

        <div class="homepage-sacred-categories__grid">
            <a class="homepage-sacred-category-card" href="<?php echo htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8'); ?>/category/vrat-tyohar" aria-label="व्रत और त्योहार की जानकारी पढ़ें">
                <span class="homepage-sacred-category-card__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3.5" y="5" width="17" height="16" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M7.5 3.5V7M16.5 3.5V7M3.5 9.5H20.5M8 13H10M13 13H15.5M8 16.5H10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="homepage-sacred-category-card__body">
                    <span class="homepage-sacred-category-card__title">व्रत और त्योहार</span>
                    <span class="homepage-sacred-category-card__description">व्रत, पर्व और त्योहारों की तारीखों, महत्व और परंपराओं से जुड़ी जानकारी।</span>
                    <span class="homepage-sacred-category-card__link">जानकारी पढ़ें <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M12.5 5.5L19 12L12.5 18.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </span>
            </a>

            <a class="homepage-sacred-category-card" href="<?php echo htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8'); ?>/category/shubh-muhurat-guide" aria-label="शुभ मुहूर्त गाइड पढ़ें">
                <span class="homepage-sacred-category-card__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M12 7V12L15.5 14" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 2.8H16" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="homepage-sacred-category-card__body">
                    <span class="homepage-sacred-category-card__title">शुभ मुहूर्त गाइड</span>
                    <span class="homepage-sacred-category-card__description">शुभ कार्यों के मुहूर्त, समय और उनसे जुड़ी पारंपरिक मान्यताओं की सरल जानकारी।</span>
                    <span class="homepage-sacred-category-card__link">जानकारी पढ़ें <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M12.5 5.5L19 12L12.5 18.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </span>
            </a>

            <a class="homepage-sacred-category-card" href="<?php echo htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8'); ?>/category/puja-vidhi-samagri" aria-label="पूजा विधि और सामग्री की जानकारी पढ़ें">
                <span class="homepage-sacred-category-card__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 10.5H18L16.8 15.5C16.5 16.8 15.4 17.7 14.1 17.7H9.9C8.6 17.7 7.5 16.8 7.2 15.5L6 10.5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                        <path d="M8.5 10.5C8.5 8.6 10 7 12 7C14 7 15.5 8.6 15.5 10.5M12 3.5V5M5 20.5H19" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="homepage-sacred-category-card__body">
                    <span class="homepage-sacred-category-card__title">पूजा विधि और सामग्री</span>
                    <span class="homepage-sacred-category-card__description">पूजा की विधि, आवश्यक सामग्री और अलग-अलग परंपराओं से जुड़ी उपयोगी जानकारी।</span>
                    <span class="homepage-sacred-category-card__link">जानकारी पढ़ें <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M12.5 5.5L19 12L12.5 18.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </span>
            </a>

            <a class="homepage-sacred-category-card" href="<?php echo htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8'); ?>/category/vedic-panchang" aria-label="वैदिक ज्योतिष और पंचांग की जानकारी पढ़ें">
                <span class="homepage-sacred-category-card__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="8.7" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M3.8 12H20.2M12 3.3C14.1 5.6 15.2 8.5 15.2 12C15.2 15.5 14.1 18.4 12 20.7C9.9 18.4 8.8 15.5 8.8 12C8.8 8.5 9.9 5.6 12 3.3Z" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </span>
                <span class="homepage-sacred-category-card__body">
                    <span class="homepage-sacred-category-card__title">वैदिक ज्योतिष और पंचांग</span>
                    <span class="homepage-sacred-category-card__description">पंचांग, तिथि, नक्षत्र, योग और पारंपरिक ज्योतिषीय विषयों की सरल व्याख्या।</span>
                    <span class="homepage-sacred-category-card__link">जानकारी पढ़ें <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M12.5 5.5L19 12L12.5 18.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </span>
            </a>
        </div>
    </div>
</section>

<style>
/* Helpful category navigation: responsive, light-weight and ad-slot-free. */
.homepage-sacred-categories {
    padding: clamp(42px, 6vw, 76px) 0;
    background: #ffffff;
    border-top: 1px solid #eef0f6;
    border-bottom: 1px solid #eef0f6;
}
.homepage-sacred-categories__header {
    max-width: 760px;
    margin: 0 auto 30px;
    text-align: center;
}
.homepage-sacred-categories__eyebrow {
    display: inline-block;
    margin-bottom: 10px;
    padding: 6px 12px;
    border-radius: 999px;
    background: #f0f2ff;
    color: #5759b8;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .02em;
}
.homepage-sacred-categories__header h2 {
    margin: 0 0 10px;
    color: #20293b;
    font-size: clamp(24px, 3vw, 34px);
    font-weight: 750;
    line-height: 1.35;
}
.homepage-sacred-categories__header p {
    margin: 0;
    color: #667085;
    font-size: 15px;
    line-height: 1.8;
}
.homepage-sacred-categories__grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
}
.homepage-sacred-category-card {
    display: flex;
    flex-direction: column;
    min-width: 0;
    min-height: 230px;
    padding: 24px 21px 20px;
    border: 1px solid #e5e8f5;
    border-radius: 18px;
    background: #fff;
    color: inherit;
    text-decoration: none;
    box-shadow: 0 5px 18px rgba(28, 39, 76, .045);
    transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
}
.homepage-sacred-category-card:hover {
    border-color: #c9cdfc;
    box-shadow: 0 10px 26px rgba(72, 83, 170, .10);
    transform: translateY(-2px);
}
.homepage-sacred-category-card:focus-visible {
    outline: 3px solid #7779e8;
    outline-offset: 3px;
}
.homepage-sacred-category-card__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    margin-bottom: 18px;
    border-radius: 14px;
    background: #f0f1ff;
    color: #5e63c8;
}
.homepage-sacred-category-card__icon svg {
    display: block;
    width: 24px;
    height: 24px;
}
.homepage-sacred-category-card__body {
    display: flex;
    flex: 1;
    flex-direction: column;
    align-items: flex-start;
}
.homepage-sacred-category-card__title {
    display: block;
    margin-bottom: 9px;
    color: #20293b;
    font-size: 17px;
    font-weight: 750;
    line-height: 1.45;
}
.homepage-sacred-category-card__description {
    display: block;
    margin-bottom: 18px;
    color: #667085;
    font-size: 14px;
    line-height: 1.75;
}
.homepage-sacred-category-card__link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: auto;
    color: #5759b8;
    font-size: 13px;
    font-weight: 700;
}
.homepage-sacred-category-card__link svg {
    width: 16px;
    height: 16px;
    transition: transform .18s ease;
}
.homepage-sacred-category-card:hover .homepage-sacred-category-card__link svg {
    transform: translateX(3px);
}
@media (max-width: 1024px) {
    .homepage-sacred-categories__grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }
    .homepage-sacred-category-card {
        min-height: 210px;
    }
}
@media (max-width: 560px) {
    .homepage-sacred-categories {
        padding: 42px 0;
    }
    .homepage-sacred-categories__header {
        margin-bottom: 22px;
        text-align: left;
    }
    .homepage-sacred-categories__header p {
        font-size: 14px;
    }
    .homepage-sacred-categories__grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    .homepage-sacred-category-card {
        min-height: 0;
        flex-direction: row;
        align-items: flex-start;
        gap: 14px;
        padding: 18px;
        border-radius: 15px;
    }
    .homepage-sacred-category-card__icon {
        flex: 0 0 42px;
        width: 42px;
        height: 42px;
        margin: 1px 0 0;
        border-radius: 12px;
    }
    .homepage-sacred-category-card__icon svg {
        width: 21px;
        height: 21px;
    }
    .homepage-sacred-category-card__title {
        margin-bottom: 5px;
        font-size: 16px;
    }
    .homepage-sacred-category-card__description {
        margin-bottom: 10px;
        font-size: 13px;
        line-height: 1.65;
    }
}
@media (prefers-reduced-motion: reduce) {
    .homepage-sacred-category-card,
    .homepage-sacred-category-card__link svg {
        transition: none;
    }
    .homepage-sacred-category-card:hover,
    .homepage-sacred-category-card:hover .homepage-sacred-category-card__link svg {
        transform: none;
    }
}
</style>

<!-- Featured Articles Section -->
<section class="section section-editorial">
    <div class="container">
        <div class="editorial-header">
            <div class="editorial-badges">
                <span class="featured-badge">प्रमुख</span>
            </div>
            <div class="editorial-title-area">
                <h2>आवश्यक चौघड़िया और शुभ मुहूर्त गाइड</h2>
                <p>वैदिक समय-गणना और धार्मिक परंपराओं पर उपयोगी लेख</p>
            </div>
                    </div>
        
        <div class="editorial-content">
            <div class="editorial-main-grid">
                <?php if ($featured_articles): ?>
                <?php foreach (array_slice($featured_articles, 0, 6) as $article): ?>
                <article class="editorial-article">
                    <div class="editorial-media">
                        <div class="editorial-image-wrapper">
                            <?php if ($article['featured_image']): ?>
                            <img src="<?php echo $article['featured_image']; ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" loading="lazy" decoding="async" class="editorial-image">
                            <div class="editorial-image-overlay">
                                <div class="editorial-category-icon">
                                    <?php 
                                    $category_icon = 'fa-star';
                                    if (strpos(strtolower($article['category_name'] ?? ''), 'choghadiya') !== false) $category_icon = 'fa-clock';
                                    if (strpos(strtolower($article['category_name'] ?? ''), 'muhurat') !== false) $category_icon = 'fa-calendar-alt';
                                    if (strpos(strtolower($article['category_name'] ?? ''), 'panchang') !== false) $category_icon = 'fa-calendar';
                                    if (strpos(strtolower($article['category_name'] ?? ''), 'festival') !== false) $category_icon = 'fa-fire';
                                    if (strpos(strtolower($article['category_name'] ?? ''), 'vastu') !== false) $category_icon = 'fa-home';
                                    if (strpos(strtolower($article['category_name'] ?? ''), 'blog') !== false) $category_icon = 'fa-blog';
                                    ?>
                                    <i class="fas <?php echo $category_icon; ?>"></i>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="editorial-placeholder-image">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($article['category_name']): ?>
                        <span class="editorial-category-badge"><?php echo htmlspecialchars($article['category_name']); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="editorial-content-wrapper">
                        <div class="editorial-content-header">
                            <h3><a href="<?php echo SITE_URL; ?>/<?php echo $article['slug']; ?>"><?php echo htmlspecialchars($article['title']); ?></a></h3>
                            <div class="editorial-meta">
                                <span class="editorial-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo format_date($article['publish_date'], 'M j, Y'); ?>
                                </span>
                            </div>
                        </div>
                        
                        <p class="editorial-excerpt"><?php echo htmlspecialchars(truncate_text($article['excerpt'] ?? $article['content'], 120)); ?></p>
                        
                        <div class="editorial-footer">
                            <a href="<?php echo SITE_URL; ?>/<?php echo $article['slug']; ?>" class="editorial-read-more">
                                <span>Read Full Article</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                
                <?php else: ?>
                <div class="editorial-empty-state" style="grid-column: 1 / -1; padding: 24px 16px; text-align: center; color: #5b6472;">
                    <p>अभी कोई प्रकाशित लेख उपलब्ध नहीं है। नए लेख प्रकाशित होने पर वे यहाँ दिखाई देंगे।</p>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="editorial-newsletter-widget">
                <div class="newsletter-header">
                    <i class="fas fa-book-open" aria-hidden="true"></i>
                    <h4>और जानकारी पढ़ें</h4>
                </div>
                <p class="newsletter-description">चौघड़िया, पंचांग, व्रत-त्योहार और पूजा विधि से जुड़े प्रकाशित लेख देखें।</p>
                <a href="<?php echo htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8'); ?>/category/vedic-panchang" class="newsletter-btn" style="display: inline-flex; text-decoration: none; align-items: center; justify-content: center; gap: 8px;">
                    पंचांग लेख देखें <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Premium Editorial Styles */
.section-editorial {
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.section-editorial::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(74, 85, 162, 0.1), transparent);
}

.editorial-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 50px;
    gap: 30px;
}

.editorial-badges {
    display: flex;
    gap: 12px;
    align-items: center;
}

.featured-badge {
    background: linear-gradient(135deg, #4a5568, #6366f1);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.trending-badge {
    background: rgba(255, 200, 0, 0.1);
    border: 1px solid rgba(255, 200, 0, 0.3);
    color: #FFC800;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.editorial-title-area {
    flex: 1;
}

.editorial-title-area h2 {
    font-size: 32px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
    font-family: 'Montserrat', sans-serif;
    line-height: 1.2;
}

.editorial-title-area p {
    font-size: 16px;
    color: #6c757d;
    margin: 10px 0 0 0;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
}

.editorial-view-all {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: rgba(74, 85, 162, 0.05);
    border: 1px solid rgba(74, 85, 162, 0.1);
    border-radius: 25px;
    text-decoration: none;
    color: #4a5568;
    font-weight: 500;
    font-size: 14px;
    font-family: 'Poppins', sans-serif;
    transition: all 0.3s ease;
}

.editorial-view-all:hover {
    background: rgba(74, 85, 162, 0.1);
    border-color: rgba(74, 85, 162, 0.2);
    transform: translateY(-2px);
}

.editorial-view-all i {
    font-size: 12px;
    transition: transform 0.3s ease;
}

.editorial-view-all:hover i {
    transform: translateX(3px);
}

/* Main Content Grid */
.editorial-content {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 60px;
    align-items: start;
}

.editorial-main-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 40px;
}

/* Article Cards */
.editorial-article {
    background: white;
    border: 1px solid rgba(74, 85, 162, 0.08);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.editorial-article:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(74, 85, 162, 0.12);
    border-color: rgba(74, 85, 162, 0.15);
}

.editorial-media {
    position: relative;
    margin-bottom: 20px;
}

.editorial-image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    aspect-ratio: 16/10;
    background: #f8f9fa;
}

.editorial-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.editorial-article:hover .editorial-image {
    transform: scale(1.05);
}

.editorial-image-overlay {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 36px;
    height: 36px;
    background: rgba(74, 85, 162, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.editorial-category-icon {
    color: #FFC800;
    font-size: 16px;
}

.editorial-placeholder-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(74, 85, 162, 0.05), rgba(74, 85, 162, 0.1));
    color: #4a5568;
    font-size: 24px;
}

.editorial-category-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255, 200, 0, 0.9);
    color: white;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

/* Content */
.editorial-content-wrapper {
    padding: 0 20px 20px 0;
}

.editorial-content-header {
    margin-bottom: 16px;
}

.editorial-content-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    line-height: 1.3;
}

.editorial-content-header h3 a {
    color: #1a1a2e;
    text-decoration: none;
    transition: color 0.3s ease;
    font-family: 'Montserrat', sans-serif;
}

.editorial-content-header h3 a:hover {
    color: #4a5568;
}

.editorial-meta {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 16px;
}

.editorial-date,
.editorial-reading-time {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #6c757d;
    font-family: 'Poppins', sans-serif;
}

.editorial-date i,
.editorial-reading-time i {
    color: #FFC800;
    font-size: 11px;
}

.editorial-excerpt {
    font-size: 15px;
    line-height: 1.6;
    color: #495057;
    margin-bottom: 20px;
    font-family: 'Poppins', sans-serif;
}

.editorial-footer {
    text-align: right;
}

.editorial-read-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: linear-gradient(135deg, #4a5568, #6366f1);
    color: white;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 500;
    font-size: 13px;
    font-family: 'Montserrat', sans-serif;
    transition: all 0.3s ease;
}

.editorial-read-more:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(74, 85, 162, 0.3);
}

.editorial-read-more i {
    font-size: 11px;
    transition: transform 0.3s ease;
}

.editorial-read-more:hover i {
    transform: translateX(3px);
}

/* Sidebar */
.editorial-sidebar {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.editorial-sidebar-premium {
    margin-bottom: auto;
}

.editorial-premium-placeholder-vertical {
    background: rgba(74, 85, 162, 0.03);
    border: 1px solid rgba(74, 85, 162, 0.08);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
}

.editorial-premium-placeholder-vertical span {
    display: block;
    font-size: 11px;
    color: #6c757d;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-family: 'Montserrat', sans-serif;
}

.editorial-placeholder-box-vertical {
    background: rgba(74, 85, 162, 0.06);
    border-radius: 8px;
    height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4a5568;
    font-size: 13px;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
}

/* Newsletter Widget */
.editorial-newsletter-widget {
    background: white;
    border: 1px solid rgba(74, 85, 162, 0.08);
    border-radius: 16px;
    padding: 25px;
    text-align: center;
}

.newsletter-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    justify-content: center;
}

.newsletter-header i {
    color: #FFC800;
    font-size: 18px;
}

.newsletter-header h4 {
    margin: 0;
    color: #1a1a2e;
    font-size: 16px;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
}

.newsletter-description {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 20px;
    line-height: 1.5;
    font-family: 'Poppins', sans-serif;
}

.newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.newsletter-input {
    padding: 12px 16px;
    border: 1px solid rgba(74, 85, 162, 0.15);
    border-radius: 10px;
    font-size: 14px;
    font-family: 'Poppins', sans-serif;
    color: #1a1a2e;
    background: white;
    transition: all 0.3s ease;
}

.newsletter-input:focus {
    outline: none;
    border-color: #4a5568;
    box-shadow: 0 0 0 3px rgba(74, 85, 162, 0.1);
}

.newsletter-input::placeholder {
    color: #9ca3af;
}

.newsletter-btn {
    background: linear-gradient(135deg, #4a5568, #6366f1);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 12px 20px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Montserrat', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.newsletter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(74, 85, 162, 0.3);
}

.newsletter-btn i {
    font-size: 12px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .editorial-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .editorial-sidebar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .section-editorial {
        padding: 60px 0;
    }
    
    .editorial-header {
        flex-direction: column;
        gap: 20px;
        margin-bottom: 40px;
    }
    
    .editorial-title-area h2 {
        font-size: 26px;
    }
    
    .editorial-main-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .editorial-sidebar {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .editorial-content-header h3 {
        font-size: 18px;
    }
    
    .editorial-meta {
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
    }
    
    .editorial-excerpt {
        font-size: 14px;
    }
    
    .editorial-footer {
        text-align: left;
        margin-top: 15px;
    }
    
    .editorial-read-more {
        width: 100%;
        justify-content: center;
    }
}

/* premium Section Styles */
.premium-section-horizontal {
    padding: 40px 0;
    background: #f8f9fa;
}

.premium-wrapper {
    text-align: center;
}

.premium-placeholder {
    background: white;
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 30px;
    display: inline-block;
}

.premium-placeholder span {
    display: block;
    font-size: 12px;
    color: #6c757d;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.placeholder-box {
    background: #e9ecef;
    border-radius: 8px;
    width: 728px;
    height: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 14px;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .articles-enhanced-layout {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .articles-sidebar {
        position: static;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .sidebar-widget {
        margin-bottom: 0;
    }
}

@media (max-width: 768px) {
    .placeholder-box {
        width: 100%;
        max-width: 336px;
        height: 280px;
    }
    
    .articles-sidebar {
        grid-template-columns: 1fr;
    }
    
    .premium-section-horizontal {
        padding: 30px 0;
    }
}
</style>

<!-- Information Section -->
<section class="section section-trust">
    <div class="container">

        <div class="section-header-center">
            <span class="section-badge">जानकारी के बारे में</span>

            <h2>चौघड़िया, पंचांग और शुभ मुहूर्त की जानकारी</h2>

            <p>
                चौघड़िया, पंचांग और शुभ मुहूर्त से जुड़ी जानकारी सरल भाषा में समझें।
            </p>
        </div>

        <div class="trust-features-grid">

            <!-- Feature 1 -->
            <div class="trust-feature">
                <div class="trust-icon-circle" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="icon-graduation-cap"></i>
                </div>

                <h3>संदर्भ आधारित जानकारी</h3>

                <p>
                    चौघड़िया, तिथि, नक्षत्र और अन्य विषयों से जुड़ी जानकारी पारंपरिक गणना पद्धतियों और उपलब्ध संदर्भों के आधार पर प्रस्तुत की जाती है।
                </p>
            </div>


            <!-- Feature 2 -->
            <div class="trust-feature">
                <div class="trust-icon-circle" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="icon-sync-alt"></i>
                </div>

                <h3>दैनिक अपडेट</h3>

                <p>
                    समय और तिथि से जुड़ी जानकारी संबंधित दिन के अनुसार अपडेट की जाती है।
                </p>
            </div>


            <!-- Feature 3 -->
            <div class="trust-feature">
                <div class="trust-icon-circle" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="icon-lightbulb"></i>
                </div>

                <h3>सरल भाषा में जानकारी</h3>

                <p>
                    जटिल विषयों को आसान भाषा में समझाया जाता है, ताकि पाठक जानकारी को आसानी से समझ सकें।
                </p>
            </div>


            <!-- Feature 4 -->
            <div class="trust-feature">
                <div class="trust-icon-circle" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="icon-shield-alt"></i>
                </div>

                <h3>पारंपरिक संदर्भ</h3>

                <p>
                    चौघड़िया, पंचांग और धार्मिक विषयों को संबंधित पारंपरिक संदर्भ के साथ सरल रूप में प्रस्तुत किया जाता है।
                </p>
            </div>


            <!-- Feature 5 -->
            <div class="trust-feature">
                <div class="trust-icon-circle" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="icon-smile"></i>
                </div>

                <h3>पाठक के लिए आसान</h3>

                <p>
                    साफ लेआउट और आसान नेविगेशन के साथ जानकारी को मोबाइल और डेस्कटॉप दोनों पर पढ़ना आसान बनाया गया है।
                </p>
            </div>

        </div>
    </div>
</section>
<!-- Trending Muhurat - premium Friendly Unique Design -->
<section class="muhurat-trending-premium">
    <div class="container">
        <div class="muhurat-header-premium">
            <div class="muhurat-header-content">
                <span class="trending-badge">
                    <i class="fas fa-fire"></i> अभी लोकप्रिय
                </span>
                <h2 class="muhurat-title-premium">लोकप्रिय शुभ मुहूर्त खोजें</h2>
                <p class="muhurat-subtitle-premium">शादी, गृह प्रवेश, नया व्यवसाय शुरू करने और अन्य महत्वपूर्ण कार्यों के लिए शुभ मुहूर्त की जानकारी देखें। शुभ समय</p>
            </div>
        </div>

        <div class="muhurat-premium-grid">
            <!-- Featured Large Card - Marriage -->
            <div class="muhurat-featured-large">
                <a href="https://choghadiyas.in/shubh-muhurat-for-marriage" class="muhurat-featured-card marriage-featured">
                    <div class="featured-bg-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="featured-content">
                        <h3>विवाह मुहूर्त</h3>
                        <p>विवाह के लिए शुभ तिथियों और मुहूर्त से जुड़ी जानकारी देखें। तिथि, नक्षत्र और अन्य पारंपरिक पंचांग विवरण के आधार पर विवाह मुहूर्त की जानकारी सरल हिंदी में पढ़ें।</p>
                        <div class="muhurat-timing-bar">
                            <span class="timing-label">विवाह मुहूर्त की जानकारी:</span>
                        
                            
                        
                        </div>
                        <span class="featured-action">
                            विवाह मुहूर्त देखें <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>

            <!-- Side Cards Grid -->
<div class="muhurat-side-grid">

    <a href="https://choghadiyas.in/vehicle-purchase-muhurat-nayi-gadi-kharidne-ka-shubh-samay"
       class="btn btn-premium-secondary">

        <div class="side-icon-wrapper">
            <i class="fas fa-car"></i>
        </div>

        <div class="side-content">
            <h4>वाहन खरीद मुहूर्त</h4>
            <p>नई कार या बाइक खरीदने का शुभ समय</p>
            <span class="side-timing">शुभ मुहूर्त देखें →</span>
        </div>

    </a>

    <a href="https://choghadiyas.in/griha-pravesh-muhurat-naye-ghar-mein"
       class="btn btn-premium-secondary">

        <div class="side-icon-wrapper">
            <i class="fas fa-home"></i>
        </div>

        <div class="side-content">
            <h4>गृह प्रवेश मुहूर्त</h4>
            <p>नए घर में प्रवेश का शुभ समय</p>
            <span class="side-timing">गृह प्रवेश मुहूर्त देखें →</span>
        </div>

    </a>

    <a href="https://choghadiyas.in/business-muhurat-naya-vyapar-shuru-karne-ka"
       class="btn btn-premium-secondary">

        <div class="side-icon-wrapper">
            <i class="fas fa-briefcase"></i>
        </div>

        <div class="side-content">
            <h4>व्यवसाय शुरू करने का मुहूर्त</h4>
            <p>नया व्यवसाय शुरू करने का शुभ समय</p>
            <span class="side-timing">व्यवसाय मुहूर्त देखें →</span>
        </div>

    </a>

</div>
</section>


<style>
/* Popular Vedic Tools Section - Premium Minimal Design */
.popular-tools-section {
    padding: 80px 0;
    background: #ffffff;
}

.popular-tools-section .section-header-center {
    text-align: center;
    margin-bottom: 50px;
}

.popular-tools-section .section-badge {
    display: inline-block;
    background: linear-gradient(135deg, #FFC800, #FFA500);
    color: #1a1a2e;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
}

.popular-tools-section .section-title {
    font-size: 36px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 16px 0;
    font-family: 'Montserrat', sans-serif;
    line-height: 1.3;
}

.popular-tools-section .section-subtitle {
    font-size: 18px;
    color: #6c757d;
    margin: 0;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
}

.tools-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

.tool-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 32px 24px;
    background: #ffffff;
    border: 2px solid #e9ecef;
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.tool-card:hover {
    border-color: #FFC800;
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(255, 200, 0, 0.15);
}

.tool-icon-wrapper {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    font-size: 28px;
    transition: all 0.3s ease;
}

.tool-icon-gold {
    background: linear-gradient(135deg, #FFC800, #FFA500);
    color: #1a1a2e;
}

.tool-icon-blue {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.tool-icon-orange {
    background: linear-gradient(135deg, #fa709a, #fee140);
    color: #1a1a2e;
}

.tool-icon-purple {
    background: linear-gradient(135deg, #a855f7, #6366f1);
    color: white;
}

.tool-icon-teal {
    background: linear-gradient(135deg, #14b8a6, #0ea5e9);
    color: white;
}

.tool-icon-red {
    background: linear-gradient(135deg, #ef4444, #f97316);
    color: white;
}

.tool-card:hover .tool-icon-wrapper {
    transform: scale(1.1);
}

.tool-content h3 {
    font-size: 20px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 12px 0;
    font-family: 'Montserrat', sans-serif;
    line-height: 1.4;
}

.tool-content p {
    font-size: 15px;
    color: #6c757d;
    margin: 0;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
}

/* Benefits for Readers Section - Premium Minimal Design */
.benefits-section {
    padding: 80px 0;
    background: #f8f9fa;
}

.benefits-section .section-header-center {
    text-align: center;
    margin-bottom: 50px;
}

.benefits-section .section-badge {
    display: inline-block;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
}

.benefits-section .section-title {
    font-size: 36px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 16px 0;
    font-family: 'Montserrat', sans-serif;
    line-height: 1.3;
}

.benefits-section .section-subtitle {
    font-size: 18px;
    color: #6c757d;
    margin: 0;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

.benefit-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 32px 24px;
    background: #ffffff;
    border: 2px solid #e9ecef;
    border-radius: 16px;
    transition: all 0.3s ease;
}

.benefit-card:hover {
    border-color: #667eea;
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(102, 126, 234, 0.15);
}

.benefit-icon-wrapper {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    font-size: 24px;
    transition: all 0.3s ease;
}

.benefit-icon-gold {
    background: linear-gradient(135deg, #FFC800, #FFA500);
    color: #1a1a2e;
}

.benefit-icon-purple {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.benefit-icon-blue {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.benefit-icon-orange {
    background: linear-gradient(135deg, #fa709a, #fee140);
    color: #1a1a2e;
}

.benefit-icon-teal {
    background: linear-gradient(135deg, #14b8a6, #0ea5e9);
    color: white;
}

.benefit-icon-red {
    background: linear-gradient(135deg, #ef4444, #f97316);
    color: white;
}

.benefit-card:hover .benefit-icon-wrapper {
    transform: scale(1.1);
}

.benefit-content h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 10px 0;
    font-family: 'Montserrat', sans-serif;
    line-height: 1.4;
}

.benefit-content p {
    font-size: 14px;
    color: #6c757d;
    margin: 0;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .tools-grid,
    .benefits-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    
    .popular-tools-section .section-title,
    .benefits-section .section-title {
        font-size: 32px;
    }
}

@media (max-width: 768px) {
    .popular-tools-section,
    .benefits-section {
        padding: 60px 0;
    }
    
    .tools-grid,
    .benefits-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .popular-tools-section .section-title,
    .benefits-section .section-title {
        font-size: 28px;
    }
    
    .popular-tools-section .section-subtitle,
    .benefits-section .section-subtitle {
        font-size: 16px;
    }
    
    .tool-card,
    .benefit-card {
        padding: 28px 20px;
    }
    
    .tool-icon-wrapper {
        width: 56px;
        height: 56px;
        font-size: 24px;
    }
    
    .benefit-icon-wrapper {
        width: 48px;
        height: 48px;
        font-size: 20px;
    }
    
    .tool-content h3 {
        font-size: 18px;
    }
    
    .benefit-content h3 {
        font-size: 16px;
    }
    
    .tool-content p,
    .benefit-content p {
        font-size: 14px;
    }
}
</style>

<!-- Benefits for Readers Section - Premium Minimal Design -->
<section class="benefits-section">
    <div class="container">
        <div class="section-header-center">
            <span class="section-badge">हमें क्यों चुनें</span>
            <h2 class="section-title">पाठकों के लिए ख़ास लाभ</h2>
            <p class="section-subtitle">चौघड़िया, पंचांग, मुहूर्त और धार्मिक विषयों से जुड़ी उपयोगी जानकारी</p>
        </div>

        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon-wrapper benefit-icon-gold">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="benefit-content">
                    <h3>स्थानीय समय की जानकारी</h3>
                    <p>स्थान के अनुसार चौघड़िया और मुहूर्त के समय में बदलाव हो सकता है</p>
                </div>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon-wrapper benefit-icon-purple">
                    <i class="fas fa-om"></i>
                </div>
                <div class="benefit-content">
                    <h3>आध्यात्मिक मार्गदर्शन</h3>
                    <p>धार्मिक परंपराओं और पंचांग से जुड़े विषयों की सरल जानकारी</p>
                </div>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon-wrapper benefit-icon-blue">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="benefit-content">
                    <h3>पारंपरिक स्रोत</h3>
                    <p>पंचांग, चौघड़िया और पारंपरिक समय-गणना से जुड़ी उपयोगी जानकारी</p>
                </div>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon-wrapper benefit-icon-orange">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="benefit-content">
                    <h3>सरल समझ</h3>
                    <p>जटिल वैदिक अवधारणाओं को आसान भाषा में समझाया गया</p>
                </div>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon-wrapper benefit-icon-teal">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="benefit-content">
                    <h3>मोबाइल फ्रेंडली</h3>
                    <p>मोबाइल, टैबलेट या डेस्कटॉप — हर जगह तेज़ और साफ अनुभव</p>
                </div>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon-wrapper benefit-icon-red">
                    <i class="fas fa-unlock"></i>
                </div>
                <div class="benefit-content">
                    <h3>मुफ्त पहुंच</h3>
                    <p>कोई छिपा हुआ शुल्क नहीं — उपलब्ध जानकारी सभी पाठकों के लिए बिल्कुल मुफ्त</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section - Premium Purple Design -->
<section class="section-newsletter-v2">
    <div class="container">
        <div class="newsletter-v2-wrapper">
            <div class="newsletter-v2-header">
                <div class="newsletter-v2-badge">
                    <i class="fas fa-envelope"></i>
                    NEWSLETTER
                </div>
                <h2 class="newsletter-v2-title">दैनिक चौघड़िया और त्योहारों की जानकारी पाएँ</h2>
                <p class="newsletter-v2-subtitle">
    चौघड़िया समय, व्रत-त्योहार की तिथियों और शुभ मुहूर्त से जुड़ी उपयोगी जानकारी अपने इनबॉक्स में प्राप्त करें।
</p>
            </div>
            
            <div class="newsletter-v2-card">
                <div class="newsletter-v2-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <form class="newsletter-v2-form" action="<?php echo SITE_URL; ?>/includes/newsletter.php" method="POST">
                    <div class="newsletter-v2-inputs">
                        <div class="input-group-v2">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="input-group-v2">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="Your Email" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-newsletter-v2">
                        <i class="fas fa-paper-plane"></i>
                        <span>मुफ्त सदस्यता लें</span>
                    </button>
                </form>
                <div class="newsletter-v2-trust">
                    <i class="fas fa-lock"></i>
                    <span>We respect your privacy. No spam ever.</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Community Section - Premium Green Design -->
<section class="section-community-v2">
    <div class="container">
        <div class="community-v2-wrapper">
            <div class="community-v2-header">
                <div class="community-v2-badge">
                    <i class="fas fa-users"></i>
                    CONNECT WITH US
                </div>
                <h2 class="community-v2-title">हमसे जुड़ें</h2>
                <p class="community-v2-subtitle">चौघड़िया, शुभ मुहूर्त और पंचांग से जुड़ी जानकारी के लिए हमारे सोशल चैनलों से जुड़ें।</p>
            </div>
            
            <div class="community-v2-grid">
                <a href="https://whatsapp.com/channel/0029Vb7TUHHEquiNzOin5P0r" target="_blank" rel="noopener noreferrer" class="community-v2-card whatsapp">
                    <div class="community-v2-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="community-v2-content">
                        <h3>WhatsApp Channel</h3>
                        <p>दैनिक चौघड़िया अपडेट और तत्काल त्योहार सूचनाएंप्राप्त करें</p>
                        <span class="community-v2-action">
                            चैनल से जुड़ेंरें
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <a href="https://www.instagram.com/shivkumarpandit8053/" target="_blank" rel="noopener noreferrer" class="community-v2-card instagram">
                    <div class="community-v2-icon">
                        <i class="fab fa-instagram"></i>
                    </div>
                    <div class="community-v2-content">
                        <h3>Instagram</h3>
                        <p>चौघड़िया, पंचांग, व्रत और त्योहारों से जुड़ी उपयोगी पोस्ट और जानकारी देखें।</p>
                        <span class="community-v2-action">
                            इंस्टाग्राम पर देखेंरें
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <a href="https://www.youtube.com/@SKPANDITJIOFFICIAL" target="_blank" rel="noopener noreferrer" class="community-v2-card youtube">
                    <div class="community-v2-icon">
                        <i class="fab fa-youtube"></i>
                    </div>
                    <div class="community-v2-content">
                        <h3>YouTube Channel</h3>
                        <p>चौघड़िया, पंचांग, शुभ मुहूर्त और धार्मिक विषयों से जुड़े वीडियो देखें।</p>
                        <span class="community-v2-action">
                            यूट्यूब चैनल देखेंें
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <a href="https://www.facebook.com/people/Shiv-Kumar-Pandit/61589328703704/" target="_blank" rel="noopener noreferrer" class="community-v2-card facebook">
                    <div class="community-v2-icon">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <div class="community-v2-content">
                        <h3>Facebook Page</h3>
                        <p>चौघड़िया, पंचांग, व्रत और त्योहारों से जुड़ी पोस्ट और अपडेट देखें।</p>
                        <span class="community-v2-action">
                            फेसबुक पेज देखेंं
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter & Community Section Styles -->
<style>
/* Newsletter Section V2 - Premium Purple Design */
.section-newsletter-v2 {
    padding: 80px 0;
    position: relative;
}

.section-newsletter-v2::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #8e44ad, #9b59b6, #8e44ad);
}

.newsletter-v2-wrapper {
    max-width: 800px;
    margin: 0 auto;
}

.newsletter-v2-header {
    text-align: center;
    margin-bottom: 40px;
}

.newsletter-v2-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #8e44ad;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

.newsletter-v2-title {
    font-size: 36px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 15px;
    line-height: 1.2;
}

.newsletter-v2-subtitle {
    font-size: 16px;
    color: #6c757d;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto;
}

.newsletter-v2-card {
    background: white;
    border-radius: 24px;
    padding: 50px;
    border: 2px solid #e9ecef;
    box-shadow: 0 10px 40px rgba(142, 68, 173, 0.1);
    text-align: center;
    transition: all 0.3s ease;
}

.newsletter-v2-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 50px rgba(142, 68, 173, 0.15);
}

.newsletter-v2-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #8e44ad, #9b59b6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    font-size: 32px;
    color: white;
    box-shadow: 0 10px 30px rgba(142, 68, 173, 0.3);
}

.newsletter-v2-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.newsletter-v2-inputs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.input-group-v2 {
    position: relative;
    display: flex;
    align-items: center;
}

.input-group-v2 i {
    position: absolute;
    left: 16px;
    color: #8e44ad;
    font-size: 16px;
}

.input-group-v2 input {
    width: 100%;
    padding: 16px 16px 16px 48px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 15px;
    transition: all 0.3s ease;
    background: white;
}

.input-group-v2 input:focus {
    outline: none;
    border-color: #8e44ad;
    box-shadow: 0 0 0 3px rgba(142, 68, 173, 0.1);
}

.btn-newsletter-v2 {
    background: linear-gradient(135deg, #8e44ad, #9b59b6);
    color: white;
    border: none;
    padding: 18px 40px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(142, 68, 173, 0.3);
}

.btn-newsletter-v2:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(142, 68, 173, 0.4);
}

.newsletter-v2-trust {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 20px;
    color: #6c757d;
    font-size: 14px;
}

.newsletter-v2-trust i {
    color: #27ae60;
}

/* Community Section V2 - Premium Green Design */
.section-community-v2 {
    padding: 80px 0;
    position: relative;
}

.section-community-v2::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #27ae60, #2ecc71, #27ae60);
}

.community-v2-wrapper {
    max-width: 1200px;
    margin: 0 auto;
}

.community-v2-header {
    text-align: center;
    margin-bottom: 50px;
}

.community-v2-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #27ae60;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

.community-v2-title {
    font-size: 36px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 15px;
    line-height: 1.2;
}

.community-v2-subtitle {
    font-size: 16px;
    color: #6c757d;
    line-height: 1.6;
}

.community-v2-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
}

.community-v2-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    border: 2px solid #e9ecef;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.community-v2-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    transition: all 0.3s ease;
}

.community-v2-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
}

.community-v2-card.whatsapp::before {
    background: linear-gradient(90deg, #25d366, #128c7e);
}

.community-v2-card.instagram::before {
    background: linear-gradient(90deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
}

.community-v2-card.youtube::before {
    background: linear-gradient(90deg, #ff0000, #cc0000);
}

.community-v2-card.facebook::before {
    background: linear-gradient(90deg, #1877f2, #0d5ab8);
}

.community-v2-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: white;
    margin-bottom: 20px;
}

.community-v2-card.whatsapp .community-v2-icon {
    background: linear-gradient(135deg, #25d366, #128c7e);
}

.community-v2-card.instagram .community-v2-icon {
    background: linear-gradient(135deg, #f09433, #e6683c, #dc2743);
}

.community-v2-card.youtube .community-v2-icon {
    background: linear-gradient(135deg, #ff0000, #cc0000);
}

.community-v2-card.facebook .community-v2-icon {
    background: linear-gradient(135deg, #1877f2, #0d5ab8);
}

.community-v2-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.community-v2-content h3 {
    font-size: 18px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
}

.community-v2-content p {
    font-size: 14px;
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 20px;
    flex: 1;
}

.community-v2-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
}

.community-v2-card.whatsapp .community-v2-action {
    color: #25d366;
}

.community-v2-card.instagram .community-v2-action {
    color: #e6683c;
}

.community-v2-card.youtube .community-v2-action {
    color: #ff0000;
}

.community-v2-card.facebook .community-v2-action {
    color: #1877f2;
}

.community-v2-card:hover .community-v2-action {
    gap: 12px;
}

/* premium Section */
.premium-section-horizontal {
    padding: 40px 0;
}

.premium-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}

.premium-placeholder {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 30px 60px;
    text-align: center;
    color: #6c757d;
}

.premium-placeholder span {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: block;
    margin-bottom: 8px;
}

.placeholder-box {
    font-size: 24px;
    font-weight: 700;
    color: #adb5bd;
}

/* Responsive Design */
@media (max-width: 768px) {
    .newsletter-v2-title,
    .community-v2-title {
        font-size: 28px;
    }
    
    .newsletter-v2-card {
        padding: 30px 20px;
    }
    
    .newsletter-v2-inputs {
        grid-template-columns: 1fr;
    }
    
    .newsletter-v2-icon {
        width: 60px;
        height: 60px;
        font-size: 24px;
    }
    
    .community-v2-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .community-v2-card {
        padding: 24px;
    }
}

@media (max-width: 480px) {
    .section-newsletter-v2,
    .section-community-v2 {
        padding: 60px 0;
    }
    
    .newsletter-v2-title,
    .community-v2-title {
        font-size: 24px;
    }
    
    .newsletter-v2-card {
        padding: 25px 15px;
    }
    
    .btn-newsletter-v2 {
        padding: 16px 24px;
        font-size: 14px;
    }
}

/* ============================================================
   premium-FRIENDLY CATEGORIES SECTION - Premium Design
   ============================================================ */
.spiritual-categories-premium {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    position: relative;
}

.categories-header-premium {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 40px;
    align-items: center;
    margin-bottom: 50px;
}

.header-content {
    text-align: left;
}

.category-badge-premium {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 16px;
}

.category-title-premium {
    font-family: 'Montserrat', sans-serif;
    font-size: 42px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 12px;
    line-height: 1.2;
}

.category-subtitle-premium {
    font-size: 18px;
    color: #64748b;
    margin: 0;
}

.header-premium-slot {
    display: flex;
    justify-content: flex-end;
}

.premium-small-slot {
    width: 300px;
    height: 250px;
    background: #f8fafc;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.categories-premium-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 30px;
}

.categories-main-column {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.category-featured-card {
    display: grid;
    grid-template-columns: 1fr 200px;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.choghadiya-featured {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.choghadiya-featured:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.3);
}

.featured-content {
    padding: 35px;
    display: flex;
    flex-direction: column;
}

.featured-icon {
    width: 70px;
    height: 70px;
    background: rgba(255,255,255,0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.featured-icon i {
    font-size: 32px;
}

.featured-text h3 {
    font-family: 'Montserrat', sans-serif;
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 12px;
}

.featured-text p {
    font-size: 15px;
    opacity: 0.9;
    margin: 0 0 24px;
    line-height: 1.6;
}

.featured-cta {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: rgba(255,255,255,0.2);
    padding: 14px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    margin-top: auto;
    width: fit-content;
}

.featured-cta:hover {
    background: rgba(255,255,255,0.3);
}

.featured-visual {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.time-indicator {
    text-align: center;
    background: rgba(255,255,255,0.15);
    padding: 20px;
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.current-time {
    display: block;
    font-size: 36px;
    font-weight: 700;
    font-family: 'Poppins', monospace;
}

.time-label {
    font-size: 13px;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.categories-sub-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.category-sub-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    text-decoration: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.category-sub-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.muhurat-card:hover {
    border-color: #f093fb;
}

.panchang-card:hover {
    border-color: #4facfe;
}

.sub-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}

.muhurat-card .sub-icon {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.panchang-card .sub-icon {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.sub-icon i {
    font-size: 22px;
}

.category-sub-card h4 {
    font-family: 'Montserrat', sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 8px;
}

.category-sub-card p {
    font-size: 14px;
    color: #64748b;
    margin: 0 0 16px;
}

.sub-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #667eea;
}

.muhurat-card .sub-cta {
    color: #f5576c;
}

.panchang-card .sub-cta {
    color: #4facfe;
}

/* Side Column */
.categories-side-column {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.category-side-card {
    display: flex;
    align-items: center;
    gap: 16px;
    background: white;
    padding: 20px;
    border-radius: 14px;
    text-decoration: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.category-side-card:hover {
    transform: translateX(5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.festivals-side:hover {
    border-color: #fa709a;
}

.vastu-side:hover {
    border-color: #43e97b;
}

.astrology-side:hover {
    border-color: #30cfd0;
}

.calendar-side:hover {
    border-color: #ff9a9e;
}

.side-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.festivals-side .side-icon {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: white;
}

.vastu-side .side-icon {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.astrology-side .side-icon {
    background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
    color: white;
}

.calendar-side .side-icon {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    color: #1e293b;
}

.side-icon i {
    font-size: 20px;
}

.side-content h4 {
    font-family: 'Montserrat', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 4px;
}

.side-content p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

/* Ad Slots */
.premium-mid-slot {
    background: #f8fafc;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    min-height: 250px;
}

.categories-bottom-ad {
    margin-top: 40px;
    background: #f8fafc;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
}

/* ============================================================
   premium-FRIENDLY MUHURAT TRENDING SECTION
   ============================================================ */
.muhurat-trending-premium {
    padding: 80px 0;
    background: linear-gradient(135deg, #fef9f3 0%, #fff5eb 100%);
    position: relative;
}

.muhurat-header-premium {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 40px;
    align-items: center;
    margin-bottom: 50px;
}

.muhurat-header-content {
    text-align: left;
}

.trending-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 16px;
}

.muhurat-title-premium {
    font-family: 'Montserrat', sans-serif;
    font-size: 42px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 12px;
    line-height: 1.2;
}

.muhurat-subtitle-premium {
    font-size: 18px;
    color: #64748b;
    margin: 0;
}

.muhurat-header-ad {
    display: flex;
    justify-content: flex-end;
}

.premium-square-slot {
    width: 300px;
    height: 250px;
    background: #fff;
    border: 2px dashed #fed7aa;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.muhurat-premium-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 30px;
}

.muhurat-featured-large {
    display: flex;
}

.muhurat-featured-card {
    display: flex;
    flex-direction: column;
    background: white;
    border-radius: 24px;
    padding: 40px;
    text-decoration: none;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
    width: 100%;
}

.marriage-featured {
    background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
    border-color: #f9a8d4;
}

.marriage-featured:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(249, 168, 212, 0.3);
}

.featured-bg-icon {
    position: absolute;
    top: -20px;
    right: -20px;
    width: 200px;
    height: 200px;
    background: rgba(249, 168, 212, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.featured-bg-icon i {
    font-size: 80px;
    color: rgba(219, 39, 119, 0.15);
}

.featured-content {
    position: relative;
    z-index: 1;
}

.trending-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #db2777 0%, #be185d 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 20px;
}

.muhurat-featured-card h3 {
    font-family: 'Montserrat', sans-serif;
    font-size: 32px;
    font-weight: 700;
    color: #9d174d;
    margin: 0 0 16px;
}

.muhurat-featured-card p {
    font-size: 16px;
    color: #831843;
    line-height: 1.7;
    margin: 0 0 24px;
}

.muhurat-timing-bar {
    background: white;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.timing-label {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

.timing-value {
    font-size: 18px;
    font-weight: 700;
    color: #be185d;
}

.timing-value i {
    margin-right: 6px;
}

.featured-action {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #db2777 0%, #be185d 100%);
    color: white;
    padding: 16px 28px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    width: fit-content;
}

.featured-action:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(219, 39, 119, 0.3);
}

/* Side Grid */
.muhurat-side-grid {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.muhurat-side-card {
    display: flex;
    align-items: center;
    gap: 18px;
    background: white;
    padding: 20px;
    border-radius: 16px;
    text-decoration: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.muhurat-side-card:hover {
    transform: translateX(5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.vehicle-card:hover {
    border-color: #3b82f6;
}

.property-card:hover {
    border-color: #10b981;
}

.griha-card:hover {
    border-color: #f59e0b;
}

.business-card:hover {
    border-color: #8b5cf6;
}

.side-icon-wrapper {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.vehicle-card .side-icon-wrapper {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}

.property-card .side-icon-wrapper {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.griha-card .side-icon-wrapper {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.business-card .side-icon-wrapper {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
}

.side-icon-wrapper i {
    font-size: 24px;
}

.side-content h4 {
    font-family: 'Montserrat', sans-serif;
    font-size: 17px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 4px;
}

.side-content p {
    font-size: 13px;
    color: #64748b;
    margin: 0 0 8px;
}

.side-timing {
    font-size: 12px;
    font-weight: 600;
    color: #059669;
    background: #d1fae5;
    padding: 4px 10px;
    border-radius: 20px;
}

.muhurat-mid-ad {
    background: white;
    border: 2px dashed #fed7aa;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    min-height: 250px;
}

/* Footer Bar */
.muhurat-footer-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    border-radius: 16px;
    padding: 24px 30px;
    margin-top: 40px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.footer-bar-content {
    display: flex;
    gap: 40px;
}

.footer-stat {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 600;
    color: #475569;
}

.footer-stat i {
    color: #f97316;
    font-size: 18px;
}

.footer-bar-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    padding: 14px 28px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.footer-bar-cta:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
}

.muhurat-bottom-ad {
    margin-top: 40px;
    background: white;
    border: 2px dashed #fed7aa;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
}

/* Ads Label */
.ads-label {
    font-size: 12px;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 10px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .categories-header-premium,
    .muhurat-header-premium {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .header-premium-slot,
    .muhurat-header-ad {
        justify-content: center;
    }
    
    .categories-premium-grid,
    .muhurat-premium-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .spiritual-categories-premium,
    .muhurat-trending-premium {
        padding: 50px 0;
    }
    
    .category-title-premium,
    .muhurat-title-premium {
        font-size: 28px;
    }
    
    .category-featured-card {
        grid-template-columns: 1fr;
    }
    
    .featured-visual {
        display: none;
    }
    
    .categories-sub-grid {
        grid-template-columns: 1fr;
    }
    
    .muhurat-featured-card {
        padding: 25px;
    }
    
    .muhurat-featured-card h3 {
        font-size: 24px;
    }
    
    .muhurat-footer-bar {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    
    .footer-bar-content {
        flex-direction: column;
        gap: 15px;
    }
}

/* LIVE TODAY - Clean Premium Design */
.live-today-section {
    padding: 60px 0;
    background: #ffffff;
}

.section-header-clean {
    text-align: center;
    margin-bottom: 40px;
}

.live-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    border: 2px solid #ef4444;
    border-radius: 50px;
    color: #ef4444;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
}

.live-dot {
    font-size: 8px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.section-title-clean {
    font-size: 36px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 12px;
    font-family: 'Montserrat', sans-serif;
}

.section-subtitle-clean {
    font-size: 16px;
    color: #64748b;
    margin: 0;
    font-weight: 400;
}

.panchang-clean-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.panchang-clean-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 24px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.panchang-clean-item:hover {
    border-color: #3b82f6;
    transform: translateY(-5px);
    box-shadow: 0 10px 40px rgba(59, 130, 246, 0.15);
}

.panchang-icon-wrap {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin-bottom: 16px;
    font-size: 24px;
}

.icon-moon { color: #8b5cf6; background: #f5f3ff; }
.icon-star { color: #f59e0b; background: #fffbeb; }
.icon-yoga { color: #ec4899; background: #fdf2f8; }
.icon-sunrise { color: #f97316; background: #fff7ed; }
.icon-sunset { color: #6366f1; background: #eef2ff; }
.icon-muhurat { color: #10b981; background: #ecfdf5; }

.panchang-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.panchang-label {
    font-size: 13px;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

.panchang-value {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.panchang-time {
    font-size: 12px;
    color: #64748b;
    margin-top: 4px;
}

.panchang-clean-footer {
    text-align: center;
}

.btn-clean-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 32px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-clean-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
}

/* UPCOMING FESTIVALS - Clean Premium Design */
.festivals-clean-section {
    padding: 60px 0;
    background: #fafafa;
}

.festivals-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    border: 2px solid #10b981;
    border-radius: 50px;
    color: #10b981;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
}

.festivals-clean-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.festival-clean-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.festival-clean-card:hover {
    border-color: #10b981;
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(16, 185, 129, 0.15);
}

.festival-clean-header {
    display: flex;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #f1f5f9;
    gap: 16px;
}

.festival-clean-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border-radius: 12px;
    font-size: 22px;
}

.festival-clean-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 8px 16px;
    background: #f0fdf4;
    border-radius: 8px;
}

.date-day {
    font-size: 24px;
    font-weight: 700;
    color: #10b981;
    line-height: 1;
}

.date-month {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    font-weight: 600;
}

.festival-clean-body {
    padding: 20px;
}

.festival-clean-title {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 12px;
    font-family: 'Montserrat', sans-serif;
}

.festival-clean-meta {
    display: flex;
    gap: 16px;
    margin-bottom: 12px;
}

.festival-clean-day,
.festival-clean-type {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #64748b;
}

.festival-clean-day i,
.festival-clean-type i {
    color: #10b981;
}

.festival-clean-description {
    font-size: 14px;
    color: #64748b;
    line-height: 1.6;
    margin: 0;
}

.festivals-clean-footer {
    text-align: center;
}

.btn-clean-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 32px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-clean-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .section-title-clean {
        font-size: 28px;
    }
    
    .panchang-clean-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    
    .festivals-clean-grid {
        grid-template-columns: 1fr;
    }
    
    .live-today-section,
    .festivals-clean-section {
        padding: 40px 0;
    }
}

@media (max-width: 480px) {
    .panchang-clean-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Premium FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header-center">
            <span class="section-badge">सामान्य प्रश्न</span>
            <h2 class="section-title">अक्सर पूछे जाने वाले प्रश्न</h2>
            <p class="section-subtitle">चौघड़िया, मुहूर्त और वैदिक ज्ञान के बारे में सबसे सामान्य प्रश्न और उनके उत्तर</p>
        </div>

        <div class="faq-grid">
            <!-- FAQ Item 1 -->
            <div class="faq-item">
                <div class="faq-question">
                    <div class="faq-icon-wrapper faq-icon-gold">
                        <i class="fas fa-question"></i>
                    </div>
                    <h3>चौघड़िया क्या है और इसका महत्व क्या है?</h3>
                </div>
                <div class="faq-answer">
                    <p>चौघड़िया दिन और रात के समय को अलग-अलग अवधियों में समझने की एक पारंपरिक पद्धति है। कुछ हिंदू परंपराओं में इसका उपयोग कार्य शुरू करने के समय की जानकारी के लिए किया जाता है।</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item">
                <div class="faq-question">
                    <div class="faq-icon-wrapper faq-icon-blue">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>पंचांग क्या है और इसमें क्या जानकारी होती है?</h3>
                </div>
                <div class="faq-answer">
                    <p>पंचांग हिंदू कैलेंडर और समय-गणना से जुड़ी पारंपरिक जानकारी देता है। इसमें तिथि, वार, नक्षत्र, योग और करण जैसी जानकारी शामिल होती है।</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item">
                <div class="faq-question">
                    <div class="faq-icon-wrapper faq-icon-purple">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>शुभ मुहूर्त क्या है और इसका उपयोग कैसे करें?</h3>
                </div>
                <div class="faq-answer">
                    <p>शुभ मुहूर्त किसी कार्य के लिए पारंपरिक रूप से अनुकूल माना जाने वाला समय है। विवाह, गृह प्रवेश और अन्य महत्वपूर्ण कार्यों के लिए मुहूर्त देखा जाता है।</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item">
                <div class="faq-question">
                    <div class="faq-icon-wrapper faq-icon-orange">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3>राहुकाल क्या है और इसे क्यों टाला जाता है?</h3>
                </div>
                <div class="faq-answer">
                    <p>राहुकाल दिन की एक निश्चित समयावधि है, जिसकी गणना स्थानीय सूर्योदय और सूर्यास्त के आधार पर होती है। कुछ हिंदू परंपराओं में महत्वपूर्ण कार्य शुरू करते समय इसे टालने की सलाह दी जाती है।</p>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="faq-item">
                <div class="faq-question">
                    <div class="faq-icon-wrapper faq-icon-teal">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>दिन और रात के चौघड़िया में क्या अंतर है?</h3>
                </div>
                <div class="faq-answer">
                    <p>दिन का चौघड़िया सूर्योदय से सूर्यास्त और रात का चौघड़िया सूर्यास्त से अगले सूर्योदय के बीच की अवधि से संबंधित होता है।</p>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="faq-item">
                <div class="faq-question">
                    <div class="faq-icon-wrapper faq-icon-red">
                        <i class="fas fa-om"></i>
                    </div>
                    <h3>वास्तु शास्त्र क्या है और इसका क्या महत्व है?</h3>
                </div>
                <div class="faq-answer">
                    <p>वास्तु शास्त्र भवन और स्थान की संरचना से जुड़ी एक पारंपरिक भारतीय पद्धति है। इसमें दिशा और भवन के विभिन्न हिस्सों से संबंधित पारंपरिक विचार शामिल हैं।</p>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="faq-item">
                <div class="faq-question">
                    <div class="faq-icon-wrapper faq-icon-green">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>आज का चौघड़िया कैसे देखें?</h3>
                </div>
                <div class="faq-answer">
                    <p>आज का चौघड़िया देखने के लिए स्थानीय सूर्योदय और सूर्यास्त के समय को ध्यान में रखा जाता है। स्थान बदलने पर चौघड़िया का समय भी बदल सकता है।</p>
                </div>
            </div>

            <!-- FAQ Item 8 -->
            <div class="faq-item">
                <div class="faq-question">
                    <div class="faq-icon-wrapper faq-icon-indigo">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <h3>हिंदू त्योहार कैलेंडर क्या है?</h3>
                </div>
                <div class="faq-answer">
                    <p>हिंदू त्योहार कैलेंडर में विभिन्न व्रत, पर्व और धार्मिक अवसरों की तिथियों की जानकारी दी जाती है।</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Schema Markup for SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "चौघड़िया क्या है और इसका महत्व क्या है?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "चौघड़िया दिन और रात के समय को अलग-अलग अवधियों में समझने की एक पारंपरिक पद्धति है। कुछ हिंदू परंपराओं में इसका उपयोग कार्य शुरू करने के समय की जानकारी के लिए किया जाता है।"
      }
    },
    {
      "@type": "Question",
      "name": "पंचांग क्या है और इसमें क्या जानकारी होती है?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "पंचांग हिंदू कैलेंडर और समय-गणना से जुड़ी पारंपरिक जानकारी देता है। इसमें तिथि, वार, नक्षत्र, योग और करण जैसी जानकारी शामिल होती है।"
      }
    },
    {
      "@type": "Question",
      "name": "शुभ मुहूर्त क्या है और इसका उपयोग कैसे करें?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "शुभ मुहूर्त किसी कार्य के लिए पारंपरिक रूप से अनुकूल माना जाने वाला समय है। विवाह, गृह प्रवेश और अन्य महत्वपूर्ण कार्यों के लिए मुहूर्त देखा जाता है।"
      }
    },
    {
      "@type": "Question",
      "name": "राहुकाल क्या है और इसे क्यों टाला जाता है?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "राहुकाल दिन की एक निश्चित समयावधि है, जिसकी गणना स्थानीय सूर्योदय और सूर्यास्त के आधार पर होती है। कुछ हिंदू परंपराओं में महत्वपूर्ण कार्य शुरू करते समय इसे टालने की सलाह दी जाती है।"
      }
    },
    {
      "@type": "Question",
      "name": "दिन और रात के चौघड़िया में क्या अंतर है?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "दिन का चौघड़िया सूर्योदय से सूर्यास्त और रात का चौघड़िया सूर्यास्त से अगले सूर्योदय के बीच की अवधि से संबंधित होता है। इसका समय स्थान के अनुसार बदल सकता है।"
      }
    },
    {
      "@type": "Question",
      "name": "वास्तु शास्त्र क्या है और इसका क्या महत्व है?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "वास्तु शास्त्र भवन और स्थान की संरचना से जुड़ी एक पारंपरिक भारतीय पद्धति है। इसमें दिशा और भवन के विभिन्न हिस्सों से संबंधित पारंपरिक विचार शामिल हैं।"
      }
    },
    {
      "@type": "Question",
      "name": "आज का चौघड़िया कैसे देखें?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "आज का चौघड़िया देखने के लिए स्थानीय सूर्योदय और सूर्यास्त के समय को ध्यान में रखा जाता है। स्थान बदलने पर चौघड़िया का समय भी बदल सकता है।"
      }
    },
    {
      "@type": "Question",
      "name": "हिंदू त्योहार कैलेंडर क्या है?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "हिंदू त्योहार कैलेंडर में विभिन्न व्रत, पर्व और धार्मिक अवसरों की तिथियों की जानकारी दी जाती है। तिथि और समय स्थान के अनुसार अलग हो सकते हैं।"
      }
    }
  ]
}
</script>
<style>
/* Premium FAQ Section Styling */
.faq-section {
    padding: 80px 0;
    background: #ffffff;
}

.faq-section .section-header-center {
    text-align: center;
    margin-bottom: 50px;
}

.faq-section .section-badge {
    display: inline-block;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
}

.faq-section .section-title {
    font-size: 36px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 16px 0;
    font-family: 'Montserrat', sans-serif;
    line-height: 1.3;
}

.faq-section .section-subtitle {
    font-size: 18px;
    color: #6c757d;
    margin: 0;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 28px;
}

.faq-item {
    background: #ffffff;
    border: 2px solid #e9ecef;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item:hover {
    border-color: #667eea;
    box-shadow: 0 12px 30px rgba(102, 126, 234, 0.15);
}

.faq-question {
    padding: 24px;
    cursor: pointer;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: #ffffff;
    transition: all 0.3s ease;
}

.faq-item:hover .faq-question {
    background: #f8f9fa;
}

.faq-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 20px;
    transition: all 0.3s ease;
}

.faq-icon-gold {
    background: linear-gradient(135deg, #FFC800, #FFA500);
    color: #1a1a2e;
}

.faq-icon-blue {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.faq-icon-purple {
    background: linear-gradient(135deg, #a855f7, #6366f1);
    color: white;
}

.faq-icon-orange {
    background: linear-gradient(135deg, #fa709a, #fee140);
    color: #1a1a2e;
}

.faq-icon-teal {
    background: linear-gradient(135deg, #14b8a6, #0ea5e9);
    color: white;
}

.faq-icon-red {
    background: linear-gradient(135deg, #ef4444, #f97316);
    color: white;
}

.faq-icon-green {
    background: linear-gradient(135deg, #22c55e, #10b981);
    color: white;
}

.faq-icon-indigo {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: white;
}

.faq-item:hover .faq-icon-wrapper {
    transform: scale(1.1);
}

.faq-question h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
    font-family: 'Montserrat', sans-serif;
    line-height: 1.4;
    flex: 1;
}

.faq-answer {
    padding: 0 24px 24px 88px;
    display: block;
}

.faq-answer p {
    font-size: 15px;
    color: #6c757d;
    margin: 0;
    line-height: 1.7;
    font-family: 'Poppins', sans-serif;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .faq-section .section-title {
        font-size: 32px;
    }
    
    .faq-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
}

@media (max-width: 768px) {
    .faq-section {
        padding: 60px 0;
    }
    
    .faq-section .section-title {
        font-size: 28px;
    }
    
    .faq-section .section-subtitle {
        font-size: 16px;
    }
    
    .faq-question {
        padding: 20px;
        gap: 14px;
    }
    
    .faq-icon-wrapper {
        width: 42px;
        height: 42px;
        font-size: 18px;
    }
    
    .faq-question h3 {
        font-size: 16px;
    }
    
    .faq-answer {
        padding: 0 20px 20px 76px;
    }
    
    .faq-answer p {
        font-size: 14px;
    }
}
</style>



<!-- Final responsive layout refinements: Panchang, categories and article cards -->
<style>
/* Keep the daily information section comfortably wide on desktop. */
#today-choghadiya.section-gradient {
    padding-block: clamp(42px, 5vw, 76px);
}
#today-choghadiya > .container {
    width: calc(100% - 48px) !important;
    max-width: 1320px !important;
    margin-inline: auto !important;
    padding-inline: 0 !important;
    box-sizing: border-box !important;
}
#today-choghadiya .section-header-center {
    max-width: 980px;
    margin: 0 auto 30px;
}
#today-choghadiya .today-grid {
    display: grid !important;
    grid-template-columns: minmax(0, 1.7fr) minmax(340px, 0.9fr) !important;
    align-items: stretch;
    gap: 28px !important;
    width: 100%;
    min-width: 0;
}
#today-choghadiya .today-card {
    min-width: 0;
    width: 100%;
    box-sizing: border-box;
    border-radius: 14px;
    overflow: hidden;
}
#today-choghadiya .today-card-header {
    min-height: 66px;
    padding: 18px 22px;
    box-sizing: border-box;
}
#today-choghadiya .today-card-header .header-text {
    min-width: 0;
}
#today-choghadiya .choghadiya-table {
    width: 100%;
    overflow-x: auto;
    overscroll-behavior-inline: contain;
}
#today-choghadiya .choghadiya-row {
    min-width: 0;
}

/* Panchang rows: stable label/value columns, generous touch/read spacing. */
#today-choghadiya .panchang-card .panchang-list {
    padding: 4px 0 14px;
    min-width: 0;
}
#today-choghadiya .panchang-item {
    display: grid !important;
    grid-template-columns: minmax(92px, 0.72fr) minmax(0, 1.28fr) !important;
    align-items: start;
    gap: 7px 14px;
    min-width: 0;
    padding: 13px 20px;
    box-sizing: border-box;
    border-bottom: 1px solid #e8eaf0;
}
#today-choghadiya .panchang-item .label {
    min-width: 0;
    color: #344054;
    font-weight: 650;
    line-height: 1.55;
    overflow-wrap: anywhere;
}
#today-choghadiya .panchang-item .value {
    min-width: 0;
    color: #5368e8;
    line-height: 1.6;
    text-align: right;
    overflow-wrap: anywhere;
    word-break: normal;
}
#today-choghadiya .panchang-item .time {
    grid-column: 2;
    min-width: 0;
    margin-top: -3px;
    color: #667085;
    font-size: 12px;
    line-height: 1.5;
    text-align: right;
    overflow-wrap: anywhere;
}
#today-choghadiya .panchang-item .time:empty {
    display: none !important;
}
#today-choghadiya .panchang-item.highlight {
    border-left: 4px solid #667eea;
    background: #eff5ff;
}
#today-choghadiya .panchang-divider {
    margin: 8px 20px;
    border-top: 1px solid #e6e8f0;
}
#today-choghadiya .panchang-solar-item:last-child {
    border-bottom: 0;
}

/* Four-category section: use the available desktop width and preserve clean SVG cards. */
.homepage-sacred-categories > .container,
.section-editorial > .container {
    width: calc(100% - 48px) !important;
    max-width: 1320px !important;
    margin-inline: auto !important;
    padding-inline: 0 !important;
    box-sizing: border-box !important;
}
.homepage-sacred-categories__grid {
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 20px;
    align-items: stretch;
}
.homepage-sacred-category-card {
    height: 100%;
    min-width: 0;
    box-sizing: border-box;
}
.homepage-sacred-category-card__description {
    overflow-wrap: anywhere;
}

/* Article listing: three balanced cards on wide screens, two on medium screens. */
.section-editorial .editorial-content {
    grid-template-columns: minmax(0, 1fr) minmax(260px, 300px);
    gap: 32px;
    align-items: start;
}
.section-editorial .editorial-main-grid {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 22px;
    min-width: 0;
}
.section-editorial .editorial-article {
    min-width: 0;
    height: 100%;
    box-sizing: border-box;
}
.section-editorial .editorial-image-wrapper {
    aspect-ratio: 16 / 10;
}
.section-editorial .editorial-content-wrapper {
    min-width: 0;
    padding: 0 16px 18px;
}
.section-editorial .editorial-content-header h3 {
    font-size: clamp(16px, 1.25vw, 19px);
    line-height: 1.45;
    overflow-wrap: anywhere;
}
.section-editorial .editorial-excerpt {
    line-height: 1.7;
    overflow-wrap: anywhere;
}

@media (max-width: 1120px) {
    #today-choghadiya .today-grid {
        grid-template-columns: minmax(0, 1.45fr) minmax(310px, 0.95fr) !important;
        gap: 20px !important;
    }
    .section-editorial .editorial-content {
        grid-template-columns: minmax(0, 1fr) 270px;
        gap: 24px;
    }
    .section-editorial .editorial-main-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }
}
@media (max-width: 900px) {
    #today-choghadiya > .container,
    .homepage-sacred-categories > .container,
    .section-editorial > .container {
        width: calc(100% - 36px) !important;
    }
    #today-choghadiya .today-grid {
        grid-template-columns: minmax(0, 1fr) !important;
        gap: 22px !important;
    }
    .section-editorial .editorial-content {
        grid-template-columns: minmax(0, 1fr);
        gap: 28px;
    }
    .section-editorial .editorial-sidebar {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }
}
@media (max-width: 600px) {
    #today-choghadiya > .container,
    .homepage-sacred-categories > .container,
    .section-editorial > .container {
        width: calc(100% - 28px) !important;
    }
    #today-choghadiya .today-card-header {
        padding: 16px;
    }
    #today-choghadiya .panchang-card .panchang-list {
        padding-bottom: 8px;
    }
    #today-choghadiya .panchang-item {
        grid-template-columns: minmax(76px, 0.72fr) minmax(0, 1.28fr) !important;
        gap: 6px 10px;
        padding: 12px 14px;
        font-size: 14px;
    }
    #today-choghadiya .panchang-item .label,
    #today-choghadiya .panchang-item .value {
        font-size: 13px;
    }
    #today-choghadiya .panchang-divider {
        margin-inline: 14px;
    }
    .homepage-sacred-categories__grid {
        grid-template-columns: minmax(0, 1fr);
        gap: 12px;
    }
    .homepage-sacred-category-card {
        min-height: 0;
    }
    .section-editorial .editorial-main-grid {
        grid-template-columns: minmax(0, 1fr);
        gap: 18px;
    }
    .section-editorial .editorial-sidebar {
        grid-template-columns: minmax(0, 1fr);
    }
}
</style>

<!-- Include footer with all enhancements -->
<?php require_once __DIR__ . '/../includes/footer.php'; ?>