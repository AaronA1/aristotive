<template>
    <div id="content">
        <b-container class="bv-example-row">
            <b-row>
                <b-col sm="12" offset="0">
                    <b-jumbotron v-if="this.loading">
                        <b-spinner style="width: 4rem; height: 4rem;" label="Large Spinner"></b-spinner>
                        <h3>Waiting on the next question</h3>
                    </b-jumbotron>
                    <question-card v-else
                        :question="question"
                        v-on:submit="submitAnswer">
                    </question-card>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
import _ from "lodash";

export default {
    name: 'Quiz',
    props: ['roomid'],
    data() {
        return {
            loading: true,
            question: [],
        }
    },
    methods: {
        submitAnswer (answer) {
            if(answer === null) {
                return;
            }
            this.loading = true;
            axios.post('/api/quiz/response', {questionId: this.question.id, answer: answer}).then(response => {
            }).catch(error => {
                console.log(error);
            });
        },
        fetchQuestion() {
            axios.get('/api/quiz/question/'+this.roomid).then(response => {
                if (response.data.question === this.question.question) {

                } else {
                    // Shuffle the multiple choice options
                    if (response.data.options) {
                        response.data.options = this.shuffleOptions(response.data.options)
                    }
                    this.question = response.data;
                    this.loading = false;
                }
            }).catch(error => {
                console.log(error);
            });
        },
        shuffleOptions(options) {
            return _.shuffle(options);
        },
    },
    created() {
        // this.fetchQuestion();
        setInterval(this.fetchQuestion, 5000);
    }
}
</script>

<style>
#content {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}
</style>
