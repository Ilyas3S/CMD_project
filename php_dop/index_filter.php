<?
include "host.php";

$agent =  (($_COOKIE['check'] == 2) ? '' : (($_COOKIE['check'] == 1) ? ' users.agent = 1 ' : 'users.agent = 0'));
$town = ((!$_COOKIE['town']) ? '' : (' a.town = \'' . $_COOKIE['town'] . '\' '));
$rooms = (($_COOKIE['rooms'] == 0) ? '' : ('a.rooms = \'' . $_COOKIE['rooms'] . '\' '));
$price_min = (($_COOKIE['price_min'] == -1) ? '' : ('a.price >= ' . $_COOKIE['price_min'] . ' '));
$price_max = (($_COOKIE['price_max'] == -1) ? '' : ('a.price <= ' . $_COOKIE['price_max'] . ' '));

$sort = ($_COOKIE['sort_radio'] == 1 ? "a.price " : ($_COOKIE['sort_radio'] == 2 ? "a.rooms " : "time ")) . ($_COOKIE['sort'] == 1 ? '' : 'DESC');

if ($agent != '') {
	if ($town != '') {
		$town = ' and ' . $town; 
		if ($rooms != '') {
			$rooms = ' and ' . $rooms;
			if ($price_min != '') {
				$price_min = ' and ' . $price_min; 
				if($price_max != '') {
					$price_max = ' and ' . $price_max;
				}
			} else {
				if ($price_max != ''){
					$price_max = ' and ' . $price_max;
				}
			}
		} else {
			if ($price_min != '') {
				if($price_max != '') {
					$price_min = ' and ' . $price_min; 
					$price_max = ' and ' . $price_max;
				} else {
					$price_min = ' and ' . $price_min; 
				}
			} else {
				if ($price_max != ''){
					$price_max = ' and ' . $price_max;
				}
			}
		}
	} else {
		if ($rooms != '') {
			if ($price_min != '') {
				if($price_max != '') {
					$rooms = ' and ' . $rooms;
					$price_min = ' and ' . $price_min; 
					$price_max = ' and ' . $price_max;
				} else {
					$rooms = ' and ' . $rooms;
					$price_min = ' and ' . $price_min; 
				}
			} else {
				if ($price_max != ''){
					$rooms = ' and ' . $rooms;
					$price_max = ' and ' . $price_max;
				} else {
					$rooms = ' and ' . $rooms;
				}
			}
		} else {
			if ($price_min != '') {
				if($price_max != '') {
					$price_min = ' and ' . $price_min; 
					$price_max = ' and ' . $price_max;
				} else {
					$price_min = ' and ' . $price_min; 
				}
			} else {
				if ($price_max != ''){
					$price_max = ' and ' . $price_max;
				}
			}
		}
	}
} else {
	if ($town != '') {
		if ($rooms != '') {
			$rooms = ' and ' . $rooms;
			if ($price_min != '') {
				$price_min = ' and ' . $price_min; 
				if($price_max != '') {
					$price_max = ' and ' . $price_max;
				}
			} else {
				if ($price_max != ''){ 
					$price_max = ' and ' . $price_max;
				}
			}
		} else {
			if ($price_min != '') {
				$price_min = ' and ' . $price_min;
				if($price_max != '') {
					$price_max = ' and ' . $price_max;
				}
			} else {
				if ($price_max != ''){
					$price_max = ' and ' . $price_max;
				}
			}
		}
	} else {
		if ($rooms != '') {
			if ($price_min != '') {
				$price_min = ' and ' . $price_min; 
				if($price_max != '') {
					$price_max = ' and ' . $price_max;
				}
			} else {
				if ($price_max != ''){
					$price_max = ' and ' . $price_max;
				}
			}
		} else {
			if ($price_min != '') {
				if($price_max != '') {
					$price_max = ' and ' . $price_max;
				}
			}
		}
	}
}

$where = ($agent . $town . $rooms . $price_min . $price_max == '' ? '' 
	: " WHERE " . $agent . $town . $rooms . $price_min . $price_max);
	
$order = "ORDER BY " . $sort;

$query = "SELECT users.login, users.agent, a.id, a.price, a.description, a.image, a.rooms, a.town, 
								STR_TO_DATE(a.`date`, '%d.%m.%Y') AS time
								FROM adverts AS a
								INNER JOIN users
								ON users.id = a.id_users
								" . $where . ' ' . $order;
								
//echo $query . "123";

$result = mysqli_query($link, $query);

for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

echo_much_ad($data);

mysqli_close($link);
?>