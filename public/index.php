<?php

    include_once __DIR__ . "/../vendor/autoload.php";
    init();

    $tools = loadVar('tools-cache');
    if (!$tools) {
        die("Can't find any file");
    }


    $post = [
        'key'     => getParam('key'),
        'content' => getParam('content'),
    ];
    if (!isset($tools[$post['key']])) {
        redirect('?key=json_show');
    }
    $tool = $tools[$post['key']];
    $key = $tool['key'];


    // dd($tool);
    // dd($tools);
    // dd($_POST);

    if (!file_exists($tool['file'])) {
        echo 'File not found';
        exit;
    }

    //echo '<pre>';
    //print_r($tool);
    //exit;
    // dirname(__DIR__)
    include_once($tool['file']);
    $className = $tool['filename'];
    $object = new $className($post['content']);
    $object->init();
    $object->run();
    $text = $object->getText();

    // --------------------------------------------------------------------------------
    // post & redirect
    // --------------------------------------------------------------------------------

    // submit_save
    // 儲存暫存的內容
    if (getParam('submit_save') && null !== $text && '' !== $text) {
        $allData = [];
        $tmp = loadVar('history/' . $key);
        $allData[] = $text;
        $i = 1;
        foreach ($tmp as $data) {
            $i++;
            if ($i > 10) {
                // 最多儲存幾份
                break;
            }
            $allData[] = $data;
        }
        saveVar('history/' . $key, $allData);
    }

    // --------------------------------------------------------------------------------
    // start
    // --------------------------------------------------------------------------------

    // 讀取暫存的內容
    $allData = loadVar('history/' . $key);

    //
    if (null !== getParam('load')) {
        $loadIndex = (int) getParam('load');
        if (isset($allData[$loadIndex])) {
            $text = $allData[$loadIndex];
        }
    }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="main.css" />
    <script type='text/javascript' src='dist/jquery/jquery.min.js'></script>
    <script type='text/javascript' src='dist/clipboard/clipboard.min.js'></script>
    <script type='text/javascript' src='main.js'></script>
    <script>
    </script>
  </head>
  <body>

    <form name="formSubmit" action="<?php echo "?key=" . $key ?>" method="post" enctype="multipart/form-data" style="margin: 0;">
        <?php
            foreach ($tools as $file) {
                $url = "?key={$file['key']}";
                $styleClass = "";
                if ($tool['key'] === $file['key']) {
                    $styleClass = 'focus';
                }
                echo '<a class="button '. $styleClass .'" href="'. $url .'" />'. $file['title'] .'</a>' . "\n";
            }
        ?>

        <p></p>

        <table style="border-spacing: 10px;">
            <tbody>
                <tr style="vertical-align:top;">
                    <td style="width: 300px;">

                        <input type="submit" name="submit_default"  value="Submit (Ctrl + Enter)" />
                        <input type="submit" name="submit_save"     value="Save" />
                        <input type="button" value="Clear" onclick="document.forms['formSubmit'].content.value = '';" />

                        <textarea id="content" name="content" style="width:100%; min-height:400px;"><?php echo $text; ?></textarea>

                    </td>
                    <td style="width: 800px; max-width: 800px;">

                        <input type="button" class="js_clipboard" value="Copy To Clipboard"data-clipboard-target="#showResult" />

                        <textarea id="showResult" style="width:100%; min-height:400px;"><?php echo $object->getResult(); ?></textarea>
                        <?php
                            foreach ($object->getAllOutput() as $tmp) {
                                $content = $tmp['content'];
                                $type    = $tmp['type'];
                                switch ($type)
                                {
                                    case 'pre':
                                        echo <<<EOD
                                            <div class="item"><pre class="outputPre">{$content}</pre></div>
EOD;
                                    break;
                                    case 'textarea':
                                    default:
                                        echo <<<EOD
                                            <textarea class="outputTextarea" style="width:100%; min-height:150px;">{$content}</textarea>
EOD;
                                }
                            }
                        ?>
                    </td>
                    <td style="width:200px; background-color:#ffeeff">
                        <a href="javascript:void(0)" onclick="setInputBox(defaultValue)">
                            <div style="margin: 5px; color:#009900;">Default</div>
                        </a>
                        <?php showByCacheData($allData, $key); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <script>

        var defaultValue = "<?php echo escape($object->getDefaultText(), 'javascript') ?>";

        (function(){
            new Clipboard('.js_clipboard');
        })();

        (function(){
            let minHeight = 100;
            let elements = document.getElementsByClassName('outputTextarea');
            for (let key in elements) {
                let el = elements[key];
                if (!el || ! el.value) {
                    continue;
                }

                let newLines = el.value.match(/\n/g);
                if (! newLines) {
                    continue;
                }

                let styleHeightCalculation = newLines.length * 16;
                if (styleHeightCalculation > minHeight) {
                    el.style.minHeight = styleHeightCalculation + "px";
                }
            }
        })();

    </script>

  </body>
</html>
<?php

    /**
     * 顯示暫存資料的部份資訊
     * 點擊後會經由 php 重新取得資料
     */
    function showByCacheData(Array $allData, $key)
    {
        $order = -1;
        $colorIndex = 1;
        $allColor = ['001122' , 'ff0011'];
        foreach ($allData as $data) {
            $order++;
            $colorIndex = 1 - $colorIndex;
            $content = print_r($data, true);
            $text = mb_substr($content, 0, 20);
            $color = $allColor[$colorIndex];
            $url = "?key={$key}&load={$order}";
            echo <<<EOD
                <div style="margin: 5px; color:{$color}">
                    <a href="{$url}">{$text}</a>
                </div>
EOD;
        }
    }

