<?php

    include_once __DIR__ . "/../vendor/autoload.php";
    init();

    $post = [
        'key'     => getParam('key'),
        'content' => getParam('content'),
    ];

    $tools = loadVar('tools-cache.json');
    if (!$tools) {
        die("Can't find any file");
    }

    if (isset($tools[$post['key']])) {
        $tool = $tools[$post['key']];
    }
    else {
        // $post['key'] = key($tools);
        $post['key'] = 'propertiestoarray';
        $tool = $tools[$post['key']];
    }

dd($_POST);
dd($tool);

    include_once($tool['file']);
    $className = $tool['filename'];
    $object = new $className($post['content']);
    $object->init();
    $object->run();
    $beforeText = $object->getBeforeText();
    $text       = $object->getText();
    $afterText  = $object->getAfterText();

    // submit_save
    // 儲存暫存的內容
    if (getParam('submit_save')) {
        $allData = [];
        $tmp = loadVar($tool['key']);
        $allData[] = $text;
        foreach ($tmp as $data) {
            $allData[] = $data;
        }
        saveVar($tool['key'], $allData);
    }

    // 讀取暫存的內容
    $allData = loadVar($tool['key']);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="main.css" />
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script type='text/javascript' src='main.js'></script>
  </head>
  <body>

    <form name="formSubmit" action="" method="post" enctype="multipart/form-data" style="margin: 0;" >
        <?php
            foreach ($tools as $file) {
                echo '<input type="radio" name="key" value="'. $file['key'] .'" />' . "\n";
                echo '<label for="'. $file['key'] .'">'. $file['title'] .'</label>';
            }
        ?>
        <p></p>
        <input type="submit" name="submit_default"  value="Submit"  />
        <input type="submit" name="submit_save"     value="Save"    />
        <input type="hidden" name="submitType" />
        <input type="button" value=" clear " onclick="document.forms[0].content.value = '';" />

        <table style="border-spacing: 10px;">
            <tbody>
                <tr style="vertical-align:top;">
                    <td style="width:300px;">

                        <textarea id="content" name="content" style="width:100%; height: 100%;"><?php echo $text; ?></textarea>

                    </td>
                    <td style="width:800px;">

                        <textarea id="beforeText" style="width:100%; min-height:700px;"><?php echo $beforeText; ?></textarea>
                        <textarea id="afterText"  style="width:100%; min-height:50px;"><?php echo $afterText; ?></textarea>

                    </td>
                    <td style="width:100px;">
                        <?php showByAllData($allData); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <script type="text/javascript">
        var focus = "<?php echo $post['key']; ?>";
        if (focus) {
            $('input[value=' + focus + ']').get(0).checked = true;
        }
    </script>

    <br />

  </body>
</html>
<?php


    function showByAllData(Array $allData)
    {
        $index = 1;
        $allColor = ['001122' , 'ff0011'];
        foreach ($allData as $data) {
            $index = 1-$index;
            $content = print_r($data, true);
            $text = mb_substr($content, 0, 20);
            $color = $allColor[$index];
            echo <<<EOD
                <div style="margin: 5px; color:{$color}">
                    {$text}
                </div>
EOD;
        }
    }


