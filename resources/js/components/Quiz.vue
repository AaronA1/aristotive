<template>
    <div id="quiz">
        <b-container class="bv-example-row">
            <b-row>
                <b-col sm="6" offset="3">
                    <question-card v-if="questionsobj.length" :currentQuestion="questionsobj[index]" :question="questionsobj[index]"
                    v-on:next-question="next()" v-on:prev-question="previous()"></question-card>
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
            questionsobj: null,
        }
    },
    methods: {
        next() {
            if(this.index !== this.questionsobj.length-1) {
                this.index++
            }
        },
        previous() {
            if(this.index !== 0) {
                this.index--
            }
        }
    },
    created() {
        this.questionsobj = JSON.parse(this.questions);
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
