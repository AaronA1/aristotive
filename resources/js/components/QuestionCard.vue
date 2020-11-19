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

            <b-button v-on:click="$emit('prev-question')" variant="primary">
                Previous
            </b-button>
            <b-button v-on:click="$emit('next-question')" variant="success">
                Next
            </b-button>
        </b-jumbotron>
    </div>
</template>

<script>
import _ from 'lodash'
export default {
    props: ['question'],
    data: function() {
        return {
            selectedAnswer: null,
            correctAnswer: this.question.answer,
            shuffledOptions: [],
            answered: false
        }
    },
    updated() {
        console.log(this.selectedAnswer);
    },
    watch: {
        currentQuestion: {
            immediate: true,
            handler() {
                this.selectedAnswer = null
                this.answered = false
                this.shuffleOptions()
            }
        }
    },
    methods: {
        selectAnswer(option) {
            this.selectedAnswer = option
        },
        submitAnswer() {
            let isCorrect = false
            if (this.selectedAnswer === this.correctAnswer) {
                isCorrect = true
            }
            this.answered = true
        },
        shuffleOptions() {
            let options = this.question.options
            this.shuffledOptions = _.shuffle(options)
            console.log(this.shuffledOptions);
        },
        answerClass(option) {
            let answerClass = ''
            if (!this.answered && this.selectedAnswer === option) {
                answerClass = 'selected'
            }
            return answerClass
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
.correct {
    background-color: lightgreen;
}
.incorrect {
    background-color: red;
}
</style>
