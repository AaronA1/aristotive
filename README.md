# Aristotive
This is a web-based Student Response System
allowing for the making of bespoke quizzes (to also include multiple question types)

To run the app you must run it within a docker container using the build script (only on the first build) on command line
```
./docker_build.sh
```
Subsequent uses will only require upping the container using
```
docker-compose up -d
```

## Building a quiz
You should build your quizzes into .json files using valid syntax.
These should be then imported into the '/quizzes' directory where they can be read by the app.
In the directory currently there should be a skeleton example as a reference to build your own quizzes.

Currently supported question types:
- Multiple choice (single) (multi-choice-single)
- Input answer (input)
- Order the options (order)
- True/False (true-false)

Future supported question types:
- Multiple choice (multi) (multi-choice-multi)
- Image-based questions

There must only be one .json file per directory.

## Starting a Quiz
To start a quiz room, log into the admin account using the following details:

`username: admin`

`password: password`

From here you can simply use the admin dashboard to enter the required quiz directory and start the room.
A unique Room ID will be generated to provide to students to join.

## Taking a Quiz
To join a quiz room, simply enter the Room ID on the login page.
