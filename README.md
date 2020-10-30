#my Mail is a mail delivery system written on PHP based MVC, Laravel Framework. 

# INSTALLATION:

#INSTALL COMPOSER.
Composer is required for installing Laravel dependencies. So use below commands to download and use as a command in you system.
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer
$ sudo chmod +x /usr/local/bin/composer


# CLONE THE PROJECT 
After cloning, go to the project directory and enter the following commands to install all the dependencies using composer.
cd /var/www/myMail
$ sudo composer install

# CONFIGURE THE APACHE DEFAULT HOST FILE.
DocumentRoot /var/www/myMail/public
<Directory /var/www/myMail/public/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
</Directory>

Restart the apache2 service.
Rename the .env.example file to .env in the project folder.
If all works fine, home page should be opened.
Make sure you define the database details in the .env file.
Make sure the queue system is database by checking out this in the .env file. QUEUE_DRIVER=database
In the terminal, go to your project folder and type in php artisan migrate, to migrate all the tables into the database.

# PROJECT DETAILS:

# LOGIN
Home page consists of login and register options.
Register with your email and password and you enter the account.
COMPOSE
Compose mail consists of subject, body, attachment(for simplicity only image files are currently being supported).
Add recipients separated with commas. 
eg: prady@mymail.com,kelly@mail.com
All the recipients will be sent the mail by a queue system. Make sure you start the queue by typing this command.
Php artisan queue:listen database --tries=3 
Now, hit send and check the mail you sent in the sent tab.
If you want to send it to the people later. It can be saved in the drafts by clicking save as draft button.

# INBOX
All the mails you received in chronological order. 
Once you click on the mail, it will be considered as read. This can be easily observed once you come back to the inbox mails screen
Below the mail the thread starts with the mails body and the people who sent it.
Inbox mails can be replied or forwarded to multiple people or be trashed.

# SENT
Sent mails consist of all the mails you have sent.
Sent mails follow similar design as the inbox.
Thread will be seen below the mail similar to the inbox.
Reply, forward and trash work like the same as in the inbox.

# DRAFT
A mail without a subject and a body will not be saved as a draft.
After the clicking on the draft you enter the screen where you can add recipients and send it or trash it.
Draft mail follows the similar design flow as like inbox.

# TRASH
All trash mails will be seen here.
Design is similar to the drafts tab.
