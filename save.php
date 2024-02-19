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
        @media only screen and (max-width: 550px) {
            #uvcustomstyleid {
                font-size: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: row;
            }
        }
        @media only screen and (max-width: 410px) {
            #uvcustomstyleid {
                font-size: 9px;
            }
        }
        @media only screen and (max-width: 320px) {
            #uvcustomstyleid {
                min-height: unset !important;
                font-size: 8px;
                padding: 8px 4px !important;
            }
        }
    </style>
    <?php
    $countdown_formatted = formatCountdown($countdown);
    $html = "<br><div class='woocommerce-message' style='clear:both; background: #FFDBDB;' id='uvcustomstyleid'>Order in <span style='margin: 0 5px;' id='countdown' data-countdown='$countdown'> {$countdown_formatted}</span>to get delivery on {$del_day}</div>";
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
    <?php
}
// Function to format the countdown timer
function formatCountdown($countdown)
{
    $hours = floor($countdown / 3600);
    $minutes = floor(($countdown % 3600) / 60);
    $seconds = $countdown % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}