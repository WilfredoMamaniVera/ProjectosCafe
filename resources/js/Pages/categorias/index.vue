<template>

    <Head title="Categorías" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorías</h2>
                <Link :href="route('categorias.create')">Crear Categoría</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Nombre</th>
                                                <th scope="col" class="px-6 py-3">Descripción</th>
                                                <th scope="col" class="px-6 py-3">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="categoria in categorias" :key="categoria.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <td class="px-6 py-4">{{ categoria.nombre }}</td>
                                                <td class="px-6 py-4">{{ categoria.descripcion }}</td>
                                                <td class="px-6 py-4 flex space-x-4">
                                                    <Link :href="route('categorias.edit', categoria)" class="text-blue-500 hover:underline">Editar</Link>
                                                    <Link @success="onDeleteSuccess" :href="route('categorias.destroy', categoria)" method="delete" as="button" class="text-red-500 hover:underline">Eliminar</Link>
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
const categorias = page.props.categorias;

// Función para actualizar la lista después de la eliminación
const onDeleteSuccess = (e) => {
    categorias.value = e.props.categorias;
    location.reload();

};



</script>
