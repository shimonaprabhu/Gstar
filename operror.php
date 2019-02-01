<!--Display the model with the appropriate error message passed to the function from where that error occured-->
<script> 
        function errordisp(res){
          $('#errortext').text(res);
          $("#myModal").modal('show');
        }
</script>

<!--A modal class which display the error message passed using jQuery-->
<div id="myModal" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Error encountered!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="errortext"></p>
      </div>
      <br>
    </div>
  </div>
</div>
