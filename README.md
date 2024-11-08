# Symfony development

## Description

This code was developed to demonstrate functionalities in Symfony using clean architectures, SOLID principles, and Domain-Driven Design (DDD) practices among others.

Symfony 5.4 was used, and the PHP version 8.2.

## Steps to deploy

The project includes a Dockerfile to create an instance with MySQL. By executing the following command `docker compose up -d`, the image and container are generated and ready for use.

Symfony has a test server that is sufficient for this demo and can be run with this command `symfony server:start`.

Commands are tasks you can execute from the command line to interact with your application and perform various tasks. They are run through the console with the main command `php bin/console`

In this project, we have two commands:

* Create admin command: Allows adding a user to the database who can log in. This can also be done through the register user endpoint, but it has been implemented this way for explanatory purposes `php bin/console app:user:create_admin`.
* Sent Newsletter command: One of the requirements of the test. This command allows sending emails to all active users who received the newsletter more than a week ago. By executing php bin/console app:user:sent_newsletter, emails are sent once the mail client is configured.
  
  For this project, it was requested to send it automatically every day at 6 a.m. To do this, you would need to add this line to the crontab.
`0 6 * * * /symfony-path/bin/console app:send-newsletter`






