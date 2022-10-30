<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router'

const router = useRouter();

let form = reactive({
    email: '',
    password: '',
});

let error = ref('')

const login = async () => {
    await axios.post('/api/login', form)
        .then(response => {
            if (response.data.success) {
                localStorage.setItem('token', response.data.data.token);
                localStorage.setItem('name', response.data.data.name);
                router.push('/admin/home');
            } else {
                return error.value = response.data.message;
            }
        })
}

</script>

<template>
    <div class="login">
        <div class="formLogin">
            <p class="text-danger" v-if="error">{{ error }}</p>
            <!-- <p class="text-danger" v-if="error">{{ error }}</p> -->
            <form @submit.prevent="login">
                <input class="input_auth" type="email" placeholder="Enter your email" v-model="form.email" />
                <br>
                <input class="input_auth" type="password" placeholder="Enter your password" v-model="form.password" />
                <br>
                <input type="submit" value="login" class="submit input_auth" />
            </form>
        </div>
    </div>
</template>

<style scoped>
@import '../../../css/auth/login.css';
</style>

