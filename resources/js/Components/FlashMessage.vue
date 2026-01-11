<script setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage()

</script>

<template>
    <div v-if="page.props.flash?.success" class="flex justify-between items-center mb-4 rounded bg-green-100 p-3 text-green-800 ml-2 mr-2 md:ml-0 md:mr-0">
        {{ page.props.flash.success }} <span @click="page.props.flash.success = null" class="ml-2 cursor-pointer">🗙</span>
    </div>
    <div v-if="page.props.flash?.error" class="flex justify-between items-center mb-4 rounded bg-red-100 p-3 text-red-800 ml-2 mr-2 md:ml-0 md:mr-0">
        {{ page.props.flash.error }} <span @click="page.props.flash.error = null" class="ml-2 cursor-pointer">🗙</span>
    </div>
</template> 