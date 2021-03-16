<template>
    <div class="question-box-container">
        <b-jumbotron>
            <template slot="lead">
                {{ question.question }}
            </template>
            <img v-if="question.image" :src="'/'+question.image" alt="image" width="400px" height="200px">
            <hr class="my-4"/>
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
                <b-list-group>
                    <b-form-input v-model="input"></b-form-input>
                </b-list-group>
                <b-button v-on:click="$emit('submit', input)" variant="success">
                    Submit
                </b-button>
            </div>
            <div v-if="questionType === 'sortable'">
                <draggable class="list-group"
                           tag="ul"
                           v-model="question.options"
                           v-bind="dragOptions"
                           @start="drag=true"
                           @end="drag=false">
                    <transition-group type="transition">
                        <div class="list-group-item"
                             v-for="option in question.options"
                             :key="option">
                            {{ option }}
                        </div>
                    </transition-group>
                </draggable>
                <b-button v-on:click="$emit('submit', question.options)" variant="success">
                    Submit
                </b-button>
            </div>
            <div v-if="questionType === 'true-false'">
                <b-list-group>
                    <b-list-group-item
                        :key="'True'"
                        @click.prevent="selectAnswer('True')"
                        :class="answerClass('True')"
                    >True</b-list-group-item>
                    <b-list-group-item
                        :key="'False'"
                        @click.prevent="selectAnswer('False')"
                        :class="answerClass('False')"
                    >False</b-list-group-item>
                </b-list-group>
                <b-button v-on:click="$emit('submit', selectedAnswer)" variant="success">
                    Submit
                </b-button>
            </div>
        </b-jumbotron>
    </div>
</template>

<script>
import draggable from 'vuedraggable'

export default {
    props: ['question'],
    components: {
        draggable,
    },
    data: function () {
        return {
            selectedAnswer: null,
            input: null,
            sortArray: []
        }
    },
    methods: {
        selectAnswer(option) {
            this.selectedAnswer = option;
        },
        answerClass(option) {
            let answerClass = ''
            if (this.selectedAnswer === option) {
                answerClass = 'selected'
            }
            return answerClass
        }
    },
    computed: {
        questionType() {
            return this.question.type;
        },
        dragOptions() {
            return {
                animation: 200,
                group: "description",
                disabled: false,
                ghostClass: "ghost"
            };
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
.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}
</style>
