<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const props = defineProps({
    placeholder: {
        type: String,
    },
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="block w-full rounded-md px-3 py-2.5 shadow-xs border-gray-300 placeholder:text-body"
        v-model="model"
        ref="input" 
        :placeholder="placeholder"
    />
</template>
