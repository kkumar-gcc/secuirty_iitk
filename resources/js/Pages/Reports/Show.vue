<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import DeleteReportForm from "@/Pages/Reports/Partials/DeleteReportForm.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DownloadReport from "@/Pages/Reports/Partials/DownloadReport.vue";
import Tag from "@/Components/Tag.vue";
import CreateRemarkForm from "@/Pages/Reports/Partials/CreateRemarkForm.vue";
import ViewRemarks from "@/Pages/Reports/Partials/ViewRemarks.vue";
import ViewComments from "@/Pages/Reports/Partials/ViewComments.vue";

defineProps({
    report: Object,
    remarks: Object,
    comments: Object,
});

const form = useForm({});

const approveReport = async (reportId) => {
    if (confirm('Are you sure you want to approve this report?')) {
        form.post(route('reports.approveOne', reportId), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onFinish: () => form.reset(),
        });
    }
}

const displayFields = [
    {key: 'serial_number', label: 'Serial Number', inline: true},
    {key: 'description', label: 'Description', inline: false},
    {key: 'reporter', label: 'Reporter', inline: true},
    {key: 'status', label: 'Status', inline: true},
    {key: 'shift', label: 'Shift', inline: true},
    {key: 'venue', label: 'Venue', inline: true},
    {key: 'tags', label: 'Tags', inline: false},
    {key: 'attachments', label: 'Attachments', inline: false},
];

const getHeadingClass = (inline) => {
    return inline ? 'inline-block mr-2' : '';
};

</script>

<template>
    <Head :title="report.serial_number"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row">
                <Tag v-if="report.approved" class="ml-2 bg-green-100 text-green-800 border-green-400 hover:border-green-600"
                     value="Approved"/>
                <div class="flex-1 flex justify-end">
                    <CreateRemarkForm v-if="can('create remarks')" :key="report.id" :report="report" class="ml-2"/>
                    <DownloadReport :key="report.id" :report="report">Download</DownloadReport>
                    <SecondaryButton v-if="can('approve reports') && !report.approved" class="ml-2"
                                     @click="approveReport(report.id)">Approve
                    </SecondaryButton>
                    <SecondaryButton v-if="can('edit own reports | edit all reports') && !report.approved"
                                     :href="route('reports.edit', report.id)" class="ml-2">Edit Report
                    </SecondaryButton>
                    <DeleteReportForm v-if="can('delete own reports | delete all reports') && !report.approved"
                                      :key="report.id" :report="report" class="ml-2"/>
                </div>
            </div>
        </template>

        <div
            class="relative prose max-w-none lg:max-w-full xl:max-w-none prose-img:rounded-xl prose-img:w-full mx-auto prose-a:no-underline prose-a:text-rose-600 prose-table p-4 sm:p-8 bg-white">
            <template v-for="field in displayFields" :key="field.key">
                <div class="mb-1">
                    <h3 :class="getHeadingClass(field.inline)">{{ field.label }} {{ field.inline ? ':' : '' }}</h3>
                    <template v-if="field.key === 'tags'">
                        <div class="flex space-x-2">
                            <template v-for="tag in report[field.key]">
                                <Tag :value="tag.title"/>
                            </template>
                        </div>
                    </template>
                    <template v-else-if="field.key === 'attachments' && report[field.key].length > 0"
                              class="grid grid-cols-3 gap-4">
                        <div class="grid grid-cols-3 gap-4">
                            <template v-for="attachment in report[field.key]">
                                <div class="border shadow-sm rounded-lg bg-white">
                                    <img :alt="'preview of '+attachment.name" :src="attachment.path"
                                         class="w-full h-32 object-cover"/>
                                    <div class="p-4 border-t">
                                        <h2 class="text-base font-medium text-gray-900">{{ attachment.name }}</h2>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template v-else>
                        <span>{{ report[field.key] }}</span>
                    </template>
                </div>
            </template>
            <ViewRemarks v-if="remarks.data && remarks.data.length > 0" :remarks="remarks" class="py-4"/>
            <ViewComments :comments="comments" :report="report" class="py-4"/>
        </div>
    </AuthenticatedLayout>
</template>

