<?php

    include_once __DIR__ . "/../vendor/autoload.php";
    init();

    define('TOOLS_DIRECTORY_FILES', getRootPath() . '/tools/*.php');

    $toolFilenames = [];
    foreach (glob(TOOLS_DIRECTORY_FILES) as $file) {

        $tmp = pathinfo($file);
        $key = strtolower($tmp['filename']);

        // include 的目的是要取得該 class 的資訊
        include($file);
        $title = getClassInfoTitle($tmp['filename']);
        if (!$title) {
            $title = $tmp['filename'];
        }

        //
        $tools[$key] = [
            'key'       => $key,
            'filename'  => $tmp['filename'],
            'basename'  => $tmp['basename'],
            'file'      => $file,
            'title'     => $title,
        ];

    }

    //save
    saveVar('tools-cache', $tools);
