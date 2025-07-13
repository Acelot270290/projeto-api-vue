<script setup>
import SidebarLayout from '@/layouts/SidebarLayout.vue'
import { onMounted, onUnmounted, ref } from 'vue'
import api from '@/api/api'
import Swal from 'sweetalert2'

const kpis = ref([])
const loading = ref(true)
let intervalId = null

const previousValues = ref({})

// Função auxiliar para identificar KPIs monetários
const isMonetario = (titulo) => {
  return ['Vendas do Dia', 'Pedidos Finalizados'].includes(titulo)
}

// Formata como moeda
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

    <div v-else class="row">
      <div class="col-12 col-md-6 mb-4" v-for="kpi in kpis" :key="kpi.id">
        <div class="card h-100 shadow d-flex flex-column justify-content-between">
          <div class="card-body">
            <h5 class="card-title fw-bold">{{ kpi.titulo }}</h5>
            <h4 class="text-primary">
              {{ isMonetario(kpi.titulo) ? formatarMoeda(kpi.valor) : kpi.valor.toLocaleString('pt-BR') }}
              <span v-if="kpi.mudou" class="badge bg-warning text-dark ms-2">Atualizado</span>
            </h4>
          </div>
          <div class="card-footer bg-transparent border-0">
            <span
              :class="[
                'fw-semibold',
                kpi.variacao_percentual >= 0 ? 'text-success' : 'text-danger'
              ]"
            >
              <i
                :class="kpi.variacao_percentual >= 0 ? 'bi bi-arrow-up' : 'bi bi-arrow-down'"
                class="me-1"
              ></i>
              {{ Math.abs(kpi.variacao_percentual).toFixed(2) }}%
            </span>
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
