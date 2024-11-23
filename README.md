# EEG Research Hub
The EEG research hub is a web application developed for UniSQ for the purpose of corroboration and to provide a central repository for serving EEG data and associated research papers.  This was designed an built as a project for CSC3600 by Belinda Greer, Jai Murali and Dustin Kearney.

The application is designed to be hosted on infrastructure with minimal system requirements and as such, is expandable to accommodate large quantities of user submitted data.
### Minimum hardware specifications
A windows 10 / 11 host
1GHz x64 CPU
512 MB RAM
500 MB Storage
## Installation
- Install XAMPP for windows following the vendors specifications.
- Clone this repository to local storage.
- Start the XAMPP GUI and initialise both the web server and the SQL database. Once both are operational, commence the configuration process.
### Configure HTTPS
From the XAMPP GUI, click on "**Config > httpd.conf**" and set the document root to the root of the locally cloned repository. Find the section below, and alter both the document root and the directory to reflect the local installation
```
# DocumentRoot: The directory out of which you will serve your
# documents. By default, all requests are taken from this directory, but
# symbolic links and aliases may be used to point to other locations.
#
DocumentRoot "C:\www\UniSQ-EEG-Publications-Platform"
<Directory "C:\www\UniSQ-EEG-Publications-Platform">
```
### Configure the MYSQL Server
If the default MYSQL settings are appropriate for your environment, proceed to the initialisation of the database by clicking on the "**Admin**" button in the XAMPP GUI. This will open the web interface for database management. Navigate to the SQL tab. 
The database can be built with, or without test data.

**Development use** (Contains test data):
> In a text editor, open **EEG_data_and_publication_platform.sql**, copy the contents to the web interface and click "**Go**".

**Production use**:
> In a text editor, open **databaseInit.sql**, copy the contents to the web interface and click "**Go**".

This will initialise the tables, ready for populating / supplementing  with user supplied data.

#### Default Credentials
Ensure these below credentials are changed upon initial login.

**EEG Platform (Management User)** - 
	U: `manager@eegdata.com`
	P: `Eegmanager12345!`
It is required that the below steps be performed to create a new management user.
1) Go to the **Researcher Portal** and click the **Sign up here** button.
1) Populate the fields as appropriate 
1) Log into the **Management Portal** as the default admin user using the above credentials
1) Click on **Edit user** in the row containing the details of the newly created user
1) Amend the **User Privilege Level** to **0** 
1) Click **Update**

The default management user **manager** will be removed in the following section

**MySQL (Admin)** - 
	U: `eeg_publications_user`
	P: `pa55word`

To create a new admin user:
1) On the XAMPP control panel, click on **Admin** in the MySQL row
1) Within the PHPMyAdmin page, navigate to the **SQL** tab
1) Paste into the input field the below, replacing values as appropriate, where \<USERNAME\> is the new MySQL admin user and \<PASSWORD\> is their password: 
	```
	CREATE USER '<USERNAME>'@'localhost' IDENTIFIED BY '<PASSWORD>';
	GRANT ALL PRIVILEGES ON *.* TO '<USERNAME>'@'localhost' WITH GRANT OPTION;
	DROP USER 'eeg_publications_user'@'localhost';
	FLUSH PRIVILEGES;
	DELETE FROM researcher WHERE username = 'manager';
	```
1) **Ensure an EEG user has been created and promoted to userRole 0 as outlined in the above step.  If this has not been done the above SQL statement will remove the only management user.**
1) Click **Go**

The default users for both the MySQL DB and the EEG platform have now been deleted.  Credentials for the new MySQL database administrative user must be reflected under the appropriate variable within the `/model/database.php` file. 
</br>
### Email setup
To permit the mailing of notifications, the email credentials must be added to two files, replace the existing filler values with those of the sending account.
Please note, currently only Gmail accounts are supported.  Follow the instruction [here](https://myaccount.google.com/apppasswords) to create an appropriate app password which is to be used when populating the below files as appropriate.

**Files to alter:** 
`/contactUs/index.php` (lines 63 and 64)
`/eeg/index.php` (lines 97 and 98)

```
            // specify SMTP credentials
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure  = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = '<Gmail address>';
            $mail->Password = '<Gmail password>';     
```
## Interacting with the web application
### EEG Data
This page is to view titles of EEG data and associated publications. In order for a public user to download, a request must be made by clicking on the request button, and agreeing to the terms and conditions. This will initiate an email to management users from which they can authorise the download by sending a link to the requester.
### Publications
The publications page is a collection of researcher supplied documents. These are considered public and no permission is required for anyone to download.
### Researcher portal
This area allows new users to request access as a researcher by clicking on the request access button.  This leads to a form requesting user details and password (note, minimum password requirements apply).  Once submitted, the user account will require management approval prior to logging in.

Active users designated as researchers can log in to the portal and perform actions with elevated privileges.  
- The download of all EEG data without requiring management approval is permitted.
- EEG data and publications can be uploaded (pending moderation).
- The logged in users profile can be modified
### Contact Us
Visitors to the website can initiate contact via the for supplied on this page.  Submitted enquiries will be forwarded to the management email account (as defined above) with details permitting a response via email.
### Management Portal
The Management portal is the hub for all moderation and administrative tasks, including content moderation, user modification and data upload / download functions.  Access is only available to management users (*userRole "0" in the researcher table*).

- View / Edit EEG - Moderation (*approve / delete*) of uploaded EEG data.
- Upload EEG data
- Public EEG request - Listing of access requests for EEG data
- View / Edit Publications - Moderation (*approve / delete*) of uploaded research publications.
- Upload Publications
- User Management - Permits the alteration of user profiles including the elevation of privileges 
