<template>
    <div id="loading" v-if="this.loading">
        <b-container class="bv-example-row">
            <b-row>
                <b-col sm="12" offset="0">
                    <b-jumbotron>
                        <b-spinner style="width: 3rem; height: 3rem;" label="Large Spinner"></b-spinner>
                        Waiting on the next question
                    </b-jumbotron>
                </b-col>
            </b-row>
        </b-container>
    </div>
    <div id="quiz" v-else>
        <b-container class="bv-example-row">
            <b-row>
                <b-col sm="12" offset="0">
                    <question-card
                        :question="question"
                        v-on:submit="submitAnswer">
                    </question-card>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
export default {
    name: 'Quiz',
    props: ['roomid'],
    data() {
        return {
            loading: false,
            question: [],
        }
    },
    methods: {
        submitAnswer (answer) {
            if(answer === null) {
                return;
            }
            axios.post('/api/quiz/response', {questionId: this.question.id, answer: answer}).then(response => {
                this.loading = true;
            }).catch(error => {
                console.log(error);
            });
        },
        fetchQuestion() {
            axios.get('/api/quiz/question/'+this.roomid).then(response => {
                this.question = response.data;
                this.loading = false;
            }).catch(error => {
                console.log(error);
            });
        }
    },
    mounted() {
        this.fetchQuestion();
        // setInterval(this.fetchQuestion, 5000);
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
