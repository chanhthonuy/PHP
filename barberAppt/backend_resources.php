<?php
require_once '_db.php';

$scheduler_barbers = $db->query('SELECT * FROM barber ORDER BY barber_name');

class Resource {}

$result = array();

foreach($scheduler_barber as $barber) {
  $r = new Resource();
  $r->id = $barber['barber_id'];
  $r->name = $barber['barber_name'];
  $result[] = $r;
}

header('Content-Type: application/json');
echo json_encode($result);

?>
