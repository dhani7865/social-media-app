<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>

<!--- Creating header for this page --->
<h1>STEP BY STEP GUIDE</h1>


<?php // open php tag


// You should use client-side code (i.e., HTML5)
// This page is all about geginners guide for new users
// It will give a guide on how to set up xamp and how to use the site. 

// execute the header script:
require_once "header.php";
// execute the header script:
require_once "header.php";
// this will call the helper.php file
include_once "helper.php";

// Session if logged in skeleton
if (!isset($_SESSION['loggedInSkeleton'])) {
    // user isn't logged in, display a message saying they must be logged in, in order to view the page.
    echo "You must be logged in to view this page.<br>";
} // close if statment
?>
<!--- Creating html tag and body tag --->
<html>
<body>
    <!--- Creating header for the introduction --->
    <h1>INTRODUCTION</h1>
        <!--- Introduction to this page--->
        <p>This page is all about creating step by step guide for beginners.Visit the different links for further information. </p>
    <!--- Header to setup xamp --->
    <h1>SETUP XAMP</h1>
        <!--- Creating p tags for all the data --->
        <p> First you would need to set up xamp. First thing you would need to do is run the setup_xampp file. When the file is running wait until the setup is finished or click 1 to refresh.  After it has been set up go to the folder where you have saved the xamp foder. Then click on the folder called xamp and click xampp-control, you will then get a pop up box, click on start apache and click start mySQL. Once it is running go to the browser type in localhost/filename.php then click enter and it should display somthing.</p>
        
    <!--- Creating header for the DOCUMENTATION --->
    <h1>DOCUMENTATION</h1>
    <!--- Header for Create_data --->
    <h1>CREATE_DATA.PHP</h1>
        <!--- Creating p tags for all the data --->
        <p> First thing the user would need to do when running xamp is run the create_data.php file which would create all the databases on phpmyadmin.Once this has been done then you can run the rest of the pages.    12</p>

    <!--- Header for Sign_in.php: --->
    <h1>SIGN_IN.PHP</h1>
        <!--- Creating p tags for all the data --->
        <p>Once the user has got the databases set up on phpmyadmin, they can then run sign_in.php file to sign in using the username and password. If they don't have an account they can then sign up and create username and password. </p>

    <!--- Header for Sign_up.php: --->
    <h1>SIGN_UP.PHP</h1>
        <!--- Creating p tags for all the data --->
        <p>The user can also sign_up by creating there own username and password and then use them details to sign in. After the user has created there username and password it will then print message saying sign in using the username and password and it would automatically be added to the database. </p>
    
     <!--- Header for set_profile.php: --->
    <h1>SET_PROFILE.PHP</h1>
        <!--- Creating p tags for all the data --->
        <p>The user can set up a profile and type in all the data into set_profile.php and then click submit. There is also a calendar in the dob field to allow users to select date. If a ield is left blank it will throw an error saying cannot be left blank. Therefore, you would need input every field.  </p>
    
    <!--- Header for Show_profile..php --->
    <h1>SHOW_PROFILE.PHP</h1>
        <!--- Creating p tags for all the data --->
        <p>Once the user has set up a profile in set_profile.php, they would then be able to view the profile in the show_profile page. </p>
    
     <!--- Header for Libraries.php --->
    <h1>LIBRARIES.PHP</h1>
        <!--- Creating p tags for all the data --->
        <p>The libraries.php iile shows all 3 different javascript ibraries which i have chosen for video sharing that would be useful. I have also added conclusion to show my opinion on which library i would think is best to use. I have compared the different librries to identify which one is better. </p>
    
    <!--- Header for Browse_profiles.php --->
    <h1>BROWSE_PROFILES.PHP</h1>
        <!--- Creating p tags for all the data --->
        <p>Browse_profiles file would give list of different usernames and it would allow users to click on each indivitual users and it would then bring up there profiles. </p>
    
    <!--- Header for Messages.php --->
    <h1>MESSAGES.PHP:</h1>
        <!--- Creating p tags for all the data --->
        <p>The global feed is where the user can type iin a post/message and then submit there post. It would then display the post with the date when it was posted. It would also allow users to like each post. In order to get the messages.php file to run. You will need to run it on the localhost and then in the text box type in a post and submit it. Then, the message will be shown in the table and it would allow the user to like any messages by simply clicking the like button. It also shows the 5 recent messages in the recent messages table. </p>
    
    <!--- Header for Validating --->
    <h1>VALIDATION</h1>
        <!--- Creating p tags for all the data --->
        <p>You would need to validate the different inputs the user enters. 
            For example if a user inputted wrong format of DOB, you would get a error saying inpput the dob in the correct formal. 
            Also if a user left out a field, it would also send a error message saying you can't leave the field blank. Furthermore, in order to test  the severside the user would need to type in question mark (?) first and then type in noval=y. </p>
    
    <!--- Header for Santisation --->
    <h1>SANTISATION</h1>
        <!--- Creating p tags for all the data --->
        <p>The Santisation code which the user has inputted would clean the user data. </p>
    
    <!--- header for api --->
    <h1>API</h1>
        <!--- Creating p tags for all the data --->
        <p>To test the api, you would simply type in a post then submit it. The post which you have entered will automatically go into the table. It would thenallow users to like posts. For example, just press the like button, next to the post. 
            
            When you type an address or submit data via a browser window, you would be making a server request, via the user interface. This is known as the API — or Application Programming Interface. Instead of sending a request and receiving data via HTML and having the results displayed as a web page, using APIs to send the request and receive the result in a format like JSON, which can then be used directly inside of other programs, to make it a lot easier. </p>
    
     <!--- header for the ADMIN ACCOUNT --->
    <h1>DMIN</h1>
        <!--- Creating p tags for all the data --->
        <p>I have created an account for only the user can access. The user would need to type in admin in the username and secret in the password. The admin is the ony person who will be able to mute abusive messages from the users.  </p>
    
    <!---conclusion - overall my opinion --->
    <h1>CONCLUSION</h1>
    <!--- Creating p tag for my overall opinion --->
        <p> Overall, in my opinion I think this step by step guide would be beneficial for beginners, as they won't know how to run xamp or the different pages. </p>


<!--- finish off the HTML for this page: --->
<!---require_once "footer.php";
</html> <!--- Close html tag --->
</body> <!--- Close body tag --->