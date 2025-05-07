<script setup>
import { computed,reactive  } from 'vue';
import UserLayouts from './Layouts/UserLayouts.vue';

import { router, usePage } from '@inertiajs/vue3';

defineProps({
    userAddress: Object
})

const carts = computed(() => usePage().props.cart.data.items)
const products = computed(() => usePage().props.cart.data.products)

const total = computed(() => usePage().props.cart.data.total)

const itemId = (id) => carts.value.findIndex((item) => item.product_id === id);


const form = reactive({
    address1: null,
    state: null,
    city: null,
    zipcode: null,
    country_code: null,
    type: null,

})


const formFilled = computed(()=>{
   return (form.address1 !== null &&
    form.state !== null &&
    form.city !== null &&
    form.zipcode !== null &&
    form.country_code !== null &&
    form.type !== null )
})

const update = (product, quantity) =>
    router.patch(route('cart.update', product), {
        quantity,
    });


//remove form cart 
const remove = (product) => router.delete(route('cart.delete', product));


// confirm order

function submit(){
    router.visit(route('checkout.store'), {
        method: 'post',
        data: {
            carts: usePage().props.cart.data.items,
            products: usePage().props.cart.data.products,
            total: usePage().props.cart.data.total,
            address: form
        }
    })

}

</script>

<template>
    <UserLayouts>
        <section class="text-gray-600 body-font relative">
            <div class="container px-5 mx-auto flex sm:flex-nowrap flex-wrap ">
                <div class="lg:w-2/3 md:w-1/2 pb-16  rounded-lg  sm:mr-10 p-10  ">
                    <!---Cart list Productg --->
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50  dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-16 py-3">
                                    Image
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Qty
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in products" :key="product.id"
                                class="bg-white border-b  border-gray-200 hover:bg-gray-50">
                                <td class="p-4">
                                    <img v-if="product.product_images.length > 0"
                                        :src="`/${product.product_images[0].image}`"
                                        class="w-10 md:w-20 h-20 max-w-full max-h-full" alt="Apple Watch">

                                    <img v-else class="w-10 md:w-20 h-20 max-w-full max-h-full"
                                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png"
                                        alt="Apple Watch">
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-500 dark:text-dark">
                                    {{ product.title }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <button @click.prevent="update(product, carts[itemId(product.id)].quantity - 1)"
                                            :disabled="carts[itemId(product.id)].quantity <= 1"
                                            :class="[carts[itemId(product.id)].quantity > 1 ? 'cursor-pointer text-purple-600' : 'cursor-not-allowed text-gray-300 dark:text-gray-500', 'inline-flex items-center justify-center p-1 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200  dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700']"
                                            type="button">
                                            <span class="sr-only">Quantity button</span>
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 18 2">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                            </svg>
                                        </button>
                                        <div>
                                            <input type="number" id="first_product"
                                                v-model="carts[itemId(product.id)].quantity"
                                                class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1  dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="1" required />
                                        </div>
                                        <button @click.prevent="update(product, carts[itemId(product.id)].quantity + 1)"
                                            class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200  dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                            type="button">
                                            <span class="sr-only">Quantity button</span>
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 18 18">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-600 dark:text-dark">
                                    ${{ product.price }}
                                </td>
                                <td class="px-6 py-4">
                                    <button @click="remove(product)"
                                        class="font-medium text-red-600 dark:text-red-500 ">Remove</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>
                <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Summary</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">Total : $ 344</p>

                    <div v-if="userAddress">
                        <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Shipping Address</h2>
                        <p class="leading-relaxed mb-5 text-gray-600">{{ userAddress.address1 }} , {{ userAddress.city }}, {{
                            userAddress.zipcode }}</p>
                        <p class="leading-relaxed mb-5 text-gray-600">or you can add new below</p>

                    </div>

                  <div v-else>
                    <p class="leading-relaxed mb-5 text-gray-600"> Add shipping address to continue</p>
                  </div>



                    <form @submit.prevent="submit">
                        <div class="relative mb-4">
                            <label for="name" class="leading-7 text-sm text-gray-600">Address 1</label>
                            <input type="text" id="name" name="address1" v-model="form.address1"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="email" class="leading-7 text-sm text-gray-600">City</label>
                            <input type="text" id="email" name="city"  v-model="form.city"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="email" class="leading-7 text-sm text-gray-600">State</label>
                            <input type="text" id="email" name="state"  v-model="form.state"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="email" class="leading-7 text-sm text-gray-600">Zipcode</label>
                            <input type="text" id="email" name="zipcode"  v-model="form.zipcode"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="email" class="leading-7 text-sm text-gray-600">Country Code</label>
                            <input type="text" id="email" name="countrycode"  v-model="form.country_code"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="email" class="leading-7 text-sm text-gray-600">Address type</label>
                            <input type="text" id="email" name="type" v-model="form.type"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>



                        <button v-if="formFilled || userAddress" type="submit"
                            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Checkout</button>

                        <button v-else type="submit"
                            class="text-white bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:bg-gray-600 rounded text-lg">Add
                            Address to continue</button>

                    </form>
                    <p class="text-xs text-gray-500 mt-3">Continue Shopping </p>

                </div>
            </div>
        </section>
    </UserLayouts>
</template>