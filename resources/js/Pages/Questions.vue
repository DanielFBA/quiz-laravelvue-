<script setup>
import Layout from "@/Shared/Layout.vue";
import NewQuestionModal from "@/Shared/NewQuestionModal.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
const showNewQuestionModal = ref(false);
const createdQuestion = ref(null);
const newAnswers = ref([]);
const selectedAnswer = ref(null);
let answerId = 1;

function createQuestion() {
    showNewQuestionModal.value = true;
}
function destroyModal() {
    showNewQuestionModal.value = false;
}

function addNewAnswer() {
    const newAnswer = {
        id: answerId++,
        answer: "",
        correct_answer: 0,
    };
    newAnswers.value.push(newAnswer);
}

function handleRadioToggle(Id) {
    selectedAnswer.value = Id;
    newAnswers.value.forEach((answer) => {
        if (answer.id === Id) {
            answer.correct_answer = 1;
        } else {
            answer.correct_answer = 0;
        }
    });
}

function validateAnswer() {
    for(const answer of newAnswers.value) {
        if(answer.answer.trim()===''){
            return false;
        }
    }
    return true;
}


function submitQuestion() {
    if (!createdQuestion.value) {
        alert("Question cannot be empty");
        return false;
    }else if(!validateAnswer()){
        alert("Answer cannot be empty");
        return false;
    }
    router.post('/questions', {
        question: createdQuestion.value,
        answers: newAnswers.value
    })
}
</script>
<template>
    <Layout>
        <button @click="createQuestion" class="btn btn-success">Create</button>
        <table class="table table-striped"></table>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
            </tbody>
        </table>

        <Teleport to="body">
            <NewQuestionModal
                :show="showNewQuestionModal"
                @close="destroyModal"
            >
                <template #header>
                    <h5>Add New Question</h5>
                </template>
                <template #body>
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label"
                                >Question</label
                            >
                            <input
                                type="text"
                                v-model="createdQuestion"
                                class="form-control"
                                id="exampleInputEmail1"
                                aria-describedby="emailHelp"
                            />
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Answer</th>
                                    <th scope="col">Correct?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(answer, index) in newAnswers">
                                    <th scope="row">{{ answer.id }}</th>
                                    <td>
                                        <input
                                            type="text"
                                            v-model="answer.answer"
                                            class="form-control"
                                            id="exampleInputEmail1"
                                            aria-describedby="emailHelp"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            :checked="
                                                answer.correct_answer == 1
                                            "
                                            class="form-check-imput"
                                            :value="answer.id"
                                            @change="
                                                handleRadioToggle(answer.id)
                                            "
                                            type="radio"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </template>
                <template #footer>
                    <span @click="addNewAnswer" v-if="newAnswers.length < 4"
                        ><h3>+</h3></span
                    >
                    <button @click="destroyModal" class="btn btn-danger">
                        Close
                    </button>
                    <button
                        class="btn btn-success"
                        @click="submitQuestion"
                        v-if="newAnswers.length == 4"
                    >
                        Submit
                    </button>
                </template>
            </NewQuestionModal>
        </Teleport>
    </Layout>
</template>
