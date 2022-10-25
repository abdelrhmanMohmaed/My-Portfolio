<script setup>
import axios from "axios";
import { onMounted, ref, } from "vue";
import Base from '../layouts/base.vue';
import { useRouter } from "vue-router";

let projects = ref([]);
let router = useRouter();

onMounted(async () => {
    getProjects();
});

const getProjects = async () => {
    let response = await axios.get('/api/projects');
    projects.value = response.data.projects;
}

const deleteProject = (project) => {
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
            axios.get('/api/delete/projects/' + project.id).then(() => {
                Swal.fire(
                    'Delete',
                    'Project delete successfully',
                    'success'
                );
                getProjects();
            })
        }
    });
}

const editModal = (id) => {
    router.push('/admin/edit/project/' + id);
}

const ourImage = (img) => {
    return '/img/upload/' + img;
}

const createProject = () => {
    router.push('/admin/new/project');
};

</script>

<template>
    <Base />
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <!--==================== PROJECTS ====================-->
            <section class="projects section" id="projects">
                <div class="skills_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Projects </h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn__open--modal" @click="createProject()">
                                New Project
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
                                <input class="table_search--input" type="text" placeholder="Search Project">
                            </div>
                        </div>

                        <div class="project_table-heading">
                            <p>Image</p>
                            <p>Title</p>
                            <p>Description</p>
                            <p>Link</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="project_table-items" v-for="item in projects" :key="item.key">
                            <p>
                                <img :src="ourImage(item.photo)" alt="" class="project_img-list">
                            </p>
                            <p>{{ item.title }}</p>
                            <p>{{ item.description }}</p>
                            <a :href="item.link" target="_blank">{{ item.title }}</a>
                            <div>

                                <button class="btn-icon success" @click="editModal(item.id)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="deleteProject(item)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </section>
        </div>
    </main>
</template>
