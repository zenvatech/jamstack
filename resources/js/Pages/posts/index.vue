<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Blog
            </h2>
        </template>

        <div class="py-12">
            <div class="container mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-xl w-full sm:rounded-lg flex gap-4 p-2 mb-6">
                    <Dropdown align="left" width="60">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                    Categries

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <div class="w-60">
                                <!-- Categories -->
                                <DropdownLink :href="route(route().current(), { _query: { category: null } })">
                                All
                                </DropdownLink>
                                <DropdownLink :href="route(route().current(), { _query: { q: route().params.q, category: category.slug } })" v-for="category in categories">
                                    {{ category.name }}
                                </DropdownLink>
                            </div>
                        </template>
                    </Dropdown>

                    <Dropdown align="left" width="60">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                    Filter by

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <div class="w-60">
                                <!-- Categories -->
                                <DropdownLink :href="route(route().current(), { _query: { ...route().params, order: 'desc' } })">
                                Latest first
                                </DropdownLink>
                                <DropdownLink :href="route(route().current(), { _query: { ...route().params, order: 'asc' } })">
                                Oldest First
                                </DropdownLink>
                            </div>
                        </template>
                    </Dropdown>

                    <form @submit.prevent="router.get(route(route().current()), { q: q }, { preserveState: true })">
                        <TextInput type="search" placeholder="Search a post" v-model="q" />
                    </form>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl w-full sm:rounded-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                        <div class="rounded p-4 dark:text-white cursor-pointer" v-for="post in posts.data" @click="router.visit(route( 'blog.post.show', { post } ))">
                            <div class="bg-gray-400 aspect-[4/3]  rounded-lg overflow-hidden">
                                <img :src="post.thumbnail" :alt="post.title" class="w-full h-full object-cover object-center" />
                            </div>

                            <div class="px-2 flex flex-col mt-4">
                                <span class="ml-auto rounded-full px-3 bg-indigo-500">{{ post.category.name }}</span>
                                <h3 class="text-lg">
                                    {{ post?.excerpt }}
                                </h3>

                                <span class="ml-auto text-indigo-500">{{ dayjs(post.created_at).from() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl w-full sm:rounded-lg flex gap-4 mt-4 p-4 justify-end">
                    <Link :href="link.url" :preserveState="true" :class="['p-2 font-bold', { 'text-indigo-500': link.active && link.url, 'text-white': link.url && !link.active, 'text-gray-500 cursor-not-allowed': !link.url } ]" :disabled="!link.url" v-for="link in posts.links" v-html="link.label" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import TextInput from '@/Components/TextInput.vue'
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'

dayjs.extend(relativeTime)

defineProps({
  posts: Array,
  categories: Array
})

const q = ref(route().params.q ?? '')
</script>

<style scoped>

</style>
