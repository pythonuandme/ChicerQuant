<?php
/**
 * Created by PhpStorm.
 * User: G
 * Date: 16/5/4
 * Time: 上午12:58
 */
header("Content-Type: text/html;charset=utf8");

include('db_login.php');

function getDBConnection()

{
    global $db_host;
    global $db_username;
    global $db_password;
    global $db_database;
    $connection = new PDO("mysql:host=$db_host;dbname=$db_database; charset=utf8", $db_username, $db_password);
    // 设置 PDO 错误模式为异常
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $connection;

}


function getMyDBConnection()
{
    global $mydb_host;
    global $mydb_username;
    global $mydb_password;
    global $mydb_database;
    $connection = new PDO("mysql:host=$mydb_host;dbname=$mydb_database; charset=utf8", $mydb_username, $mydb_password);
    // 设置 PDO 错误模式为异常
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $connection;
}

function getMyFavor($username)
{
    $connection = getMyDBConnection();
    $stmt = $connection->prepare("select * from favorstocks where username = :username");
    $stmt->bindParam(':username', $_username);
    $_username = $username;
    return execQuery($connection,$stmt);
}

function cancelMyFavor($name, $username)
{
    $connection = getMyDBConnection();
    $stmt = $connection->prepare("delete from favorstocks where username = :username and stock_name = :stockname");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':stockname', $name);
    return execQuery($connection,$stmt);
}

function addMyFavor($name, $username)
{
    $connection = getMyDBConnection();
    $stmt = $connection->prepare("insert into favorstocks values(:username, :stockname)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':stockname', $name);
    return execQuery($connection,$stmt);
}

function getStockByName($name, $date)
{
    $connection = getDBConnection();
    if ($date == date("Y-m-d")){
        $stmt = $connection->prepare("select * from today where stock_id = :stock_name");
        $stmt->bindParam(':stock_name', $_stock_name);
        $_stock_name = $name;
    }else{

        $stmt = $connection->prepare("select * from ".$name." where date  = :datetime");
        $stmt->bindParam(':datetime',$_date);
        $_stock_name = $name;
        $_date = $date;
    }

    return execQuery($connection,$stmt);
}

function checkTableNameValid($tablename)
{
    $valid = 0;
    $connection = getDBConnection();
    $stmt = $connection->prepare("show tables");
    $result = execQuery($connection,$stmt);

    $result = str_replace("\t",'',$result);
    $result = str_replace("'", '"', $result);
    $result =  iconv("ASCII", "utf8", $result);
    $result = json_decode($result, true);
    print_r($result[22]);
    $values = array_values($result);
    print_r($values);
    echo $valid;
    return $valid;
}

echo getStockByName("sh600000",date('Y-m-d',strtotime('2016-05-10')));
//checkTableNameValid("sh600000");
function getStockAmongDate($name, $startdate, $enddate)
{
//    $datearr = getAmongDates($startdate, $enddate);
//    $string = "";
//    for ($i = 0; $i < sizeof($datearr); $i++){
//        $query = "select * from ".$name."where date = ".$datearr[$i];
//        $string .= execQuery($query);
//    }
//    return $string;
//


    $connection = getDBConnection();
    $stmt = $connection->prepare("select * from :stockname where :phpdate between :startdate and :enddate");
    $stmt->bindParam(':phpdate',$_pdate);
    $stmt->bindParam(':stockname', $_stockname);
    $stmt->bindParam(':startdate', $_startdate);
    $stmt->bindParam(':enddate', $_enddate);
    $_pdate = 'date';
    $_stockname = $name;
    $_startdate = $startdate;
    $_enddate = $enddate;
    return execQuery($connection,$stmt);
}



function getAllStocks()
{
//    $query = "select * from today";
//    return execQuery($query);
    $connection = getDBConnection();
    $stmt = $connection->prepare("select * from today");
    return execQuery($connection,$stmt);
}

//echo  getAllStocks();

function getBenchMarkByName($name, $date)
{
    $query = "select * from ".$name."where date = ".$date;
    return execQuery($query);
}

function getBenchMarkAmongDate($name, $startdate, $enddate)
{
    return getStockAmongDate($name,$startdate,$enddate);
}

function get5PMA_day($name, $date)
{
    return getCalcuValue("PMA5_day",$name,$date);
}

function get5PMA_week($name, $date)
{
    return getCalcuValue("PMA5_week",$name,$date);
}

function get5PMA_month($name, $date)
{
    return getCalcuValue("PMA5_month",$name,$date);
}

function get10PMA_day($name, $date)
{
    return getCalcuValue("PMA10_day",$name,$date);
}

function get10PMA_week($name, $date)
{
    return getCalcuValue("PMA10_week",$name,$date);
}

function get10PMA_month($name, $date)
{
    return getCalcuValue("PMA10_month",$name,$date);
}

function get30PMA_day($name, $date)
{
    return getCalcuValue("PMA30_day",$name,$date);
}

function get30PMA_week($name, $date)
{
    return getCalcuValue("PMA30_week",$name,$date);
}

function get30PMA_month($name, $date)
{
    return getCalcuValue("PMA30_month",$name,$date);
}

function get6RSI($name, $date)
{
    return getCalcuValue("RSI6",$name,$date);
}

function get12RSI($name, $date)
{
    return getCalcuValue("RSI12",$name,$date);
}

function get24RSI($name, $date)
{
    return getCalcuValue("RSI24",$name,$date);
}

function get6BIAS($name, $date)
{
    return getCalcuValue("BIAS6",$name,$date);
}


function get12BIAS($name, $date)
{
    return getCalcuValue("BIAS12",$name,$date);
}

function get24BIAS($name, $date)
{
    return getCalcuValue("BIAS24",$name,$date);
}

function getK($name, $date)
{
    return getCalcuValue("K",$name,$date);
}

function getD($name, $date)
{
    return getCalcuValue("D",$name,$date);
}

function getJ($name, $date)
{
    return getCalcuValue("J",$name,$date);
}

function getDIF($name, $date)
{
    return getCalcuValue("DIF",$name,$date);
}

function getDEA($name, $date)
{
    return getCalcuValue("DEA",$name,$date);
}

function getMACDBar($name, $date)
{
    return getCalcuValue("MACDBar",$name,$date);
}

function getpoly($name, $date)
{
    return getCalcuValue("poly",$name,$date);
}


function getAllIndustries()
{
    //TODO
//    $query = "select industry from industry_stock";
//    $json_string = execQuery($query);
//    return $arr = json_decode($json_string,true);

    $connection = getDBConnection();
    $stmt = $connection->prepare("select * from industry_stock");
    return execQuery($connection,$stmt);
}

//$arr = getAllIndustries();
//echo "--- ".$arr['industry'];
//echo $arr;

function getStocksByIndustry($industry_name)
{
//    $query = "select stock_id, stock_name from industry_stock where industry = ".$industry_name;
//    return execQuery($query);
    $connection = getDBConnection();
    $stmt = $connection->prepare("select stock_id, stock_name from industry_stock where industry = :industry_name");
    $stmt->bindParam(':industry_name', $_industry_name);
    $_industry_name = $industry_name;
    return execQuery($connection,$stmt);
}

//echo getStocksByIndustry("银行");

function getIndustry($industry_name,$date)
{
    //TODO
}
function getCalcuValue($type, $name, $date)
{
    $query = "select ".$type." from ".$name."where date = ".$date;
    return execQuery($query);
}

function getAmongDates($startdate, $enddate)
{
    $arr = array();
    while ($startdate<=$enddate){
        $arr[] = date('Y-m-d',$startdate);
        $startdate = strtotime('+1 day',$startdate);
    }
    return $arr;
}


function execQuery($connection, $stmt)
{
    echo json_encode($stmt);
    if(!$stmt) {
        $arr = array('retmsg'=>$connection->errorInfo());
        $json_string = json_encode($arr);
        return $json_string;
    }
    $result = $stmt -> execute();
    if ($result === false){
        $arr = array('retmsg'=>$connection->errorInfo());
        $json_string = json_encode($arr);
        return $json_string;
    }
    $arr = array('retmsg'=>'success');
    $json_string = json_encode($arr);
    while ($result_row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        $json_string .= json_encode($result_row,JSON_UNESCAPED_UNICODE);
    }
    $connection = null;
    $stmt = null;
    return $json_string;
}

function getNameByAge($age){
    $connection = getDBConnection();
    $query = "select name, age from snois where age = ".$age;
    $result = mysqli_query($connection,$query);
    if ($result === false){
        echo "query error <br/>".$connection->error;
    }
    $names = array();
    while ($result_row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        array_push($names, $result_row);
    }
    return $names;
}



?>