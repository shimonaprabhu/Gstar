<!--Create the footer that appears on each page-->
		<div class="footer">
 			Copyright © 2017, Accord Software & Systems,Inc.
		</div>
<!--Functions to submit form on clicking a link and auto submit on form loading-->
		<script>

			function sub() {
			  document.getElementById("catform").submit();
			}
			function submit(id){
				document.getElementById(id).submit(); 
				return false;
			}
			function refresh(nm) {
			    $.ajax({
			        type: 'POST',
			        url: 'server.php',
			        data: { text1: nm },
			        error: function () {
			        	errordisp("Unsuccessful operation!");
			      }
			    });
			}
			/*if ( window.history.replaceState ) {
			  window.history.replaceState( null, null, window.location.href );
			}*/
			
</script>
	</body>
</html>