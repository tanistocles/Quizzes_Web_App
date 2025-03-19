
# Quickzzes

This is a quizzing app that allows "teacher" users to create quizzes and add "student" users to the quizzes - thus, allowing these users to do and complete them, the "student" users can also see a summary of their results should they want to. 

You first need to login, the "database" MySQL database contains the "login" table, in which you can find all the pre-set login info. 
I recommend the following account:
teacher@gmail.com - PW: teacher
student@gmail.com - PW: student
teacher2@gmail.com - PW: teacher
huh@gmail.com - PW: 123

Alternatively, you can just register a new account and start from there.

NOTE: I recommend using the "Home" and "Logout" buttons provided by the web app to navigate. The browser's "back" button does work, though it might create some quacky stuff by submitting a form twice, which is annoying. It won't break the program though (not that I know of).

To create a new quiz from scratch, add it by specifying its name and number of questions, and then edit it. 
To test out the newly added quiz, add a student to it and then log in to the said student account. 



## Authors

- [@tanistocles](https://www.github.com/tanistocles)


## Installation

Run the web app by hosting it locally, you can use xampp for this, the index.php file should be the starting point of the app.

You should also host the database.sql file as well since this is where all the data of the app is stored. 
    