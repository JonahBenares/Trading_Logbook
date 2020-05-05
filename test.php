<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});



</script>
<input type="file" id="file">


<div class="input_fields_wrap">
    <button class="add_field_button">Add More Fields</button>
    <div><input type="text" name="mytext[]"></div>
</div>

<?php
$shit1;
$shit=11;
$shit2=10;
$favcolor = $shit;
$favcolor2 = $shit2;

switch ($favcolor) {
    case ($shit<1):
        echo "Your favorite color is red!";
        break;
    case ($shit>=1 && $shit <= 10):
        echo "Your favorite color is blue!";
        break;
    case ($shit>10):
        echo "Your favorite color is green!";
        break;
    default:
        echo "Your favorite color is neither red, blue, nor green!";
}





$date = new DateTime('2018-04-31');

$date->modify('+1 day');
echo $date->format('Y-m-d') . "\n";






$me="2013-04-20";
$me2="2013-03-07";
$date1=date_create($me);
$date2=date_create($me2);
//$diff=date_diff($date1,$date2);
// $diff->format("%a");
//$date = new DateTime('+1 day');
//echo $date->format('Y-m-d H:i:s');
//ari ho
$dates = new DateTime($me);
$dates ->modify('+1 day');
echo $dates->format('Y-m-d');


//$x=$diff-2;
//echo $x;


echo "yeye";

$diff = $date1->diff($date2);
$days = $diff->format("%a");


//echo $days;



date_default_timezone_set("Asia/Manila");
$current =  date("Y-m-d").' '. date("H:i:s");

//echo $current;
$x='';
						while($x <= $days){ 
                                   

                  echo $me;
				   echo "<br>";
                   $me++;
						$x++;
						
						}
						
						
						
						$var1 = "This is String one";
$var2 = "This is String Two";
echo $var1.$var2;


$current_time = date("H:i");
  
$a = new DateTime('07:00');
$b = new DateTime($current_time);
$interval = $a->diff($b);

echo $interval->format("%H:%i");
echo   $interval;


						

?>


<script>

var uploadField = document.getElementById("file");

uploadField.onchange = function() {
    if(this.files[0].size > 307200){
       alert("File is too big!");
       this.value = "";
    };
};

</script>