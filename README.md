# Aristotive
This is a web-based Student Response System
allowing for the making of bespoke quizzes (to also include multiple question types)

To run the app first run `npm run dev` then `php artisan serve`
If npm is not installed, either install it or run the app within a docker container using the build script (first time)
```
./docker_build.sh
```

This app runs operates a database so quizzes and results are read from and written to files.

## Building a quiz
You should build your quizzes into .json files using valid syntax.
These should be then imported into the '/quizzes' directory where they can be read by the app.
In the directory currently there should be a skeleton example as a reference to build your own quizzes.

Currently supported question types:
- Multiple choice (one answer)

Future supported question types:
- Multiple choice (one or more)
- Short answer (numbers)
- Short answer (words)
- Order the options

Currently the naming conventions for quiz directories are as follows:
'example(#number)' with a 'test.json' inside

Directory and file naming will be more flexible once a better approach is resolved in future


## Taking a Quiz
To take a quiz, simple proceed to '/quiz/#' where # is the number of the directory.
For instance, the example quiz can be taken at '/quiz/1'
