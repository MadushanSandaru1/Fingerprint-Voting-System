# Fingerprint Voting System

* Import the fvs_database.sql file in the sql directory into the database...

* Configure the connection/connection.php file according to the database...

---------------------------------------------------------------------------
* Login to administration part using this link
  http://localhost/FVS-NextGen/admin_login.php

* Account Username and password
- Administrator username - 111111111v pwd - 123
- Assistant Election Officer username - 222222222V pwd - 123
- Assistant Election Officer username - 333333333V pwd - 123
- Division Officer username - 444444444v - 123
- Division Officer username - 555555555v - 123
- Division Officer username - 666666666v - 123
- Division Officer username - 777777777v - 123

---------------------------------------------------------------------------
* Login to voting part using this link
  http://localhost/FVS-NextGen/index.php

* Account Username and password
- An inspector must be registered under an election schedule. Then, The account password will be sent via email.
- The inspector can access the system using the NIC number and password.
- The inspector can only login to accpunt during the election time.

---------------------------------------------------------------------------

* Tips for operating the system
- First you need to log in from the admin account and set an election schedule.
- Subsequently, the assisstant election officer must log in through the accounts and appoint polling center inspectors and candidates for election.(If the election is a presidential election, the administrator must appoint candidates.)
- When the polling station inspectors are appointed, the password for the account will be automatically generated and notified to the inspector by email. (You can easily change password through 'inspector' table in database. All the password are encrypted by 'sha1')

- The polling station inspector can only enter during the election scheduled time.
