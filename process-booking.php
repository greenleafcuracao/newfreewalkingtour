<?php
// Basic safety
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  exit("Invalid access");

$name   = trim($_POST['name'] ?? '');
$email  = trim($_POST['email'] ?? '');
$phone  = trim($_POST['phone'] ?? '');
$tour   = trim($_POST['tour'] ?? '');
$date   = trim($_POST['date'] ?? '');
$time   = trim($_POST['time'] ?? '');
$guests = trim($_POST['guests'] ?? '1');


$guideMap = [
  "Punda" => [
    "name" => "Guide Punda",
    "phone" => "5999XXXXXXX",
    "calendar" => "punda@yourdomain.com"
  ],
  "Otrobanda" => [
    "name" => "Guide Otrobanda",
    "phone" => "5999YYYYYYY",
    "calendar" => "otrobanda@yourdomain.com"
  ],
  "Scharloo/Fleur de Marie" => [
    "name" => "Guide Fleur",
    "phone" => "5999ZZZZZZZ",
    "calendar" => "fleur@yourdomain.com"
  ],
  "Pietermaai" => [
    "name" => "Guide Pietermaai",
    "phone" => "5999AAAAAAA",
    "calendar" => "pietermaai@yourdomain.com"
  ]
];

$admin = [
  "name"  => "Admin",
  "phone" => "5999ADMINNUM" // ← replace with real admin number
];


if (!isset($guideMap[$tour])) {
  exit("Invalid tour selected");
}

$guide = $guideMap[$tour];
$guideName = $guide['name'];
$guidePhone = $guide['phone'];
$guideCalendar = $guide['calendar'];

function waEncode($text) {
  return urlencode($text);
}
$clientMessage = waEncode(
"Hello $name 👋\n\n".
"Your booking request has been received:\n".
"• Tour: $tour\n".
"• Date: $date\n".
"• Time: $time\n".
"• Guests: $guests\n\n".
"We will confirm shortly.\n".
"Free Walking Tour Curaçao 🇨🇼"
);

$guideMessage = waEncode(
"🚶 New Tour Request\n\n".
"Tour: $tour\n".
"Date: $date\n".
"Time: $time\n".
"Guests: $guests\n\n".
"Client: $name"
);

$adminMessage = waEncode(
"📌 NEW BOOKING REQUEST\n\n".
"Tour: $tour\n".
"Date: $date\n".
"Time: $time\n".
"Guests: $guests\n\n".
"Client:\n".
"Name: $name\n".
"Email: $email\n".
"Phone: $phone\n\n".
"Assigned guide:\n".
"$guideName\n\n".
"Status: Pending approval"
);


$clientWaLink = "https://wa.me/$phone?text=$clientMessage";
$guideWaLink  = "https://wa.me/$guidePhone?text=$guideMessage";
$adminWaLink = "https://wa.me/".$admin['phone']."?text=$adminMessage";


echo "<h2>Booking request received</h2>";
echo "<p>Thank you, $name.</p>";

echo "<ul>";
echo "<li><a href='$clientWaLink' target='_blank'>Confirm with client (WhatsApp)</a></li>";
echo "<li><a href='$guideWaLink' target='_blank'>Notify guide (WhatsApp)</a></li>";
echo "<li><a href='$adminWaLink' target='_blank'>Notify admin (WhatsApp)</a></li>";
echo "</ul>";



}



