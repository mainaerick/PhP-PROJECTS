<?php
// considering wekeends are not allowed
function isThisDayAWeekend($date)
{

    $timestamp = strtotime($date);

    $weekday = date("l", $timestamp);

    if ($weekday == "Saturday" or $weekday == "Sunday") {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET['auto_timeslots'])) {

    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    $out = array();
    $booked = array();

    $starting_date = DateTime::createFromFormat('Y-m-d', $fromdate);  //create date time objects from where to start
    $end_end = DateTime::createFromFormat('Y-m-d', $todate);  //create date time objects from where to stop

    $dates = array();
    $starting_date->modify("-1 day");      //reverse one day
    $newstartdatestring = $starting_date->format('Y-m-d');//format the date to string
    $newstartdate = DateTime::createFromFormat('Y-m-d', $newstartdatestring);  //create date time objects

    $booked=array('12:00-13:00', '14:00-15:00'); 
    for ($i = $newstartdate; $i < $end_end;)  //for loop 
    {
        $date1 = $i->format('Y-m-d');   //take hour and minute
        $i->modify("+1 day");      //add one day
        $date2 = $i->format('Y-m-d');     //frmat the day
        $slot_date = $date2;
        // SKIP IF DAY IS WEEKEND
        if (!isThisDayAWeekend($date2)) {
            array_push($dates, $slot_date); // add days into the array excluding weekends
           
        //    start working with time in per day
            $start_time = $slot_date . ' 07:00:00';  //start time as string
            $end_time = $slot_date . ' 20:00:00';  //end time as string

            $start = DateTime::createFromFormat('Y-m-d H:i:s', $start_time);  //create date time objects
            $end = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);  //create date time objects
            $count = 0;  //number of slots

            for ($i = $start; $i < $end;)  //for loop 
            {
                $avoid = false;   //booked slot?
                $time1 = $i->format('H:i');   //take hour and minute
                $i->modify("+120 minutes");      //add 20 minutes
                $time2 = $i->format('H:i');     //take hour and minute
                $slot = $time1 . "-" . $time2;      //create a format 12:40-13:00 etc

                for ($k = 0; $k < sizeof($booked); $k++)  //if booked hour
                {
                    if ($booked[$k] == $slot)  //check
                        $avoid = true;   //yes. booked
                }
                if (!$avoid && $i < $end)  //if not booked and less than end time
                {
                    $count++;           //add count
                    // $slots = ['start' => $time1, 'stop' => $time2];         //add count
                    $slots = $time1 . "-" . $time2 . ";" . $slot_date;
                    array_push($out, $slots); //add slot to array
                }
            }
        }
    }
    echo json_encode($out);

    // echo json_encode($dates);

}
?>