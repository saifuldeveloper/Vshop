<script setup>
import { onMounted } from 'vue'
import Navbar from './Navbar.vue'
import Sidebar from './Sidebar.vue'

</script>


<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <!---Navbar Start-->
        <Navbar />
        <!--Navbar End-->

        <!-- Sidebar  start-->

        <sidebar />
        <!----Sidebar End-->

        <!----main Section Start-->

        <slot />

        <!-- Main Section End -->
    </div>
</template>