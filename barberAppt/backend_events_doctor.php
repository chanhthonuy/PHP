<?php
require_once '_db.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$stmt = $db->prepare('SELECT * FROM appointments WHERE NOT ((appointment_end <= :start) OR (appointment_start >= :end)) AND barber_id = :doctor');
$stmt->bindParam(':start', $params->start);
$stmt->bindParam(':end', $params->end);
$stmt->bindParam(':barber', $params->barber);
$stmt->execute();
$result = $stmt->fetchAll();

class Event {}
class Tags {}
$events = array();

foreach($result as $row) {
  $e = new Event();
  $e->id = $row['appointment_id'];
  $e->text = $row['appointment_client_name'];
  $e->start = $row['appointment_start'];
  $e->end = $row['appointment_end'];
  $e->resource = $row['barber_id'];
  $e->tags = new Tags();
  $e->tags->status = $row['appointment_status'];
  $events[] = $e;
}

header('Content-Type: application/json');
echo json_encode($events);

?>
