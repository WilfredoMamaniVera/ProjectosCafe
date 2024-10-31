<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Definir las propiedades recibidas desde el servidor (categoría)
const props = defineProps(['categoria']);

// Inicializa los valores del formulario
const initialValues = {
    nombre: props.categoria.nombre,
    descripcion: props.categoria.descripcion
};

// Inicializa el formulario con useForm
const form = useForm(initialValues);

// Maneja el envío del formulario
const submit = (e) => {
    e.preventDefault(); 
    form.post(route('categorias.update', props.categoria.id)); 
};

</script>

<template>

    <Head title="Editar Categoría" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Categoría</h2>
                <Link :href="route('categorias.index')">Lista De Categorías</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form class="w-1/3 py-5 space-y-3" @submit="submit">

                        <!-- Campo nombre -->
                        <div>
                            <InputLabel for="nombre" value="Nombre de la Categoría" />
                            <TextInput id="nombre" type="text" class="mt-1 block w-full"
                                v-model="form.nombre" required autofocus autocomplete="nombre"
                                placeholder="Ej: Electrónica" />
                            <InputError class="mt-2" :message="form.errors.nombre" />
                        </div>

                        <!-- Campo descripcion -->
                        <div>
                            <InputLabel for="descripcion" value="Descripción" />
                            <TextInput id="descripcion" type="text" class="mt-1 block w-full" v-model="form.descripcion"
                                placeholder="Descripción de la categoría" />
                            <InputError class="mt-2" :message="form.errors.descripcion" />
                        </div>

                        <!-- Botón de envío -->
                        <div class="flex justify-center">
                            <PrimaryButton>
                                Actualizar Categoría
                            </PrimaryButton>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
