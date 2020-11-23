<template>
    <div id="quiz" v-if="this.completed === false">
        <b-container class="bv-example-row">
            <b-row>
                <b-col sm="12" offset="0">
                    <question-card
                        v-if="questionsObject.length"
                        :question="questionsObject[index]"
                        :length="questionsObject.length"
                        v-on:next-question="next"
                        v-on:complete-quiz="completeQuiz">
                    </question-card>
                </b-col>
            </b-row>
        </b-container>
    </div>
    <div id="results" v-else="">
        <b-container class="bv-example-row">
            <b-row>
                <b-col sm="12" offset="0">
                    <b-jumbotron>
                        <template slot="lead">
                            Results
                        </template>

                        <hr class="my-4" />
                        You got {{this.correct}}/{{questionsObject.length}} correct!
                    </b-jumbotron>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
export default {
    name: 'Quiz',
    props: ['questions'],
    data() {
        return {
            index: 0,
            questionsObject: null,
            answers: [],
            completed: false,
            incorrect: 0,
        }
    },
    methods: {
        next (answer) {
            if(answer === null) {
                return;
            }
            if(this.index !== this.questionsObject.length-1) {
                this.answers.push(answer)
                this.index++;
            }
        },
        completeQuiz(answer) {
            if(answer === null) {
                return;
            }
            this.answers.push(answer);
            axios.post('/quiz/results', [location.pathname.split('/').pop(), this.answers]).then(response => {
                this.completed = true;
                this.incorrect = response.data;
            }).catch(error => {
                console.log(error);
            });
        }
    },
    computed: {
        correct: function() {
            return this.questionsObject.length-this.incorrect;
        }
    },
    created() {
        this.questionsObject = JSON.parse(this.questions);
    }
}
</script>

<style>
#quiz {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}
</style>
