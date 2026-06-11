
    <?php
      include_once "./config/dbconnect.php";
   
     
      ?>


  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-secondary " style="height:40px" data-toggle="modal" data-target="#myModal">
    Add Product
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Product Item</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form  enctype='multipart/form-data' action="add_course.php" method="POST">


          <div class="form-group">
            <label for="title">Course Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="about">Course About:</label>
            <textarea id="about" name="about" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="regular_price">Regular Price:</label>
            <input type="number" id="regular_price" name="regular_price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="discount_price">Discount Price:</label>
            <input type="number" id="discount_price" name="discount_price" step="0.01">
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category" required>
            <?php

$sql="SELECT * from category";
$result = $conn-> query($sql);

if ($result-> num_rows > 0){
  while($row = $result-> fetch_assoc()){
    echo"<option value='".$row['category_id']."'>".$row['category_name'] ."</option>";
  }
}
?>
                <!-- Add more categories as needed -->
            </select>
        </div>
        <div class="form-group">
            <label for="requirements">Course Requirements:</label>
            <textarea id="requirements" name="requirements" rows="3" ></textarea>
        </div>
        <div class="form-group">
            <label for="what_will_learn">What Will Be Learned:</label>
            <textarea id="what_will_learn" name="what_will_learn" rows="3" ></textarea>
        </div>
        <div class="form-group">
            <label for="duration">Course description</label>
            <textarea type="text" id="description" name="description" required  rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="duration">Course overall lesson </label>
            <input type="text" id="duration" name="course_overall_lesson" required>
        </div>
        <div class="form-group">
            <label for="duration">language</label>
            <input type="text" id="duration" name="language" required>
        </div>
        <div class="form-group">
            <label for="duration">rating</label>
            <input type="text" id="rating" name="rating" required>
        </div>
      
      
        <br><br>
        <div class="form-group">
            <label for="course_image">Course Image:</label>
            <input type="file" id="course_image" name="course_image" accept="image/*" required>
        </div>

        <button type="submit">Submit Course</button>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  
</div>
   