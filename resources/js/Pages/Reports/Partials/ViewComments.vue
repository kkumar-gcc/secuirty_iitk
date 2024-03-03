<script setup>
import CreateCommentForm from "@/Pages/Reports/Partials/CreateCommentForm.vue";
import Paginator from "@/Components/Paginator.vue";
import Avatar from "@/Components/Avatar.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DeleteCommentForm from "@/Pages/Reports/Partials/DeleteCommentForm.vue";
import UpdateCommentForm from "@/Pages/Reports/Partials/UpdateCommentForm.vue";
import formatDate from "../../../Compositions/DateTime.js";
import {inject} from "vue";

const props = defineProps({
    report: {
        type: Object,
    },
    comments: {
        type: Object,
    }
})

const can = inject('can')
const showDropdown = () => {
    return can('edit own comments | edit all comments | delete own comments | delete all comments');
};

const canEditComment = () => {
    return can('edit own comments | edit all comments');
};

const canDeleteComment = () => {
    return can('delete own comments | delete all comments');
};

const getUserInitials = (userName) => {
    return userName.substring(0, 2).toUpperCase();
};
</script>

<template>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Comments ({{comments.total}})</h2>
    <div class="py-4">
        <CreateCommentForm :report="report"/>

        <div class="mt-4 space-y-4">
            <div
                v-for="comment in comments.data"
                :key="comment.id"
                class="p-4 border border-gray-200 rounded-lg shadow-sm"
            >
                <!-- Comment header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <Avatar :user="comment.user" />
                        <div class="font-medium">
                            <span>{{ comment.user.name }}</span>
                            <div class="text-sm text-gray-500">{{ formatDate(comment.created_at, true) }}</div>
                        </div>
                    </div>
                    <!-- Dropdown for edit and delete options -->
                    <div v-if="showDropdown()">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-500 bg-white border border-gray-300 rounded-full hover:text-gray-700 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200">
                                    {{ getUserInitials(comment.user.name) }}
                                </button>
                            </template>
                            <template #content>
                                <UpdateCommentForm v-if="canEditComment()" :comment="comment" />
                                <DeleteCommentForm v-if="canDeleteComment()" :comment="comment" />
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Comment body -->
                <div class="mt-2 prose max-w-none sm:max-w-full prose-img:rounded-xl prose-a:text-rose-600">{{ comment.body }}</div>
            </div>
            <!-- Paginator for comment pagination -->
            <Paginator :paginator="comments" />
        </div>
    </div>
</template>
