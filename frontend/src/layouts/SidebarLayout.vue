<template>
    <div class="d-flex">
        <!-- Botão Hamburguer (Mobile) -->
        <button class="btn btn-outline-dark d-md-none position-fixed top-0 start-0 m-2 z-3" @click="toggleSidebar">
            <i class="bi" :class="sidebarOpen ? 'bi-x-lg' : 'bi-list'"></i>
        </button>

        <!-- Overlay (Mobile) -->
        <div v-if="sidebarOpen && isMobile" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 z-2"
            @click.self="toggleSidebar"></div>

        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white p-3" :class="[
            'sidebar',
            isMobile ? (sidebarOpen ? 'sidebar-show' : 'sidebar-hidden') : ''
        ]">
            <!-- Botão de fechar (aparece só no mobile) -->
            <div class="d-flex justify-content-end d-md-none mb-3">
                <button class="btn btn-sm btn-light" @click="toggleSidebar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <h4 class="mb-4">📊 Dashboard</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link text-white" @click="handleLinkClick">
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

        <!-- Conteúdo principal -->
        <div class="flex-grow-1 p-4 bg-light" style="min-height: 100vh;">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import Swal from 'sweetalert2'

const sidebarOpen = ref(true)
const isMobile = ref(false)

const checkMobile = () => {
    isMobile.value = window.innerWidth < 768
    sidebarOpen.value = !isMobile.value
}

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value
}

const handleLinkClick = () => {
    if (isMobile.value) sidebarOpen.value = false
}

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

onMounted(() => {
    checkMobile()
    window.addEventListener('resize', checkMobile)
})

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile)
})
</script>

<style scoped>
.sidebar {
    width: 250px;
    transition: transform 0.3s ease-in-out;
    z-index: 1040;
}

.sidebar-hidden {
    transform: translateX(-100%);
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
}

.nav-link.router-link-exact-active {
    font-weight: bold;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 5px;
}

@media (max-width: 767.98px) {
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        transform: translateX(0);
    }

    .z-3 {
        z-index: 1050 !important;
    }

    .sidebar-show {
        transform: translateX(0);
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
    }

    .sidebar-hidden {
        transform: translateX(-100%);
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
    }
}
</style>
