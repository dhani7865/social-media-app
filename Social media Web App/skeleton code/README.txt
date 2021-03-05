SETUP XAMP:
First you would need to set up xamp. 
First thing you would need to do is run the setup_xampp file. When the file is running wait until the setup is finished or click 1 to refresh.  After it has been set up go to the folder where you have saved the xamp foder. Then click on the folder called xamp and click xampp-control, you will then get a pop up box, click on start apache and click start mySQL. Once it is running go to the browser type in localhost/filename.php then click enter and it should display somthing.

DOCUMENTATION:
Create_data.php:
First thing the user would need to do when running xamp is run the create_data.php file which would create all the databases on phpmyadmin.Once this has been done then you can run the rest of the pages. 

Sign_in.php:
Once the user has got the databases set up on phpmyadmin, they can then run sign_in.php file to sign in using the username and password. If they don't have an account they can then sign up and create username and password. 

Sign_up.php:
The user can also sign_up by creating there own username and password and then use them details to sign in. After the user has created there username and password it will then print message saying sign in using the username and password and it would automatically be added to the database.

Set_profile.php:
The user can set up a profile and type in all the data into set_profile.php and then click submit. There is also a calendar in the dob field to allow users to select date. If a ield is left blank it will throw an error saying cannot be left blank. Therefore, you would need input every field. 

Show_profile.php:
Once the user has set up a profile in set_profile.php, they would then be able to view the profile in the show_profile page.


Libraries:
The libraries.php iile shows all 3 different javascript ibraries which i have chosen for video sharing that would be useful. I have also added conclusion to show my opinion on which library i would think is best to use. I have compared the different librries to identify which one is better. 

Browse_profiles.php:
Browse_profiles file would give list of different usernames and it would allow users to click on each indivitual users and it would then bring up there profiles.

Messages.php
The global feed is where the user can type iin a post/message and then submit there post. It would then display the post with the date when it was posted. It would also allow users to like each post. 

In order to get the messages.php file to run. You will need to run it on the localhost and then in the text box type in a post and submit it. Then, the message will be shown in the table and it would allow the user to like any messages by simply clicking the like button. It also shows the 5 recent messages in the recent messages table. 


Validating:
You would need to validate the different inputs the user enters. 
For example if a user inputted wrong format of DOB, you would get a error saying inpput the dob in the correct formal. 
Also if a user left out a field, it would also send a error message saying you can't leave the field blank. Furthermore, in order to test  the severside the user would need to type in question mark (?) first and then type in noval=y. 

Santisation:
The Santisation code which the user has inputted would clean the user data.

API:
To test the api, you would simply type in a post then submit it. The post which you have entered will automatically go into the table. It would thenallow users to like posts. For example, just press the like button, next to the post. 

When you type an address or submit data via a browser window, you would be making a server request, via the user interface. This is known as the API — or Application Programming Interface. Instead of sending a request and receiving data via HTML and having the results displayed as a web page, using APIs to send the request and receive the result in a format like JSON, which can then be used directly inside of other programs, to make it a lot easier.


Admin
I have created an account for only the user can access. The user would need to type in admin in the username and secret in the password. The admin is the ony person who will be able to mute abusive messages from the users. 