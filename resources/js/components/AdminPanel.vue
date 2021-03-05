<template>
    <div class="container">
        <div class="question-box-container" v-if="active">
            <b-jumbotron>
                <template slot="lead">
                    {{currentQuestion.question}}
                </template>
                <b-list-group>
                    <b-list-group-item v-for="response in responses" :key="response.response">
                        {{response.answer}}
<!--                        <div class="progress">-->
<!--                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40"-->
<!--                                 aria-valuemin="0" aria-valuemax="100" style="width:40%">-->
<!--                                40%-->
<!--                            </div>-->
<!--                        </div>-->
                    </b-list-group-item>
                </b-list-group>
                <b-button v-on:click="nextQuestion" variant="success">
                    Next Question
                </b-button>
            </b-jumbotron>
        </div>
        <div v-else>
            <b-jumbotron>
                <h3>Room ID: {{roomObj.id}}</h3>
            </b-jumbotron>
            <b-card bg-variant="light" header="Begin Quiz?" class="text-center">
                <b-card-text>There are currently {{members}} people in the room.</b-card-text>
                <b-card-text>Press the button below to begin</b-card-text>
                <b-button variant="primary" v-on:click="beginQuiz">Begin Quiz</b-button>
            </b-card>
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
            members: 2,
        }
    },
    methods: {
        beginQuiz() {
            this.active = true;
            this.postQuestion();
            setInterval(this.fetchResponses, 2000);
        },
        fetchResponses() {
            axios.get('/api/quiz/response/'+this.roomObj.id).then(response => {
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
                console.log(response);
            }).catch(error => {
                console.log(error);
            });
        }
    },
    computed: {
        currentQuestion: function() {
            return this.questionsObj[this.questionIndex];
        }
    },
    created() {
        let questions = JSON.parse(this.questions);
        this.questionsObj = questions.questions;
        this.roomObj = JSON.parse(this.room);
    },
}
</script>

<style scoped>

</style>
