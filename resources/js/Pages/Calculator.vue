<script setup>
import {Head, Link} from '@inertiajs/vue3';
import {onMounted, ref} from "vue";

const display = ref('');
const calculations = ref([]);

const add = (value) => {
    display.value += value;
};

const clear = () => {
    display.value = '';
};

const calculate = () => {
    axios.post('api/calculator/calculate', {expression: display.value})
        .then(response => {
            display.value = response.data.data.result;

            history();
        })
        .catch(error => {
            if (error.response.status === 422) {
                display.value = error.response.data.errors.expression[0];
                return;
            }

            display.value = error.response.data.error;
        });
};

const history = () => {
    axios.get('api/calculator/history')
        .then(response => {
            calculations.value = response.data.data;
        })
        .catch(error => {
            console.log(error);
        });
};

const deleteHistory = (id) => {
    axios.delete(`api/calculator/history/${id}`)
        .then(response => {
            history();
        })
        .catch(error => {
            console.log(error);
        });
};

const clearHistory = () => {
    axios.delete('api/calculator/history')
        .then(response => {
            calculations.value = [];
        })
        .catch(error => {
            console.log(error);
        });
};

onMounted(() => {
    history();
});

</script>

<template>
    <Head title="Welcome"/>
    <div class="bg-gray-50 text-black/50 py-16">
        <div class="container mx-auto mb-16">
            <h1 class="text-4xl font-bold text-center">CalcTek</h1>
        </div>
        <div class="min-h-screen flex flex-row items-start justify-center selection:text-white">
            <div class="w-full max-w-2xl px-6">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <input class="text-right text-4xl mb-4 p-8 bg-gray-200 rounded w-full" v-model="display"/>
                    <div class="grid grid-cols-4 gap-4">
                        <button class="button hover:bg-gray-50" @click="add('7')">7</button>
                        <button class="button hover:bg-gray-50" @click="add('8')">8</button>
                        <button class="button hover:bg-gray-50" @click="add('9')">9</button>
                        <button class="button hover:bg-gray-50" @click="add('/')">/</button>
                        <button class="button hover:bg-gray-50" @click="add('4')">4</button>
                        <button class="button hover:bg-gray-50" @click="add('5')">5</button>
                        <button class="button hover:bg-gray-50" @click="add('6')">6</button>
                        <button class="button hover:bg-gray-50" @click="add('*')">*</button>
                        <button class="button hover:bg-gray-50" @click="add('1')">1</button>
                        <button class="button hover:bg-gray-50" @click="add('2')">2</button>
                        <button class="button hover:bg-gray-50" @click="add('3')">3</button>
                        <button class="button hover:bg-gray-50" @click="add('-')">-</button>
                        <button class="button hover:bg-gray-50" @click="add('0')">0</button>
                        <button class="button hover:bg-gray-50" @click="add('.')">.</button>
                        <button class="button hover:bg-gray-50" @click="clear()">C</button>
                        <button class="button hover:bg-gray-50" @click="add('+')">+</button>
                        <button class="button hover:bg-gray-50" @click="add('sqrt(')">sqrt(</button>
                        <button class="button hover:bg-gray-50" @click="add('^')">^</button>
                        <button class="button hover:bg-gray-50" @click="add('(')">(</button>
                        <button class="button hover:bg-gray-50" @click="add(')')">)</button>
                    </div>
                    <div class="flex mx-auto mt-12 max-w-sm">
                        <button class="button bg-green-500 p-2 rounded-md text-white w-full" @click="calculate()">=
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-2xl p-6 bg-white shadow-md rounded-lg">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">History</h2>
                    <button class="rounded-md text-red underline" @click="clearHistory()">Clear history</button>
                </div>
                <ul class="mt-4">
                    <li v-for="calculation in calculations" :key="calculation.id"
                        class="relative bg-white p-4 rounded-lg shadow mb-4">
                        <p class="text-lg font-bold">Expression: {{ calculation.expression }}</p>
                        <p class="text-xl">Result: {{ calculation.result }}</p>
                        <button @click="deleteHistory(calculation.id)"
                                class="absolute top-5 right-5 button bg-red-500 p-2 rounded-md text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </button>
                    </li>
                    <li v-if="!calculations.length">No calculations yet</li>
                </ul>
            </div>
        </div>
    </div>
</template>
