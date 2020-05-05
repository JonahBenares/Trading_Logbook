<?php 
	function getInfo($con, $column, $table, $id, $value_id){
		$get = $con->query("SELECT $column FROM $table WHERE $id = '$value_id'");
		$fetch = $get->fetch_array();
		return $fetch[$column];
	}
    
    function get_times( $default = '24:00', $interval = '+30 minutes' ) {
        $output = '';
        $current = strtotime( '00:00' );
        $end = strtotime( '23:59' );
        while( $current <= $end ) {
            $time = date( 'H:i', $current );
            $sel = ( $time == $default ) ? ' selected' : '';

            $output .= "<option value=\"{$time}\"{$sel}>" . date( 'H:i ', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        }
        return $output;
    }

	 function get_times2($current_time, $end_t, $interval = '+1 minutes' ) {
        $output = '';
        $currents = strtotime($current_time);
        $end2 = strtotime($end_t);
		
		$minus  = '-30 minutes';
		$plus = '+30minutes';
		$current =  strtotime( $minus, $currents );
		$end = strtotime( $plus, $currents );
        while( $current <= $end ) {
            $time = date( 'H:i', $current );
            $sel = ( $time == $current_time ) ? ' selected' : '';

            $output .= "<option value=\"{$time}\"{$sel}>" . date( 'H:i', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        
        }
        return $output;
    }
	
	function get_times3($st , $interval = '+1 minutes' ) {
       $output = '';
        $current = strtotime( $st );

		$plus = '+59minutes';
        $end = strtotime( $plus, $current );
        while( $current <= $end ) {
            $time = date( 'H:i', $current );
            $sel = ( $time == $default ) ? ' selected' : '';

            $output .= "<option value=\"{$time}\"{$sel}>" . date( 'H:i ', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        
        }
        return $output;
    }
	
	function get_times4($start_time, $interval = '+1 minutes' ) {
       $output = '';
        $current = strtotime( $start_time );
       
		$plus = '+59minutes';
        $end = strtotime( $plus, $current );
        while( $current <= $end ) {
            $time = date( 'H:i', $current );
            $sel = ( $time == $default ) ? ' selected' : '';

            $output .= "<option value=\"{$time}\"{$sel}>" . date( 'H:i ', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        
        }
        return $output;
    }
	
	
	
     function get_mins($current_time, $end_t, $interval = '+1 minutes' ) {
        $output = '';
        $currents = strtotime($current_time);
        $end2 = strtotime($end_t);
		
		$minus  = '-30 minutes';
		$plus = '+30minutes';
		$current =  strtotime( $minus, $currents );
		$end = strtotime( $plus, $currents );
        while( $current <= $end ) {
            $time = date( ':i', $current );
            $sel = ( $time == $current_time ) ? ' selected' : '';

            $output .= "<option value=\"{$time}\"{$sel}>" . date( ':i', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        }
        return $output;
    }
	
	function  missed_logs($con,$userid){
        $today = date("Y-m-d");
        $get_sched = $con->query("SELECT sched_id FROM schedule_logs WHERE sched_date = '$today' AND user_id = '$userid'");
        $row_sched = $get_sched->num_rows;
       // echo "SELECT sched_id FROM schedule_logs WHERE sched_date = '$today' AND user_id = '$userid'";

        if($row_sched>0){
            $get_last_logged = $con->query("SELECT MAX(logged_time) AS maxtime FROM activity_log WHERE user_id = '$userid' AND logged_date = '$today'");

            $fetch_logged = $get_last_logged->fetch_array();
            $last_time = explode(':',$fetch_logged['maxtime']);
            $last_time = $last_time[0];

            $hour_now = date('H');

            $get_sched_hours = $con->query("SELECT end_hr FROM schedule_logs WHERE sched_date = '$today' AND user_id = '$userid'");

            $fetch_sched = $get_sched_hours->fetch_array();
           
           
            if($fetch_sched['end_hr']>=$hour_now){
                $diff = $hour_now - $last_time;
            } else {
                $diff =$fetch_sched['end_hr']-$last_time;
            }

          
        } else {
            $diff=0;
        }

        return $diff;
    }
	

    function logs_today($con){
         $today = date("Y-m-d");
         $get_logs = $con->query("SELECT log_id FROM activity_log WHERE logged_date = '$today'");
         $logs_row = $get_logs->num_rows;
         return $logs_row;
    }

    function get_log_count($con,$userid){
        $today = date("Y-m-d");
        $get_logs = $con->query("SELECT log_id FROM activity_log WHERE logged_date = '$today' AND user_id = '$userid'");
        $row_logs = $get_logs->num_rows;
        return $row_logs;
    }
?>
 