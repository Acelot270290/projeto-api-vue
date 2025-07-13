<script setup>
import { ref } from 'vue'
import api from '@/api/api'
import Swal from 'sweetalert2'
import { RouterLink } from 'vue-router'

const email = ref('')
const password = ref('')

const login = async () => {
  try {
    const response = await api.post('/login', {
      email: email.value,
      password: password.value,
    })

    const token = response.data.access_token
    localStorage.setItem('token', token)

    await Swal.fire({
      icon: 'success',
      title: 'Login realizado!',
      text: 'Você será redirecionado.',
      timer: 2000,
      showConfirmButton: false,
    })

    window.location.href = '/dashboard'
  } catch (err) {
    const mensagem = err.response?.data?.error || 'Erro ao fazer login'
    Swal.fire({
      icon: 'error',
      title: 'Erro no login',
      text: mensagem,
    })
  }
}
</script>

<template>
  <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
      <div class="text-center mb-4">
        <i class="bi bi-shield-lock-fill fs-1 text-primary"></i>
        <h3 class="fw-bold">Login</h3>
      </div>

      <form @submit.prevent="login">
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input
            v-model="email"
            type="email"
            class="form-control"
            id="email"
            placeholder="Digite seu e-mail"
            required
          />
        </div>

        <div class="mb-4">
          <label for="password" class="form-label">Senha</label>
          <input
            v-model="password"
            type="password"
            class="form-control"
            id="password"
            placeholder="Digite sua senha"
            required
          />
        </div>

        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-box-arrow-in-right me-2"></i> Entrar
        </button>
      </form>

      <div class="text-center mt-3">
        <small class="text-muted">
          Ainda não tem uma conta?
         <router-link to="/register">Cadastre-se</router-link>
        </small>
      </div>
    </div>
  </div>
</template>

<style scoped>
body {
  background-color: #f8f9fa;
}
</style>
