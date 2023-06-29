<?php
include("to-do.class.php");
include("controller.php");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>ToDo</title>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
            integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
            crossorigin="anonymous" />
        <link rel="stylesheet" href="vendor/css/bootstrap4-bubblegum.min.css" />

        <link href="https://fonts.googleapis.com/css?family=Chicle|Open+Sans" rel="stylesheet" />
    </head>

    <body>
        <div class=" px-5 mt-5 md-5">
            <h1 class="mb-5">My ToDo List</h1>

            <div class="row d-flex flex-md-wrap-reverse">
                <div class="col-md-4 pb-5 pt-3 shadow mb-5 border border-primary bg-light rounded ">
                    <form action="" method="post" id="addTask">
                        <div class="input-group mb-3">
                            <h2 class="flex-fill">Add task</h2>
                            <div class="d-lg-none d-xs-block">
                                <a href="#todo-list" class="btn btn-outline-primary" type="button">
                                    <strong>+</strong>
                                    Go to list
                                </a>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="taskTitle">Task title</label>
                            <input type="text" class="form-control text-nowrap" id="taskTitle"
                                placeholder="Enter task name" aria-describedby="emailHelp" autocomplete="off"
                                name="taskTitle"
                                value="<?= isset($_GET['action']) && $_GET['action'] == 'edit' ? $_GET['todo'] : ''; ?>"
                                required />
                            <small id="emailHelp" class="form-text text-muted">*Task name required</small>
                        </div>

                        <div class="form-group mb-4">
                            <label for="taskDesc">Task Description</label>
                            <textarea class="form-control text-nowrap" name="taskDesc" id="taskDesc" rows="3"
                                placeholder="Enter task description"></textarea>
                        </div>

                        <div class="form-group mb-5">
                            <label class="text-nowrap" for="file">Add file </label>
                            <input type="file" class="form-control  text-nowrap" name="file" aria-describedby="fileHelp"
                                id="file" />
                            <small id="fileHelp" class="form-text text-muted">*Add file ( 5Mb file limit )</small>

                        </div>

                        <input type="submit" class="btn btn-primary form-control mb-3"
                            name="<?= isset($_GET['action']) && $_GET['action'] == 'edit' ? 'updateLast' : 'addNew'; ?>"
                            value="<?php echo isset($_GET['action']) && $_GET['action'] == 'edit' ? 'Save Task' : 'Add Task'; ?>"
                            disabled />
                        <a class="btn border-primary form-control" href="index.php">
                            <?php echo isset($_GET['action']) && $_GET['action'] == 'edit' ? 'Cancel' : 'Clear'; ?>
                        </a>
                    </form>
                </div>

                <div class="col-md-8" id="todo-list">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Task</th>
                                <th scope="col">Attachment</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $todo->show_todo("all");

                            ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
            </script>


        <script>
            $(document).ready(function () {
                $('#taskTitle').on('keyup', function () {

                    if ($(this).val().length == 0)
                        $('form[id=addTask] > input[type=submit]').attr('disabled', 'disabled');
                    else
                        $('form[id=addTask] > input[type=submit]').attr('disabled', false);
                });
            });
        </script>
    </body>

</html>