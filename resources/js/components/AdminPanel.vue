<template>
    <div class="container">
        <div class="question-box-container">
            <b-jumbotron>
                <template slot="lead">
                    This is the question
                </template>
                <b-list-group>
                    <b-list-group-item v-for="response in responses" :key="response.response">
                        {{response.response}}
<!--                        <div class="progress">-->
<!--                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40"-->
<!--                                 aria-valuemin="0" aria-valuemax="100" style="width:40%">-->
<!--                                40%-->
<!--                            </div>-->
<!--                        </div>-->
                    </b-list-group-item>
                </b-list-group>
            </b-jumbotron>
        </div>
    </div>
</template>

<script>
export default {
    props: ['roomid', 'questions'],
    data() {
        return {
            responses: [],
            questionIndex: 0,
        }
    },
    methods: {
        fetchResponses() {
            axios.get('/api/quiz/response/'+this.roomid).then(response => {
                this.responses = response.data;
            }).catch(error => {
                console.log(error);
            });
        },
        nextQuestion() {
            axios.post('/api/quiz/question')
        }
    },
    mounted() {
        setInterval(this.fetchResponses, 2000);
    }
}
</script>

<style scoped>

</style>
