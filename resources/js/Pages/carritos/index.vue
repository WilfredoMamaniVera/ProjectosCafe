<template>
  <AuthenticatedUserLayout>
    <Head title="Carrito de Compras" />

    <div class="container mx-auto mt-4">
      <h1 class="mb-4 text-center text-4xl font-bold">Carrito de Compras</h1>

      <div v-if="loading" class="text-center">Cargando...</div>
      <div v-else-if="!carrito || carrito.detalles.length === 0" class="text-center">
        <p>Tu carrito está vacío.</p>
      </div>
      <div v-else>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
          <div class="relative overflow-x-auto">
            <table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th scope="col" class="px-6 py-3">Imagen</th>
                  <th scope="col" class="px-6 py-3">Nombre del Producto</th>
                  <th scope="col" class="px-6 py-3">Descripción</th>
                  <th scope="col" class="px-6 py-3">Marca</th>
                  <th scope="col" class="px-6 py-3">Categoría</th>
                  <th scope="col" class="px-6 py-3">Stock</th>
                  <th scope="col" class="px-6 py-3">Cantidad</th>
                  <th scope="col" class="px-6 py-3">Precio Unitario</th>
                  <th scope="col" class="px-6 py-3">Total</th>
                  <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="detalle in carrito.detalles" :key="detalle.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                  <td class="px-6 py-4">
                    <img 
                      :src="detalle.producto && detalle.producto.imagen 
                        ? `/storage/${detalle.producto.imagen}` 
                        : '/Imagenes/No_image_available.svg.png'" 
                      alt="imagen del producto" 
                      class="img-fluid h-16"
                    />
                  </td>
                  <td class="px-6 py-4">{{ detalle.producto ? detalle.producto.producto_nombre : 'Producto no disponible' }}</td>
                  <td class="px-6 py-4">{{ detalle.producto ? detalle.producto.descripcion : 'Sin descripción' }}</td>
                  <td class="px-6 py-4">{{ detalle.producto ? detalle.producto.marca : 'Sin marca' }}</td>
                  <td class="px-6 py-4">{{ detalle.producto && detalle.producto.categoria ? detalle.producto.categoria.nombre : 'Sin categoría' }}</td>
                  <td class="px-6 py-4">{{ detalle.producto ? detalle.producto.stock : 'N/A' }}</td>
                  <td class="px-6 py-4">
                    <div class="flex items-center">
                      <button @click="decrementarCantidad(detalle)" class="btn btn-secondary btn-sm" :disabled="detalle.cantidad <= 1">-</button>
                      <span class="mx-2">{{ detalle.cantidad }}</span>
                      <button @click="incrementarCantidad(detalle)" class="btn btn-secondary btn-sm">+</button>
                    </div>
                  </td>
                  <td class="px-6 py-4">{{ detalle.precio_unico.toFixed(2) }}</td>
                  <td class="px-6 py-4">{{ (detalle.precio_unico * detalle.cantidad).toFixed(2) }}</td>
                  <td class="px-6 py-4">
                    <button @click="eliminarProducto(detalle)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-4 text-end">
          <strong class="text-black-500 text-xl">Total: {{ calcularTotal.toFixed(2) }}Bs</strong>
        </div>
      </div>
    </div>
  </AuthenticatedUserLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedUserLayout from '@/Layouts/AuthenticatedUserLayout.vue';
import { Head } from '@inertiajs/vue3';

const page = usePage();
const carrito = ref(page.props.carrito || { detalles: [] });
const loading = ref(!carrito.value);

// Computed property to calculate the total
const calcularTotal = computed(() => {
  return carrito.value.detalles.reduce((total, detalle) => {
    return total + (detalle.cantidad * detalle.precio_unico);
  }, 0);
});

// Fetch carrito when component is mounted
onMounted(async () => {
  if (!carrito.value || carrito.value.detalles.length === 0) {
    loading.value = true;
    await fetchCarrito();
  } else {
    loading.value = false;
  }
});

// Method to fetch carrito from server
async function fetchCarrito() {
  try {
    const response = await fetch(route('carritos.index'));
    if (!response.ok) throw new Error('Error en la respuesta de la API: ' + response.status);
    const data = await response.json();
    carrito.value = data;
  } catch (error) {
    console.error('Error al cargar el carrito:', error);
  } finally {
    loading.value = false;
  }
}

// Methods to manage product quantities
function incrementarCantidad(detalle) {
  detalle.cantidad++;
  actualizarCantidad(detalle);
}

function decrementarCantidad(detalle) {
  if (detalle.cantidad > 1) {
    detalle.cantidad--;
    actualizarCantidad(detalle);
  }
}

async function eliminarProducto(detalle) {
  
    const response = await axios.post('carritos/remove-product', {
      producto_id: detalle.producto.id,
    });
    location.reload();
}

// Method to update product quantity
async function actualizarCantidad(detalle) {
  try {
    const response = await axios.post('/carritos/update-product', {
      producto_id: detalle.producto.id,
      cantidad: detalle.cantidad,
    });

    if (!response.status === 200) {
      throw new Error('Error al actualizar la cantidad: ' + response.status);
    }

    console.log('Cantidad actualizada para:', detalle.producto.producto_nombre);
  } catch (error) {
    console.error('Error al actualizar la cantidad:', error);
  }
}
</script>
