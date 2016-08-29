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
        redirect('?key=propertiestoarray');
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

    include_once($tool['file']);
    $className = $tool['filename'];
    $object = new $className($post['content']);
    $object->init();
    $object->run();
    $beforeText = $object->getBeforeText();
    $text       = $object->getText();
    $afterText  = $object->getAfterText();


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
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
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
        <input type="submit" name="submit_default"  value="Submit"  />
        <input type="submit" name="submit_save"     value="Save"    />
        <input type="button" value="Clear" onclick="document.forms['formSubmit'].content.value = '';" />

        <table style="border-spacing: 10px;">
            <tbody>
                <tr style="vertical-align:top;">
                    <td style="width:300px;">

                        <textarea id="content" name="content" style="width:100%; height: 100%;"><?php echo $text; ?></textarea>

                    </td>
                    <td style="width:800px;">

                        <textarea id="beforeText" style="width:100%; min-height:600px;"><?php echo $beforeText; ?></textarea>
                        <p></p>
                        <textarea id="afterText"  style="width:100%; min-height:100px;" ><?php echo $afterText; ?></textarea>

                    </td>
                    <td style="width:100px;">
                        <?php showByAllData($allData, $tool, $object); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <script type="text/javascript">

        var defaultValue = "<?php echo escape($object->getDefaultText(), 'javascript') ?>";

        function setContentTextarea(text)
        {
            $("#content").val(text);
        }

    </script>

    <br />

  </body>
</html>
<?php


    function showByAllData(Array $allData, Array $tool, $object)
    {
        echo <<<EOD
            <a href="javascript:void(0)" onclick="setContentTextarea(defaultValue)">
                <div style="margin: 5px; color:#009900;">Default</div>
            </a>
EOD;


        $order = -1;
        $colorIndex = 1;
        $allColor = ['001122' , 'ff0011'];
        foreach ($allData as $data) {
            $order++;
            $colorIndex = 1 - $colorIndex;
            $content = print_r($data, true);
            $text = mb_substr($content, 0, 20);
            $color = $allColor[$colorIndex];
            $url = "?key={$tool['key']}&load={$order}";
            echo <<<EOD
                <div style="margin: 5px; color:{$color}">
                    <a href="{$url}">{$text}</a>
                </div>
EOD;
        }
    }

