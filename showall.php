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
		$str1="<a href='showall.php?id=$id'>����</a>";
		$str2="<a href='showall.php?id=$id'>����</a>";
		
        echo "\r\n<tr>\r\n<td>\r\n&nbsp&nbsp&nbsp {$row['0']} &nbsp&nbsp&nbsp\r\n</td>\r\n<td>\r\n&nbsp&nbsp&nbsp {$row['1']} &nbsp&nbsp&nbsp\r\n</td>\r\n<td>\r\n&nbsp&nbsp&nbsp {$row['2']} &nbsp&nbsp&nbsp\r\n</td>\r\n<td>\r\n&nbsp&nbsp&nbsp {$row['3']} &nbsp&nbsp&nbsp\r\n</td>\r\n<td>\r\n<div id=\"div1\"></div>\r\n<div onclick=\"play_click(this,'wma/{$row['4']}.mp3')\" style=\"cursor:hand\" >{$row['4']}<div/>\r\n\r\n\r\n</td>\r\n<td>\r\n&nbsp&nbsp&nbsp {$row['5']} &nbsp&nbsp&nbsp\r\n</td>\r\n<td>$str1</td><td>$str2</td></tr>";
		$addarray[$row[4]]=$row[5];
	}
	$ser=serialize($addarray);  //
	file_put_contents("add.txt",$ser);//tempfile
    mysql_free_result($result);
	//test����
	$file=unserialize(file_get_contents("add.txt"));
	$c=count($file);
	echo "һ���� $c  ��";
}
?>

<form action='showall.php' method='post'>
<select name='xueli'>
<option value='xx'>Сѧ</option>
<option value='cz'>����</option>
<option value='gz'>����</option>
<option value='sj'>�ļ�</option>
<option value='lj'>����</option>
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



<a href="/phpenglish/ciyan.php">����</a>
<a href="/phpenglish/aotuagain.php">����</a><br>
<br>
<br>

<table border="2">
<tr>
<td>
&nbsp&nbsp&nbsp id &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp ѧ�� &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp ϵ�� &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp ���� &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp ���� &nbsp&nbsp&nbsp 
</td>
<td>
&nbsp&nbsp&nbsp ���� &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp ���� &nbsp&nbsp&nbsp
</td>
<td>
&nbsp&nbsp&nbsp ��� &nbsp&nbsp&nbsp
</td>
</tr>

<?php 
	$xueli=isset($_POST['xueli'])?$_POST['xueli']:"cc";  //ѧ��
	$xilie=isset($_POST['xilie'])?$_POST['xilie']:-1;   //ϵ��
	
	if($xueli=="cc" && $xilie==-1){
	
	}else{
		$arr=array($xueli,$xilie);
		$bak=serialize($arr);
		file_put_contents("bak.txt",$bak);//tempfile  ѧ����ϵ��
	
	}
	
	$id=isset($_GET['id'])?$_GET['id']:-1;
	if($id!=-1){
		//����������
		echo "����idΪ$id"."����";
		$f=file_get_contents("bak.txt"); //tempfile
		$arr=unserialize($f);	
		$xueli=$arr[0];  //��ȡϵ��
		$xilie=$arr[1];	 //��ȡѧ��
	}
initsss($xueli,$xilie);
?>
<table>