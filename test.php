
<?php
add_action('woocommerce_after_add_to_cart_button', 'delivery_estimate');
function delivery_estimate()
{
    date_default_timezone_set('Europe/London');
    // Calculate time until 3 PM
    $now = time();
    $cutoff = strtotime(date("Y-m-d 15:00:00", $now));
    $countdown = $cutoff - $now;

    // If current time is after 3 PM, move to next day's cutoff
    if ($countdown < 0) {
        $cutoff = strtotime(date("Y-m-d 15:00:00", strtotime("+1 day")));
        $countdown = $cutoff - $now;
    }
    // if SAT/SUN delivery will be MON
    if (date('N') >= 6) {
        $section = "1";
        $del_day = date("l jS F", strtotime("next Monday"));
        $order_by = "Monday";

        //         if(date('H') >= 15){
//             $del_day = date("l jS F", strtotime("next monday"));
//             $order_by = "Monday";
//         }else{
//             // Set $del_day to next week's Wednesday
//             $del_day = date("l jS F", strtotime("next Wednesday"));
//             $order_by = "Monday";
//         }

    }
    // If Friday
    elseif (date('N') == 5) {
        $section = "2";

        if (date('H') >= 15) {
            $del_day = date("l jS F", strtotime("next Tuesday"));
            $order_by = "Monday";
        } else {
            $del_day = date("l jS F", strtotime("next Monday"));
            $order_by = "Monday";
        }
    }
    // if MON/THU after 3PM delivery will be day after tomorrow
    elseif (date('H') >= 15) {
        $section = "3";


        $del_day = date("l jS F", strtotime("tomorrow + 2 days"));
        $order_by = "day after tomorrow";
    }
    // if MON/THU before 3PM delivery will be TOMORROW
    else {
        $del_day = date("l jS F", strtotime("tomorrow + 1 days"));

        $order_by = "today";
    }
    // Format countdown timer
    ?>
    <style>
   div#uvcustomstyleid
   {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    gap: 12px;
    background: transparent;
    margin-top: 15px;
   }
   div#uvcustomstyleid span 
   {
    font-size: 18px;
   }
   @media only screen and (max-width: 450px)  {
    div#uvcustomstyleid span 
   {
    font-size: 15px;
   }
   div#uvcustomstyleid
   {
    gap: 5px;
   }
   }
   @media only screen and (max-width: 350px)  {
    div#uvcustomstyleid span 
   {
    font-size: 13px;
   }
   }
    </style>
    <?php
    $countdown_formatted = formatCountdown($countdown);
    $html = "<br>
    <div id='uvcustomstyleid'>
    <div>
    <span><b style='color: #434247;'>Expected Delivery: </b> <b style='color: #36A6A8;'> {$del_day} </b></span>
    </div>
    <div>
    <span style='color: #7c7a7a;'>Order it within: </span> <b> <span id='countdown' style='color: #EF6250;' data-countdown='$countdown'> {$countdown_formatted} </span> </b>
    </div>
    </div>";
    echo $html;
    ?>
    <script>
        jQuery(document).ready(function ($) {
            function updateCountdown() {
                var countdownElement = $('#countdown');
                var countdownTime = parseInt(countdownElement.attr('data-countdown'));
                if (countdownTime > 0) {
                    countdownTime--;
                    var hours = Math.floor(countdownTime / 3600);
                    var minutes = Math.floor((countdownTime % 3600) / 60);
                    var seconds = countdownTime % 60;
                    var formattedTime = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);
                    countdownElement.text(formattedTime);
                    countdownElement.attr('data-countdown', countdownTime);
                }
            }
            setInterval(updateCountdown, 1000);
        });
    </script>
    <script>
    jQuery(document).ready(function ($) {
        function updateCountdown() {
            var countdownElement = $('#countdown');
            var countdownTime = parseInt(countdownElement.attr('data-countdown'));
            if (countdownTime > 0) {
                countdownTime--;
                var hours = Math.floor(countdownTime / 3600);
                var minutes = Math.floor((countdownTime % 3600) / 60);
                var seconds = countdownTime % 60;
                var formattedTime = hours + ' ' + 'Hours' + ' ' + minutes + ' ' + 'Minutes and' + ' ' + seconds + ' ' + 'Seconds';
                countdownElement.text(formattedTime);
                countdownElement.attr('data-countdown', countdownTime);
            }
        }
        setInterval(updateCountdown, 1000);
    });
</script>

    <?php
}
// Function to format the countdown timer
function formatCountdown($countdown)
{
    $hours = floor($countdown / 3600);
    $minutes = floor(($countdown % 3600) / 60);
    $seconds = $countdown % 60;

    return sprintf('%dHours %dMinutes %dseconds', $hours, $minutes, $seconds);
}
