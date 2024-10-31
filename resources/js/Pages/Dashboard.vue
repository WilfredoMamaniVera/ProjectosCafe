<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';

// Lista de imágenes y slogans para el carrusel
const images = [
    {
        src: 'image/image1.jpeg',
        slogan: "Disfruta el sabor de la felicidad en cada taza."
    },
    {
        src: 'image/image2.jpeg',
        slogan: "Tu rincón de paz y café."
    },
    {
        src: 'image/image3.jpeg',
        slogan: "Momentos especiales se crean con un buen café."
    }
];

const currentImageIndex = ref(0);

// Función para avanzar a la siguiente imagen
const nextImage = () => {
    currentImageIndex.value = (currentImageIndex.value + 1) % images.length;
};

// Función para retroceder a la imagen anterior
const prevImage = () => {
    currentImageIndex.value = (currentImageIndex.value - 1 + images.length) % images.length;
};

// Agregar un intervalo para cambiar las imágenes automáticamente
let interval;

onMounted(() => {
    interval = setInterval(nextImage, 3000); // Cambia de imagen cada 3 segundos
});

onBeforeUnmount(() => {
    clearInterval(interval); // Limpia el intervalo al desmontar el componente
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>


        <!-- Carrusel de imágenes -->
        <div class="relative overflow-hidden h-80 bg-cover bg-center mt-8">
            <transition name="fade">
                <img :key="currentImageIndex" :src="images[currentImageIndex].src" alt="Imagen del carrusel" class="w-full h-full object-cover" />
            </transition>
            <div class="absolute bottom-0 left-0 right-0 bg-[#6f4c3e] bg-opacity-60 text-white text-center p-4">
                <h2 class="text-2xl font-bold text-white text-shadow">{{ images[currentImageIndex].slogan }}</h2>
            </div>
            <button @click="prevImage" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-[#8b5a2b] text-white px-3 py-1 rounded-full">Prev</button>
            <button @click="nextImage" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-[#8b5a2b] text-white px-3 py-1 rounded-full">Next</button>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Agrega las clases de transición */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>
