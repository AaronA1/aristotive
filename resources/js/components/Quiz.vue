<template>
    <div id="quiz">
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
</template>

<script>
export default {
    name: 'Quiz',
    props: ['questions'],
    data() {
        return {
            index: 0,
            questionsObject: null,
            answers: []
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
                console.log(this.answers);
            }
        },
        completeQuiz(answer) {
            if(answer === null) {
                return;
            }
            this.answers.push(answer)
            console.log(this.answers);
            console.log('Quiz completed');
        }
        // previous() {
        //     if(this.index !== 0) {
        //         this.index--
        //     }
        // }
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
