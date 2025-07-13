<script setup>
import { ref } from 'vue'
import api from '@/api/api'
import Swal from 'sweetalert2'
import { RouterLink } from 'vue-router'

const name = ref('')
const email = ref('')
const password = ref('')

const register = async () => {
  try {
    const response = await api.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
    })

    const token = response.data.token
    localStorage.setItem('token', token)

    await Swal.fire({
      icon: 'success',
      title: 'Cadastro realizado!',
      text: 'Você será redirecionado para o dashboard.',
      timer: 2000,
      showConfirmButton: false,
    })

    window.location.href = '/dashboard'
  } catch (err) {
    const mensagem = err.response?.data?.message || 'Erro ao registrar usuário'
    Swal.fire({
      icon: 'error',
      title: 'Erro no registro',
      text: mensagem,
    })
  }
}
</script>

<template>
  <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="card p-4 shadow" style="width: 100%; max-width: 450px;">
      <div class="text-center mb-4">
        <i class="bi bi-person-plus-fill fs-1 text-success"></i>
        <h3 class="fw-bold">Criar Conta</h3>
      </div>

      <form @submit.prevent="register">
        <div class="mb-3">
          <label for="name" class="form-label">Nome</label>
          <input
            v-model="name"
            type="text"
            class="form-control"
            id="name"
            placeholder="Digite seu nome"
            required
          />
        </div>

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

        <button type="submit" class="btn btn-success w-100">
          <i class="bi bi-check-circle me-2"></i> Registrar
        </button>
      </form>

      <div class="text-center mt-3">
        <small class="text-muted">
          Já tem uma conta?
          <router-link to="/login">Voltar para o login</router-link>
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
