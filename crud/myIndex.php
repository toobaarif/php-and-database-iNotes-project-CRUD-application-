<?php
  // connection to database
include_once "connect.php";

// Die if connection was not successful
if (!$connect){
  die("Sorry we failed to connect: ". mysqli_connect_error());
}

$insert = false;
$update = false;
$delete = false;



// for deletion of data
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes_table` WHERE `sno` = $sno";
  $result = mysqli_query($connect, $sql);
}

// <!-- php add notes into data and access or read the data through the form -->
// insert data after submission into database
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
// update the record
$sno = $_POST['snoEdit'];
$title = $_POST['titleEdit'];
$description =  $_POST['descriptionEdit'];

// sql quary for updation or editing
$sql = "UPDATE `notes_table` SET `title` = '$title' , `description` = '$description' WHERE `notes_table`.`sno` = $sno";
$result = mysqli_query($connect, $sql);
if($result){
  $update = true;
}
else{
  echo "We could not update the result successfully";
}
  }


  else{
    $title = $_POST['title'];
    $description =  $_POST['description'];

$sql = "INSERT INTO `notes_table` (`title`, `description`, `date`) VALUES ('$title', '$description', current_timestamp())";
$result = mysqli_query($connect, $sql);

if($result){
  $insert = true;
}
else{
  echo  "The record was not inserted successfully because of this error ---> ". mysqli_error($connect);
}
  }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- include css for data table   Bootstrap CSS --> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

  <title>iNotes</title>
  </head>


  <body>
<!-- edit modal -->
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Model
</button> -->

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <form action="/crud/index.php" method="POST">
      <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
        <div class="form-group">
          <label for="title" class="form-label">NoteTitle</label>
          <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
        </div>

        <div class="form-group">
        <label for="description">Note Description</label>
            <textarea class="form-control" id="descriptionEdit"  name="descriptionEdit" style="height: 130px"></textarea>
          </div>
          </div>

          <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </form>
    </div>
  </div>
</div>


    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">iNotes</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>



      <?php
      // insert alert
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <!-- update alert -->
      <?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <!-- delete alert -->
      <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>



      <!-- form -->
      <div class="container my-4">
        <h2>Add a Note</h2>
      <form action="/crud/index.php" method="POST">
        <div class="form-group ">
          <label for="title" class="form-label">NoteTitle</label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        </div>

        <label for="description">Note Description</label>
        <div class="form-floating">
            <textarea class="form-control" name="description" id="description" style="height: 130px"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Add Note</button>
              </form>
        </div>


        
        <!-- php -->
<!-- //Tbale-> access and read the database -->
<div class="container">
<table class="table" id="myTable">
<thead>
  <tr>
    <th scope='col'>S.No</th>
    <th scope='col'>Title</th>
    <th scope='col'>Description</th>
    <th scope='col'>Action</th>
  </tr>
</thead>

<tbody>
<?php
// access and read the database
$sql = "SELECT * FROM `notes_table`";
$result = mysqli_query($connect, $sql);
$i = 0;
$sno = 0;
while($row = $result->fetch_assoc()){
  $sno = $sno + 1;
?>
  <tr>
    <th scope='row'><?php echo $sno; ?></th>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['description']; ?></td>
<!-- // for actions delete update  -->
<td><button class="edit btn btn-sm btn-primary" id="<?php $row['sno'] ?>">Edit</button>
<button class="delete btn btn-sm btn-primary" id="d<?php $row['sno'] ?>">Delete</button>
</td>
  </tr>
  <?php
  $i++;
}
?>
</tbody>

</table>
</div>
<hr>




   <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>

<!-- java script for edit -->
<script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
        
})
})

// <!-- java script for delete -->

deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })


</script>
  </body>
</html>
