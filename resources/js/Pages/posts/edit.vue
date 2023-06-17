<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Post
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
                <FormSection @submitted="updatePost">
                    <template #title>
                        Post Info
                    </template>

                    <template #description>
                        The post informations
                    </template>

                    <template #form>
                        <!-- Team Owner Information -->
                        <div class="col-span-6">
                            <InputLabel value="Post Author" />

                            <div class="flex items-center mt-2">
                                <img class="w-12 h-12 rounded-full object-cover" :src="post.author.profile_photo_url" :alt="post.author.name">

                                <div class="ml-4 leading-tight">
                                    <div class="text-gray-900 dark:text-white">{{ post.author.name }}</div>
                                    <div class="text-gray-700 dark:text-gray-300 text-sm">
                                        {{ post.author.email }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Team Name -->
                        <div class="col-span-6 sm:col-span-12">
                            <InputLabel for="name" value="Post Title" />

                            <TextInput
                                id="name"
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full"
                                :disabled="!canEditPost"
                            />

                            <InputError :message="form.errors.title" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-12">
                            <InputLabel for="name" value="Post Excerpt" />

                            <TextInput
                                id="name"
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full"
                                :disabled="!canEditPost"
                            />

                            <InputError :message="form.errors.excerpt" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-12">
                            <InputLabel for="name" value="Post Body" />

                            <TextArea
                                id="body"
                                v-model="form.body"
                                type="text"
                                class="mt-1 block w-full"
                                :disabled="!canEditPost"
                            />

                            <InputError :message="form.errors.body" class="mt-2" />
                        </div>
                    </template>

                    <template v-if="canEditPost" #actions>
                        <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                            Saved.
                        </ActionMessage>

                        <DangerButton :class="{ 'opacity-25': form.processing || confirmingPostDeletion }" :disabled="form.processing || confirmingPostDeletion" @click="confirmPostDeletion">
                            Delete Post
                        </DangerButton>

                        <PrimaryButton :class="[ 'ml-6', { 'opacity-25': form.processing || !form.isDirty } ]" :disabled="form.processing || !form.isDirty">
                            Update Post
                        </PrimaryButton>
                    </template>
                </FormSection>

                <FormSection>
                    <template #title>
                        Post Preview
                    </template>

                    <template #description>
                        Get live preview of your post
                    </template>

                    <template #form>
                        <div class="post-content col-span-full" v-html="preview"></div>
                    </template>
                </FormSection>
            </div>
        </div>

        <!-- Delete Team Confirmation Modal -->
        <ConfirmationModal :show="confirmingPostDeletion" @close="confirmingPostDeletion = false">
            <template #title>
                Delete Team
            </template>

            <template #content>
                Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <SecondaryButton @click="confirmingPostDeletion = false">
                    Cancel
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="deletePost"
                >
                    Delete Team
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>

<script setup lang="ts">
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { mdiPencil } from '@mdi/js'
    import { useForm } from '@inertiajs/vue3';
    import ActionMessage from '@/Components/ActionMessage.vue';
    import FormSection from '@/Components/FormSection.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import TextArea from '@/Components/TextArea.vue';
    import ConfirmationModal from '@/Components/ConfirmationModal.vue';
    import { marked } from 'marked';
    import { ref, computed } from 'vue'

    import {
        router
    } from '@inertiajs/vue3'

    const props = defineProps({
        post: Object,
        canEditPost: Boolean
    })

    const form = useForm({
        title: props.post.title,
        excerpt: props.post.excerpt,
        body: props.post.body
    })

    const preview = computed(() => marked(form.body))
    const confirmingPostDeletion = ref(false);

    const updatePost = () => {
        form.patch(route('blog.post.update', props.post.slug))
    }


    const confirmPostDeletion = () => {
        confirmingPostDeletion.value = true
    }

    const deletePost = () => {
        form.delete(route('blog.post.destroy', props.post.slug))
    }

</script>

<style scoped>

</style>
