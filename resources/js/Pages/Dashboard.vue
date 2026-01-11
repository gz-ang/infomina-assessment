<script setup>
import PageLayout from '@/Layouts/PageLayout.vue'

const props = defineProps({
    recent_members: Object,
    plan_subscribers: Object,
    expiring_members: Object,
})

</script>
<template>
    <PageLayout title="Dashboard">
        <div class="p4 mb-4">
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded-t-md">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Membership Plan Subscriptions
                </h2>
            </div>
            <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                        <tr>
                            <th scope="col" class="font-bold w-1/3 md:w-1/2 px-3 py-3">
                                Plan Name
                            </th>
                            <th scope="col" class="font-bold md:w-1/4 px-3 py-3">
                                Active Subscribers
                            </th>
                            <th scope="col" class="font-bold md:w-1/4 px-3 py-3">
                                Total Subscribers
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="plan_subscribers.length > 0" v-for="plan in plan_subscribers" :key="plan.id">
                            <td class="px-3 py-3">{{ plan.name }}</td>
                            <td class="px-3 py-3">{{ plan.active_subscribers }}</td>
                            <td class="px-3 py-3">{{ plan.total_subscribers }}</td>
                        </tr>
                        <tr v-else>
                            <td colspan="3" class="px-3 py-3 text-center">No data available</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="w-full flex flex-col md:flex-row md:justify-between md:items-top p4 mb-4">
            <div class="w-full mb-4 md:mb-0 md:w-1/2 md:mr-2">
                <div class="flex justify-between items-center bg-gray-100 p-4 rounded-t-md">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    New Member
                </h2>
            </div>
            <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                        <tr>
                            <th scope="col" class="font-bold w-1/3 md:w-1/2 px-3 py-3">
                                Name
                            </th>
                            <th scope="col" class="font-bold md:w-1/4 px-3 py-3">
                                Plan Name
                            </th>
                            <th scope="col" class="font-bold md:w-1/4 px-3 py-3">
                                Date Joined
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="recent_members.length > 0" v-for="member in recent_members" :key="member.id">
                            <td class="px-3 py-3">{{ member.first_name + ' ' + member.last_name }}</td>
                            <td class="px-3 py-3">{{ member.membership_plan.name }}</td>
                            <td class="px-3 py-3">{{ member.start_date }}</td>
                        </tr>
                        <tr v-else>
                            <td colspan="3" class="px-3 py-3 text-center">No data available</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
            <div class="w-full md:w-1/2 md:ml-2">
                <div class="flex justify-between items-center bg-gray-100 p-4 rounded-t-md">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Expiring Members
                    </h2>
                </div>
                <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                            <tr>
                                <th scope="col" class="font-bold w-1/3 md:w-1/2 px-3 py-3">
                                    Name
                                </th>
                                <th scope="col" class="font-bold md:w-1/4 px-3 py-3">
                                    Plan Name
                                </th>
                                <th scope="col" class="font-bold md:w-1/4 px-3 py-3">
                                    Plan Expiry Date
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="expiring_members.length > 0" v-for="member in expiring_members" :key="member.id">
                                <td class="px-3 py-3">{{ member.first_name + ' ' + member.last_name }}</td>
                                <td class="px-3 py-3">{{ member.membership_plan.name }}</td>
                                <td class="px-3 py-3">{{ member.end_date }}</td>
                            </tr>
                            <tr v-else>
                                <td colspan="3" class="px-3 py-3 text-center">No data available</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </PageLayout>
</template>
