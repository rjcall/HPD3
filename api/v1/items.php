<?php 
/**
 * User: rjcal
 * Date: 10/12/2018
 * Time: 11:29 AM
 */

function createItem($name, $photo, $description, $valuation, $method, $verified, $ownerId) {

  header("Status: 201 CREATED");
  global $mysqli;
  $sqlcreate = "INSERT into Items(name, photo, description, valuation, method, verified, creationDate) Values('$name', '$photo',  '$description', $valuation, '$method', $verified, DATE_FORMAT(NOW(), '%Y-%m-%d'));";

  $result = $mysqli->query($sqlcreate);
  echo "est-ce que c'est bon?";
  if (!$result) {
    return false;
  } 
  else {
    $id = "SELECT item_id  from items order by item_id desc
    limit 1"; 
    $idresult = $mysqli->query($id);
    if(!$idresult){
      return false;
    } 
    else {
      $row = $idresult->fetch_row();
      $lastInsertedItemId = $row[0];
    }
  }

  $sqlcreate2 = "INSERT INTO owner_items(owner_id, item_id) 
  values('$ownerId', $lastInsertedItemId)";

  $result2 = $mysqli->query($sqlcreate2);
  if(!$result2){
    return false;
  } 
  else 
  {
    $createAffected = $mysqli->affected_rows;
  }

}

function readItem($id) { 

  global $mysqli;

  $sql1 = "SELECT * FROM items WHERE item_id = $id";
      $result = $mysqli->query($sql1);
      if (!$result)
      die("query didn't work bud");
      $results = array();
      while ($row = $result->fetch_row()) {
        array_push($results, $row); 
    }
    return json_encode($results);
}

function updateItem($ownerId, $itemId, $name, $photo, $description, $valuation, $method, $verified) {

  global $mysqli;

  $sqlcreate = "UPDATE Items
  SET 
  name='$name', 
  description='$description', 
  valuation='$valuation', 
  method='$method', 
  verified='$verified'
  WHERE item_id='$itemId'";

  $result = $mysqli->query($sqlcreate);
  $createAffected = $mysqli->affected_rows;
  if (!$result)
    die("update item query didn't work bud");
  
}

function deleteItem($id) {
  header("HTTP/1.1 204 No Content");
  global $mysqli;
  $sql1 = "DELETE FROM items WHERE item_id = $id";
	  $result = $mysqli->query($sql1);
		if (!$result)
    die("item delete query didn't work bud");
}

function listItems($ownerId) {
  global $mysqli;
  $sql1  = "SELECT items.item_id,  items.name, items.photo,
                    items.description, 
                    items.valuation, 
                    items.method, 
                    items.verified
          FROM owner_items
            INNER JOIN owners
                ON owner_items.owner_id = owners.owner_id
            INNER JOIN items 
                ON owner_items.item_id = items.item_id
          WHERE owners.owner_id = $ownerId
          Order By owners.owner_id;";
      $result = $mysqli->query($sql1);
      if (!$result)
      die("query didn't work bud");
      $results = array();
      while ($row = $result->fetch_row()) {
        array_push($results, $row);
        
    }
    
    return json_encode($results);

}
