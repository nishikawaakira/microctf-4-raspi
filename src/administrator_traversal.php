<?php
session_start();

require_once('../config/app.php');

if (empty($_SESSION['admin'])) {
    // ログイン済みの場合はログイン画面を表示させない
    header('location: /administrator_login.php');
    exit;
}
$file = '';
$file_data = '';
// ログイン処理
if (!empty($_POST['file'])) {
    
    $file = $_POST['file'];
    if (file_exists('/var/www/html/' . $file)) {
        $file_data = file_get_contents('/var/www/html/' . $file) ;
    } else {
        $message = $file . '<br>ファイルが存在しません';
    }
}

$file_list = [];
if ($dh = opendir('./')) {
    while (($file = readdir($dh)) !== false) {
        $tmp = explode('.', $file);
        $ext = $tmp[count($tmp) - 1];
    
        if ($ext === 'php' && $file !== 'administrator_traversal.php') {
            $file_list[] = $file;
        }
    }
    closedir($dh);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>管理画面ファイル読み込み - 脆弱図書館</title>
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
                <a class="navbar-brand" href="#">脆弱図書館管理画面</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if ($isLogged):?>
                        <li class="active"><a href="logout.php">ログアウト <span class="sr-only">(current)</span></a></li>
                        <?php else:?>
                        <li class="active"><a href="login.php">ログイン</a></li>
                    <?php endif;?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    
    
    <div class="container">
        
        <div class="jumbotron">
            <h1>ファイル読み込み</h1>
            <p>最後はディレクトリトラバーサル。読み込むファイルがわからなければ前に戻れ</p>
            <form name="read-form" id="read-form" action="" method="post">
                
                <?php if ($message):?>
                    <div class="alert alert-danger">
                        <?php echo $message;?>
                    </div>
                <?php endif;?>
                
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>読み込むファイルを選択してください</th>
                        <td>
                            <select name="file">
                                <option value="">ファイルを選択してください</option>
                                <?php foreach ($file_list as $file):?>
                                    <option value="<?= $file; ?>"><?= $file;?>
                                <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <input type="submit" value="読み込み" class="btn btn-primary" />
                        </td>
                    </tr>
                </table>

                <pre>
                    <?= htmlspecialchars($file_data, ENT_QUOTES);?>
                </pre>
            </form>
        </div>
    </div> <!-- /container -->

</body>
</html>