Technology:
- PHP5
- Yii framework
- MySQL database
- Apache/IIS

Plug-ins & Extensions
- PHP Mailer
- html2pdf
- Yii eFeed (for RSS feeds)

Design Patten
- MVC

Instructions:

1. Open the mysql database with root user (phpmyadmin recommended) and run/import the following files:
   - Source/db/db.sql -> Creates the database and user account
   - Source/db/htnews.sql -> Creates the database and imports the sample data
2. Copy and paste the content of the Source folder to your web root.
3. If your database is not located at localhost or you wish to use a different database, then you will have to update the file Source/htnews/protected/config/database.php with your information.
4. Open web browser and go to http://localhost/htnews/ and the website should load.
5. Make the folder Source/htnews/uploads writable by the web server to store uploaded images.
6. For security reasons make the protected directory not accessible from web and delete the db directory after deployment.

Assumptions & Missing Requirements:

- The verification code expires after two days and the user needs to contact admin. Usually user should be able to regenerate the verification code.
- There is no admin control panel designed yet.
- User cannot obtain his password if he forgets it.
- Author email address are visible to public, we should consider using a username to maintain author privacy.
- There is no way a user can see all the articles published by an author.
- An HTML editor (like tinymce) would be nice to have for writing article.
- I haven't configured the framework to use SEO friendly URL's
