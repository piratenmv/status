<?php

static $id = 0;

function assertRedirectionEQ($url, $target, $critial = true) {
    global $id;
    echo '<div id="result'.$id.'"></div>';

    echo '<script>';
    echo '$.post("check.php", { q: "assertRedirectionEQ", url: "'.$url.'", target: "'.$target.'" } , function(data) {';
    echo '$("#result'.$id.'").append(data);';
    echo '});';
    echo '</script>';

    $id++;
}

function assertStatusEQ($url, $code, $critial = true) {
    global $id;
    echo '<div id="result'.$id.'"></div>';

    echo '<script>';
    echo '$.post("check.php", { q: "assertStatusEQ", url: "'.$url.'", code: "'.$code.'" } , function(data) {';
    echo '$("#result'.$id.'").append(data);';
    echo '});';
    echo '</script>';

    $id++;
}

function assertContentEQ($url, $content, $critial = true) {
}

function assertPortUp($url, $port, $critial = true) {
    global $id;
    echo '<div id="result'.$id.'"></div>';

    echo '<script>';
    echo '$.post("check.php", { q: "assertPortUp", url: "'.$url.'", port: "'.$port.'" } , function(data) {';
    echo '$("#result'.$id.'").append(data);';
    echo '});';
    echo '</script>';

    $id++;
}

function assertTitleEQ($url, $title, $critial = true) {
    global $id;
    echo '<div id="result'.$id.'"></div>';

    echo '<script>';
    echo '$.post("check.php", { q: "assertTitleEQ", url: "'.$url.'", title: "'.$title.'" } , function(data) {';
    echo '$("#result'.$id.'").append(data);';
    echo '});';
    echo '</script>';

    $id++;
}


?>