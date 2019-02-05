<!-- assignment 5.0 -->
<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        /* This sets the current page to not be a link. Repeat this if block for
         *  each menu item */
        if ($path_parts['filename'] == "index") {
            print '<li class="activePage" id="index">Home</li>';
        } else {
            print '<li id="index"><a href="index.php">Home</a></li>';
        }
        
        if ($path_parts['filename'] == "local_events") {
            print '<li class="activePage">Local Events</li>';
        } else {
            print '<li><a href="local_events.php">Local Events</a></li>';
        }
        
        if ($path_parts['filename'] == "concerts") {
            print '<li class="activePage">Concerts</li>';
        } else {
            print '<li><a href="concerts.php">Concerts</a></li>';
        }
        
        if ($path_parts['filename'] == "art") {
            print '<li class="activePage">Art</li>';
        } else {
            print '<li><a href="art.php">Art</a></li>';
        }
        
        if ($path_parts['filename'] == "skate") {
            print '<li class="activePage">Skate</li>';
        } else {
            print '<li><a href="skate.php">Skate</a></li>';
        }
        
        if ($path_parts['filename'] == "snow") {
            print '<li class="activePage">Snow</li>';
        } else {
            print '<li><a href="snow.php">Snow</a></li>';
        }
        
        if ($path_parts['filename'] == "surf") {
            print '<li class="activePage">Surf</li>';
        } else {
            print '<li><a href="surf.php">Surf</a></li>';
        }
        
        if ($path_parts['filename'] == "form") {
            print '<li class="activePage">Join</li>';
        } else {
            print '<li><a href="form.php">Join</a></li>';
        }
        ?>
    </ol>
</nav>