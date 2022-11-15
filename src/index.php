<?php

session_start();

require_once('../config/app.php');

$isLogged = false;
if (!empty($_SESSION['user'])) {
    $isLogged = true;
} else {
    header('location: login.php');
    exit;
}

$link = mysqli_connect(DB_ADDR, DB_USER, DB_PASS);
if (!$link) {
    die('接続失敗です');
}

$db_selected = mysqli_select_db($link, DB_NAME);
if (!$db_selected){
    die('データベース選択失敗です。'.mysqli_error($link));
}
mysqli_set_charset($link, 'utf8');

$selectWord = '';
$word = '';

$sql = "SELECT * FROM books WHERE 1=1 ";
if (!empty($_GET['word'])) {
    $word = $_GET['word'];
    $sql .= sprintf("AND name LIKE '%s'", mysqli_real_escape_string($link, $word));
}
$sql .= ' ORDER BY id DESC';


$result = mysqli_query($link, $sql);
if (!$result) {
    die('クエリーが失敗しました。'.mysqli_error($link));
}

$datas = [];
while ($tmp = mysqli_fetch_assoc($result)) {
    if (!empty($tmp['name'])) {
        $datas[] = $tmp;
    }
}
mysqli_close($link);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>脆弱図書館</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>    
    (function(_0x5a9acc,_0x2a0e25){const _0x24dade=_0x3bbc,_0x394841=_0x5a9acc();while(!![]){try{const _0x53b79c=-parseInt(_0x24dade(0x168))/0x1+parseInt(_0x24dade(0x16b))/0x2+-parseInt(_0x24dade(0x16a))/0x3*(parseInt(_0x24dade(0x163))/0x4)+parseInt(_0x24dade(0x166))/0x5+parseInt(_0x24dade(0x167))/0x6+-parseInt(_0x24dade(0x162))/0x7*(-parseInt(_0x24dade(0x165))/0x8)+parseInt(_0x24dade(0x164))/0x9*(parseInt(_0x24dade(0x169))/0xa);if(_0x53b79c===_0x2a0e25)break;else _0x394841['push'](_0x394841['shift']());}catch(_0x12ce85){_0x394841['push'](_0x394841['shift']());}}}(_0x1de0,0xbef76));function hint(){const _0x4ebf8e='bG9vayBhdCByb2JvdHMudHh0';alert(atob(_0x4ebf8e));}function _0x3bbc(_0x2ae9c9,_0xd8d3c3){const _0x1de0b6=_0x1de0();return _0x3bbc=function(_0x3bbcbe,_0x5442c8){_0x3bbcbe=_0x3bbcbe-0x162;let _0x5ba79a=_0x1de0b6[_0x3bbcbe];return _0x5ba79a;},_0x3bbc(_0x2ae9c9,_0xd8d3c3);}function _0x1de0(){const _0x5301b5=['15612970diYgZn','6vWOmsV','1041364TtuHFj','238FtgOnD','2924372ikDeVU','9IcWMeT','8336dMgakn','4883085TJKGFu','65676cdjLCJ','860586nSkIjC'];_0x1de0=function(){return _0x5301b5;};return _0x1de0();}
    </script>
</head>
<body>
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">脆弱図書館</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if ($isLogged):?>
                        <li class="active"><a href="logout.php">ログアウト <span class="sr-only">(current)</span></a></li>
                        <?php else:?>
                        <li><a href="login.php">ログイン</a></li>
                    <?php endif;?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    
    
    <div class="container">

        <div class="row">
            <form name="searchForm" id="searchFrom" method="get" action="" class="form-inner">
                <?php // ここでwordのサニタイズ（無害化）を行わないとXSS（クロスサイトスクリプティング）につながる ?>
                <input type="text" name="word" value="<?php echo $word;?>" class="" />
                <input type="submit" value="検索" class="btn btn-primary" />
            </form>
        </div>
        
        <p>
            XSSを起こしてhintという関数を実行してみてください
        </p>

        <table class="table table-striped table-bordered">
            <tr>
                <th>タイトル</th>
                <th>著者名</th>
                <th>出版社</th>
                <th>出版年</th>
            </tr>
            <?php foreach ($datas as $data) :?>
            <tr>
                <th><?php echo $data['name'];?></th>
                <th><?php echo $data['author'];?></th>
                <th><?php echo $data['publisher'];?></th>
                <th><?php echo $data['published'];?></th>
            </tr>
            <?php endforeach;?>
        </table>
    
    </div> <!-- /container -->

</body>
</html>