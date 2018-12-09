<?php
/**
 * User: rjcal
 * Date: 10/12/2018
 * Time: 11:00 AM
 */
require_once "owners.php";
require_once "items.php";

$host = "localhost";
$usr = "jace";
$pwd = "Ghost797";
$db = "hpd";


global $host, $usr, $pwd, $db, $mysqli;
$mysqli = new mysqli($host, $usr, $pwd, $db);




if ($_SERVER["REQUEST_METHOD"] === "POST") {
$argh = explode("/",  $_SERVER['PATH_INFO']);

 




$count = count($argh);
global $sortColumn;
if($count == 2){
  echo "You sent a POST";
  if (isset($_REQUEST['fname'])) {
      $fname = $_REQUEST['fname'];
    } else {
      $fname = "";
    }
    if (isset($_REQUEST['lname'])) {
      $lname = $_REQUEST['lname'];
    } else {
      $lname = "";
    }
    if (isset($_REQUEST['street1'])) {
      $street1 = $_REQUEST['street1'];
    } else {
      $street1 = "";
    }
    if (isset($_REQUEST['street2'])) {
      $street2 = $_REQUEST['street2'];
    } else {
      $street2 = "";
    }
    if (isset($_REQUEST['city'])) {
      $city = $_REQUEST['city'];
    } else {
      $city = "";
    }
    if (isset($_REQUEST['state'])) {
      $state = $_REQUEST['state'];
    } else {
      $state = "";
    }
    if (isset($_REQUEST['zip'])) {
      $zip = $_REQUEST['zip'];
    } else {
      $zip = "";
    }
    if (isset($_REQUEST['policy'])) {
      $policy = $_REQUEST['policy'];
    } else {
      $policy = "";
    }
    if (isset($_REQUEST['expiration'])) {
      $expiration = $_REQUEST['expiration'];
    } else {
      $expiration = "";
    }
  echo createOwner($fname, $lname, $street1, $street2, $city, $state, $zip, $policy, $expiration);
  

}
  else if ($count == 3){

    if (isset($_REQUEST['name'])) {
      $name = $_REQUEST['name'];
    } else {
      $name = "";
    }
    if (isset($_REQUEST['photo'])) {
      $photo = $_REQUEST['photo'];
    } else {
      $photo = "";
    }
    if (isset($_REQUEST['description'])) {
      $description = $_REQUEST['description'];
    } else {
      $description = "";
    }
    if (isset($_REQUEST['valuation'])) {
      $valuation = $_REQUEST['valuation'];
    } else {
      $valuation = "";
    }
    if (isset($_REQUEST['method'])) {
      $method = $_REQUEST['method'];
    } else {
      $method = "";
    }
    if (isset($_REQUEST['verified'])) {
      $verified = $_REQUEST['verified'];
    } else {
      $verified = "";
    }
  }
  echo createItem($name, $photo, $description, $valuation, $method, $verified, $argh[2]);
}
elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (isset($_GET['filter'])) {
        if (isset($_GET['fnamefilter'])) {
            $fnamefilter = $_GET['fnamefilter'];
          } else {
            $fnamefilter = "";
          }
          if (isset($_GET['lnamefilter'])) {
            $lnamefilter = $_GET['lnamefilter'];
          } else {
            $lnamefilter = "";
          }
          if (isset($_GET['street1filter'])) {
            $street1filter = $_GET['street1filter'];
          } else {
            $street1filter = "";
          }
          if (isset($_GET['street2filter'])) {
            $street2filter = $_GET['street2filter'];
          } else {
            $street2filter = "";
          }
          if (isset($_GET['cityfilter'])) {
            $cityfilter = $_GET['cityfilter'];
          } else {
            $cityfilter = "";
          }
          if (isset($_GET['statefilter'])) {
            $statefilter = $_GET['statefilter'];
          } else {
            $statefilter = "";
          }
          if (isset($_GET['zipfilter'])) {
            $zipfilter = $_GET['zipfilter'];
          } else {
            $zipfilter = "";
          }
          if (isset($_GET['policyfilter'])) {
            $policyfilter = $_GET['policyfilter'];
          } else {
            $policyfilter = "";
          }
          if (isset($_GET['expirationfilter'])) {
            $expirationfilter = $_GET['expirationfilter'];
          } else {
            $expirationfilter = "";
          }
                $filters = array();
      if(!empty($fnamefilter))
      {
        array_push($filters, $fnamefilter);
        array_push($filters, "fname");
      } 
      if(!empty($lnamefilter))
      {
        array_push($filters, $lnamefilter);
        array_push($filters, "lname");
      }
      if(!empty($street1filter))
      {
        array_push($filters, $street1filter);
        array_push($filters, "street1");
      } 
      if(!empty($street2filter))
      {
        array_push($filters, $street2filter);
        array_push($filters, "street2");
      } 
      if(!empty($cityfilter))
      {
        array_push($filters, $cityfilter);
        array_push($filters, "city");
      } 
      if(!empty($statefilter))
      {
        array_push($filters, $statefilter);
        array_push($filters, "state");
      } 
      if(!empty($zipfilter))
      {
        array_push($filters, $zipfilter);
        array_push($filters, "zip");
      } 
      if(!empty($policyfilter))
      {
        array_push($filters, $policyfilter);
        array_push($filters, "policy");
      } 
      if(!empty($expirationfilter))
      {
        array_push($filters, $expirationfilter);
        array_push($filters, "expiration");
      }
      if(count($filters) == 0)
      {
        $filter = "";
      }
      if(count($filters) >= 2)
      {
        $filter = "WHERE $filters[1] LIKE \"%$filters[0]%\"";
        for($i = 2; $i < count($filters); $i+=2)
        { 
          $j = $i + 1;
          $filter .= "AND $filters[$j] LIKE \"%$filters[$i]%\"";
        }
      }
      } 
      else {
        $filter = "";
      }

    if (isset($_GET{'offs'})) {
        $offset = $_GET{'offs'};
      } else {
        $offset = 0;
      }
      if (isset($_GET['sortColumn'])) {
        $sortColumn = $_GET['sortColumn'];
      } else {
        $sortColumn = 'lname';
      }   

        $argh = explode("/",  $_SERVER['PATH_INFO']);

 





$count = count($argh);
global $sortColumn;
if($count == 2){
        echo listOwners($sortColumn, $filter, $offset);
}
else if($count == 3){
          if (strpos($argh[2], 'pg') !== false){
            $offset = substr($argh[2], 2);  
            echo listOwners($sortColumn, $offset);
          }
          else{
            $sortColumn = $argh[2];
            echo readOwner($argh[2]);
          }
   
        }
else if($count == 4){
         
            echo listItems($argh[2]);
        }
else if ($count == 5){
          echo readItem($argh[4]);
        }
    }


elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
  $argh = explode("/",  $_SERVER['PATH_INFO']);
  $count = count($argh);
 



  if($count == 3){
    echo "you wish to update owner";
    parse_str(file_get_contents("php://input"),$post_vars);
    echo updateOwner($post_vars["ownerId"], 
    $post_vars["fname"], 
    $post_vars["lname"], 
    $post_vars["street1"], 
    $post_vars["street2"], 
    $post_vars["city"], 
    $post_vars["state"], 
    $post_vars["zip"], 
    $post_vars["policy"], 
    $post_vars["expiration"]);
  }

  if($count == 5){
    echo "you wish to update item";
    parse_str(file_get_contents("php://input"),$post_vars);
    echo updateItem($post_vars["ownerId"], 
    $post_vars["itemId"],
    $post_vars["name"], 
    $post_vars["photo"], 
    $post_vars["description"], 
    $post_vars["valuation"], 
    $post_vars["method"], 
    $post_vars["verified"]);
  }

}
elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {

$argh = explode("/",  $_SERVER['PATH_INFO']);
$count = count($argh);

if($count == 5){
  echo deleteItem($argh[4]);
}
if($count == 3){
  echo deleteOwner($argh[2]);
}
echo $argh[2]."2 ";


    

global $sortColumn, $filter, $offset;
echo listOwners($sortColumn, $filter, $offset);
}
else {
    echo "You sent an unknown ".$_SERVER["REQUEST_METHOD"];
}

?>