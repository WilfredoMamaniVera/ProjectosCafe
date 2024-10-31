<template>
  <AuthenticatedUserLayout>
    <div class="orden-container">
      <h1 class="mb-4 text-center text-4xl font-bold">Detalles de tu Orden</h1>

      <div class="content">
        <div class="productos">
          <h2 class="text-xl font-semibold">Productos en el Carrito</h2>
          <table class="min-w-full table-auto bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
              <tr>
                <th class="px-6 py-3">Imagen</th>
                <th class="px-6 py-3">Nombre del Producto</th>
                <th class="px-6 py-3">Descripción</th>
                <th class="px-6 py-3">Marca</th>
                <th class="px-6 py-3">Categoría</th>
                <th class="px-6 py-3">Stock</th>
                <th class="px-6 py-3">Cantidad</th>
                <th class="px-6 py-3">Precio Unitario</th>
                <th class="px-6 py-3">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="detalle in carrito.detalles" :key="detalle.id" class="border-b">
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
                <td class="px-6 py-4">{{ detalle.cantidad }}</td>
                <td class="px-6 py-4">{{ detalle.precio_unico.toFixed(2) }} Bs</td>
                <td class="px-6 py-4">{{ (detalle.precio_unico * detalle.cantidad).toFixed(2) }} Bs</td>
              </tr>
            </tbody>
          </table>
          <p class="mt-4 font-bold">Total Productos: {{ calcularTotal.toFixed(2) }} Bs</p>
        </div>

        <div class="resumen">
          <h2 class="text-xl font-semibold mt-4">Resumen de la Orden</h2>
          <div class="resumen-detalle">
            <p><strong>Total Productos:</strong> {{ calcularTotal.toFixed(2) }} Bs</p>
            <p><strong>Envío:</strong> {{ calcularEnvio.toFixed(2) }} Bs</p>
            <p><strong>Descuento Cupón:</strong> {{ descuentoCupon.toFixed(2) }} Bs</p>
            <p><strong>Total a Pagar:</strong> {{ calcularTotalConEnvio.toFixed(2) }} Bs</p>
          </div>

          <h2 class="text-xl font-semibold mt-4">Dirección de Envío</h2>
          <input type="text" v-model="direccion" placeholder="Ingresa tu dirección" class="input mb-4" />

          <h2 class="text-xl font-semibold mt-4">Método de Pago</h2>
          <select v-model="metodoPago" @change="metodoPagoChange" class="select mb-4">
            <option value="tarjeta">Tarjeta de Crédito</option>
            <option value="efectivo">Efectivo</option>
          </select>

          <div v-if="metodoPago === 'efectivo'">
            <input type="text" v-model="numeroEfectivo" placeholder="Ingresa el número" class="input mb-4" />
          </div>

          <div v-if="metodoPago === 'tarjeta'">
            <h3 class="text-lg font-semibold">Agregar Tarjeta</h3>
            <input type="text" v-model="numeroTarjeta" placeholder="Número de tarjeta" class="input mb-4" />
            <input type="text" v-model="fechaExpiracion" placeholder="MM/AA" class="input mb-4" />
            <input type="text" v-model="codigoSeguridad" placeholder="Código de seguridad" class="input mb-4" />
          </div>

          <h2 class="text-xl font-semibold mt-4">Código de Cupón</h2>
          <input type="text" v-model="codigoCupon" placeholder="Ingresa tu código de cupón" class="input mb-4" />
          
          <button class="btn aplicar-cupon" @click="aplicarCupon">Aplicar Cupón</button>

          <div class="botones-accion mt-4">
            <button class="btn pagar" @click="guardarOrden">Pagar</button>
            <button class="btn cancelar" @click="cancelarOrden">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedUserLayout>
</template>

<script>
import AuthenticatedUserLayout from '@/Layouts/AuthenticatedUserLayout.vue';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
components: {
  AuthenticatedUserLayout,
},
props: {
  carrito: Object,
},
data() {
  return {
    direccion: '',
    metodoPago: 'tarjeta',
    numeroEfectivo: '',
    numeroTarjeta: '',
    fechaExpiracion: '',
    codigoSeguridad: '',
    codigoCupon: '',
    descuentoCupon: 0,
  };
},
computed: {
  calcularTotal() {
    if (this.carrito && this.carrito.detalles) {
      return this.carrito.detalles.reduce((total, detalle) => {
        return total + (detalle.precio_unico * detalle.cantidad);
      }, 0);
    }
    return 0;
  },
  calcularEnvio() {
    return 5; // Costo de envío
  },
  calcularTotalConEnvio() {
    return this.calcularTotal + this.calcularEnvio - this.descuentoCupon;
  },
},
methods: {
  metodoPagoChange() {
    if (this.metodoPago === 'tarjeta') {
      this.numeroEfectivo = ''; // Limpiar número de efectivo
    } else {
      this.numeroTarjeta = ''; // Limpiar campos de tarjeta
      this.fechaExpiracion = '';
      this.codigoSeguridad = '';
    }
  },
  aplicarCupon() {
    if (this.codigoCupon === 'DESCUENTO10') {
      this.descuentoCupon = 10; // Descuento fijo de 10 Bs
      alert(`Cupón aplicado. Descuento: ${this.descuentoCupon} Bs`);
    } else {
      alert('Cupón no válido.');
    }
  },
  guardarOrden() {
    const ordenData = {
      direccion: this.direccion,
      metodo_pago: this.metodoPago,
      codigo_cupon: this.codigoCupon,
    };

    // Enviar datos de la orden al servidor
    Inertia.post('orden', ordenData, {
    onSuccess: () => {
        alert('Orden guardada con éxito.');
    },
    onError: () => {
        alert('Error al guardar la orden.');
    },
});

  },
  cancelarOrden() {
    this.direccion = '';
    this.metodoPago = 'tarjeta';
    this.numeroEfectivo = '';
    this.numeroTarjeta = '';
    this.fechaExpiracion = '';
    this.codigoSeguridad = '';
    this.codigoCupon = '';
    this.descuentoCupon = 0;
    alert('Orden cancelada.');
  },
},
};
</script>

<style scoped>
.orden-container {
margin: 10px;
}

.content {
display: flex;
justify-content: space-between;
}

.productos {
flex: 3; 
margin-right: 20px; 
}

.resumen {
flex: 1;
}

.table-auto {
width: 100%;
}

.btn {
border: none;
color: white;
padding: 10px 20px;
margin: 5px;
cursor: pointer;
border-radius: 5px;
}

.aplicar-cupon {
background-color: green;
}

.pagar {
background-color: blue;
}

.cancelar {
background-color: red;
}

.input {
width: 100%;
padding: 10px;
margin: 5px 0;
border: 1px solid #ccc;
border-radius: 5px;
}

.select {
width: 100%;
padding: 10px;
margin: 5px 0;
border: 1px solid #ccc;
border-radius: 5px;
}
</style>
