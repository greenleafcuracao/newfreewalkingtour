<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $tour  = $_POST["tour"]  ?? "";
    $name  = $_POST["name"]  ?? "";
    $email = $_POST["email"] ?? "";
    $date  = $_POST["date"]  ?? "";

    if(!$tour || !$name || !$email || !$date){
        http_response_code(400);
        echo "Missing data";
        exit;
    }

    $to = "freewalkingtourcuracaocalendar@gmail.com";
    $subject = "New Walking Tour Booking";

    $message = "
New booking request:

Name: $name
Email: $email
Tour: $tour
Date: $date
";

    $headers = "From: booking@freewalktour.local";

    mail($to, $subject, $message, $headers);

    echo "Booking request sent!";
}
