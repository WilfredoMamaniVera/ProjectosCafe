<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FileInput from '@/Components/FileInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Definir las propiedades recibidas desde el servidor (categorías)
const props = defineProps(['categorias', 'producto']);
const page = usePage();

// Inicializa los valores del formulario
const initialValues = {
    producto_nombre: props.producto.producto_nombre,
    marca: props.producto.marca,
    descripcion: props.producto.descripcion,
    precio: props.producto.precio,
    imagen: null,
    stock: props.producto.stock,
    categoria_id: props.producto.categoria_id
};



// Maneja el archivo de imagen
const onSelectimage = (e) => {
    const files = e.target.files;
    if (files.length) {
        form.imagen = files[0];
    }
    console.log(form.imagen);
}

// Inicializa el formulario con useForm
const form = useForm(initialValues);

// Maneja el envío del formulario
const submit = (e) => {
    e.preventDefault(); 
    form.post(route('productos.update', props.producto.id)); 
};





</script>

<template>

    <Head title="Editar Productos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Productos</h2>
                <Link :href="route('productos.index')">Lista De Productos</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form class="w-1/3 py-5 space-y-3" @submit="submit">

                        <!-- Campo producto_nombre -->
                        <div>
                            <InputLabel for="producto_nombre" value="Nombre del Producto" />
                            <TextInput id="producto_nombre" type="text" class="mt-1 block w-full"
                                v-model="form.producto_nombre" required autofocus autocomplete="producto_nombre"
                                placeholder="Cafe Late" />
                            <InputError class="mt-2" :message="form.errors.producto_nombre" />
                        </div>

                        <!-- Campo descripcion -->
                        <div>
                            <InputLabel for="descripcion" value="Descripción" />
                            <TextInput id="descripcion" type="text" class="mt-1 block w-full" v-model="form.descripcion"
                                placeholder="Revitalizador" />
                            <InputError class="mt-2" :message="form.errors.descripcion" />
                        </div>

                        <!-- Campo marca -->
                        <div>
                            <InputLabel for="marca" value="Marca" />
                            <TextInput id="marca" type="text" class="mt-1 block w-full" v-model="form.marca"
                                placeholder="Clara" />
                            <InputError class="mt-2" :message="form.errors.marca" />
                        </div>

                        <!-- Campo precio -->
                        <div>
                            <InputLabel for="precio" value="Precio" />
                            <TextInput id="precio" type="text" class="mt-1 block w-full" v-model="form.precio"
                                placeholder="0 Bs" />
                            <InputError class="mt-2" :message="form.errors.precio" />
                        </div>

                        <!-- Campo stock -->
                        <div>
                            <InputLabel for="stock" value="Stock" />
                            <TextInput id="stock" type="text" class="mt-1 block w-full" v-model="form.stock"
                                placeholder="0" />
                            <InputError class="mt-2" :message="form.errors.stock" />
                        </div>

                        <div>
                            <img class="h-16" :src="`/storage/${producto.imagen}`" v-if="producto.imagen" />

                        </div>





                        <!-- Campo imagen -->
                        <div>
                            <InputLabel for="imagen" value="Imagen" />
                            <FileInput name="imagen" @change="onSelectimage" />
                            <InputError class="mt-2" :message="form.errors.imagen" />
                        </div>

                        <!-- Campo categoría -->
                        <div>
                            <InputLabel for="categoria_id" value="Categoría" />
                            <select v-model="form.categoria_id" name="categoria_id" id="categoria_id"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Seleccione una categoría</option>
                                <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                                    {{ categoria.nombre }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.categoria_id" />
                        </div>

                        <!-- Botón de envío -->
                        <div class="flex justify-center">
                            <PrimaryButton>
                                Actualizar Producto
                            </PrimaryButton>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
