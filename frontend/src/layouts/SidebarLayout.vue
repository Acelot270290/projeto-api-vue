<template>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">
      <h4 class="mb-4">📊 Dashboard</h4>
      <ul class="nav flex-column">
        <li class="nav-item">
          <router-link to="/dashboard" class="nav-link text-white">
            <i class="bi bi-speedometer2 me-2"></i> KPIs
          </router-link>
        </li>
        <li class="nav-item mt-3">
          <button @click="logout" class="btn btn-outline-light w-100">
            <i class="bi bi-box-arrow-right me-2"></i> Sair
          </button>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4 bg-light" style="min-height: 100vh;">
      <slot />
    </div>
  </div>
</template>

<script setup>
import Swal from 'sweetalert2'

const logout = () => {
  localStorage.removeItem('token')
  Swal.fire({
    icon: 'success',
    title: 'Logout realizado',
    timer: 1500,
    showConfirmButton: false
  }).then(() => {
    window.location.href = '/login'
  })
}
</script>

<style scoped>
.nav-link.router-link-exact-active {
  font-weight: bold;
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 5px;
}
</style>
