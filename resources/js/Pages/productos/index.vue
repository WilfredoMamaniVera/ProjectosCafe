<template>

    <Head title="Productos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Productos</h2>
                <Link :href="route('productos.create')">Crear Productos</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="relative overflow-x-auto">
                                    <table
                                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Producto Nombre</th>
                                                <th scope="col" class="px-6 py-3">Descripción</th>
                                                <th scope="col" class="px-6 py-3">Marca</th>
                                                <th scope="col" class="px-6 py-3">Precio</th>
                                                <th scope="col" class="px-6 py-3">Stock</th>
                                                <th scope="col" class="px-6 py-3">Categoría</th>
                                                <th scope="col" class="px-6 py-3">Imagen</th>
                                                <th scope="col" class="px-6 py-3">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="producto in productos" :key="producto.id"
                                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <td class="px-6 py-4">{{ producto.producto_nombre }}</td>
                                                <td class="px-6 py-4">{{ producto.descripcion }}</td>
                                                <td class="px-6 py-4">{{ producto.marca }}</td>
                                                <td class="px-6 py-4">{{ formatPrice(producto.precio) }}</td>
                                                <td class="px-6 py-4">{{ producto.stock }}</td>
                                                <td class="px-6 py-4">{{ producto.categoria ? producto.categoria.nombre
                                                    : 'N/A'
                                                    }}</td>
                                                <td class="px-6 py-4">
                                                    <img class="h-16" :src="`/storage/${producto.imagen}`" v-if="producto.imagen" />
                                                </td>

                                                <td class="px-6 py-4 flex space-x-4">
                                                    <Link :href="route('productos.edit', producto)"
                                                        class="text-blue-500 hover:underline">Editar</Link>
                                                    <Link @success="onDeleteSuccess"
                                                        :href="route('productos.destroy', producto)" method="delete"
                                                        as="button" class="text-red-500 hover:underline">Eliminar</Link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const productos = page.props.productos;

// Definir la función formatPrice
const formatPrice = (value) => {
    return new Intl.NumberFormat('es-BO', {
        style: 'currency',
        currency: 'BOB', // Cambiar a la moneda boliviana
    }).format(value);
};

// Funciones para editar y eliminar productos
const onDeleteSuccess = (e) => {
    productos.value = e.props.producto;
    location.reload();

};
</script>
