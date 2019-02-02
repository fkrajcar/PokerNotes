<button class="btn btn-primary input_button" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Add session</i></button>
<div id="id01" class="modal">           
  <form class="modal-content animate" action="session_input.php" method="POST">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="container">
        <form action="session_input.php" method="post" name="session_input">
          <div class="form-group">
            <label for="buyin">Buy-in</label>
            <input type="number" step="0.01" min="0.5" class="form-control" name="buyin" id="buyin" required>
          </div>
          <div class="form-group">
            <label for="buyout">Buy-out</label>
            <input type="number" step="0.01" class="form-control" name="buyout" id="buyout" required>
          </div>
          <div class="form-group">
            <label for="stakes">Stakes</label>
            <select class="form-control" id="stakes" name="stakes" required>
              <option value="0.50">0.25/0.50</option>
              <option value="1">0.50/1</option>
              <option value="5">2/5</option>
              <option value="10">5/10</option>
              <option value="100">50/100</option>
            </select>
          </div>
          <div class="row">
          <div class="form-group col-md-6">
            <label for="hours">Hours</label>
            <input type="number" class="form-control" name="hours" id="hours" min="0" max="24" required>
          </div>
          <div class="form-group col-md-6">
            <label for="minutes">Minutes</label>
            <input type="number" class="form-control" name="minutes" id="minutes" min="0" max="59" required>
          </div>
        </div>


          <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>