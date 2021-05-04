# Aristotive
This is a web-based Student Response System
allowing for the making of bespoke quizzes

To run the app you must run it within docker containers using the build script (only on the first build) on command line from the root directory
```
./docker_build.sh
```
Subsequent uses will only require upping the containers using:
```
docker-compose up -d
```
Downing the containers when finished with:
```
docker-compose down
```

## Building a quiz
You should build your quizzes into .json files using valid syntax.
These should be then imported into the '/quizzes' directory where they can be read by the app.
In the directory currently there should be a skeleton example as a reference to build your own quizzes.

The currently supported question types are:
- Multiple choice (multi-choice)
- True/False (true-false)
- Input answer (input)
- Order the options (sortable)

There must only be one .json file per directory.

## Starting a Quiz (Admin)
To start a quiz room, log into the admin account using the following details:

`username: admin`

`password: password`

From here you can simply use the admin dashboard to enter the required quiz directory and start the room.
A unique Room ID will be generated to provide to students to join.

## Taking a Quiz (Audience)
To join a quiz room, simply enter the Room ID on the login page.
