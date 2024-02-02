<?php
include 'db-config.php';
use dbase\DataBaseRevenue;

function filling()
{
	$mysqli = new mysqli('localhost', DataBaseRevenue::$db_login, DataBaseRevenue::$db_pass, DataBaseRevenue::$db_name);
	$i = 1;
	while($i < 14){
		$day = $mysqli->real_escape_string(date('Y-m-d', strtotime('+'.$i.' day')));
		$cash = $mysqli->real_escape_string(rand(100000, 500000));
		$cashless = $mysqli->real_escape_string(rand(100000, 500000));
		$credit = $mysqli->real_escape_string(rand(100000, 500000));
		$a_check = $mysqli->real_escape_string(rand(1000, 10000));
		$a_guest = $mysqli->real_escape_string(rand(1000, 10000));
		$post_removal = $mysqli->real_escape_string(rand(100, 10000));
		$removal_to = $mysqli->real_escape_string(rand(100, 10000));
		$c_checks = $mysqli->real_escape_string(rand(20, 150));
		$query = sprintf("INSERT INTO revenue (cash, cashless, credit_cart, average_check, average_guest, post_removal, removal_to, count_checks, count_guests, day) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $cash, $cashless, $credit, $a_check, $a_guest, $post_removal, $removal_to, $c_checks, $c_checks, $day);
		$result = $mysqli->query($query);
		$i++;
        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
	}
	return false;
}

function getData()
{
	$mysqli = new mysqli('localhost', DataBaseRevenue::$db_login, DataBaseRevenue::$db_pass, DataBaseRevenue::$db_name);
	$revenue = array();
	$day = $mysqli->real_escape_string(date('Y-m-d'));
	$yesterday = $mysqli->real_escape_string(date('Y-m-d', strtotime('-1 day')));
	$this_weekday = $mysqli->real_escape_string(date('Y-m-d', strtotime('-7 day')));
	$query = sprintf("SELECT * FROM revenue WHERE day LIKE '%s' OR day LIKE '%s' OR day LIKE '%s'", $day, $yesterday, $this_weekday);
	$result = $mysqli->query($query);
	if(mysqli_num_rows($result) == 0){
		$revenue['type'] = 'error';
		$revenue['error'] = 'Нет подходящих элементов';
	}else{
		$revenue['type'] = 'success';
	}
	while($row = $result->fetch_assoc()) {
		if($row['day'] == $day){
			$name_day = 'today';
		}elseif($row['day'] == $yesterday){
			$name_day = 'yesterday';
		}else{
			$name_day = 'this_weekday';
		}
		$revenue['text'][$name_day] = $row;
	}
	echo json_encode($revenue);
	return false;
}

getData();

?>