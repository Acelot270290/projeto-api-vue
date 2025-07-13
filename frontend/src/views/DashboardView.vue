<script setup>
import SidebarLayout from '@/layouts/SidebarLayout.vue'
import { onMounted, onUnmounted, ref, computed } from 'vue'
import api from '@/api/api'
import Swal from 'sweetalert2'
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const kpis = ref([])
const loading = ref(true)
let intervalId = null
const previousValues = ref({})

const isMonetario = (titulo) => {
  return ['Vendas do Dia', 'Pedidos Finalizados'].includes(titulo)
}

const formatarMoeda = (valor) => {
  return valor.toLocaleString('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  })
}

const fetchKpis = async () => {
  try {
    const response = await api.get('/kpis', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })

    const novosKpis = response.data.map((kpi) => {
      const id = kpi.id
      const valor = parseFloat(kpi.valor)
      const variacao = parseFloat(kpi.variacao_percentual)

      const oldValue = previousValues.value[id]
      const mudou = oldValue !== undefined && oldValue !== valor
      previousValues.value[id] = valor

      return {
        ...kpi,
        valor,
        variacao_percentual: variacao,
        mudou,
      }
    })

    kpis.value = novosKpis
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Erro ao carregar KPIs',
      text: error.response?.data?.message || 'Token inválido ou expirado',
    })
    localStorage.removeItem('token')
    window.location.href = '/login'
  } finally {
    loading.value = false
  }
}

const chartData = computed(() => {
  return {
    labels: kpis.value.map(kpi => kpi.titulo),
    datasets: [
      {
        label: 'Valores dos KPIs',
        backgroundColor: '#0d6efd',
        data: kpis.value.map(kpi => kpi.valor),
      },
    ],
  }
})

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { display: false },
  },
  scales: {
    y: { beginAtZero: true },
  },
}

onMounted(() => {
  fetchKpis()
  intervalId = setInterval(fetchKpis, 30000)
})

onUnmounted(() => {
  clearInterval(intervalId)
})
</script>

<template>
  <SidebarLayout>
    <div class="container-fluid px-2 px-sm-3">
      <h2 class="mb-4 text-center">
        📈 Dashboard de KPIs
      </h2>

      <div v-if="loading" class="text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Carregando...</span>
        </div>
      </div>

      <div v-else-if="kpis.length === 0" class="alert alert-info text-center">
        Nenhum KPI encontrado.
      </div>

      <div v-else class="row g-3">
        <div class="col-12 col-md-6" v-for="kpi in kpis" :key="kpi.id">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title fw-bold">{{ kpi.titulo }}</h5>
              <h4 class="text-primary">
                {{ isMonetario(kpi.titulo) ? formatarMoeda(kpi.valor) : kpi.valor.toLocaleString('pt-BR') }}
                <span v-if="kpi.mudou" class="badge bg-warning text-dark ms-2">Atualizado</span>
              </h4>
            </div>
            <div class="card-footer bg-transparent border-0">
              <span
                :class="[ 'fw-semibold', kpi.variacao_percentual >= 0 ? 'text-success' : 'text-danger' ]"
              >
                <i :class="kpi.variacao_percentual >= 0 ? 'bi bi-arrow-up' : 'bi bi-arrow-down'" class="me-1"></i>
                {{ Math.abs(kpi.variacao_percentual).toFixed(2) }}%
              </span>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card shadow-sm mt-4">
            <div class="card-body">
              <h5 class="card-title">Gráfico Geral dos KPIs</h5>
              <div style="height: 300px;">
                <Bar :data="chartData" :options="chartOptions" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </SidebarLayout>
</template>

<style scoped>
.card-title {
  font-size: 1.2rem;
}
.card h4 {
  font-weight: 500;
}
.badge {
  animation: fadeIn 0.4s ease-in-out;
}
@keyframes fadeIn {
  0% { opacity: 0; transform: translateY(-2px); }
  100% { opacity: 1; transform: translateY(0); }
}
</style>
