<?php

switch ($_REQUEST['q']) {
    case "assertPortUp": {
        echo assertPortUp($_REQUEST['url'], $_REQUEST['port']);
        break;
    }

    case "assertRedirectionEQ": {
        echo assertRedirectionEQ($_REQUEST['url'], $_REQUEST['target']);
        break;
    }

    case "assertStatusEQ": {
        echo assertStatusEQ($_REQUEST['url'], $_REQUEST['code']);
        break;
    }

    case "assertTitleEQ": {
        echo assertTitleEQ($_REQUEST['url'], $_REQUEST['title']);
        break;
    }
}


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

    $result = "";
    if ($location != $target) {
        $result .= '<p><span class="label '.($critial ? 'important' : 'warning').'">falsche Weiterleitung</span> Die URL <strong><a href="'.$url.'">'.$url.'</a></strong> wird falsch weitergeleitet:</p>';
        $result .= '<p><ul>';
        $result .= '<li>derzeitige Weiterleitung: <strong><a href="'.$location.'">'.$location.'</a></strong></li>';
        $result .= '<li>erwartete Weiterleitung: <strong><a href="'.$target.'">'.$target.'</strong></a></li>';
        $result .= '<li>Details:';
        $result .= "<pre>";
        $result .= print_r($h, true);
        $result .= "</pre>";
        $result .= "</li>";
        $result .= '</ul></p>';
    } else {
        $result = '<p><span class="label success"> Test erfolgreich</span> Umleitung von URL <strong><a href="'.$url.'">'.$url.'</a></strong> ist <strong><a href="'.$location.'">'.$location.'</a></strong>.</p>';
    }

    return $result;
}

function code2string($code) {
    static $codes = Array(
        NULL => "none",
        200 => "200 OK",
        301 => "301 Moved Permanently",
        302 => "302 Found",
        401 => "401 Authorization Required",
        404 => "404 Not Found",
        502 => "502 Bad Gateway"
    );

    return $codes[$code];
}

function assertStatusEQ($url, $code, $critial = true) {
    $h = my_get_headers($url);
    $mycode = $h[0];

    $mycode = str_replace('HTTP/1.0 ', '', $mycode);
    $mycode = str_replace('HTTP/1.1 ', '', $mycode);

    $mycode = intval($mycode);

    $result = "";
    if ($mycode != intval($code)) {
        $result .= '<p><span class="label '.($critial ? 'important' : 'warning').'">falscher Statuscode</span> Der HTTP-Statuscode von <strong><a href="'.$url.'">'.$url.'</a></strong> ist falsch:</p>';
        $result .= '<p><ul>';
        $result .= '<li>derzeitiger Statuscode: <strong>'.code2string($mycode).'</strong></li>';
        $result .= '<li>erwarteter Statuscode: <strong>'.code2string($code).'</strong></li>';
        $result .= '<li>Details:';
        $result .= "<pre>";
        $result .= print_r($h, true);
        $result .= "</pre>";
        $result .= "</li>";
        $result .= '</ul></p>';
    } else {
        $result = '<p><span class="label success"> Test erfolgreich</span> HTTP-Statuscocde von <strong><a href="'.$url.'">'.$url.'</a></strong> ist '.$mycode.'.</p>';
    }

    return $result;
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
        587 => 'SMTP',
        5222 => 'XMPP',
        5223 => 'XMPP',
        5269 => 'XMPP',
        64738 => 'Mumble'
    );

    $fp = fsockopen($url, $port, $errno, $errstr, 10);

    $result = "";
    if (!$fp) {
        $result .= '<p><span class="label '.($critial ? 'important' : 'warning').'">Port unerreichbar</span> ';
        $result .= 'Der auf der Adresse <strong>'.$url.'</strong> ist Port <strong>'.$port.' ('.$ports[$port].')</strong> nicht erreichbar:</p>';
        $result .= "<pre>$errstr ($errno)\n</pre>";
    } else {
        $result = '<p><span class="label success"> Test erfolgreich</span> Port '.$port.' ('.$ports[$port].') von <strong>'.$url.'</strong> ist erreichbar.</p>';
    }

    return $result;
}

function assertTitleEQ($url, $title, $critial = true) {
    $html = file_get_contents($url, NULL, NULL, -1, 1000);
    preg_match("/<title>(.+)<\/title>/siU", $html, $matches);

    $result = "";
    if ($title != $matches[1]) {
        $result .= '<p><span class="label '.($critial ? 'important' : 'warning').'">falscher Seitentitel</span> Der Seitentitel von <strong><a href="'.$url.'">'.$url.'</a></strong> ist falsch:</p>';
        $result .= '<p><ul>';
        $result .= '<li>derzeitiger Seitentitel: <strong>'.$matches[1].'</strong></li>';
        $result .= '<li>erwarteter Seitentitel: <strong>'.$title.'</strong></li>';
        $result .= '</ul></p>';
    } else {
        $result = '<p><span class="label success"> Test erfolgreich</span> Seitentitel von <strong><a href="'.$url.'">'.$url.'</a></strong> ist "'.$title.'".</p>';
    }

    return $result;
}


?>