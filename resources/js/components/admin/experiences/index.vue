<script setup>
import { onMounted, ref } from "vue";
import Base from '../layouts/base.vue';

let experiences = ref([]);
const showModal = ref(false);
const hideModal = ref(true);
const editMode = ref(false);
onMounted(async () => {
    getExperience();
});

let form = ref({
    company: "",
    period: "",
    position: "",
});

const openModel = () => {
    showModal.value = !showModal.value;
}

const closeModel = () => {
    showModal.value = !hideModal.value;
    form.value = ({});
    editMode.value = false;
}

const getExperience = async () => {
    let response = await axios.get('/api/experiences')
    experiences.value = response.data.experiences;

}

const createExperience = async () => {
    await axios.post('/api/store/experiences', form.value)
        .then(response => {
            getExperience();
            closeModel();
            toast.fire({
                icon: 'success',
                title: 'Education add successfully',
            });
        });
}

const editModal = (experience) => {
    editMode.value = true;
    showModal.value = !showModal.value;
    form.value = experience;
}

const UpdateModal = async () => {
    await axios.post('/api/update/experiences/' + form.value.id, form.value)
        .then(() => {
            getExperience();
            closeModel();
            toast.fire({
                icon: 'success',
                title: 'Experiences update successfully',
            });
        });
}

const deleteModal = (experienceId) => {
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
            axios.get('/api/delete/experiences/' + experienceId.id).then(() => {
                Swal.fire(
                    'Delete',
                    'Service delete successfully',
                    'success'
                );
                getExperience();
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
            <!--==================== EXPERIENCES ====================-->
            <section class="experiences section" id="experiences">
                <div class="skills_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Experiences </h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn__open--modal" @click="openModel()">
                                New Experience
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
                                <input class="table_search--input" type="text" placeholder="Search Experience">
                            </div>
                        </div>

                        <div class="experience_table-heading">
                            <p>Company</p>
                            <p>Period</p>
                            <p>Position</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="experience_table-items" v-for="item in experiences" :key="item.id">
                            <p>{{ item.company }}</p>
                            <p>{{ item.period }}</p>
                            <p>{{ item.position }}</p>
                            <div>
                                <button class="btn-icon success" @click="editModal(item)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="deleteModal(item)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
                <!-------------- EXPERIENCE MODAL --------------->
                <div class="modal main__modal" :class="{ show: showModal }">
                    <div class="modal__content">
                        <span class="modal__close btn__close--modal" @click="openModel()">×</span>
                        <h3 class="modal__title" v-show="editMode == false">Add Experience</h3>
                        <h3 class="modal__title" v-show="editMode == true">Edit Experience</h3>
                        <hr class="modal_line"><br>
                        <form @submit.prevent="editMode ? UpdateModal() : createExperience()">
                            <div>
                                <p>Company</p>
                                <input type="text" class="input" v-model="form.company" />

                                <p>Period</p>
                                <input type="text" class="input" v-model="form.period" />

                                <p>Position</p>
                                <input type="text" class="input" v-model="form.position" />

                            </div>
                            <br>
                            <hr class="modal_line">
                            <div class="model__footer">
                                <button class="btn mr-2 btn__close--modal" @click="closeModel()">
                                    Cancel
                                </button>
                                <button class="btn btn-secondary btn__close--modal"
                                    v-show="editMode == false">Save</button>
                                <button class="btn btn-secondary btn__close--modal"
                                    v-show="editMode == true">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>
