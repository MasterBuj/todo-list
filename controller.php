<?php

if (isset($_GET['action'])) {
  $id = $_GET['id'];
  switch ($_GET['action']) {
    case 'delete':
      $todo->delete_todo($id);
      break;
    case 'Not Done':
      $todo->return_todo($id);
      break;
    case 'Done':
      $todo->done_todo($id);
      break;
  }
}


if (isset($_POST['addNew']))
  $todo->add_todo($_POST['task']);


if (isset($_POST['updateTask'])) {
  $task = $_POST['taskTitle'];
  $id = $_POST['task_id'];

  $todo->update_todo($id, $task);
}