<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<?php 


$next1 = isset($_POST['next1']) ? 1 : 0;
$pre2 = isset($_POST['pre2']) ? 1 : 0;
$han3 = isset($_POST['han3']) ? 1 : 0;
$work1 = isset($_POST['work1']) ? 1 : 0;
$moshi5 = isset($_POST['value']) ? 1 : 0;


//����ѡ���
function chiose($testarray, $key)
{
    echo '<br><br>';
    echo '<form action=\'/work_list/ciyan.php\' method=\'post\'>';
    foreach ($testarray as $k => $v) {
        echo "<input type='submit' name='value' value='{$v}'>";
    }
	//һ�����Ͳ�����ģʽ5
    echo '</form>';
}


//ģʽ5
function optmoshi5($filename,$v)
{
    $array = unserialize(file_get_contents($filename));
    $keyset = array_keys($array);
    //��ȡ��ǰ�ĵ��ʣ���ǰ�ķ��� +3������
    $url = unserialize(file_get_contents('url.txt'));
    if ($url >= count($array)) {
        $url = 0;
    }
    $temp = $url + 1;
    file_put_contents('url.txt', serialize($temp));
    $key = $keyset[$url];
    $value = $array[$key];
	$tempurl=$url-1;
	$tempkey=$keyset[$tempurl];
	$tempvalue=$array[$tempkey];

	if($tempvalue==$v||$v=="cc"||$v==$tempkey)
	{
		echo "<br>"."($tempvalue)==($v)"."<br>";
	}
	else
	{
		echo "<script>alert('no')</script>";
		echo "<br><br>"."($tempvalue)!=($v)"."<br>";
	}
    opt_allecho45($key, $value, $url, $array);
}


function opt_allecho45($key, $value, $num, $array)
{
    $temparray = $array;
    shuffle($temparray);//
    $varray = array();
    echo "<br><br>".$num . '---->' . $key . '<br><br><br>';
    $varray[3] = $value;
    for ($i = 0; $i < 3; $i++) {
        if ($temparray[$i] != $value) {
            $j = $i;
            $j += 1;
            $varray[$i] = $temparray[$i];
        } else {
            $i -= 1;
        }
    }
    shuffle($varray);
    chiose($varray, $key);
    echo "<embed src=\"wma/{$key}.mp3\" loop=\"0\" autostart=\"true\" hidden=\"true\"></embed>";
    echo '<br><br><br><br>';
    echo '<br><br><br><br>';
}

//next ����
function opt_next1($filename)
{
    $array = unserialize(file_get_contents($filename));
    $keyset = array_keys($array);
    $url = unserialize(file_get_contents('url.txt'));
    if ($url >= count($array)) {
        $url = 0;
    }
    $temp = $url + 1;
    file_put_contents('url.txt', serialize($temp));
    $key = $keyset[$url];
    $value = $array[$key];
    opt_allecho1($key, $value, $url);
}

function opt_allecho1($key, $value, $num)
{
    echo $num . '->' . $key . '<br><br><br>' . $value;
    echo "<embed src=\"wma/{$key}.mp3\" loop=\"0\" autostart=\"true\" hidden=\"true\"></embed>";
    echo '<br><br><br><br>';
}

//���html
function echohtml()
{
	echo '<form action=\'/work_list/ciyan.php\' method=\'post\'>
	<input type=\'submit\' name=\'next1\' value=\'next\'>
	<input type=\'submit\' name=\'pre2\' value=\'pre\'>
	<input type=\'submit\' name=\'han3\' value=\'han-->word\' >
	<input type=\'submit\' name=\'work1\' value=\'work-->han\' >
	</form>';
}


function iswork($str)
{
	preg_match ( '/[a-zA-z]/',  $str ,  $matches);
	return count( $matches );
}


//����ģʽ3
function opt_han3($filename)
{
    $array = unserialize(file_get_contents($filename));
    $keyset = array_keys($array);
    $url = unserialize(file_get_contents('url.txt'));
    if ($url >= count($array)) {
        $url = 0;
    }
    $temp = $url + 1;
    file_put_contents('url.txt', serialize($temp));
    $key = $keyset[$url];
    $value = $array[$key];
    opt_allecho3($key, $value, $url,$array);
}

//����ģʽ3�����
function opt_allecho3($key, $value, $num,$array)
{
	$temparray = $array;
	$temparray=array_flip($temparray);
    shuffle($temparray);
    $varray = array();
    echo $num . '->' . $value . '<br><r><br>';
    $varray[3] = $key;
    for ($i = 0; $i < 3; $i++) {
        if ($temparray[$i] != $value) {
            $j = $i;
            $j += 1;
            $varray[$i] = $temparray[$i];
        } else {
            $i -= 1;
        }
    }
    //��ȡvalueֵ3���������Ǵ���
    shuffle($varray);
    chiose($varray, $key);
    echo "<embed src=\"wma/{$key}.mp3\" loop=\"0\" autostart=\"true\" hidden=\"true\"></embed>";
    echo '<br><br><br><br>';
    echo '<br><br><br><br>';
}


if ($next1) {
    opt_next1('add.txt');
    echohtml();
} elseif ($pre2) {
    echo 'û��ʵ��';
    echohtml();
} elseif ($han3) {
    
	opt_han3('add.txt');//���ݷ���->д������
    echo 'han3';
    echohtml();
	
} elseif ($work1) {

	$value=isset($_POST['value'])?$_POST['value']:"cc";   //ʲôʱ���ύ��
    optmoshi5('add.txt',$value);
    //echo 'work_1';
    echohtml();
	
} else {
    if ($moshi5) {
	
	//vlue ���� ģʽ5
	//�Ͻе�����
		$value=isset($_POST['value'])?$_POST['value']:"cc";
		
		//echo "-----?".$value;
		//echo iswork($value);
		
		if(iswork($value)==0&& $value!="cc")
		{
		 optmoshi5('add.txt',$value);
			echohtml();
		}
		if(iswork($value)!=0 && $value!="cc")
		{
			opt_han3('add.txt');
			echohtml();
		}
    } else {
	
        echo 'in defaute';
		echohtml();
    }
}
?>