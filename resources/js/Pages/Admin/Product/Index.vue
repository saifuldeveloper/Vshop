 <script setup>
 import AdminLayout from '../Components/AdminLayout.vue';
 import ProductList from './ProductList.vue';

 defineProps({
    products:{
          type: Object,
           required: true
    },
 })


  
</script>

<template>

    <AdminLayout>
        <ProductList :products ="products" />
      
    </AdminLayout>
     
</template>