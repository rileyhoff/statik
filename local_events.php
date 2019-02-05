<?php
$title = 'Local Events';

include 'top.php';

//open csv file and put into array-----------------------------------------
$debug = false;

if (isset($_GET["debug"])) {
    $debug = true;
}

$myFileName = "data/local_events";

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


<article>
    <h1 class="title">Local Events.</h1>
    <div class="media"> <!-- print out photos/data from csv (concerts.csv) -->
        <?php
        /* display the data */
        print "<ol>";
        foreach ($records as $oneRecord) {
            if ($oneRecord[0] != "") {  //the eof would be a "" 
                print "\n\t<li class='local_events'>";
                //print out values
                print '<span class="title">' . $oneRecord[1] . '</span>';
                if ($oneRecord[2] != "") {
                    print '<div class="main_media">';
                    print '<figure>';
                    print '<img src="images/local_events/' . $oneRecord[2] . '" alt"">';
                    print '</figure>';
                    print '</div>';
                }
                if ($oneRecord[4] != "") {
                    print '<span class="date"><h2>Date:</h2>' . $oneRecord[4] . '</span>';
                }
                if ($oneRecord[5] != "") {
                    print '<span class="time"><h2>Time:</h2>' . $oneRecord[5] . '</span>';
                }
                if ($oneRecord[6] != "") {
                print '<span class="location"><h2>Location:</h2><p>' . $oneRecord[6] . '</p></span>';
                }
                print '<span class="description">' . $oneRecord[3] . '</span>';
                if ($oneRecord[7] != "") {
                print '<span class="hyperlink"><h2>Link:</h2><a href="' . $oneRecord[7] . '">' . $oneRecord[7] . '</a></span>';
                }
                print "\n\t</li>";
                print'<hr />';
            }
        }

        print "</ol>";

        if ($debug)
            print "<p>End of processing.</p>\n";
        ?>
    </div>
</article>
<?php
include 'footer.php';
?>    
</body>