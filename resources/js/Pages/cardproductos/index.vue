<template>
  <AuthenticatedUserLayout>

    <Head title="Productos Disponibles" />
    <div class="container mx-auto mt-4">
      <h1 class="text-3xl font-bold mb-4 text-center">Productos Disponibles</h1>
      <form @submit.prevent="searchProducts"
        class="flex flex-col sm:flex-row sm:items-center mb-6 gap-5 justify-center">
        <div class="flex-grow">
          <label class="visually-hidden" for="CategoriaId">Categorías</label>
          <select
            class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            id="CategoriaId" v-model="selectedCategory">
            <option disabled value="">Seleccione...</option>
            <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
              {{ categoria.nombre }}
            </option>
          </select>
        </div>
        <div class="flex-grow">
          <label class="visually-hidden" for="searchTerm">Buscar por Nombre</label>
          <input type="text"
            class="form-control w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            v-model="searchTerm" id="searchTerm" placeholder="Buscar por Nombre" />
        </div>
        <div class="flex space-x-2">
          <button type="submit"
            class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition">Buscar</button>
          <button type="button"
            class="bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg hover:bg-gray-400 transition"
            @click="resetFilters">Restablecer</button>
        </div>
      </form>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">
        <div v-for="producto in filteredProducts" :key="producto.id"
          class="card bg-white rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105 hover:shadow-2xl">
          <img :src="getImageUrl(producto.imagen)" class="card-img-top w-full h-48 object-cover"
            alt="Imagen del producto" />
          <div class="card-body p-4">
            <h5 class="card-title text-lg font-semibold text-gray-800">{{ producto.nombre }}</h5>
            <p class="card-text text-sm text-gray-600">
              <b>Nombre:</b> {{ producto.producto_nombre }}<br />
              <b>Precio:</b> {{ producto.precio }} Bs<br />
              <b>Categoría:</b> {{ producto.categoria.nombre }}<br />
              <b>Marca:</b> {{ producto.marca }}<br />
            </p>
            <div class="flex items-center justify-between mt-2">
              <span v-if="producto.stock > 0"
                class="bg-blue-600 text-white font-semibold cursor-pointer rounded-lg px-3 py-1"
                @click="addToCart(producto.id, 1)"> <!-- Asumí que la cantidad es 1 -->
                <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h18M3 3v18h18V3M3 3l9 9m-9 0l9 9" />
                </svg>
                Agregar
              </span>
              <span v-else class="text-red-500 border border-red-500 px-2 py-1 rounded">
                Sin Stock
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedUserLayout>
</template>

<script>
import AuthenticatedUserLayout from '@/Layouts/AuthenticatedUserLayout.vue';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    AuthenticatedUserLayout,
    Head,
  },
  props: {
    productos: {
      type: Array,
      required: true,
    },
    categorias: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      selectedCategory: '',
      searchTerm: '',
    };
  },
  computed: {
    filteredProducts() {
      return this.productos.filter((producto) => {
        const matchesCategory = this.selectedCategory ? producto.categoria.id === this.selectedCategory : true;
        const matchesSearchTerm = producto.producto_nombre && producto.producto_nombre.toLowerCase().includes(this.searchTerm.toLowerCase());

        // Filtra solo si hay un término de búsqueda o se ha seleccionado una categoría
        return (this.selectedCategory || this.searchTerm) ? matchesCategory && matchesSearchTerm : true;
      });
    },
  },
  methods: {
    getImageUrl(imagen) {
      return imagen ? `/storage/${imagen}` : '/storage/no_image_available.png';
    },
    async addToCart(productoId, cantidad) {
      try {
        const response = await axios.post('/dashboard/carritos/agregar', {
          producto_id: productoId,
          cantidad: cantidad
        });

        console.log('Producto agregado al carrito:', response.data);
      } catch (error) {
        console.error('Error al agregar al carrito:', error.response.data);
      }
    },
    searchProducts() {
      console.log(`Buscando productos en la categoría ${this.selectedCategory} con el término "${this.searchTerm}"`);
      // Implementa la lógica de búsqueda aquí si es necesario
    },
    resetFilters() {
      this.selectedCategory = '';
      this.searchTerm = '';
    },
  },
};
</script>

<style scoped>
.card {
  transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
  transform: scale(1.05);
}
</style>
