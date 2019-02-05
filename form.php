<?php
$title = 'Newsletter';

include "top.php";

//%^%^%^%^%^%^%^%^%^--------assignment 3.3----^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.

$debug = false;

if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}

if ($debug)
    print "<p>DEBUG MODE IS ON</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
//define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
$firstName = "";
$lastName = "";
$email = "";
$gender = "Male";
$skate = true; //checked
$concerts = false; // not checked
$snow = false;
$surf = false;
$where = "Local";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error flags one for each form element we validate
// In the order they appear in section 1c.
$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;
$genderERROR = false;
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

// array used to hold form values that will be written to a CSV file
$dataRecord = array();

$mailed = false; // have we mailed this information to the user?
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a Security
    // 
    if (!securitycheck(true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same as declared in section 1c.

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;

    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastName;
    
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;

    $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $gender;
    
    if(isset($_POST["chkSkate"])) {
        $skate = true;
    } else {
        $skate = false;
    }
    $dataRecord[] = $skate;
    
    if(isset($_POST["chkConcerts"])) {
        $concerts = true;
    } else {
        $concerts = false;
    }
    $dataRecord[] = $concerts;

    if(isset($_POST["chkSnow"])) {
        $snow = true;
    } else {
        $snow = false;
    }
    $dataRecord[] = $snow;
    
    if(isset($_POST["chkSurf"])) {
        $surf = true;
    } else {
        $surf= false;
    }
    $dataRecord[] = $surf;
    
    $where = htmlentities($_POST["lstWhere"],ENT_QUOTES,"UTF-8");
    $dataRecord[] = $where;
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.

    if ($firstName == "") {
        $errorMsg[] = "Please Enter your First name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have an extra character(s).";
        $firstNameERROR = true;
    }

    if ($lastName == "") {
        $errorMsg[] = "Please Enter your Last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your last name appears to have an extra character(s).";
        $lastNameERROR = true;
    }
    
    
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }


    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //
        if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //
        // This block saves the data to a CSV file.

        $fileExt = ".csv";

        $myFileName = "data/registration";

        $filename = $myFileName . $fileExt;

        if ($debug)
            print"\n\n<p>filename is " . $filename;

        // now we just open the file for append
        $file = fopen($filename, 'a');

        // write the forms informations
        fputcsv($file, $dataRecord);

        // close the file
        fclose($file);

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to 
        // to the person filling out the form (section 2g)

        $message = '<h2>Thank you for signing up for our newsletter.</h2>'
                . '<h3>Here is the information you gave us.</h3>';

        foreach ($_POST as $key => $value) {
            if ($key != "btnSubmit") {
                $message .= "<p>";
                
                $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));

                foreach ($camelCase as $one) {
                    $message .= $one . " ";
                }
                $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
            }
        }


        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f. 
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        $from = "Statik Newsletter <noreply@statik.com>";

        // subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "Statik Newsletter: " . $todaysDate;

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    } // end form is valid   
} // ends if form was submitted.
//#############################################################################
//
// SECTION 3 Display Form
//
?>
<article id='form'>

    <?php
//####################################
//
    // SECTION 3a.
//
    // 
// 
// 
// If its the first time coming to the form or there are errors we are going
// to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { //closing of if marked with: end body submit
        print "<h1> Your Request has ";

        if (!$mailed) {
            print "not ";
        }

        print "been processed</h1>";

        print "<p>A copy of this message has ";
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p>To: " . $email . "</p>";
        print "<article id='message'>";
        print "<p id='mailmessage'>Mail Message:</p>";

        print $message;
        print "</article>"; //close id = 'message'
    } else {

        //####################################
        //
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form

        if ($errorMsg) {
            print '<div id="errors">';
            print "<h1>Oops! There is an error with your form.</h1>";
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }




        //####################################
        //
        // SECTION 3c html Form
        //
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:

          value="<?php print $email; ?>

          this makes the form sticky by displaying either the initial default value (line 35)
          or the value they typed in (line 84)

          NOTE this line:

          <?php if($emailERROR) print 'class="mistake"';?>

          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.

         */
        ?>

        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">

            <fieldset class="wrapper">
                <legend>Sign Up Today!</legend>
                <p>Please fill out this form to receive weekly e-mails about new Statik events</p>

                <fieldset class="wrapperTwo">
                    <legend>Please complete the following form</legend>

                    <fieldset class="contact">
                        <legend>Contact Information</legend>
                        <label for="txtFirstName" class="required">First Name
                            <input type="text" id="txtFirstName" name="txtFirstName"
                                   value="<?php print $firstName; ?>"
                                   tabindex="100" maxlength="45" placeholder="Enter your first name"
                                   <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   autofocus>
                        </label>
                        <label for="txtLastName" class="required">Last Name
                            <input type="text" id="txtLastName" name="txtLastName"
                                   value="<?php print $lastName; ?>"
                                   tabindex="200" maxlength="45" placeholder="Enter your Last name"
                                   <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()">
                        </label>
                        <label for="txtEmail" class="required">Email
                            <input type="text" id="txtEmail" name="txtEmail"
                                   value="<?php print $email; ?>"
                                   tabindex="300" maxlength="45" placeholder="Enter a valid email address"
                                   <?php if ($emailERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()">
                        </label>
                        <fieldset class="radio">
                        <legend>What is your gender?</legend>
                        <label><input type="radio" 
                                      id="radGenderMale" 
                                      name="radGender" 
                                      value="Male"
                                      <?php if ($gender=="Male")print'checked'?>
                                      tabindex="400">Male</label>
                        <label><input type="radio" 
                                      id="radGenderFemale" 
                                      name="radGender" 
                                      value="Female"
                                      <?php if ($gender=="Female")print'checked'?>
                                      tabindex="450">Female</label>
                        </fieldset> <!-- ends radio -->
                    </fieldset> <!-- ends contact -->
                    <fieldset class = "newsletter">
                    <legend>Newsletter Preferences</legend>
                        <fieldset class="checkbox">
                            <legend><strong>What</strong> would you like to be notified about? <em>(check all that apply)</em>:</legend>
                            <label><input type="checkbox"
                                          id="chkSkate"
                                          name="chkSkate"
                                          value="Skate"
                                          <?php if($skate) print 'checked'; ?>
                                          tabindex="500">Skate</label>
                            <label><input type="checkbox"
                                          id="chkConcerts"
                                          name="chkConcerts"
                                          value="Concerts"
                                          <?php if($concerts) print 'checked'; ?>
                                          tabindex="510">Concerts</label>
                            <label><input type="checkbox"
                                          id="chkSnow"
                                          name="chkSnow"
                                          value="Snow"
                                          <?php if($snow) print 'checked'; ?>
                                          tabindex="520">Snow</label>
                            <label><input type="checkbox"
                                          id="chkRestaurants"
                                          name="chkSurf"
                                          value="Surf"
                                          <?php if($surf) print 'checked'; ?>
                                          tabindex="530">Surf</label>
                        </fieldset> <!-- ends checkbox -->
                        <fieldset class="listbox">
                            <legend><strong>Where</strong> would you like to get information about events for?</legend>
                            <select id="lstWhere"
                                    name="lstWhere"
                                    tabindex="600">
                                <option <?php if($where=="Local") print" selected "; ?>
                                    value="Local">Local (Burlington, VT)</option>
                                <option <?php if($where=="State") print" selected "; ?>
                                    value="State">State (Vermont)</option>
                                <option <?php if($where=="National") print" selected "; ?>
                                    value="National">National (United States)</option>
                                <option <?php if($where=="Global") print" selected "; ?>
                                    value="Global">Global</option>
                            </select>    
                        </fieldset> <!-- ends listbox -->
                    </fieldset> <!-- ends newsletter -->
                </fieldset> <!-- ends wrapper Two -->
                
                <fieldset class="buttons">
                    <legend></legend>
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="900" class="button">
                </fieldset> <!-- ends buttons -->

            </fieldset> <!-- Ends Wrapper -->
        </form>

        <?php
    } // end body submit
    ?>

</article>
<?php include "footer.php"; ?>

</body>
</html>