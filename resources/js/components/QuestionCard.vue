<template>
    <div class="question-box-container">
        <b-jumbotron>
            <template slot="lead">
                {{ question.question }}
            </template>

            <hr class="my-4" />

            <div v-if="questionType === 'multi-choice'">
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
                <b-button v-on:click="$emit('submit', selectedAnswer)" variant="success">
                    Submit
                </b-button>
            </div>
            <div v-if="questionType === 'input'">
                <div id="inputBox">
                <b-form-input v-model="input"></b-form-input>
                </div>
                <b-button v-on:click="$emit('submit', input)" variant="success">
                    Submit
                </b-button>
            </div>
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
            input: null,
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
    },
    computed: {
        questionType: function () {
            return this.question.type;
        }
    }
}
</script>

<style scoped>
.list-group {
    margin-bottom: 40px;
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
#inputBox {
    padding-bottom: 40px;
}
</style>
