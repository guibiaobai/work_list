<script language="javascript">
function play_click(sef,url){
var div = document.getElementById('div1');
div.innerHTML = '<embed src="'+url+'" loop="0" autostart="true" hidden="true"></embed>';
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<?php
function initsss($xueli, $xilie)
{
    $conn = mysql_connect('localhost', 'root', '');
    if (!$conn) {
        echo 'unable';
        die('err');
    }
    if (!mysql_select_db('englishstorage')) {
        die('err2');
    }
    mysql_query('set names \'gb2312\' ');
	$mysql ="SELECT * FROM `allenglish` WHERE `t_id`='$xueli' and `xilie`=$xilie";
    $result = mysql_query($mysql);	
	$addarray=array();
    while ($row = mysql_fetch_array($result)) {
		$id=$row[0];
		$str1="<a href='showall.php?id=$id'>加生</a>";
		$str2="<a href='showall.php?id=$id'>加熟</a>";
		
        echo "\r\n<tr>\r\n<td>\r\n&nbsp&nbsp&nbsp {$row['0']} &nbsp&nbsp&nbsp\r\n</td>\r\n<td>\r\n&nbsp&nbsp&nbsp {$row['1']} &nbsp&nbsp&nbsp\r\n</td>\r\n<td>\r\n&nbsp&nbsp&nbsp {$row['2']} &nbsp&nbsp&nbsp\r\n</td>\r\n<td>\r\n&nbsp&nbsp&nbsp {$row['3']} &nbsp&nbsp&nbsp\r\n</td>\r\n<td>\r\n<div id=\"div1\"></div>\r\n<div onclick=\"play_click(this,'wma/{$row['4']}.mp3')\" style=\"cursor:hand\" >{$row['4']}<div/>\r\n\r\n\r\n</td>\r\n<td>\r\n&nbsp&nbsp&nbsp {$row['5']} &nbsp&nbsp&nbsp\r\n</td>\r\n<td>$str1</td><td>$str2</td></tr>";
		$addarray[$row[4]]=$row[5];
	}
	$ser=serialize($addarray);  //
	file_put_contents("add.txt",$ser);//tempfile
    mysql_free_result($result);
	//test代码
	$file=unserialize(file_get_contents("add.txt"));
	$c=count($file);
	echo "一共有 $c  个";
}
?>

<form action='showall.php' method='post'>
<select name='xueli'>
<option value='xx'>小学</option>
<option value='cz'>初中</option>
<option value='gz'>高中</option>
<option value='sj'>四级</option>
<option value='lj'>六级</option>
</select>
<select name='xilie'>
<?php
for($i=1;$i<24;$i++)
{
	echo "<option value='$i'>$i</option>";
}
?>
</select>
<input type='submit' value='submt'>
</form>



<a href="/phpenglish/ciyan.php">测验</a>
<a href="/phpenglish/aotuagain.php">播放</a><br>
<br>
<br>

<table border="2">
<tr>
<td>
&nbsp&nbsp&nbsp id &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp 学历 &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp 系列 &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp 个数 &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp 单词 &nbsp&nbsp&nbsp 
</td>
<td>
&nbsp&nbsp&nbsp 翻译 &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp 生词 &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp 熟词 &nbsp&nbsp&nbsp
</td>
</tr>

<?php 
	$xueli=isset($_POST['xueli'])?$_POST['xueli']:"cc";  //学历
	$xilie=isset($_POST['xilie'])?$_POST['xilie']:-1;   //系列
	
	if($xueli=="cc" && $xilie==-1){
	
	}else{
		$arr=array($xueli,$xilie);
		$bak=serialize($arr);
		file_put_contents("bak.txt",$bak);//tempfile  学历和系列
	
	}
	
	$id=isset($_GET['id'])?$_GET['id']:-1;
	if($id!=-1){
		//插入生单词
		echo "插入id为$id"."单词";
		$f=file_get_contents("bak.txt"); //tempfile
		$arr=unserialize($f);	
		$xueli=$arr[0];  //获取系列
		$xilie=$arr[1];	 //获取学历
	}
initsss($xueli,$xilie);
?>
<table>