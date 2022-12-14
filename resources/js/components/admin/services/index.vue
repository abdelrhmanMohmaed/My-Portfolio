<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import Base from '../layouts/base.vue';


let services = ref([]);
const showModal = ref(false);
const hideModal = ref(true);
const editMode = ref(false);
let form = ref({
    name: "",
    icon: "",
    description: "",
});

onMounted(async () => {
    getServers();
});

const openModel = () => {
    showModal.value = !showModal.value;
}

const closeModel = () => {
    showModal.value = !hideModal.value;
    form.value = ({});
    editMode.value = false;
}

const getServers = async () => {
    let response = await axios.get('/api/services');
    services.value = response.data.services;
};

const createService = async () => {
    await axios.post('/api/store/services', form.value)
        .then(response => {
            getServers();
            closeModel();
            toast.fire({
                icon: 'success',
                title: 'Server add successfully',
            });
        });
}

const editModal = (service) => {
    editMode.value = true;
    showModal.value = !showModal.value;
    form.value = service;
}

const updateService = async () => {
    await axios.post('/api/update/services/' + form.value.id, form.value)
        .then(() => {
            getServers();
            closeModel();
            toast.fire({
                icon: 'success',
                title: 'Server update successfully',
            });
        });
}

const deleteService = (servicesId) => {
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
            axios.get('/api/delete/services/' + servicesId.id).then(() => {
                Swal.fire(
                    'Delete',
                    'Service delete successfully',
                    'success'
                );
                getServers();
            })
        }
    });
}

</script>

<template>
    <Base />
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="services section" id="services">
                <div class="services_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Services</h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn__open--modal" @click="openModel()">
                                New Service
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
                                <input class="table_search--input" type="text" placeholder="Search Service">
                            </div>
                        </div>

                        <div class="service_table-heading">
                            <p>Title</p>
                            <p>Icon</p>
                            <p>Description</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="service_table-items" v-for="item in services" :key="item.id">
                            <p>{{ item.name }}</p>
                            <button class="service_table-icon">
                                <i class="{{item.icon}}"></i>
                            </button>
                            <p>
                                {{ item.description }}
                            </p>
                            <div>
                                <button class="btn-icon success" @click="editModal(item)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="deleteService(item)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <!-------------- SERVICES MODAL --------------->
                <div class="modal main__modal " :class="{ show: showModal }">
                    <div class="modal__content">
                        <span class="modal__close btn__close--modal" @click="closeModel()">??</span>
                        <h3 class="modal__title" v-show="editMode == false">Add Service</h3>
                        <h3 class="modal__title" v-show="editMode == true">Update Service</h3>
                        <hr class="modal_line"><br>
                        <form @submit.prevent="editMode ? updateService() : createService()">
                            <div>
                                <p>Service Name</p>
                                <input type="text" class="input" v-model="form.name" />

                                <p>Icon Class</p>
                                <input type="text" class="input" v-model="form.icon" />
                                <span style="color:#006fbb;">Find your suitable icon: Font Awesome</span>

                                <p>Description</p>
                                <textarea cols="10" rows="5" v-model="form.description"></textarea>
                            </div>
                            <br>
                            <hr class="modal_line">
                            <div class="model__footer">
                                <button class="btn mr-2 btn__close--modal" @click="closeModel()">
                                    Cancel
                                </button>
                                <button class="btn btn-secondary" v-show="editMode == false">
                                    Save
                                </button>
                                <button class="btn btn-secondary" v-show="editMode == true">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>
