<script setup>
import PageLayout from '@/Layouts/PageLayout.vue'
import Modal from '@/Components/Modal.vue'
import DangerButton from '@/Components/DangerButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import axios from 'axios'
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

function formatValidity(validity, validityType) {
    return `${validity} ${validityType}${validity > 1 ? 's' : ''}`;
}

const showDeleteModal = ref(false)
const membershipPlanToDelete = ref(null)
const deleteHeader = ref('Delete Membership Plan')
const deleteMessage = ref('Are you sure you want to delete this membership plan?')

function closeModal() {
    showDeleteModal.value = false
    // Set timeout to prevent name from disappearing before modal is closed
    setTimeout(() => {
        membershipPlanToDelete.value = null
    }, 200)
}

function deleteMembershipPlan(confirm = false) {
    router.delete(
        route('membership-plans.destroy', membershipPlanToDelete.value.id, { confirm }),
        {
            onSuccess: () => closeModal()
        }
    )
}

async function confirmDelete(plan) {
    membershipPlanToDelete.value = plan

    const response = await axios.get(
        `/membership-plans/${plan.id}/can-delete`
    )

    if (response.data.inUse) {
        deleteHeader.value = 'Force Delete Membership Plan'
        deleteMessage.value = 'This membership plan is currently in use. Are you sure you want to delete <strong>' + plan.name + '</strong>? This action cannot be undone.'
    } else {
        deleteHeader.value = 'Delete Membership Plan'
        deleteMessage.value = 'Are you sure you want to delete <strong>' + plan.name + '</strong>? This action cannot be undone.'
    }

    showDeleteModal.value = true
}

defineProps({
    membershipPlans: Array,
})
</script>
<template>
    <PageLayout title="Membership Plans">
        <div class="flex justify-between items-center bg-gray-100 p-4 rounded-t-md">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Membership Plans
            </h2>

            <Link
                href="/membership-plans/create"
                class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75"
            >
                <span class="md:hidden">+</span>
                <span class="hidden md:inline">New Plan</span>
            </Link>
        </div>
        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                    <tr>
                        <th scope="col" class="px-3 py-3 font-medium">
                            Name
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium hidden md:table-cell">
                            Validity
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium hidden md:table-cell">
                            Price
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium w-fit md:w-auto">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="membershipPlan in membershipPlans" :key="membershipPlan.id">
                        <td class="px-3 py-3">{{ membershipPlan.name }}</td>
                        <td class="px-3 py-3 hidden md:table-cell">{{ formatValidity(membershipPlan.validity, membershipPlan.validity_type) }}</td>
                        <td class="px-3 py-3 hidden md:table-cell">{{ membershipPlan.price }}</td>
                        <td class="px-3 py-3 w-fit md:w-auto">
                            <Link :href="`/membership-plans/${membershipPlan.id}/edit`"><span class="md:hidden">View/</span>Edit</Link>
                            |
                            <button
                                @click="confirmDelete(membershipPlan)"
                                class="text-red-600"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </PageLayout>
    <Modal
        :show="showDeleteModal"
        maxWidth="md"
        @close="closeModal"
    >
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ deleteHeader }}
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                <span v-html="deleteMessage"></span>
            </p>

            <div class="mt-6 flex justify-end space-x-3">
                <SecondaryButton @click="closeModal">
                    Cancel
                </SecondaryButton>

                <DangerButton @click="deleteMembershipPlan">
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>