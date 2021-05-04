<template>
    <div class="container">
        <div class="question-box-container" v-if="active">
            <b-jumbotron>
                <template slot="lead">
                    <div class="row">
                        <div class="col-md-6">
                            {{ currentQuestion.question }}
                        </div>
                        <div class="col-md-6" style="text-align: right">
                            <b-button v-on:click="fetchResponses" variant="primary">
                                Show Answers
                            </b-button>
                        </div>
                    </div>
                </template>
                <hr class="my-5"/>
                <b-list-group v-if="questionType === 'multi-choice'">
                    <b-list-group-item class="d-flex justify-content-between align-items-center"
                                       v-for="option in currentQuestion.options"
                                       :key="option">
                        {{ option }}
                        <b-badge variant="primary" pill>{{ calculate(option) }}</b-badge>
                    </b-list-group-item>
                </b-list-group>
                <b-list-group v-else-if="questionType === 'true-false'">
                    <b-list-group-item variant="primary"
                                       class="d-flex justify-content-between align-items-center progress-bar"
                                       v-bind:style="{ width: percentageTrue+'%'}">
                        True
                        <b-badge variant="primary" pill>{{ numTrue }}</b-badge>
                    </b-list-group-item>
                    <b-list-group-item variant="primary"
                                       class="d-flex justify-content-between align-items-center progress-bar"
                                       v-bind:style="{ width: percentageFalse+'%'}">
                        False
                        <b-badge variant="primary" pill>{{ numFalse }}</b-badge>
                    </b-list-group-item>
                </b-list-group>
                <b-list-group style="text-align: center" v-else>
                    <b-list-group-item v-for="response in responses" :key="response.answer" text>
                        {{ response.answer }}
                    </b-list-group-item>
                </b-list-group>
                <hr class="my-5"/>
                    <div style="text-align: right">
                        <b-button v-if="lastQuestion" v-on:click="endQuiz" variant="danger">
                            End Quiz
                        </b-button>
                        <b-button v-else v-on:click="nextQuestion" variant="success">
                            Next Question
                        </b-button>
                    </div>
            </b-jumbotron>
        </div>
        <div v-else>
            <b-jumbotron style="text-align: center">
                <h3>Room ID: </h3>
                <h1>{{ roomObj.id }}</h1>
                <b-card-text>There are currently {{ numMembers }} people in the room.</b-card-text>
                <b-card-text>Press the button below to begin</b-card-text>
                <b-button variant="success" v-on:click="beginQuiz">Begin Quiz</b-button>
            </b-jumbotron>
        </div>
    </div>
</template>

<script>
export default {
    props: ['room', 'questions'],
    data() {
        return {
            responses: [],
            questionIndex: 0,
            questionsObj: null,
            roomObj: null,
            active: false,
            numMembers: 0,
            interval: null
        }
    },
    methods: {
        beginQuiz() {
            this.postQuestion();
            this.stopMemberCount();
        },
        countMembers() {
            this.interval = setInterval(() => {
                axios.get('/api/quiz/session').then(response => {
                    this.numMembers = response.data.length - 1;
                }).catch(error => {
                    console.log(error);
                })
            }, 5000);
        },
        stopMemberCount() {
            clearInterval(this.interval);
        },
        fetchResponses() {
            axios.get('/api/quiz/response/' + this.roomObj.id).then(response => {
                this.responses = response.data;
            }).catch(error => {
                console.log(error);
            });
        },
        nextQuestion() {
            this.responses = [];
            this.questionIndex++;
            this.postQuestion();
        },
        postQuestion() {
            axios.post('/api/quiz/question', {
                roomId: this.roomObj.id,
                question: this.currentQuestion
            }).then(response => {
                this.active = true;
            }).catch(error => {
                console.log(error);
            });
        },
        calculate(option) {
            let count = 0;
            for (const response of this.responses) {
                if (response.answer === option)
                    count++;
            }
            return count;
        },
        endQuiz() {
            axios.delete('/room/' + this.roomObj.id).then(response => {
                window.location.replace('/admin');
            })
        }
    },
    computed: {
        currentQuestion() {
            return this.questionsObj[this.questionIndex];
        },
        lastQuestion() {
            if (this.questionIndex === this.questionsObj.length - 1)
                return true;
        },
        percentageTrue() {
            return (this.numTrue / this.responses.length) * 100;
        },
        percentageFalse() {
            return (this.numFalse / this.responses.length) * 100;
        },
        numTrue() {
            let count = 0;
            for (const response of this.responses) {
                if (response.answer === "True")
                    count++;
            }
            return count;
        },
        numFalse() {
            let count = 0;
            for (const response of this.responses) {
                if (response.answer === "False")
                    count++;
            }
            return count;
        },
        questionType() {
            return this.currentQuestion.type;
        },
    },
    created() {
        let questions = JSON.parse(this.questions);
        this.questionsObj = questions.questions;
        this.roomObj = JSON.parse(this.room);
        this.countMembers();
    },
}
</script>

<style scoped>
* {
    /*border: 1px solid black;*/
}

.container {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    /*text-align: center;*/
    color: #2c3e50;
    margin-top: 60px;
}
</style>
