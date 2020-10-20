<?php 

    include 'dbconnector.php';

    $date = $_POST["date"];
    $heading = $_POST["heading"];
    $tml_month = $_POST["tml_month"];
    $tml_day = $_POST["tml_day"];
    $day = $_POST["day"];
    $thidhi = $_POST["thidhi"];
    $star = $_POST["star"];
    $event = $_POST["event"];
    $url = $_POST["url"];
    $title = $_POST["title"];
    $url1 = $_POST["url1"];
    $title1 = $_POST["title1"];
    $url2 = $_POST["url2"];
    $title2 = $_POST["title2"];

    $d_url = "";
    $d_url1 = "";
    $d_url2 = "";

    $date_query = "SELECT * FROM dhinachariyai WHERE date='$date'";
    $date_result = mysqli_query($connection,$date_query);

    while ($row = mysqli_fetch_array($date_result)) {
        $d_url = $row["url"];
        $d_url1 = $row["url1"];
        $d_url2 = $row["url2"];
    }

    if ($url == "no") {
        $url = $d_url;
    }

    if ($url1 == "no") {
        $url1 = $d_url1;
    }

    if ($url2 == "no") {
        $url2 = $d_url2;
    }

    $update_query = "UPDATE dhinachariyai SET date='$date',heading='$heading',tml_month='$tml_month',tml_day='$tml_day',day='$day',thidhi='$thidhi',star='$star',event='$event',url='$url',url1='$url1',url2='$url2',title1='$title',title2='$title1',title3='$title2' WHERE date='$date'";
    $update_result = mysqli_query($connection,$update_query);

    if ($update_result) {
        echo "Successfull";
    } else {
        echo $update_result;
    }

?>