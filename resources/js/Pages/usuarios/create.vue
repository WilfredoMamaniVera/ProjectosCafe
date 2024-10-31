<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Inicializa los valores del formulario
const initialValues = {
    nombre: "",  // Nombre del usuario
    email: "",   // Correo electrónico del usuario
    password: "", // Contraseña del usuario
    password_confirmation: "", // Confirmación de la contraseña
};

// Inicializa el formulario con useForm
const form = useForm(initialValues);

// Maneja el envío del formulario
const submit = (e) => {
    e.preventDefault(); // Evita el comportamiento predeterminado del formulario
    form.post(route('usuarios.store')); // Realiza la petición POST para crear un usuario
}
</script>

<template>

    <Head title="Crear Usuario" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Usuario</h2>
                <Link :href="route('usuarios.index')">Lista de Usuarios</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form class="w-1/3 py-5 space-y-3" @submit="submit">

                        <!-- Campo nombre del usuario -->
                        <div>
                            <InputLabel for="nombre" value="Nombre del Usuario" />
                            <TextInput id="nombre" type="text" class="mt-1 block w-full"
                                v-model="form.nombre" required autofocus autocomplete="nombre"
                                placeholder="Juan Pérez" />
                            <InputError class="mt-2" :message="form.errors.nombre" />
                        </div>

                        <!-- Campo correo electrónico -->
                        <div>
                            <InputLabel for="email" value="Correo Electrónico" />
                            <TextInput id="email" type="email" class="mt-1 block w-full"
                                v-model="form.email" required autocomplete="email"
                                placeholder="correo@ejemplo.com" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <!-- Campo contraseña -->
                        <div>
                            <InputLabel for="password" value="Contraseña" />
                            <TextInput id="password" type="password" class="mt-1 block w-full"
                                v-model="form.password" required autocomplete="new-password"
                                placeholder="********" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <!-- Campo confirmación de la contraseña -->
                        <div>
                            <InputLabel for="password_confirmation" value="Confirmar Contraseña" />
                            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                                v-model="form.password_confirmation" required autocomplete="new-password"
                                placeholder="********" />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <!-- Botón de envío -->
                        <div class="flex justify-center">
                            <PrimaryButton>
                                Crear Usuario
                            </PrimaryButton>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
