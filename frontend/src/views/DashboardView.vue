<script setup>
import { onMounted, ref } from 'vue'
import api from '@/api/api'
import Swal from 'sweetalert2'

const kpis = ref([])
const loading = ref(true)

const fetchKpis = async () => {
  try {
    const response = await api.get('/kpis', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    kpis.value = response.data
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

onMounted(fetchKpis)
</script>

<template>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Dashboard de KPIs</h2>

    <div v-if="loading" class="text-center">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <div v-else-if="kpis.length === 0" class="alert alert-info text-center">
      Nenhum KPI encontrado.
    </div>

    <div v-else class="row">
      <div class="col-md-4 mb-4" v-for="kpi in kpis" :key="kpi.id">
        <div class="card shadow h-100">
          <div class="card-body">
            <h5 class="card-title">{{ kpi.title }}</h5>
            <p class="card-text">{{ kpi.description }}</p>
            <span class="badge bg-success">Valor: {{ kpi.value }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
