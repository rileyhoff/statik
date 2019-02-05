<?php
$title = 'Home';

include 'top.php';
include 'openallcsv.php';

//open csv file and put into array-----------------------------------------
$debug = false;

if (isset($_GET["debug"])) {
    $debug = true;
}

$myFileName = "data/slider";

$fileExt = ".csv";

$filename = $myFileName . $fileExt;

if ($debug)
    print "\n\n<p>filename is " . $filename;

$file = fopen($filename, "r");

/* the variable $file will be empty or false if the file does not open */
if ($file) {
    if ($debug)
        print "<p>File Opened</p>\n";

    if ($debug)
        print "<p>Begin reading data into an array.</p>\n";

    /* This reads the first row, which in our case is the column headers */
    $headers = fgetcsv($file);

    if ($debug) {
        print "<p>Finished reading headers.</p>\n";
        print "<p>My header array<p><pre> ";
        print_r($headers);
        print "</pre></p>";
    }
    /* the while (similar to a for loop) loop keeps executing until we reach 
     * the end of the file at which point it stops. the resulting variable 
     * $records is an array with all our data.
     */
    while (!feof($file)) {
        $records[] = fgetcsv($file);
    }

    //closes the file
    fclose($file);

    if ($debug) {
        print "<p>Finished reading data. File closed.</p>\n";
        print "<p>My data array<p><pre> ";
        print_r($records);
        print "</pre></p>";
    }
} // ends if file was opened
?>

<article id="index">
    <figure id="title">
        <img src="images/misc/statik_header_100px.png" alt="statik logo" id="title"/>
        <figcaption id="title">Action-sports and Lifestyle.</figcaption>
    </figure>
    <!-- jQuery slider -->
    <div class="flexslider">
        <ul class="slides">
            <?php
            /* display the data */
            foreach ($records as $oneRecord) {
                if ($oneRecord[0] != "") {  //the eof would be a "" 
                    print "\n\t<li class='slider_input'>";
                    //print out values
                    print '<img src="images/slider/' . $oneRecord[1] . '" alt"">';
                  /*  print '<h1 class="info">' . $oneRecord[2] . '</h1>'; */
                    print "\n\t</li>";
                }
            }
            ?>
        </ul>
    </div> <!-- flexslider -->
    <h1>What is Statik?</h1>
    <p>Statik is an action sports and lifestyle website that showcases events 
        around the globe while highlighting event in its hometown, Burlington, VT.
        We cover news from Surfing, Skateboarding, Snowboarding, Art and Local Concerts.
        Click on the tabs above or below to find out the latest news in any of these 
        categories, and don't forget to sign up for our newsletter for updates!</p>
    <ol class ='home'>
        <li><a href="local_events.php">Local Events</a></li>
        <li><a href="concerts.php">Concerts</a></li>
        <li><a href="skate.php">Skate</a></li>
        <li><a href="snow.php">Snow</a></li>
        <li><a href="surf.php">Surf</a></li>
        <li><a href="form.php">Join</a></li>
    </ol>
    <a href="form.php" id="mail"><img src="images/misc/mail.png" alt="" id="mail"/><h3 id="mail">Join our Mailing list!</h3></a>
<!--
    <div> <!-- print out photos/data from csv (concerts.csv) 
        <?php
        /* display the data 
        print "<ol>";
        foreach ($records as $oneRecord) {
            if ($oneRecord[0] != "") {  //the eof would be a "" 
                print "\n\t<li class='home'>";
                //print out values
                if ($oneRecord[2] != "") {
                    print '<img src="images/concerts/' . $oneRecord[2] . '" alt"">';
                }
                print '<span class="title">' . $oneRecord[1] . '</span>';
                print '<span class="date">' . $oneRecord[5] . '</span>';
                print '<span class="time">' . $oneRecord[6] . '</span>';
                print '<span class="location">' . $oneRecord[7] . '</span>';
                print '<span class="description">' . $oneRecord[4] . '</span>';
                print '<span class="additional_image">' . $oneRecord[8] . '</span>';
                print "\n\t</li>";
            }
        }

        print "</ol>";

        if ($debug)
            print "<p>End of processing.</p>\n";
         * 
         */
        ?>
    </div> -->
</article>
<?php
include 'footer.php';
?>  
</body>