<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define('DB_NAME', 'wp');

/** MySQL数据库用户名 */
define('DB_USER', 'root');

/** MySQL数据库密码 */
define('DB_PASSWORD', 'root');

/** MySQL主机 */
define('DB_HOST', 'localhost');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'iV/Bi=_z]J$(4Tl/TU=ycS=~9il8Rt[9HW!eCQmf8Fi:{-e($A$jMoS;r.x8TxIx');
define('SECURE_AUTH_KEY',  'S7&8rK:%!^O;q$K[z2Z6WW8%b3tW4%Jn:6}?,VXWm0^3F l|nxvPNvw$F+>>)!%T');
define('LOGGED_IN_KEY',    'WTtB28r8TJ7%k:a!;)j7Rdhk`cD6pH:nrf|M.BzIxXQVP LDhWi?$Z7j1 voku&%');
define('NONCE_KEY',        'kPtC[}ca(g1ava3mE]k%pDU(w7LYA(LW#e/4_GIVBfcblhD.2_n]?L=rNa8P-y%J');
define('AUTH_SALT',        'svFhd&@P/;TuT 5_TKv58+u.Ge,$JWC.O>!Rq3!ULOsN9!lq[s34<nZkgq<F[mYv');
define('SECURE_AUTH_SALT', 'o:s=)I/x{I[E+2(2@b/V*|[=e7Oh$2U#j;PkZnw7fWB?%6KS(<v@CNs,8I0L,#Z^');
define('LOGGED_IN_SALT',   'RX9~jx{^od{5JS)LEYZ4tSNP2%n=uN4bzk!Cu v`NPNm|d4O7ylo(jU2JQKBR.Eh');
define('NONCE_SALT',       '&k71X0[7WmDyd|[=qs7y(JJwPGoE.J,z)EvTInVW,+JS!Ss9>c52nptGJeQiE5}7');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */

//不同域名使用不同后缀
//include 'wp-domain.php';
//$table_prefix = str_replace('.','',getBaseDomain($_SERVER['HTTP_HOST'])).'_';
// if(strpos($_SERVER['HTTP_HOST'], 'dick')){
// 	$table_prefix  = 'wpdickcom_';
// }else{
// 	$table_prefix  = 'wphulkcom_';
// }

$mysqlli = mysqli_connect(DB_HOST. ':' .'3306' , DB_USER , DB_PASSWORD);
$host = substr_count($_SERVER['HTTP_HOST'],'.') === 1 ? 'www.'.$_SERVER['HTTP_HOST'] : $_SERVER['HTTP_HOST'];
$res = $mysqlli->query("SELECT prefix FROM wp.wp_sites WHERE domain='{$host}'");
$domain_data = mysqli_fetch_assoc($res);
if(!$domain_data){
	exit('未找到对应的数据库配置');
}
$table_prefix = $domain_data['prefix'];



/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
// define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置WordPress变量和包含文件。 */
define("FS_METHOD", "direct");  
define("FS_CHMOD_DIR", 0777);  
define("FS_CHMOD_FILE", 0777);  

require_once(ABSPATH . 'wp-settings.php');
