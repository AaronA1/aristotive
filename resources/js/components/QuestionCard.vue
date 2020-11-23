<template>
    <div class="question-box-container">
        <b-jumbotron>
            <template slot="lead">
                {{ question.question }}
            </template>

            <hr class="my-4" />

            <b-list-group>
                <b-list-group-item
                    v-for="(option) in question.options"
                    :key="option"
                    @click.prevent="selectAnswer(option)"
                    :class="answerClass(option)"
                >
                    {{ option }}
                </b-list-group-item>
            </b-list-group>
            <b-button v-if="this.localIndex < length" v-on:click="$emit('next-question', selectedAnswer); nextQuestion()" variant="success">
                Next
            </b-button>
            <b-button v-else v-on:click="$emit('complete-quiz', selectedAnswer)" variant="success">
                Finish
            </b-button>
        </b-jumbotron>
    </div>
</template>

<script>
import _ from 'lodash'
export default {
    props: ['question', 'length'],
    data: function() {
        return {
            selectedAnswer: null,
            shuffledOptions: [],
            localIndex: 1,
        }
    },
    methods: {
        selectAnswer(option) {
            this.selectedAnswer = option;
            console.log(this.selectedAnswer);
        },
        shuffleOptions() {
            let options = this.question.options
            this.shuffledOptions = _.shuffle(options)
        },
        answerClass(option) {
            let answerClass = ''
            if (this.selectedAnswer === option) {
                answerClass = 'selected'
            }
            return answerClass
        },
        nextQuestion() {
            if(this.selectedAnswer !== null) {
                this.localIndex++
                console.log(this.localIndex);
            }
        }
    }
}
</script>

<style scoped>
.list-group {
    margin-bottom: 15px;
}
.list-group-item:hover {
    background: #EEE;
    cursor: pointer;
}
.btn {
    margin: 0 5px;
}
.selected {
    background-color: lightblue;
}
</style>
