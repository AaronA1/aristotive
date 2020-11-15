# Aristotive
This is a web-based Student Response System
allowing for the making of bespoke quizzes (including multiple question types)
This app is dockerirsed so to run in a container just run the build script on command line
```
./docker_build.sh
```

This app runs without a database so quizzes and results are read from and written to files.

## Building a quiz
You should build your quizzes into .json files using valid syntax.
These should be then imported into the '/quizzes' directory where they can be read by the app.
In the directory currently there should be a skeleton example to use for reference and build your question types.
Currently supported question types:
- Multiple choice (one answer)

Future supported question types:
- Multiple choice (one or more)
- Short answer (numbers)
- Short answer (words)
- Order the options
