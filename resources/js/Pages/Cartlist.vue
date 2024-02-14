<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, usePage } from "@inertiajs/vue3";
import { onMounted, computed } from "vue";
import { initFlowbite } from "flowbite";
import Productlist from "@/Pages/Productlist.vue";

const products = computed(() => usePage().props.cartItems);
const product1 = computed(() => usePage().props.product);
const product2 = computed(() => usePage().props.CartItems);
console.log(products);

const itemId = (id) =>
    cartItems.findIndex((item) => cartItems.product_id === id);

const update = (product, qty) => {
    console.log(product);
    router.patch(route("cart.update", product), { qty });
};

const remove = (product) => router.delete(route("cart.delete", product));

const totalPrice = computed(() => {
    return products.value
        .reduce((total, product) => {
            return total + product.itemqty * parseFloat(product.price);
        }, 0)
        .toFixed(2);
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Cart
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- cartlist -->
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Image</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Product
                                    </th>
                                    <th scope="col" class="px-6 py-3">Qty</th>
                                    <th scope="col" class="px-6 py-3">Price</th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="product in products"
                                    :key="product.id"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <td class="p-4">
                                        <img
                                            v-if="product.image.length > 0"
                                            :src="product.image"
                                            :alt="product.image"
                                            class="w-16 md:w-32 max-w-full max-h-full"
                                        />
                                        <img
                                            v-else
                                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png?20200912122019 "
                                            class="w-16 md:w-32 max-w-full max-h-full"
                                        />
                                    </td>
                                    <td
                                        class="px-6 py-4 font-semibold text-gray-900 dark:text-white"
                                    >
                                        {{ product.title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <button
                                                @click.prevent="
                                                    update(
                                                        product,
                                                        product.itemqty - 1
                                                    )
                                                "
                                                :disabled="product.itemqty <= 1"
                                                class="inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                                type="button"
                                            >
                                                <span class="sr-only"
                                                    >Quantity button</span
                                                >
                                                <svg
                                                    class="w-3 h-3"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 18 2"
                                                >
                                                    <path
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M1 1h16"
                                                    />
                                                </svg>
                                            </button>
                                            <div>
                                                <input
                                                    type="number"
                                                    id="first_product"
                                                    v-model="product.itemqty"
                                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="1"
                                                    required
                                                />
                                            </div>
                                            <button
                                                @click.prevent="
                                                    update(
                                                        product,
                                                        product.itemqty + 1
                                                    )
                                                "
                                                class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                                type="button"
                                            >
                                                <span class="sr-only"
                                                    >Quantity button</span
                                                >
                                                <svg
                                                    class="w-3 h-3"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 18 18"
                                                >
                                                    <path
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 1v16M1 9h16"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 font-semibold text-gray-900 dark:text-white"
                                    >
                                        {{ product.price }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a
                                            @click="remove(product)"
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline"
                                            >Remove</a
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="flex justify-end mt-4">
                            <span
                                class="text-lg font-semibold text-gray-900 dark:text-white"
                            >
                                Total: RM{{ totalPrice }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
