
<script src="assets/js/jquery-1.12.4.js"></script>
<script>

	$(function() {
	  setInterval(function() {
	   	var d = new Date();
	    var n = d.getMinutes();
		
	     $.ajax({
                type: 'POST',
                url: "check_logs.php",
                success: function(output){
                	if(output==0 && n==57){
					
						
                      new Audio('alarm.mp3').play();
					  
                        setTimeout(function(){
                              alert("alert box");
                               }, 6000);

                		
						
                	}
                }
         });  
	 
	   
	  },30000);
});
</script>