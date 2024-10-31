<template>
    <Head title="Usuarios" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2>
                <Link :href="route('usuarios.create')" class="btn btn-primary">Crear Usuario</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nombre</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ user.name }}</td>
                                    <td class="px-6 py-4">{{ user.email }}</td>
                                    <td class="px-6 py-4 flex space-x-4">
                                        <Link :href="route('usuarios.edit', user)" class="text-blue-500 hover:underline">Editar</Link>
                                        <Link @success="onDeleteSuccess" :href="route('usuarios.destroy', user)" method="delete" as="button" class="text-red-500 hover:underline">Eliminar</Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
const users = page.props.users;

console.log(users); // Agregar este log para depurar

const onDeleteSuccess = (e) => {
    // Aquí debes asegurarte de que los usuarios se actualizan correctamente
    // Puedes usar una lógica más adecuada para actualizar la lista de usuarios
    users.value = e.props.users;
};
</script>
