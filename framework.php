<?php


// get headers - cache for reuse
function my_get_headers($site) {
    static $cached_headers = array();
    
    if (!isset($cached_headers[$site])) {
        $cached_headers[$site] = get_headers($site, 1);
    }

    return $cached_headers[$site];
}

// deprecated
function checkSite($sites) {
    foreach ($sites as $site) {
        $h = my_get_headers($site);
        echo '<h3>';
        echo status($h[0]);
        $location = $h['Location'];
        echo '&nbsp;<a href="'.$site.'">'.$site.'</a>';
        if ($location != "") {
            echo ' ➔ <a href="'.a2s($h['Location']).'">'.a2s($h['Location']).'</a>';
        }
        echo '</h3>';
        echo "<ul>";

        $html = file_get_contents($site, NULL, NULL, -1, 1000);
        preg_match("/<title>(.+)<\/title>/siU", $html, $matches);

        if ($matches[1] != "") {
            echo '<li>Title: '.$matches[1].'</li>';
        }

        $content = a2s($h['Content-Type']);
        if ($content != "") {
            echo '<li>Content: '.$content.'</li>';
        }
    echo "<pre>";
    print_r($h);
    echo "</pre>";
        echo "</ul>";
    }
}

// deprecated
function status($code) {
    $code = str_replace('HTTP/1.0 ', '', $code);
    $code = str_replace('HTTP/1.1 ', '', $code);
    switch (strtoupper($code)) {
        case "200 OK":
            return '<span class="label success">'.$code.'</span>';

        case "401 AUTHORIZATION REQUIRED":
        case "401 AUTHENTICATION REQUIRED":
            return '<span class="label warning">'.$code.'</span>';

        case "404 NOT FOUND":
        case "504 GATEWAY TIME-OUT":
            return '<span class="label important">'.$code.'</span>';

        case "":
            return '<span class="label important">offline</span>';

        default:
            return '<span class="label notice">'.$code.'</span>';
    }
}

function a2s($array) {
    if (!is_array($array)) {
        return $array;
    } else {
        return end($array);
    }
}

function assertRedirectionEQ($url, $target, $critial = true) {
    $h = my_get_headers($url);

    if (is_array($h['Location'])) {
        $location = end($h['Location']);
    } else {
        $location = $h['Location'];
    }

    if ($location != $target) {
        echo '<p><span class="label '.($critial ? 'important' : 'warning').'">falsche Weiterleitung</span> Die URL <strong><a href="'.$url.'">'.$url.'</a></strong> wird falsch weitergeleitet:</p>';
        echo '<p><ul>';
        echo '<li>derzeitige Weiterleitung: <strong><a href="'.$location.'">'.$location.'</a></strong></li>';
        echo '<li>erwartete Weiterleitung: <strong><a href="'.$target.'">'.$target.'</strong></a></li>';
        echo '<li>Details:';
        echo "<pre>";
        print_r($h);
        echo "</pre>";
        echo "</li>";
        echo '</ul></p>';
    }

    return ($location == $target);
}

function code2string($code) {
    static $codes = Array(
        NULL => "none",
        200 => "200 OK",
        301 => "301 Moved Permanently",
        302 => "302 Found",
        401 => "401 Authorization Required",
        404 => "404 Not Found"
    );

    return $codes[$code];
}

function assertStatusEQ($url, $code, $critial = true) {
    $h = my_get_headers($url);
    $mycode = $h[0];

    $mycode = str_replace('HTTP/1.0 ', '', $mycode);
    $mycode = str_replace('HTTP/1.1 ', '', $mycode);

    if ($mycode != intval($code)) {
        echo '<p><span class="label '.($critial ? 'important' : 'warning').'">falscher Statuscode</span> Der HTTP-Statuscode von <strong><a href="'.$url.'">'.$url.'</a></strong> ist falsch:</p>';
        echo '<p><ul>';
        echo '<li>derzeitiger Statuscode: <strong>'.code2string($mycode).'</strong></li>';
        echo '<li>erwarteter Statuscode: <strong>'.code2string($code).'</strong></li>';
        echo '<li>Details:';
        echo "<pre>";
        print_r($h);
        echo "</pre>";
        echo "</li>";
        echo '</ul></p>';
    }

    return ($mycode == intval($code));
}

function assertContentEQ($url, $content, $critial = true) {
    $h = my_get_headers($site);
    return (a2s($h['Content-Type']) == $content);
}

function assertPortUp($url, $port, $critial = true) {
    static $ports = Array(
         20 => 'FTP',
         21 => 'FTP',
         22 => 'SSH',
         23 => 'Telnet',
         25 => 'SMTP',
         53 => 'DNS',
         80 => 'HTTP',
        110 => 'POP',
        119 => 'NNTP',
        123 => 'NTP',
        143 => 'IMAP',
        443 => 'HTTPS',
        587 => 'SMTP'
    );

    $fp = fsockopen($url, $port, $errno, $errstr, 10);

    if (!$fp) {
        echo '<p><span class="label '.($critial ? 'important' : 'warning').'">Port unerreichbar</span> ';
        echo 'Der auf der Adresse <strong>'.$url.'</strong> ist Port <strong>'.$port.' ('.$ports[$port].')</strong> nicht erreichbar:</p>';
        echo "<pre>$errstr ($errno)\n</pre>";
        return false;
    } else {
        return true;
    }
}

function assertTitleEQ($url, $title, $critial = true) {
    $html = file_get_contents($url, NULL, NULL, -1, 1000);
    preg_match("/<title>(.+)<\/title>/siU", $html, $matches);

    if ($title != $matches[1]) {
        echo '<p><span class="label '.($critial ? 'important' : 'warning').'">falscher Seitentitel</span> Der Seitentitel von <strong><a href="'.$url.'">'.$url.'</a></strong> ist falsch:</p>';
        echo '<p><ul>';
        echo '<li>derzeitiger Seitentitel: <strong>'.$matches[1].'</strong></li>';
        echo '<li>erwarteter Seitentitel: <strong>'.$title.'</strong></li>';
        echo '</ul></p>';
    }

    return ($title == $matches[1]);
}


?>