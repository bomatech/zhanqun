<?php
/**
 * 百度链接提交脚本
 */
include './db.php';

$db = new DB();
$sql = 'SELECT * from wp_sites WHERE bsl_on -- limit 1';
$sites = $db->db_getAll($sql);
if (! $sites) {
    die("没有站点开启链接提交\n");
}
foreach ($sites as $site) {
    // 表前缀
    $tblPrefix = $site['prefix'];
    // token
    $sql = "SELECT * FROM `{$tblPrefix}options` WHERE option_name = 'bsl_option'";
    $option = $db->db_getRow($sql);
// $option = array('option_value' => 'a:1:{s:5:"token";s:16:"EbTKkYD98midq32C";}');
    if (! $option) {
        echo "{$site['domain']}站点未配置token\n";
        continue;
    }
    $tokenRow = unserialize($option['option_value']);
    $token = $tokenRow['token'];
    // 待提交链接
    $sql = "select id, guid from {$tblPrefix}posts where id not in(select post_id from {$tblPrefix}bsl_push)";
    $posts = $db->db_getAll($sql);
    if (! $posts) {
        continue;
    }
    $urls = array();
    foreach ($posts as $post) {
        $urls[] = $post['guid'];
    }
    // 向百度提交链接
    $apis = 'http://data.zz.baidu.com/urls';
    $site = $site['domain'];
    if(!$site || !$token){ 
        continue;
    }
    $api = $apis . '?site=' . $site . '&token=' . $token;
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $urls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    $result = json_decode($resp, true);
    if (! empty($result["error"])) {
        echo "提交链接失败{$resp}\n";
        continue;
    }
    // 更新结果到bsl_push表
    $sql = "insert into {$tblPrefix}bsl_push(post_id, state, status) values";
    $values = array();
    foreach ($posts as $key => $post) {
        $values[] = "({$post['id']}, 1, 0)";
        if (($key + 1) % 200 == 0) {
            $sqlt = $sql . implode(',', $values);
            $db->db_query($sqlt);
            $values = array();
        }
    }
    if ($values) {
        $sqlt = $sql . implode(',', $values);
        $db->db_query($sqlt);
    }
    echo "执行完毕。\n";
}