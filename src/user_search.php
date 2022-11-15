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
if (!empty($_GET['word'])) {
    $word = $_GET['word'];
    $selectWord = "AND name LIKE '%{$word}%'";
}

$sql = "SELECT * FROM users WHERE 1=1 {$selectWord} ORDER BY id DESC";
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
    <title>ユーザー検索 - 脆弱図書館</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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
                <input type="text" name="word" value="<?php echo htmlspecialchars($word, ENT_QUOTES);?>" class="" size=100/>
                <input type="submit" value="検索" class="btn btn-primary" />
            </form>
        </div>
        
        <p>SQLインジェクションで管理者の認証情報を取得しよう</p>

        <table class="table table-striped table-bordered">
            <tr>
                <th>ID</th>    
                <th>ログインID</th>
                <th>ユーザー名</th>
            </tr>
            <?php foreach ($datas as $data) :?>
            <tr>
                <th><?php echo $data['id'];?></th>
                <th><?php echo $data['login_id'];?></th>
                <th><?php echo $data['name'];?></th>
            </tr>
            <?php endforeach;?>
        </table>
    
    </div> <!-- /container -->

</body>
</html>