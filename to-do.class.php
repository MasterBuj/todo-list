<?php
class Todo
{
  private $db;

  const DATABASE = 'php_todo';
  const USERNAME = 'root';
  const PASSWORD = '';

  public $root;

  /**
   * Class constructor
   * 
   * @author mohammad
   * @param string $con
   */
  function __construct()
  {
    $this->db = mysqli_connect("localhost", self::USERNAME, self::PASSWORD, self::DATABASE);

    if (!$this->db) {
      echo '<h1>Please follow intro.php file instructions ...</h1>';
      exit;
    }

    $this->root = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  }

  /**
   * Add new todo
   * 
   * @author mohammad
   * @param string $task
   */
  public function install()
  {
    $query = "CREATE TABLE IF NOT EXISTS `todo` (`id` int(11) NOT NULL AUTO_INCREMENT, `todo` varchar(200) NOT NULL, `date` varchar(200) NOT NULL, `done` int(11) NOT NULL, PRIMARY KEY (`id`))";
    $run = mysqli_query($this->db, $query);
    if ($run)
      echo 'Done<p><a href="' . $this->root_url() . '">Go to home</a></p>';
  }

  /**
   * Add new todo
   * 
   * @author mohammad
   * @param string $task
   */
  public function add_todo($task)
  {
    $date = time();
    $query = "INSERT INTO todo (todo, date, done) VALUES ('$task', '$date', '0')";

    $this->run_query($query);
  }

  /**
   * Delete todo
   * 
   * @author mohammad
   * @param int $id
   */
  public function delete_todo($id)
  {
    $query = "DELETE FROM todo WHERE todo.id='$id'";
    $this->run_query($query);
  }

  /**
   * Return todo to undone
   * 
   * @author mohammad
   * @param int $id
   */
  public function return_todo($id)
  {
    $now = time();

    $data = ['isDone' => 0, 'date' => $now];
    $where = ['id' => $id];

    $this->update_sql_query($data, $where, $table = 'todo');
  }

  /**
   * Done todo
   * 
   * @author mohammad
   * @param int $id
   */
  public function done_todo($id)
  {
    $now = time();

    $data = ['isDone' => 1, 'date' => $now];
    $where = ['id' => $id];

    $this->update_sql_query($data, $where, $table = 'todo');
  }

  /**
   * Update todo
   * 
   * @author mohammad
   * @param int $id
   * @param string $task
   */
  public function update_todo($id, $task)
  {
    $task = $_POST['task'];

    $data = ['todo' => $task];
    $where = ['id' => $id];

    $this->update_sql_query($data, $where, $table = 'todo');
  }

  /**
   * Sql query and run for todo update
   * 
   * @author mohammad
   * @param array $data
   * @param array $where
   * @param string $table
   */
  public function update_sql_query($data, $where, $table = 'todo')
  {
    $cols = [];
    foreach ($data as $key => $val) {
      $cols[] = $table . ".$key = '$val'";
    }

    $wheres = [];
    foreach ($where as $key => $val) {
      $wheres[] = $table . ".$key = '$val'";
    }

    $query = "UPDATE $table SET " . implode(', ', $cols) . " WHERE " . implode(', ', $wheres);

    $this->run_query($query);
  }

  /**
   * Run sql query and header to home
   * 
   * @author mohammad
   * @param string $query
   */
  private function run_query($query)
  {
    mysqli_query($this->db, $query);
    header('Location: ' . $this->root_url());
    exit;
  }

  /**
   * Select todo
   * 
   * @author mohammad
   * @param string $done
   */
  private function getAllTodoBy($done = 0)
  {
    $query = "SELECT * FROM todo WHERE todo.isDone='$done' ORDER BY `date` ASC";

    $run_select = mysqli_query($this->db, $query);

    if (!$run_select) {
      echo '<h1>Please follow intro.php file instructions ...</h1>';
      exit;
    }

    return $run_select;
  }


  /**
   * Select todo
   * 
   */
  private function getAllTodo()
  {
    $query = "SELECT * FROM todo ORDER BY `date` ASC";

    $run_select = mysqli_query($this->db, $query);

    if (!$run_select) {
      echo '<h1>Error on our side ...</h1>';
      exit;
    }

    return $run_select;
  }


  /**
   * Show todo
   * 
   * @author mohammad
   * @param string $done
   */
  public function show_todo($show = "all")
  {

    switch ($show) {
      case 'all':
        $todos = $this->getAllTodo();
        break;

      case 'complete':
        $todos = $this->getAllTodoBy(0);
        break;

      case 'notdone':
        $todos = $this->getAllTodoBy(1);
        break;

      default:
        $todos = $this->getAllTodo();
        break;
    }



    $num = 1;
    while ($row = mysqli_fetch_array($todos)):
      $name = ($row["isDone"] == 0) ? 'Done' : 'Not Done';
      $isDone = ($row["isDone"] == 0) ? 'bg-success' : 'bg-warning';
      echo ' <tr>';
      echo '<td class="col-1">' . $num . '</td>';
      echo ' <td> <a href="#" class="font-weight-bold">' . $row["todo"] . '</a> </td>';
      echo '<td class="col-1">
                  <span class="border border-success text-primary rounded-sm px-2 my-1 my-sm-0">PNG</span>
                </td>';
      echo '<td class="col-2"> 
                  <a href="?id=' . $row["id"] . '&action=' . $name . '" class="text-decoration-none text-nowrap"><span class="my-1 my-sm-0 px-2 py-1 text-white rounded ' . $isDone . ' text-uppercase "> ' . $name . ' </span></a>
                </td>';
      echo '<td class="col-2">' . date('m/d/Y', $row["date"]) . '</td>';
      echo '<td class="col-1">';
      echo ' <a href="?id=' . $row["id"] . '&action=edit&todo=' . $row["todo"] . '"  class="text-decoration-none">
                    <span class="fas fa-edit fa-lg mr-1 text-primary"></span>
                  </a>';
      echo ' <a href="?id=' . $row["id"] . '&action=delete" class="text-decoration-none">
                    <span class="fas fa-trash fa-lg mr-1 text-danger"></span>
                  </a>';
      echo '</td></tr>';
      $num++;
    endwhile;
  }

  /**
   * Root url
   * 
   * @author mohammad
   * @param string $query
   */
  private function root_url()
  {
    $protocol = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
    $url = $_SERVER['REQUEST_URI'];
    $parts = explode('/', $url);
    $dir = $_SERVER['SERVER_NAME'];
    for ($i = 0; $i < count($parts) - 1; $i++) {
      $dir .= $parts[$i] . "/";
    }
    return $protocol . $dir;
  }

}
$todo = new Todo();