<?php

/* To set up database:
 *    Start mysql as root user:
 *      user@host$ mysql -u<root user> -p <root password>
 *   
 *    Create database and user for applicant test:
 *      mysql> create database cp_applicant;
 *      mysql> grant all on cp_applicant.* to 'cp_user'@'localhost' identified by 'cp_password';
        mysql> quit;
 *    
 *    Import user data into newly created db:
 *      user@host$ mysql -ucp_user -p'cp_password' cp_applicant < contacts.sql
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'cp_user');
define('DB_PASSWORD', 'cp_password');
define('DB_NAME', 'cp_applicant');
