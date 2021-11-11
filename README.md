# Lab 3 Writeup

## Introduction
**Name:** Garrett Cooper  
**Date:** 13/10/2021  
**Lab Title:** Lab 3  


## Executive Summary
In this lab, I implemented the functionality of creating, updating, and deleting information in a database using PHP and MySQL. The information was in the form of 
user generated tasks. I also managed user information in a database and created log in, registration, and credential verification as well. I developed in a local 
environment and hosted my finished product on a live server.

## Design Overview
### Files:
- *index.php* - Contains HTML code for website, loads HTML base of page, selects and displays tasks from database
- *create_action.php* - Creates a task in the database
- *delete_action.php* - Deletes a task from the database
- *login_action.php* - Logs the user in after verifiying their username and password
- *logout_action.php* - Logs the user out
- *register_action.php* - Registers a new user in the databse if their informaion doesn't already exist
- *update_action.php* - Updates the "done" status of a task in the databse and on-screen
- *login.php* - Displays the form to gather username and password, calls login_action.php
- *register.php* - Displays the form to gather user information for registration, calls register_aciton.php
- *style.css* - Contains CSS code for website, loads CSS styling for page
- *docker-compose.yml* - Creates Docker development environment
- *.env.example* - Template .env file for connecting to database
- *apache2_env_setup.sh* - Used on live server to help source the .env file
- *favicon.ico* - Favicon image
- *instructions.md* - Lab instructions
- *Lab 3a UML Diagram - Register.png* - Activity diagram showing register function
- *Lab 3a UML Diagram - Login.png* - Activity diagram showing log in function
- *Lab 3a UML Diagram - CRUD.png* - Activity diagram showing CRUD functions
- *Register.png* - Screenshot of register page
- *Login.png* - Screenshot of log in page
- *On load.png* - Screenshot showing page after logging in

### UML Diagrams
Activity diagram of registering
![UML 3a](https://github.com/BYU-ITC-210/lab-3b-gncoop/blob/master/instructions/Lab%203b%20UML%20Diagram%20-%20Register.png)

Activity diagram of logging in
![UML 3a](https://github.com/BYU-ITC-210/lab-3b-gncoop/blob/master/instructions/Lab%203b%20UML%20Diagram%20-%20Login.png)

Activity diagram of CRUD functions  
![UML 3a](https://github.com/BYU-ITC-210/lab-3b-gncoop/blob/master/instructions/Lab%203b%20UML%20Diagram%20-%20CRUD.png)

### Screenshots
Webpage on load 
![Load](https://github.com/BYU-ITC-210/lab-3b-gncoop/blob/master/instructions/On%20load.png) 
  
Log in  
![Login](https://github.com/BYU-ITC-210/lab-3b-gncoop/blob/master/instructions/Login.png)

Register  
![Register](https://github.com/BYU-ITC-210/lab-3b-gncoop/blob/master/instructions/Register.png)

## Questions

**Describe how cookies are used to keep track of the state. (Where are they stored? How does the server distinguish one user from another? What sets the cookie?)** 
- Cookies are stored locally in the web browser in order to remember the "name-value pair" that identifies the user. The server distinguished one user from another 
by assigning a unique string of numbers as part of the cookie to identify an individual browser. The server sends the cookie to the users web browser.

**Name 2 advantages of using a server-side database/web-app instead of a browser-only app (like Lab 2).**
- One advantage is that the data is accessible across different browsers. Another advantage is that the data cannot be accessed unless the user is authenticated to 
be able to view the information in the database.
  
**Describe how prepared statements protect against sql injection, but not xss.**
- Prepared statements protect from SQL injection because it sends the query and the user supplied data seperately. The query is sent first and the data is sent 
later, allowing the server to distinguish between the code and input data, preventing malicious extra code from being executed. This will not protect against 
xss becasue the user input is not sanitized before being used.

**Describe at least two key differences between the PHP version of the task list and the JavaScript one you completed in labs 2A and 2B.**
- One difference is that the PHP version of the tasklist data was all stored server-side inside of in local browser storage. Another difference is that the 
index.php (index.html) page checked for session variables before loading and the JavaScript version did not.
  
**If we created a new table login_logout in the database to keep track of login and logout times of our various users, what would that table's schema look like? 
Describe necessary fields, which fields would need to be primary or unique, and what data type you would use for each.** 
| Name         | Type      | Length/Values  | Default         | Index   | A_I |  ...  |
| ------------ | --------- | -------------- | --------------- | ------- | --- | ----- |
| `user_id`    | `INT`     |                | ...             | Primary |  ☐  |  ...  |
| `login_time` | `INT`     |                | ...             | ...     |  ☐  |  ...  |
| `logout_time`| `INT`     |                | ...             | ...     |  ☐  |  ...  |
| `logged_in`  | `BOOLEAN` |                | `As defined: 0` | ...     |  ☐  |  ...  |
  

## Lessons Learned
### 1 - Using Prepared Statements
Including prepared statements when sending queries with user submitted data is critical to protect from SQL injection. If the prepared query is not coded properly, 
a particularly confusing error message referncing booleans will be given and the query will not work. This error message will be thrown even if booleans are not 
a part of the query. The solution was to ensure that your query is perfectly formatted, and the values match the types expected by the statement.

### 2 - Utilizing Buttons and Form Tags
Changing the checkbox and delete buttons posed a challenge as, when changing them to buttons and wrapping them in form tags, the formatting of the task list was 
severely disrupted. No element was where it was inteded to be. The key to this was uncluding span tags so that the elements did not take up the width of the page. 
Equally essential was closing the span tags correctly at the end of each element. This enabled the elements to be displayed stylistically and correctly.

### 3 - Sessions
A session needs to be started or resumed before session variables can be accessed. At one point, required session variables were unable to be accessed. This 
prevented creating, updating, deleting, or reading the required tasks. Upon inspection, a session had not been started. Including `session_start()` solved this 
issue.

## Conclusions
- Store data using MySQL database
- Use prepared statements
- Validate passwords
- Return custom error messages
- Create and manage sessions
- Use session variables
- Send values using POST requests
- Use PHP and HTML in the same file

## References
- https://www.php.net/manual/en/function.session-start.php\
- https://stackoverflow.com/questions/707874/differences-between-index-primary-unique-fulltext-in-mysql
- https://www.ptsecurity.com/ww-en/analytics/knowledge-base/how-to-prevent-sql-injection-attacks/#4
- https://www.w3schools.com/php/php_mysql_delete.asp
- https://www.w3schools.com/PHP/func_mysqli_fetch_assoc.asp


