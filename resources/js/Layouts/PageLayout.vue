<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import FlashMessage from '@/Components/FlashMessage.vue'

const props = defineProps({
    title: {
        type: String,
        default: '',
    },
})
</script>

<template>
    <Head :title="props.title" />
    

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <FlashMessage />
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
