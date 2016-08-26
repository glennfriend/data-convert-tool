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

    include_once($tool['file']);
    $className = $tool['filename'];
    $object = new $className($post['content']);
    $object->init();
    $object->run();
    $beforeText = $object->getBeforeText();
    $text       = $object->getText();
    $afterText  = $object->getAfterText();


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
        <input type="submit" value=" submit " />
        <input type="button" value=" clear " onclick="document.forms[0].content.value = '';" />

        <table style="width:100%; border-spacing: 10px;">
            <tbody>
                <tr>
                    <td style="width:40%;">

                        <textarea id="content" name="content" style="width:100%; min-height:300px;"><?php echo $text; ?></textarea>

                    </td>
                    <td style="width:60%; vertical-align:top;">

                        <div id="beforeText"><?php echo $beforeText; ?></div>
                        <div id="afterText"><?php echo $afterText; ?></div>

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
