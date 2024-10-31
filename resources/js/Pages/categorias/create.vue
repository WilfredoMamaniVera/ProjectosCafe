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
    nombre: "",  // Nombre de la categoría
    descripcion: ""  // Descripción de la categoría
};

// Inicializa el formulario con useForm
const form = useForm(initialValues);

// Maneja el envío del formulario
const submit = (e) => {
    e.preventDefault(); // Evita el comportamiento predeterminado del formulario
    form.post(route('categorias.store')); // Realiza la petición POST para crear una categoría
}
</script>

<template>

    <Head title="Crear Categoría" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Categoría</h2>
                <Link :href="route('categorias.index')">Lista de Categorías</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form class="w-1/3 py-5 space-y-3" @submit="submit">

                        <!-- Campo nombre de la categoría -->
                        <div>
                            <InputLabel for="nombre" value="Nombre de la Categoría" />
                            <TextInput id="nombre" type="text" class="mt-1 block w-full"
                                v-model="form.nombre" required autofocus autocomplete="nombre"
                                placeholder="Bebidas" />
                            <InputError class="mt-2" :message="form.errors.nombre" />
                        </div>

                        <!-- Campo descripción de la categoría -->
                        <div>
                            <InputLabel for="descripcion" value="Descripción de la Categoría" />
                            <TextInput id="descripcion" type="text" class="mt-1 block w-full"
                                v-model="form.descripcion" autocomplete="descripcion"
                                placeholder="Descripción de la categoría" />
                            <InputError class="mt-2" :message="form.errors.descripcion" />
                        </div>

                        <!-- Botón de envío -->
                        <div class="flex justify-center">
                            <PrimaryButton>
                                Crear Categoría
                            </PrimaryButton>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
