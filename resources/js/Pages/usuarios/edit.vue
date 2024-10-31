<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Definir las propiedades recibidas desde el servidor (usuario)
const props = defineProps(['usuario']);

// Inicializa el formulario con useForm
const form = useForm({
    nombre: props.usuario.name,
    email: props.usuario.email,
    password: "",
    password_confirmation: "",
});

// Maneja el envío del formulario

const submit = (e) => {
    e.preventDefault(); 
    form.post(route('usuarios.update', props.usuario.id)); 
};






</script>

<template>
    <Head title="Editar Usuario" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Usuario</h2>
                <Link :href="route('usuarios.index')">Lista De Usuarios</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form class="w-1/3 py-5 space-y-3" @submit="submit">
                        <div>
                            <InputLabel for="nombre" value="Nombre del Usuario" />
                            <TextInput id="nombre" type="text" class="mt-1 block w-full"
                                v-model="form.nombre" required autofocus autocomplete="nombre"
                                placeholder="Juan Pérez" />
                            <InputError class="mt-2" :message="form.errors.nombre" />
                        </div>

                        <div>
                            <InputLabel for="email" value="Correo Electrónico" />
                            <TextInput id="email" type="email" class="mt-1 block w-full"
                                v-model="form.email" required autocomplete="email"
                                placeholder="correo@ejemplo.com" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div>
                            <InputLabel for="password" value="Contraseña" />
                            <TextInput id="password" type="password" class="mt-1 block w-full"
                                v-model="form.password" autocomplete="new-password"
                                placeholder="********" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div>
                            <InputLabel for="password_confirmation" value="Confirmar Contraseña" />
                            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                                v-model="form.password_confirmation" autocomplete="new-password"
                                placeholder="********" />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <div class="flex justify-center">
                            <PrimaryButton>
                                Actualizar Usuario
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
