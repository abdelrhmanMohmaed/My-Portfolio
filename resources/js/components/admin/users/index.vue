<script setup>
import axios from "axios";
import { onMounted, ref, } from "vue";
import Base from '../layouts/base.vue';
import { useRouter } from "vue-router";

const router = useRouter();
let users = ref([]);
let roles = ref([]);
const showModal = ref(false);
const hideModal = ref(true);
const editMode = ref(false);
let errors = ref({});

onMounted(() => {
    getUsers();
    getRoles();
});

let form = ref({
    name: '',
    email: '',
    password: '',
    bio: '',
    photo: '',
    role_id: '',
    password_confirmation: '',
});

const openModal = () => {
    showModal.value = !showModal.value;
};

const closeModal = () => {
    showModal.value = !hideModal.value;
    form.value = ('');
    errors.value = ({});
    editMode.value = false;
};

const getUsers = async () => {
    let response = await axios.get('/api/users');
    users.value = response.data.users;
};

const getRoles = async () => {
    let response = await axios.get('/api/roles');
    roles.value = response.data.roles;

};

const ourImage = (img) => {
    return '/img/upload/' + img;
};

const storeUser = async () => {
    await axios.post('/api/store/user/', form.value)
        .then(response => {
            getUsers();
            closeModal();
            toast.fire({
                icon: 'success',
                title: 'User add successfuly',
            });
        }).catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        });
};

const editUser = (user) => {
    editMode.value = true;
    showModal.value = !showModal.value;
    form.value = user;
};

const updateUser = async () => {
    await axios.post('/api/update/user/' + form.value.id, form.value)
        .then(() => {
            getUsers();
            closeModal();
            toast.fire({
                icon: 'success',
                title: 'Server update successfully',
            });
        });
    localStorage.removeItem('token', 'name');
    router.push('/');
}

const deleteUser = (userId) => {
    Swal.fire({
        title: 'Are you sure ?',
        text: "You can't go back",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085ds',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it',
    }).then((result) => {
        if (result.value) {
            axios.get('/api/delete/user/' + userId.id).then(() => {
                Swal.fire(
                    'Delete',
                    'user delete successfully',
                    'success'
                );
                getUsers();
            })
        }
    });
};

</script>

<template>
    <Base />
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <!--==================== USERS ====================-->
            <section class="users section" id="users">
                <div class="users_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Users </h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn__open--modal" @click="openModal">
                                New User
                            </div>
                        </div>
                    </div>

                    <div class="table">

                        <div class="table_filter">
                            <span class="table_filter-Btn ">
                                <i class="fas fa-ellipsis-h"></i>
                            </span>
                            <div>
                                <ul class="table_filter-list">
                                    <li>
                                        <p class="table_filter-link table_filter-link--active">
                                            All
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="table_search">
                            <div class="table_search-wrapper">
                                <select class="table_search-select" name="" id="">
                                    <option value="">Filter</option>
                                </select>
                            </div>
                            <div class="relative">
                                <i class="table_search-input--icon fas fa-search "></i>
                                <input class="table_search--input" type="text" placeholder="Search User">
                            </div>
                        </div>

                        <div class="user_table-heading">
                            <p>Photo</p>
                            <p>Name</p>
                            <p>Role</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="user_table-items" v-for="item in users" :key="item.id">
                            <p>
                                <img :src="ourImage(item.photo)" alt="" class="user_img-list">
                            </p>
                            <p>{{ item.name }}</p>

                            <p>{{ item.role.name }}</p>
                            <div>
                                <button class="btn-icon success" @click="editUser(item)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="deleteUser(item)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </section>
            <!-------------- USER MODAL --------------->
            <div class="modal main__modal" :class="{ show: showModal }">
                <div class="modal__content">
                    <span class="modal__close btn__close--modal" @click="closeModal">×</span>

                    <h3 class="modal__title" v-show="editMode == false">Add User</h3>
                    <h3 class="modal__title" v-show="editMode == true">Update User</h3>
                    <hr class="modal_line"><br>
                    <form @submit.prevent="editMode ? updateUser() : storeUser()">
                        <div>
                            <p>Name</p>
                            <input type="text" class="input" v-model="form.name" />
                            <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                            <p>Email</p>
                            <input type="email" class="input" v-model="form.email" />
                            <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>

                            <p>Bio</p>
                            <textarea cols="20" rows="3" class="textarea" v-model="form.bio"></textarea>
                            <span class="text-danger" v-if="errors.bio">{{ errors.bio[0] }}</span>

                            <p>Type</p>
                            <select class="inputSelect" name="" id="" v-model="form.role_id">
                                <option disabled selected>Select Role</option>
                                <option :value="role.id" v-for="role in roles" :key="role.id">
                                    {{ role.name }}
                                </option>
                            </select>
                            <span class="text-danger" v-if="errors.role_id">{{ errors.role_id[0] }}</span>

                            <p>Password</p>
                            <input type="password" id="password" class="input" v-model="form.password">
                            <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>

                            <p>Password Confirmed</p>
                            <input type="password" id="password" class="input" v-model="form.password_confirmation">
                            <span class="text-danger" v-if="errors.password">{{
                                    errors.password[0]
                            }}</span>

                        </div>
                        <br>
                        <hr class="modal_line">
                        <div class="model__footer">
                            <button class="btn mr-2 btn__close--modal" @click="closeModal">
                                Cancel
                            </button>
                            <button class="btn btn-secondary btn__close--modal" v-show="editMode == false">
                                Save
                            </button>
                            <button class="btn btn-secondary btn__close--modal" v-show="editMode == true"> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
</template>
